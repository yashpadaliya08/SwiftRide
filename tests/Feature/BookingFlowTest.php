<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Revenue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_available_cars_filters_case_insensitively(): void
    {
        $car = Car::create([
            'name' => 'City Sedan',
            'brand' => 'Honda',
            'model' => 'City',
            'year' => 2023,
            'color' => 'White',
            'price_per_day' => 3000,
            'type' => 'Sedan',
            'transmission' => 'automatic',
            'fuel_type' => 'petrol',
            'seats' => 5,
            'status' => 'available',
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('booking.available', [
            'pickup_city' => 'Rajkot',
            'dropoff_city' => 'Ahmedabad',
            'start_date' => Carbon::tomorrow()->toDateString(),
            'start_time' => '10:00',
            'end_date' => Carbon::tomorrow()->addDays(2)->toDateString(),
            'end_time' => '10:00',
            'transmission' => 'Automatic', // TitleCase from form
            'fuel_type' => 'Petrol', // TitleCase from form
        ]));

        $response->assertOk();
        $response->assertSee('Honda');
        $response->assertSee('City');
    }

    public function test_payment_page_renders_invoice_for_confirmed_booking(): void
    {
        $user = User::factory()->create();
        $car = Car::create([
            'name' => 'Creta',
            'brand' => 'Hyundai',
            'model' => 'Creta',
            'year' => 2023,
            'color' => 'Black',
            'price_per_day' => 4000,
            'type' => 'SUV',
            'transmission' => 'automatic',
            'fuel_type' => 'diesel',
            'seats' => 5,
            'status' => 'available',
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'pickup_city' => 'Rajkot',
            'dropoff_city' => 'Rajkot',
            'start_datetime' => Carbon::tomorrow(),
            'end_datetime' => Carbon::tomorrow()->addDays(2),
            'name' => 'Test User',
            'email' => 'user@example.com',
            'phone' => '1234567890',
            'total_price' => 8000,
            'status' => 'confirmed',
        ]);

        // Accessing payment page should NOT redirect to myBookings, but render the invoice
        $response = $this->actingAs($user)->get(route('booking.payment', $booking->id));

        $response->assertOk();
        $response->assertSee('Invoice');
        $response->assertSee('Hyundai');
    }

    public function test_payment_process_is_idempotent(): void
    {
        $user = User::factory()->create();
        $car = Car::create([
            'name' => 'Fortuner',
            'brand' => 'Toyota',
            'model' => 'Fortuner',
            'year' => 2023,
            'color' => 'White',
            'price_per_day' => 7000,
            'type' => 'SUV',
            'transmission' => 'automatic',
            'fuel_type' => 'diesel',
            'seats' => 7,
            'status' => 'available',
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'pickup_city' => 'Rajkot',
            'dropoff_city' => 'Rajkot',
            'start_datetime' => Carbon::tomorrow(),
            'end_datetime' => Carbon::tomorrow()->addDays(2),
            'name' => 'Test User',
            'email' => 'user@example.com',
            'phone' => '1234567890',
            'total_price' => 14000,
            'status' => 'pending',
        ]);

        // First payment
        $response1 = $this->actingAs($user)->post(route('booking.payment.process', $booking->id));
        $response1->assertRedirect(route('booking.success', $booking->id));

        $this->assertEquals('confirmed', $booking->fresh()->status);
        $this->assertEquals(1, Revenue::where('booking_id', $booking->id)->count());
        $initialPoints = $user->fresh()->loyalty_points;

        // Duplicate payment attempt
        $response2 = $this->actingAs($user)->post(route('booking.payment.process', $booking->id));
        $response2->assertRedirect(route('booking.payment', $booking->id));

        // Revenue records and loyalty points should NOT duplicate
        $this->assertEquals(1, Revenue::where('booking_id', $booking->id)->count());
        $this->assertEquals($initialPoints, $user->fresh()->loyalty_points);
    }

    public function test_user_cannot_cancel_another_users_booking(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $car = Car::create([
            'name' => 'Swift',
            'brand' => 'Maruti',
            'model' => 'Swift',
            'year' => 2022,
            'color' => 'Red',
            'price_per_day' => 2000,
            'type' => 'Hatchback',
            'transmission' => 'manual',
            'fuel_type' => 'petrol',
            'seats' => 5,
            'status' => 'available',
        ]);

        $booking = Booking::create([
            'user_id' => $user1->id,
            'car_id' => $car->id,
            'pickup_city' => 'Rajkot',
            'dropoff_city' => 'Rajkot',
            'start_datetime' => Carbon::tomorrow(),
            'end_datetime' => Carbon::tomorrow()->addDays(1),
            'name' => 'User One',
            'email' => 'user1@example.com',
            'phone' => '1234567890',
            'total_price' => 2000,
            'status' => 'confirmed',
        ]);

        // User 2 attempts to cancel User 1's booking
        $response = $this->actingAs($user2)->patch(route('booking.cancel', $booking->id));
        $response->assertForbidden();

        $this->assertEquals('confirmed', $booking->fresh()->status);
    }

    public function test_cancelling_pending_booking_does_not_issue_refund_revenue(): void
    {
        $user = User::factory()->create();
        $car = Car::create([
            'name' => 'Swift',
            'brand' => 'Maruti',
            'model' => 'Swift',
            'year' => 2022,
            'color' => 'Red',
            'price_per_day' => 2000,
            'type' => 'Hatchback',
            'transmission' => 'manual',
            'fuel_type' => 'petrol',
            'seats' => 5,
            'status' => 'available',
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'pickup_city' => 'Rajkot',
            'dropoff_city' => 'Rajkot',
            'start_datetime' => Carbon::tomorrow(),
            'end_datetime' => Carbon::tomorrow()->addDays(1),
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'total_price' => 2000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->patch(route('booking.cancel', $booking->id));
        $response->assertRedirect();

        $this->assertEquals('cancelled', $booking->fresh()->status);
        // Since it was pending and unpaid, no refund entry should exist
        $this->assertEquals(0, Revenue::where('booking_id', $booking->id)->count());
    }
}
