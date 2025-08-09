@extends('backend.layouts.master')
@section('title', 'Booking Edit')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-edit me-2"></i>
                        Edit Booking
                    </h2>
                    <p class="text-muted mb-0">Update booking details and student information</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-primary text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-edit me-1"></i>
                        Editing Mode
                    </div>
                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-id-badge me-1"></i>
                        ID: #{{ $booking->id }}
                    </div>
                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card booking-edit-card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-cog me-2"></i>
                                Booking Update Configuration
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Modify booking details, schedule, and student information
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="creation-info">
                                <small class="d-block opacity-75">Last Updated:</small>
                                <strong>{{ $booking->updated_at ? $booking->updated_at->format('M d, Y H:i') : 'Never' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body bg-light p-4">
                    <form method="POST" action="{{ route('bookings.update', $booking->id) }}" id="booking-form">
                        @csrf
                        @method('PATCH')

                        <!-- Step 1: Basic Booking Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Basic Booking Information
                                </h6>
                                <p class="text-muted mb-0 small">Update the basic details for the booking</p>
                            </div>

                            <div class="row g-4">
                                <!-- Purpose -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="inputpurpose"
                                            type="text"
                                            name="purpose"
                                            class="form-control form-control-modern @error('purpose') is-invalid @enderror"
                                            placeholder="Enter purpose"
                                            value="{{ $booking->purpose }}"
                                            required
                                        >
                                        <label for="inputpurpose">
                                            <i class="fas fa-bullseye me-2"></i>
                                            Purpose <span class="text-danger">*</span>
                                        </label>
                                        @error('purpose')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="inputPhoneNumber"
                                            type="text"
                                            name="phone_number"
                                            class="form-control form-control-modern @error('phone_number') is-invalid @enderror"
                                            placeholder="Enter phone number"
                                            value="{{ $booking->phone_number }}"
                                            required
                                        >
                                        <label for="inputPhoneNumber">
                                            <i class="fas fa-phone me-2"></i>
                                            Phone Number <span class="text-danger">*</span>
                                        </label>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <!-- Room Selection -->
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <select name="no_room" id="no_room" class="form-control form-control-modern @error('no_room') is-invalid @enderror">
                                            <option value="">-- Select Room --</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->no_room }}" {{ $booking->no_room == $room->no_room ? 'selected' : '' }}>
                                                    {{ $room->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="no_room">
                                            <i class="fas fa-door-open me-2"></i>
                                            Room
                                        </label>
                                        @error('no_room')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Schedule Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Schedule Information
                                </h6>
                                <p class="text-muted mb-0 small">Update the date and time for the booking</p>
                            </div>

                            <div class="row g-4">
                                <!-- Booking Date -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input
                                            id="flatpickrDate"
                                            type="text"
                                            name="booking_date"
                                            class="form-control form-control-modern @error('booking_date') is-invalid @enderror"
                                            placeholder="Select date"
                                            value="{{ $booking->booking_date }}"
                                            required
                                        >
                                        <label for="flatpickrDate">
                                            <i class="fas fa-calendar me-2"></i>
                                            Date <span class="text-danger">*</span>
                                        </label>
                                        @error('booking_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Start Time -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input
                                            id="flatpickrTimeStart"
                                            type="text"
                                            name="booking_time_start"
                                            class="form-control form-control-modern @error('booking_time_start') is-invalid @enderror"
                                            placeholder="Select start time"
                                            value="{{ $booking->booking_time_start }}"
                                            required
                                        >
                                        <label for="flatpickrTimeStart">
                                            <i class="fas fa-clock me-2"></i>
                                            Start Time <span class="text-danger">*</span>
                                        </label>
                                        @error('booking_time_start')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- End Time -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input
                                            id="flatpickrTimeEnd"
                                            type="text"
                                            name="booking_time_end"
                                            class="form-control form-control-modern @error('booking_time_end') is-invalid @enderror"
                                            placeholder="Select end time"
                                            value="{{ $booking->booking_time_end }}"
                                            required
                                        >
                                        <label for="flatpickrTimeEnd">
                                            <i class="fas fa-clock me-2"></i>
                                            End Time <span class="text-danger">*</span>
                                        </label>
                                        @error('booking_time_end')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Student Management -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">3</span>
                                    Student Management
                                </h6>
                                <p class="text-muted mb-0 small">Update students for this booking (minimum 4 required)</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-dark mb-0">
                                            <i class="fas fa-users me-2 text-primary"></i>
                                            Student List
                                            <span class="badge selected-count-warning rounded-pill ms-2">
                                                <span id="studentCount">{{ count($selectedStudents) }}</span> / 10 students
                                            </span>
                                        </h6>
                                        <button type="button" id="add-student" class="btn btn-success btn-lg rounded-pill px-4">
                                            <i class="fas fa-user-plus me-2"></i>
                                            Add Student
                                        </button>
                                    </div>

                                    <div id="students-list" class="student-entries">
                                        @foreach($selectedStudents as $index => $student)
                                            <div class="student-entry card mb-3 border-0 bg-light">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h6 class="mb-0 text-primary fw-semibold">
                                                            <i class="fas fa-user me-2"></i>
                                                            Student #{{ $index + 1 }}
                                                        </h6>
                                                        @if($index > 0)
                                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill remove-student">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="form-floating">
                                                                <input
                                                                    type="text"
                                                                    name="students[{{ $index }}][no_matriks]"
                                                                    class="form-control form-control-modern"
                                                                    placeholder="No Matriks"
                                                                    value="{{ $student->no_matriks }}"
                                                                    required
                                                                >
                                                                <label>
                                                                    <i class="fas fa-id-card me-2"></i>
                                                                    No Matriks <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating">
                                                                <input
                                                                    type="text"
                                                                    name="students[{{ $index }}][name]"
                                                                    class="form-control form-control-modern"
                                                                    placeholder="Name"
                                                                    value="{{ $student->name ?? '' }}"
                                                                    required
                                                                >
                                                                <label>
                                                                    <i class="fas fa-user me-2"></i>
                                                                    Name <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="alert alert-warning rounded-3 mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Note:</strong> You must have at least 4 students to proceed with the booking. Maximum 10 students allowed.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions fade-in">
                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                                        <div class="form-summary">
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Update Booking?</h6>
                                            <p class="mb-0 text-muted small">Review your changes before updating the booking</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('bookings.index') }}"
                                               class="btn btn-outline-danger btn-lg rounded-pill px-4 shadow-sm">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                Back
                                            </a>
                                            <button type="reset"
                                                    class="btn btn-outline-warning btn-lg rounded-pill px-4 shadow-sm"
                                                    id="resetBtn">
                                                <i class="fas fa-undo-alt me-2"></i>
                                                Reset
                                            </button>
                                            <button class="btn btn-success btn-lg rounded-pill px-4 shadow-sm"
                                                    type="submit"
                                                    id="submitBtn">
                                                <span class="btn-text">
                                                    <i class="fas fa-save me-2"></i>
                                                    Update Booking
                                                </span>
                                                <span class="btn-spinner d-none">
                                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                                    Updating...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Tips Card -->
    <div class="row justify-content-center mt-4">
        <div class="col-xl-10 col-lg-12">
            <div class="card border-0 bg-primary bg-opacity-10 rounded-3">
                <div class="card-body p-4">
                    <h6 class="text-white fw-bold mb-3">
                        <i class="fas fa-lightbulb me-2"></i>
                        Booking Edit Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-save text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Save Changes</div>
                                    <small class="text-white">Don't forget to update after making changes</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Student Requirement</div>
                                    <small class="text-white">Minimum 4 students, maximum 10 students</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Time Validation</div>
                                    <small class="text-white">End time must be after start time</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log('Booking Edit Form initializing...');

    // Initialize date and time pickers
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    flatpickr("#flatpickrTimeStart", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minuteIncrement: 15
    });

    flatpickr("#flatpickrTimeEnd", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minuteIncrement: 15
    });

    // Store original values for reset functionality
    const originalValues = {
        purpose: $('#inputpurpose').val(),
        phone_number: $('#inputPhoneNumber').val(),
        no_room: $('#no_room').val(),
        booking_date: $('#flatpickrDate').val(),
        booking_time_start: $('#flatpickrTimeStart').val(),
        booking_time_end: $('#flatpickrTimeEnd').val(),
        students: []
    };

    // Store original student data
    $('#students-list .student-entry').each(function(index) {
        originalValues.students.push({
            no_matriks: $(this).find('input[name*="no_matriks"]').val(),
            name: $(this).find('input[name*="name"]').val()
        });
    });

    // Update student counter
    function updateStudentCounter() {
        const count = $('#students-list .student-entry').length;
        $('#studentCount').text(count);
        
        // Update add button state
        if (count >= 10) {
            $('#add-student').prop('disabled', true).text('Maximum Reached');
        } else {
            $('#add-student').prop('disabled', false).html('<i class="fas fa-user-plus me-2"></i>Add Student');
        }
        
        console.log('Student count updated:', count);
    }

    // Add student functionality
    $('#add-student').on('click', function() {
        const studentsList = $('#students-list');
        const count = studentsList.find('.student-entry').length;

        if (count >= 10) {
            showNotification('You can only add a maximum of 10 students.', 'warning');
            return;
        }

        const studentNumber = count + 1;
        const studentEntry = `
            <div class="student-entry card mb-3 border-0 bg-light fade-in">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 text-primary fw-semibold">
                            <i class="fas fa-user me-2"></i>
                            Student #${studentNumber}
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill remove-student">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    name="students[${count}][no_matriks]"
                                    class="form-control form-control-modern"
                                    placeholder="No Matriks"
                                    required
                                >
                                <label>
                                    <i class="fas fa-id-card me-2"></i>
                                    No Matriks <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    name="students[${count}][name]"
                                    class="form-control form-control-modern"
                                    placeholder="Name"
                                    required
                                >
                                <label>
                                    <i class="fas fa-user me-2"></i>
                                    Name <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        studentsList.append(studentEntry);
        updateStudentCounter();
        showNotification(`Student #${studentNumber} added successfully!`, 'success');
    });

    // Remove student functionality (using event delegation)
    $(document).on('click', '.remove-student', function() {
        const studentEntry = $(this).closest('.student-entry');
        const studentNumber = studentEntry.find('h6').text().match(/\d+/)[0];
        
        studentEntry.fadeOut(300, function() {
            $(this).remove();
            updateStudentCounter();
            renumberStudents();
            showNotification(`Student #${studentNumber} removed`, 'info');
        });
    });

    // Renumber students after removal
    function renumberStudents() {
        $('#students-list .student-entry').each(function(index) {
            const studentNumber = index + 1;
            
            // Update student number in header
            $(this).find('h6').html(`<i class="fas fa-user me-2"></i>Student #${studentNumber}`);
            
            // Update input names
            $(this).find('input[name*="no_matriks"]').attr('name', `students[${index}][no_matriks]`);
            $(this).find('input[name*="name"]').attr('name', `students[${index}][name]`);
        });
    }

    // Form validation
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Basic field validation
        if (!$('#inputpurpose').val().trim()) {
            errors.push('Purpose is required');
            isValid = false;
        }

        if (!$('#inputPhoneNumber').val().trim()) {
            errors.push('Phone number is required');
            isValid = false;
        }

        if (!$('#flatpickrDate').val()) {
            errors.push('Booking date is required');
            isValid = false;
        }

        if (!$('#flatpickrTimeStart').val()) {
            errors.push('Start time is required');
            isValid = false;
        }

        if (!$('#flatpickrTimeEnd').val()) {
            errors.push('End time is required');
            isValid = false;
        }

        // Time validation
        const startTime = $('#flatpickrTimeStart').val();
        const endTime = $('#flatpickrTimeEnd').val();
        
        if (startTime && endTime && startTime >= endTime) {
            errors.push('End time must be after start time');
            isValid = false;
        }

        // Student validation
        const studentCount = $('#students-list .student-entry').length;
        if (studentCount < 4) {
            errors.push('You must have at least 4 students before submitting the form');
            isValid = false;
        }

        // Validate student fields
        let emptyStudentFields = false;
        $('#students-list .student-entry').each(function() {
            const noMatriks = $(this).find('input[name*="no_matriks"]').val().trim();
            const name = $(this).find('input[name*="name"]').val().trim();
            
            if (!noMatriks || !name) {
                emptyStudentFields = true;
                return false;
            }
        });

        if (emptyStudentFields) {
            errors.push('All student fields must be filled');
            isValid = false;
        }

        if (!isValid) {
            showValidationErrors(errors);
        }

        return isValid;
    }

    // Show validation errors
    function showValidationErrors(errors) {
        $('.validation-alert').remove();

        const alertHtml = `
            <div class="alert alert-danger validation-alert fade-in" role="alert">
                <h6 class="alert-heading mb-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Please fix the following errors:
                </h6>
                <ul class="mb-0">
                    ${errors.map(error => `<li>${error}</li>`).join('')}
                </ul>
            </div>
        `;

        $('#booking-form').before(alertHtml);

        // Auto-remove alert after 7 seconds
        setTimeout(() => {
            $('.validation-alert').fadeOut(300, function() {
                $(this).remove();
            });
        }, 7000);

        // Scroll to alert
        $('.validation-alert')[0].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }

    // Show notification function
    function showNotification(message, type = 'success') {
        const alertClass = type === 'success' ? 'alert-success' :
                          type === 'error' ? 'alert-danger' :
                          type === 'warning' ? 'alert-warning' : 'alert-info';
        
        const icon = type === 'success' ? 'fa-check-circle' :
                    type === 'error' ? 'fa-exclamation-triangle' :
                    type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show notification-alert position-fixed"
                 style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" role="alert">
                <i class="fas ${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Remove existing notifications
        $('.notification-alert').remove();

        // Add new notification
        $('body').append(alertHtml);

        // Auto-remove after 3 seconds
        setTimeout(() => {
            $('.notification-alert').fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    // Form submission
    $('#booking-form').on('submit', function(e) {
        console.log('Form submitted');
        
        const btnText = $('#submitBtn .btn-text');
        const btnSpinner = $('#submitBtn .btn-spinner');
        
        // Show loading state
        btnText.addClass('d-none');
        btnSpinner.removeClass('d-none');
        $('#submitBtn').prop('disabled', true);
        
        // Validate form
        if (!validateForm()) {
            e.preventDefault();
            // Reset button state
            btnText.removeClass('d-none');
            btnSpinner.addClass('d-none');
            $('#submitBtn').prop('disabled', false);
            return;
        }
    });

    // Reset form to original values
    $('#resetBtn').on('click', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
            // Reset basic fields
            $('#inputpurpose').val(originalValues.purpose);
            $('#inputPhoneNumber').val(originalValues.phone_number);
            $('#no_room').val(originalValues.no_room);
            $('#flatpickrDate').val(originalValues.booking_date);
            $('#flatpickrTimeStart').val(originalValues.booking_time_start);
            $('#flatpickrTimeEnd').val(originalValues.booking_time_end);
            
            // Reset students list
            const studentsHtml = originalValues.students.map((student, index) => {
                const removeButton = index > 0 ? `
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill remove-student">
                        <i class="fas fa-times"></i>
                    </button>
                ` : '';
                
                return `
                    <div class="student-entry card mb-3 border-0 bg-light">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 text-warning fw-semibold">
                                    <i class="fas fa-user me-2"></i>
                                    Student #${index + 1}
                                </h6>
                                ${removeButton}
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            name="students[${index}][no_matriks]"
                                            class="form-control form-control-modern"
                                            placeholder="No Matriks"
                                            value="${student.no_matriks}"
                                            required
                                        >
                                        <label>
                                            <i class="fas fa-id-card me-2"></i>
                                            No Matriks <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            name="students[${index}][name]"
                                            class="form-control form-control-modern"
                                            placeholder="Name"
                                            value="${student.name}"
                                            required
                                        >
                                        <label>
                                            <i class="fas fa-user me-2"></i>
                                            Name <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            
            $('#students-list').html(studentsHtml);
            updateStudentCounter();
            showNotification('Form has been reset to original values', 'info');
        }
    });

    // Animate elements on page load
    setTimeout(() => {
        $('.card, .form-section').each(function(index) {
            const element = $(this);
            setTimeout(() => {
                element.addClass('fade-in');
            }, index * 100);
        });
    }, 100);

    // Initialize counter
    updateStudentCounter();

    console.log('Booking Edit Form initialized successfully');
    console.log('Original values stored:', originalValues);
});
</script>
@endpush