@extends('frontend.layouts.master')
@section('title','Change Password')
@section('main-content')
<div class="modern-profile-container">
    <div class="profile-header">
        <div class="container">
            <h2 class="profile-title">
                <i class="fas fa-lock me-3"></i>
                Change Password
            </h2>
            <p class="profile-subtitle">Update your account password for better security</p>
        </div>
    </div>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="modern-form-card">
                    <div class="form-card-header">
                        <h4 class="form-title">
                            <i class="fas fa-key me-2"></i>
                            Password Security
                        </h4>
                        <p class="form-subtitle">Enter your current password and choose a new secure password</p>
                    </div>
                    <div class="form-card-body">
                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="success-container mb-4">
                                <div class="success-message">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="error-container mb-4">
                                @foreach ($errors->all() as $error)
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        {{ $error }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('change.password') }}" id="changePasswordForm">
                            @csrf
                            
                            <!-- Hidden username field for accessibility -->
                            <input type="text" name="username" value="{{ auth()->user()->email ?? '' }}" autocomplete="username" style="display: none;">
                            <div class="row g-4">
                                <!-- Current Password -->
                                <div class="col-12">
                                    <div class="modern-form-group">
                                        <label for="current_password" class="modern-form-label">
                                            <i class="fas fa-unlock-alt me-2"></i>Current Password
                                        </label>
                                        <div class="password-input-container">
                                            <input id="current_password"
                                                   type="password"
                                                   name="current_password"
                                                   placeholder="Enter your current password"
                                                   class="modern-form-input password-input @error('current_password') is-invalid @enderror"
                                                   autocomplete="current-password"
                                                   required>
                                            <button type="button" class="password-toggle" onclick="togglePassword('current_password')" tabindex="-1">
                                                <i class="fas fa-eye" id="current_password_icon"></i>
                                            </button>
                                        </div>
                                        @error('current_password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- New Password -->
                                <div class="col-12">
                                    <div class="modern-form-group">
                                        <label for="new_password" class="modern-form-label">
                                            <i class="fas fa-lock me-2"></i>New Password
                                        </label>
                                        <div class="password-input-container">
                                            <input id="new_password"
                                                   type="password"
                                                   name="new_password"
                                                   placeholder="Enter your new password"
                                                   class="modern-form-input password-input @error('new_password') is-invalid @enderror"
                                                   autocomplete="new-password"
                                                   required>
                                            <button type="button" class="password-toggle" onclick="togglePassword('new_password')" tabindex="-1">
                                                <i class="fas fa-eye" id="new_password_icon"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength" id="password_strength"></div>
                                        @error('new_password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm New Password -->
                                <div class="col-12">
                                    <div class="modern-form-group">
                                        <label for="new_confirm_password" class="modern-form-label">
                                            <i class="fas fa-check-double me-2"></i>Confirm New Password
                                        </label>
                                        <div class="password-input-container">
                                            <input id="new_confirm_password"
                                                   type="password"
                                                   name="new_confirm_password"
                                                   placeholder="Confirm your new password"
                                                   class="modern-form-input password-input @error('new_confirm_password') is-invalid @enderror"
                                                   autocomplete="new-password"
                                                   required>
                                            <button type="button" class="password-toggle" onclick="togglePassword('new_confirm_password')" tabindex="-1">
                                                <i class="fas fa-eye" id="new_confirm_password_icon"></i>
                                            </button>
                                        </div>
                                        <div class="password-match" id="password_match"></div>
                                        @error('new_confirm_password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password Requirements -->
                                <div class="col-12">
                                    <div class="password-requirements">
                                        <h6 class="requirements-title">
                                            <i class="fas fa-shield-alt me-2"></i>Password Requirements
                                        </h6>
                                        <ul class="requirements-list">
                                            <li id="length">At least 8 characters long</li>
                                            <li id="uppercase">Contains uppercase letter (A-Z)</li>
                                            <li id="lowercase">Contains lowercase letter (a-z)</li>
                                            <li id="number">Contains at least one number (0-9)</li>
                                            <li id="special">Contains special character (!@#$%^&*)</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-center pt-3">
                                        <button type="submit" class="modern-submit-btn" id="submitBtn">
                                            <i class="fas fa-shield-alt me-2"></i>
                                            Update Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Prevent double submission
    let formSubmitted = false;
    
    // Password visibility toggle
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '_icon');
        
        if (!field || !icon) return;
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    };

    // Password strength checker
    const newPasswordField = document.getElementById('new_password');
    const strengthIndicator = document.getElementById('password_strength');
    
    if (newPasswordField && strengthIndicator) {
        newPasswordField.addEventListener('input', function() {
            checkPasswordStrength(this.value);
            checkPasswordRequirements(this.value);
            
            // Also check match when new password changes
            const confirmField = document.getElementById('new_confirm_password');
            if (confirmField && confirmField.value) {
                checkPasswordMatch(this.value, confirmField.value);
            }
        });
    }

    // Password match checker
    const confirmPasswordField = document.getElementById('new_confirm_password');
    const matchIndicator = document.getElementById('password_match');
    
    if (confirmPasswordField && matchIndicator) {
        confirmPasswordField.addEventListener('input', function() {
            const newPassword = newPasswordField ? newPasswordField.value : '';
            checkPasswordMatch(newPassword, this.value);
        });
    }

    function checkPasswordStrength(password) {
        if (!strengthIndicator) return;
        
        let strength = 0;
        let strengthText = '';
        let strengthClass = '';
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;
        
        switch(strength) {
            case 0:
            case 1:
                strengthText = 'Very Weak';
                strengthClass = 'very-weak';
                break;
            case 2:
                strengthText = 'Weak';
                strengthClass = 'weak';
                break;
            case 3:
                strengthText = 'Fair';
                strengthClass = 'fair';
                break;
            case 4:
                strengthText = 'Good';
                strengthClass = 'good';
                break;
            case 5:
                strengthText = 'Strong';
                strengthClass = 'strong';
                break;
        }
        
        if (password.length > 0) {
            strengthIndicator.innerHTML = `<i class="fas fa-shield-alt me-1"></i>Password Strength: <span class="${strengthClass}">${strengthText}</span>`;
            strengthIndicator.style.display = 'block';
        } else {
            strengthIndicator.style.display = 'none';
        }
    }

    function checkPasswordRequirements(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[^a-zA-Z0-9]/.test(password)
        };

        Object.keys(requirements).forEach(req => {
            const element = document.getElementById(req);
            if (!element) return;
            
            if (requirements[req]) {
                element.classList.add('requirement-met');
                element.classList.remove('requirement-not-met');
            } else {
                element.classList.add('requirement-not-met');
                element.classList.remove('requirement-met');
            }
        });
    }

    function checkPasswordMatch(password, confirmPassword) {
        if (!matchIndicator) return;
        
        if (confirmPassword.length > 0) {
            if (password === confirmPassword) {
                matchIndicator.innerHTML = '<i class="fas fa-check me-1"></i>Passwords match';
                matchIndicator.className = 'password-match match-success';
            } else {
                matchIndicator.innerHTML = '<i class="fas fa-times me-1"></i>Passwords do not match';
                matchIndicator.className = 'password-match match-error';
            }
            matchIndicator.style.display = 'block';
        } else {
            matchIndicator.style.display = 'none';
        }
    }

    // Form submission with validation
    const form = document.getElementById('changePasswordForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Prevent double submission
            if (formSubmitted) {
                e.preventDefault();
                return;
            }
            
            // Basic validation
            const currentPassword = document.getElementById('current_password')?.value;
            const newPassword = document.getElementById('new_password')?.value;
            const confirmPassword = document.getElementById('new_confirm_password')?.value;
            
            if (!currentPassword || !newPassword || !confirmPassword) {
                e.preventDefault();
                alert('Please fill in all password fields.');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('New passwords do not match.');
                return;
            }
            
            if (newPassword.length < 8) {
                e.preventDefault();
                alert('New password must be at least 8 characters long.');
                return;
            }
            
            // Mark as submitted and update button
            formSubmitted = true;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating Password...';
            
            // Re-enable button after 5 seconds in case of server error
            setTimeout(() => {
                if (formSubmitted) {
                    formSubmitted = false;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-shield-alt me-2"></i>Update Password';
                }
            }, 5000);
        });
    }

    // Clear form on successful submission (if redirected back)
    @if(session('success'))
        // Clear form fields on success
        const formElements = ['current_password', 'new_password', 'new_confirm_password'];
        formElements.forEach(elementId => {
            const element = document.getElementById(elementId);
            if (element) element.value = '';
        });
        
        // Hide indicators
        if (strengthIndicator) strengthIndicator.style.display = 'none';
        if (matchIndicator) matchIndicator.style.display = 'none';
        
        // Reset requirements styling
        const requirementElements = ['length', 'uppercase', 'lowercase', 'number', 'special'];
        requirementElements.forEach(req => {
            const element = document.getElementById(req);
            if (element) {
                element.classList.remove('requirement-met', 'requirement-not-met');
            }
        });
    @endif
});
</script>
@endpush