@extends('backend.layouts.master')
@section('title', 'Reservation Create')
@section('main-content')



<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Add New Reservation
                    </h2>
                    <p class="text-muted mb-0">Create a new room reservation</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-success text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-plus me-1"></i>
                        New reservation
                    </div>
                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Form -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <h5 class="card-title text-white mb-0 fw-bold">
                        <i class="fas fa-cog me-2"></i>
                        Reservation Configuration
                    </h5>
                </div>

                <div class="card-body bg-light p-4">
                    <form method="POST" action="{{ route('backend.reservation.store') }}" id="booking-form" enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Basic Information -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Basic Information
                                </h6>
                            </div>

                            <div class="row g-4">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                               placeholder="Enter full name" value="{{ old('name') }}" required>
                                        <label>
                                            <i class="fas fa-user me-2"></i>
                                            Name <span class="text-danger">*</span>
                                        </label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Created By -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" 
                                               value="{{ auth()->user()->name ?? 'Current User' }}" readonly>
                                        <label>
                                            <i class="fas fa-user-check me-2"></i>
                                            Created By
                                        </label>
                                        <input type="hidden" name="created_by_matric_no" value="{{ auth()->user()->student_id ?? auth()->id() }}">
                                    </div>
                                </div>

                                <!-- Staff ID/Matric No -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="staff_id_matric_no" class="form-control @error('staff_id_matric_no') is-invalid @enderror" 
                                               placeholder="Enter matric number" value="{{ old('staff_id_matric_no') }}" required>
                                        <label>
                                            <i class="fas fa-id-card me-2"></i>
                                            Staff/Matric No <span class="text-danger">*</span>
                                        </label>
                                        @error('staff_id_matric_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Contact Number -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror" 
                                               placeholder="Enter contact number" value="{{ old('contact_no') }}" required>
                                        <label>
                                            <i class="fas fa-phone me-2"></i>
                                            Contact Number <span class="text-danger">*</span>
                                        </label>
                                        @error('contact_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                               placeholder="Enter email" value="{{ old('email') }}" required>
                                        <label>
                                            <i class="fas fa-envelope me-2"></i>
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Department - Only Choices.js -->
                                <div class="col-md-6">
                                    <div class="choices-container">
                                        <select name="faculty_office_id" id="faculty_office_id" class="@error('faculty_office_id') is-invalid @enderror" required>
                                            <option value="">-- Select Department --</option>
                                            @if(isset($facultie))
                                                @foreach($facultie as $faculty)
                                                    <option value="{{ $faculty->no_facultyOffice }}" {{ old('faculty_office_id') == $faculty->no_facultyOffice ? 'selected' : '' }}>
                                                        {{ $faculty->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label class="choices-label">
                                            <i class="fas fa-building me-2"></i>
                                            Department <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    @error('faculty_office_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Purpose -->
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea name="purpose_program_name" class="form-control @error('purpose_program_name') is-invalid @enderror" 
                                                  placeholder="Enter purpose" style="height: 100px;" required>{{ old('purpose_program_name') }}</textarea>
                                        <label>
                                            <i class="fas fa-bullseye me-2"></i>
                                            Purpose/Program Name <span class="text-danger">*</span>
                                        </label>
                                        @error('purpose_program_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Room Selection -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Room Selection
                                </h6>
                            </div>

                            <div id="rooms-container">
                                <div class="room-selection-item mb-4" data-room-index="0">
                                    <div class="card border-0 bg-white shadow-sm rounded-3">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0 text-primary fw-bold">
                                                    <i class="fas fa-door-open me-2"></i>
                                                    Room Selection #1
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-room d-none">
                                                    <i class="fas fa-times me-1"></i>
                                                    Remove
                                                </button>
                                            </div>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <select name="room_selections[0][room_id]" class="form-select room-select" required>
                                                            <option value="">-- Select Room --</option>
                                                            @if(isset($rooms))
                                                                @foreach($rooms as $room)
                                                                    <option value="{{ $room->no_room }}">{{ $room->name }}</option>
                                                                @endforeach
                                                            @endif
                                                            <option value="other">Other (Please Specify)</option>
                                                        </select>
                                                        <label>
                                                            <i class="fas fa-door-open me-2"></i>
                                                            Room <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 other-room-description" style="display: none;">
                                                    <div class="form-floating">
                                                        <input type="text" name="room_selections[0][other_room_description]" class="form-control" 
                                                               placeholder="Please specify the room">
                                                        <label>
                                                            <i class="fas fa-edit me-2"></i>
                                                            Please Specify Room <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" id="add-room-btn" class="btn btn-outline-primary btn-lg rounded-pill px-4">
                                    <i class="fas fa-plus me-2"></i>
                                    Add Another Room
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Schedule Information -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">3</span>
                                    Schedule Information
                                </h6>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                                               value="{{ old('start_date') }}" required>
                                        <label>Start Date <span class="text-danger">*</span></label>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                                               value="{{ old('end_date') }}" required>
                                        <label>End Date <span class="text-danger">*</span></label>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" 
                                               value="{{ old('start_time') }}" required>
                                        <label>Start Time <span class="text-danger">*</span></label>
                                        @error('start_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" 
                                               value="{{ old('end_time') }}" required>
                                        <label>End Time <span class="text-danger">*</span></label>
                                        @error('end_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Event Information -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">4</span>
                                    Event Information
                                </h6>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" name="no_of_participants" class="form-control @error('no_of_participants') is-invalid @enderror" 
                                               placeholder="Enter number" value="{{ old('no_of_participants') }}" min="1" required>
                                        <label>
                                            <i class="fas fa-users me-2"></i>
                                            Number of Participants <span class="text-danger">*</span>
                                        </label>
                                        @error('no_of_participants')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select name="participant_category" id="participant_category" class="form-select @error('participant_category') is-invalid @enderror" required>
                                            <option value="">-- Select Category --</option>
                                            @if(isset($participant_category))
                                                @foreach($participant_category as $category)
                                                    <option value="{{ $category }}" {{ old('participant_category') == $category ? 'selected' : '' }}>
                                                        {{ $category }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label>
                                            <i class="fas fa-users me-2"></i>
                                            Participant Category <span class="text-danger">*</span>
                                        </label>
                                        @error('participant_category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select name="event_type" class="form-select @error('event_type') is-invalid @enderror" required>
                                            <option value="">-- Select Type --</option>
                                            @if(isset($event_type))
                                                @foreach($event_type as $type)
                                                    <option value="{{ $type }}" {{ old('event_type') == $type ? 'selected' : '' }}>
                                                        {{ $type }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label>
                                            <i class="fas fa-desktop me-2"></i>
                                            Event Type <span class="text-danger">*</span>
                                        </label>
                                        @error('event_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12" id="other-participant-category" style="display: none;">
                                    <div class="form-floating">
                                        <input type="text" name="other_participant_category" class="form-control" 
                                               placeholder="Specify category" value="{{ old('other_participant_category') }}">
                                        <label>
                                            <i class="fas fa-info-circle me-2"></i>
                                            Other Participant Category <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Document Upload -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">5</span>
                                    Document Upload
                                </h6>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <div class="upload-area p-4 text-center" id="upload-area">
                                        <input type="file" name="document_file" id="document_file" class="d-none" 
                                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                        <div class="upload-content">
                                            <div class="upload-icon mb-3">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                                            </div>
                                            <h6 class="text-primary fw-bold mb-2">Click to Upload Document</h6>
                                            <p class="text-muted mb-0">
                                                Tentative/Program Poster/Official Letter<br>
                                                <small>PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</small>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div id="file-preview-area" class="mt-4" style="display: none;">
                                        <div class="card border-success">
                                            <div class="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 text-success">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    Document Uploaded Successfully
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger" id="remove-file-btn">
                                                    <i class="fas fa-times me-1"></i>
                                                    Remove
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-3">
                                                        <div class="text-center" id="file-preview-container"></div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="file-details">
                                                            <div class="row g-3">
                                                                <div class="col-sm-6">
                                                                    <strong>File Name:</strong>
                                                                    <div class="text-truncate" id="file-name-display"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <strong>File Size:</strong>
                                                                    <div id="file-size-display"></div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <strong>File Type:</strong>
                                                                    <div id="file-type-display"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @error('document_file')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: Declaration -->
                        <div class="form-section mb-5">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">6</span>
                                    Declaration Statement
                                </h6>
                            </div>
                            
                            <div class="card border-0 bg-light rounded-3">
                                <div class="card-body p-4">
                                    <div class="declaration-content mb-4">
                                        <h6 class="text-dark fw-bold mb-3">Terms and Conditions</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>I am fully responsible for the application and use of the space</li>
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Any changes to the program must be informed to PTTA</li>
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Application must be made 3 days before the date of use</li>
                                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>I will comply with the rules set by the PTTA</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="form-check p-0">
                                        <div class="d-flex align-items-start">
                                            <input class="form-check-input me-3 mt-1 @error('declaration_accepted') is-invalid @enderror" 
                                                   type="checkbox" name="declaration_accepted" id="declaration_accepted" 
                                                   value="1" {{ old('declaration_accepted') ? 'checked' : '' }} required>
                                            <label class="form-check-label fw-semibold text-dark" for="declaration_accepted">
                                                I have read, understood, and agree to comply with all the terms and conditions stated above.
                                                <span class="text-danger">*</span>
                                            </label>
                                        </div>
                                        @error('declaration_accepted')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="status" value="Pending">

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                                        <div class="form-summary">
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Create Reservation?</h6>
                                            <p class="mb-0 text-muted small">Review your reservation details before creating</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('backend.reservation.index') }}" class="btn btn-outline-danger btn-lg rounded-pill px-4">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                Back
                                            </a>
                                            <button type="submit" class="btn btn-success btn-lg rounded-pill px-4" id="submitBtn">
                                                <span class="btn-text">
                                                    <i class="fas fa-check me-2"></i>
                                                    Create Reservation
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
</div>

@endsection

@push('scripts')
<!-- Choices.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let roomCount = 1;
    let departmentChoices = null;
    const availableRoomsData = @json($rooms ?? []);

    // Initialize Choices.js for Department ONLY
    const departmentSelect = document.getElementById('faculty_office_id');
    if (departmentSelect) {
        departmentChoices = new Choices(departmentSelect, {
            searchEnabled: true,
            removeItemButton: false,
            shouldSort: false,
            placeholderValue: '-- Select Department --',
            noChoicesText: 'No departments available',
            noResultsText: 'No departments found',
        });

        // Handle floating label
        departmentChoices.passedElement.element.addEventListener('choice', function() {
            departmentSelect.closest('.choices-container').classList.add('has-value');
        });

        departmentChoices.passedElement.element.addEventListener('removeItem', function() {
            if (!departmentChoices.getValue()) {
                departmentSelect.closest('.choices-container').classList.remove('has-value');
            }
        });

        // Set initial state
        if (departmentChoices.getValue().value) {
            departmentSelect.closest('.choices-container').classList.add('has-value');
        }
    }

    // Handle participant category "Other" option
    const participantCategorySelect = document.getElementById('participant_category');
    const otherCategoryDiv = document.getElementById('other-participant-category');
    const otherCategoryInput = document.querySelector('input[name="other_participant_category"]');

    function toggleOtherCategory() {
        if (participantCategorySelect.value === 'Other') {
            otherCategoryDiv.style.display = 'block';
            otherCategoryInput.setAttribute('required', 'required');
        } else {
            otherCategoryDiv.style.display = 'none';
            otherCategoryInput.removeAttribute('required');
            otherCategoryInput.value = '';
        }
    }

    if (participantCategorySelect) {
        participantCategorySelect.addEventListener('change', toggleOtherCategory);
        // Check initial state
        toggleOtherCategory();
    }

    // FIXED: Add room functionality
    document.getElementById('add-room-btn').addEventListener('click', function() {
        let roomOptionsHtml = '<option value="">-- Select Room --</option>';
        
        if (availableRoomsData && availableRoomsData.length > 0) {
            availableRoomsData.forEach(room => {
                roomOptionsHtml += `<option value="${room.no_room}">${room.name}</option>`;
            });
        }
        roomOptionsHtml += '<option value="other">Other (Please Specify)</option>';

        const roomHtml = `
            <div class="room-selection-item mb-4" data-room-index="${roomCount}">
                <div class="card border-0 bg-white shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 text-primary fw-bold">
                                <i class="fas fa-door-open me-2"></i>
                                Room Selection #${roomCount + 1}
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-room">
                                <i class="fas fa-times me-1"></i>
                                Remove
                            </button>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select name="room_selections[${roomCount}][room_id]" class="form-select room-select" required>
                                        ${roomOptionsHtml}
                                    </select>
                                    <label>
                                        <i class="fas fa-door-open me-2"></i>
                                        Room <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 other-room-description" style="display: none;">
                                <div class="form-floating">
                                    <input type="text" name="room_selections[${roomCount}][other_room_description]" class="form-control" 
                                           placeholder="Specify room">
                                    <label>
                                        <i class="fas fa-edit me-2"></i>
                                        Please Specify Room <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('rooms-container').insertAdjacentHTML('beforeend', roomHtml);
        roomCount++;
        
        // Show remove buttons
        const removeButtons = document.querySelectorAll('.remove-room');
        removeButtons.forEach(btn => btn.classList.remove('d-none'));
        
        showNotification('Room added successfully', 'success');
    });

    // FIXED: Remove room functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-room')) {
            const roomItem = e.target.closest('.room-selection-item');
            roomItem.remove();
            
            // Hide remove buttons if only 1 room left
            const remainingRooms = document.querySelectorAll('.room-selection-item');
            if (remainingRooms.length === 1) {
                document.querySelectorAll('.remove-room').forEach(btn => btn.classList.add('d-none'));
            }
            
            // Renumber rooms
            remainingRooms.forEach((room, index) => {
                room.querySelector('h6').innerHTML = `<i class="fas fa-door-open me-2"></i>Room Selection #${index + 1}`;
                const roomSelect = room.querySelector('select[name*="room_id"]');
                const roomInput = room.querySelector('input[name*="other_room_description"]');
                if (roomSelect) roomSelect.name = `room_selections[${index}][room_id]`;
                if (roomInput) roomInput.name = `room_selections[${index}][other_room_description]`;
                room.setAttribute('data-room-index', index);
            });
            
            roomCount = remainingRooms.length;
            showNotification('Room removed', 'info');
        }
    });

    // Handle room selection change
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('room-select')) {
            const roomItem = e.target.closest('.room-selection-item');
            const otherDescContainer = roomItem.querySelector('.other-room-description');
            const otherDescInput = otherDescContainer.querySelector('input');
            const selectedValue = e.target.value;
            
            // Handle "other" option
            if (selectedValue === 'other') {
                otherDescContainer.style.display = 'block';
                otherDescInput.setAttribute('required', 'required');
            } else {
                otherDescContainer.style.display = 'none';
                otherDescInput.removeAttribute('required');
                otherDescInput.value = '';
            }
        }
    });

    // FIXED: File upload handling
    const fileInput = document.getElementById('document_file');
    const uploadArea = document.getElementById('upload-area');
    const filePreviewArea = document.getElementById('file-preview-area');

    if (uploadArea) {
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });
    }

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleFileUpload(file);
            }
        });
    }

    function handleFileUpload(file) {
        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            showNotification('File size must be less than 5MB', 'error');
            fileInput.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            showNotification('Invalid file type. Please upload PDF, DOC, DOCX, JPG, or PNG', 'error');
            fileInput.value = '';
            return;
        }
        
        showFilePreview(file);
        showNotification('File uploaded successfully', 'success');
    }

    function showFilePreview(file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
        const fileType = getFileTypeDisplay(file.type);
        
        document.getElementById('file-name-display').textContent = fileName;
        document.getElementById('file-size-display').textContent = fileSize;
        document.getElementById('file-type-display').textContent = fileType;
        
        const previewContainer = document.getElementById('file-preview-container');
        
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="file-preview img-thumbnail">`;
            };
            reader.readAsDataURL(file);
        } else {
            const icon = getFileIcon(file.type);
            previewContainer.innerHTML = `
                <div class="text-center">
                    <i class="${icon} file-icon"></i>
                    <div class="mt-2">
                        <small class="text-muted">${fileType}</small>
                    </div>
                </div>
            `;
        }
        
        uploadArea.style.display = 'none';
        filePreviewArea.style.display = 'block';
    }

    // Remove file
    const removeFileBtn = document.getElementById('remove-file-btn');
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', function() {
            if (confirm('Remove this file?')) {
                fileInput.value = '';
                uploadArea.style.display = 'block';
                filePreviewArea.style.display = 'none';
                showNotification('File removed', 'info');
            }
        });
    }

    function getFileTypeDisplay(mimeType) {
        const types = {
            'application/pdf': 'PDF Document',
            'application/msword': 'Word Document',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 'Word Document',
            'image/jpeg': 'JPEG Image',
            'image/jpg': 'JPEG Image',
            'image/png': 'PNG Image'
        };
        return types[mimeType] || 'Unknown';
    }

    function getFileIcon(mimeType) {
        if (mimeType === 'application/pdf') return 'fas fa-file-pdf text-danger';
        if (mimeType.includes('word')) return 'fas fa-file-word text-primary';
        if (mimeType.includes('image')) return 'fas fa-file-image text-success';
        return 'fas fa-file text-muted';
    }

    // Form submission
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            const btnText = this.querySelector('.btn-text');
            const btnSpinner = this.querySelector('.btn-spinner');
            
            if (btnText && btnSpinner) {
                btnText.classList.add('d-none');
                btnSpinner.classList.remove('d-none');
                this.disabled = true;
            }
        });
    }

    // Notification system
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
        document.querySelectorAll('.notification-alert').forEach(alert => alert.remove());

        // Add new notification
        document.body.insertAdjacentHTML('beforeend', alertHtml);

        // Auto-remove after 3 seconds
        setTimeout(() => {
            const alert = document.querySelector('.notification-alert');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, 3000);
    }
});
</script>
@endpush