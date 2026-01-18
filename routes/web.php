<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Client\CarBrowseController;
use App\Http\Controllers\Client\ClientAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ReviewController;


// Public
Route::view('/', 'client.home')->name('home');
Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::view('/about', 'client.about')->name('about');
Route::view('/contact', 'client.contact')->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/cars', [CarBrowseController::class, 'index'])->name('browse');
Route::get('/car/{id}', [CarBrowseController::class, 'show'])->name('car.details');
Route::get('/cars-admin-legacy', [CarController::class, 'index'])->name('cars.index');

// Client Auth - Only accessible when NOT logged in as client
Route::middleware('guest:web')->group(function () {
    Route::get('/auth', [ClientAuthController::class, 'showAuthForm'])->name('client.auth');
    Route::post('/login', [ClientAuthController::class, 'login'])->name('client.login');
    Route::post('/register', [ClientAuthController::class, 'register'])->name('client.register');
});

// Admin Auth - Only accessible when NOT logged in as admin
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/auth', [AdminAuthController::class, 'showAuthForm'])->name('admin.auth');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register');
});

// Client Authenticated - Must be logged in as client (web guard) with client role
Route::middleware(['auth:web', \App\Http\Middleware\EnsureClientRole::class, 'verified'])->group(function () {
    Route::get('/dashboard', [ClientBookingController::class, 'dashboard'])->name('dashboard');


    // Booking Flow
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/select', [ClientBookingController::class, 'selectCriteria'])->name('selectCriteria');
        Route::post('/search', [ClientBookingController::class, 'handleSearch'])->name('handleSearch');
        Route::get('/available', [ClientBookingController::class, 'showAvailableCars'])->name('available');

        Route::post('/confirm', [ClientBookingController::class, 'confirm'])->name('confirm');
        Route::post('/store', [ClientBookingController::class, 'storeConfirmed'])->name('store');
        Route::get('/my-bookings', [ClientBookingController::class, 'myBookings'])->name('myBookings');
        Route::patch('/my-bookings/{booking}/cancel', [ClientBookingController::class, 'cancel'])->name('cancel');

        Route::get('/{booking}/payment', [ClientBookingController::class, 'showPayment'])->name('payment');
        Route::post('/{booking}/payment', [ClientBookingController::class, 'processPayment'])->name('payment.process');
        Route::get('/{booking}/success', [ClientBookingController::class, 'success'])->name('success');

    });

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/coupons/apply', [ClientBookingController::class, 'applyCoupon'])->name('coupons.apply');

    Route::get('/my_bookings', [ClientBookingController::class, 'myBookings'])->name('booking.myBookings');

    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Client Logout
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

        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::patch('/users/{id}/verify', [UserController::class, 'verify'])->name('users.verify');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::patch('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
        Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::resource('coupons', AdminCouponController::class)->except(['create', 'edit', 'show', 'update']);
        Route::patch('/coupons/{coupon}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');

        Route::get('/calendar', [AdminDashboardController::class, 'calendar'])->name('calendar'); 
        Route::get('/reports', [AdminReportController::class, 'reports'])->name('reports');
        Route::view('/settings', 'admin.settings')->name('settings');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
// --------------------
// Laravel Breeze Routes
// --------------------
require __DIR__ . '/auth.php';