<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Mahasiswa Routes
    Route::prefix('mahasiswa')->middleware('role:mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
        
        // KRS Routes
        Route::get('/krs', [MahasiswaController::class, 'krs'])->name('mahasiswa.krs');
        Route::get('/tambah-krs', [MahasiswaController::class, 'tambahKrs'])->name('mahasiswa.tambah-krs');
        Route::post('/tambah-krs', [MahasiswaController::class, 'storeKrs'])->name('mahasiswa.store-krs');
        Route::delete('/krs/{id}', [MahasiswaController::class, 'deleteKrs'])->name('mahasiswa.delete-krs');
        
        // KHS Routes
        Route::get('/khs', [MahasiswaController::class, 'khs'])->name('mahasiswa.khs');
    });

    // Dosen Routes
    Route::prefix('dosen')->middleware('role:dosen')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
        Route::get('/jadwal', [DosenController::class, 'jadwal'])->name('dosen.jadwal');
        Route::get('/mahasiswa', [DosenController::class, 'mahasiswa'])->name('dosen.mahasiswa');
        Route::get('/input-nilai', [DosenController::class, 'inputNilai'])->name('dosen.input-nilai');
        Route::post('/input-nilai', [DosenController::class, 'storeNilai'])->name('dosen.store-nilai');
        Route::get('/absensi', [DosenController::class, 'absensi'])->name('dosen.absensi');
    });
});
