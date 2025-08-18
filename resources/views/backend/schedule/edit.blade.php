@extends('backend.layouts.master')
@section('title', 'Schedule Edit')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-calendar-edit me-2"></i>
                        Edit Schedule
                    </h2>
                    <p class="text-muted mb-0">Modify existing schedule booking for room reservations</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-warning text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-edit me-1"></i>
                        Editing Schedule #{{ $schedule->id }}
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
            <div class="card schedule-card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title text-white mb-0 fw-bold">
                                <i class="fas fa-calendar-check me-2"></i>
                                Schedule Configuration Update
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Modify unavailable dates and times for room management
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="current-schedule-info">
                                <small class="d-block opacity-75">Current Date:</small>
                                <strong>{{ \Carbon\Carbon::parse($schedule->invalid_date)->format('M d, Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body bg-light p-4">
                    <form method="post" action="{{ route('schedule.update', $schedule->id) }}" id="scheduleEditForm">
                        @csrf
                        @method('PATCH')
                        <!-- Step 1: Date & Time Configuration -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Date & Time Configuration
                                </h6>
                                <p class="text-muted mb-0 small">Update the date and time range when rooms will be unavailable</p>
                            </div>

                            <div class="row g-4">
                                <!-- Date Picker -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input
                                            id="flatpickrDate"
                                            type="text"
                                            name="invalid_date"
                                            value="{{ old('invalid_date', $schedule->invalid_date) }}"
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
                                            value="{{ old('invalid_time_start', $schedule->invalid_time_start) }}"
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
                                            value="{{ old('invalid_time_end', $schedule->invalid_time_end) }}"
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
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Room Selection
                                </h6>
                                <p class="text-muted mb-0 small">Update which rooms should be affected by this schedule</p>
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
                                                {{ old('apply_to_all', $schedule->apply_to_all ?? false) ? 'checked' : '' }}
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
                                            <div class="selected-count badge rounded-pill px-3 py-2">
                                                <span id="selectedCount">0</span> Selected
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3">
                                        <div class="row g-3">
                                            @foreach($rooms as $room)
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="room-card {{ (is_array(old('no_room', $scheduleRooms ?? [])) && in_array($room->no_room, old('no_room', $scheduleRooms ?? []))) ? 'selected' : '' }}">
                                                        <input
                                                            class="room-checkbox d-none"
                                                            type="checkbox"
                                                            name="no_room[]"
                                                            id="room_{{ $room->no_room }}"
                                                            value="{{ $room->no_room }}"
                                                            {{ (is_array(old('no_room', $scheduleRooms ?? [])) && in_array($room->no_room, old('no_room', $scheduleRooms ?? []))) ? 'checked' : '' }}
                                                            {{ old('apply_to_all', $schedule->apply_to_all ?? false) ? 'disabled' : '' }}
                                                        >
                                                        <label class="room-label" for="room_{{ $room->no_room }}">
                                                            <div class="room-icon">
                                                                <i class="fas fa-door-closed"></i>
                                                            </div>
                                                            <div class="room-info">
                                                                <div class="room-name">{{ $room->name }}</div>
                                                                <div class="room-details">
                                                                    <span class="room-number">Room {{ $room->no_room }}</span>
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

                        <!-- Current vs New Comparison -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-info fw-bold mb-2">
                                    <span class="step-number">3</span>
                                    Changes Summary
                                </h6>
                                <p class="text-muted mb-0 small">Review your changes before updating</p>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="card border-0 bg-danger bg-opacity-10 rounded-3 h-100">
                                        <div class="card-body p-4">
                                            <h6 class="text-danger fw-bold mb-3">
                                                <i class="fas fa-history me-2"></i>
                                                Current Schedule
                                            </h6>
                                            <div class="current-info">
                                                <div class="info-item mb-2">
                                                    <strong>Date:</strong> 
                                                    <span class="text-white">{{ \Carbon\Carbon::parse($schedule->invalid_date)->format('M d, Y') }}</span>
                                                </div>
                                                <div class="info-item mb-2">
                                                    <strong>Time:</strong> 
                                                    <span class="text-white">{{ \Carbon\Carbon::parse($schedule->invalid_time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->invalid_time_end)->format('H:i') }}</span>
                                                </div>
                                                <div class="info-item">
                                                    <strong>Scope:</strong> 
                                                    <span class="text-white">
                                                        @if($schedule->apply_to_all ?? false)
                                                            All Rooms
                                                        @else
                                                            {{ count($scheduleRooms ?? []) }} Room(s) Selected
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 bg-success bg-opacity-10 rounded-3 h-100">
                                        <div class="card-body p-4">
                                            <h6 class="text-success fw-bold mb-3">
                                                <i class="fas fa-arrow-right me-2"></i>
                                                New Schedule
                                            </h6>
                                            <div class="new-info">
                                                <div class="info-item mb-2">
                                                    <strong>Date:</strong> 
                                                    <span class="text-white" id="newDate">-</span>
                                                </div>
                                                <div class="info-item mb-2">
                                                    <strong>Time:</strong> 
                                                    <span class="text-white" id="newTime">-</span>
                                                </div>
                                                <div class="info-item">
                                                    <strong>Scope:</strong> 
                                                    <span class="text-white" id="newScope">-</span>
                                                </div>
                                            </div>
                                        </div>
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
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Update?</h6>
                                            <p class="mb-0 text-muted small">Review your changes before updating the schedule</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('schedule.index') }}" 
                                               class="btn btn-outline-danger btn-lg rounded-pill px-4 shadow-sm">
                                                <i class="fas fa-times me-2"></i>
                                                Cancel
                                            </a>
                                            <button
                                                type="reset"
                                                class="btn btn-outline-warning btn-lg rounded-pill px-4 shadow-sm"
                                                id="resetBtn"
                                            >
                                                <i class="fas fa-undo-alt me-2"></i>
                                                Reset Changes
                                            </button>
                                            <button
                                                class="btn btn-success btn-lg rounded-pill px-4 shadow-sm"
                                                type="submit"
                                                id="submitBtn"
                                            >
                                                <span class="btn-text">
                                                    <i class="fas fa-save me-2"></i>
                                                    Update Schedule
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
                        Edit Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-edit text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Modify Carefully</div>
                                    <small class="text-white">Changes will affect existing bookings</small>
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
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-history text-white "></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Review Changes</div>
                                    <small class="text-white">Check the summary before updating</small>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr with enhanced styling
    const datePicker = flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: "today",
        theme: "material_orange",
        animate: true,
        onChange: function() {
            updateProgress();
            updateSummary();
        }
    });

    const startTimePicker = flatpickr("#flatpickrTimeStart", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minuteIncrement: 15,
        onChange: function() {
            updateProgress();
            updateSummary();
        }
    });

    const endTimePicker = flatpickr("#flatpickrTimeEnd", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minuteIncrement: 15,
        onChange: function() {
            updateProgress();
            updateSummary();
        }
    });

    // Form elements
    const applyToAllCheckbox = document.getElementById('applyToAll');
    const roomSelector = document.getElementById('roomSelector');
    const roomCheckboxes = document.querySelectorAll('input[name="no_room[]"]');
    const selectedCountElement = document.getElementById('selectedCount');
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetBtn');
    const scheduleEditForm = document.getElementById('scheduleEditForm');

    // Store original values for reset functionality
    const originalValues = {
        date: document.getElementById('flatpickrDate').value,
        startTime: document.getElementById('flatpickrTimeStart').value,
        endTime: document.getElementById('flatpickrTimeEnd').value,
        applyToAll: applyToAllCheckbox.checked,
        selectedRooms: Array.from(roomCheckboxes).filter(cb => cb.checked).map(cb => cb.value)
    };

    // Toggle room selector
    function toggleRoomSelector() {
        const isChecked = applyToAllCheckbox.checked;
        
        if (isChecked) {
            roomSelector.classList.add('disabled');
            roomCheckboxes.forEach(checkbox => {
                checkbox.disabled = true;
                checkbox.checked = false;
                const roomCard = checkbox.closest('.room-card');
                roomCard.classList.remove('selected');
            });
        } else {
            roomSelector.classList.remove('disabled');
            roomCheckboxes.forEach(checkbox => {
                checkbox.disabled = false;
            });
        }
        
        updateSelectedCount();
        updateProgress();
        updateSummary();
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

    // Update summary section
    function updateSummary() {
        const dateValue = document.getElementById('flatpickrDate').value;
        const startTimeValue = document.getElementById('flatpickrTimeStart').value;
        const endTimeValue = document.getElementById('flatpickrTimeEnd').value;

        // Update date
        if (dateValue) {
            const formattedDate = new Date(dateValue).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
            document.getElementById('newDate').textContent = formattedDate;
        } else {
            document.getElementById('newDate').textContent = '-';
        }

        // Update time
        if (startTimeValue && endTimeValue) {
            document.getElementById('newTime').textContent = `${startTimeValue} - ${endTimeValue}`;
        } else {
            document.getElementById('newTime').textContent = '-';
        }

        // Update scope
        if (applyToAllCheckbox.checked) {
            document.getElementById('newScope').textContent = 'All Rooms';
        } else {
            const selectedCount = Array.from(roomCheckboxes).filter(cb => cb.checked).length;
            document.getElementById('newScope').textContent = selectedCount > 0 ? `${selectedCount} Room(s) Selected` : '-';
        }
    }

    // Event listeners
    applyToAllCheckbox.addEventListener('change', toggleRoomSelector);
    
    roomCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const roomCard = this.closest('.room-card');
            
            if (this.checked) {
                roomCard.classList.add('selected');
            } else {
                roomCard.classList.remove('selected');
            }
            
            updateSelectedCount();
            updateProgress();
            updateSummary();
            
            // Add animation to the room card
            roomCard.classList.add('fade-in');
            setTimeout(() => roomCard.classList.remove('fade-in'), 500);
        });
    });

    // Form submission with loading state
    scheduleEditForm.addEventListener('submit', function(e) {
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
    resetBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Reset flatpickr instances to original values
        datePicker.setDate(originalValues.date);
        startTimePicker.setDate(originalValues.startTime, false, 'H:i');
        endTimePicker.setDate(originalValues.endTime, false, 'H:i');
        
        // Reset checkboxes to original state
        applyToAllCheckbox.checked = originalValues.applyToAll;
        roomCheckboxes.forEach(cb => {
            cb.checked = originalValues.selectedRooms.includes(cb.value);
            cb.disabled = originalValues.applyToAll;
            
            const roomCard = cb.closest('.room-card');
            if (cb.checked) {
                roomCard.classList.add('selected');
            } else {
                roomCard.classList.remove('selected');
            }
        });
        
        // Reset UI states
        if (originalValues.applyToAll) {
            roomSelector.classList.add('disabled');
        } else {
            roomSelector.classList.remove('disabled');
        }
        
        updateSelectedCount();
        updateProgress();
        updateSummary();
        
        // Add reset animation
        scheduleEditForm.classList.add('fade-in');
        setTimeout(() => scheduleEditForm.classList.remove('fade-in'), 500);

        // Show reset confirmation
        showNotification('Form reset to original values', 'info');
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
        scheduleEditForm.insertAdjacentHTML('beforebegin', alertHtml);

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

    // Show notification function
    function showNotification(message, type = 'success') {
        const alertClass = type === 'success' ? 'alert-success' :
                          type === 'error' ? 'alert-danger' :
                          type === 'warning' ? 'alert-warning' : 'alert-info';
        
        const icon = type === 'success' ? 'fa-check-circle' :
                    type === 'error' ? 'fa-exclamation-triangle' :
                    type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show notification-alert" role="alert">
                <i class="fas ${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification-alert');
        existingNotifications.forEach(notification => notification.remove());

        // Add new notification
        document.querySelector('.container-fluid').insertAdjacentHTML('afterbegin', alertHtml);

        // Auto-remove after 3 seconds
        setTimeout(() => {
            const notification = document.querySelector('.notification-alert');
            if (notification) {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 150);
            }
        }, 3000);
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (validateForm()) {
                scheduleEditForm.submit();
            }
        }
        
        // Ctrl+R to reset (prevent default browser refresh)
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            resetBtn.click();
        }
        
        // Escape to cancel
        if (e.key === 'Escape') {
            window.location.href = "{{ route('schedule.index') }}";
        }
    });

    // Detect changes to show unsaved changes warning
    let hasUnsavedChanges = false;
    
    function checkForChanges() {
        const currentValues = {
            date: document.getElementById('flatpickrDate').value,
            startTime: document.getElementById('flatpickrTimeStart').value,
            endTime: document.getElementById('flatpickrTimeEnd').value,
            applyToAll: applyToAllCheckbox.checked,
            selectedRooms: Array.from(roomCheckboxes).filter(cb => cb.checked).map(cb => cb.value)
        };

        hasUnsavedChanges =
            currentValues.date !== originalValues.date ||
            currentValues.startTime !== originalValues.startTime ||
            currentValues.endTime !== originalValues.endTime ||
            currentValues.applyToAll !== originalValues.applyToAll ||
            JSON.stringify(currentValues.selectedRooms.sort()) !== JSON.stringify(originalValues.selectedRooms.sort());
    }

    // Add change listeners to detect unsaved changes
    const formInputs = scheduleEditForm.querySelectorAll('input');
    formInputs.forEach(input => {
        input.addEventListener('change', checkForChanges);
    });

    // Warn about unsaved changes when leaving page
    window.addEventListener('beforeunload', function(e) {
        checkForChanges();
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

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

    // Initialize
    toggleRoomSelector();
    updateProgress();
    updateSummary();

    console.log('Schedule Edit Form initialized successfully');
});
</script>
@endpush