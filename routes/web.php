<?php

use App\Http\Controllers\Admin\AduanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\KategoriAduanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\PengaduanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin Page
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // MasterUser
    Route::resource('user', UserController::class);
    Route::patch('user/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggle-status');
    // MasterDesa
    Route::resource('desa', DesaController::class);
    // MasterKategoriAduan
    Route::resource('kategori/aduan', KategoriAduanController::class)->names('kategori.aduan');
    Route::patch('kategori/aduan/{id}/status', [KategoriAduanController::class, 'toggleStatus'])->name('kategori.aduan.status');
    // MasterAduan
    Route::resource('aduan', AduanController::class);
    Route::post('aduan/{id}/tanggapan', [AduanController::class, 'storeTanggapan'])->name('aduan.tanggapan.store');
    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Warga Page
Route::middleware('warga')->prefix('warga')->name('warga.')->group(function () {
    Route::get('dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');
    Route::get('pengaduan/buat', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('pengaduan/buat', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('pengaduan/detail/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
});
