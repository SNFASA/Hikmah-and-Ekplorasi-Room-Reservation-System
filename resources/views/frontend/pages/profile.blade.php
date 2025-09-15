@extends('frontend.layouts.master')
@section('title','User Profile')
@section('main-content')
<div class="modern-profile-container">
    <div class="profile-header">
        <div class="container">
            <h2 class="profile-title">
                <i class="fas fa-user-circle me-3"></i>
                User Profile
            </h2>
            <p class="profile-subtitle">Manage your personal information and preferences</p>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <!-- Profile Card -->
            <div class="col-lg-4 col-md-12">
                <div class="modern-profile-card">
                    <div class="profile-card-header">
                        <div class="profile-image-container">
                            <img class="profile-avatar" src="{{asset('backend/img/avatar.png')}}" alt="Profile Picture">
                            <div class="profile-status-badge">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="profile-card-body">
                        <h5 class="profile-name">{{$profile->name}}</h5>
                        <div class="profile-info-item">
                            <i class="fas fa-id-card profile-icon"></i>
                            <span class="profile-text">{{$profile->no_matriks}}</span>
                        </div>
                        <div class="profile-info-item">
                            <i class="fas fa-envelope profile-icon"></i>
                            <span class="profile-text">{{$profile->email}}</span>
                        </div>
                        <div class="profile-info-item">
                            <i class="fas fa-user-tag profile-icon"></i>
                            <span class="profile-role">{{ucfirst($profile->role)}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="col-lg-8 col-md-12">
                <div class="modern-form-card">
                    <div class="form-card-header">
                        <h4 class="form-title">
                            <i class="fas fa-edit me-2"></i>
                            Edit Profile Information
                        </h4>
                    </div>
                    <div class="form-card-body">
                        <form method="POST" action="{{route('user-profile-update', $profile->id)}}">
                            @csrf
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-12">
                                    <div class="modern-form-group">
                                        <label for="inputTitle" class="modern-form-label">
                                            <i class="fas fa-user me-2"></i>Full Name
                                        </label>
                                        <input id="inputTitle" type="text" name="name" placeholder="Enter your full name"
                                               value="{{$profile->name}}"
                                               class="modern-form-input @error('name') is-invalid @enderror">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Matric Number -->
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label for="inputNoMatriks" class="modern-form-label">
                                            <i class="fas fa-id-card me-2"></i>Matric Number
                                        </label>
                                        <input id="inputNoMatriks" type="text" name="no_matriks"
                                               placeholder="Enter matric number"
                                               value="{{$profile->no_matriks}}"
                                               class="modern-form-input @error('no_matriks') is-invalid @enderror">
                                        @error('no_matriks')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label for="inputEmail" class="modern-form-label">
                                            <i class="fas fa-envelope me-2"></i>Email Address
                                        </label>
                                        <input id="inputEmail" type="email" name="email"
                                               placeholder="Enter email address"
                                               value="{{$profile->email}}"
                                               class="modern-form-input @error('email') is-invalid @enderror">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Faculty Office -->
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label for="facultyOffice" class="modern-form-label">
                                            <i class="fas fa-building me-2"></i>Faculty Office
                                        </label>
                                        <select name="facultyOffice" id="facultyOffice"
                                                class="choices-select @error('facultyOffice') is-invalid @enderror">
                                            <option  value="">Select Faculty Office</option>
                                            @foreach($facultyOffices as $office)
                                                <option value="{{ $office->no_facultyOffice }}"
                                                    {{ $office->no_facultyOffice == $profile->facultyOffice ? 'selected' : '' }}>
                                                    {{ $office->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('facultyOffice')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Course -->
                                <div class="col-md-6">
                                    <div class="modern-form-group">
                                        <label for="course" class="modern-form-label">
                                            <i class="fas fa-graduation-cap me-2"></i>Course
                                        </label>
                                        <select name="course" id="course"
                                                class="choices-select @error('course') is-invalid @enderror">
                                            <option value="">Select Course</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->no_course }}"
                                                    {{ $course->no_course == $profile->course ? 'selected' : '' }}>
                                                    {{ $course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('course')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-end pt-3">
                                        <button type="submit" class="modern-submit-btn">
                                            <i class="fas fa-save me-2"></i>
                                            Update Profile
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Choices.js only once
    let facultyChoices = null;
    let courseChoices = null;
    
    // Faculty Office Dropdown
    const facultySelect = document.getElementById('facultyOffice');
    if (facultySelect) {
        facultyChoices = new Choices(facultySelect, {
            searchEnabled: true,
            removeItemButton: false,
            shouldSort: false,
            placeholderValue: 'Select Faculty Office',
            noChoicesText: 'No faculty offices available',
            noResultsText: 'No faculty offices found',
            itemSelectText: 'Press to select',
        });
    }
    
    // Course Dropdown
    const courseSelect = document.getElementById('course');
    if (courseSelect) {
        courseChoices = new Choices(courseSelect, {
            searchEnabled: true,
            removeItemButton: false,
            shouldSort: false,
            placeholderValue: 'Select Course',
            noChoicesText: 'No courses available',
            noResultsText: 'No courses found',
            itemSelectText: 'Press to select',
        });
    }
    
    // Form submission handler
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.modern-submit-btn');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            }
        });
    }
    
    // Input validation feedback
    document.querySelectorAll('.modern-form-input').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() !== '') {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
    });
});
</script>

<style>
/* Choices.js Custom Styling */
.choices {
    margin-bottom: 0;
}

.choices__inner {
    background-color: white;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.95rem;
    min-height: 48px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.choices__inner:hover {
    border-color: #1a1660;
}

.choices.is-focused .choices__inner {
    border-color: #1a1660;
    box-shadow: 0 0 0 0.2rem rgba(26, 22, 96, 0.1);
    background-color: #f8f9ff;
}

.choices__list--single {
    padding: 0;
}

.choices__item--selectable {
    color: #495057;
    font-weight: 500;
    
    
}

.choices__placeholder {
    color: #6c757d;
    opacity: 1;
}

/* Dropdown styling */
.choices__list--dropdown {
    background-color: white;
    border: 2px solid #1a1660;
    border-top: none;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 8px 25px rgba(23, 18, 88, 0.15);
    z-index: 1050;
}

.choices__list--dropdown .choices__item {
    padding: 12px 16px;
    font-size: 0.95rem;
    border-bottom: 1px solid #f1f3f4;
}

.choices__list--dropdown .choices__item:last-child {
    border-bottom: none;
}

.choices__list--dropdown .choices__item--selectable {
    color: #495057;
    transition: all 0.2s ease;
    
}

.choices__list--dropdown .choices__item--selectable.is-highlighted {
    background-color: #1a1660;
    color: #1a1660;
}

/* Search input styling */
.choices__input {
    background-color: transparent;
    border: none;
    color:#1a1660;
    font-size: 0.95rem;
    padding: 0;
}

.choices__input:focus {
    outline: none;
}

/* Arrow styling */
.choices[data-type*="select-one"]:after {
    border-color: #1a1660 transparent transparent transparent;
    margin-top: -2.5px;
    right: 16px;
}

.choices[data-type*="select-one"].is-open:after {
    border-color: transparent transparent #1a1660 transparent;
    margin-top: -7.5px;
}

/* Error state */
.choices.is-invalid .choices__inner {
    border-color: #eb242b;
    background-color: #fff5f5;
}

/* Hide original selects completely */
.choices-select {
    display: none !important;
}

/* Make sure Choices container fits the form styling */
.choices {
    width: 100%;
    font-family: inherit;
}

/* Loading state for submit button */
.modern-submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.modern-submit-btn:disabled:hover {
    transform: none;
    background: linear-gradient(135deg, #171258 0%, #1a1660 100%);
}
</style>
@endpush