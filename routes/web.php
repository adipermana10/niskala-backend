<?php

use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DisasterController as AdminDisasterController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DisasterInfoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use Illuminate\Support\Facades\Route;

// 1. Halaman Utama (Landing Page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Autentikasi Pengguna (Tamu / Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// 3. Informasi Bencana Alam (Publik)
Route::prefix('bencana')->name('disasters.')->group(function () {
    Route::get('/', [DisasterInfoController::class, 'index'])->name('index');
    Route::get('/{slug}', [DisasterInfoController::class, 'show'])->name('show');
});

// 4. Kampanye Penggalangan Dana & Donasi (Publik)
Route::prefix('kampanye')->name('campaigns.')->group(function () {
    Route::get('/', [CampaignController::class, 'index'])->name('index');
    Route::get('/{slug}', [CampaignController::class, 'show'])->name('show');
    Route::post('/{slug}/donasi', [CampaignController::class, 'donate'])->name('donate');
});

// 5. Dashboard Pengguna & Profil Akun (Auth User & Admin)
Route::middleware('auth')->prefix('akun')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');
});

// 6. Dashboard Admin Lengkap (Khusus Role Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Kategori
    Route::get('/kategori', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/kategori', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/kategori/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/kategori/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // CRUD Informasi Bencana
    Route::resource('bencana', AdminDisasterController::class)
        ->parameters(['bencana' => 'disaster'])
        ->names('disasters')
        ->except(['show']);

    // CRUD Kampanye Donasi
    Route::resource('kampanye', AdminCampaignController::class)
        ->parameters(['kampanye' => 'campaign'])
        ->names('campaigns')
        ->except(['show']);

    // Manajemen Data Donasi
    Route::get('/donasi', [AdminDonationController::class, 'index'])->name('donations.index');
    Route::patch('/donasi/{donation}/status', [AdminDonationController::class, 'updateStatus'])->name('donations.status');
    Route::delete('/donasi/{donation}', [AdminDonationController::class, 'destroy'])->name('donations.destroy');
});