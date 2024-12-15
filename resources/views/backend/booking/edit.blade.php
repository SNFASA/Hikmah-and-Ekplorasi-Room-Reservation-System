@extends('backend.layouts.master')
@section('title', 'Booking Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Booking</h5>
    <div class="card-body">
        <form method="post" action="{{ route('bookings.update', $booking->id) }}">
            @csrf 
            @method('PATCH')

            <!-- Purpose -->
            <div class="form-group">
                <label for="inputpurpose" class="col-form-label">Purpose<span class="text-danger">*</span></label>
                <input id="inputpurpose" type="text" name="purpose" placeholder="Enter purpose" value="{{ $booking->purpose }}" class="form-control">
                @error('purpose')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Date -->
            <div class="form-group">
                <label for="flatpickrDate" class="col-form-label">Date<span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="booking_date" value="{{ $booking->booking_date }}" class="form-control">
                @error('booking_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Start Time -->
            <div class="form-group">
                <label for="flatpickrTimeStart" class="col-form-label">Time Start<span class="text-danger">*</span></label>
                <input id="flatpickrTimeStart" type="text" name="booking_time_start" value="{{ $booking->booking_time_start }}" class="form-control">
                @error('booking_time_start')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- End Time -->
            <div class="form-group">
                <label for="flatpickrTimeEnd" class="col-form-label">Time End<span class="text-danger">*</span></label>
                <input id="flatpickrTimeEnd" type="text" name="booking_time_end" value="{{ $booking->booking_time_end }}" class="form-control">
                @error('booking_time_end')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="inputPhoneNumber" class="col-form-label">Phone Number<span class="text-danger">*</span></label>
                <input id="inputPhoneNumber" type="text" name="phone_number" placeholder="Enter Phone Number" value="{{ $booking->phone_number }}" class="form-control">
                @error('phone_number')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Room Selection -->
            <div class="form-group">
                <label for="room">Room</label>
                <select name="no_room" class="form-control">
                    <option value="">--Select Room--</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->no_room }}" 
                            {{ $booking->no_room == $room->no_room ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
                @error('no_room')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div id="students-list" class="form-group">
                @foreach($selectedStudents as $index => $student)
                <div class="student-entry">
                    <label>No Matriks:</label>
                    <input type="text" name="students[{{ $index }}][no_matriks]" value="{{ $student->no_matriks }}" class="form-control">
                    <label>Name:</label>
                    <input type="text" name="students[{{ $index }}][name]" value="{{ $student->name ?? '' }}" class="form-control">
                </div>
            @endforeach
            
            </div>
            <button type="button" id="add-student" style="margin:10px 0 10px 0" class="btn btn-primary">Add Student</button>

            <!-- Submit Button -->
            <div class="form-group mb-3">
                <button class="btn btn-success" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    @push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
    // Initialize Flatpickr for the date field
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y", // User-friendly date format
        dateFormat: "Y-m-d", // Format for form submission
    });
    
    // Initialize Flatpickr for time start field
    flatpickr("#flatpickrTimeStart", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // 24-hour format
        time_24hr: true,
    });
    
    // Initialize Flatpickr for time end field
    flatpickr("#flatpickrTimeEnd", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });
    
    // Add student input fields dynamically
    document.getElementById('add-student').addEventListener('click', function() {
        const studentsList = document.getElementById('students-list');
        const count = studentsList.children.length;
    
        // Maximum of 10 students can be added
        if (count >= 10) {
            alert('You can only add a maximum of 10 students.');
            return;
        }
    
        // Create a new student input group
        const studentEntry = document.createElement('div');
        studentEntry.classList.add('student-entry', 'form-group');
        studentEntry.innerHTML = `
            <label class="col-form-label" for="students[${count}][no_matriks]">No Matriks:</label>
            <input type="text" name="students[${count}][no_matriks]" required class="form-control">

            <button type="button" class="btn btn-danger remove-student" style="margin-top: 10px;">Remove</button>

        `;
        studentsList.appendChild(studentEntry);
    
        // Attach event listener to remove button
        studentEntry.querySelector('.remove-student').addEventListener('click', function() {
            studentEntry.remove();
        });
    });
    
    // Ensure at least 4 students are added before form submission
    document.querySelector('form').addEventListener('submit', function(event) {
        const studentsList = document.getElementById('students-list');
        const count = studentsList.children.length;
    
        if (count < 4) {
            alert('You must add at least 4 students before submitting the form.');
            event.preventDefault(); // Prevent form submission
        }
    });
    </script>
    @endpush
    
@endpush