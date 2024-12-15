@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system || Booking Create')
@section('main-content')

<div class="card">
    <h5 class="card-header">Add Booking</h5>
    <div class="card-body">
      <form method="post" action="{{ route('bookings.store') }}">
        {{ csrf_field() }}
        
        <!-- Purpose -->
        <div class="form-group">
          <label for="inputpurpose" class="col-form-label">Purpose<span class="text-danger">*</span></label>
          <input id="inputpurpose" type="text" name="purpose" placeholder="Enter purpose" value="{{ old('purpose') }}" class="form-control">
          @error('purpose')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <!-- Date -->
        <div class="form-group">
          <label for="flatpickrDate" class="col-form-label">Date<span class="text-danger">*</span></label>
          <input id="flatpickrDate" type="text" name="booking_date" value="{{ old('booking_date') }}" class="form-control">
          @error('booking_date')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- Start Time -->
        <div class="form-group">
          <label for="flatpickrTime" class="col-form-label">Time Start<span class="text-danger">*</span></label>
          <input id="flatpickrTimeStart" type="text" name="booking_time_start" value="{{ old('booking_time_start') }}" class="form-control">
          @error('booking_time_start')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- End Time -->
        <div class="form-group">
          <label for="flatpickrTime" class="col-form-label">Time End<span class="text-danger">*</span></label>
          <input id="flatpickrTimeEnd" type="text" name="booking_time_end" value="{{ old('booking_time_end') }}" class="form-control">
          @error('booking_time_end')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- Phone Number -->
        <div class="form-group">
          <label for="inputPhoneNumber" class="col-form-label">Phone number<span class="text-danger">*</span></label>
          <input id="inputPhoneNumber" type="text" name="phone_number" placeholder="Enter Phone number" value="{{ old('phone_number') }}" class="form-control">
          @error('phone_number')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <!-- Room Selection -->
        @php
          $rooms = DB::table('rooms')->select('no_room', 'name')->get();
        @endphp
        <div class="form-group">
          <label for="no_room" class="col-form-label">Room</label>
          <select name="no_room" class="form-control">
            <option value="">-----Select Room-----</option>
            @foreach($rooms as $room)
              <option value="{{ $room->no_room }}">{{ $room->name }}</option>
            @endforeach
          </select>
          @error('no_room')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

          <!-- Input for No Matriks -->
          <div id="students-list" class="form-group">
            <div class="form-group">
                <label class="col-form-label">No Matriks:</label>
                <input type="text" name="students[0][no_matriks]" required class="form-control">

                <label for="name[]" class="col-form-label"> Name:</label>
                <input type="text" name="students[0][name]" required class="form-control">
            </div>
          </div>
          <button type="button" id="add-student"class="btn btn-primary" style="margin:10px 0 10px 0">Add Student</button>
          <!-- Hidden Inputs for Form Submission -->
          <div id="students-hidden-inputs"></div>

        
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
          <button class="btn btn-success" type="submit">Submit</button>
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
<script>
    // Initialize Flatpickr for Date
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y", // Example: November 26, 2024
        dateFormat: "Y-m-d", // Format for form submission
    });

    // Initialize Flatpickr for Time Start
    flatpickr("#flatpickrTimeStart", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // 24-hour format
        time_24hr: true,
    });

    // Initialize Flatpickr for Time End
    flatpickr("#flatpickrTimeEnd", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });

    document.getElementById('add-student').addEventListener('click', function() {
    const studentsList = document.getElementById('students-list');
    const count = studentsList.children.length;

    // Check if the number of students is within the allowed range
    if (count >= 10) {
        alert('You can only add a maximum of 10 students.');
        return;
    }

    const studentEntry = document.createElement('div');
    studentEntry.classList.add('student-entry');
    studentEntry.innerHTML = `
      <label class="col-form-label" for="students{${count}][no_matriks]">No Matriks:</label>
      <input type="text" name="students[${count}][no_matriks]" required class="form-control">

      <label for="students[${count}[name]" class="col-form-label"> Name:</label>
      <input type="text" name="students[${count}][name]" required class="form-control">
    `;
    studentsList.appendChild(studentEntry);
});

// Ensure at least 4 students are present before form submission
document.getElementById('your-form-id').addEventListener('submit', function(event) {
    const studentsList = document.getElementById('students-list');
    const count = studentsList.children.length;

    if (count < 4) {
        alert('You must add at least 4 students before submitting the form.');
        event.preventDefault(); // Stop form submission
    }
});

</script>
@endpush
