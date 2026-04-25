<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SmartphoneController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============ ROUTE AUTENTIKASI ============
Route::get('/',      [AuthController::class, 'showLogin'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ============ ROUTE CRUD - PROTECTED dengan Middleware Auth ============
Route::middleware('auth')->group(function () {
    Route::resource('smartphones', SmartphoneController::class);
    Route::resource('transaksi', TransaksiController::class);
});
