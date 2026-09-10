<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CarReviewController;
use App\Http\Controllers\PhotoReviewController;
use Illuminate\Support\Facades\Route;

// --- Rute GUEST (Belum Login) ---
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// --- Rute PUBLIC (Bisa diakses siapa saja) ---
//Route::get('/', function ()     return view('portal.index'); // Sesuaikan dengan nama file blade kamu}); //

Route::get('/', [PortalController::class, 'index'])->name('portal.index');

// --- Rute AUTH (Harus Login) ---
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard


    // Profile (Urutan dibedakan agar tidak bentrok)
    Route::get('/showroom/profile', [ShowroomController::class, 'myProfile'])->name('showroom.profile');
  
});


Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Showroom Routes
    Route::get('/upload-showroom', [ShowroomController::class, 'index'])->name('showrooms.upload');
    Route::post('/upload-showroom', [ShowroomController::class, 'upload'])->name('showrooms.import');
    Route::get('/showrooms/monitoring', [ShowroomController::class, 'monitoring'])->name('showrooms.monitoring');

    // Car & Photos Routes
    Route::get('/upload-cars', [CarController::class, 'createUpload'])->name('cars.upload');
    Route::post('/upload-cars', [CarController::class, 'upload'])->name('cars.import');
    Route::post('/cars/upload-zip-photos', [CarController::class, 'uploadZipPhotos'])->name('cars.photos.zip');
    Route::delete('/admin/cars/{id}', [CarController::class, 'destroy'])->name('admin.cars.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Tambahkan 'Route::' di depan get() dan post() serta delete()
    Route::get('/cars/review', [CarReviewController::class, 'index'])->name('cars.review');
    Route::post('/cars/review/{id}/approve', [CarReviewController::class, 'approve'])->name('cars.review.approve');
    Route::delete('/cars/review/{id}', [CarReviewController::class, 'destroy'])->name('cars.review.destroy');
    Route::post('/cars/upload-chunk', [CarController::class, 'uploadChunk'])->name('cars.chunk.upload');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Pastikan menggunakan Route::get untuk halaman utama review
    Route::get('/cars/photo_review', [PhotoReviewController::class, 'index'])->name('cars.photo_review');
    Route::post('/cars/photo_review/{id}/assign', [PhotoReviewController::class, 'assign'])->name('cars.photo_review.assign');
    Route::delete('/cars/photo_review/clear', [PhotoReviewController::class, 'clearUnmatchedPhotos'])->name('cars.photo_review.clear');
});
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');
require __DIR__.'/auth.php';