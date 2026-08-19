<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AduanController extends Controller
{
    /**
     * Menampilkan daftar aduan berdasarkan desa tempat petugas bertugas & filter status.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Mengambil aduan yang lokasinya sesuai dengan desa tempat petugas bertugas
        $query = Aduan::with(['user', 'kategoriAduan', 'desa'])
            ->where('desa_id', $user->desa_id);

        // Filterberdasarkan Status
        if ($request->filled('status') && in_array($request->status, ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])) {
            $query->where('status', $request->status);
        }

        // Pencarian (Tiket, Judul, Pelapor)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tiket', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $aduans = $query->latest()->paginate(10)->withQueryString();

        return view('petugas.aduan.index', compact('aduans'));
    }

    /**
     * Detail Aduan & Riwayat Tanggapan
     */
    public function show(string $id)
    {
        // 1. Cari data aduan berdasarkan ID yang diterima dari parameter route
        $aduan = Aduan::with(['user', 'kategoriAduan', 'desa', 'tanggapan.user'])->findOrFail($id);

        // 2. Keamanan: Pastikan aduan berada di desa tempat petugas bertugas
        if ($aduan->desa_id !== Auth::user()->desa_id) {
            abort(403, 'Anda tidak memiliki akses ke aduan wilayah ini.');
        }

        return view('petugas.aduan.show', compact('aduan'));
    }
    /**
     * Menyimpan Tanggapan, Upload Bukti, dan Memperbarui Status Aduan
     */
    public function storeTanggapan(Request $request, string $id)
    {
        // Keamanan akses
        $aduan = Aduan::findOrFail($id);
        if ($aduan->desa_id !== Auth::user()->desa_id) {
            abort(403, 'Anda tidak memiliki akses ke aduan wilayah ini.');
        }

        $validate = $request->validate([
            'tanggapan'  => 'required|string',
            'status'     => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'tanggapan.required' => 'Tanggapan wajib diisi',
            'tanggapan.string' => 'Tanggapan harus berupa teks',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status yang dipilih tidak valid',
            'foto_bukti.image' => 'File bukti harus berupa gambar',
            'foto_bukti.mimes' => 'File bukti harus berformat jpg, jpeg, atau png',
            'foto_bukti.max' => 'Ukuran file bukti maksimal 2MB',
        ]);

        $statusSebelumnya = $aduan->status;
        $statusSetelahnya  = $validate['status'];

        // Handle Upload Foto Bukti Pengerjaan
        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('tanggapan-bukti', 'public');
        }

        // 1. Simpan Data Tanggapan
        Tanggapan::create([
            'aduan_id'          => $aduan->id,
            'user_id'           => Auth::id(),
            'tanggapan'         => $validate['tanggapan'],
            'foto_bukti'        => $fotoPath,
            'status_sebelumnya' => $statusSebelumnya,
            'status_setelahnya' => $statusSetelahnya,
        ]);

        // 2. Update Status pada Tabel Aduan
        $aduan->update([
            'status' => $statusSetelahnya,
        ]);

        return redirect()->back()->with('success', 'Tanggapan dan pembaruan status aduan berhasil disimpan.');
    }
}
