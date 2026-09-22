<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KategoriController;

// Public Route (Dengan Rate Limiter: Maksimal 5 percobaan login / menit untuk mencegah Brute Force)
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('throttle:5,1');

// Protected Routes (Sanctum Token Protection + Rate Limiter 120 req/min)
Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Akses Katalog & POS Transaksi (Semua User Authenticated: Admin & Kasir)
    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/barang/{id}', [BarangController::class, 'show']);
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::post('/transaksi', [TransaksiController::class, 'store']);

    // Khusus Role Admin (CRUD Master Barang & Executive Dashboard Stats)
    Route::middleware('role:admin')->group(function () {
        Route::post('/barang', [BarangController::class, 'store']);
        Route::put('/barang/{id}', [BarangController::class, 'update']);
        Route::post('/barang/{id}', [BarangController::class, 'update']); // support FormData _method=PUT
        Route::delete('/barang/{id}', [BarangController::class, 'destroy']);

        Route::post('/kategori', [KategoriController::class, 'store']);
        Route::put('/kategori/{id}', [KategoriController::class, 'update']);
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);

        Route::get('/dashboard', [TransaksiController::class, 'dashboardStats']);
    });

    Route::apiResource('data', DataController::class);
});
