<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// --- Rute GUEST (Belum Login) ---
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// --- Rute PUBLIC (Bisa diakses siapa saja) ---
Route::get('/', function () {
    return redirect()->route('login');
});
// --- Rute AUTH (Harus Login) ---
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile (Urutan dibedakan agar tidak bentrok)
    Route::get('/showroom/profile', [ShowroomController::class, 'myProfile'])->name('showroom.profile');
  
});
 Route::get('/upload-showroom', [ShowroomController::class, 'index'])->name('showrooms.upload');
    Route::post('/upload-showroom', [ShowroomController::class, 'upload'])->name('showrooms.import');
   Route::get('/upload-cars', [CarController::class, 'createUpload'])->name('cars.upload');
    Route::post('/upload-cars', [CarController::class, 'upload'])->name('cars.import');
    Route::get('/showrooms/monitoring', [ShowroomController::class, 'monitoring'])->name('showrooms.monitoring');
    Route::post('/cars/upload-zip-photos', [CarController::class, 'uploadZipPhotos'])->name('cars.photos.zip');
require __DIR__.'/auth.php';