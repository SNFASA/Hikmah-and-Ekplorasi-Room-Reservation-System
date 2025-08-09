@extends('backend.layouts.master')
@section('title', 'Maintenance Create')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-tools me-2"></i>
                        Add Maintenance Report
                    </h2>
                    <p class="text-muted mb-0">Create a new maintenance report for equipment and facilities</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-primary text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-wrench me-1"></i>
                        New Report
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
            <div class="card maintenance-card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-clipboard-list me-2"></i>
                                Maintenance Configuration
                            </h5>
                            <p class="mb-0 mt-1 opacity-75 text-white">
                                Report maintenance issues and track repairs
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="creation-info">
                                <small class="d-block opacity-75">Report Date:</small>
                                <strong>{{ now()->format('M d, Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body bg-light p-4">
                    <form method="POST" action="{{ route('maintenance.store') }}" id="maintenanceCreateForm">
                        @csrf

                        <!-- Step 1: Basic Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Basic Report Information
                                </h6>
                                <p class="text-muted mb-0 small">Enter the basic details for the maintenance report</p>
                            </div>

                            <div class="row g-4">
                                <!-- Reported By -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="reported_by"
                                            type="text"
                                            name="reported_by"
                                            class="form-control form-control-modern"
                                            value="{{ $reported_by }}"
                                            disabled
                                        >
                                        <label for="reported_by">
                                            <i class="fas fa-user me-2"></i>
                                            Reported By
                                        </label>
                                        @error('reported_by')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="inputTitle"
                                            type="text"
                                            name="title"
                                            class="form-control form-control-modern @error('title') is-invalid @enderror"
                                            placeholder="Enter title"
                                            value="{{ old('title') }}"
                                            required
                                        >
                                        <label for="inputTitle">
                                            <i class="fas fa-heading me-2"></i>
                                            Title <span class="text-danger">*</span>
                                        </label>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <!-- Description -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea
                                            class="form-control form-control-modern @error('description') is-invalid @enderror"
                                            id="description"
                                            name="description"
                                            style="height: 120px"
                                            placeholder="Enter detailed description of the maintenance issue"
                                        >{{ old('description') }}</textarea>
                                        <label for="description">
                                            <i class="fas fa-align-left me-2"></i>
                                            Description
                                        </label>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Date and Location -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Date and Location Details
                                </h6>
                                <p class="text-muted mb-0 small">Specify when and where the maintenance is needed</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Date -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input
                                                    id="flatpickrDate"
                                                    type="text"
                                                    name="date_maintenance"
                                                    class="form-control form-control-modern @error('date_maintenance') is-invalid @enderror"
                                                    value="{{ old('date_maintenance') }}"
                                                    placeholder="Select date"
                                                    required
                                                >
                                                <label for="flatpickrDate">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    Maintenance Date <span class="text-danger">*</span>
                                                </label>
                                                @error('date_maintenance')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Room -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="room_id" id="room_id" class="form-control form-control-modern @error('room_id') is-invalid @enderror">
                                                    <option value="">-- Select Room --</option>
                                                    @foreach($rooms as $room)
                                                        <option value="{{ $room->no_room }}" {{ old('room_id') == $room->no_room ? 'selected' : '' }}>
                                                            {{ $room->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="room_id">
                                                    <i class="fas fa-door-open me-2"></i>
                                                    Room Location
                                                </label>
                                                @error('room_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Item Selection -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">3</span>
                                    Item Selection
                                </h6>
                                <p class="text-muted mb-0 small">Select the type and specific item that needs maintenance</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Item Type -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="itemType" id="itemType" class="form-control form-control-modern @error('itemType') is-invalid @enderror">
                                                    <option value="">-- Select Item Type --</option>
                                                    <option value="furniture" {{ old('itemType') == 'furniture' ? 'selected' : '' }}>
                                                        <i class="fas fa-chair me-2"></i>Furniture
                                                    </option>
                                                    <option value="electronic_equipment" {{ old('itemType') == 'electronic_equipment' ? 'selected' : '' }}>
                                                        <i class="fas fa-laptop me-2"></i>Electronic Equipment
                                                    </option>
                                                    <option value="other" {{ old('itemType') == 'other' ? 'selected' : '' }}>
                                                        <i class="fas fa-tools me-2"></i>Other
                                                    </option>
                                                </select>
                                                <label for="itemType">
                                                    <i class="fas fa-tags me-2"></i>
                                                    Item Type
                                                </label>
                                                @error('itemType')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Item Selection -->
                                        <div class="col-md-6">
                                            <div id="itemid-wrapper">
                                                <div class="form-floating">
                                                    <select name="itemid" id="itemid" class="form-control form-control-modern @error('itemid') is-invalid @enderror">
                                                        <option value="">-- Select Item --</option>
                                                    </select>
                                                    <label for="itemid">
                                                        <i class="fas fa-cube me-2"></i>
                                                        Item
                                                    </label>
                                                    @error('itemid')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item Type Selection Info -->
                                    <div class="mt-4" id="item-type-info" style="display: none;">
                                        <div class="alert alert-info border-0 rounded-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle me-3 text-info"></i>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">Item Type Selected</h6>
                                                    <p class="mb-0 small" id="item-type-description"></p>
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
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Submit Report?</h6>
                                            <p class="mb-0 text-muted small">Review your maintenance report before submitting</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('maintenance.index') }}"
                                               class="btn btn-outline-danger btn-lg rounded-pill px-4 shadow-sm">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                Back
                                            </a>
                                            <button type="reset"
                                                    class="btn btn-outline-warning btn-lg rounded-pill px-4 shado7w-sm"
                                                    id="resetBtn">
                                                <i class="fas fa-undo-alt me-2"></i>7
                                                Reset
                                            </button>
                                            <button class="btn btn-warning btn-lg rounded-pill px-4 shadow-sm text-dark fw-bold"
                                                    type="submit"
                                                    id="submitBtn">
                                                <span class="btn-text">
                                                    <i class="fas fa-check me-2"></i>
                                                    Submit Report
                                                </span>
                                                <span class="btn-spinner d-none">
                                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                                    Submitting...
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
                        Maintenance Report Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Required Fields</div>
                                    <small class="text-white">Title and date are mandatory fields</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-edit text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Description</div>
                                    <small class="text-white">Provide detailed problem description</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-tools text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Item Selection</div>
                                    <small class="text-white">Choose type first, then specific item</small>
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
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Maintenance Create Form initializing...');

    // Initialize flatpickr with modern styling
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        theme: "material_orange",
        minDate: "today"
    });


    // Update form status visual feedback
    function updateFormStatus(percentage) {
        const isComplete = percentage === 100;
        const submitBtn = $('#submitBtn');
        
        if (isComplete) {
            submitBtn.removeClass('btn-outline-warning').addClass('btn-warning');
        } else {
            submitBtn.removeClass('btn-warning').addClass('btn-outline-warning');
        }
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

    // Load items based on item type
    $('#itemType').change(function () {
        const type = $(this).val();
        const url = "{{ route('maintenance.items') }}?type=" + type;

        // Show item type info
        if (type) {
            const descriptions = {
                'furniture': 'Select from available furniture items like chairs, tables, cabinets, etc.',
                'electronic_equipment': 'Choose from electronic equipment such as computers, projectors, printers, etc.',
                'other': 'Specify any other item that needs maintenance by typing the name.'
            };
            
            $('#item-type-description').text(descriptions[type] || '');
            $('#item-type-info').fadeIn(300);
        } else {
            $('#item-type-info').fadeOut(300);
        }

        if (!type) {
            $('#itemid-wrapper').html(`
                <div class="form-floating">
                    <select id="itemid" name="itemid" class="form-control form-control-modern">
                        <option value="">-- Select Item --</option>
                    </select>
                    <label for="itemid">
                        <i class="fas fa-cube me-2"></i>
                        Item
                    </label>
                </div>
            `);
            return;
        }

        if (type === 'other') {
            $('#itemid-wrapper').html(`
                <div class="form-floating">
                    <input type="text" id="item_text" name="item_text" class="form-control form-control-modern" placeholder="Enter item name">
                    <label for="item_text">
                        <i class="fas fa-edit me-2"></i>
                        Item Name
                    </label>
                </div>
            `);
            showNotification('You can now enter a custom item name', 'info');
        } else {
            // Show loading state
            $('#itemid-wrapper').html(`
                <div class="form-floating">
                    <select id="itemid" name="itemid" class="form-control form-control-modern" disabled>
                        <option value="">Loading items...</option>
                    </select>
                    <label for="itemid">
                        <i class="fas fa-spinner fa-spin me-2"></i>
                        Loading Items...
                    </label>
                </div>
            `);

            $.get(url, function (data) {
                const select = $('<select id="itemid" name="itemid" class="form-control form-control-modern"></select>');
                select.append('<option value="">-- Select Item --</option>');
                
                if (data.length > 0) {
                    data.forEach(item => {
                        select.append(`<option value="${item.id}">${item.name}</option>`);
                    });
                    showNotification(`${data.length} items loaded successfully`, 'success');
                } else {
                    select.append('<option value="" disabled>No items available</option>');
                    showNotification('No items found for this type', 'warning');
                }

                const icon = type === 'furniture' ? 'fa-chair' : 'fa-laptop';
                $('#itemid-wrapper').html(`
                    <div class="form-floating">
                        <label for="itemid">
                            <i class="fas ${icon} me-2"></i>
                            Item
                        </label>
                    </div>
                `).find('.form-floating').append(select);
            }).fail(function() {
                $('#itemid-wrapper').html(`
                    <div class="form-floating">
                        <select id="itemid" name="itemid" class="form-control form-control-modern is-invalid">
                            <option value="">Error loading items</option>
                        </select>
                        <label for="itemid">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Item (Error)
                        </label>
                        <div class="invalid-feedback">Failed to load items. Please try again.</div>
                    </div>
                `);
                showNotification('Failed to load items. Please try again.', 'error');
            });
        }
    });

    // Form validation function
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Validate title
        if (!$('#inputTitle').val().trim()) {
            errors.push('Title is required');
            isValid = false;
        }

        // Validate date
        if (!$('#flatpickrDate').val().trim()) {
            errors.push('Maintenance date is required');
            isValid = false;
        }

        // Show errors if any
        if (!isValid) {
            showValidationErrors(errors);
        }

        return isValid;
    }

    // Show validation errors function
    function showValidationErrors(errors) {
        const existingAlerts = $('.validation-alert');
        existingAlerts.remove();

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

        $('#maintenanceCreateForm').before(alertHtml);

        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            $('.validation-alert').fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);

        // Scroll to alert
        $('.validation-alert')[0].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }

    // Reset form function
    function resetForm() {
        console.log('Resetting form...');
        
        // Reset form fields
        $('#maintenanceCreateForm')[0].reset();
        
        // Reset item type selection
        $('#item-type-info').fadeOut(300);
        $('#itemid-wrapper').html(`
            <div class="form-floating">
                <select name="itemid" id="itemid" class="form-control form-control-modern">
                    <option value="">-- Select Item --</option>
                </select>
                <label for="itemid">
                    <i class="fas fa-cube me-2"></i>
                    Item
                </label>
            </div>
        `);
        
        // Reset flatpickr
        const flatpickrInstance = document.querySelector("#flatpickrDate")._flatpickr;
        if (flatpickrInstance) {
            flatpickrInstance.clear();
        }
        
        updateProgress();
        showNotification('Form has been reset', 'info');
    }

    // Event Listeners
    
    // Form submission with validation and loading state
    $('#maintenanceCreateForm').on('submit', function(e) {
        console.log('Form submitted');
        
        const btnText = $('#submitBtn .btn-text');
        const btnSpinner = $('#submitBtn .btn-spinner');
        
        // Show loading state
        btnText.addClass('d-none');
        btnSpinner.removeClass('d-none');
        $('#submitBtn').prop('disabled', true);
        
        // Basic validation
        if (!validateForm()) {
            e.preventDefault();
            // Reset button state
            btnText.removeClass('d-none');
            btnSpinner.addClass('d-none');
            $('#submitBtn').prop('disabled', false);
            return;
        }
    });

    // Reset form button click
    $('#resetBtn').on('click', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            resetForm();
        }
    });

    // Form field change listeners for progress tracking
    $('#inputTitle, #flatpickrDate').on('input change', function() {
        updateProgress();
    });

    // Real-time validation feedback
    $('#inputTitle').on('input', function() {
        const input = $(this);
        const value = input.val().trim();
        
        if (value.length > 0) {
            input.removeClass('is-invalid').addClass('is-valid');
        } else {
            input.removeClass('is-valid');
        }
    });

    // Description character counter
    $('#description').on('input', function() {
        const maxLength = 1000;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        
        // Add character counter if it doesn't exist
        if ($('#description-counter').length === 0) {
            $(this).after(`
                <div id="description-counter" class="form-text text-end mt-1">
                    <small class="text-muted">
                        <span id="char-count">${currentLength}</span>/${maxLength} characters
                    </small>
                </div>
            `);
        } else {
            $('#char-count').text(currentLength);
        }
        
        // Update counter color based on usage
        const counter = $('#description-counter small');
        if (remaining < 100) {
            counter.removeClass('text-muted text-warning').addClass('text-danger');
        } else if (remaining < 200) {
            counter.removeClass('text-muted text-danger').addClass('text-warning');
        } else {
            counter.removeClass('text-warning text-danger').addClass('text-muted');
        }
    });

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (validateForm()) {
                $('#maintenanceCreateForm').submit();
            }
        }
        
        // Escape to focus on reset
        if (e.key === 'Escape') {
            $('#resetBtn').focus();
        }
    });

    // Add smooth scroll to form sections on focus
    $('.form-floating input, .form-floating select, .form-floating textarea').on('focus', function() {
        const section = $(this).closest('.form-section');
        if (section.length) {
            section[0].scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });

    // Enhanced form field interactions
    $('.form-control-modern').on('focus', function() {
        $(this).closest('.form-floating').addClass('focused');
    }).on('blur', function() {
        $(this).closest('.form-floating').removeClass('focused');
    });

    // Room selection enhancement
    $('#room_id').on('change', function() {
        const selectedRoom = $(this).find('option:selected').text();
        if ($(this).val()) {
            showNotification(`Room "${selectedRoom}" selected`, 'info');
        }
    });

    // Item selection enhancement
    $(document).on('change', '#itemid', function() {
        const selectedItem = $(this).find('option:selected').text();
        if ($(this).val()) {
            showNotification(`Item "${selectedItem}" selected`, 'success');
        }
    });

    // Custom item text validation (for 'other' type)
    $(document).on('input', '#item_text', function() {
        const input = $(this);
        const value = input.val().trim();
        
        if (value.length >= 3) {
            input.removeClass('is-invalid').addClass('is-valid');
        } else if (value.length > 0) {
            input.removeClass('is-valid').addClass('is-invalid');
        } else {
            input.removeClass('is-valid is-invalid');
        }
    });

    // Auto-save functionality (optional - saves to sessionStorage)
    function autoSave() {
        const formData = {
            title: $('#inputTitle').val(),
            description: $('#description').val(),
            date_maintenance: $('#flatpickrDate').val(),
            room_id: $('#room_id').val(),
            itemType: $('#itemType').val(),
            itemid: $('#itemid').val() || $('#item_text').val(),
            timestamp: new Date().getTime()
        };
        
        // Note: In real implementation, you might want to save to server instead
        console.log('Auto-saving form data:', formData);
    }

    // Auto-save every 30 seconds
    setInterval(autoSave, 30000);

    // Form completion visual feedback
    function updateFormCompletionStatus() {
        const requiredFields = ['#inputTitle', '#flatpickrDate'];
        const completed = requiredFields.filter(field => $(field).val().trim()).length;
        const total = requiredFields.length;
        const percentage = Math.round((completed / total) * 100);
        
        // Update form completion indicator
        if ($('#completion-indicator').length === 0) {
            $('.form-actions .form-summary').append(`
                <div id="completion-indicator" class="mt-2">
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: ${percentage}%"></div>
                    </div>
                    <small class="text-muted">Form completion: ${percentage}%</small>
                </div>
            `);
        } else {
            $('#completion-indicator .progress-bar').css('width', percentage + '%');
            $('#completion-indicator small').text(`Form completion: ${percentage}%`);
        }
    }

    // Update completion status on field changes
    $('#inputTitle, #flatpickrDate').on('input change', function() {
        updateFormCompletionStatus();
    });

    // Animate elements on page load
    setTimeout(() => {
        $('.card, .form-section').each(function(index) {
            const element = $(this);
            setTimeout(() => {
                element.addClass('fade-in');
            }, index * 150);
        });
    }, 100);

    // Add loading states for better UX
    function showLoadingState(element, message = 'Loading...') {
        const originalHtml = element.html();
        element.data('original-html', originalHtml);
        element.html(`
            <span class="spinner-border spinner-border-sm me-2"></span>
            ${message}
        `).prop('disabled', true);
    }

    function hideLoadingState(element) {
        const originalHtml = element.data('original-html');
        if (originalHtml) {
            element.html(originalHtml).prop('disabled', false);
        }
    }

    // Initialize form
    updateProgress();
    updateFormCompletionStatus();

    console.log('Maintenance Create Form initialized successfully');
    
    // Show welcome message
    setTimeout(() => {
        showNotification('Maintenance report form is ready!', 'info');
    }, 1000);
});
</script>
@endpush