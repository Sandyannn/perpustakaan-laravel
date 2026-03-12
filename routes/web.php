<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriBukuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;

use App\Http\Controllers\Peminjam\KatalogController;
use App\Http\Controllers\Peminjam\PeminjamanController;
use App\Http\Controllers\Peminjam\KoleksiController;
use App\Http\Controllers\Peminjam\UlasanController;

Route::get('/', function () {
    $bukus = \App\Models\Buku::with('kategoris')->latest()->take(8)->get();
    return view('welcome', compact('bukus'));
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:administrator,petugas')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('buku', BukuController::class);
        Route::resource('kategori', KategoriBukuController::class);

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::patch('/peminjaman/{id}/verifikasi', [LaporanController::class, 'verifikasiKembali'])
         ->name('admin.peminjaman.verifikasi');

        Route::middleware('role:administrator')->group(function () {
            Route::resource('users', UserController::class);
        });
    });

    Route::middleware('role:peminjam')->group(function () {
        Route::get('/dashboard', [KatalogController::class, 'index'])->name('dashboard');
        Route::get('/katalog/{buku}', [KatalogController::class, 'show'])->name('katalog.show');

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman/{bukuId}', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::patch('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

        Route::get('/koleksi', [KoleksiController::class, 'index'])->name('koleksi.index');
        Route::post('/koleksi', [KoleksiController::class, 'store'])->name('koleksi.store');
        Route::delete('/koleksi/{id}', [KoleksiController::class, 'destroy'])->name('koleksi.destroy');

        Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    });

});