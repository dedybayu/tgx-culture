<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\GambarKatalogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/jelajah', [LandingController::class, 'jelajah'])->name('jelajah');
Route::get('/jelajah/{id}', [LandingController::class, 'show'])->name('jelajah.show');
Route::get('/tentang-kami', [LandingController::class, 'tentang'])->name('tentang');

// Guest authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Management
    Route::get('/admin/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::put('/admin/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/admin/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');

    Route::get('/admin/user-dashboard', [DashboardController::class, 'user'])->name('user.dashboard');

    // Both Admin and Regular User can access catalog management
    Route::get('/admin/katalog', [KatalogController::class, 'index'])->name('admin.katalog.index');
    Route::get('/admin/katalog/create', [KatalogController::class, 'create'])->name('admin.katalog.create');
    Route::post('/admin/katalog', [KatalogController::class, 'store'])->name('admin.katalog.store');
    Route::get('/admin/katalog/{id}', [KatalogController::class, 'show'])->name('admin.katalog.show');
    Route::get('/admin/katalog/{id}/edit', [KatalogController::class, 'edit'])->name('admin.katalog.edit');
    Route::put('/admin/katalog/{id}', [KatalogController::class, 'update'])->name('admin.katalog.update');
    Route::delete('/admin/katalog/{id}', [KatalogController::class, 'destroy'])->name('admin.katalog.destroy');

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

        // Category CRUD
        Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
        Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
        Route::put('/admin/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

        Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index');
        Route::post('/admin/user', [UserController::class, 'store'])->name('admin.user.store');
        Route::put('/admin/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    });
});


