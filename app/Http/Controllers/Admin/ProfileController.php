<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the specified resource / profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        $desa = Desa::all();

        return view('admin.profile.edit', compact('user', 'desa'));
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

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        User::where('id', Auth::id())->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile.edit')->with('success', 'Password berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
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
