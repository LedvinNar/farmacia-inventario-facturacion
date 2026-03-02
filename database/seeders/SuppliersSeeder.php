<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suppliers')->insert([

            [
                'name' => 'Distribuidora Farmacéutica López',
                'phone' => '88881234',
                'email' => 'lopez.distribuidora@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Suministros Médicos Hernández',
                'phone' => '88882345',
                'email' => 'hernandez.med@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Distribuidora La Salud',
                'phone' => '88883456',
                'email' => 'lasalud.nic@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Farmacéutica Martínez',
                'phone' => '88884567',
                'email' => 'martinez.farma@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Comercial Médica Gómez',
                'phone' => '88885678',
                'email' => 'gomez.med@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Importadora San José',
                'phone' => '88886789',
                'email' => 'sanjose.import@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Distribuidora El Buen Precio',
                'phone' => '88887890',
                'email' => 'buenprecio@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Farmacia Central Distribución',
                'phone' => '88888901',
                'email' => 'central.dist@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Suministros Médicos Ruiz',
                'phone' => '88889012',
                'email' => 'ruiz.med@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Comercial Farmacéutica Torres',
                'phone' => '88890123',
                'email' => 'torres.farma@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // ---- otros 10 ----

            [
                'name' => 'Distribuidora Médica Díaz',
                'phone' => '88891234',
                'email' => 'diaz.med@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Farmacéutica Castillo',
                'phone' => '88892345',
                'email' => 'castillo.farma@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Importadora San Rafael',
                'phone' => '88893456',
                'email' => 'sanrafael.import@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Comercial Médica Sánchez',
                'phone' => '88894567',
                'email' => 'sanchez.med@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Distribuidora Farmacia Vida',
                'phone' => '88895678',
                'email' => 'farmaciavida@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Suministros Médicos Rivera',
                'phone' => '88896789',
                'email' => 'rivera.med@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Importadora San Miguel',
                'phone' => '88897890',
                'email' => 'sanmiguel.import@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Comercial Farmacéutica Pérez',
                'phone' => '88898901',
                'email' => 'perez.farma@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Distribuidora Médica Ramírez',
                'phone' => '88899012',
                'email' => 'ramirez.med@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Farmacéutica San Juan',
                'phone' => '88890145',
                'email' => 'sanjuan.farma@gmail.com',
                'address' => 'Cristo Rey',
                'created_at' => now(),
                'updated_at' => now()
            ],

        ]);
    }
}
