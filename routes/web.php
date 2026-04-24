<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SmartphoneController;
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
// Middleware 'auth' memastikan hanya user yang sudah login bisa akses
Route::middleware('auth')->group(function () {
    Route::resource('smartphones', SmartphoneController::class);
});

// Route yang dihasilkan oleh resource:
// GET    /smartphones           -> index   (daftar semua)
// GET    /smartphones/create    -> create  (form tambah)
// POST   /smartphones           -> store   (simpan baru)
// GET    /smartphones/{id}      -> show    (detail)
// GET    /smartphones/{id}/edit -> edit    (form edit)
// PUT    /smartphones/{id}      -> update  (simpan edit)
// DELETE /smartphones/{id}      -> destroy (hapus)
