<?php

namespace Database\Seeders;

use App\Models\Desa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $desa = [
            'Gedangan',
            'Jiyu',
            'Kaligoro',
            'Karangasem',
            'Karangdiyeng',
            'Kepuharum',
            'Kepuhpandak',
            'Kertosari',
            'Kutorejo',
            'Payungrejo',
            'Pesanggrahan',
            'Sampangagung',
            'Sawo',
            'Simbaringin',
            'Singowangi',
            'Windurejo',
            'Wonodadi'
        ];

        foreach ($desa as $index => $name) {
            Desa::create([
                'nama' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
