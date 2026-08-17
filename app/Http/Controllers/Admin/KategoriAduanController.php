<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriAduan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KategoriAduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KategoriAduan::query();

        // Filter Pencarian (nama atau deskripsi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter Status Keaktifan
        if ($request->has('status') && $request->status !== null && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // Ambil data ter-paginate dengan relasi aduan_count jika ada
        $kategoriAduan = KategoriAduan::latest()->paginate(10);

        // Data Statistik
        $totalKategori = KategoriAduan::count();
        $kategoriAktif = KategoriAduan::where('is_active', true)->count();
        $kategoriNonaktif = KategoriAduan::where('is_active', false)->count();

        $kategoriBulanIni = KategoriAduan::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $persenAktif = $totalKategori > 0 ? round(($kategoriAktif / $totalKategori) * 100) : 0;
        $persenNonaktif = $totalKategori > 0 ? round(($kategoriNonaktif / $totalKategori) * 100) : 0;

        return view('admin.master_kategori.index', compact(
            'kategoriAduan',
            'totalKategori',
            'kategoriAktif',
            'kategoriNonaktif',
            'kategoriBulanIni',
            'persenAktif',
            'persenNonaktif',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.string' => 'Nama kategori harus berupa teks',
            'nama.max' => 'Nama kategori maksimal 255 karakter',
            'is_active.boolean' => 'Status aktif harus berupa nilai boolean',
        ]);

        KategoriAduan::create($validate);

        return redirect()->route('admin.kategori.aduan.index')->with('success', 'Kategori berhasil dibuat');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.string' => 'Nama kategori harus berupa teks',
            'nama.max' => 'Nama kategori maksimal 255 karakter',
            'is_active.boolean' => 'Status aktif harus berupa nilai boolean',
        ]);

        KategoriAduan::findOrFail($id)->update($validate);

        return redirect()->route('admin.kategori.aduan.index')->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Toggle / Update Status (Aktif / Nonaktif)
     */
    public function toggleStatus(string $id)
    {
        $kategori = KategoriAduan::findOrFail($id);
        $kategori->update([
            'is_active' => !$kategori->is_active
        ]);

        return redirect()->route('admin.kategori.aduan.index')->with('success', 'Status kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = KategoriAduan::findOrFail($id);

        // if ($kategori->aduan()->count() > 0) {
        //     return redirect()->route('admin.kategori.aduan.index')
        //         ->with('error', "Kategori '{$kategori->nama}' tidak dapat dihapus karena masih digunakan oleh beberapa pengaduan.");
        // }

        $kategori->delete();

        return redirect()->route('admin.kategori.aduan.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
