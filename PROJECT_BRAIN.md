# 🚗 SwiftRide — Complete Project Brain

> **My full project explained like I wrote it myself — for interviews, revision, or explaining to anyone.**

---

## 📌 What is SwiftRide?

SwiftRide is a **car rental web application** built with **Laravel 12** (PHP framework).

It has two types of users:
- **Clients (users)** — people who browse cars and book them
- **Admins** — people who manage cars, bookings, coupons, reviews, and users

The whole app runs on a single **SQLite database** (`database/database.sqlite`) — simple, no MySQL setup needed.

---

## 🏗️ Tech Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel 12 (PHP 8.2+) |
| Database | SQLite (via Eloquent ORM) |
| Frontend | Blade Templates + Tailwind CSS |
| Auth System | Custom dual-guard (web + admin) |
| Email | Laravel Mailable (SMTP / Mailtrap) |
| DataTables | Yajra Laravel DataTables |
| Auth Scaffolding | Laravel Breeze (partially used) |
| Build Tool | Vite |

---

## 📂 Folder Structure (Important Parts)

```
SwiftRide/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           ← All admin-side controllers
│   │   │   ├── Auth/            ← Breeze auth controllers (password reset, email verify)
│   │   │   ├── Client/          ← All client-side controllers
│   │   │   ├── CarController.php      ← CRUD for cars (used by admin)
│   │   │   ├── ContactController.php  ← Contact form submit
│   │   │   └── ProfileController.php  ← User profile edit/delete
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php      ← Guards admin routes
│   │       └── EnsureClientRole.php    ← Guards client routes
│   ├── Mail/
│   │   ├── BookingConfirmationMail.php     ← Email to customer on payment
│   │   └── AdminBookingNotificationMail.php ← Email to admin on booking
│   └── Models/
│       ├── User.php, Car.php, Booking.php, Revenue.php
│       ├── Review.php, Coupon.php, Contact.php, Message.php
├── database/
│   ├── migrations/      ← All table definitions
│   └── database.sqlite  ← Actual database file
└── routes/
    ├── web.php     ← All HTTP routes
    ├── auth.php    ← Breeze password reset + email verify routes
    └── console.php ← Artisan test commands for emails
```

---

## 🗄️ Database Design — Every Table Explained

### 1. `users` table
The single table for BOTH admins and clients. Role differentiates them.

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `name` | string | Full name |
| `email` | string UNIQUE | Login email |
| `password` | string | Bcrypt hashed |
| `role` | enum('admin','user') | `user` = client, `admin` = admin |
| `loyalty_points` | integer | Default 0. Earned when paying for bookings |
| `membership_tier` | string | Default 'Silver'. Upgrades to Gold/Platinum |
| `phone` | string | Optional contact |
| `driving_license` | string | File path stored, uploaded by client |
| `is_verified` | boolean | Admin manually verifies client's license |
| `email_verified_at` | datetime | Email verification timestamp |
| `remember_token` | string | For "remember me" |
| `created_at`, `updated_at` | timestamps | Auto |

> **Why role in same table?** Because Laravel's guards (`web`, `admin`) point to the same `users` table but filter by `role`. Simpler than 2 tables.

---

### 2. `cars` table
Every car the business offers for rent.

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | Auto |
| `name` | string | Display name e.g. "Swift Dzire" |
| `brand` | string | e.g. Maruti, Hyundai |
| `model` | string | e.g. Dzire, Creta |
| `year` | year | Manufacturing year |
| `color` | string | Nullable |
| `price_per_day` | decimal(8,2) | Price charged per day |
| `description` | text | Nullable |
| `image` | string | File path stored in `storage/app/public/cars/` |
| `type` | string | e.g. Sedan, SUV, Hatchback |
| `status` | enum('available','unavailable') | Controls booking eligibility |
| `transmission` | enum('manual','automatic') | Added later via migration |
| `fuel_type` | enum('petrol','diesel','electric','hybrid') | Added later |
| `seats` | integer | How many people fit |
| `created_at`, `updated_at` | timestamps | Auto |

---

### 3. `bookings` table
Core table — every rent request made by a client.

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | Auto |
| `user_id` | FK → users | Who booked |
| `car_id` | FK → cars | Which car |
| `name` | string | Customer name (entered at confirm step) |
| `email` | string | Customer email (for sending confirmation) |
| `phone` | string | Customer phone |
| `pickup_city` | string | One of 5 Gujarat cities |
| `dropoff_city` | string | One of 5 Gujarat cities |
| `start_datetime` | datetime | Rental start time |
| `end_datetime` | datetime | Rental end time |
| `total_price` | decimal(8,2) | Final price after discount |
| `coupon_code` | string | Nullable — coupon used |
| `discount_amount` | decimal | How much was discounted |
| `status` | enum('pending','confirmed','cancelled','completed') | Lifecycle |
| `created_at`, `updated_at` | timestamps | Auto |

> **Status lifecycle:** `pending` (created) → `confirmed` (payment done) → `completed` (auto after end_datetime passes) OR `cancelled` (user cancels)

---

### 4. `revenues` table
Tracks every money event (payment or refund).

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | Auto |
| `booking_id` | FK → bookings | Which booking |
| `amount` | decimal | Positive = payment, Negative = refund |
| `type` | string | 'payment' or 'refund' |
| `status` | enum('received','refunded') | Status of money |
| `created_at`, `updated_at` | timestamps | Auto |

> When a booking is paid → Revenue record created (`type=payment`, `status=received`)
> When a booking is cancelled → Revenue record created (`type=refund`, `amount=-total_price`, `status=refunded`)

---

### 5. `reviews` table
Customer reviews for cars.

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | Auto |
| `user_id` | FK → users | Who wrote it |
| `car_id` | FK → cars | Which car |
| `rating` | integer | 1–5 stars |
| `comment` | text | Nullable |
| `is_approved` | boolean | Default false. Admin must approve |
| `created_at`, `updated_at` | timestamps | Auto |

> Reviews are **not visible** to anyone until admin approves them.

---

### 6. `coupons` table
Discount codes that clients can apply at booking confirmation.

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | Auto |
| `code` | string UNIQUE | e.g. "SAVE50" |
| `type` | enum('fixed','percent') | Fixed = ₹ amount off, Percent = % off |
| `value` | decimal | Amount or percentage |
| `min_booking_amount` | decimal | Minimum order to use this |
| `expires_at` | datetime | Nullable — null = never expires |
| `is_active` | boolean | Admin can toggle on/off |
| `created_at`, `updated_at` | timestamps | Auto |

---

### 7. `contacts` table
Messages submitted through the public contact form.

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | Auto |
| `name` | string | Sender name |
| `email` | string | Sender email |
| `issue_type` | string | e.g. 'how_to_book', 'car_late' |
| `message` | text | Full message |
| `created_at`, `updated_at` | timestamps | Auto |

---

### 8. `sessions` table
Laravel stores session data here (database driver).

---

### 9. `cache` table + `jobs` table
Standard Laravel tables for caching and queued jobs (emails can be queued).

---

## 🗺️ Database Relationships (ERD in words)

```
users ──< bookings >── cars
users ──< reviews >── cars
bookings ──< revenues
coupons (standalone — codes referenced in bookings.coupon_code)
contacts (standalone — no FK)
```

---

## 🔐 Authentication — How it Actually Works

### The Key Concept: TWO Guards

Laravel has a concept called **"guards"** — they are independent login sessions.

We have **two guards** configured:

| Guard | Model | Purpose |
|---|---|---|
| `web` | `User` (role = 'user') | Client login |
| `admin` | `User` (role = 'admin') | Admin login |

Both use the **same `users` table**, but they are completely separate sessions. You can be logged in as both at the same time without conflict.

---

### Client Authentication Flow

**Registration (`POST /register`):**
1. Client fills the register tab on `/auth`
2. Validates: name, email (unique), password (min 6, confirmed)
3. Creates user with `role = 'user'` (database enum uses 'user', not 'client')
4. Logs them in immediately via `Auth::guard('web')->login($user)`
5. Redirects to `/dashboard`

**Login (`POST /login`):**
1. Client submits email + password on `/auth`
2. Fetches user from DB by email
3. Checks `role === 'client' OR role === 'user'` (safety check)
4. Calls `Auth::guard('web')->attempt($credentials)` — Laravel verifies password
5. If success: `session()->regenerate()` → redirect to `/dashboard`
6. If fail: back with error "Invalid credentials or not a client account"

**Logout (`POST /logout`):**
1. Only logs out `web` guard: `Auth::guard('web')->logout()`
2. Regenerates CSRF token
3. Redirects to `/auth`
> **Why not invalidate entire session?** Because admin could be logged in too — we don't want to log out admin.

---

### Admin Authentication Flow

**Login (`POST /admin/login`):**
1. Admin fills form at `/admin/auth`
2. Calls `Auth::guard('admin')->attempt(array_merge($credentials, ['role' => 'admin']))`
   - This attempts login AND requires `role = admin` in the credentials match
3. If success: `session()->regenerate()` → redirect to `/admin/dashboard`
4. If fail: back with "Invalid credentials or not an admin account"

**Logout (`POST /admin/logout`):**
1. Only logs out `admin` guard: `Auth::guard('admin')->logout()`
2. Regenerates CSRF token
3. Redirects to `/admin/auth`

---

### Middleware — How Routes are Protected

#### `EnsureClientRole` Middleware
Applied to ALL client protected routes.
- Gets user from `web` guard
- If no user → redirect to `/auth`
- If user's role is NOT `'user'` → logout and redirect to `/auth`

#### `AdminMiddleware`
Applied to ALL admin routes.
- Gets user from `admin` guard
- If no user → redirect to `/admin/auth`
- If user's role is NOT `'admin'` → logout and redirect to `/admin/auth`

---

### Route Protection Groups Summary

```
Public (no auth):
  GET  /                → Home
  GET  /about           → About page
  GET  /contact         → Contact page
  POST /contact         → Submit contact form
  GET  /cars            → Browse all cars
  GET  /car/{id}        → Car detail page

Guest-only (redirect if already logged in):
  GET  /auth            → Client login/register form
  POST /login           → Client login
  POST /register        → Client register
  GET  /admin/auth      → Admin login/register form
  POST /admin/login     → Admin login
  POST /admin/register  → Admin register

Client-protected (auth:web + EnsureClientRole + verified):
  GET  /dashboard          → My bookings dashboard
  GET  /booking/select     → Step 1: Select dates + cities
  POST /booking/search     → Step 2: Validate and redirect
  GET  /booking/available  → Step 3: Show available cars
  POST /booking/confirm    → Step 4: Confirm car selection
  POST /booking/store      → Step 5: Store booking (pending)
  GET  /booking/{id}/payment   → Payment page
  POST /booking/{id}/payment   → Process payment
  GET  /booking/{id}/success   → Success page
  GET  /booking/my-bookings    → My bookings list
  PATCH /booking/{id}/cancel   → Cancel a booking
  POST /reviews            → Submit a review
  POST /coupons/apply      → AJAX: Apply coupon
  GET  /profile/edit       → Edit profile
  PATCH /profile/update    → Update profile
  DELETE /profile/delete   → Delete account

Admin-protected (auth:admin + AdminMiddleware):
  GET  /admin/dashboard        → Stats + charts
  GET  /admin/messages         → Contact form submissions
  GET  /admin/bookings         → All bookings
  GET  /admin/bookings/{id}    → Single booking detail
  POST /admin/bookings/{id}/confirm  → Confirm a booking
  GET  /admin/users            → All users
  PATCH /admin/users/{id}/verify    → Verify user's license
  DELETE /admin/users/{id}          → Delete user
  GET  /admin/reviews          → All reviews
  PATCH /admin/reviews/{id}/approve → Approve review
  DELETE /admin/reviews/{id}        → Delete review
  GET/POST /admin/coupons      → Create coupon
  DELETE /admin/coupons/{id}   → Delete coupon
  PATCH /admin/coupons/{id}/toggle → Toggle active/inactive
  GET  /admin/calendar         → Booking calendar
  GET  /admin/reports          → Revenue + user reports
  GET  /admin/cars             → List all cars (CRUD)
  POST /admin/logout           → Admin logout
```

---

## 🚗 Booking Flow — Step by Step

This is the most important feature. Here is exactly what happens:

### Step 1: Select Criteria (`GET /booking/select`)
- Page shows: pickup city, dropoff city, start date+time, end date+time
- Available cities hardcoded in controller: `['Rajkot', 'Ahmedabad', 'Vadodara', 'Surat', 'Jamnagar']`
- Buffer hours (8 hours) shown to user so they know a car needs 8 hrs gap between bookings

### Step 2: Handle Search (`POST /booking/search`)
- Validates all fields
- After end date must be >= start date
- **No DB query here** — just validates and redirects to `/booking/available` with query params

### Step 3: Available Cars (`GET /booking/available`)
- **Key logic here:** `hasConflict()` function
- Fetches ALL `available` cars
- For each car, checks if it conflicts with requested dates (with 8-hour buffer)
- **Conflict check logic:**
  - Subtracts 8 hours from requested start
  - Adds 8 hours to requested end
  - Checks if ANY non-cancelled booking for that car overlaps this adjusted window
  - Uses three overlap conditions: existing booking starts within window, ends within window, or fully covers window
- After conflict filter: apply user filters (max price, transmission, fuel type)
- Sorting options: popular (default), price_low, price_high, newest (by year)
- Supports AJAX requests (returns partial view for live filtering)

### Step 4: Confirm (`POST /booking/confirm`)
- User selects a car and clicks "Book This Car"
- Re-validates car exists + dates valid
- **Re-checks conflict** (someone else might have booked it between steps)
- Calculates: `days = diffInDays(start, end) + 1`
- Calculates: `total = days × car.price_per_day`
- Shows confirmation page with all details — no DB write yet

### Step 5: Store Confirmed (`POST /booking/store`)
- User fills in their contact info (name, email, phone) + optional coupon
- Full validation again (car, dates, name, email, phone)
- **Final conflict check** (3rd time — race condition protection)
- **Coupon processing:**
  - If coupon code provided, finds coupon in DB
  - Calls `$coupon->isValid($total)` — checks active, not expired, min amount met
  - Calls `$coupon->calculateDiscount($total)` — fixed or percent discount
  - If invalid → back with error
- **Creates Booking** with `status = 'pending'`
- `total_price = total - discount` (already reduced price saved)
- Redirects to payment page

### Step 6: Payment (`GET + POST /booking/{id}/payment`)
**GET:** Shows payment summary. Checks booking belongs to logged-in user AND status is 'pending'.

**POST (Process Payment):**
1. Security: verify `booking.user_id === Auth::id()` → else `abort(403)`
2. Change `booking.status` → `'confirmed'`
3. Create `Revenue` record (`type=payment`, `status=received`, `amount=total_price`)
4. **Award Loyalty Points:**
   - Formula: `floor(total_price / 100)` = 1 point per ₹100 spent
   - Example: ₹3,000 booking = 30 points
   - Update `user.loyalty_points += earnedPoints`
   - Check membership tier:
     - `loyalty_points >= 15000` → Platinum
     - `loyalty_points >= 5000` → Gold
     - Below 5000 → stays Silver
5. **Send Emails:**
   - Customer: `BookingConfirmationMail` to `booking.email`
   - Admin: `AdminBookingNotificationMail` to `ADMIN_EMAIL` env variable
   - Both wrapped in try/catch — email failure doesn't break booking
6. Redirect to `/booking/{id}/success`

### Step 7: Success (`GET /booking/{id}/success`)
- Shows booking confirmation details
- Verifies booking belongs to logged-in user

---

## ❌ Cancel Booking (`PATCH /booking/{id}/cancel`)

1. Finds booking by ID
2. If already cancelled → back with error
3. Sets `status = 'cancelled'`
4. Creates Revenue record: `type=refund`, `amount=-total_price`, `status=refunded`
5. Back with success message

> **Note:** No check for booking ownership here — potential improvement to add `where('user_id', Auth::id())`.

---

## 🏷️ Coupon System — How it Works

### Admin creates coupons:
- Goes to `/admin/coupons`
- Fills code, type (fixed/percent), value, min amount, expiry
- `POST /admin/coupons` → `CouponController@store`

### Client uses coupons — Two ways:

**AJAX validation (`POST /coupons/apply`):**
- JavaScript sends `{code, amount}` to this endpoint
- Returns JSON: `{success, discount, new_total, message}`
- Used for live preview before confirming

**Actual application (`POST /booking/store`):**
- Coupon code validated server-side before booking is created
- `isValid($amount)` checks: active + not expired + amount >= min
- `calculateDiscount($amount)`:
  - `fixed` type: `min(coupon.value, total)` — can't discount more than total
  - `percent` type: `(total × value) / 100`

---

## 📧 Email System — How it Works

### Two email classes in `app/Mail/`:

**`BookingConfirmationMail`:**
- Sent to: Customer's email (stored in `booking.email`)
- Subject: "Booking Confirmation - SwiftRide"
- Template: `resources/views/emails/booking-confirmation.blade.php`
- Data passed: booking, car, user

**`AdminBookingNotificationMail`:**
- Sent to: `ADMIN_EMAIL` env variable (default: `swiftride15@gmail.com`)
- Subject: "New Booking Request - SwiftRide"
- Template: `resources/views/emails/admin-booking-notification.blade.php`
- Special: includes `confirmUrl` and `viewUrl` so admin can act directly from email

### When are emails sent?
Only after **successful payment** (`processPayment` method). Not when booking is created (pending state).

### Test Commands (Artisan):
```bash
php artisan test:email-customer {email}    # Test customer email
php artisan test:email-admin {email?}      # Test admin email  
php artisan test:email-both {customer} {admin?}  # Test both
```

---

## ⭐ Review System — How it Works

### Client submits review (`POST /reviews`):
1. Must be logged in
2. Provides: `booking_id`, `rating` (1-5), optional `comment`
3. Validates booking belongs to logged-in user (ownership check)
4. **Duplicate check:** Has user already reviewed this car after this booking was created?
   - `Review::where('user_id')->where('car_id')->where('created_at', '>=', booking.created_at)->exists()`
5. Creates review with `is_approved = false`
6. Back with "submitted for moderation" message

### Admin moderates reviews (`/admin/reviews`):
- **Approve:** `PATCH /admin/reviews/{id}/approve` → sets `is_approved = true`
- **Delete:** `DELETE /admin/reviews/{id}` → removes it

### Where reviews show up:
- Car detail page: `CarBrowseController@show` loads `car->approvedReviews()->with('user')`
- `Car::averageRating()` calculates average of only approved reviews

---

## 📊 Admin Dashboard — What Data it Shows

`AdminDashboardController@dashboard` builds:

1. **Key Counters:**
   - Total users: `User::count()`
   - Total bookings: `Booking::count()`
   - Total cars: `Car::count()`
   - Total revenue: Sum of `total_price` where status is `confirmed` or `completed`
   - Verified users: `User::where('is_verified', true)->count()`

2. **Recent Bookings Table:** Last 5 bookings with user + car eagerly loaded

3. **Monthly Revenue Chart (last 6 months):**
   - Loops from 5 months ago to now
   - For each month: sums `total_price` of confirmed/completed bookings in that month
   - Returns `months[]` (labels) and `revenueData[]` (values) for a Chart.js bar chart

4. **Car Popularity Pie Chart:**
   - `Booking::join('cars')->groupBy('cars.type')->count()`
   - Returns car types and how many bookings each type has

---

## 📅 Booking Calendar (`/admin/calendar`)

- Fetches all bookings with their car
- Maps each to FullCalendar event format:
  ```php
  [
      'title' => 'Brand Model (UserName)',
      'start' => ISO8601 datetime,
      'end'   => ISO8601 datetime,
      'backgroundColor' => color based on status,
      'url'   => link to booking detail
  ]
  ```
- Colors: green=confirmed, yellow=pending, blue=completed, red=cancelled

---

## 📋 Reports Page (`/admin/reports`)

`AdminReportController@reports` does:
1. **Auto-completes expired bookings first:**
   - `Booking::autoCompleteExpiredBookings()` — finds all non-completed bookings where `end_datetime < now()` and sets them to `completed`
2. Shows: total users, completed rides count, total revenue
3. Shows: 5 most recent rides

---

## 👤 User Management (Admin)

### User Verification:
- Client uploads driving license when editing profile
- File stored at `storage/app/public/licenses/`
- When license uploaded: `is_verified = false` (needs re-verification)
- Admin goes to `/admin/users` → clicks Verify → sets `is_verified = true`

### User Deletion:
- `DELETE /admin/users/{id}` → deletes user record
- Because `user_id` in bookings has `onDelete('cascade')` — all their bookings deleted too

---

## 🚘 Car Management (Admin CRUD)

All via `CarController` which is a full Laravel resource controller:

| Action | Route | What it does |
|---|---|---|
| `index` | `GET /admin/cars` | List all cars |
| `create` | `GET /admin/cars/create` | Show add form |
| `store` | `POST /admin/cars` | Validate + save + upload image |
| `show` | `GET /admin/cars/{id}` | View single car |
| `edit` | `GET /admin/cars/{id}/edit` | Show edit form |
| `update` | `PUT /admin/cars/{id}` | Update car fields + optional new image |
| `destroy` | `DELETE /admin/cars/{id}` | Delete car |

Image upload: stored in `storage/app/public/cars/` via `$request->file('image')->store('cars', 'public')`

---

## 🏆 Loyalty Points System

| Tier | Points Required |
|---|---|
| Silver | Default (0–4,999 points) |
| Gold | 5,000+ points |
| Platinum | 15,000+ points |

**Earning points:** 1 point per ₹100 spent → `floor(total_price / 100)`

Example: ₹8,500 booking → 85 points earned

Points are added to `users.loyalty_points` immediately after payment is processed.

---

## 🌐 Public Pages (No Auth Required)

| Route | Controller | What it does |
|---|---|---|
| `GET /` | `HomeController@index` | Home page with latest 4 cars |
| `GET /about` | View directly | About page |
| `GET /contact` | View directly | Contact form page |
| `POST /contact` | `ContactController@submit` | Saves to `contacts` table |
| `GET /cars` | `CarBrowseController@index` | Browse all available cars |
| `GET /car/{id}` | `CarBrowseController@show` | Car detail + approved reviews |

---

## 📝 Contact Form Flow

1. User fills: name, email, issue_type, message
2. `ContactController@submit` validates all fields
3. `Contact::create(...)` saves to `contacts` table
4. Back with flash success message

Admin reads these at `/admin/messages` via `MessageController@index` which fetches all Contact records ordered by newest.

---

## 🔑 Profile Management (Client)

`GET /profile/edit` → Shows edit form with current user data

`PATCH /profile/update` → Uses `ProfileUpdateRequest` for validation:
- Updates name, email, phone
- If email changed → clears `email_verified_at` (needs re-verify)
- If driving license uploaded → stores file + sets `is_verified = false` (needs admin re-verify)

`DELETE /profile/delete` → Requires password confirmation:
- Validates `password` matches current
- Logs out user
- Deletes user record
- Invalidates session
- Redirects to home

---

## 🔗 Models and Their Relationships

```php
// User
$user->bookings()   // hasMany Booking
$user->reviews()    // hasMany Review

// Booking  
$booking->user()    // belongsTo User
$booking->car()     // belongsTo Car
$booking->revenues() // hasMany Revenue

// Car
$car->reviews()          // hasMany Review
$car->approvedReviews()  // hasMany Review (where is_approved = true)
$car->averageRating()    // Returns rounded avg of approved reviews (0 if none)

// Review
$review->user()  // belongsTo User
$review->car()   // belongsTo Car
```

---

## ⚙️ Key Business Logic Methods

### `hasConflict($carId, $start, $end)` — in Client/BookingController
The most critical function. Called 3 times during booking flow.

```
Adjusted window = (start - 8 hours) to (end + 8 hours)

A conflict exists if ANY non-cancelled booking for the car:
  - starts within the adjusted window, OR
  - ends within the adjusted window, OR  
  - fully covers the adjusted window (starts before + ends after)
```

### `autoCompleteExpiredBookings()` — on Booking model
Static method. Updates all bookings where:
- `status != 'completed'`
- `end_datetime < now()`
Sets them to `completed`. Called whenever `/admin/reports` loads.

### `Coupon::isValid($amount)`
Returns `false` if:
- Coupon is inactive (`is_active = false`)
- Expiry date exists and is in the past
- Booking amount < minimum required amount

### `Coupon::calculateDiscount($amount)`
- `fixed` type: Returns `min(coupon.value, amount)` — can't exceed total
- `percent` type: Returns `(amount × value) / 100`

---

## 🛠️ Artisan / Console Commands

Defined in `routes/console.php`:

```bash
# Send test customer confirmation email
php artisan test:email-customer someone@gmail.com

# Send test admin notification email
php artisan test:email-admin admin@example.com

# Send both emails at once
php artisan test:email-both customer@gmail.com admin@example.com
```

These create a temporary test booking using first user + first car in DB, send the email, and report success/failure.

---

## 🏛️ Architecture Decisions (Why We Did Things This Way)

### Why two guards (`web` and `admin`) instead of role-based middleware only?
Two guards give completely separate sessions. Admin can be on admin panel while being a different logged-in entity than client guard. Cleaner separation.

### Why is role 'user' in DB but treated as 'client' in code?
Historical: The original migration used 'user'. Later in code we call them 'clients'. The `EnsureClientRole` middleware checks `role !== 'user'` to be consistent with DB.

### Why does the booking store contact info (name, email, phone)?
The booking record stores a snapshot of contact info at time of booking. Even if user later changes profile, the booking record retains what was true at booking time.

### Why 3 conflict checks during booking flow?
Race condition protection: Between steps, another user could book the same car. Each step re-validates to prevent double-booking.

### Why auto-complete in reports page instead of a scheduled job?
Simple approach for a non-production app. In production you'd use `php artisan schedule:run` with a scheduled command. Currently runs every time admin opens reports.

### Why store coupon_code as string in booking instead of FK to coupons?
A coupon snapshot — if coupon is later deleted, booking history still shows what code was used.

### Why no payment gateway?
SwiftRide simulates payment — clicking "Pay Now" immediately marks booking as confirmed and records revenue. This is intentional for a demo/project app.

---

## 📦 Important Dependencies

| Package | Purpose |
|---|---|
| `laravel/framework:^12` | Core framework |
| `laravel/breeze:^2.3` | Auth scaffolding (password reset, email verify) |
| `yajra/laravel-datatables-oracle:^12.3` | Server-side DataTables for booking lists |
| `laravel/tinker` | REPL for debugging |

---

## 🔄 Request Validation Summary

Every form submission in this app goes through Laravel validation before touching the database. Key validation rules:

| Field | Common Rules |
|---|---|
| email | `required\|email\|unique:users,email` (registration) |
| password | `required\|min:6\|confirmed` |
| car_id | `required\|exists:cars,id` |
| pickup_city | `required\|in:Rajkot,Ahmedabad,Vadodara,Surat,Jamnagar` |
| start_date | `required\|date` |
| end_date | `required\|date\|after_or_equal:start_date` |
| image | `nullable\|image\|mimes:jpeg,png,jpg,gif\|max:2048` |
| coupon_code | `nullable\|string\|exists:coupons,code` |
| rating | `required\|integer\|min:1\|max:5` |

---

## 🚀 How to Run the Project Locally

```bash
# Clone and install
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations (creates SQLite tables)
php artisan migrate

# Start all servers at once (server + queue + vite)
composer run dev

# OR manually:
php artisan serve          # Backend at localhost:8000
npm run dev                # Vite for frontend assets
```

For emails, set SMTP credentials in `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS=your@gmail.com
ADMIN_EMAIL=admin@example.com
```

---

## 🧠 Quick Answer Reference

**Q: How does login work?**
> Two separate guards. Client uses `Auth::guard('web')`, admin uses `Auth::guard('admin')`. Both check against same `users` table but filter by `role`.

**Q: How are routes protected?**
> Middleware: `EnsureClientRole` for clients, `AdminMiddleware` for admins. Both check the correct guard and verify the role.

**Q: How does booking conflict detection work?**
> For every car, we check existing non-cancelled bookings. We add 8-hour buffer to the requested window and check for any overlap using three overlap conditions.

**Q: How does the coupon system work?**
> Admin creates coupon with code, type (fixed/percent), value, min amount. Client enters code → server validates → discount calculated → final price saved in booking.

**Q: What happens when payment is processed?**
> Booking confirmed → Revenue record created → Loyalty points earned → Two emails sent (customer confirmation + admin notification).

**Q: How are reviews moderated?**
> Client submits → `is_approved = false` → Admin approves → Appears publicly. Prevents spam/fake reviews.

**Q: What is the revenue table for?**
> It tracks every money movement. Payment creates a positive record. Cancellation creates a negative (refund) record. This makes financial reporting accurate.

**Q: How does auto-complete for bookings work?**
> `Booking::autoCompleteExpiredBookings()` is a static method that bulk-updates all non-completed bookings past their end time to 'completed'. Called on reports page load.
