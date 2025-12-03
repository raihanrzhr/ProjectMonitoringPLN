<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // [1] Import ini PENTING

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

// --- BAGIAN AUTHENTICATION (LOGIN & LOGOUT) ---

// Group untuk tamu (yang belum login)
Route::middleware('guest')->group(function () {
    // [2] Route Login (Tampilan)
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // [3] Route Login (Proses Submit)
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    
    // Register
    Route::get('/register', [RegisteredUserController::class, 'index'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

// Route Logout (Hanya bisa diakses jika sudah login)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ----------------------------------------------

// Admin pages (views/admin/*)
// Tambahkan middleware 'auth' agar halaman admin tidak bisa dibuka tanpa login
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
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