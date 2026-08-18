<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use App\Models\Desa;
use App\Models\KategoriAduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Aduan::with(['user', 'desa', 'kategoriAduan'])->latest();

        // Pencarian (Tiket, Judul, Nama Pelapor)
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

        // Filter Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Wilayah (Desa)
        if ($request->filled('desa_id')) {
            $query->where('desa_id', $request->desa_id);
        }

        $aduan = $query->paginate(10)->withQueryString();

        // Data Statistik Singkat
        $totalAduan    = Aduan::count();
        $totalMenunggu = Aduan::where('status', 'Menunggu')->count();
        $totalDiproses = Aduan::where('status', 'Diproses')->count();
        $totalSelesai  = Aduan::where('status', 'Selesai')->count();

        // Master Data Filter
        $kategori = KategoriAduan::where('is_active', true)->get();
        $desa     = Desa::all();

        return view('admin.master_aduan.index', compact(
            'aduan',
            'totalAduan',
            'totalMenunggu',
            'totalDiproses',
            'totalSelesai',
            'kategori',
            'desa'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $aduan = Aduan::with([
            'user',
            'desa',
            'kategoriAduan',
            'tanggapan.user'
        ])->findOrFail($id);

        $kategori = KategoriAduan::where('is_active', true)->get();
        $desa     = Desa::all();

        return view('admin.master_aduan.show', compact('aduan', 'kategori', 'desa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $aduan = Aduan::findOrFail($id);
        $statusSebelumnya = $aduan->status;

        $validate = $request->validate([
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_aduans,id',
            'desa_id'     => 'required|exists:desas,id',
            'status'      => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'detail_lokasi' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
        ], [
            'judul.required' => 'Judul aduan wajib diisi',
            'judul.string' => 'Judul aduan harus berupa teks',
            'judul.max' => 'Judul aduan maksimal 255 karakter',
            'kategori_id.required' => 'Kategori aduan wajib dipilih',
            'kategori_id.exists' => 'Kategori aduan yang dipilih tidak valid',
            'desa_id.required' => 'Desa wajib dipilih',
            'desa_id.exists' => 'Desa yang dipilih tidak valid',
            'status.required' => 'Status aduan wajib dipilih',
            'status.in' => 'Status aduan yang dipilih tidak valid',
            'detail_lokasi.required' => 'Detail lokasi wajib diisi',
            'detail_lokasi.string' => 'Detail lokasi harus berupa teks',
            'detail_lokasi.max' => 'Detail lokasi maksimal 255 karakter',
            'deskripsi.required' => 'Deskripsi aduan wajib diisi',
            'deskripsi.string' => 'Deskripsi aduan harus berupa teks',
        ]);

        $aduan->update($validate);

        // Catat riwayat perubahan jika status berubah via edit form
        if ($statusSebelumnya !== $request->status) {
            Tanggapan::create([
                'aduan_id'          => $aduan->id,
                'user_id'           => Auth::id() ?? 1,
                'tanggapan'         => 'Status aduan diperbarui oleh Admin melalui pembaharuan data.',
                'status_sebelumnya' => $statusSebelumnya,
                'status_setelahnya' => $request->status,
            ]);
        }

        return redirect()->route('admin.aduan.show', $id)
            ->with('success', 'Data aduan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $aduan = Aduan::findOrFail($id);

        if ($aduan->foto && Storage::disk('public')->exists($aduan->foto)) {
            Storage::disk('public')->delete($aduan->foto);
        }

        $aduan->delete();

        return redirect()->route('admin.aduan.index')
            ->with('success', 'Data aduan berhasil dihapus.');
    }

    public function storeTanggapan(Request $request, string $id)
    {
        $aduan = Aduan::findOrFail($id);

        $validate = $request->validate([
            'tanggapan'  => 'required|string',
            'status'     => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'tanggapan.required' => 'Tanggapan wajib diisi',
            'tanggapan.string' => 'Tanggapan harus berupa teks',
            'status.required' => 'Status aduan wajib dipilih',
            'status.in' => 'Status aduan yang dipilih tidak valid',
            'foto_bukti.image' => 'File bukti harus berupa gambar',
            'foto_bukti.mimes' => 'Format gambar yang didukung adalah jpeg, png, jpg',
            'foto_bukti.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        DB::transaction(function () use ($validate, $aduan) {
            $statusSebelumnya = $aduan->status;
            $statusSetelahnya = $validate['status'];

            $fotoBuktiPath = null;
            if (request()->hasFile('foto_bukti')) {
                $fotoBuktiPath = request()->file('foto_bukti')->store('tanggapans', 'public');
            }

            // Simpan Tanggapan
            Tanggapan::create([
                'aduan_id'          => $aduan->id,
                'user_id'           => Auth::id() ?? 1,
                'tanggapan'         => $validate['tanggapan'],
                'foto_bukti'        => $fotoBuktiPath,
                'status_sebelumnya' => $statusSebelumnya,
                'status_setelahnya' => $statusSetelahnya,
            ]);

            // Update status aduan utama
            $aduan->update([
                'status' => $statusSetelahnya,
            ]);
        });

        return redirect()->route('admin.aduan.show', $id)
            ->with('success', 'Tanggapan dan pembaruan status berhasil disimpan.');
    }
}
