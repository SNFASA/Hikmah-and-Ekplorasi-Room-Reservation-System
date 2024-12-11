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

        <!-- Select Students -->
        <div class="form-group">
          <label for="students">Student<span class="text-danger">*</span></label>
          <select id="students" name="students[]" class="form-control" >
              <option value="">--Select Student--</option>
              @foreach($students as $student)
                  <option value="{{ $student->no_matriks }}">{{ $student->name }}</option>
              @endforeach
          </select>
          @error('students')
          <span class="text-danger">{{ $message }}</span>
          @enderror
      </div>
        
        <!-- Dynamically Added Students -->
        <div class="form-group">
            <label for="selected-students" class="col-form-label">Selected Students</label>
            <ul id="selected-students" class="list-group">
                <!-- Dynamically added students will appear here -->
            </ul>
        </div>
        
        <!-- Hidden Inputs for Form Submission -->
        <div id="students-hidden-inputs"></div>
        
        <!-- Add Student Button -->
        <button type="button" id="add-selected-student" class="btn btn-primary" style="margin-bottom: 20px;">Add Student</button>
        
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

    // Initialize an empty array to store selected students
    const selectedStudents = [];

    // Event listener for the 'Add Student' button
    document.getElementById('add-selected-student').addEventListener('click', function() {
        const studentSelect = document.getElementById('students');
        
        // Ensure the student select element exists
        if (studentSelect) {
            const selectedOptions = Array.from(studentSelect.selectedOptions);

            selectedOptions.forEach(option => {
                if (!selectedStudents.includes(option.value)) {
                    selectedStudents.push(option.value);
                    addStudentToList(option.value, option.text);
                }
            });

            // Update hidden inputs for form submission
            updateHiddenInputs();
        } else {
            console.error("Student select element not found");
        }
    });

    // Function to add a student to the selected list
    function addStudentToList(noMatriks, name) {
        const list = document.getElementById('selected-students');
        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item');
        listItem.textContent = `${name} (No Matriks: ${noMatriks})`;

        // Remove button to remove student from the list
        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'ml-2');
        removeButton.addEventListener('click', function() {
            selectedStudents.splice(selectedStudents.indexOf(noMatriks), 1);
            listItem.remove();
            updateHiddenInputs();
        });

        listItem.appendChild(removeButton);
        list.appendChild(listItem);
    }

    // Function to update hidden inputs for form submission
    function updateHiddenInputs() {
        const hiddenInputsContainer = document.getElementById('students-hidden-inputs');
        hiddenInputsContainer.innerHTML = ''; // Clear previous hidden inputs

        selectedStudents.forEach(noMatriks => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'students[]';
            hiddenInput.value = noMatriks;
            hiddenInputsContainer.appendChild(hiddenInput);
        });
    }
</script>
@endpush
