<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Analgésicos',
            'Antibióticos',
            'Antiinflamatorios',
            'Antialérgicos',
            'Vitaminas y Suplementos',
            'Jarabes',
            'Cremas y Pomadas',
            'Higiene Personal',
            'Cuidado del Bebé',
            'Dermatología',
            'Gastrointestinal',
            'Respiratorio',
            'Oftálmicos',
            'Otológicos',
            'Antigripales',
            'Antipiréticos',
            'Presión Arterial',
            'Diabetes',
            'Salud Sexual',
            'Primeros Auxilios',
        ];

        foreach ($categories as $name) {
            DB::table('categories')->insert([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
