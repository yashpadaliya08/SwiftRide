<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Client\CarBrowseController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\ProfileController;

// Homepage
Route::view('/', 'client.home')->name('home');

// Public Pages
Route::view('/about', 'client.about')->name('about');
Route::view('/contact', 'client.contact')->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'client.dashboard')->name('dashboard');

    // Browse and Book Cars
    Route::get('/browse', [CarBrowseController::class, 'index'])->name('browse');
    Route::get('/car/{id}', [CarBrowseController::class, 'show'])->name('car.details');
    Route::get('/book', [CarBrowseController::class, 'book'])->name('book');
    Route::post('/book', [ClientBookingController::class, 'store'])->name('booking.store');
    Route::get('/my_bookings', [ClientBookingController::class, 'index'])->name('my_bookings');

    // Profile Management (optional for future use)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        Route::get('/messages', [MessageController::class, 'index'])->name('messages');
        Route::resource('cars', CarController::class);

        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [AdminBookingController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminBookingController::class, 'show'])->name('show');
        });

        Route::view('/users', 'admin.users')->name('users');
        Route::view('/reports', 'admin.reports')->name('reports');
        Route::view('/settings', 'admin.settings')->name('settings');
    });
});

// Breeze Auth Routes
require __DIR__ . '/auth.php';
