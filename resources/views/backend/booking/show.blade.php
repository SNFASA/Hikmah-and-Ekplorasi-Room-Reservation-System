@extends('backend.layouts.master')
@section('title', 'View Booking')
@section('main-content')

<div class="container mt-4">
    <div class="card shadow">
        <h5 class="card-header">Booking Details</h5>
        <div class="card-body">

            <!-- Booking Info -->
            <div class="row mb-3">
                <div class="col-md-6"><strong>Purpose:</strong> {{ $booking->purpose }}</div>
                <div class="col-md-6"><strong>Phone Number:</strong> {{ $booking->phone_number }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Date:</strong> {{ $booking->booking_date }}</div>
                <div class="col-md-4"><strong>Time Start:</strong> {{ $booking->booking_time_start }}</div>
                <div class="col-md-4"><strong>Time End:</strong> {{ $booking->booking_time_end }}</div>
            </div>

            <hr>

            <!-- Room Info -->
            <h5 class="card-header">Room Info</h5>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Room Name:</strong> {{ $booking->room->name ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Room Type:</strong> {{ $booking->room->type_room ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Status:</strong> {{ $booking->room->status ?? 'N/A' }}</div>
            </div>

            <!-- Furnitures -->
            <h6 class="mt-3">Furnitures</h6>
            <ul class="mb-3">
                @forelse($booking->room->furnitures as $furniture)
                    <li>{{ $furniture->name }}</li>
                @empty
                    <li>No furnitures assigned.</li>
                @endforelse
            </ul>

            <!-- Electronics -->
            <h6>Electronics</h6>
            <ul class="mb-3">
                @forelse($booking->room->electronics as $electronic)
                    <li>{{ $electronic->name }} ({{ $electronic->category }})</li>
                @empty
                    <li>No electronics assigned.</li>
                @endforelse
            </ul>

            <hr>

            <!-- Student Info -->
            <h5 class="card-header">Students</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Matriks</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->listStudentBookings as $student)
                            <tr>
                                <td>{{ $student->no_matriks }}</td>
                                <td>{{ $student->user->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2">No students found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
