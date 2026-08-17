<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Hitung Statistik Pengaduan Warga
        $stats = [
            'pending'   => Aduan::where('user_id', $userId)->where('status', 'Menunggu')->count(),
            'processed' => Aduan::where('user_id', $userId)->where('status', 'Diproses')->count(),
            'completed' => Aduan::where('user_id', $userId)->where('status', 'Selesai')->count(),
            'rejected'  => Aduan::where('user_id', $userId)->where('status', 'Ditolak')->count(),
        ];

        // 2. Query Riwayat Pengaduan dengan Filter & Search
        $query = Aduan::with(['kategoriAduan', 'desa'])
            ->where('user_id', $userId);

        // Filter berdasarkan Status jika dipiliha
        if ($request->filled('status')) {
            $statusMap = [
                'pending'   => 'Menunggu',
                'processed' => 'Diproses',
                'completed' => 'Selesai',
                'rejected'  => 'Ditolak',
            ];

            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }

        // Filter berdasarkan Search (Nomor Tiket atau Judul)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tiket', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%");
            });
        }

        // Urutkan dari yang terbaru dan pagination
        $aduans = $query->latest()->paginate(10)->withQueryString();

        return view("warga.dashboard", compact('stats', 'aduans'));
    }
}
