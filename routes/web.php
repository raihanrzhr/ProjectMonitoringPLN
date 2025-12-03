<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Definisi Role (Untuk Referensi)
|--------------------------------------------------------------------------
| 1 = Pending (Register tapi belum approval)
| 2 = User
| 3 = Admin
| 4 = PemakuKepentingan
*/

// ====================================================
// 1. PUBLIC ROUTES (Bisa diakses Guest / Siapapun)
// ====================================================

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

// // Form
// Route::get('/form', function () {
//     return view('form');
// })->name('form');

// Login & Register (Hanya untuk Guest / yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::get('/register', [RegisteredUserController::class, 'index'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

// ====================================================
// 2. AUTH ROUTES (Harus Login)
// ====================================================
Route::middleware(['auth'])->group(function () {

    // ------------------------------------------------
    // GROUP A: USER AREA (Role 1 & 2)
    // ------------------------------------------------
    // Role 1 (Pending) dan 2 (User) bisa akses halaman form
    Route::middleware(['role:1,2'])->group(function () {
        Route::get('/form', function () {
            // TIPS: Di dalam view 'form', Anda bisa gunakan @if(auth()->user()->role == 1)
            // untuk mendisable tombol submit atau input field agar "tidak bisa input"
            return view('form');
        })->name('form');
    });

    // Khusus Role 2 (User Aktif) yang boleh Submit Form (Input data)
    // Asumsi ada route POST untuk form
    Route::middleware(['role:2'])->group(function () {
         Route::post('/form', function() {
             // Logic simpan form
         })->name('form.store');
    });

// Admin pages (views/admin/*)
    // ------------------------------------------------
    // GROUP B: ADMIN AREA (Role 3 & 4)
    // ------------------------------------------------
    // Dashboard, Maintenance, Peminjaman, Report, Units (Bisa diakses Admin & PemakuKepentingan)
    Route::prefix('admin')->name('admin.')->middleware(['role:3,4'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance');
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
        Route::get('/report', [ReportController::class, 'index'])->name('report');
        
        // Unit Controller (Semua bisa lihat index)
        Route::get('/units', [UnitController::class, 'index'])->name('units');
        Route::get('/unit/{id}/detail', [UnitController::class, 'show'])->name('units.show'); // Asumsi ada method show

        // User Controller (READ ONLY untuk Admin & PemakuKepentingan)
        Route::get('/users', [UserController::class, 'index'])->name('users');
    });
    
    // ------------------------------------------------
    // GROUP C: SUPER ADMIN / WRITABLE AREA (Hanya Role 4)
    // ------------------------------------------------
    // Ini khusus PemakuKepentingan yang boleh Add/Edit/Delete
    Route::prefix('admin')->name('admin.')->middleware(['role:4'])->group(function () {
        
        // Add Unit (Admin biasa tidak bisa, hanya PemakuKepentingan)
        Route::post('/units/add', [UnitController::class, 'store'])->name('units.add');
        
        // User Management (Create, Update, Delete)
        // Admin biasa (role 3) hanya bisa lihat index (di Group B), tapi tidak bisa ke route ini
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
