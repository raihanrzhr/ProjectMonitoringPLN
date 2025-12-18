<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\FormApiController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // PENTING: Import ini dari branch Current

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

// ====================================================
// 2. GUEST ROUTES (Login & Register)
// ====================================================
Route::middleware('guest')->group(function () {
    // LOGIN: Menggunakan logika dari branch CURRENT (Pakai Controller)
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // REGISTER: Menggunakan logika standar
    Route::get('/register', [RegisteredUserController::class, 'index'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

// ====================================================
// 3. AUTH ROUTES (Harus Login)
// ====================================================
Route::middleware(['auth'])->group(function () {

    // LOGOUT: Menggunakan logika dari branch CURRENT
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // ------------------------------------------------
    // GROUP A: USER AREA (Role 1 & 2)
    // ------------------------------------------------
    // Role 1 (Pending) dan 2 (User) bisa akses halaman form
    Route::middleware(['role:2,3,4'])->group(function () {
        Route::get('/form', function () {
            // TIPS: Di dalam view 'form', Anda bisa gunakan @if(auth()->user()->role == 1)
            // untuk mendisable tombol submit atau input field agar "tidak bisa input"
            return view('form');
        })->name('form');

        Route::post('/peminjamanform', [PeminjamanController::class, 'store'])->name('peminjaman.form.store');
        Route::post('/reportform', [ReportController::class, 'store'])->name('report.form.store');
        
        // API untuk mengambil data unit berdasarkan tipe (UPS/UKB/DETEKSI) - hanya status Standby
        Route::get('/api/units-by-type', [FormApiController::class, 'getUnitsByType'])->name('api.units-by-type');
        
        // API untuk mengambil SEMUA unit berdasarkan tipe (untuk Form Pelaporan Anomali)
        Route::get('/api/all-units-by-type', [FormApiController::class, 'getAllUnitsByType'])->name('api.all-units-by-type');
    });

    // Khusus Role 2 (User Aktif) yang boleh Submit Form (Input data)
    Route::middleware(['role:2'])->group(function () {
         Route::post('/form', function() {
             // Logic simpan form nanti disini
         })->name('form.store');
    });

    // ------------------------------------------------
    // GROUP B: ADMIN AREA (Role 3 & 4)
    // ------------------------------------------------
    // Dashboard, Maintenance, Peminjaman, Report, Units (Bisa diakses Admin & PemakuKepentingan)
    Route::prefix('admin')->name('admin.')->middleware(['role:3,4'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance');

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
        Route::put('/peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
        
        Route::get('/report', [ReportController::class, 'index'])->name('report');
        Route::put('/report/{report}', [ReportController::class, 'update'])->name('report.update');
        Route::delete('/report/{report}', [ReportController::class, 'destroy'])->name('report.destroy');
        Route::delete('/report/image/{image}', [ReportController::class, 'deleteImage'])->name('report.image.destroy');
        
        Route::get('/units', [UnitController::class, 'index'])->name('units');
        Route::post('/units/add', [UnitController::class, 'store'])->name('units.add'); 
        Route::get('/unit/{id}/detail', [UnitController::class, 'show'])->name('units.show');
        Route::put('/units/{id}', [UnitController::class, 'update'])->name('units.update');
        Route::delete('/units/{id}', [UnitController::class, 'destroy'])->name('units.destroy');
        Route::get('/unit-archive', [UnitController::class, 'archive'])->name('unit-archive');

        
        
        // User Controller (READ ONLY untuk Admin biasa)
        Route::get('/users', [UserController::class, 'index'])->name('users');
    });
    
    // ------------------------------------------------
    // GROUP C: SUPER ADMIN / WRITABLE AREA (Hanya Role 4)
    // ------------------------------------------------
    // Ini khusus PemakuKepentingan yang boleh Add/Edit/Delete
    Route::prefix('admin')->name('admin.')->middleware(['role:4'])->group(function () {
        
        // User Management (Create, Update, Delete)
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});