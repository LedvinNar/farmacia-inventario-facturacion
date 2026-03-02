<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Backup & Restore — Farmacia Silva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root{
            --border:#e5e7eb;
            --muted:#6b7280;
            --bg:#f9fafb;
            --card:#ffffff;
            --ink:#111827;
            --accent:#111827;
            --danger:#b91c1c;
            --ok:#065f46;
        }
        *{ box-sizing:border-box; }
        body{ font-family: Arial, Helvetica, sans-serif; margin:24px; color:var(--ink); background:var(--bg); }
        .wrap{ max-width: 1100px; margin:0 auto; }

        .top{ display:flex; justify-content:space-between; gap:16px; align-items:flex-start; flex-wrap:wrap; }
        .card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:14px;
            padding:14px;
            box-shadow:0 1px 2px rgba(0,0,0,.04);
        }
        .brand h1{ margin:0; font-size:22px; letter-spacing:.2px; }
        .muted{ color:var(--muted); font-size:12px; line-height:1.45; }
        .title{ font-weight:900; font-size:13px; margin-bottom:10px; }

        .grid{ display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-top:12px; }
        @media (max-width: 980px){ .grid{ grid-template-columns: 1fr; } }

        .actions{ margin-top:12px; display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
        .btn{
            border:1px solid var(--border);
            background:var(--accent);
            color:#fff;
            padding:10px 12px;
            border-radius:12px;
            cursor:pointer;
            text-decoration:none;
            display:inline-block;
            font-size:13px;
            line-height:1;
            white-space:nowrap;
        }
        .btn.secondary{ background:#fff; color:var(--accent); }
        .btn.danger{ background:var(--danger); border-color: rgba(185,28,28,.25); }
        .btn.ok{ background: var(--ok); border-color: rgba(6,95,70,.25); }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:12px;
            background:var(--card);
            border:1px solid var(--border);
            border-radius:14px;
            overflow:hidden;
        }
        thead th{
            padding:10px 12px;
            font-size:12px;
            color:var(--muted);
            text-transform:uppercase;
            letter-spacing:.04em;
            background:#f3f4f6;
            border-bottom:1px solid var(--border);
            text-align:left;
        }
        tbody td{
            padding:10px 12px;
            border-bottom:1px solid var(--border);
            font-size:13px;
            vertical-align:middle;
        }
        tbody tr:last-child td{ border-bottom:none; }
        .right{ text-align:right; }

        input[type="file"]{
            width:100%;
            padding:10px;
            border:1px solid var(--border);
            border-radius:12px;
            background:#fff;
        }

        .alert{
            border:1px solid var(--border);
            background:#fff;
            border-radius:14px;
            padding:12px 14px;
            margin-top:12px;
            font-size:13px;
        }
        .alert.ok{ border-color: rgba(6,95,70,.35); background: rgba(6,95,70,.06); }
        .alert.bad{ border-color: rgba(185,28,28,.35); background: rgba(185,28,28,.06); }
        .alert b{ font-weight:900; }

        .badge{
            display:inline-block;
            padding:3px 10px;
            border-radius:999px;
            border:1px solid var(--border);
            font-size:12px;
            background:#fff;
            color:var(--ink);
            white-space:nowrap;
        }

        .footer{ margin-top:14px; font-size:12px; color:var(--muted); }
        .hint{ font-size:12px; color:var(--muted); margin-top:8px; }
        .mono{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }

        @media print{
            body{ margin:0; background:#fff; }
            .actions, .no-print{ display:none !important; }
            .card, table{ box-shadow:none; }
            .wrap{ max-width:100%; }
        }
    </style>
</head>
<body>
<div class="wrap">

    <div class="top">
        <div class="card" style="flex: 1; min-width: 320px;">
            <div class="brand">
                <h1>Backup & Restore</h1>
                <div class="muted" style="margin-top:6px;">
                    Módulo PRO para respaldar y restaurar la base de datos del sistema.<br>
                    Recomendación: realizá backup antes de cualquier cambio importante.
                </div>
            </div>

            <div class="actions no-print">
                <form method="POST" action="{{ route('backup.create') }}">
                    @csrf
                    <button class="btn ok" type="submit">Crear Backup</button>
                </form>

                <button class="btn secondary" type="button" onclick="window.print()">Imprimir</button>
                <a class="btn secondary" href="javascript:history.back()">Volver</a>

                <span class="badge">Entorno: <span class="mono">{{ app()->environment() }}</span></span>
            </div>
        </div>

        <div class="card" style="min-width: 320px;">
            <div class="title">Restaurar Backup</div>

            <form class="no-print" method="POST" action="{{ route('backup.restore') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="sql" accept=".sql,.txt" required>
                <div class="actions" style="margin-top:10px;">
                    <button class="btn danger" type="submit"
                            onclick="return confirm('¿Seguro que querés restaurar? Esto reemplazará los datos actuales.')">
                        Restaurar
                    </button>
                </div>
                <div class="hint">
                    Subí un archivo <b>.sql</b> generado por el sistema (o compatible). Tamaño máx: 50MB (según controlador).
                </div>
            </form>
        </div>
    </div>

    @php
        $success = session('success');
        $errorMsg = session('error');

        $toText = function($v){
            if (is_array($v)) return json_encode($v, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            if (is_object($v)) return method_exists($v, '__toString') ? (string)$v : json_encode($v, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            return (string)$v;
        };

        // Normaliza $files para que SIEMPRE sea lista de items con:
        // - display (lo que se ve)
        // - file (lo que se manda al controlador)
        $normalized = [];
        foreach (($files ?? []) as $item) {
            if (is_string($item)) {
                $normalized[] = ['display' => $item, 'file' => $item];
                continue;
            }
            if (is_array($item)) {
                $display = $item['name'] ?? $item['file'] ?? $item['path'] ?? json_encode($item, JSON_UNESCAPED_UNICODE);
                $fileVal = $item['path'] ?? $item['name'] ?? '';
                $normalized[] = ['display' => $display, 'file' => $fileVal];
                continue;
            }
            if (is_object($item)) {
                $arr = (array)$item;
                $display = $arr['name'] ?? $arr['file'] ?? $arr['path'] ?? json_encode($arr, JSON_UNESCAPED_UNICODE);
                $fileVal = $arr['path'] ?? $arr['name'] ?? '';
                $normalized[] = ['display' => $display, 'file' => $fileVal];
                continue;
            }
            $normalized[] = ['display' => (string)$item, 'file' => (string)$item];
        }
    @endphp

    @if($success)
        <div class="alert ok"><b>✅ Éxito:</b> {{ $toText($success) }}</div>
    @endif

    @if($errorMsg)
        <div class="alert bad"><b>⚠️ Error:</b> {{ $toText($errorMsg) }}</div>
    @endif

    @if($errors->any())
        <div class="alert bad">
            <b>⚠️ Validación:</b>
            <ul style="margin:8px 0 0 18px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid">
        <div class="card">
            <div class="title">Backups existentes</div>
            <div class="muted">Descargá o eliminá respaldos guardados en el servidor.</div>

            <table>
                <thead>
                <tr>
                    <th>Archivo</th>
                    <th class="right">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($normalized as $row)
                    <tr>
                        <td class="mono">{{ $row['display'] }}</td>
                        <td class="right no-print">
                            <a class="btn secondary" href="{{ route('backup.download', ['file' => $row['file']]) }}">
                                Descargar
                            </a>

                            <form method="POST" action="{{ route('backup.delete') }}" style="display:inline-block; margin-left:6px;">
                                @csrf
                                <input type="hidden" name="file" value="{{ $row['file'] }}">
                                <button class="btn danger" type="submit" onclick="return confirm('¿Eliminar este backup?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="muted">No hay backups todavía. Presioná “Crear Backup”.</td></tr>
                @endforelse
                </tbody>
            </table>

            <div class="hint">
                Tip: Si querés, podés guardar backups dentro de <span class="mono">storage/app/backups</span>.
            </div>
        </div>

        <div class="card">
            <div class="title">Recomendaciones PRO</div>
            <ul style="margin: 8px 0 0 18px; color: var(--muted); line-height:1.6;">
                <li>Hacé backup antes de actualizar dependencias o migraciones.</li>
                <li>No restaurés backups de otro sistema distinto (puede fallar por tablas diferentes).</li>
                <li>Si usás MySQL, asegurate que el controlador esté configurado para MySQL.</li>
                <li>Mantené al menos 3 copias: último, semanal y mensual.</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        Documento generado por el Sistema de Inventario y Facturación — Farmacia Silva.
    </div>

</div>
</body>
</html>
