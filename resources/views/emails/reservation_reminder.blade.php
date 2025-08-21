<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Facility Reservation Reminder</title>
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
        .reservation-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏢 Facility Reservation Reminder</h1>

        <p>Hi {{ $user->name }},</p>

        <p>This is a reminder for your upcoming facility reservation. Below are the details:</p>

        <div class="reservation-details">
            <ul>
                <li><strong>Reservation ID:</strong> #{{ $reservation->id }}</li>
                <li><strong>Purpose/Program:</strong> {{ $reservation->purpose_program_name }}</li>
                @if($reservation->room_id)
                    <li><strong>Room ID:</strong> {{ $reservation->room_id }}</li>
                @endif
                @if($reservation->other_room_description)
                    <li><strong>Room Description:</strong> {{ $reservation->other_room_description }}</li>
                @endif
                <li><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($reservation->start_date)->format('l, F j, Y') }}</li>
                <li><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($reservation->start_time)->format('g:i A') }}</li>
                <li><strong>End Date:</strong> {{ \Carbon\Carbon::parse($reservation->end_date)->format('l, F j, Y') }}</li>
                <li><strong>End Time:</strong> {{ \Carbon\Carbon::parse($reservation->end_time)->format('g:i A') }}</li>
                <li><strong>Duration:</strong> {{ $durationHours }} hour(s)</li>
                <li><strong>Participants:</strong> {{ $reservation->no_of_participants }} ({{ $reservation->participant_category }})</li>
                <li><strong>Event Type:</strong> {{ $reservation->event_type }}</li>
                <li><strong>Status:</strong> 
                    <span style="color: 
                        @if($reservation->status == 'approved') green 
                        @elseif($reservation->status == 'pending') orange 
                        @elseif($reservation->status == 'rejected') red 
                        @else gray @endif">
                        {{ ucfirst($reservation->status) }}
                    </span>
                </li>
            </ul>
        </div>

        <div class="divider"></div>

        <h3 class="section-title">👥 People Involved</h3>
        <ul>
            @forelse($reservationUsers as $person)
                <li>{{ $person->name }} ({{ $person->email }})
                    @if(isset($person->no_matriks) && $person->no_matriks != 'N/A')
                        - {{ $person->no_matriks }}
                    @endif
                </li>
            @empty
                <li>No user data available.</li>
            @endforelse
        </ul>

        <div class="divider"></div>

        <h3 class="section-title">🪑 Furniture Available</h3>
        <ul>
            @forelse($furnitures as $item)
                <li>{{ $item }}</li>
            @empty
                <li>No furniture information available</li>
            @endforelse
        </ul>

        <div class="divider"></div>

        <h3 class="section-title">⚡ Electronics Available</h3>
        <ul>
            @forelse($electronics as $item)
                <li>{{ $item }}</li>
            @empty
                <li>No electronics information available</li>
            @endforelse
        </ul>

        @if($reservation->declaration_accepted)
        <div class="divider"></div>
        <p><strong>✅ Declaration:</strong> Terms and conditions have been accepted</p>
        @endif

        <p style="margin-top: 40px;">
            If you have any questions or need to make changes to your reservation, please contact us immediately.
        </p>

        <p>Thank you,<br><strong>{{ config('app.name') }} Facility Management</strong></p>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This email was sent to you because you are involved in a facility reservation.</p>
        </div>
    </div>
</body>
</html>