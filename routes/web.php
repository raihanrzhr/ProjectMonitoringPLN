<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::get('/maintenance', function () {
        return view('admin.maintenance');
    })->name('maintenance');
    Route::get('/peminjaman', function () {
        return view('admin.peminjaman');
    })->name('peminjaman');
    Route::get('/report', function () {
        return view('admin.report');
    })->name('report');
    Route::get('/units', function () {
        return view('admin.units');
    })->name('units');
    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');
    Route::get('/unit-detail', function () {
        return view('admin.unit-detail');
    })->name('unit.detail');
});
