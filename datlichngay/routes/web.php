<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Field\FieldController;
use App\Http\Controllers\Field\PriceController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;

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

Route::get('/admin/customers', [CustomerController::class, 'index'])
    ->name('admin.customers')
    ->middleware('auth');
    Route::get('/admin', [CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/admin/customers/{id}', [CustomerController::class, 'show'])->name('admin.customers.show');
    Route::delete('/admin/customers/{id}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');


Route::middleware(['auth'])->group(function () {
    // Route quản lý sân bóng
    Route::get('/admin/fields', [FieldController::class, 'index'])->name('fields.index');
    Route::get('/admin/fields/create', [FieldController::class, 'create'])->name('fields.create');
    Route::post('/admin/fields/store', [FieldController::class, 'store'])->name('fields.store');
    Route::get('/admin/fields/edit/{id}', [FieldController::class, 'edit'])->name('fields.edit');
    Route::put('/admin/fields/update/{id}', [FieldController::class, 'update'])->name('fields.update'); // Dùng PUT
    Route::delete('/admin/fields/delete/{id}', [FieldController::class, 'destroy'])->name('fields.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/prices', [PriceController::class, 'index'])->name('prices.index');
    Route::get('/admin/prices/edit/{id}', [PriceController::class, 'edit'])->name('prices.edit');
    Route::post('/admin/prices/update/{id}', [PriceController::class, 'update'])->name('prices.update'); // Sử dụng POST
});

Route::get('/fields', [FieldsController::class, 'index'])->name('fields.index');
Route::get('/fields/{id}', [FieldsController::class, 'show'])->name('fields.show');