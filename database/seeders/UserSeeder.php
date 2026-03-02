<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar que exista la tabla users
        if (!Schema::hasTable('users')) {
            $this->command?->warn("La tabla 'users' no existe. Ejecuta migraciones primero.");
            return;
        }

        $hasRoleColumn = Schema::hasColumn('users', 'role');

        $users = [
            [
                'name'     => 'Administrador',
                'email'    => 'admin@silva.com',
                'password' => Hash::make('Admin12345*'),
                'role'     => 'Admin',
            ],
            [
                'name'     => 'Vendedor',
                'email'    => 'vendedor@silva.com',
                'password' => Hash::make('Vendedor12345*'),
                'role'     => 'Vendedor',
            ],
            [
                'name'     => 'Consulta',
                'email'    => 'consulta@silva.com',
                'password' => Hash::make('Consulta12345*'),
                'role'     => 'Consulta',
            ],
        ];

        foreach ($users as $user) {
            $data = [
                'name'       => $user['name'],
                'email'      => $user['email'],
                'password'   => $user['password'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Solo agrega role si existe la columna
            if ($hasRoleColumn) {
                $data['role'] = $user['role'];
            }

            // Inserta si no existe por email, si existe lo actualiza
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                $data
            );
        }

        $this->command?->info("✅ UserSeeder ejecutado: Admin, Vendedor y Consulta creados/actualizados.");
    }
}
