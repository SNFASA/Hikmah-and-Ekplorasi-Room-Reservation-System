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

            <!-- Student Selection -->
            <div class="form-group">
                <label for="students-select">Select Student<span class="text-danger">*</span></label>
                <select id="students-select" class="form-control">
                    <option value="">--Select Student/Staff--</option>
                    @foreach($students as $student)
                        @if(!in_array($student->no_matriks, $selectedStudents))
                            <option value="{{ $student->no_matriks }}">{{ $student->name }}</option>
                        @endif
                    @endforeach
                </select>

                @error('students-select')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Selected Students List -->
            <div class="form-group">
                <label for="selected-students">Selected Students</label>
                <ul id="selected-students" class="list-group">
                    @foreach($selectedStudents as $selectedStudent)
                        <li class="list-group-item d-flex justify-content-between" data-item-id="{{ $selectedStudent }}">
                            {{ $students->where('no_matriks', $selectedStudent)->first()->name }}
                            <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="{{ $selectedStudent }}" data-type="student">Remove</button>
                        </li>
                    @endforeach
                </ul>
            </div>
                <button type="button" id="add-selected-student" class="btn btn-primary" >Add Selected Student</button>

            <div id="students-hidden-inputs"></div>

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
        let selectedStudents = @json($selectedStudents);
    
        flatpickr("#flatpickrDate", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
    
        flatpickr("#flatpickrTimeStart", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
        });
    
        flatpickr("#flatpickrTimeEnd", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
        });
    
        $(document).ready(function () {
    
            // Function to check if the number of selected students is within the allowed range
            function validateStudentSelection() {
                if (selectedStudents.length >= 10) {
                    alert('You can select a maximum of 10 students.');
                    $('#add-selected-student').prop('disabled', true); // Disable "Add Student" button
                } else if (selectedStudents.length >= 4) {
                    $('#add-selected-student').prop('disabled', false); // Enable "Add Student" button once 4 are selected
                } else {
                    $('#add-selected-student').prop('disabled', false); // Keep it enabled before 4 students
                }
            }
    
            // Initialize the number of selected students based on existing data
            validateStudentSelection();
    
            // Add student to the selected list when the button is clicked
            $('#add-selected-student').click(function () {
                const selectedItemId = $('#students-select').val();
                const selectedItemText = $('#students-select option:selected').text();
    
                if (selectedItemId) {
                    // Check if the student is already in the list
                    if (!$(`#selected-students li[data-item-id="${selectedItemId}"]`).length) {
                        // Add the student to the list
                        $('#selected-students').append(`
                            <li class="list-group-item d-flex justify-content-between" data-item-id="${selectedItemId}">
                                ${selectedItemText}
                                <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="${selectedItemId}" data-type="student">Remove</button>
                            </li>
                        `);
    
                        // Add hidden input for the student
                        $('#students-hidden-inputs').append(`<input type="hidden" name="students[]" value="${selectedItemId}">`);
    
                        // Remove the student from the select options
                        $(`#students-select option[value="${selectedItemId}"]`).remove();
    
                        // Add student to selectedStudents array
                        selectedStudents.push(selectedItemId);
    
                        // Validate the number of selected students after the addition
                        validateStudentSelection();
                    }
                }
            });
    
            // Remove student from the selected list
            $(document).on('click', '.remove-item', function () {
                const itemId = $(this).data('item-id');
                const itemText = $(this).closest('li').text().trim().replace('Remove', '').trim();
    
                $(this).closest('li').remove();
                $(`input[name="students[]"][value="${itemId}"]`).remove();
    
                // Add the student back to the select options
                $('#students-select').append(`<option value="${itemId}">${itemText}</option>`);
    
                // Remove student from selectedStudents array
                selectedStudents = selectedStudents.filter(id => id !== itemId);
    
                // Validate the number of selected students after removal
                validateStudentSelection();
            });
        });
    </script>
    
@endpush
