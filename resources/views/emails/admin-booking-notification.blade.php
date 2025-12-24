<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking Request - SwiftRide Admin</title>
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
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
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
        .alert-badge {
            background-color: #f59e0b;
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
        .customer-info {
            background-color: #f0fdf4;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #10b981;
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
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 5px 10px;
            font-weight: bold;
        }
        .button-primary {
            background-color: #10b981;
        }
        .button-secondary {
            background-color: #3b82f6;
        }
        .button:hover {
            opacity: 0.9;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .urgent {
            background-color: #fef2f2;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ef4444;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚗 SwiftRide Admin</h1>
        </div>

        <div style="text-align: center;">
            <div class="alert-badge">⚠️ New Booking Request</div>
        </div>

        <h2>New Booking Received</h2>
        <p>A new booking request has been submitted and requires your confirmation. Please review the details below:</p>

        <div class="customer-info">
            <h3 style="margin-top: 0; color: #059669;">Customer Information</h3>
            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span class="detail-value">{{ $user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $user->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">User ID:</span>
                <span class="detail-value">#{{ $user->id }}</span>
            </div>
        </div>

        <div class="car-info">
            <h3 style="margin-top: 0; color: #1e40af;">Vehicle Details</h3>
            <p style="margin: 5px 0;"><strong>{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</strong></p>
            <p style="margin: 5px 0; color: #4b5563;">{{ $car->name }}</p>
            @if($car->color)
                <p style="margin: 5px 0; color: #6b7280;">Color: {{ $car->color }}</p>
            @endif
            <p style="margin: 5px 0; color: #6b7280;">Price per day: ₹{{ number_format($car->price_per_day, 2) }}</p>
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
                    <span style="padding: 4px 12px; background-color: #fef3c7; color: #d97706; border-radius: 12px; font-size: 12px; text-transform: uppercase;">
                        {{ ucfirst($booking->status) }}
                    </span>
                </span>
            </div>
        </div>

        <div class="total-price">
            <div style="color: #6b7280; font-size: 14px; margin-bottom: 5px;">Total Amount</div>
            <div class="amount">₹{{ number_format($booking->total_price, 2) }}</div>
        </div>

        <div class="urgent">
            <p style="margin: 0; color: #991b1b;">
                <strong>Action Required:</strong> Please review and confirm this booking to proceed with the rental.
            </p>
        </div>

        <div class="action-buttons">
            <a href="{{ $confirmUrl }}" class="button button-primary">✓ Confirm Booking</a>
            <a href="{{ $viewUrl }}" class="button button-secondary">View Details</a>
        </div>

        <div style="background-color: #f0f9ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 0; color: #0369a1;">
                <strong>Quick Actions:</strong><br>
                • Click "Confirm Booking" to approve and record revenue<br>
                • Click "View Details" to see full booking information in admin panel
            </p>
        </div>

        <div class="footer">
            <p>This is an automated notification from SwiftRide Admin Panel.</p>
            <p style="margin-top: 10px;">© {{ date('Y') }} SwiftRide. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

