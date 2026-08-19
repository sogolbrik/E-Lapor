<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
        /**
     * Display the specified resource / profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        $desa = Desa::all();

        return view('warga.profile.edit', compact('user', 'desa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $userId = Auth::id();

        $validate = $request->validate([
            'nik'     => 'required|string|size:16|unique:users,nik,' . $userId,
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:users,email,' . $userId,
            'no_hp'   => 'nullable|string|max:20',
            'desa_id' => 'nullable|exists:desas,id',
            'avatar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nik.required' => 'NIK harus diisi.',
            'nik.string' => 'NIK harus berupa teks.',
            'nik.size' => 'NIK harus tepat 16 karakter.',
            'nik.unique' => 'NIK sudah terdaftar, silakan gunakan NIK lain.',
            'name.required' => 'Nama lengkap harus diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Alamat email harus diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Alamat email sudah terdaftar, silakan gunakan email lain.',
            'no_hp.string' => 'Nomor HP harus berupa teks.',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 20 karakter.',
            'desa_id.exists' => 'Desa yang dipilih tidak valid.',
            'avatar.image' => 'File yang diunggah harus berupa gambar.',
            'avatar.mimes' => 'Avatar harus berformat: jpeg, png, jpg, webp.',
            'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 2MB.',
        ]);

        // Handling Upload Avatar
        if ($request->hasFile('avatar')) {
            $user = Auth::user();

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $validate['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::where('id', $userId)->update($validate);

        return redirect()->route('warga.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini harus diisi.',
            'current_password.current_password' => 'Password saat ini yang Anda masukkan salah.',
            'password.required' => 'Password baru harus diisi.',
            'password.string' => 'Password baru harus berupa teks.',
            'password.min' => 'Password baru harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        User::where('id', Auth::id())->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('warga.profile.edit')->with('success', 'Password berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ], [
            'password.required' => 'Password harus diisi untuk menghapus akun.',
            'password.current_password' => 'Password yang Anda masukkan salah.',
        ]);

        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();

        User::where('id', $user->id)->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda berhasil dihapus.');
    }
}
