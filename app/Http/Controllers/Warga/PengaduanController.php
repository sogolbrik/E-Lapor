<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use App\Models\Desa;
use App\Models\KategoriAduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function create()
    {
        return view("warga.create", [
            'kategoriAduan' => KategoriAduan::where('is_active', true)->get(),
            'desas' => Desa::all(),
        ]);
    }

    public function store(Request $request)
    {
        // Generate nomor tiket otomatis unik
        $request->merge([
            'tiket' => 'ADU-' . strtoupper(bin2hex(random_bytes(4))),
            'user_id' => Auth::id(),
            'status' => 'Menunggu',
            'is_anonymous' => $request->boolean('is_anonymous'),
        ]);

        $validate = $request->validate([
            'tiket' => 'required|string|unique:aduans,tiket',
            'user_id' => 'required|exists:users,id',
            'desa_id' => 'required|exists:desas,id',
            'kategori_id' => 'required|exists:kategori_aduans,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'detail_lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'required|boolean',
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
        ], [
            'desa_id.required' => 'Desa wajib dipilih',
            'desa_id.exists' => 'Desa yang dipilih tidak valid',
            'kategori_id.required' => 'Kategori aduan wajib dipilih',
            'kategori_id.exists' => 'Kategori aduan yang dipilih tidak valid',
            'judul.required' => 'Judul aduan wajib diisi',
            'deskripsi.required' => 'Deskripsi aduan wajib diisi',
            'latitude.required' => 'Latitude lokasi wajib diisi',
            'longitude.required' => 'Longitude lokasi wajib diisi',
            'detail_lokasi.required' => 'Detail lokasi wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus jpeg, png, jpg, atau gif',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('aduan-foto', 'public');
            $validate['foto'] = $fotoPath;
        }

        Aduan::create($validate);

        return redirect()->route('warga.dashboard')->with('success', 'Pengaduan berhasil dikirimkan');
    }

    public function show(string $id)
    {
        // Pastikan hanya pemilik aduan yang bisa melihat detailnya
        $aduan = Aduan::with(['kategoriAduan', 'desa', 'tanggapan.user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view("warga.show", compact('aduan'));
    }
}
