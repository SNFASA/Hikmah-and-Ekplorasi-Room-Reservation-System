<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Booking Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f8fa;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.05);
        }
        h1, h2 {
            color: #2c3e50;
        }
        ul {
            padding-left: 20px;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }
        .section-title {
            margin-top: 30px;
            font-weight: bold;
            color: #555;
        }
        .divider {
            margin: 20px 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Room Booking Reminder!</h1>

        <p>Hi {{ $user->name }},</p>

        <p>You have an upcoming room booking. Here are the details:</p>

        <ul>
            <li><strong>Room:</strong> {{ $booking->room->name }}</li>
            <li><strong>Date:</strong> {{ $booking->booking_date }}</li>
            <li><strong>Start Time:</strong> {{ $booking->booking_time_start }}</li>
            <li><strong>End Time:</strong> {{ $booking->booking_time_end }}</li>
            <li><strong>Duration:</strong> {{ $durationHours }} hour(s)</li>
        </ul>

        <div class="divider"></div>

        <h3 class="section-title">📚 Students Involved:</h3>
        <ul>
            @foreach($users as $student)
                <li>{{ $student->name }} ({{ $student->no_matriks }})</li>
            @endforeach
        </ul>

        <div class="divider"></div>

        <h3 class="section-title">🪑 Furniture Available:</h3>
        <ul>
            @if(count($furnitures))
                @foreach($furnitures as $item)
                    <li>{{ $item }}</li>
                @endforeach
            @else
                <li>None</li>
            @endif
        </ul>

        <div class="divider"></div>

        <h3 class="section-title">⚡ Electronics Available:</h3>
        <ul>
            @if(count($electronics))
                @foreach($electronics as $item)
                    <li>{{ $item }}</li>
                @endforeach
            @else
                <li>None</li>
            @endif
        </ul>

        <p style="margin-top: 40px;">Thanks,<br>{{ config('app.name') }}</p>
        <p style="font-size: 12px; color: #999;">This is an automated message. Please do not reply.</p>
        <p style="font-size: 12px; color: #999;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        <p style="font-size: 12px; color: #999;">This email was sent to you because you are a registered user of {{ config('app.name') }}.</p>
 
    </div>
</body>
</html>
