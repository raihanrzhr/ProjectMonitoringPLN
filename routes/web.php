<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Auth\RegisteredUserController;

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
Route::middleware(['web'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'index'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

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

    Route::get('/units', [UnitController::class, 'index'])->name('units');
    Route::get('/unit/{id}/detail', function ($id) {
        
    });
    Route::post('/units/add', [UnitController::class, 'store'])->name('units.add');

    Route::get('/users', [UserController::class, 'index'])
    ->name('users');
});
