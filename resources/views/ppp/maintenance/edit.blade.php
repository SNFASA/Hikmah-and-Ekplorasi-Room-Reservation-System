@extends('ppp.layouts.master')
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
                        Update Maintenance Report
                    </h2>
                    <p class="text-muted mb-0">Review and update maintenance report status</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-primary text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-user-cog me-1"></i>
                        PPP Mode
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
                        <div class="col-md-8 ">
                            <h5 class="card-title mb-0 fw-bold text-white">
                                <i class="fas fa-clipboard-check me-2 text-white"></i>
                                Maintenance Report Review
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Update status and finalize maintenance request
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
                    <form method="POST" action="{{ route('ppp.maintenance.update', $maintenances->id) }}" id="maintenanceEditForm">
                        @csrf
                        @method('PUT')

                        <!-- Step 1: Reporter Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Reporter Information
                                </h6>
                                <p class="text-muted mb-0 small">Details of the person who reported this maintenance issue</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Reported By -->
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input
                                                    id="reported_by"
                                                    type="text"
                                                    name="reported_by"
                                                    class="form-control form-control-modern"
                                                    value="{{ $reported_by }}"
                                                    readonly
                                                >
                                                <label for="reported_by">
                                                    <i class="fas fa-user me-2"></i>
                                                    Reported By
                                                </label>
                                            </div>
                                            @error('reported_by')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Report Details -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Report Details
                                </h6>
                                <p class="text-muted mb-0 small">Basic information about the maintenance request</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Title -->
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input
                                                    id="inputTitle"
                                                    type="text"
                                                    name="title"
                                                    class="form-control form-control-modern"
                                                    value="{{ $maintenances->title }}"
                                                    readonly
                                                >
                                                <label for="inputTitle">
                                                    <i class="fas fa-heading me-2"></i>
                                                    Title
                                                </label>
                                            </div>
                                            @error('title')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea
                                                    class="form-control form-control-modern"
                                                    id="description"
                                                    name="description"
                                                    style="height: 120px"
                                                    readonly
                                                >{{ $maintenances->description }}</textarea>
                                                <label for="description">
                                                    <i class="fas fa-align-left me-2"></i>
                                                    Description
                                                </label>
                                            </div>
                                            @error('description')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Schedule and Location -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">3</span>
                                    Schedule and Location
                                </h6>
                                <p class="text-muted mb-0 small">When and where the maintenance is scheduled</p>
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
                                                    class="form-control form-control-modern"
                                                    value="{{ $maintenances->date_maintenance }}"
                                                    readonly
                                                >
                                                <label for="flatpickrDate">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    Maintenance Date
                                                </label>
                                            </div>
                                            @error('date_maintenance')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Room -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input
                                                    id="room_id"
                                                    type="text"
                                                    name="room_id"
                                                    class="form-control form-control-modern"
                                                    value="{{ $rooms->name ?? 'N/A' }}"
                                                    readonly
                                                >
                                                <label for="room_id">
                                                    <i class="fas fa-door-open me-2"></i>
                                                    Room Location
                                                </label>
                                            </div>
                                            @error('room_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Item Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">4</span>
                                    Item Information
                                </h6>
                                <p class="text-muted mb-0 small">Details about the item requiring maintenance</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Item Type -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input
                                                    id="itemType"
                                                    type="text"
                                                    name="itemType"
                                                    class="form-control form-control-modern"
                                                    value="{{ ucfirst(str_replace('_', ' ', $maintenances->itemType)) }}"
                                                    readonly
                                                >
                                                <label for="itemType">
                                                    <i class="fas fa-tags me-2"></i>
                                                    Item Type
                                                </label>
                                            </div>
                                            @error('itemType')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Item -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input
                                                    id="itemid"
                                                    type="text"
                                                    name="itemid"
                                                    class="form-control form-control-modern"
                                                    value="{{ $itemName }}"
                                                    readonly
                                                >
                                                <label for="itemid">
                                                    <i class="fas fa-cube me-2"></i>
                                                    Item Name
                                                </label>
                                            </div>
                                            @error('itemid')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Status Update -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">5</span>
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
                                                    <option value="pending" {{ $maintenances->status == 'pending' ? 'selected' : '' }}>
                                                        <i class="fas fa-clock me-2"></i> Pending
                                                    </option>
                                                    <option value="in_progress" {{ $maintenances->status == 'in_progress' ? 'selected' : '' }}>
                                                        <i class="fas fa-cog me-2"></i> In Progress
                                                    </option>
                                                    <option value="completed" {{ $maintenances->status == 'completed' ? 'selected' : '' }}>
                                                        <i class="fas fa-check-circle me-2"></i> Completed
                                                    </option>
                                                    <option value="failed" {{ $maintenances->status == 'failed' ? 'selected' : '' }}>
                                                        <i class="fas fa-times-circle me-2"></i> Failed
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
                                                        <span class="badge status-badge me-2" id="current-status-badge">
                                                            {{ ucfirst(str_replace('_', ' ', $maintenances->status)) }}
                                                        </span>
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
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Update Status?</h6>
                                            <p class="mb-0 text-muted small">Review the status change before updating the maintenance report</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('ppp.maintenance.index') }}"
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
                        PPP Update Guidelines
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-eye text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Review Details</div>
                                    <small class="text-muted">Verify all information before updating status</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-tasks text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Update Status</div>
                                    <small class="text-muted">Change status based on maintenance progress</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-bell text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Auto Notifications</div>
                                    <small class="text-muted">Reporter will be notified of status changes</small>
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
    console.log('PPP Maintenance Edit Form initializing...');

    // Initialize flatpickr with modern styling (readonly)
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        theme: "material_blue",
        clickOpens: false // Make it readonly
    });
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

    // Status change handler with visual feedback
    $('#status').on('change', function() {
        const status = $(this).val();
        const statusBadge = $('#current-status-badge');
        const statusText = status.replace('_', ' ');
        
        // Update status badge text
        statusBadge.text(statusText.charAt(0).toUpperCase() + statusText.slice(1));
        
        // Change badge color based on status
        statusBadge.removeClass('bg-secondary bg-warning bg-success bg-danger');
        switch(status) {
            case 'pending':
                statusBadge.addClass('bg-secondary');
                showNotification('Status changed to Pending', 'info');
                break;
            case 'in_progress':
                statusBadge.addClass('bg-warning');
                showNotification('Status changed to In Progress', 'warning');
                break;
            case 'completed':
                statusBadge.addClass('bg-success');
                showNotification('Status changed to Completed', 'success');
                break;
            case 'failed':
                statusBadge.addClass('bg-danger');
                showNotification('Status changed to Failed', 'error');
                break;
        }
    });

    // Set initial status badge color
    function setInitialStatusBadge() {
        const currentStatus = $('#status').val();
        const statusBadge = $('#current-status-badge');
        
        statusBadge.removeClass('bg-secondary bg-warning bg-success bg-danger');
        switch(currentStatus) {
            case 'pending':
                statusBadge.addClass('bg-secondary');
                break;
            case 'in_progress':
                statusBadge.addClass('bg-warning');
                break;
            case 'completed':
                statusBadge.addClass('bg-success');
                break;
            case 'failed':
                statusBadge.addClass('bg-danger');
                break;
        }
    }

    // Form submission with loading state
    $('#maintenanceEditForm').on('submit', function(e) {
        const btnText = $('#submitBtn .btn-text');
        const btnSpinner = $('#submitBtn .btn-spinner');
        
        // Show loading state
        btnText.addClass('d-none');
        btnSpinner.removeClass('d-none');
        $('#submitBtn').prop('disabled', true);
        
        showNotification('Updating maintenance status...', 'info');
    });

    // Enhanced form field interactions
    $('.form-control-modern').on('focus', function() {
        $(this).closest('.form-floating').addClass('focused');
    }).on('blur', function() {
        $(this).closest('.form-floating').removeClass('focused');
    });

    // Form validation
    function validateForm() {
        const status = $('#status').val();
        if (!status) {
            showNotification('Please select a status before updating', 'error');
            return false;
        }
        return true;
    }

    // Add form validation to submit
    $('#maintenanceEditForm').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            // Reset button state
            const btnText = $('#submitBtn .btn-text');
            const btnSpinner = $('#submitBtn .btn-spinner');
            btnText.removeClass('d-none');
            btnSpinner.addClass('d-none');
            $('#submitBtn').prop('disabled', false);
            return;
        }
    });

    // Animate elements on page load
    setTimeout(() => {
        $('.form-section').each(function(index) {
            const element = $(this);
            setTimeout(() => {
                element.addClass('fade-in');
            }, index * 200);
        });
    }, 100);

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (validateForm()) {
                $('#maintenanceEditForm').submit();
            }
        }
        
        // Escape to focus on back button
        if (e.key === 'Escape') {
            $('a[href*="back"]').focus();
        }
    });

    // Add hover effects to cards
    $('.card').hover(
        function() {
            $(this).addClass('shadow-lg');
        },
        function() {
            $(this).removeClass('shadow-lg');
        }
    );

    // Status dropdown enhancement
    $('#status').on('focus', function() {
        showNotification('Select the appropriate status for this maintenance request', 'info');
    });

    // Confirmation dialog for status change
    let originalStatus = $('#status').val();
    $('#status').on('change', function() {
        const newStatus = $(this).val();
        const statusText = newStatus.replace('_', ' ');
        
        if (originalStatus !== newStatus) {
            // Show confirmation for critical status changes
            if (newStatus === 'completed' || newStatus === 'failed') {
                const confirmMessage = `Are you sure you want to mark this maintenance as "${statusText}"? This action will notify the reporter.`;
                
                if (!confirm(confirmMessage)) {
                    $(this).val(originalStatus);
                    return;
                }
            }
        }
    });

    // Initialize tooltips for better UX
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Add progress indicator
    function updateProgress() {
        const statusSelected = $('#status').val() !== '';
        const progress = statusSelected ? 100 : 0;
        
        // Update progress bar if it exists
        if ($('#form-progress').length === 0) {
            $('.row .form-summary').append(`
                <div id="form-progress" class="mt-2">
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: ${progress}%"></div>
                    </div>
                    <small class="text-muted">Form completion: ${progress}%</small>
                </div>
            `);
        } else {
            $('#form-progress .progress-bar').css('width', progress + '%');
            $('#form-progress small').text(`Form completion: ${progress}%`);
        }
    }

    // Real-time form validation feedback
    $('#status').on('change', function() {
        const input = $(this);
        if (input.val()) {
            input.removeClass('is-invalid').addClass('is-valid');
        } else {
            input.removeClass('is-valid').addClass('is-invalid');
        }
        updateProgress();
    });

    // Initialize everything
    console.log('Initializing PPP form components...');
    setInitialStatusBadge();
    updateProgress();
    
    // Show welcome message
    setTimeout(() => {
        showNotification('Review the maintenance details and update the status as needed', 'info');
    }, 1000);

    // Auto-save draft functionality (optional)
    let autoSaveTimer;
    $('#status').on('change', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            // Here you could implement auto-save functionality
            console.log('Auto-save: Status changed to', $(this).val());
        }, 2000);
    });

    // Smooth scroll to form sections on validation errors
    function scrollToFirstError() {
        const firstError = $('.is-invalid').first();
        if (firstError.length) {
            firstError[0].scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    }

    // Enhanced error handling
    window.addEventListener('error', function(e) {
        console.error('JavaScript Error:', e.error);
        showNotification('An error occurred. Please refresh the page and try again.', 'error');
    });

    // Form state management
    let formSubmitted = false;
    $('#maintenanceEditForm').on('submit', function() {
        formSubmitted = true;
    });

    // Prevent double submission
    $('#submitBtn').on('click', function(e) {
        if (formSubmitted) {
            e.preventDefault();
            showNotification('Form is already being submitted, please wait...', 'warning');
            return false;
        }
    });

    // Add loading overlay for better UX (optional)
    function showLoadingOverlay() {
        const overlay = `
            <div id="loading-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                 style="background: rgba(255,255,255,0.9); z-index: 9999;">
                <div class="text-center">
                    <div class="spinner-border text-warning mb-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 class="text-warning">Updating Status...</h5>
                    <p class="text-muted">Please wait while we process your request</p>
                </div>
            </div>
        `;
        $('body').append(overlay);
    }

    // Enhanced submit handler with loading overlay
    $('#maintenanceEditForm').on('submit', function(e) {
        if (validateForm()) {
            showLoadingOverlay();
        }
    });

    console.log('PPP Maintenance Edit Form initialized successfully');
});
</script>
@endpush