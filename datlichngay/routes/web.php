<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route dành riêng cho admin (chủ sân)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); // Layout admin
})->name('admin.dashboard')->middleware('auth'); // Chỉ truy cập nếu đã đăng nhập

