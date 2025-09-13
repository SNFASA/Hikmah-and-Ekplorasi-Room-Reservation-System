@extends('backend.layouts.master')
@section('title', 'Maintenance Edit')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-edit me-2"></i>
                        Edit Maintenance Report
                    </h2>
                    <p class="text-muted mb-0">Update maintenance report details and status</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-primary text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-pencil-alt me-1"></i>
                        Edit Mode
                    </div>
                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-calendar me-1"></i>
                        {{ now()->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card maintenance-edit-card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-0 text-white fw-bold">
                                <i class="fas fa-cog me-2"></i>
                                Update Maintenance Report
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Modify report details and update maintenance status
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="report-info">
                                <small class="d-block opacity-75">Report ID:</small>
                                <strong>#{{ $maintenances->id }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body bg-light p-4">
                    <form method="POST" action="{{ route('maintenance.update', $maintenances->id) }}" id="maintenanceEditForm">
                        @csrf
                        @method('PATCH')

                        <!-- Step 1: Basic Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Basic Report Information
                                </h6>
                                <p class="text-muted mb-0 small">Update the basic details for the maintenance report</p>
                            </div>

                            <div class="row g-4">
                                <!-- Reported By -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="reported_by"
                                            type="text"
                                            class="form-control form-control-modern"
                                            value="{{ $maintenances->reporter->no_matriks ?? 'N/A' }}"
                                            disabled
                                        >
                                        <label for="reported_by">
                                            <i class="fas fa-user me-2"></i>
                                            Reported By
                                        </label>
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
                                            value="{{ old('title', $maintenances->title) }}"
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
                                        >{{ old('description', $maintenances->description) }}</textarea>
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
                                <p class="text-muted mb-0 small">Update when and where the maintenance is needed</p>
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
                                                    value="{{ old('date_maintenance', $maintenances->date_maintenance) }}"
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
                                                        <option value="{{ $room->no_room }}" {{ old('room_id', $maintenances->room_id) == $room->no_room ? 'selected' : '' }}>
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
                                <p class="text-muted mb-0 small">Update the type and specific item that needs maintenance</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Item Type -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="itemType" id="itemType" class="form-control form-control-modern @error('itemType') is-invalid @enderror">
                                                    <option value="">-- Select Item Type --</option>
                                                    <option value="furniture" {{ old('itemType', $maintenances->itemType) == 'furniture' ? 'selected' : '' }}>
                                                        Furniture
                                                    </option>
                                                    <option value="electronic_equipment" {{ old('itemType', $maintenances->itemType) == 'electronic_equipment' ? 'selected' : '' }}>
                                                        Electronic Equipment
                                                    </option>
                                                    <option value="other" {{ old('itemType', $maintenances->itemType) == 'other' ? 'selected' : '' }}>
                                                        Other
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
                                                <i class="fas fa-info-circle me-3 text-primary"></i>
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

                        <!-- Step 4: Status Update -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primaryfw-bold mb-2">
                                    <span class="step-number">4</span>
                                    Status Management
                                </h6>
                                <p class="text-muted mb-0 small">Update the current status of the maintenance request</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Status -->
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <select name="status" id="status" class="form-control form-control-modern @error('status') is-invalid @enderror" required>
                                                    <option value="pending" {{ old('status', $maintenances->status) == 'pending' ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option value="in_progress" {{ old('status', $maintenances->status) == 'in_progress' ? 'selected' : '' }}>
                                                        In Progress
                                                    </option>
                                                    <option value="completed" {{ old('status', $maintenances->status) == 'completed' ? 'selected' : '' }}>
                                                        Completed
                                                    </option>
                                                    <option value="Failed" {{ old('status', $maintenances->status) == 'Failed' ? 'selected' : '' }}>
                                                        Failed
                                                    </option>
                                                </select>
                                                <label for="status">
                                                    <i class="fas fa-flag me-2"></i>
                                                    Status <span class="text-danger">*</span>
                                                </label>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Information -->
                                    <div class="mt-4" id="status-info">
                                        <div class="alert alert-light border-0 rounded-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle me-3 text-muted"></i>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">Current Status</h6>
                                                    <p class="mb-0 small">
                                                        <span class="badge status-badge me-2">{{ ucfirst(str_replace('_', ' ', $maintenances->status)) }}</span>
                                                        Last updated: {{ $maintenances->updated_at->format('M d, Y H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row fade-in">
                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                                        <div class="form-summary">
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Update Report?</h6>
                                            <p class="mb-0 text-muted small">Review your changes before updating the maintenance report</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('maintenance.index') }}"
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
                                            <button class="btn btn-success btn-lg rounded-pill px-4 shadow-sm text-white fw-bold"
                                                    type="submit"
                                                    id="submitBtn">
                                                <span class="btn-text">
                                                    <i class="fas fa-save me-2"></i>
                                                    Update Report
                                                </span>
                                                <span class="btn-primary d-none">
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
                        Edit Report Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-white">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-edit text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Update Status</div>
                                    <small class="text-white">Change status to reflect current progress</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Track Changes</div>
                                    <small class="text-white">All changes are logged with timestamps</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-save text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Save Progress</div>
                                    <small class="text-white">Review all fields before updating</small>
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
    console.log('Maintenance Edit Form initializing...');

    // Initialize flatpickr with modern styling
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        theme: "material_blue"
    });

    // Store original form values for reset functionality
    const originalValues = {};
    $('#maintenanceEditForm input, #maintenanceEditForm select, #maintenanceEditForm textarea').each(function() {
        const name = $(this).attr('name');
        if (name) {
            originalValues[name] = $(this).val();
        }
    });
    // Update form status visual feedback
    function updateFormStatus(percentage) {
        const isComplete = percentage === 100;
        const submitBtn = $('#submitBtn');
        
        if (isComplete) {
            submitBtn.removeClass('btn-outline-info').addClass('btn-info');
        } else {
            submitBtn.removeClass('btn-info').addClass('btn-outline-info');
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

    // IMPROVED ITEM TYPE CHANGE HANDLER - THIS IS THE FIX
    $('#itemType').change(function () {
        const type = $(this).val();
        const url = "{{ route('maintenance.items') }}?type=" + type;
        const currentItemId = "{{ old('itemid', $maintenances->itemid) }}";
        
        console.log('Item type changed to:', type);
        console.log('Current item ID:', currentItemId);
        console.log('AJAX URL:', url);

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

        // Reset item dropdown when no type is selected
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

        // Handle 'other' type with text input
        if (type === 'other') {
            const currentItemText = "{{ old('itemid_text', $maintenances->itemType == 'other' ? $maintenances->item_text : '') }}";
            $('#itemid-wrapper').html(`
                <div class="form-floating">
                    <input type="text" id="itemid_text" name="itemid_text" 
                           class="form-control form-control-modern" 
                           placeholder="Enter item name" value="${currentItemText}">
                    <label for="itemid_text">
                        <i class="fas fa-edit me-2"></i>
                        Item Name
                    </label>
                </div>
            `);
            showNotification('You can now enter a custom item name', 'info');
            return;
        }

        // Show loading state for database items
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

        // Fetch items from server with improved error handling
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            timeout: 10000, // 10 second timeout
            success: function(data) {
                console.log('Items loaded successfully:', data);
                
                const icon = type === 'furniture' ? 'fa-chair' : 'fa-laptop';
                const selectHtml = `
                    <div class="form-floating">
                        <select id="itemid" name="itemid" class="form-control form-control-modern">
                            <option value="">-- Select Item --</option>
                        </select>
                        <label for="itemid">
                            <i class="fas ${icon} me-2"></i>
                            Item
                        </label>
                    </div>
                `;
                
                $('#itemid-wrapper').html(selectHtml);
                const select = $('#itemid');
                
                if (data && Array.isArray(data) && data.length > 0) {
                    data.forEach(item => {
                        const isSelected = currentItemId == item.id ? 'selected' : '';
                        select.append(`<option value="${item.id}" ${isSelected}>${item.name}</option>`);
                    });
                    showNotification(`${data.length} items loaded successfully`, 'success');
                } else {
                    select.append('<option value="" disabled>No items available for this type</option>');
                    showNotification('No items found for this type', 'warning');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response Text:', xhr.responseText);
                console.error('Status Code:', xhr.status);
                
                let errorMessage = 'Failed to load items. ';
                if (xhr.status === 404) {
                    errorMessage += 'Route not found (404).';
                } else if (xhr.status === 500) {
                    errorMessage += 'Server error (500).';
                } else if (status === 'timeout') {
                    errorMessage += 'Request timed out.';
                } else {
                    errorMessage += 'Please check your internet connection.';
                }
                
                $('#itemid-wrapper').html(`
                    <div class="form-floating">
                        <select id="itemid" name="itemid" class="form-control form-control-modern is-invalid">
                            <option value="">Error loading items</option>
                        </select>
                        <label for="itemid">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Item (Error)
                        </label>
                        <div class="invalid-feedback">${errorMessage}</div>
                    </div>
                `);
                showNotification(errorMessage, 'error');
            }
        });
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

        // Validate status
        if (!$('#status').val()) {
            errors.push('Status is required');
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

        $('#maintenanceEditForm').before(alertHtml);

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
        
        // Reset form fields to original values
        Object.keys(originalValues).forEach(name => {
            const element = $(`[name="${name}"]`);
            if (element.length) {
                element.val(originalValues[name]);
            }
        });
        
        // Reset item type selection
        $('#item-type-info').fadeOut(300);
        
        // Reset flatpickr
        const flatpickrInstance = document.querySelector("#flatpickrDate")._flatpickr;
        if (flatpickrInstance) {
            flatpickrInstance.setDate(originalValues.date_maintenance);
        }
        
        // Trigger item type change to reload items
        if (originalValues.itemType) {
            setTimeout(() => {
                $('#itemType').trigger('change');
            }, 300);
        }
        
        updateProgress();
        showNotification('Form has been reset to original values', 'info');
    }

    // Initialize item selection on page load - IMPORTANT FOR EDIT MODE
    function initializeItemSelection() {
        const currentItemType = "{{ old('itemType', $maintenances->itemType) }}";
        const currentItemId = "{{ old('itemid', $maintenances->itemid) }}";
        
        console.log('Initializing item selection...');
        console.log('Current item type:', currentItemType);
        console.log('Current item ID:', currentItemId);
        
        if (currentItemType) {
            // Set the item type dropdown value
            $('#itemType').val(currentItemType);
            
            // Trigger the change event to load items after a short delay
            setTimeout(() => {
                $('#itemType').trigger('change');
            }, 800); // Increased delay to ensure DOM is ready
        }
    }

    // Status change handler with visual feedback
    $('#status').on('change', function() {
        const status = $(this).val();
        const statusBadge = $('.status-badge');
        const statusText = status.replace('_', ' ');
        
        // Update status badge
        statusBadge.text(statusText.charAt(0).toUpperCase() + statusText.slice(1));
        
        // Change badge color based on status
        statusBadge.removeClass('bg-secondary bg-warning bg-success bg-danger');
        switch(status) {
            case 'pending':
                statusBadge.addClass('bg-secondary');
                break;
            case 'in_progress':
                statusBadge.addClass('bg-warning');
                break;
            case 'completed':
                statusBadge.addClass('bg-success');
                break;
            case 'Failed':
                statusBadge.addClass('bg-danger');
                break;
        }
        
        showNotification(`Status updated to: ${statusText}`, 'info');
    });

    // Track form changes
    let formChanged = false;
    $('#maintenanceEditForm input, #maintenanceEditForm select, #maintenanceEditForm textarea').on('change input', function() {
        const name = $(this).attr('name');
        if (name && originalValues[name] !== $(this).val()) {
            formChanged = true;
        }
    });

    // Warn before leaving if there are unsaved changes
    $(window).on('beforeunload', function(e) {
        if (formChanged) {
            const message = 'You have unsaved changes. Are you sure you want to leave?';
            e.returnValue = message;
            return message;
        }
    });

    // Form submission with validation and loading state
    $('#maintenanceEditForm').on('submit', function(e) {
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
        
        // Form is valid, allow submission
        formChanged = false; // Reset change tracking
    });

    // Reset form button click
    $('#resetBtn').on('click', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
            resetForm();
            formChanged = false;
        }
    });

    // Form field change listeners for progress tracking
    $('#inputTitle, #flatpickrDate, #status').on('input change', function() {
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

    // Form completion visual feedback
    function updateFormCompletionStatus() {
        const requiredFields = ['#inputTitle', '#flatpickrDate', '#status'];
        const completed = requiredFields.filter(field => $(field).val().trim()).length;
        const total = requiredFields.length;
        const percentage = Math.round((completed / total) * 100);
        
        // Update form completion indicator
        if ($('#completion-indicator').length === 0) {
            $('.row .form-summary').append(`
                <div id="completion-indicator" class="mt-2">
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: ${percentage}%"></div>
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
    $('#inputTitle, #flatpickrDate, #status').on('input change', function() {
        updateFormCompletionStatus();
    });

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (validateForm()) {
                $('#maintenanceEditForm').submit();
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

    // Item selection enhancement (delegated event for dynamically created elements)
    $(document).on('change', '#itemid', function() {
        const selectedItem = $(this).find('option:selected').text();
        if ($(this).val()) {
            showNotification(`Item "${selectedItem}" selected`, 'success');
        }
    });

    // Custom item text validation (for 'other' type)
    $(document).on('input', '#itemid_text', function() {
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

    // Animate elements on page load
    setTimeout(() => {
        $('.card, .form-section').each(function(index) {
            const element = $(this);
            setTimeout(() => {
                element.addClass('fade-in');
            }, index * 150);
        });
    }, 100);

    // Debug function for testing routes
    window.debugItemsRoute = function() {
        console.log('=== DEBUGGING ITEMS ROUTE ===');
        
        const itemTypes = ['furniture', 'electronic_equipment'];
        
        itemTypes.forEach(type => {
            const testUrl = "{{ route('maintenance.items') }}?type=" + type;
            console.log(`Testing URL: ${testUrl}`);
            
            $.ajax({
                url: testUrl,
                method: 'GET',
                success: function(data) {
                    console.log(`✅ ${type} items loaded:`, data);
                },
                error: function(xhr, status, error) {
                    console.error(`❌ Error loading ${type} items:`, {
                        status: status,
                        error: error,
                        responseText: xhr.responseText,
                        statusCode: xhr.status
                    });
                }
            });
        });
    };

    // Initialize everything
    console.log('Initializing form components...');
    updateProgress();
    updateFormCompletionStatus();
    
    // MOST IMPORTANT: Initialize item selection for edit mode
    setTimeout(() => {
        initializeItemSelection();
    }, 1000);

    console.log('Maintenance Edit Form initialized successfully');
    
    // Show welcome message
    setTimeout(() => {
        showNotification('Maintenance report ready for editing!', 'info');
    }, 1500);
});
</script>
@endpush