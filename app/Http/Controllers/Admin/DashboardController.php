<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Statistik Utama (Cards)
        $totalAduan = Aduan::count();
        $sedangDiproses = Aduan::where('status', 'Diproses')->count();
        $pengaduanSelesai = Aduan::where('status', 'Selesai')->count();
        $totalPengguna = User::whereIn('role', ['Warga', 'Petugas'])->count();

        // Persentase Pengaduan Selesai dari Total
        $persenSelesai = $totalAduan > 0 ? round(($pengaduanSelesai / $totalAduan) * 100, 1) : 0;

        // 2. Data Grafik Bulanan
        $selectedYear = $request->input('year', date('Y'));

        // Mengambil rekap aduan per bulan berdasarkan tahun terpilih
        $monthlyDataRaw = Aduan::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Memetakan ke 12 bulan (1-12)
        $months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ];

        $chartData = [];
        $maxChartVal = 0;

        foreach ($months as $num => $name) {
            $val = $monthlyDataRaw[$num] ?? 0;
            if ($val > $maxChartVal) {
                $maxChartVal = $val;
            }
            $chartData[] = [
                'month' => $name,
                'val' => $val,
            ];
        }

        // Hitung tinggi grafik dalam persen (sebagai persentase terhadap nilai maksimum)
        foreach ($chartData as &$item) {
            $item['percentage'] = $maxChartVal > 0 ? round(($item['val'] / $maxChartVal) * 100) : 0;
        }
        unset($item);

        // Daftar pilihan tahun untuk filter chart (dari tahun tertua laporan hingga tahun ini)
        $years = Aduan::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (empty($years)) {
            $years = [date('Y')];
        }

        // 3. Ringkasan Status Pengaduan
        $statusCounts = Aduan::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $countSelesai = $statusCounts['Selesai'] ?? 0;
        $countDiproses = $statusCounts['Diproses'] ?? 0;
        $countMenunggu = $statusCounts['Menunggu'] ?? 0;
        $countDitolak  = $statusCounts['Ditolak'] ?? 0;

        $statusSummary = [
            'Selesai'  => ['count' => $countSelesai,  'percent' => $totalAduan > 0 ? round(($countSelesai / $totalAduan) * 100, 1) : 0],
            'Diproses' => ['count' => $countDiproses, 'percent' => $totalAduan > 0 ? round(($countDiproses / $totalAduan) * 100, 1) : 0],
            'Menunggu' => ['count' => $countMenunggu, 'percent' => $totalAduan > 0 ? round(($countMenunggu / $totalAduan) * 100, 1) : 0],
            'Ditolak'  => ['count' => $countDitolak,  'percent' => $totalAduan > 0 ? round(($countDitolak / $totalAduan) * 100, 1) : 0],
        ];

        // 4. Laporan Terbaru (5 Data Terakhir)
        $laporanTerbaru = Aduan::with(['user', 'desa', 'kategoriAduan'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalAduan',
            'sedangDiproses',
            'pengaduanSelesai',
            'totalPengguna',
            'persenSelesai',
            'chartData',
            'selectedYear',
            'years',
            'statusSummary',
            'laporanTerbaru'
        ));
    }
}
