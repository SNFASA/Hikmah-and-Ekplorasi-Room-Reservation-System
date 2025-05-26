@extends('backend.layouts.master')
@section('title','Booking Create')
@section('main-content')

<div class="card shadow-sm border-0">
    <h5 class="card-header bg-light font-weight-bold text-primary">Add Booking</h5>
    <div class="card-body">
        <form method="POST" action="{{ route('bookings.store') }}" id="booking-form">
            @csrf

            {{-- Purpose --}}
            <div class="form-group">
                <label for="inputpurpose" class="font-weight-semibold">Purpose <span class="text-danger">*</span></label>
                <input type="text" name="purpose" id="inputpurpose" value="{{ old('purpose') }}" class="form-control" placeholder="Enter purpose">
                @error('purpose') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Booking Date --}}
            <div class="form-group">
                <label for="flatpickrDate" class="font-weight-semibold">Date <span class="text-danger">*</span></label>
                <input type="text" name="booking_date" id="flatpickrDate" value="{{ old('booking_date') }}" class="form-control">
                @error('booking_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Start Time --}}
            <div class="form-group">
                <label for="flatpickrTimeStart" class="font-weight-semibold">Start Time <span class="text-danger">*</span></label>
                <input type="text" name="booking_time_start" id="flatpickrTimeStart" value="{{ old('booking_time_start') }}" class="form-control">
                @error('booking_time_start') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- End Time --}}
            <div class="form-group">
                <label for="flatpickrTimeEnd" class="font-weight-semibold">End Time <span class="text-danger">*</span></label>
                <input type="text" name="booking_time_end" id="flatpickrTimeEnd" value="{{ old('booking_time_end') }}" class="form-control">
                @error('booking_time_end') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Phone Number --}}
            <div class="form-group">
                <label for="inputPhoneNumber" class="font-weight-semibold">Phone Number <span class="text-danger">*</span></label>
                <input type="text" name="phone_number" id="inputPhoneNumber" value="{{ old('phone_number') }}" class="form-control" placeholder="Enter phone number">
                @error('phone_number') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Room Selection --}}
            @php
                $rooms = DB::table('rooms')->select('no_room', 'name')->get();
            @endphp
            <div class="form-group">
                <label for="no_room" class="font-weight-semibold">Room</label>
                <select name="no_room" id="no_room" class="form-control">
                    <option value="">----- Select Room -----</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->no_room }}">{{ $room->name }}</option>
                    @endforeach
                </select>
                @error('no_room') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Student List --}}
            <label class="font-weight-semibold d-block mb-2">Students</label>
            <div id="students-list" class="mb-3">
                <div class="form-group">
                    <input type="text" name="students[0][no_matriks]" class="form-control mb-2" placeholder="No Matriks" required>
                    <input type="text" name="students[0][name]" class="form-control" placeholder="Name" required>
                </div>
            </div>
            <button type="button" id="add-student" class="btn btn-primary mb-3 shadow-sm transition w-100 w-sm-auto">
                <i class="fas fa-user-plus mr-1"></i> Add Student
            </button>

            {{-- Action Buttons --}}
            <div class="form-group d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4">
                <a href="{{ route('bookings.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <button type="submit" class="btn btn-success text-white w-100 w-sm-auto shadow-sm transition">
                    <i class="fas fa-check mr-1"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Date picker
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    });

    // Time pickers
    flatpickr("#flatpickrTimeStart", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    flatpickr("#flatpickrTimeEnd", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    // Add student functionality
    document.getElementById('add-student').addEventListener('click', function () {
        const studentsList = document.getElementById('students-list');
        const count = studentsList.querySelectorAll('.form-group').length;

        if (count >= 10) {
            alert('You can only add a maximum of 10 students.');
            return;
        }

        const div = document.createElement('div');
        div.className = 'form-group mt-2';
        div.innerHTML = `
            <input type="text" name="students[${count}][no_matriks]" class="form-control mb-2" placeholder="No Matriks" required>
            <input type="text" name="students[${count}][name]" class="form-control" placeholder="Name" required>
        `;
        studentsList.appendChild(div);
    });

    // Ensure at least 4 students
    document.getElementById('booking-form').addEventListener('submit', function (e) {
        const count = document.querySelectorAll('#students-list .form-group').length;
        if (count < 4) {
            alert('You must add at least 4 students before submitting the form.');
            e.preventDefault();
        }
    });
</script>
@endpush
