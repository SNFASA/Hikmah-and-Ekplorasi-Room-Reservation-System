@extends('backend.layouts.master')
@section('title', 'Booking Edit')
@section('main-content')

<div class="card shadow-sm border-0">
    <h5 class="card-header bg-light font-weight-bold text-primary">Edit Booking</h5>
    <div class="card-body">
        <form method="post" action="{{ route('bookings.update', $booking->id) }}" id="booking-form">
            @csrf 
            @method('PATCH')

            <!-- Purpose -->
            <div class="form-group">
                <label for="inputpurpose" class="font-weight-semibold">Purpose <span class="text-danger">*</span></label>
                <input id="inputpurpose" type="text" name="purpose" value="{{ $booking->purpose }}" class="form-control" placeholder="Enter purpose">
                @error('purpose') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Date -->
            <div class="form-group">
                <label for="flatpickrDate" class="font-weight-semibold">Date <span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="booking_date" value="{{ $booking->booking_date }}" class="form-control">
                @error('booking_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Start Time -->
            <div class="form-group">
                <label for="flatpickrTimeStart" class="font-weight-semibold">Start Time <span class="text-danger">*</span></label>
                <input id="flatpickrTimeStart" type="text" name="booking_time_start" value="{{ $booking->booking_time_start }}" class="form-control">
                @error('booking_time_start') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- End Time -->
            <div class="form-group">
                <label for="flatpickrTimeEnd" class="font-weight-semibold">End Time <span class="text-danger">*</span></label>
                <input id="flatpickrTimeEnd" type="text" name="booking_time_end" value="{{ $booking->booking_time_end }}" class="form-control">
                @error('booking_time_end') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="inputPhoneNumber" class="font-weight-semibold">Phone Number <span class="text-danger">*</span></label>
                <input id="inputPhoneNumber" type="text" name="phone_number" value="{{ $booking->phone_number }}" class="form-control" placeholder="Enter phone number">
                @error('phone_number') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Room -->
            <div class="form-group">
                <label for="room" class="font-weight-semibold">Room</label>
                <select name="no_room" class="form-control">
                    <option value="">-- Select Room --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->no_room }}" {{ $booking->no_room == $room->no_room ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
                @error('no_room') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Students -->
            <label class="font-weight-semibold d-block mb-2">Students</label>
            <div id="students-list" class="mb-3">
                @foreach($selectedStudents as $index => $student)
                    <div class="student-entry mb-3 border p-3 rounded bg-light position-relative">
                        <input type="text" name="students[{{ $index }}][no_matriks]" value="{{ $student->no_matriks }}" class="form-control mb-2" placeholder="No Matriks" required>
                        <input type="text" name="students[{{ $index }}][name]" value="{{ $student->name ?? '' }}" class="form-control" placeholder="Name" required>
                        <button type="button" class="btn btn-danger btn-sm remove-student position-absolute" style="top:10px; right:10px;"><i class="fas fa-times"></i></button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-student" class="btn btn-primary mb-4 shadow-sm transition w-100 w-sm-auto">
                <i class="fas fa-user-plus mr-1"></i> Add Student
            </button>

            <!-- Action Buttons -->
            <div class="form-group d-flex flex-column flex-sm-row justify-content-end gap-2">
                <a href="{{ route('bookings.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <button class="btn btn-success text-white shadow-sm w-100 w-sm-auto" type="submit">
                    <i class="fas fa-save mr-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    });

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

    function attachRemoveEvent(button) {
        button.addEventListener('click', function () {
            const studentEntry = button.closest('.student-entry');
            studentEntry.remove();
        });
    }

    document.getElementById('add-student').addEventListener('click', function () {
        const studentsList = document.getElementById('students-list');
        const count = studentsList.querySelectorAll('.student-entry').length;

        if (count >= 10) {
            alert('You can only add a maximum of 10 students.');
            return;
        }

        const div = document.createElement('div');
        div.className = 'student-entry mb-3 border p-3 rounded bg-light position-relative';
        div.innerHTML = `
            <input type="text" name="students[${count}][no_matriks]" class="form-control mb-2" placeholder="No Matriks" required>
            <input type="text" name="students[${count}][name]" class="form-control" placeholder="Name" required>
            <button type="button" class="btn btn-danger btn-sm remove-student position-absolute" style="top:10px; right:10px;"><i class="fas fa-times"></i></button>
        `;
        studentsList.appendChild(div);
        attachRemoveEvent(div.querySelector('.remove-student'));
    });

    document.querySelectorAll('.remove-student').forEach(attachRemoveEvent);

    document.getElementById('booking-form').addEventListener('submit', function (e) {
        const count = document.querySelectorAll('#students-list .student-entry').length;
        if (count < 4) {
            alert('You must add at least 4 students before submitting the form.');
            e.preventDefault();
        }
    });
</script>
@endpush
