<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Bayer',
            'Pfizer',
            'Roche',
            'Novartis',
            'Sanofi',
            'Abbott',
            'GlaxoSmithKline',
            'AstraZeneca',
            'Johnson & Johnson',
            'Merck',
            'Teva',
            'Amgen',
            'Eli Lilly',
            'Takeda',
            'Boehringer Ingelheim',
            'Bristol Myers',
            'Gedeon Richter',
            'Almirall',
            'Sandoz',
            'Mylan',
        ];

        foreach ($brands as $name) {
            DB::table('brands')->insert([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
