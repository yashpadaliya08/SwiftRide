<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use App\Models\Revenue;
use App\Models\Review;
use App\Models\Coupon;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Clean current data safely by disabling foreign key checks
        Schema::disableForeignKeyConstraints();
        DB::table('revenues')->truncate();
        DB::table('reviews')->truncate();
        DB::table('bookings')->truncate();
        DB::table('cars')->truncate();
        DB::table('coupons')->truncate();
        DB::table('contacts')->truncate();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Seed Users
        // Admin user
        $admin = User::create([
            'name' => 'SwiftRide Admin',
            'email' => 'admin@swiftride.com',
            'phone' => '555-019-2834',
            'driving_license' => 'DL-98765432A',
            'is_verified' => true,
            'role' => 'admin',
            'password' => Hash::make('password'),
            'loyalty_points' => 1500,
            'membership_tier' => 'Platinum',
        ]);

        // Standard user
        $testUser = User::create([
            'name' => 'John Doe',
            'email' => 'user@swiftride.com',
            'phone' => '555-012-3456',
            'driving_license' => 'DL-12345678B',
            'is_verified' => true,
            'role' => 'user',
            'password' => Hash::make('password'),
            'loyalty_points' => 250,
            'membership_tier' => 'Silver',
        ]);

        // More realistic users
        $usersData = [
            ['Sarah Jenkins', 'sarah.j@example.com', '555-014-9876', 'DL-87654321C', true, 450, 'Gold'],
            ['Michael Chen', 'm.chen@example.com', '555-016-1234', 'DL-45678901D', true, 920, 'Platinum'],
            ['Emily Rodriguez', 'emily.r@example.com', '555-018-5678', 'DL-34567890E', true, 120, 'Silver'],
            ['David Kim', 'd.kim@example.com', '555-011-4321', 'DL-23456789F', false, 0, 'Silver'],
            ['Jessica Taylor', 'jess.t@example.com', '555-013-8765', 'DL-12349876G', true, 600, 'Gold'],
            ['Marcus Vance', 'marcus.v@example.com', '555-015-3456', 'DL-98761234H', true, 800, 'Platinum'],
            ['Amanda Ross', 'amanda.r@example.com', '555-017-7890', 'DL-56781234I', true, 310, 'Gold'],
            ['Daniel Martinez', 'd.martinez@example.com', '555-019-2345', 'DL-43215678J', false, 50, 'Silver'],
        ];

        $users = [$testUser];
        foreach ($usersData as $u) {
            $users[] = User::create([
                'name' => $u[0],
                'email' => $u[1],
                'phone' => $u[2],
                'driving_license' => $u[3],
                'is_verified' => $u[4],
                'role' => 'user',
                'password' => Hash::make('password'),
                'loyalty_points' => $u[5],
                'membership_tier' => $u[6],
            ]);
        }

        // 3. Seed premium cars (exactly 12 cars mapping to local assets in storage/app/public/cars)
        $carsData = [
            [
                'name' => 'Tesla Model S',
                'brand' => 'Tesla',
                'model' => 'Model S Plaid',
                'year' => 2024,
                'color' => 'Pearl White',
                'price_per_day' => 150.00,
                'description' => 'Experience the future of high-performance driving. Featuring autopilot capabilities, tri-motor all-wheel drive, a premium sound system, and zero emissions.',
                'image' => 'cars/1HG6gE80SCiXEVUY77qxTcas1Wlztj9vJUg4vv56.png',
                'type' => 'Electric',
                'status' => 'available',
                'transmission' => 'automatic',
                'fuel_type' => 'electric',
                'seats' => 5
            ],
            [
                'name' => 'Ford Mustang GT',
                'brand' => 'Ford',
                'model' => 'Mustang GT Premium',
                'year' => 2023,
                'color' => 'Race Red',
                'price_per_day' => 120.00,
                'description' => 'Feel the legendary raw power of the 5.0L Coyote V8 engine. Classic American muscle design meets advanced driving modes and aggressive exhaust styling.',
                'image' => 'cars/29sAR3GiHzZnn8XcU1SwkLJgguBuR6pg7ucpuwBR.png',
                'type' => 'Coupe',
                'status' => 'available',
                'transmission' => 'manual',
                'fuel_type' => 'petrol',
                'seats' => 4
            ],
            [
                'name' => 'Porsche 911 Carrera',
                'brand' => 'Porsche',
                'model' => '911 Carrera S',
                'year' => 2024,
                'color' => 'Agate Grey Metallic',
                'price_per_day' => 250.00,
                'description' => 'The definitive German sports car masterpiece. Exceptional twin-turbo boxer engine, PDK dual-clutch transmission, and razor-sharp handling dynamics.',
                'image' => 'cars/9WHL6gIdUbZcjstnAxxEY01Wsi3SOql0JySlO85o.png',
                'type' => 'Coupe',
                'status' => 'available',
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'seats' => 4
            ],
            [
                'name' => 'Range Rover Sport',
                'brand' => 'Land Rover',
                'model' => 'Range Rover Sport Dynamic',
                'year' => 2023,
                'color' => 'Santorini Black',
                'price_per_day' => 180.00,
                'description' => 'Commanding presence, peerless luxury, and outstanding all-terrain capability. Features premium leather upholstery, panoramic sunroof, and adaptive air suspension.',
                'image' => 'cars/KmR4vUc8w9jCk2z6b10b8uMWlGy6Y4I1aEFrJ4vs.jpg',
                'type' => 'SUV',
                'status' => 'available',
                'transmission' => 'automatic',
                'fuel_type' => 'diesel',
                'seats' => 7
            ],
            [
                'name' => 'BMW M5 Competition',
                'brand' => 'BMW',
                'model' => 'M5 Competition',
                'year' => 2024,
                'color' => 'Marina Bay Blue',
                'price_per_day' => 200.00,
                'description' => 'An executive luxury sedan with the beating heart of a supercar. Twin-turbo V8 engine, intelligent M xDrive, and bespoke executive styling.',
                'image' => 'cars/L8pkQw8uiJmf3nNAUYQsvYEZSyuoh3jZhWb0lRdH.jpg',
                'type' => 'Sedan',
                'status' => 'available',
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'seats' => 5
            ],
            [
                'name' => 'Audi A6 Premium',
                'brand' => 'Audi',
                'model' => 'A6 55 TFSI e',
                'year' => 2023,
                'color' => 'Floret Silver Metallic',
                'price_per_day' => 110.00,
                'description' => 'Sophisticated plugin-hybrid technology wrapped in executive styling. Virtual Cockpit, quiet cabin, and Quattro all-wheel drive stability.',
                'image' => 'cars/c2UkP0ELrDyzzUwHdCilZW7p9sDnOJkHWnkMEsKN.jpg',
                'type' => 'Sedan',
                'status' => 'available',
                'transmission' => 'automatic',
                'fuel_type' => 'hybrid',
                'seats' => 5
            ],
            [
                'name' => 'Mercedes-Benz C-Class',
                'brand' => 'Mercedes-Benz',
                'model' => 'C300 AMG Line',
                'year' => 2024,
                'color' => 'Polar White',
                'price_per_day' => 130.00,
                'description' => 'Luxurious inside and out, the C-Class offers an class-leading infotainment screen, ambient lighting customizability, and ultra-smooth highway cruising.',
                'image' => 'cars/hThEq2Qt06ZZz7hkH2hO3PwyaWbxUKmdWMPSiUgr.jpg',
                'type' => 'Sedan',
                'status' => 'available',
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'seats' => 5
            ],
            [
                'name' => 'Volkswagen Golf GTI',
                'brand' => 'Volkswagen',
                'model' => 'Golf GTI Clubsport',
                'year' => 2023,
                'color' => 'Deep Black Pearl',
                'price_per_day' => 75.00,
                'description' => 'The ultimate practical enthusiast hatchback. Nimble front-wheel drive setup, iconic plaid seats, aggressive dual exhausts, and a highly responsive manual gearbox.',
                'image' => 'cars/lLYMmn1v5qoGhKlc7Zj4dXZ89QMmgqpYKgbAkkl1.jpg',
                'type' => 'Hatchback',
                'status' => 'available',
                'transmission' => 'manual',
                'fuel_type' => 'petrol',
                'seats' => 5
            ],
            [
                'name' => 'Jeep Wrangler Rubicon',
                'brand' => 'Jeep',
                'model' => 'Wrangler Rubicon 392',
                'year' => 2023,
                'color' => 'Sarge Green',
                'price_per_day' => 95.00,
                'description' => 'Legendary open-air offroad adventure. Removable doors, heavy-duty 4x4 axles, premium shocks, and unmatched rugged styling for the ultimate road trip.',
                'image' => 'cars/mWgcdYAq5K8RnnWKAF0hTi7xTtHQygShwKCvY7CU.jpg',
                'type' => 'SUV',
                'status' => 'unavailable',
                'transmission' => 'automatic',
                'fuel_type' => 'diesel',
                'seats' => 5
            ],
            [
                'name' => 'Chevrolet Corvette C8',
                'brand' => 'Chevrolet',
                'model' => 'Corvette Stingray 3LT',
                'year' => 2024,
                'color' => 'Accelerate Yellow',
                'price_per_day' => 220.00,
                'description' => 'A true mid-engine performance icon. Offers futuristic interior design, fighter-jet cockpit feel, 0-60 in 2.9 seconds, and a high-revving naturally aspirated V8.',
                'image' => 'cars/vBdQ1J0hjq8w9J11qCPFP3YreyPD3ytCjGfKmF6A.jpg',
                'type' => 'Coupe',
                'status' => 'available',
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'seats' => 2
            ],
            [
                'name' => 'Toyota RAV4 Hybrid',
                'brand' => 'Toyota',
                'model' => 'RAV4 XSE Hybrid',
                'year' => 2024,
                'color' => 'Cavalry Blue',
                'price_per_day' => 80.00,
                'description' => 'Sporty, highly reliable, and unbelievably fuel-efficient hybrid SUV. Offers ample cargo space, active safety features, and a comfortable, elevated ride.',
                'image' => 'cars/vursPoLWXfXCEGIYRMOmtGiGUyZe8Y1CDaifpeuP.jpg',
                'type' => 'SUV',
                'status' => 'available',
                'transmission' => 'automatic',
                'fuel_type' => 'hybrid',
                'seats' => 5
            ],
            [
                'name' => 'Hyundai Ioniq 5',
                'brand' => 'Hyundai',
                'model' => 'Ioniq 5 Limited',
                'year' => 2024,
                'color' => 'Digital Teal',
                'price_per_day' => 90.00,
                'description' => 'Stunning retro-futuristic electric crossover. Award-winning interior design, sliding center console, massive panoramic pixel dashboard, and exceptionally smooth silent ride.',
                'image' => 'cars/yfxtNMqMU10Re4U1Kl28Ro8yHLhrQISbGTfZyTXd.png',
                'type' => 'Hatchback',
                'status' => 'unavailable',
                'transmission' => 'automatic',
                'fuel_type' => 'electric',
                'seats' => 5
            ]
        ];

        $cars = [];
        foreach ($carsData as $c) {
            $cars[] = Car::create($c);
        }

        // 4. Seed Coupons
        $coupons = [
            Coupon::create([
                'code' => 'WELCOME10',
                'type' => 'percent',
                'value' => 10.00,
                'min_booking_amount' => 0.00,
                'expires_at' => Carbon::now()->addDays(30),
                'is_active' => true,
            ]),
            Coupon::create([
                'code' => 'SUMMER20',
                'type' => 'percent',
                'value' => 20.00,
                'min_booking_amount' => 150.00,
                'expires_at' => Carbon::now()->addDays(15),
                'is_active' => true,
            ]),
            Coupon::create([
                'code' => 'CASH50',
                'type' => 'fixed',
                'value' => 50.00,
                'min_booking_amount' => 200.00,
                'expires_at' => Carbon::now()->addDays(90),
                'is_active' => true,
            ]),
            Coupon::create([
                'code' => 'EXPIRED15',
                'type' => 'fixed',
                'value' => 15.00,
                'min_booking_amount' => 50.00,
                'expires_at' => Carbon::now()->subDays(10),
                'is_active' => true,
            ]),
            Coupon::create([
                'code' => 'INACTIVE5',
                'type' => 'percent',
                'value' => 5.00,
                'min_booking_amount' => 0.00,
                'expires_at' => Carbon::now()->addDays(60),
                'is_active' => false,
            ]),
        ];

        // 5. Seed Bookings & Revenues
        $pickupCities = ['New York', 'Los Angeles', 'Miami', 'San Francisco', 'Chicago', 'Houston', 'Seattle'];
        $statuses = ['completed', 'confirmed', 'pending', 'cancelled'];
        
        // Let's seed 26 bookings distributed across times:
        // - 15 completed bookings (past)
        // - 5 confirmed bookings (currently active or upcoming)
        // - 3 pending bookings (upcoming)
        // - 3 cancelled bookings (past or future)
        
        $bookingIndex = 0;
        
        // We will loop to generate a variety of bookings
        for ($i = 0; $i < 26; $i++) {
            // Pick a user (skipping admin, who is at index 0 in the user array if admin was added first. Let's pick from index 1 onwards)
            $user = $users[array_rand(array_slice($users, 1))];
            $car = $cars[array_rand($cars)];
            
            // Determine status
            if ($i < 15) {
                $status = 'completed';
            } elseif ($i < 20) {
                $status = 'confirmed';
            } elseif ($i < 23) {
                $status = 'pending';
            } else {
                $status = 'cancelled';
            }
            
            // Determine dates
            $durationDays = rand(1, 7);
            if ($status === 'completed') {
                // Completed in the past
                $startOffset = rand(10, 60); // 10 to 60 days ago
                $start = Carbon::now()->subDays($startOffset)->startOfDay()->addHours(rand(8, 14));
                $end = (clone $start)->addDays($durationDays)->addHours(rand(1, 4));
            } elseif ($status === 'confirmed' && $i === 15) {
                // Active right now
                $start = Carbon::now()->subDays(1)->startOfDay()->addHours(9);
                $end = Carbon::now()->addDays($durationDays - 1)->addHours(12);
            } elseif ($status === 'confirmed') {
                // Upcoming confirmed
                $startOffset = rand(1, 15);
                $start = Carbon::now()->addDays($startOffset)->startOfDay()->addHours(10);
                $end = (clone $start)->addDays($durationDays);
            } elseif ($status === 'pending') {
                // Pending upcoming
                $startOffset = rand(2, 20);
                $start = Carbon::now()->addDays($startOffset)->startOfDay()->addHours(8);
                $end = (clone $start)->addDays($durationDays);
            } else {
                // Cancelled booking
                $startOffset = rand(-15, 15);
                $start = Carbon::now()->addDays($startOffset)->startOfDay()->addHours(11);
                $end = (clone $start)->addDays($durationDays);
            }
            
            $rawPrice = $car->price_per_day * $durationDays;
            
            // Apply a coupon sometimes
            $couponCode = null;
            $discountAmount = 0.00;
            
            // 35% chance of applying a coupon
            if (rand(1, 100) <= 35) {
                // Select active coupon
                $activeCoupons = array_slice($coupons, 0, 3); // WELCOME10, SUMMER20, CASH50
                $coupon = $activeCoupons[array_rand($activeCoupons)];
                
                if ($rawPrice >= $coupon->min_booking_amount) {
                    $couponCode = $coupon->code;
                    $discountAmount = $coupon->calculateDiscount($rawPrice);
                }
            }
            
            $totalPrice = max(0, $rawPrice - $discountAmount);
            
            $pickup = $pickupCities[array_rand($pickupCities)];
            // 90% dropoff in same city, 10% in a different city
            $dropoff = (rand(1, 100) <= 90) ? $pickup : $pickupCities[array_rand($pickupCities)];

            $booking = Booking::create([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '555-000-1111',
                'pickup_city' => $pickup,
                'dropoff_city' => $dropoff,
                'start_datetime' => $start,
                'end_datetime' => $end,
                'status' => $status,
                'total_price' => $totalPrice,
                'coupon_code' => $couponCode,
                'discount_amount' => $discountAmount,
                'created_at' => $start->copy()->subDays(rand(2, 7)),
            ]);

            // Seed revenues based on booking status
            if ($status === 'completed' || $status === 'confirmed') {
                // Standard payment received
                Revenue::create([
                    'booking_id' => $booking->id,
                    'amount' => $totalPrice,
                    'type' => 'payment',
                    'status' => 'received',
                    'created_at' => $booking->created_at->addMinutes(rand(5, 60)),
                ]);
            } elseif ($status === 'cancelled') {
                // 50% chance of being partially/fully refunded
                if (rand(1, 100) <= 50) {
                    $refundPercent = rand(50, 100) / 100;
                    $refundAmount = round($totalPrice * $refundPercent, 2);
                    
                    // Create received payment first
                    Revenue::create([
                        'booking_id' => $booking->id,
                        'amount' => $totalPrice,
                        'type' => 'payment',
                        'status' => 'received',
                        'created_at' => $booking->created_at->addMinutes(10),
                    ]);
                    
                    // Create refund
                    Revenue::create([
                        'booking_id' => $booking->id,
                        'amount' => $refundAmount,
                        'type' => 'refund',
                        'status' => 'refunded',
                        'created_at' => $booking->created_at->addDays(1),
                    ]);
                }
            }
        }

        // 6. Seed Reviews
        $reviewComments = [
            5 => [
                'Incredible performance! Cleanest car I\'ve ever rented. Autopilot is a game changer.',
                'Absolutely loved driving this car. Pristine condition, smooth transaction, and premium feel.',
                'Exceeded my expectations in every way. The seats were extremely comfortable for our long road trip!',
                'Stunning looks and great speed! Got compliments everywhere I went. Highly recommended!',
                'Fantastic customer support and an absolute dream to drive. Spotless interior.',
            ],
            4 => [
                'Great ride and highly economical. The pickup process took a few extra minutes but otherwise perfect.',
                'Very clean, good technology features. Solid choice for a business trip, will rent again.',
                'Super comfortable SUV. Perfect amount of space for the family and drove very nicely.',
                'A blast to drive. Only minor issue was the trunk space was slightly tight, but the performance made up for it!',
            ],
            3 => [
                'Decent car. Cleanliness could have been slightly better inside the door pockets, but mechanical status was perfect.',
                'Average experience. The car drove fine, but we noticed a slight squeak in the suspension over speed bumps.',
            ]
        ];

        foreach ($cars as $car) {
            // Seed 1-2 reviews per car
            $numReviews = rand(1, 2);
            for ($r = 0; $r < $numReviews; $r++) {
                $rating = rand(3, 5);
                $commentOptions = $reviewComments[$rating];
                $comment = $commentOptions[array_rand($commentOptions)];
                $reviewer = $users[array_rand(array_slice($users, 1))]; // Non-admin user

                Review::create([
                    'user_id' => $reviewer->id,
                    'car_id' => $car->id,
                    'rating' => $rating,
                    'comment' => $comment,
                    'is_approved' => (rand(1, 100) <= 85), // 85% approved, 15% pending moderation
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }
        }

        // 7. Seed Support Inquiries / Contacts
        $contactInquiries = [
            [
                'name' => 'Alice Henderson',
                'email' => 'alice.h@example.com',
                'issue_type' => 'how_to_book',
                'message' => 'Hello, I want to rent the Tesla Model S for a week next month. Do I need a special driver insurance or is standard coverage included in the price? Thanks!',
            ],
            [
                'name' => 'Brian O\'Connor',
                'email' => 'brian.oc@example.com',
                'issue_type' => 'general_feedback',
                'message' => 'Just returned the Ford Mustang GT today. The exhaust sound is absolutely incredible! Extremely smooth pick up and drop off. SwiftRide is my go-to service from now on.',
            ],
            [
                'name' => 'Claire Sterling',
                'email' => 'claire.s@example.com',
                'issue_type' => 'refund_query',
                'message' => 'Hello, my flight to Los Angeles was cancelled due to heavy storm, and I had to cancel my SUV booking. Could you check if I qualify for a full refund? Booking ID #12.',
            ],
            [
                'name' => 'Derrick Vance',
                'email' => 'derrickv@example.com',
                'issue_type' => 'car_late',
                'message' => 'Hi, I booked the Range Rover Sport to pick up at 9 AM, but I am running late by 45 minutes due to luggage delay. Will my booking be held? Please let me know ASAP.',
            ],
            [
                'name' => 'Grace Lee',
                'email' => 'grace.lee@example.com',
                'issue_type' => 'how_to_book',
                'message' => 'Good morning, does the Toyota RAV4 Hybrid come with a pre-installed baby car seat, or do I need to request it as an add-on during reservation?',
            ],
            [
                'name' => 'Frank Miller',
                'email' => 'frank.m@example.com',
                'issue_type' => 'general_feedback',
                'message' => 'The website interface is beautiful and extremely fast! The checkout flow was a breeze. Keep up the amazing work guys.',
            ]
        ];

        foreach ($contactInquiries as $ci) {
            Contact::create([
                'name' => $ci['name'],
                'email' => $ci['email'],
                'issue_type' => $ci['issue_type'],
                'message' => $ci['message'],
            ]);
        }
    }
}
