<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\PegawaiController;

use App\Http\Middleware\Manajer;
use App\Http\Middleware\Admin;

use Illuminate\Support\Facades\Route;

// LOGIN
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

// SEMUA PENGGUNA YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // =========================
    // ANGGOTA
    // =========================

    Route::get('/anggota', [AnggotaController::class, 'index'])
        ->name('anggota.index');

    Route::middleware(Manajer::class)->group(function () {

        Route::resource('anggota', AnggotaController::class)
            ->except(['index', 'show']);

        Route::patch('/anggota/{anggota}/status',
            [AnggotaController::class, 'ubahStatus'])
            ->name('anggota.status');

        // =========================
        // PEGAWAI - KHUSUS MANAJER
        // =========================

        Route::get('/pegawai', [PegawaiController::class, 'index'])
            ->name('pegawai.index');

        Route::get('/pegawai/data', [PegawaiController::class, 'data'])
            ->name('pegawai.data');

        Route::post('/pegawai', [PegawaiController::class, 'store'])
            ->name('pegawai.store');

        Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])
            ->name('pegawai.show');

        Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])
            ->name('pegawai.update');

        Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])
            ->name('pegawai.destroy');
    });

    // =========================
    // SIMPANAN
    // =========================

    Route::get('/simpanan', [SimpananController::class, 'index'])
        ->name('simpanan.index');

    Route::get('/simpanan/{simpanan}/nota',
        [SimpananController::class, 'nota'])
        ->name('simpanan.nota');

    Route::middleware(Admin::class)->group(function () {

        Route::get('/simpanan/create',
            [SimpananController::class, 'create'])
            ->name('simpanan.create');

        Route::post('/simpanan',
            [SimpananController::class, 'store'])
            ->name('simpanan.store');

        Route::get('/simpanan/{simpanan}/edit',
            [SimpananController::class, 'edit'])
            ->name('simpanan.edit');

        Route::put('/simpanan/{simpanan}',
            [SimpananController::class, 'update'])
            ->name('simpanan.update');

        Route::delete('/simpanan/{simpanan}',
            [SimpananController::class, 'destroy'])
            ->name('simpanan.destroy');
    });

    // =========================
    // PINJAMAN
    // =========================

    Route::get('/pinjaman', [PinjamanController::class, 'index'])
        ->name('pinjaman.index');

    Route::get('/pinjaman/{pinjaman}/nota',
        [PinjamanController::class, 'nota'])
        ->name('pinjaman.nota');

    Route::middleware(Admin::class)->group(function () {

        Route::get('/pinjaman/create',
            [PinjamanController::class, 'create'])
            ->name('pinjaman.create');

        Route::post('/pinjaman',
            [PinjamanController::class, 'store'])
            ->name('pinjaman.store');

        Route::get('/pinjaman/{pinjaman}/edit',
            [PinjamanController::class, 'edit'])
            ->name('pinjaman.edit');

        Route::put('/pinjaman/{pinjaman}',
            [PinjamanController::class, 'update'])
            ->name('pinjaman.update');

        Route::delete('/pinjaman/{pinjaman}',
            [PinjamanController::class, 'destroy'])
            ->name('pinjaman.destroy');
    });

});
