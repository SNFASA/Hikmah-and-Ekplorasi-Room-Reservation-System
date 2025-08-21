<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Facility Reservation Status Update</title>
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
        .status-update {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .status-approved {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .status-cancelled {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }
        .status-pending {
            background-color: #cce7ff;
            border: 1px solid #b3d9ff;
            color: #004085;
        }
        .admin-comment {
            background-color: #f1f3f4;
            padding: 15px;
            border-left: 4px solid #007bff;
            border-radius: 4px;
            margin: 15px 0;
        }
        .status-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        @php
            $statusClass = '';
            $statusIcon = '';
            switch($reservation->status) {
                case 'approved':
                    $statusClass = 'status-approved';
                    $statusIcon = '✅';
                    break;
                case 'rejected':
                    $statusClass = 'status-rejected';
                    $statusIcon = '❌';
                    break;
                case 'cancelled':
                    $statusClass = 'status-cancelled';
                    $statusIcon = '⚠️';
                    break;
                default:
                    $statusClass = 'status-pending';
                    $statusIcon = '⏳';
            }
        @endphp

        <h1>🏢 Facility Reservation Status Update</h1>

        <p>Hi {{ $user->name }},</p>

        <p>We're writing to inform you about an update to your facility reservation.</p>

        <div class="status-update {{ $statusClass }}">
            <div class="status-icon">{{ $statusIcon }}</div>
            <h2>Your reservation has been <strong>{{ strtoupper($reservation->status) }}</strong></h2>
            <p><strong>Reservation ID:</strong> #{{ $reservation->id }}</p>
        </div>

        @if($reservation->admin_comment)
        <div class="admin-comment">
            <h4>📝 Message from Administration:</h4>
            <p>{{ $reservation->admin_comment }}</p>
            @if($reservation->admin_updated_at)
                <small><em>Updated on {{ \Carbon\Carbon::parse($reservation->admin_updated_at)->format('F j, Y \a\t g:i A') }}</em></small>
            @endif
        </div>
        @endif

        <div class="divider"></div>

        <h3>📋 Reservation Details</h3>

        <div class="reservation-details">
            <ul>
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
                <li><strong>Current Status:</strong> 
                    <span style="color: 
                        @if($reservation->status == 'approved') green 
                        @elseif($reservation->status == 'pending') orange 
                        @elseif($reservation->status == 'rejected') red 
                        @elseif($reservation->status == 'cancelled') #856404
                        @else gray @endif; font-weight: bold;">
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

        @if($reservation->status == 'approved')
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
        @endif

        <div class="divider"></div>

        @if($reservation->status == 'approved')
            <p><strong>🎉 Congratulations!</strong> Your reservation has been approved. Please arrive on time and follow all facility guidelines.</p>
        @elseif($reservation->status == 'rejected')
            <p><strong>We apologize</strong> that your reservation could not be approved at this time. Please review the admin comments above for more information. You may submit a new reservation if needed.</p>
        @elseif($reservation->status == 'cancelled')
            <p><strong>Your reservation has been cancelled.</strong> If this was unexpected, please contact administration for clarification.</p>
        @else
            <p><strong>Your reservation is currently pending review.</strong> We will notify you once a decision has been made.</p>
        @endif

        <p>If you have any questions or concerns about this status update, please don't hesitate to contact our facility management team.</p>

        <p style="margin-top: 40px;">
            Best regards,<br><strong>{{ config('app.name') }} Facility Management Team</strong>
        </p>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This email was sent to you because your reservation status has been updated.</p>
        </div>
    </div>
</body>
</html>