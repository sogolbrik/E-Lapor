<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil total user
        $totalUser = User::count();
        // User baru bulan ini
        $userBulanIni = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        // Akun Aktif & Nonaktif
        $akunAktif = User::where('is_active', true)->count();
        $akunNonaktif = User::where('is_active', false)->count();
        // Persentase Aktif & Nonaktif
        $persenAktif = $totalUser > 0 ? number_format(($akunAktif / $totalUser) * 100, 1) : 0;
        $persenNonaktif = $totalUser > 0 ? number_format(($akunNonaktif / $totalUser) * 100, 1) : 0;

        // Total Desa
        $totalDesa = Desa::count();
        return view('admin.master_user.index', [
            'user' => User::get(),
            'desa' => Desa::get(),
            'totalUser' => $totalUser,
            'userBulanIni' => $userBulanIni,
            'akunAktif' => $akunAktif,
            'akunNonaktif' => $akunNonaktif,
            'persenAktif' => $persenAktif,
            'persenNonaktif' => $persenNonaktif,
            'totalDesa' => $totalDesa
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
            'avatar' => 'nullable|string',
            'no_hp' => 'nullable|string',
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
