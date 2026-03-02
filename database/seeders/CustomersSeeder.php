<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    public function run(): void
    {
       // Me da error DB::table('customers')->truncate();

        $customers = [
            ['name' => 'Juan Pérez', 'phone' => '88881234', 'email' => 'juan.perez@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'María López', 'phone' => '88882345', 'email' => 'maria.lopez@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Carlos Rodríguez', 'phone' => '88883456', 'email' => 'carlos.rodriguez@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Ana Martínez', 'phone' => '88884567', 'email' => 'ana.martinez@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Luis González', 'phone' => '88885678', 'email' => 'luis.gonzalez@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Sofía Hernández', 'phone' => '88886789', 'email' => 'sofia.hernandez@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Miguel Castillo', 'phone' => '88887890', 'email' => 'miguel.castillo@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Daniela Ruiz', 'phone' => '88888901', 'email' => 'daniela.ruiz@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'José Morales', 'phone' => '88889012', 'email' => 'jose.morales@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Karla Sánchez', 'phone' => '88890123', 'email' => 'karla.sanchez@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],

            ['name' => 'Ricardo Flores', 'phone' => '88891234', 'email' => 'ricardo.flores@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Paola Rivera', 'phone' => '88892345', 'email' => 'paola.rivera@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Fernando Reyes', 'phone' => '88893456', 'email' => 'fernando.reyes@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Valeria Gómez', 'phone' => '88894567', 'email' => 'valeria.gomez@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Kevin Aguilar', 'phone' => '88895678', 'email' => 'kevin.aguilar@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Andrea Navarro', 'phone' => '88896789', 'email' => 'andrea.navarro@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Javier Ortega', 'phone' => '88897890', 'email' => 'javier.ortega@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Camila Torres', 'phone' => '88898901', 'email' => 'camila.torres@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Erick Mendoza', 'phone' => '88899012', 'email' => 'erick.mendoza@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
            ['name' => 'Melissa Vargas', 'phone' => '88900123', 'email' => 'melissa.vargas@gmail.com', 'address' => 'Cristo Rey', 'is_active' => 1],
        ];

        DB::table('customers')->insert($customers);
    }
}
