<?php

namespace Database\Seeders;

use App\Models\KategoriAduan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriAduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriAduan = [
            [
                'nama' => 'Infrastruktur & Fasilitas Umum',
                'deskripsi' => 'Laporan terkait kerusakan jalan, jembatan, lampu jalan, saluran air, fasilitas olahraga, dan infrastruktur umum lainnya'
            ],
            [
                'nama' => 'Pelayanan Publik',
                'deskripsi' => 'Keluhan mengenai pelayanan kantor pemerintahan, kinerja PNS, perizinan, dan layanan administrasi masyarakat'
            ],
            [
                'nama' => 'Kebersihan & Lingkungan Hidup',
                'deskripsi' => 'Laporan tentang sampah menumpuk, pencemaran air/udara, pembakaran sampah liar, dan masalah lingkungan lainnya'
            ],
            [
                'nama' => 'Ketertiban & Ketenteraman Umum',
                'deskripsi' => 'Pengaduan tentang kebisingan, parkir liar, tawuran, tindakan kriminal, dan gangguan ketertiban lingkungan'
            ],
            [
                'nama' => 'Kesehatan & Sosial',
                'deskripsi' => 'Keluhan terkait layanan puskesmas/rumah sakit, stok obat, bantuan sosial, PMKS, dan masalah kesejahteraan masyarakat'
            ],
            [
                'nama' => 'Pendidikan',
                'deskripsi' => 'Laporan mengenai fasilitas sekolah, biaya pendidikan, kinerja guru, dan masalah dalam lingkungan pendidikan'
            ]
        ];

        foreach ($kategoriAduan as $item) {
            KategoriAduan::create([
                'nama' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'is_active' => true
            ]);
        }
    }
}
