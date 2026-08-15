<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman formulir login.
     */
    public function login()
    {
        return view("auth.login");
    }

    /**
     * Tampilkan halaman formulir pendaftaran.
     */
    public function register()
    {
        return view("auth.register");
    }

    /**
     * Proses pendaftaran pengguna baru (POST).
     */
    public function postRegister(Request $request)
    {
        $validate = $request->validate([
            'nik' => 'required|string|size:16|unique:users,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'desa_id' => 'required',
            'no_hp' => 'nullable|string|max:20',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus berjumlah 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'desa_id.required' => 'Desa wajib dipilih.',
        ]);

        User::create($validate);

        return redirect()->intended('/warga/dashboard')->with('status', 'Pendaftaran berhasil! Selamat datang di aplikasi.');
    }

    /**
     * Proses masuk pengguna (POST).
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email atau NIK wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        if (Auth::attempt([$loginType => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            $redirectRoute = '/';
            if ($user->role === 'Admin') {
                $redirectRoute = '/admin/dashboard';
                // } elseif ($user->role === 'Petugas') {
                //     $redirectRoute = '/b';
            } elseif ($user->role === 'warga') {
                $redirectRoute = '/warga/dashboard';
            }
            return redirect()->intended($redirectRoute)->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email/NIK atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Proses keluar pengguna (POST).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Anda telah berhasil keluar.');
    }
}
