@extends('backend.layouts.master')
@section('title', 'Schedule Create')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Schedule Management
                    </h2>
                    <p class="text-muted mb-0">Create new schedule booking for room reservations</p>
                </div>
                <div class="d-flex align-items-center">
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
            <div class="card schedule-card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title text-white mb-0 fw-bold">
                                <i class="fas fa-calendar-plus me-2"></i>
                                Schedule Booking Configuration
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Set unavailable dates and times for room management
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body bg-light p-4">
                    <form method="post" action="{{ route('schedule.store') }}" id="scheduleForm">
                        @csrf

                        <!-- Step 1: Date & Time Configuration -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Date & Time Configuration
                                </h6>
                                <p class="text-muted mb-0 small">Select the date and time range when rooms will be unavailable</p>
                            </div>

                            <div class="row g-4">
                                <!-- Date Picker -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input
                                            id="flatpickrDate"
                                            type="text"
                                            name="invalid_date"
                                            value="{{ old('invalid_date') }}"
                                            class="form-control form-control-modern @error('invalid_date') is-invalid @enderror"
                                            placeholder="Select date"
                                            autocomplete="off"
                                        >
                                        <label for="flatpickrDate">
                                            <i class="fas fa-calendar me-2"></i>
                                            Unavailable Date
                                        </label>
                                        @error('invalid_date')
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
                                            name="invalid_time_start"
                                            value="{{ old('invalid_time_start') }}"
                                            class="form-control form-control-modern @error('invalid_time_start') is-invalid @enderror"
                                            placeholder="Start time"
                                            autocomplete="off"
                                        >
                                        <label for="flatpickrTimeStart">
                                            <i class="fas fa-clock me-2"></i>
                                            Start Time
                                        </label>
                                        @error('invalid_time_start')
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
                                            name="invalid_time_end"
                                            value="{{ old('invalid_time_end') }}"
                                            class="form-control form-control-modern @error('invalid_time_end') is-invalid @enderror"
                                            placeholder="End time"
                                            autocomplete="off"
                                        >
                                        <label for="flatpickrTimeEnd">
                                            <i class="fas fa-clock me-2"></i>
                                            End Time
                                        </label>
                                        @error('invalid_time_end')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Room Selection -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Room Selection
                                </h6>
                                <p class="text-muted mb-0 small">Choose which rooms should be affected by this schedule</p>
                            </div>

                            <!-- Apply to All Toggle -->
                            <div class="card border-0 bg-white shadow-sm rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div class="flex-grow-1 me-4">
                                            <label class="fw-bold text-dark mb-2 d-block" for="applyToAll">
                                                <i class="fas fa-globe me-2 text-primary"></i>
                                                Apply to All Rooms
                                            </label>
                                            <div class="text-muted small">
                                                Toggle this option to apply the schedule to all available rooms
                                            </div>
                                        </div>
                                        <div class="form-check form-switch form-switch-lg">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="apply_to_all"
                                                id="applyToAll"
                                                value="1"
                                                {{ old('apply_to_all') ? 'checked' : '' }}
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Room Selector -->
                            <div class="room-selector-container" id="roomSelector">
                                <div class="card border-0 bg-white shadow-sm rounded-3">
                                    <div class="card-header bg-transparent border-0 pb-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold text-dark">
                                                <i class="fas fa-door-open me-2 text-primary"></i>
                                                Select Specific Rooms
                                            </h6>
                                            <div class="selected-count badge bg-primary rounded-pill px-3 py-2">
                                                <span id="selectedCount">0</span> Selected
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3">
                                        <div class="row g-3">
                                            @foreach($rooms as $room)
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="room-card">
                                                        <input
                                                            class="room-checkbox d-none"
                                                            type="checkbox"
                                                            name="no_room[]"
                                                            id="room_{{ $room->no_room }}"
                                                            value="{{ $room->no_room }}"
                                                            {{ in_array($room->no_room, old('no_room', [])) ? 'checked' : '' }}
                                                            {{ old('apply_to_all') ? 'disabled' : '' }}
                                                        >
                                                        <label class="room-label" for="room_{{ $room->no_room }}">
                                                            <div class="room-icon">
                                                                <i class="fas fa-door-closed"></i>
                                                            </div>
                                                            <div class="room-info">
                                                                <div class="room-name">{{ $room->name }}</div>
                                                                <div class="room-details">
                                                                    <span class="room-number-shcedule">Room {{ $room->no_room }}</span>
                                                                    @if(isset($room->capacity))
                                                                        <span class="room-capacity">
                                                                            <i class="fas fa-users me-1"></i>{{ $room->capacity }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="room-status">
                                                                <i class="fas fa-check"></i>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('no_room')
                                            <div class="alert alert-danger mt-3 rounded-3">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                                        <div class="form-summary">
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Submit?</h6>
                                            <p class="mb-0 text-muted small">Review your selections before creating the schedule</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('backend.schedule.index') }}"
                                               class="btn btn-outline-danger btn-lg rounded-pill px-4 shadow-sm">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                Back
                                            </a>
                                            <button
                                                type="reset"
                                                class="btn btn-outline-warning btn-lg rounded-pill px-4 shadow-sm"
                                                id="resetBtn"
                                            >
                                                <i class="fas fa-undo-alt me-2"></i>
                                                Reset Form
                                            </button>
                                            <button
                                                class="btn btn-success btn-lg rounded-pill px-4 shadow-sm"
                                                type="submit"
                                                id="submitBtn"
                                            >
                                                <span class="btn-text">
                                                    <i class="fas fa-check me-2"></i>
                                                    Create Schedule
                                                </span>
                                                <span class="btn-spinner d-none">
                                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                                    Processing...
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
                    <h6 class="text-white  fw-bold mb-3">
                        <i class="fas fa-lightbulb me-2"></i>
                        Quick Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-calendar-check text-white "></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white ">Date Selection</div>
                                    <small class="text-black">Choose future dates for scheduling unavailability</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-clock text-white "></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white ">Time Range</div>
                                    <small class="text-black">End time must be after start time</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-door-open text-white "></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white ">Room Selection</div>
                                    <small class="text-black">Select specific rooms or apply to all</small>
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

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr
    const datePicker = flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: "today",
        theme: "material_blue",
        animate: true,
        onChange: function() {
            updateProgress();
        }
    });

    const startTimePicker = flatpickr("#flatpickrTimeStart", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minuteIncrement: 15,
        defaultHour: 9,
        defaultMinute: 0,
        onChange: function() {
            updateProgress();
        }
    });

    const endTimePicker = flatpickr("#flatpickrTimeEnd", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minuteIncrement: 15,
        defaultHour: 17,
        defaultMinute: 0,
        onChange: function() {
            updateProgress();
        }
    });

    // Form elements
    const applyToAllCheckbox = document.getElementById('applyToAll');
    const roomSelector = document.getElementById('roomSelector');
    const roomCheckboxes = document.querySelectorAll('input[name="no_room[]"]');
    const selectedCountElement = document.getElementById('selectedCount');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetBtn');
    const scheduleForm = document.getElementById('scheduleForm');

    // Toggle room selector
    function toggleRoomSelector() {
        const isChecked = applyToAllCheckbox.checked;
        
        if (isChecked) {
            roomSelector.classList.add('disabled');
            roomCheckboxes.forEach(checkbox => {
                checkbox.disabled = true;
                checkbox.checked = false;
            });
        } else {
            roomSelector.classList.remove('disabled');
            roomCheckboxes.forEach(checkbox => {
                checkbox.disabled = false;
            });
        }
        
        updateSelectedCount();
        updateProgress();
    }

    // Update selected room count
    function updateSelectedCount() {
        if (applyToAllCheckbox.checked) {
            selectedCountElement.textContent = 'All Rooms';
        } else {
            const selectedCount = Array.from(roomCheckboxes).filter(cb => cb.checked).length;
            selectedCountElement.textContent = selectedCount;
        }
    }

    // Update form progress
    function updateProgress() {
        let progress = 0;
        const total = 4; // Total form fields to check

        // Check date
        if (document.getElementById('flatpickrDate').value) progress++;
        
        // Check start time
        if (document.getElementById('flatpickrTimeStart').value) progress++;
        
        // Check end time
        if (document.getElementById('flatpickrTimeEnd').value) progress++;
        
        // Check room selection
        if (applyToAllCheckbox.checked || Array.from(roomCheckboxes).some(cb => cb.checked)) {
            progress++;
        }

        const percentage = (progress / total) * 100;
        document.getElementById('formProgress').style.width = percentage + '%';
    }

    // Event listeners
    applyToAllCheckbox.addEventListener('change', toggleRoomSelector);
    
    roomCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            updateProgress();
            
            // Add animation to the room card
            const roomCard = this.closest('.room-card');
            roomCard.classList.add('fade-in');
            setTimeout(() => roomCard.classList.remove('fade-in'), 500);
        });
    });

    // Form submission with loading state
    scheduleForm.addEventListener('submit', function(e) {
        const btnText = submitBtn.querySelector('.btn-text');
        const btnSpinner = submitBtn.querySelector('.btn-spinner');
        
        // Show loading state
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
        submitBtn.disabled = true;
        
        // Validate form before submission
        if (!validateForm()) {
            e.preventDefault();
            // Reset button state
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
            submitBtn.disabled = false;
            return;
        }
    });

    // Reset form functionality
    resetBtn.addEventListener('click', function() {
        // Reset flatpickr instances
        datePicker.clear();
        startTimePicker.clear();
        endTimePicker.clear();
        
        // Reset checkboxes
        applyToAllCheckbox.checked = false;
        roomCheckboxes.forEach(cb => {
            cb.checked = false;
            cb.disabled = false;
        });
        
        // Reset UI states
        roomSelector.classList.remove('disabled');
        updateSelectedCount();
        updateProgress();
        
        // Add reset animation
        scheduleForm.classList.add('fade-in');
        setTimeout(() => scheduleForm.classList.remove('fade-in'), 500);
    });

    // Form validation function
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Validate date
        const dateValue = document.getElementById('flatpickrDate').value;
        if (!dateValue) {
            errors.push('Please select a date');
            isValid = false;
        }

        // Validate start time
        const startTimeValue = document.getElementById('flatpickrTimeStart').value;
        if (!startTimeValue) {
            errors.push('Please select a start time');
            isValid = false;
        }

        // Validate end time
        const endTimeValue = document.getElementById('flatpickrTimeEnd').value;
        if (!endTimeValue) {
            errors.push('Please select an end time');
            isValid = false;
        }

        // Validate time range
        if (startTimeValue && endTimeValue) {
            const startTime = new Date('2000-01-01 ' + startTimeValue);
            const endTime = new Date('2000-01-01 ' + endTimeValue);
            if (endTime <= startTime) {
                errors.push('End time must be after start time');
                isValid = false;
            }
        }

        // Validate room selection
        if (!applyToAllCheckbox.checked && !Array.from(roomCheckboxes).some(cb => cb.checked)) {
            errors.push('Please select at least one room or apply to all rooms');
            isValid = false;
        }

        // Show errors if any
        if (!isValid) {
            showValidationErrors(errors);
        }

        return isValid;
    }

    // Show validation errors
    function showValidationErrors(errors) {
        // Remove existing error alerts
        const existingAlerts = document.querySelectorAll('.validation-alert');
        existingAlerts.forEach(alert => alert.remove());

        // Create error alert
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

        // Insert alert before the form
        scheduleForm.insertAdjacentHTML('beforebegin', alertHtml);

        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.validation-alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);

        // Scroll to alert
        document.querySelector('.validation-alert').scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (validateForm()) {
                scheduleForm.submit();
            }
        }
        
        // Escape to reset
        if (e.key === 'Escape') {
            resetBtn.click();
        }
    });

    // Auto-save to localStorage (optional)
    function autoSave() {
        const formData = {
            invalid_date: document.getElementById('flatpickrDate').value,
            invalid_time_start: document.getElementById('flatpickrTimeStart').value,
            invalid_time_end: document.getElementById('flatpickrTimeEnd').value,
            apply_to_all: applyToAllCheckbox.checked,
            selected_rooms: Array.from(roomCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value)
        };
        
        localStorage.setItem('scheduleFormData', JSON.stringify(formData));
    }

    // Load auto-saved data
    function loadAutoSaved() {
        const savedData = localStorage.getItem('scheduleFormData');
        if (savedData) {
            try {
                const data = JSON.parse(savedData);
                
                if (data.invalid_date) {
                    datePicker.setDate(data.invalid_date);
                }
                if (data.invalid_time_start) {
                    startTimePicker.setDate(data.invalid_time_start, false, 'H:i');
                }
                if (data.invalid_time_end) {
                    endTimePicker.setDate(data.invalid_time_end, false, 'H:i');
                }
                if (data.apply_to_all) {
                    applyToAllCheckbox.checked = true;
                    toggleRoomSelector();
                }
                if (data.selected_rooms && data.selected_rooms.length > 0) {
                    roomCheckboxes.forEach(cb => {
                        if (data.selected_rooms.includes(cb.value)) {
                            cb.checked = true;
                        }
                    });
                }
                
                updateSelectedCount();
                updateProgress();
            } catch (e) {
                console.warn('Error loading auto-saved data:', e);
            }
        }
    }

    // Auto-save on form changes
    const formInputs = scheduleForm.querySelectorAll('input');
    formInputs.forEach(input => {
        input.addEventListener('change', autoSave);
    });

    // Clear auto-saved data on successful submit
    scheduleForm.addEventListener('submit', function() {
        if (validateForm()) {
            localStorage.removeItem('scheduleFormData');
        }
    });

    // Initialize
    toggleRoomSelector();
    updateProgress();
    
    // Load auto-saved data if available
    // loadAutoSaved(); // Uncomment if you want auto-save functionality

    // Add smooth scroll to form sections on focus
    const formInputsWithLabels = document.querySelectorAll('.form-floating input');
    formInputsWithLabels.forEach(input => {
        input.addEventListener('focus', function() {
            const section = this.closest('.form-section');
            if (section) {
                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Animate elements on page load
    setTimeout(() => {
        document.querySelectorAll('.card, .form-section').forEach((element, index) => {
            setTimeout(() => {
                element.classList.add('fade-in');
            }, index * 100);
        });
    }, 100);

    console.log('Schedule Create Form initialized successfully');
});
</script>
@endpush