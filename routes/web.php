<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Client\CarBrowseController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\ProfileController;
<<<<<<< HEAD

// Homepage
=======
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Client\ClientAuthController;

// --------------------
// Public Pages
// --------------------
>>>>>>> b97c7c6 (Push all files to SwiftRide repository)
Route::view('/', 'client.home')->name('home');

// Public Pages
Route::view('/about', 'client.about')->name('about');
Route::view('/contact', 'client.contact')->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

<<<<<<< HEAD
// Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'client.dashboard')->name('dashboard');

    // Browse and Book Cars
=======
// --------------------
// Client Authentication (Tabbed Login/Register)
// --------------------
Route::middleware('guest')->group(function () {
    Route::get('/auth', [ClientAuthController::class, 'showAuthForm'])->name('client.auth');
    Route::post('/login', [ClientAuthController::class, 'login'])->name('login');
    Route::post('/register', [ClientAuthController::class, 'register'])->name('register');
});

// --------------------
// Authenticated Client Routes
// --------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'client.dashboard')->name('dashboard');

    // Car Browsing & Booking
>>>>>>> b97c7c6 (Push all files to SwiftRide repository)
    Route::get('/browse', [CarBrowseController::class, 'index'])->name('browse');
    Route::get('/car/{id}', [CarBrowseController::class, 'show'])->name('car.details');
    Route::get('/book', [CarBrowseController::class, 'book'])->name('book');
    Route::post('/book', [ClientBookingController::class, 'store'])->name('booking.store');
    Route::get('/my_bookings', [ClientBookingController::class, 'index'])->name('my_bookings');

<<<<<<< HEAD
    // Profile Management (optional for future use)
=======
    // Profile
>>>>>>> b97c7c6 (Push all files to SwiftRide repository)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

<<<<<<< HEAD
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        Route::get('/messages', [MessageController::class, 'index'])->name('messages');
        Route::resource('cars', CarController::class);

        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [AdminBookingController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminBookingController::class, 'show'])->name('show');
        });
=======
// --------------------
// Admin Auth Routes (Tabbed Login/Register)
// --------------------
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/auth', [AdminAuthController::class, 'showAuthForm'])->name('auth');
      Route::get('/login', [AdminAuthController::class, 'showAuthForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register');
});

// --------------------
// Authenticated Admin Routes
// --------------------
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
>>>>>>> b97c7c6 (Push all files to SwiftRide repository)

        Route::view('/users', 'admin.users')->name('users');
        Route::view('/reports', 'admin.reports')->name('reports');
        Route::view('/settings', 'admin.settings')->name('settings');
    });
});

<<<<<<< HEAD
// Breeze Auth Routes
=======
// --------------------
// Laravel Breeze Routes
// --------------------
>>>>>>> b97c7c6 (Push all files to SwiftRide repository)
require __DIR__ . '/auth.php';
