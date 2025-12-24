<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use App\Mail\AdminBookingNotificationMail;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Console Routes for Email Testing
|--------------------------------------------------------------------------
|
| These commands help you test email functionality
|
*/

// Test customer booking confirmation email
Artisan::command('test:email-customer {email}', function ($email) {
    // Create a dummy booking for testing
    $user = User::first();
    $car = Car::first();
    
    if (!$user || !$car) {
        $this->error('Please create at least one user and one car first!');
        return;
    }
    
    $booking = Booking::create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'pickup_city' => 'Rajkot',
        'dropoff_city' => 'Ahmedabad',
        'start_datetime' => now()->addDays(1),
        'end_datetime' => now()->addDays(3),
        'total_price' => 5000.00,
        'status' => 'pending',
        'name' => $user->name,
        'email' => $email,
        'phone' => '1234567890',
    ]);
    
    $booking->load(['car', 'user']);
    
    try {
        Mail::to($email)->send(new BookingConfirmationMail($booking));
        $this->info("✅ Customer email sent successfully to: {$email}");
        $this->info("Booking ID: #{$booking->id} (created for testing)");
    } catch (\Exception $e) {
        $this->error("❌ Failed to send email: " . $e->getMessage());
    }
})->purpose('Test customer booking confirmation email');

// Test admin booking notification email
Artisan::command('test:email-admin {email?}', function ($email = null) {
    $adminEmail = $email ?? env('ADMIN_EMAIL', 'swiftride15@gmail.com');
    
    if (!$adminEmail) {
        $this->error('Please provide an email address or set ADMIN_EMAIL in .env file');
        return;
    }
    
    $user = User::first();
    $car = Car::first();
    
    if (!$user || !$car) {
        $this->error('Please create at least one user and one car first!');
        return;
    }
    
    $booking = Booking::create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'pickup_city' => 'Rajkot',
        'dropoff_city' => 'Ahmedabad',
        'start_datetime' => now()->addDays(1),
        'end_datetime' => now()->addDays(3),
        'total_price' => 5000.00,
        'status' => 'pending',
        'name' => $user->name,
        'email' => $user->email,
        'phone' => '1234567890',
    ]);
    
    $booking->load(['car', 'user']);
    
    try {
        Mail::to($adminEmail)->send(new AdminBookingNotificationMail($booking));
        $this->info("✅ Admin email sent successfully to: {$adminEmail}");
        $this->info("Booking ID: #{$booking->id} (created for testing)");
        $this->info("Confirm URL: " . route('admin.bookings.confirm', $booking->id));
    } catch (\Exception $e) {
        $this->error("❌ Failed to send email: " . $e->getMessage());
    }
})->purpose('Test admin booking notification email');

// Test both emails at once
Artisan::command('test:email-both {customer_email} {admin_email?}', function ($customerEmail, $adminEmail = null) {
    $adminEmail = $adminEmail ?? env('ADMIN_EMAIL', 'swiftride15@gmail.com');
    
    $user = User::first();
    $car = Car::first();
    
    if (!$user || !$car) {
        $this->error('Please create at least one user and one car first!');
        return;
    }
    
    $booking = Booking::create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'pickup_city' => 'Rajkot',
        'dropoff_city' => 'Ahmedabad',
        'start_datetime' => now()->addDays(1),
        'end_datetime' => now()->addDays(3),
        'total_price' => 5000.00,
        'status' => 'pending',
        'name' => $user->name,
        'email' => $customerEmail,
        'phone' => '1234567890',
    ]);
    
    $booking->load(['car', 'user']);
    
    // Send customer email
    try {
        Mail::to($customerEmail)->send(new BookingConfirmationMail($booking));
        $this->info("✅ Customer email sent to: {$customerEmail}");
    } catch (\Exception $e) {
        $this->error("❌ Customer email failed: " . $e->getMessage());
    }
    
    // Send admin email
    try {
        Mail::to($adminEmail)->send(new AdminBookingNotificationMail($booking));
        $this->info("✅ Admin email sent to: {$adminEmail}");
    } catch (\Exception $e) {
        $this->error("❌ Admin email failed: " . $e->getMessage());
    }
    
    $this->info("\n📧 Booking ID: #{$booking->id} (created for testing)");
})->purpose('Test both customer and admin emails');