<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Booking Reminder</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f6f8fa;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        h1, h2, h3 {
            color: #2c3e50;
            margin-bottom: 12px;
        }
        p {
            line-height: 1.6;
        }
        ul {
            padding-left: 20px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        li {
            margin-bottom: 5px;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 30px;
            color: #555;
        }
        .divider {
            margin: 25px 0;
            border-top: 1px solid #ddd;
        }
        .footer {
            font-size: 12px;
            color: #999;
            line-height: 1.5;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📅 Room Booking Reminder</h1>

        <p>Hi {{ $user->name }},</p>

        <p>This is a friendly reminder for your upcoming room booking. Below are the details:</p>

        <ul>
            <li><strong>Room:</strong> {{ $booking->room->name }}</li>
            <li><strong>Date:</strong> {{ $booking->booking_date }}</li>
            <li><strong>Start Time:</strong> {{ $booking->booking_time_start }}</li>
            <li><strong>End Time:</strong> {{ $booking->booking_time_end }}</li>
            <li><strong>Duration:</strong> {{ $durationHours }} hour(s)</li>
        </ul>

        <div class="divider"></div>

        <h3 class="section-title">👥 Students Involved</h3>
        <ul>
            @forelse($users as $student)
                <li>{{ $student->name }} ({{ $student->no_matriks }})</li>
            @empty
                <li>No student data available.</li>
            @endforelse
        </ul>

        <div class="divider"></div>

        <h3 class="section-title">🪑 Furniture Available</h3>
        <ul>
            @forelse($furnitures as $item)
                <li>{{ $item }}</li>
            @empty
                <li>None</li>
            @endforelse
        </ul>

        <div class="divider"></div>

        <h3 class="section-title">⚡ Electronics Available</h3>
        <ul>
            @forelse($electronics as $item)
                <li>{{ $item }}</li>
            @empty
                <li>None</li>
            @endforelse
        </ul>

        <p style="margin-top: 40px;">Thank you,<br><strong>{{ config('app.name') }}</strong></p>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This email was sent to you because you are a registered user of {{ config('app.name') }}.</p>
        </div>
    </div>
</body>
</html>
