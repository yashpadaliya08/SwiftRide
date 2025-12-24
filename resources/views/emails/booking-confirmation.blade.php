<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - SwiftRide</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .success-badge {
            background-color: #10b981;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0;
        }
        .booking-details {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #6b7280;
        }
        .detail-value {
            color: #111827;
        }
        .car-info {
            background-color: #eff6ff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }
        .total-price {
            background-color: #fef3c7;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .total-price .amount {
            font-size: 28px;
            font-weight: bold;
            color: #d97706;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚗 SwiftRide</h1>
        </div>

        <div style="text-align: center;">
            <div class="success-badge">✓ Booking Confirmed</div>
        </div>

        <h2>Hello {{ $user->name }},</h2>
        <p>Thank you for choosing SwiftRide! Your booking has been successfully confirmed. Below are your booking details:</p>

        <div class="car-info">
            <h3 style="margin-top: 0; color: #1e40af;">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</h3>
            <p style="margin: 5px 0; color: #4b5563;">{{ $car->name }}</p>
            @if($car->color)
                <p style="margin: 5px 0; color: #6b7280;">Color: {{ $car->color }}</p>
            @endif
        </div>

        <div class="booking-details">
            <h3 style="margin-top: 0;">Booking Details</h3>
            
            <div class="detail-row">
                <span class="detail-label">Booking ID:</span>
                <span class="detail-value">#{{ $booking->id }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Pickup Location:</span>
                <span class="detail-value">{{ $booking->pickup_city }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Drop-off Location:</span>
                <span class="detail-value">{{ $booking->dropoff_city }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Pickup Date & Time:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('F d, Y h:i A') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Return Date & Time:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->end_datetime)->format('F d, Y h:i A') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Duration:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->start_datetime)->diffInDays(\Carbon\Carbon::parse($booking->end_datetime)) + 1 }} day(s)</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <span style="padding: 4px 12px; background-color: #dbeafe; color: #1e40af; border-radius: 12px; font-size: 12px; text-transform: uppercase;">
                        {{ ucfirst($booking->status) }}
                    </span>
                </span>
            </div>
        </div>

        <div class="total-price">
            <div style="color: #6b7280; font-size: 14px; margin-bottom: 5px;">Total Amount</div>
            <div class="amount">₹{{ number_format($booking->total_price, 2) }}</div>
        </div>

        <div style="background-color: #fef2f2; padding: 15px; border-radius: 8px; border-left: 4px solid #ef4444; margin: 20px 0;">
            <p style="margin: 0; color: #991b1b;">
                <strong>Note:</strong> Your booking is currently pending confirmation. You will receive another email once the admin confirms your booking.
            </p>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('booking.myBookings') }}" class="button">View My Bookings</a>
        </div>

        <div class="footer">
            <p>If you have any questions, please contact us at <a href="mailto:support@swiftride.com" style="color: #667eea;">support@swiftride.com</a></p>
            <p style="margin-top: 10px;">© {{ date('Y') }} SwiftRide. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

