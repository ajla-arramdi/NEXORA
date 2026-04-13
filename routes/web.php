<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])
        ->middleware('role:peminjam')
        ->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->middleware('role:peminjam')
        ->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create', [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::get('/pengembalian/{pengembalian}', [PengembalianController::class, 'show'])->name('pengembalian.show');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/users', UserController::class)->except('show');
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    Route::resource('/kategori', KategoriController::class)->except('show');
    Route::resource('/alat', AlatController::class)->except('show');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::post('/peminjaman/{peminjaman}/process', [PeminjamanController::class, 'process'])->name('peminjaman.process');
    Route::post('/pengembalian/{pengembalian}/terima', [PengembalianController::class, 'terima'])->name('pengembalian.terima');
});

require __DIR__.'/auth.php';
