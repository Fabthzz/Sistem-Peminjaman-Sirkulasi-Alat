<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;

// redirect awal
Route::get('/', fn() => redirect()->route('login'));

// ── AUTH ──
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// ── MAHASISWA ──
Route::prefix('mahasiswa')
    ->middleware(['auth'])
    ->controller(MahasiswaController::class)
    ->group(function () {

        Route::get('/dashboard', 'dashboard')->name('mahasiswa.dashboard');

        Route::get('/keranjang', 'keranjang')->name('mahasiswa.keranjang');
        Route::post('/keranjang/tambah', 'tambahKeranjang')->name('mahasiswa.keranjang.tambah');
        Route::post('/keranjang/hapus', 'hapusKeranjang')->name('mahasiswa.keranjang.hapus');

        Route::post('/pinjam/submit', 'submitPinjam')->name('mahasiswa.pinjam.submit');

        Route::get('/riwayat', 'riwayat')->name('mahasiswa.riwayat');
    });

// ── ADMIN ──
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->controller(AdminController::class)
    ->group(function () {

        Route::get('/dashboard', 'dashboard')->name('admin.dashboard');

        // alat
        Route::get('/alat', 'alatIndex')->name('admin.alat.index');
        Route::post('/alat', 'alatStore')->name('admin.alat.store');
        Route::put('/alat/{id}', 'alatUpdate')->name('admin.alat.update');
        Route::delete('/alat/{id}', 'alatDestroy')->name('admin.alat.destroy');

        // peminjaman
        Route::get('/peminjaman', 'peminjamanIndex')->name('admin.peminjaman.index');
        Route::patch('/peminjaman/{id}/setujui', 'peminjamanSetujui')->name('admin.peminjaman.setujui');
        Route::patch('/peminjaman/{id}/tolak', 'peminjamanTolak')->name('admin.peminjaman.tolak');
        Route::patch('/peminjaman/{id}/kembalikan', 'peminjamanKembalikan')->name('admin.peminjaman.kembalikan');

        // laporan
        Route::get('/laporan/cetak', 'cetakLaporan')->name('admin.laporan.cetak');

        // user (mahasiswa)
        Route::get('/mahasiswa', 'mahasiswaIndex')->name('admin.mahasiswa.index');
        Route::post('/mahasiswa', 'mahasiswaStore')->name('admin.mahasiswa.store');
        Route::put('/mahasiswa/{id}', 'mahasiswaUpdate')->name('admin.mahasiswa.update');
        Route::delete('/mahasiswa/{id}', 'mahasiswaDestroy')->name('admin.mahasiswa.destroy');

        Route::get('/admin-list', 'adminIndex')->name('admin.list');
        Route::post('/admin-list', 'adminStore')->name('admin.store');
        Route::delete('/admin-list/{id}', 'adminDestroy')->name('admin.destroy');

        Route::get('/admin/mahasiswa/search', [AdminController::class, 'mahasiswaSearch'])
            ->name('admin.mahasiswa.search');
    });
