@extends('backend.layouts.master')
@section('title', 'Electronic Equipment Create')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-laptop me-2"></i>
                        Add Electronic Equipment
                    </h2>
                    <p class="text-muted mb-0">Create new electronic equipment for room assignment</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-success text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-plus me-1"></i>
                        New Equipment
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
            <div class="card electronic-card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title text-white mb-0 fw-bold">
                                <i class="fas fa-cog me-2"></i>
                                Equipment Configuration
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Set up electronic equipment details and specifications
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="creation-info">
                                <small class="d-block opacity-75">Creation Date:</small>
                                <strong>{{ now()->format('M d, Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body bg-light p-4">
                    <form method="POST" action="{{ route('backend.electronic.store') }}" id="electronicCreateForm">
                        @csrf
                        
                        <!-- Equipment Details Section -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Equipment Information
                                </h6>
                                <p class="text-muted mb-0 small">Enter the basic details for the electronic equipment</p>
                            </div>

                            <div class="row g-4">
                                <!-- Equipment Name -->
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input
                                            id="inputName"
                                            type="text"
                                            name="name"
                                            class="form-control form-control-modern @error('name') is-invalid @enderror"
                                            placeholder="Enter equipment name"
                                            value="{{ old('name') }}"
                                            required
                                        >
                                        <label for="inputName">
                                            <i class="fas fa-tag me-2"></i>
                                            Equipment Name <span class="text-danger">*</span>
                                        </label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <!-- Category -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="category_id" class="form-control form-control-modern @error('category_id') is-invalid @enderror" required>
                                            <option value="">-- Select Category --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if(old('category_id', $electronics->category_id ?? '') == $category->id) selected @endif>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="category_id">
                                            <i class="fas fa-list me-2"></i>
                                            Category <span class="text-danger">*</span>
                                        </label>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="status" class="form-control form-control-modern @error('status') is-invalid @enderror" required>
                                            <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Damage" {{ old('status') == 'Damage' ? 'selected' : '' }}>Damage</option>
                                        </select>
                                        <label for="status">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Status <span class="text-danger">*</span>
                                        </label>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Create Equipment?</h6>
                                            <p class="mb-0 text-muted small">Review your equipment configuration before creating</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('backend.electronic.index') }}"
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
                                                    <i class="fas fa-check me-2"></i>
                                                    Create Electronic 
                                                </span>
                                                <span class="btn-spinner d-none">
                                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                                    Creating...
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
                        Equipment Creation Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Required Fields</div>
                                    <small class="text-white">All fields marked with * are mandatory</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-list text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Select Category</div>
                                    <small class="text-white">Choose appropriate equipment category</small>
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
                                    <small class="text-white">Review before submitting the form</small>
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
    console.log('Electronic Equipment Create Form initializing...');

    // Progress tracking function
    function updateProgress() {
        let progress = 0;
        const total = 3; // Total required fields

        // Check equipment name
        if ($('#inputName').val().trim()) progress++;
        
        // Check category
        if ($('select[name="category_id"]').val()) progress++;
        
        // Check status
        if ($('select[name="status"]').val()) progress++;

        const percentage = (progress / total) * 100;
        console.log('Progress updated:', percentage + '%');
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

    // Form validation function
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Validate equipment name
        if (!$('#inputName').val().trim()) {
            errors.push('Equipment name is required');
            isValid = false;
        }

        // Validate category
        if (!$('select[name="category_id"]').val()) {
            errors.push('Category is required');
            isValid = false;
        }

        // Validate status
        if (!$('select[name="status"]').val()) {
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

        $('#electronicCreateForm').before(alertHtml);

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
        $('#electronicCreateForm')[0].reset();
        
        // Set default status to Active
        $('select[name="status"]').val('Active');
        
        updateProgress();
        showNotification('Form has been reset', 'info');
    }

    // Event Listeners

    // Form submission with validation and loading state
    $('#electronicCreateForm').on('submit', function(e) {
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
    $('#inputName, select[name="category_id"], select[name="status"]').on('input change', function() {
        updateProgress();
    });

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (validateForm()) {
                $('#electronicCreateForm').submit();
            }
        }
        
        // Escape to focus on reset
        if (e.key === 'Escape') {
            $('#resetBtn').focus();
        }
    });

    // Add smooth scroll to form sections on focus
    $('.form-floating input, .form-floating select').on('focus', function() {
        const section = $(this).closest('.form-section');
        if (section.length) {
            section[0].scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
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

    // Initialize progress
    updateProgress();

    console.log('Electronic Equipment Create Form initialized successfully');
});
</script>
@endpush