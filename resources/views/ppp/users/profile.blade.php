@extends('backend.layouts.master')

@section('title','Admin Profile')

@section('main-content')

<!-- Main Container with Enhanced Styling -->
<div class="container-fluid px-4">
    <!-- Header Section with Gradient Background -->
    <div class="header-section mb-4">
        <div class="row align-items-center">
            <div class="col-12">
                @include('backend.layouts.notification') <!--tukar-->
            </div>
        </div>
        
        <div class="header-content d-flex flex-column flex-lg-row justify-content-between align-items-center">
            <div class="header-title">
                <h1 class="main-title text-white">
                    <i class="fas fa-user-circle me-3"></i>
                    Profile Management
                </h1>
                <p class="subtitle">Manage your account information and settings</p>
            </div>
            <div class="header-actions mt-3 mt-lg-0">
                <nav class="modern-breadcrumb">
                    <a href="{{ route('ppp.dashboard') }}" class="breadcrumb-item"><!--tukar-->
                        <i class="fas fa-home me-1"></i>
                        Dashboard
                    </a>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-current">Profile</span>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="modern-card">
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Profile Card Section -->
                <div class="col-lg-4">
                    <div class="profile-section">
                        <div class="profile-header">
                            <div class="profile-background">
                                <div class="background-overlay"></div>
                                <img src="{{ asset('backend/img/background.jpg') }}" alt="Background" class="background-image">
                            </div>
                            <div class="profile-avatar">
                                <div class="avatar-container">
                                    <img src="{{ asset('backend/img/avatar.png') }}" alt="Profile Picture" class="avatar-image">
                                    <div class="avatar-status online"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="profile-info">
                            <h3 class="profile-name">
                                <i class="fas fa-user me-2"></i>
                                {{ $profile->name }}
                            </h3>
                            
                            <div class="profile-details">
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div class="detail-content">
                                        <span class="detail-label">Matrix Number</span>
                                        <span class="detail-value">{{ $profile->no_matriks }}</span>
                                    </div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="detail-content">
                                        <span class="detail-label">Email Address</span>
                                        <span class="detail-value">{{ $profile->email }}</span>
                                    </div>
                                </div>
                                
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <div class="detail-content">
                                        <span class="detail-label">Role</span>
                                        <span class="role-badge role-{{ strtolower($profile->role) }}">
                                            {{ ucfirst($profile->role) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Form Section -->
                <div class="col-lg-8">
                    <div class="form-section">
                        <div class="form-header">
                            <h3 class="form-title">
                                <i class="fas fa-edit me-2"></i>
                                Edit Profile Information
                            </h3>
                            <p class="form-subtitle">Update your account details below</p>
                        </div>
                        
                        <form method="POST" action="{{ route('ppp.profile-update', $profile->id) }}" class="modern-form"><!--tukar-->
                            @csrf

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="no_matriks" class="form-label">
                                        <i class="fas fa-id-card me-2"></i>
                                        Matrix Number
                                    </label>
                                    <div class="input-group">
                                        <input id="no_matriks" 
                                               type="text" 
                                               name="no_matriks" 
                                               value="{{ old('no_matriks', $profile->no_matriks) }}" 
                                               class="form-control modern-input" 
                                               placeholder="Enter Matrix Number">
                                    </div>
                                    @error('no_matriks')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-2"></i>
                                        Full Name
                                    </label>
                                    <div class="input-group">
                                        <input id="name" 
                                               type="text" 
                                               name="name" 
                                               value="{{ old('name', $profile->name) }}" 
                                               class="form-control modern-input" 
                                               placeholder="Enter Full Name">
                                    </div>
                                    @error('name')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>
                                    Email Address
                                </label>
                                <div class="input-group">
                                    <input id="email" 
                                           type="email" 
                                           name="email" 
                                           value="{{ old('email', $profile->email) }}" 
                                           class="form-control modern-input" 
                                           placeholder="Enter Email Address">
                                </div>
                                @error('email')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="role" class="form-label">
                                        <i class="fas fa-user-tag me-2"></i>
                                        Role
                                    </label>
                                    <div class="input-group">
                                        <select id="role" name="role" class="form-control-modern modern-select">
                                            <option value="">-- Select Role --</option>
                                            <option value="ppp" {{ (old('role', $profile->role) == 'ppp') ? 'selected' : '' }}>PPP</option>
                                            <option value="user" {{ (old('role', $profile->role) == 'user') ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ (old('role', $profile->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                    @error('role')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="facultyOffice" class="form-label">
                                        <i class="fas fa-building me-2"></i>
                                        Faculty Office
                                    </label>
                                    <div class="input-group">
                                        <select id="facultyOffice" name="facultyOffice" class="form-control-modern modern-select">
                                            <option value="">-- Select Faculty Office --</option>
                                            @foreach($facultyOffices as $office)
                                                <option value="{{ $office->no_facultyOffice }}" 
                                                    {{ old('facultyOffice', $profile->facultyOffice) == $office->no_facultyOffice ? 'selected' : '' }}>
                                                    {{ $office->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('facultyOffice')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <button type="submit" class="btn btn-update">
                                    <i class="fas fa-save me-2"></i>
                                    <span>Update Profile</span>
                                </button>
                                <a href="{{ route('ppp.dashboard') }}" class="btn btn-cancel"><!--tukar-->
                                    <i class="fas fa-times me-2"></i>
                                    <span>Cancel</span>
                                </a>
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
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
$(document).ready(function() {
    // Initialize file manager if needed
    $('#lfm').filemanager('image');
    
    // Form input animations
    $('.modern-input, .modern-select').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
    
    // Form validation enhancement
    $('form').on('submit', function(e) {
        var hasError = false;
        
        // Check required fields
        $(this).find('.modern-input[required], .modern-select[required]').each(function() {
            if (!$(this).val()) {
                hasError = true;
                $(this).addClass('error');
                $(this).focus();
                return false;
            } else {
                $(this).removeClass('error');
            }
        });
        
        if (hasError) {
            e.preventDefault();
            // Show error message
            swal({
                title: "Validation Error",
                text: "Please fill in all required fields.",
                icon: "error",
                button: "OK"
            });
        }
    });
    
    // Remove error class on input
    $('.modern-input, .modern-select').on('input change', function() {
        $(this).removeClass('error');
    });
    
    // Animate elements on load
    setTimeout(function() {
        $('.detail-item').each(function(index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
        });
    }, 100);
});
</script>
@endpush