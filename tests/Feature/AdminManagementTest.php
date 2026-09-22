<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Revenue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function createAdmin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_car_show_page_renders_successfully(): void
    {
        $admin = $this->createAdmin();

        $car = Car::create([
            'name' => 'BMW 3 Series',
            'brand' => 'BMW',
            'model' => '330i',
            'year' => 2023,
            'color' => 'Blue',
            'price_per_day' => 8000,
            'type' => 'Sedan',
            'transmission' => 'automatic',
            'fuel_type' => 'petrol',
            'seats' => 5,
            'status' => 'available',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.cars.show', $car->id));

        $response->assertOk();
        $response->assertSee('BMW');
        $response->assertSee('330i');
        $response->assertSee('Technical Specifications');
    }

    public function test_admin_car_update_persists_all_attributes(): void
    {
        $admin = $this->createAdmin();

        $car = Car::create([
            'name' => 'City Old',
            'brand' => 'Honda',
            'model' => 'City',
            'year' => 2021,
            'color' => 'Silver',
            'price_per_day' => 2500,
            'type' => 'Sedan',
            'transmission' => 'manual',
            'fuel_type' => 'petrol',
            'seats' => 5,
            'status' => 'available',
        ]);

        $response = $this->actingAs($admin, 'admin')->put(route('admin.cars.update', $car->id), [
            'name' => 'City New',
            'brand' => 'Honda',
            'model' => 'City ZX',
            'year' => 2023,
            'color' => 'Black',
            'price_per_day' => 3200,
            'type' => 'Luxury',
            'transmission' => 'automatic',
            'fuel_type' => 'hybrid',
            'seats' => 5,
            'status' => 'unavailable',
        ]);

        $response->assertRedirect(route('admin.cars.index'));

        $car->refresh();
        $this->assertEquals('City New', $car->name);
        $this->assertEquals('Luxury', $car->type);
        $this->assertEquals('automatic', $car->transmission);
        $this->assertEquals('hybrid', $car->fuel_type);
        $this->assertEquals('unavailable', $car->status);
    }

    public function test_public_admin_registration_is_disabled(): void
    {
        $response = $this->post('/admin/register', [
            'name' => 'Hacker Admin',
            'email' => 'hacker@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        // Route should not exist or be forbidden (404/405/403)
        $this->assertTrue(in_array($response->status(), [403, 404, 405]));
        $this->assertDatabaseMissing('users', ['email' => 'hacker@example.com']);
    }

    public function test_admin_can_cancel_booking_and_record_refund(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create(['loyalty_points' => 100]);

        $car = Car::create([
            'name' => 'Innova Crysta',
            'brand' => 'Toyota',
            'model' => 'Innova',
            'year' => 2023,
            'color' => 'Grey',
            'price_per_day' => 5000,
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
            'name' => 'Client',
            'email' => $user->email,
            'phone' => '1234567890',
            'total_price' => 10000,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($admin, 'admin')->patch(route('admin.bookings.cancel', $booking->id));

        $response->assertRedirect(route('admin.bookings.show', $booking->id));

        $this->assertEquals('cancelled', $booking->fresh()->status);
        $refund = Revenue::where('booking_id', $booking->id)->where('type', Revenue::TYPE_REFUND)->first();
        $this->assertNotNull($refund);
        $this->assertEquals(-10000, $refund->amount);
    }
}
