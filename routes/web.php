<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/jelajah', [LandingController::class, 'jelajah'])->name('jelajah');
Route::get('/tentang-kami', [LandingController::class, 'tentang'])->name('tentang');

// Guest authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Both Admin and Regular User can access catalog management
    Route::get('/admin/katalog', [KatalogController::class, 'index'])->name('admin.katalog.index');
    Route::get('/admin/katalog/{id}', [KatalogController::class, 'show'])->name('admin.katalog.show');

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');

        Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index');
    });
});


