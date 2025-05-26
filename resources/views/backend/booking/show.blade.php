@extends('backend.layouts.master')
@section('title', 'View Booking')
@section('main-content')

<style>
    /* Card header distinct style */
    .card-header.custom-header {
        background-color: #007bff; /* Bootstrap primary */
        color: white;
        font-weight: 600;
        position: relative;
        padding-right: 4rem;
    }
    /* Hover effect on card */
    .card.shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.25);
        transition: box-shadow 0.3s ease-in-out;
    }
    /* Action buttons */
    .action-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 2.25rem;
        height: 2.25rem;
        padding: 0;
        border-radius: 50%;
        font-size: 1rem;
        line-height: 1.25;
    }
    /* Responsive label/value pairs row */
    .info-row > div {
        margin-bottom: 0.75rem;
    }
    @media (min-width: 576px) {
        .info-row > div {
            margin-bottom: 0;
        }
    }
</style>

<div class="container mt-4">
    <div class="card shadow">

        <h5 class="card-header custom-header">
            Booking Details
        </h5>

        <div class="card-body">

            <!-- Booking Info -->
            <div class="row info-row mb-3">
                <div class="col-sm-6"><strong>Purpose:</strong> {{ $booking->purpose }}</div>
                <div class="col-sm-6"><strong>Phone Number:</strong> {{ $booking->phone_number }}</div>
            </div>
            <div class="row info-row mb-4">
                <div class="col-sm-4"><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}</div>
                <div class="col-sm-4"><strong>Time Start:</strong> {{ \Carbon\Carbon::parse($booking->booking_time_start)->format('H:i') }}</div>
                <div class="col-sm-4"><strong>Time End:</strong> {{ \Carbon\Carbon::parse($booking->booking_time_end)->format('H:i') }}</div>
            </div>

            <hr>

            <!-- Room Info -->
            <h5 class="card-header custom-header">Room Info</h5>
            <div class="row info-row mb-3 pt-2">
                <div class="col-sm-4"><strong>Room Name:</strong> {{ $booking->room->name ?? 'N/A' }}</div>
                <div class="col-sm-4"><strong>Room Type:</strong> {{ $booking->room->type_room ?? 'N/A' }}</div>
                <div class="col-sm-4"><strong>Status:</strong> {{ $booking->room->status ?? 'N/A' }}</div>
            </div>

            <!-- Furnitures -->
            <h6 class="mt-3">Furnitures</h6>
            <ul class="mb-3 ps-3">
                @forelse($booking->room->furnitures as $furniture)
                    <li>{{ $furniture->name }}</li>
                @empty
                    <li>No furnitures assigned.</li>
                @endforelse
            </ul>

            <!-- Electronics -->
            <h6>Electronics</h6>
            <ul class="mb-3 ps-3">
                @forelse($booking->room->electronics as $electronic)
                    <li>{{ $electronic->name }} ({{ $electronic->category }})</li>
                @empty
                    <li>No electronics assigned.</li>
                @endforelse
            </ul>

            <hr>

            <!-- Student Info -->
            <h5 class="card-header custom-header">Students</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="table-primary">
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
                            <tr><td colspan="2" class="text-center">No students found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination placeholder if needed --}}
            <div class="mt-3 d-flex justify-content-end">
                {{-- Uncomment and adapt if you have pagination --}}
                {{-- {{ $booking->listStudentBookings->links() }} --}}
            </div>

        </div>
    </div>
</div>

@endsection
