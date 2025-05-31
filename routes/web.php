<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Client\CarBrowseController;
use App\Http\Controllers\Client\ClientAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\HomeController;


// Public
Route::view('/', 'client.home')->name('home');
Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::view('/about', 'client.about')->name('about');
Route::view('/contact', 'client.contact')->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

// Client Auth
Route::middleware('guest')->group(function () {
    Route::get('/auth', [ClientAuthController::class, 'showAuthForm'])->name('client.auth');
    Route::post('/login', [ClientAuthController::class, 'login'])->name('client.login');
    Route::post('/register', [ClientAuthController::class, 'register'])->name('client.register');

});

// Admin Auth
Route::middleware('web')->group(function () {
    Route::get('/admin/auth', [AdminAuthController::class, 'showAuthForm'])->name('admin.auth');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register');
});

// Client Authenticated
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => view('client.dashboard'))->name('dashboard');

    Route::get('/browse', [CarBrowseController::class, 'index'])->name('browse');
    Route::get('/car/{id}', [CarBrowseController::class, 'show'])->name('car.details');

    // Booking Flow
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/select', [ClientBookingController::class, 'selectCriteria'])->name('selectCriteria');
        Route::post('/search', [ClientBookingController::class, 'handleSearch'])->name('handleSearch');
        Route::get('/available', [ClientBookingController::class, 'showAvailableCars'])->name('available');

        Route::post('/confirm', [ClientBookingController::class, 'confirm'])->name('confirm');
        Route::post('/store', [ClientBookingController::class, 'storeConfirmed'])->name('store');
        Route::get('/my-bookings', [ClientBookingController::class, 'myBookings'])->name('myBookings');
        Route::patch('/my-bookings/{booking}/cancel', [ClientBookingController::class, 'cancel'])->name('cancel');


    });

    Route::get('/my_bookings', [ClientBookingController::class, 'myBookings'])->name('booking.myBookings');

    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout
    Route::post('/logout', [ClientAuthController::class, 'logout'])->name('logout');
});

// Admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:admin', \App\Http\Middleware\AdminMiddleware::class])
    ->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

        Route::get('/messages', [MessageController::class, 'index'])->name('messages');
        Route::resource('cars', CarController::class);
        Route::get('/registered-users', [AdminDashboardController::class, 'registeredUsers'])->name('registered.users');

        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [AdminBookingController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminBookingController::class, 'show'])->name('show');
             Route::post('/{id}/confirm', [App\Http\Controllers\Admin\BookingController::class, 'confirmBooking'])->name('confirm');
        });

        Route::get('/users', [AdminDashboardController::class, 'registeredUsers'])->name('users');
        Route::get('/reports', [AdminReportController::class, 'reports'])->name('reports');
        Route::view('/settings', 'admin.settings')->name('settings');
    });
// --------------------
// Laravel Breeze Routes
// --------------------
require __DIR__ . '/auth.php';