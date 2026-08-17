<?php

namespace Database\Seeders;

use App\Models\Aduan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Aduan::create([
            'tiket' => 'ADU-' . strtoupper(bin2hex(random_bytes(4))),
            'user_id' => 3,
            'desa_id' => 7,
            'kategori_id' => 1,
            'judul' => 'Jalan Rusak di Wilayah Desa',
            'deskripsi' => 'Jalan utama yang menghubungkan pemukiman warga mengalami kerusakan parah dengan banyak lubang, membahayakan pengguna jalan dan mengganggu aktivitas sehari-hari warga.',
            'latitude' => -7.5333,
            'longitude' => 112.5167,
            'detail_lokasi' => 'Jalan Raya Utama, RT 03/RW 01',
            'foto' => 'contoh_foto_jalan_rusak.jpg',
            'is_anonymous' => false,
            'status' => 'Menunggu',
        ]);
    }
}
