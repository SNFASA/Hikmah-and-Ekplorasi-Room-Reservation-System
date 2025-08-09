@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-user-plus me-2"></i>
                        Add New User
                    </h2>
                    <p class="text-muted mb-0">Create a new user account with role and permissions</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-success text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-plus me-1"></i>
                        New User
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
            <div class="card user-card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-0 fw-bold text-white">
                                <i class="fas fa-cog me-2 text-white"></i>
                                User Configuration
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Set up user details, role, and access permissions
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
                    <form method="POST" action="{{ route('users.store') }}" id="userCreateForm">
                        @csrf

                        <!-- Step 1: Personal Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Personal Information
                                </h6>
                                <p class="text-muted mb-0 small">Enter the basic personal details for the user</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Student ID -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input
                                                    id="inputno_matriks"
                                                    type="text"
                                                    name="no_matriks"
                                                    class="form-control form-control-modern @error('no_matriks') is-invalid @enderror"
                                                    placeholder="Enter No Matriks"
                                                    value="{{ old('no_matriks') }}"
                                                    required
                                                >
                                                <label for="inputno_matriks">
                                                    <i class="fas fa-id-card me-2 text-primary"></i>
                                                    No Matriks <span class="text-danger">*</span>
                                                </label>
                                                @error('no_matriks')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Full Name -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input
                                                    id="inputname"
                                                    type="text"
                                                    name="name"
                                                    class="form-control form-control-modern @error('name') is-invalid @enderror"
                                                    placeholder="Enter Full Name"
                                                    value="{{ old('name') }}"
                                                    required
                                                >
                                                <label for="inputname">
                                                    <i class="fas fa-user me-2 text-success"></i>
                                                    Full Name <span class="text-danger">*</span>
                                                </label>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email Address -->
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input
                                                    id="inputEmail"
                                                    type="email"
                                                    name="email"
                                                    class="form-control form-control-modern @error('email') is-invalid @enderror"
                                                    placeholder="Enter Email Address"
                                                    value="{{ old('email') }}"
                                                    required
                                                >
                                                <label for="inputEmail">
                                                    <i class="fas fa-envelope me-2 text-info"></i>
                                                    Email Address <span class="text-danger">*</span>
                                                </label>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Role & Access -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Role & Access Control
                                </h6>
                                <p class="text-muted mb-0 small">Define user role and organizational access</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- User Role -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="role" class="form-control form-control-modern @error('role') is-invalid @enderror" required>
                                                    <option value="">-- Select User Role --</option>
                                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                        Administrator
                                                    </option>
                                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                                        Regular User
                                                    </option>
                                                    <option value="ppp" {{ old('role') == 'ppp' ? 'selected' : '' }}>
                                                        PPP Staff
                                                    </option>
                                                </select>
                                                <label for="role">
                                                    <i class="fas fa-user-tag me-2 text-warning"></i>
                                                    User Role <span class="text-danger">*</span>
                                                </label>
                                                @error('role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Faculty Office -->
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="facultyOffice" class="form-control form-control-modern @error('facultyOffice') is-invalid @enderror">
                                                    <option value="">-- Select Faculty Office --</option>
                                                    @php
                                                        $facultyOffices = DB::table('faculty_Offices')->select('no_facultyOffice', 'name')->get();
                                                    @endphp
                                                    @foreach($facultyOffices as $office)
                                                        <option value="{{ $office->no_facultyOffice }}" {{ old('facultyOffice') == $office->no_facultyOffice ? 'selected' : '' }}>
                                                            {{ $office->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="facultyOffice">
                                                    <i class="fas fa-building me-2 text-purple"></i>
                                                    Faculty Office
                                                </label>
                                                @error('facultyOffice')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Course -->
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <select name="course" class="form-control form-control-modern @error('course') is-invalid @enderror">
                                                    <option value="">-- Select Course --</option>
                                                    @php
                                                        $courses = DB::table('courses')->select('no_course', 'name')->get();
                                                    @endphp
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->no_course }}" {{ old('course') == $course->no_course ? 'selected' : '' }}>
                                                            {{ $course->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="course">
                                                    <i class="fas fa-graduation-cap me-2 text-pink"></i>
                                                    Course/Program
                                                </label>
                                                @error('course')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Security Settings -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">3</span>
                                    Security Settings
                                </h6>
                                <p class="text-muted mb-0 small">Set up secure login credentials</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <!-- Password -->
                                        <div class="col-md-6">
                                            <div class="form-floating password-field">
                                                <input
                                                    id="inputPassword"
                                                    type="password"
                                                    name="password"
                                                    class="form-control form-control-modern @error('password') is-invalid @enderror"
                                                    placeholder="Enter Password"
                                                    required
                                                >
                                                <label for="inputPassword">
                                                    <i class="fas fa-lock me-2 text-orange"></i>
                                                    Password <span class="text-danger">*</span>
                                                </label>
                                                <button type="button" class="btn btn-outline-secondary position-absolute end-0 top-50 translate-middle-y me-3 border-0 toggle-password" data-target="inputPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="col-md-6">
                                            <div class="form-floating password-field">
                                                <input
                                                    id="inputPasswordConfirmation"
                                                    type="password"
                                                    name="password_confirmation"
                                                    class="form-control form-control-modern @error('password_confirmation') is-invalid @enderror"
                                                    placeholder="Confirm Password"
                                                    required
                                                >
                                                <label for="inputPasswordConfirmation">
                                                    <i class="fas fa-lock me-2 text-orange"></i>
                                                    Confirm Password <span class="text-danger">*</span>
                                                </label>
                                                <button type="button" class="btn btn-outline-secondary position-absolute end-0 top-50 translate-middle-y me-3 border-0 toggle-password" data-target="inputPasswordConfirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Password Requirements -->
                                    <div class="password-requirements mt-3">
                                        <small class="text-muted d-block mb-2">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Password Requirements:
                                        </small>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="list-unstyled small text-muted">
                                                    <li><i class="fas fa-check-circle text-success me-1"></i> At least 8 characters</li>
                                                    <li><i class="fas fa-check-circle text-success me-1"></i> One uppercase letter</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled small text-muted">
                                                    <li><i class="fas fa-check-circle text-success me-1"></i> One number</li>
                                                    <li><i class="fas fa-check-circle text-success me-1"></i> One special character</li>
                                                </ul>
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
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Create User?</h6>
                                            <p class="mb-0 text-muted small">Review user information before creating the account</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('users.index') }}"
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
                                                    Create User
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
                        User Creation Tips
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
                                    <i class="fas fa-shield-alt text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Strong Password</div>
                                    <small class="text-white">Follow security requirements for passwords</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-user-check text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Role Selection</div>
                                    <small class="text-white">Choose appropriate role for user access</small>
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
    console.log('User Create Form initializing...');
    
    // Password visibility toggle
    $('.toggle-password').on('click', function() {
        const targetId = $(this).data('target');
        const passwordField = $(`#${targetId}`);
        const icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Form validation function
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Validate No Matriks
        if (!$('#inputno_matriks').val().trim()) {
            errors.push('No Matriks is required');
            isValid = false;
        }

        // Validate name
        if (!$('#inputname').val().trim()) {
            errors.push('Full name is required');
            isValid = false;
        }

        // Validate email
        const email = $('#inputEmail').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            errors.push('Email address is required');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            errors.push('Please enter a valid email address');
            isValid = false;
        }

        // Validate role
        if (!$('select[name="role"]').val()) {
            errors.push('User role is required');
            isValid = false;
        }

        // Validate password
        const password = $('#inputPassword').val();
        if (!password) {
            errors.push('Password is required');
            isValid = false;
        } else {
            // Password strength validation
            if (password.length < 8) {
                errors.push('Password must be at least 8 characters long');
                isValid = false;
            }
            if (!/[A-Z]/.test(password)) {
                errors.push('Password must contain at least one uppercase letter');
                isValid = false;
            }
            if (!/[0-9]/.test(password)) {
                errors.push('Password must contain at least one number');
                isValid = false;
            }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                errors.push('Password must contain at least one special character');
                isValid = false;
            }
        }

        // Validate password confirmation
        const passwordConfirmation = $('#inputPasswordConfirmation').val();
        if (password !== passwordConfirmation) {
            errors.push('Password confirmation does not match');
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

        $('#userCreateForm').before(alertHtml);

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

        // Auto-remove after 4 seconds
        setTimeout(() => {
            $('.notification-alert').fadeOut(300, function() {
                $(this).remove();
            });
        }, 4000);
    }

    // Real-time password strength indicator
    $('#inputPassword').on('input', function() {
        const password = $(this).val();
        updatePasswordStrength(password);
    });

    function updatePasswordStrength(password) {
        const requirements = [
            { test: password.length >= 8, text: 'At least 8 characters' },
            { test: /[A-Z]/.test(password), text: 'One uppercase letter' },
            { test: /[0-9]/.test(password), text: 'One number' },
            { test: /[!@#$%^&*(),.?":{}|<>]/.test(password), text: 'One special character' }
        ];

        $('.password-requirements li').each(function(index) {
            const icon = $(this).find('i');
            if (requirements[index].test) {
                icon.removeClass('text-muted').addClass('text-success');
            } else {
                icon.removeClass('text-success').addClass('text-muted');
            }
        });
    }

    // Form submission handling
    $('#userCreateForm').on('submit', function(e) {
        console.log('Form submitted');
        
        const btnText = $('#submitBtn .btn-text');
        const btnSpinner = $('#submitBtn .btn-spinner');
        
        // Validate form
        if (!validateForm()) {
            e.preventDefault();
            return;
        }
        
        // Show loading state
        btnText.addClass('d-none');
        btnSpinner.removeClass('d-none');
        $('#submitBtn').prop('disabled', true);
        
        showNotification('Creating user account...', 'info');
    });

    // Reset form function
    $('#resetBtn').on('click', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            $('#userCreateForm')[0].reset();
            $('.validation-alert').remove();
            updatePasswordStrength('');
            showNotification('Form has been reset', 'info');
        }
    });

    // Auto-fill email based on No Matriks (if follows pattern)
    $('#inputno_matriks').on('blur', function() {
        const noMatriks = $(this).val().trim();
        const emailField = $('#inputEmail');
        
        if (noMatriks && !emailField.val()) {
            // Suggest email format (adjust according to your institution's format)
            const suggestedEmail = `${noMatriks.toLowerCase()}@student.edu.my`;
            emailField.val(suggestedEmail);
            showNotification('Email auto-suggested based on No Matriks', 'info');
        }
    });

    // Form field validation on blur
    $('.form-control-modern').on('blur', function() {
        const field = $(this);
        const value = field.val().trim();
        
        // Remove existing validation classes
        field.removeClass('is-valid is-invalid');
        
        if (field.prop('required') && !value) {
            field.addClass('is-invalid');
        } else if (value) {
            // Email specific validation
            if (field.attr('type') === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailRegex.test(value)) {
                    field.addClass('is-valid');
                } else {
                    field.addClass('is-invalid');
                }
            } else {
                field.addClass('is-valid');
            }
        }
    });

    // Password confirmation matching
    $('#inputPasswordConfirmation').on('input', function() {
        const password = $('#inputPassword').val();
        const confirmation = $(this).val();
        
        $(this).removeClass('is-valid is-invalid');
        
        if (confirmation && password === confirmation) {
            $(this).addClass('is-valid');
        } else if (confirmation) {
            $(this).addClass('is-invalid');
        }
    });

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (validateForm()) {
                $('#userCreateForm').submit();
            }
        }
        
        // Escape to focus on reset
        if (e.key === 'Escape') {
            $('#resetBtn').focus();
        }
    });

    // Form progress indication (visual feedback)
    function updateFormProgress() {
        const requiredFields = ['#inputno_matriks', '#inputname', '#inputEmail', 'select[name="role"]', '#inputPassword', '#inputPasswordConfirmation'];
        let filledFields = 0;
        
        requiredFields.forEach(selector => {
            if ($(selector).val().trim()) {
                filledFields++;
            }
        });
        
        const progress = (filledFields / requiredFields.length) * 100;
        
        // Update progress indicator (if you want to add one)
        console.log('Form completion:', Math.round(progress) + '%');
    }

    // Track form progress on input
    $('.form-control-modern').on('input change', function() {
        updateFormProgress();
    });

    // Initialize tooltips (if Bootstrap is available)
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Animate elements on page load
    setTimeout(() => {
        $('.form-section').each(function(index) {
            const element = $(this);
            setTimeout(() => {
                element.addClass('fade-in');
            }, index * 200);
        });
    }, 100);

    console.log('User Create Form initialized successfully');
    showNotification('Form ready for user creation', 'info');
});
</script>
@endpush