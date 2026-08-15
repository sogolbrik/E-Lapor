<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Data Widget Statistik
        $totalUser = User::count();
        $userBulanIni = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $akunAktif = User::where('is_active', true)->count();
        $akunNonaktif = User::where('is_active', false)->count();

        $persenAktif = $totalUser > 0 ? number_format(($akunAktif / $totalUser) * 100, 1) : 0;
        $persenNonaktif = $totalUser > 0 ? number_format(($akunNonaktif / $totalUser) * 100, 1) : 0;
        $totalDesa = Desa::count();

        // 2. Query Data Table dengan Filter & Search
        $user = User::with('desa')
            // Filter Pencarian (NIK, Nama, No. HP, Email)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nik', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            // Filter Desa
            ->when($request->filled('desa_id'), function ($query) use ($request) {
                $query->where('desa_id', $request->desa_id);
            })
            // Filter Status Akun (1 = Aktif, 0 = Nonaktif)
            ->when($request->has('status') && $request->status !== null && $request->status !== '', function ($query) use ($request) {
                $query->where('is_active', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Menjaga parameter filter saat klik pagination

        // 3. Render View
        return view('admin.master_user.index', [
            'user'         => $user,
            'desa'          => Desa::get(),
            'totalUser'     => $totalUser,
            'userBulanIni'  => $userBulanIni,
            'akunAktif'     => $akunAktif,
            'akunNonaktif'  => $akunNonaktif,
            'persenAktif'   => $persenAktif,
            'persenNonaktif' => $persenNonaktif,
            'totalDesa'     => $totalDesa
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('admin.master_warga.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nik' => 'required|string|size:16|unique:users,nik',
            'desa_id' => 'nullable|exists:desas,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'role' => 'required|in:Admin,Petugas,Warga',
            'no_hp' => 'nullable|string',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus terdiri dari 16 karakter',
            'nik.unique' => 'NIK sudah terdaftar pada akun lain',
            'desa_id.exists' => 'Desa yang dipilih tidak valid',
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Alamat email wajib diisi',
            'email.email' => 'Format alamat email tidak valid',
            'email.unique' => 'Alamat email sudah terdaftar pada akun lain',
            'password.required' => 'Kata sandi wajib diisi',
            'role.required' => 'Role pengguna wajib dipilih',
            'role.in' => 'Role yang dipilih tidak valid',
            'no_hp.string' => 'Format nomor handphone tidak valid'
        ]);

        $validate['password'] = Hash::make($validate['password']);

        User::create($validate);
        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'nik' => 'required|string|size:16|unique:users,nik,' . $id,
            'desa_id' => 'nullable|exists:desas,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string',
            'role' => 'required|in:Admin,Petugas,Warga',
            'no_hp' => 'nullable|string',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus terdiri dari 16 karakter',
            'nik.unique' => 'NIK sudah terdaftar pada akun lain',
            'desa_id.exists' => 'Desa yang dipilih tidak valid',
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Alamat email wajib diisi',
            'email.email' => 'Format alamat email tidak valid',
            'email.unique' => 'Alamat email sudah terdaftar pada akun lain',
            'role.required' => 'Role pengguna wajib dipilih',
            'role.in' => 'Role yang dipilih tidak valid'
        ]);

        if (!empty($validate['password'])) {
            $validate['password'] = Hash::make($validate['password']);
        } else {
            unset($validate['password']);
        }

        $user = User::findOrFail($id);
        $user->update($validate);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }

    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);

        // Toggle status boolean (true -> false / false -> true)
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $statusMessage = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.user.index')->with('success', "Akun user {$user->name} berhasil {$statusMessage}");
    }
}
