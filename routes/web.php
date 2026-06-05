<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/jelajah', [LandingController::class, 'jelajah'])->name('jelajah');
Route::get('/tentang-kami', [LandingController::class, 'tentang'])->name('tentang');

