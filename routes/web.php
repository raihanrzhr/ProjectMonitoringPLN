<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PeminjamanController;

// Landing (root)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Optional alias /landing -> root
Route::get('/landing', function () {
    return redirect()->route('landing');
});

// Layanan
Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');

// Form
Route::get('/form', function () {
    return view('form');
})->name('form');

// Login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Register
Route::get('/register', function () {
    return view('register');
})->name('register');

// Admin pages (views/admin/*)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

    Route::get('/maintenance', [MaintenanceController::class, 'index'])
    ->name('maintenance');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
    ->name('peminjaman');

    Route::get('/report', [ReportController::class, 'index'])
    ->name('report');

    Route::get('/units', [unitController::class, 'index'])
    ->name('units');

    Route::get('/users', [UserController::class, 'index'])
    ->name('users');
});
