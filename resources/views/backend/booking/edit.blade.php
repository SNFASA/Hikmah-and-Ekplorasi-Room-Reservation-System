@extends('backend.layouts.master')
@section('title', 'E-SHOP || Brand Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Brand</h5>
    <div class="card-body">
        <form method="post" action="{{ route('bookings.update', $booking->id) }}">
            @csrf 
            @method('PATCH')
            
            <!-- Purpose -->
            <div class="form-group">
                <label for="inputpurpose" class="col-form-label">Purpose<span class="text-danger">*</span></label>
                <input id="inputpurpose" type="text" name="purpose" placeholder="Enter purpose" value="{{$booking->purpose}}" class="form-control">
                @error('purpose')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <!-- Date -->
            <div class="form-group">
                <label for="flatpickrDate" class="col-form-label">Date<span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="booking_date" value="{{$booking->booking_date}}" class="form-control">
                @error('booking_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Start Time -->
            <div class="form-group">
                <label for="flatpickrTime" class="col-form-label">Time Start<span class="text-danger">*</span></label>
                <input id="flatpickrTimeStart" type="text" name="booking_time_start" value="{{$booking->booking_time_start}}" class="form-control">
                @error('booking_time_start')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- End Time -->
            <div class="form-group">
                <label for="flatpickrTime" class="col-form-label">Time End<span class="text-danger">*</span></label>
                <input id="flatpickrTimeEnd" type="text" name="booking_time_end" value="{{$booking->booking_time_end}}" class="form-control">
                @error('booking_time_end')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="inputPhoneNumber" class="col-form-label">Phone number<span class="text-danger">*</span></label>
                <input id="inputPhoneNumber" type="text" name="phone_number" placeholder="Enter Phone number" value="{{$booking->phone_number}}" class="form-control">
                @error('phone_number')
                    <span class="text-danger">{{$message}}</span>
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

            <!-- Select Student Dropdown -->
            <div class="form-group">
              <label for="students-select">Select Student</label>
              <select id="students-select" class="form-control">
                  <option value="">--Select Student--</option>
                  @foreach($students as $student)
                      @if(!in_array($student->no_matriks, $selectedStudents))
                          <option value="{{ $student->no_matriks }}">{{ $student->name }} (No Matriks: {{ $student->no_matriks }})</option>
                      @endif
                  @endforeach
              </select>
          </div>

            <!-- Selected Students List -->
<div class="form-group">
    <label for="selected-students">Selected Students</label>
    <ul id="selected-students" class="list-group">
        @foreach($selectedStudents as $selectedStudent)
            <li class="list-group-item d-flex justify-content-between" data-item-id="{{ $selectedStudent }}">
                {{ $students->firstWhere('no_matriks', $selectedStudent)->name ?? 'Unknown' }} 
                (No Matriks: {{ $selectedStudent }})
                <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="{{ $selectedStudent }}">Remove</button>
            </li>
            <input type="hidden" name="students[]" value="{{ $selectedStudent }}">
        @endforeach
    </ul>
</div>>

            <!-- Hidden Inputs for Form Submission -->
            <div id="students-hidden-inputs"></div>

            <!-- Add Student Button -->
            <button type="button" id="add-selected-student" class="btn btn-primary" style="margin-bottom: 20px;">Add Student</button>

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
<script>
    // Initialize the array with pre-selected students
    let selectedStudents = @json($selectedStudents);

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
// Function to add a student to the selected list
function addStudentToList(noMatriks, name) {
    const list = document.getElementById('selected-students');
    const listItem = document.createElement('li');
    listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between');
    listItem.setAttribute('data-item-id', noMatriks);
    listItem.innerHTML = `${name} (No Matriks: ${noMatriks})
        <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="${noMatriks}">Remove</button>`;
    
    listItem.querySelector('.remove-item').addEventListener('click', function () {
        removeStudentFromList(noMatriks, listItem); // Remove student from list and array
    });

    list.appendChild(listItem);
    selectedStudents.push(noMatriks); // Add to selectedStudents array
    updateDropdownOptions(); // Update the dropdown options after adding a student
}

// Function to remove a student from the list
function removeStudentFromList(noMatriks, listItem) {
    // Remove from selectedStudents array
    selectedStudents = selectedStudents.filter(student => student !== noMatriks);
    
    // Remove the list item from the DOM
    listItem.remove();

    // Re-enable the student option in the dropdown
    const studentSelect = document.getElementById('students-select');
    const option = studentSelect.querySelector(`option[value="${noMatriks}"]`);
    if (option) {
        option.disabled = false; // Enable the option if it was previously disabled
    }

    // Update hidden inputs for form submission
    updateHiddenInputs();
    updateDropdownOptions(); // Update the dropdown options after removal
}

// Function to update hidden inputs for form submission
function updateHiddenInputs() {
    const hiddenInputsContainer = document.getElementById('students-hidden-inputs');
    hiddenInputsContainer.innerHTML = ""; // Clear previous inputs

    selectedStudents.forEach(noMatriks => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = "hidden";
        hiddenInput.name = "students[]";
        hiddenInput.value = noMatriks;
        hiddenInputsContainer.appendChild(hiddenInput);
    });
}

// Function to update the dropdown options based on selected students
function updateDropdownOptions() {
    const studentSelect = document.getElementById('students-select');
    // Disable the students that are already selected
    Array.from(studentSelect.options).forEach(option => {
        if (selectedStudents.includes(option.value)) {
            option.disabled = true; // Disable the option
        } else {
            option.disabled = false; // Enable the option if not selected
        }
    });
}

// Event delegation for remove buttons
document.getElementById('selected-students').addEventListener('click', function (event) {
    if (event.target && event.target.classList.contains('remove-item')) {
        const listItem = event.target.closest('li');
        const noMatriks = event.target.getAttribute('data-item-id');
        removeStudentFromList(noMatriks, listItem);
    }
});

// Event for adding a student to the list (this can be triggered on the 'Add Student' button click)
document.getElementById('add-selected-student').addEventListener('click', function () {
    const studentSelect = document.getElementById('students-select');
    const selectedOption = studentSelect.options[studentSelect.selectedIndex];

    if (selectedOption && selectedOption.value) {
        const noMatriks = selectedOption.value;
        const name = selectedOption.text;
        
        // Add the student to the list and disable the option
        addStudentToList(noMatriks, name);
        
        // Disable the option in the dropdown
        selectedOption.disabled = true;
    }
});

</script>
@endpush
