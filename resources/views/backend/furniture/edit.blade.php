@extends('backend.layouts.master')
@section('title', 'Furniture Equipment Edit')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-edit me-2"></i>
                        Edit Furniture Equipment
                    </h2>
                    <p class="text-muted mb-0">Update furniture equipment details and specifications</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-primary text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-edit me-1"></i>
                        Edit Mode
                    </div>
                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-hashtag me-1"></i>
                        ID: {{ $furniture->no_furniture }}
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
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-cog me-2"></i>
                                Equipment Configuration
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Update equipment details and specifications
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="creation-info">
                                <small class="d-block opacity-75">Equipment ID:</small>
                                <strong>{{ $furniture->no_furniture }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body bg-light p-4">
                    <form method="POST" action="{{ route('furniture.update', $furniture->no_furniture) }}" id="electronicEditForm">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Equipment Details Section -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Equipment Information
                                </h6>
                                <p class="text-muted mb-0 small">Update the details for this furniture equipment</p>
                            </div>

                            <div class="row g-4">
                                <!-- Equipment Name -->
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input
                                            id="inputTitle"
                                            type="text"
                                            name="name"
                                            class="form-control form-control-modern @error('name') is-invalid @enderror"
                                            placeholder="Enter equipment name"
                                            value="{{ old('name', $furniture->name) }}"
                                            required
                                        >
                                        <label for="inputTitle">
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
                                                    {{ (old('category_id', $furniture->category_id ?? '') == $category->id) ? 'selected' : '' }}>
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
                                            <option value="">-- Select Status --</option>
                                            <option value="Active" {{ old('status', $furniture->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Damage" {{ old('status', $furniture->status) == 'Damage' ? 'selected' : '' }}>Damage</option>
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

                        <!-- Current Values Display -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number-info">i</span>
                                    Current Values
                                </h6>
                                <p class="text-muted mb-0 small">Review current equipment information</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-tag text-primary me-2"></i>
                                                    <strong>Current Name:</strong>
                                                </div>
                                                <div class="info-value text-muted">{{ $furniture->name }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-list text-primary me-2"></i>
                                                    <strong>Current Category:</strong>
                                                </div>
                                                <div class="info-value text-muted">
                                                    {{ $categories->firstWhere('id', $furniture->category_id)->name ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-check-circle text-primary me-2"></i>
                                                    <strong>Current Status:</strong>
                                                </div>
                                                <div class="info-value">
                                                    <span class="badge {{ $furniture->status == 'Active' ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                                        {{ $furniture->status }}
                                                    </span>
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
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Update Equipment?</h6>
                                            <p class="mb-0 text-muted small">Review your changes before updating the equipment</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('backend.furniture.index') }}"
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
                                                    Update Furniture
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
                        Equipment Update Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Review Changes</div>
                                    <small class="text-white">Compare with current values before updating</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-save text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Save Changes</div>
                                    <small class="text-white">Click update to save your modifications</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-undo text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Reset Form</div>
                                    <small class="text-white">Use reset to restore original values</small>
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
    console.log('Furniture Edit Form initializing...');

    // Store original values for reset functionality
    const originalValues = {
        name: $('#inputTitle').val(),
        category_id: $('select[name="category_id"]').val(),
        status: $('select[name="status"]').val()
    };

    // Check if form has changes
    function hasChanges() {
        return (
            $('#inputTitle').val() !== originalValues.name ||
            $('select[name="category_id"]').val() !== originalValues.category_id ||
            $('select[name="status"]').val() !== originalValues.status
        );
    }

    // Update form state based on changes
    function updateFormState() {
        const changed = hasChanges();
        
        if (changed) {
            $('#submitBtn').removeClass('btn-outline-warning').addClass('btn-warning text-white');
            $('.form-summary h6').text('Changes Detected - Ready to Update?');
            $('.form-summary p').text('You have unsaved changes. Click update to save them.');
        } else {
            $('#submitBtn').removeClass('btn-warning text-white').addClass('btn-outline-warning');
            $('.form-summary h6').text('No Changes Made');
            $('.form-summary p').text('Make changes to the form fields to enable update.');
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

    // Form validation function
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Validate equipment name
        if (!$('#inputTitle').val().trim()) {
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

        $('#electronicEditForm').before(alertHtml);

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
        console.log('Resetting form to original values...');
        
        // Reset to original values
        $('#inputTitle').val(originalValues.name);
        $('select[name="category_id"]').val(originalValues.category_id);
        $('select[name="status"]').val(originalValues.status);
        
        updateProgress();
        updateFormState();
        showNotification('Form has been reset to original values', 'info');
    }

    // Event Listeners

    // Form submission with validation and loading state
    $('#electronicEditForm').on('submit', function(e) {
        console.log('Form submitted');
        
        const btnText = $('#submitBtn .btn-text');
        const btnSpinner = $('#submitBtn .btn-spinner');
        
        // Check if there are changes
        if (!hasChanges()) {
            e.preventDefault();
            showNotification('No changes detected. Please make changes before updating.', 'warning');
            return;
        }
        
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
        
        if (hasChanges()) {
            if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
                resetForm();
            }
        } else {
            showNotification('No changes to reset', 'info');
        }
    });

    // Form field change listeners
    $('#inputTitle, select[name="category_id"], select[name="status"]').on('input change', function() {
        updateProgress();
        updateFormState();
    });

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (hasChanges() && validateForm()) {
                $('#electronicEditForm').submit();
            }
        }
        
        // Ctrl+R to reset (prevent default browser refresh)
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            if (hasChanges()) {
                resetForm();
            }
        }
        
        // Escape to focus on reset
        if (e.key === 'Escape') {
            $('#resetBtn').focus();
        }
    });

    // Warn user about unsaved changes when leaving page
    $(window).on('beforeunload', function(e) {
        if (hasChanges()) {
            const message = 'You have unsaved changes. Are you sure you want to leave?';
            e.returnValue = message;
            return message;
        }
    });

    // Remove beforeunload warning when form is submitted
    $('#electronicEditForm').on('submit', function() {
        $(window).off('beforeunload');
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

    // Initialize progress and form state
    updateProgress();
    updateFormState();

    console.log('Furniture Edit Form initialized successfully');
    console.log('Original values:', originalValues);
});
</script>
@endpush