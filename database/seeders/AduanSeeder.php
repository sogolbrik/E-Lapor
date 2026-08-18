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
        // First aduan
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

        // Second aduan - Kebersihan lingkungan
        Aduan::create([
            'tiket' => 'ADU-' . strtoupper(bin2hex(random_bytes(4))),
            'user_id' => 3,
            'desa_id' => 8,
            'kategori_id' => 3,
            'judul' => 'Sampah Menumpuk di Tempat Pembuangan Sementara',
            'deskripsi' => 'Tempat pembuangan sampah di dekat pasar desa sudah penuh dan tidak diangkut selama lebih dari seminggu, menyebabkan bau tidak sedap dan berpotensi menimbulkan penyakit.',
            'latitude' => -7.5412,
            'longitude' => 112.5234,
            'detail_lokasi' => 'Pasar Desa, RT 05/RW 02',
            'foto' => 'contoh_sampah_menumpuk.jpg',
            'is_anonymous' => true,
            'status' => 'Menunggu',
        ]);

        // Third aduan - Kesehatan masyarakat
        Aduan::create([
            'tiket' => 'ADU-' . strtoupper(bin2hex(random_bytes(4))),
            'user_id' => 3,
            'desa_id' => 9,
            'kategori_id' => 5,
            'judul' => 'Kekurangan Stok Obat di Puskesmas Desa',
            'deskripsi' => 'Warga yang berobat ke puskesmas tidak bisa mendapatkan obat-obatan dasar karena stok kosong, banyak warga harus membeli di apotek luar desa yang harganya lebih mahal.',
            'latitude' => -7.5567,
            'longitude' => 112.5089,
            'detail_lokasi' => 'Puskesmas Desa, RT 01/RW 01',
            'foto' => 'contoh_stok_obat_kosong.jpg',
            'is_anonymous' => false,
            'status' => 'Menunggu',
        ]);

        // Fourth aduan - Infrastruktur air bersih
        Aduan::create([
            'tiket' => 'ADU-' . strtoupper(bin2hex(random_bytes(4))),
            'user_id' => 3,
            'desa_id' => 10,
            'kategori_id' => 1,
            'judul' => 'Aliran Air PAM Tidak Lancar',
            'deskripsi' => 'Selama dua minggu terakhir, aliran air PAM ke rumah-rumah warga sangat kecil dan sering mati total di sore hari, menyulitkan warga untuk memenuhi kebutuhan air sehari-hari.',
            'latitude' => -7.5289,
            'longitude' => 112.5312,
            'detail_lokasi' => 'Perumahan Warga, RT 07/RW 03',
            'foto' => 'contoh_aliran_air_lambat.jpg',
            'is_anonymous' => false,
            'status' => 'Menunggu',
        ]);
    }
}
