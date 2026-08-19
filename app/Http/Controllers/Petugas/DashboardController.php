<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Mengambil data desa milik petugas
        $namaDesa = $user->desa->nama ?? 'Semua Wilayah';
        $desaId = $user->desa_id;

        // Query dasar aduan yang difilter berdasarkan desa_id milik petugas (jika petugas terikat ke desa)
        $aduanQuery = Aduan::query();
        if ($desaId) {
            $aduanQuery->where('desa_id', $desaId);
        }

        // 1. Hitung Statistik Berdasarkan Wilayah
        $totalAduan = (clone $aduanQuery)->count();
        $menungguTindakan = (clone $aduanQuery)->where('status', 'Menunggu')->count();
        $sedangDiproses = (clone $aduanQuery)->where('status', 'Diproses')->count();
        $selesaiDitangani = (clone $aduanQuery)->where('status', 'Selesai')->count();

        // 2. Ambil Daftar Aduan Perlu Ditindaklanjuti (Status: Menunggu & Diproses)
        $aduanPerluTindakan = (clone $aduanQuery)
            ->with(['user', 'kategoriAduan'])
            ->whereIn('status', ['Menunggu', 'Diproses'])
            ->latest()
            ->get();

        return view('petugas.dashboard', compact(
            'namaDesa',
            'totalAduan',
            'menungguTindakan',
            'sedangDiproses',
            'selesaiDitangani',
            'aduanPerluTindakan'
        ));
    }
}
