<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // $aduan = Aduan::select('tiket', 'judul', 'deskripsi', '')->with('user', 'desa', 'kategoriAduan', 'tanggapan');
        // 1. Data Statistik (Menggunakan nama enum status dari migration: Menunggu, Diproses, Selesai, Ditolak)
        $total = Aduan::count();
        $diproses = Aduan::where('status', 'Diproses')->count();
        $selesai = Aduan::where('status', 'Selesai')->count();

        // Respon rate (< 24 jam dari dibuat hingga mendapat tanggapan pertama/perubahan status)
        $verifiedFast = Aduan::whereIn('status', ['Diproses', 'Selesai', 'Ditolak'])
            ->whereRaw('TIMESTAMPDIFF(HOUR, created_at, updated_at) <= 24')
            ->count();

        $responRate = $total > 0 ? round(($verifiedFast / $total) * 100) : null;

        $stats = [
            'total' => $total,
            'diproses' => $diproses,
            'selesai' => $selesai,
            'responRate' => $responRate,
        ];

        // Mapping Enum DB ke key status di Blade ('pending', 'processed', 'completed', 'rejected')
        $statusMap = [
            'Menunggu' => 'pending',
            'Diproses' => 'processed',
            'Selesai'  => 'completed',
            'Ditolak'  => 'rejected',
        ];

        // 2. Data Aduan Terbaru (Ambil 6 data publik terbaru beserta relasinya)
        $recentComplaints = Aduan::with(['kategoriAduan', 'desa', 'user', 'tanggapan'])
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($aduan) use ($statusMap) {
                // Ambil tanggapan terbaru jika ada
                $latestTanggapan = $aduan->tanggapan->last();

                return [
                    'code' => $aduan->tiket, // Sesuai field 'tiket' di database
                    'title' => $aduan->judul,
                    'description' => $aduan->deskripsi,
                    'category' => $aduan->kategoriAduan->nama ?? 'Umum',
                    'status' => $statusMap[$aduan->status] ?? 'pending',
                    'date' => $aduan->created_at ? $aduan->created_at->translatedFormat('d M Y') : '-',
                    'response' => $latestTanggapan->tanggapan ?? null,
                    'reporter' => $aduan->is_anonymous ? 'Anonim' : ($aduan->user->name ?? 'Warga'),
                    'village' => $aduan->desa->nama ?? 'Kecamatan',
                ];
            });

        // 3. Konfigurasi Lokasi & Nama Kecamatan (Bisa diatur via config/env)
        $kecamatanCenter = [
            'lat' => (float) config('app.kecamatan_lat', -7.4724),
            'lng' => (float) config('app.kecamatan_lng', 112.434),
        ];

        $kecamatanName = config('app.kecamatan_name', 'Kecamatan');

        // 4. Config Status Label untuk UI Blade
        $statusLabel = [
            'pending'   => ['label' => 'Menunggu Verifikasi', 'color' => '#F59E0B', 'bg' => '#F59E0B1a'],
            'processed' => ['label' => 'Diproses', 'color' => '#3B82F6', 'bg' => '#3B82F61a'],
            'rejected'  => ['label' => 'Ditolak', 'color' => '#EF4444', 'bg' => '#EF44441a'],
            'completed' => ['label' => 'Selesai', 'color' => '#22C55E', 'bg' => '#22C55E1a'],
        ];

        return view('welcome', compact(
            'stats',
            'recentComplaints',
            'kecamatanCenter',
            'kecamatanName',
            'statusLabel'
        ));
    }
}
