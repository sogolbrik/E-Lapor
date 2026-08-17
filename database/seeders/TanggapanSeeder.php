<?php

namespace Database\Seeders;

use App\Models\Aduan;
use App\Models\Tanggapan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TanggapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada sampel aduan & petugas
        $aduan = Aduan::first();
        $petugas = User::where('role', 'petugas')->first() ?? User::first();

        if ($aduan && $petugas) {
            // Tanggapan 1: Mengubah status dari Menunggu ke Diproses
            Tanggapan::create([
                'aduan_id' => $aduan->id,
                'user_id' => $petugas->id,
                'tanggapan' => 'Laporan telah diverifikasi oleh tim kecamatan dan dijadwalkan untuk peninjauan lapangan.',
                'status_sebelumnya' => 'Menunggu',
                'status_setelahnya' => 'Diproses',
            ]);

            // Tanggapan 2: Mengubah status dari Diproses ke Selesai
            Tanggapan::create([
                'aduan_id' => $aduan->id,
                'user_id' => $petugas->id,
                'tanggapan' => 'Pengerjaan pemeliharaan fasilitas publik telah selesai dilaksanakan.',
                'foto_bukti' => 'tanggapan/bukti_selesai_sample.jpg',
                'status_sebelumnya' => 'Diproses',
                'status_setelahnya' => 'Selesai',
            ]);

            // Update status aduan agar sinkron dengan tanggapan terakhir
            $aduan->update(['status' => 'Selesai']);
        }
    }
}
