<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
    public function index()
    {
        $this->ensureBackupDir();

        $disk = Storage::disk('local');
        $dir  = 'backups';

        // Lista de archivos (como arrays: path, name, size, time)
        $files = collect($disk->files($dir))
            ->filter(fn ($f) => Str::endsWith(strtolower($f), '.sql'))
            ->map(function ($path) use ($disk) {
                return [
                    'path' => $path,              // backups/xxx.sql
                    'name' => basename($path),    // xxx.sql
                    'size' => $disk->size($path),
                    'time' => $disk->lastModified($path),
                ];
            })
            ->sortByDesc('time')
            ->values();

        return view('backup.index', compact('files'));
    }

    /**
     * POST /backup/create
     */
    public function create()
    {
        $this->ensureBackupDir();

        if (config('database.default') !== 'mysql') {
            return back()->with('error', 'Este módulo está preparado para MySQL. Tu conexión actual es: ' . config('database.default'));
        }

        $cfg = config('database.connections.mysql');
        $dbName = $cfg['database'] ?? '';
        $dbUser = $cfg['username'] ?? '';
        $dbPass = $cfg['password'] ?? '';
        $dbHost = $cfg['host'] ?? '127.0.0.1';
        $dbPort = (string)($cfg['port'] ?? '3306');

        if (!$dbName || !$dbUser) {
            return back()->with('error', 'Faltan credenciales en .env (DB_DATABASE / DB_USERNAME).');
        }

        $stamp   = now()->format('Y_m_d_His');
        $relPath = "backups/backup_{$dbName}_{$stamp}.sql";

        // Ruta REAL del disco local (evita errores en Windows)
        $fullPath = Storage::disk('local')->path($relPath);

        // 1) Intentar mysqldump
        $try = $this->tryDumpWithMysqldump($fullPath, $dbHost, $dbPort, $dbUser, $dbPass, $dbName);

        if ($try['ok']) {
            return back()->with('success', '✅ Backup creado con mysqldump: ' . basename($relPath));
        }

        // 2) Fallback: dump por Laravel
        $fallback = $this->dumpUsingLaravel($fullPath, $dbName);

        if (!$fallback['ok']) {
            $msg = "No se pudo crear el backup.\n\n"
                 . "Intento mysqldump falló:\n" . $try['error'] . "\n\n"
                 . "Fallback Laravel falló:\n" . $fallback['error'];
            return back()->with('error', $msg);
        }

        return back()->with('success', '✅ Backup creado (modo Laravel, sin mysqldump): ' . basename($relPath));
    }

    /**
     * GET /backup/download?file=backups/xxx.sql
     */
    public function download(Request $request)
    {
        $request->validate([
            'file' => ['required', 'string', 'max:255'],
        ]);

        $file = (string) $request->query('file');

        if (!Str::startsWith($file, 'backups/') || !Str::endsWith(strtolower($file), '.sql')) {
            abort(403, 'Archivo no permitido.');
        }

        if (!Storage::disk('local')->exists($file)) {
            abort(404, 'Backup no encontrado.');
        }

        $fullPath = Storage::disk('local')->path($file);

        return response()->download(
            $fullPath,
            basename($file),
            ['Content-Type' => 'application/sql']
        );
    }

    /**
     * POST /backup/restore
     */
    public function restore(Request $request)
    {
        $request->validate([
            'sql' => ['required', 'file', 'mimes:sql,txt', 'max:51200'], // 50MB
        ]);

        if (config('database.default') !== 'mysql') {
            return back()->with('error', 'Este módulo está preparado para MySQL. Tu conexión actual es: ' . config('database.default'));
        }

        $cfg = config('database.connections.mysql');
        $dbName = $cfg['database'] ?? '';
        $dbUser = $cfg['username'] ?? '';
        $dbPass = $cfg['password'] ?? '';
        $dbHost = $cfg['host'] ?? '127.0.0.1';
        $dbPort = (string)($cfg['port'] ?? '3306');

        if (!$dbName || !$dbUser) {
            return back()->with('error', 'Faltan credenciales en .env (DB_DATABASE / DB_USERNAME).');
        }

        $this->ensureBackupDir();

        // Guardar el archivo subido y obtener el path REAL
        $stamp = now()->format('Y_m_d_His');
        $name  = "restore_upload_{$stamp}_" . Str::random(6) . ".sql";

        $storedPath = Storage::disk('local')->putFileAs('backups', $request->file('sql'), $name);
        // $storedPath será: backups/restore_upload_xxx.sql
        $fullPath = Storage::disk('local')->path($storedPath);

        // 1) Intentar restaurar con mysql.exe
        $try = $this->tryRestoreWithMysqlClient($fullPath, $dbHost, $dbPort, $dbUser, $dbPass, $dbName);

        if ($try['ok']) {
            return back()->with('success', '✅ Restauración completada (mysql client): ' . basename($storedPath));
        }

        // 2) Fallback: Laravel
        $fallback = $this->restoreUsingLaravel($fullPath);

        if (!$fallback['ok']) {
            $msg = "No se pudo restaurar.\n\n"
                 . "Intento mysql client falló:\n" . $try['error'] . "\n\n"
                 . "Fallback Laravel falló:\n" . $fallback['error'];
            return back()->with('error', $msg);
        }

        return back()->with('success', '✅ Restauración completada (modo Laravel): ' . basename($storedPath));
    }

    /**
     * POST /backup/delete
     */
    public function delete(Request $request)
    {
        $request->validate([
            'file' => ['required', 'string', 'max:255'],
        ]);

        $file = (string) $request->input('file');

        if (!Str::startsWith($file, 'backups/') || !Str::endsWith(strtolower($file), '.sql')) {
            abort(403, 'Archivo no permitido.');
        }

        if (Storage::disk('local')->exists($file)) {
            Storage::disk('local')->delete($file);
        }

        return back()->with('success', '🗑️ Backup eliminado.');
    }

    // =========================
    // Helpers
    // =========================

    private function ensureBackupDir(): void
    {
        $disk = Storage::disk('local');
        if (!$disk->exists('backups')) {
            $disk->makeDirectory('backups');
        }
    }

    private function tryDumpWithMysqldump(string $fullPath, string $host, string $port, string $user, string $pass, string $db): array
    {
        try {
            $dumpExe = env('MYSQLDUMP_PATH', $this->guessXamppBinary('mysqldump.exe')) ?: 'mysqldump';

            $args = [
                $dumpExe,
                '--protocol=tcp',
                "--host={$host}",
                "--port={$port}",
                "--user={$user}",
                '--single-transaction',
                '--routines',
                '--triggers',
                '--add-drop-table',
                '--default-character-set=utf8mb4',
                "--result-file={$fullPath}",
                $db,
            ];

            $process = new Process($args, base_path(), [
                'MYSQL_PWD' => (string)$pass,
            ]);

            $process->setTimeout(180);
            $process->run();

            if (!$process->isSuccessful()) {
                return ['ok' => false, 'error' => trim($process->getErrorOutput()) ?: 'mysqldump falló sin mensaje'];
            }

            if (!file_exists($fullPath) || filesize($fullPath) < 50) {
                return ['ok' => false, 'error' => 'mysqldump terminó pero el archivo quedó vacío/no se generó.'];
            }

            return ['ok' => true, 'error' => ''];
        } catch (\Throwable $e) {
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    private function tryRestoreWithMysqlClient(string $sqlFile, string $host, string $port, string $user, string $pass, string $db): array
    {
        try {
            $mysqlExe = env('MYSQL_PATH', $this->guessXamppBinary('mysql.exe')) ?: 'mysql';

            if (PHP_OS_FAMILY === 'Windows') {
                $cmd = '"' . $mysqlExe . '"'
                    . ' --protocol=tcp'
                    . ' --host=' . $host
                    . ' --port=' . $port
                    . ' --user=' . $user
                    . ' ' . $db
                    . ' < "' . $sqlFile . '"';

                $process = new Process(['cmd', '/C', $cmd], base_path(), [
                    'MYSQL_PWD' => (string)$pass,
                ]);
            } else {
                $cmd = $mysqlExe
                    . ' --protocol=tcp'
                    . ' --host=' . escapeshellarg($host)
                    . ' --port=' . escapeshellarg($port)
                    . ' --user=' . escapeshellarg($user)
                    . ' ' . escapeshellarg($db)
                    . ' < ' . escapeshellarg($sqlFile);

                $process = Process::fromShellCommandline($cmd, base_path(), [
                    'MYSQL_PWD' => (string)$pass,
                ]);
            }

            $process->setTimeout(300);
            $process->run();

            if (!$process->isSuccessful()) {
                return ['ok' => false, 'error' => trim($process->getErrorOutput()) ?: 'mysql client falló sin mensaje'];
            }

            return ['ok' => true, 'error' => ''];
        } catch (\Throwable $e) {
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    private function dumpUsingLaravel(string $fullPath, string $dbName): array
    {
        try {
            $pdo = DB::connection()->getPdo();

            $fh = fopen($fullPath, 'wb');
            if (!$fh) {
                return ['ok' => false, 'error' => 'No se pudo crear el archivo de backup en: ' . $fullPath];
            }

            $write = fn (string $s) => fwrite($fh, $s);

            $write("-- Backup generado por Laravel (Farmacia)\n");
            $write("-- Fecha: " . now()->toDateTimeString() . "\n");
            $write("SET FOREIGN_KEY_CHECKS=0;\n");
            $write("SET NAMES utf8mb4;\n\n");

            $tables = DB::select('SHOW TABLES');
            $key = 'Tables_in_' . $dbName;

            foreach ($tables as $row) {
                $table = $row->$key ?? array_values((array)$row)[0] ?? null;
                if (!$table) continue;

                $write("\n-- ----------------------------\n");
                $write("-- Tabla: {$table}\n");
                $write("-- ----------------------------\n\n");

                $create = DB::select("SHOW CREATE TABLE `{$table}`");
                $createSql = $create[0]->{'Create Table'} ?? null;

                if ($createSql) {
                    $write("DROP TABLE IF EXISTS `{$table}`;\n");
                    $write($createSql . ";\n\n");
                }

                $rows = DB::table($table)->get();
                if ($rows->isEmpty()) continue;

                $columns = array_keys((array)$rows->first());
                $colList = '`' . implode('`,`', $columns) . '`';

                $chunkSize = 300;
                $buffer = [];

                foreach ($rows as $r) {
                    $vals = [];
                    foreach ($columns as $c) {
                        $v = $r->$c;
                        if ($v === null) $vals[] = 'NULL';
                        else $vals[] = $pdo->quote((string)$v);
                    }

                    $buffer[] = '(' . implode(',', $vals) . ')';

                    if (count($buffer) >= $chunkSize) {
                        $write("INSERT INTO `{$table}` ({$colList}) VALUES \n" . implode(",\n", $buffer) . ";\n");
                        $buffer = [];
                    }
                }

                if (!empty($buffer)) {
                    $write("INSERT INTO `{$table}` ({$colList}) VALUES \n" . implode(",\n", $buffer) . ";\n");
                }
            }

            $write("\nSET FOREIGN_KEY_CHECKS=1;\n");
            fclose($fh);

            if (!file_exists($fullPath) || filesize($fullPath) < 50) {
                return ['ok' => false, 'error' => 'Backup Laravel generado pero quedó vacío.'];
            }

            return ['ok' => true, 'error' => ''];
        } catch (\Throwable $e) {
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    private function restoreUsingLaravel(string $sqlFile): array
    {
        try {
            if (!file_exists($sqlFile)) {
                return ['ok' => false, 'error' => 'No existe el archivo: ' . $sqlFile];
            }

            $sql = file_get_contents($sqlFile);
            if ($sql === false || trim($sql) === '') {
                return ['ok' => false, 'error' => 'El archivo SQL está vacío o no se pudo leer.'];
            }

            DB::unprepared($sql);

            return ['ok' => true, 'error' => ''];
        } catch (\Throwable $e) {
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    private function guessXamppBinary(string $exe): ?string
    {
        $p = 'C:\\xampp\\mysql\\bin\\' . $exe;
        return file_exists($p) ? $p : null;
    }
}
