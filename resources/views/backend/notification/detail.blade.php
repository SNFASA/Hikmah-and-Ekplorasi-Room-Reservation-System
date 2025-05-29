@extends('backend.layouts.master')
@section('title', 'View Booking')
@section('main-content')

<div class="container mt-4">
    <div class="card shadow-sm mb-4" style="background-color: #f8f9fa;">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Booking Details</h5>
        </div>
        <div class="card-body">
            <!-- Booking Info -->
            <div class="row mb-3">
                <div class="col-md-6 mb-2"><strong>Purpose:</strong> {{ $booking->purpose }}</div>
                <div class="col-md-6 mb-2"><strong>Phone Number:</strong> {{ $booking->phone_number }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 mb-2"><strong>Date:</strong> {{ $booking->booking_date }}</div>
                <div class="col-md-4 mb-2"><strong>Time Start:</strong> {{ $booking->booking_time_start }}</div>
                <div class="col-md-4 mb-2"><strong>Time End:</strong> {{ $booking->booking_time_end }}</div>
            </div>
        </div>
    </div>

    <!-- Room Info -->
    <div class="card shadow-sm mb-4" style="background-color: #f8f9fa;">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Room Info</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 mb-2"><strong>Room Name:</strong> {{ $booking->room->name ?? 'N/A' }}</div>
                <div class="col-md-4 mb-2"><strong>Room Type:</strong> {{ $booking->room->type_room ?? 'N/A' }}</div>
                <div class="col-md-4 mb-2"><strong>Status:</strong> {{ $booking->room->status ?? 'N/A' }}</div>
            </div>

            <!-- Furnitures -->
            <h6 class="font-weight-bold text-secondary">Furnitures</h6>
            <ul class="mb-3">
                @forelse($booking->room->furnitures as $furniture)
                    <li>{{ $furniture->name }}</li>
                @empty
                    <li>No furnitures assigned.</li>
                @endforelse
            </ul>

            <!-- Electronics -->
            <h6 class="font-weight-bold text-secondary">Electronics</h6>
            <ul class="mb-3">
                @forelse($booking->room->electronics as $electronic)
                    <li>{{ $electronic->name }} ({{ $electronic->category }})</li>
                @empty
                    <li>No electronics assigned.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Student Info -->
    <div class="card shadow-sm mb-4" style="background-color: #f8f9fa;">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Students</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped mb-0">
                    <thead class="thead-light">
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
                            <tr>
                                <td colspan="2" class="text-center text-muted">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@push('styles')
<style>
    .card-header h5 {
        font-size: 1.25rem;
    }
    ul {
        padding-left: 1.2rem;
    }
    table th, table td {
        vertical-align: middle;
    }
</style>
@endpush