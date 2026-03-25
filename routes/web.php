<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// ── AUTH ──
Route::get('/login',           [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/admin',    [AuthController::class, 'loginAdmin'])->name('login.admin');
Route::post('/login/mahasiswa', [AuthController::class, 'loginMahasiswa'])->name('login.mahasiswa');
Route::post('/logout',         [AuthController::class, 'logout'])->name('logout');

// ── MAHASISWA (session-based) ──
Route::prefix('mahasiswa')->middleware('mahasiswa')->group(function () {
    Route::get('/dashboard',         [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::get('/keranjang',         [MahasiswaController::class, 'keranjang'])->name('mahasiswa.keranjang');
    Route::post('/keranjang/tambah', [MahasiswaController::class, 'tambahKeranjang'])->name('mahasiswa.keranjang.tambah');
    Route::post('/keranjang/hapus',  [MahasiswaController::class, 'hapusKeranjang'])->name('mahasiswa.keranjang.hapus');
    Route::post('/pinjam/submit',    [MahasiswaController::class, 'submitPinjam'])->name('mahasiswa.pinjam.submit');
    Route::get('/riwayat',           [MahasiswaController::class, 'riwayat'])->name('mahasiswa.riwayat');
});

// ── ADMIN (Auth-based) ──
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard',                    [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Alat
    Route::get('/alat',                         [AdminController::class, 'alatIndex'])->name('admin.alat.index');
    Route::post('/alat',                        [AdminController::class, 'alatStore'])->name('admin.alat.store');
    Route::put('/alat/{id}',                    [AdminController::class, 'alatUpdate'])->name('admin.alat.update');
    Route::delete('/alat/{id}',                 [AdminController::class, 'alatDestroy'])->name('admin.alat.destroy');

    // Peminjaman
    Route::get('/peminjaman',                   [AdminController::class, 'peminjamanIndex'])->name('admin.peminjaman.index');
    Route::patch('/peminjaman/{id}/setujui',    [AdminController::class, 'peminjamanSetujui'])->name('admin.peminjaman.setujui');
    Route::patch('/peminjaman/{id}/tolak',      [AdminController::class, 'peminjamanTolak'])->name('admin.peminjaman.tolak');
    Route::patch('/peminjaman/{id}/kembalikan', [AdminController::class, 'peminjamanKembalikan'])->name('admin.peminjaman.kembalikan');

    // Mahasiswa
    Route::get('/mahasiswa',         [AdminController::class, 'mahasiswaIndex'])->name('admin.mahasiswa.index');
    Route::post('/mahasiswa',        [AdminController::class, 'mahasiswaStore'])->name('admin.mahasiswa.store');
    Route::put('/mahasiswa/{id}',    [AdminController::class, 'mahasiswaUpdate'])->name('admin.mahasiswa.update');
    Route::delete('/mahasiswa/{id}', [AdminController::class, 'mahasiswaDestroy'])->name('admin.mahasiswa.destroy');
});
