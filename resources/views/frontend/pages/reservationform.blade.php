@extends('frontend.layouts.master')
@section('title','Facilities Reservation Checkout')
@section('main-content')
<!-- Main Content -->
<div class="modern-booking-container">
    <div class="booking-header">
        <div class="container">
            <h2 class="booking-title">
                <i class="fas fa-calendar-plus me-3"></i>
                Facilities Reservation Checkout
            </h2>
            <p class="booking-subtitle">Complete your facilities reservation details</p>
        </div>
    </div>

    <div class="container py-5">
        <!-- Alert Messages -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form class="modern-booking-form" method="POST" action="{{route('reservationformStore', ['id' => $room->no_room])}}" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8 col-12">
                    <div class="booking-form-card">
                        <div class="form-card-header">
                            <h4 class="form-card-title">
                                <i class="fas fa-cog me-2"></i>
                                Reservation Configuration
                            </h4>
                        </div>
                        
                        <div class="form-card-body">
                            <!-- Step 1: Basic Information -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="text-primary fw-bold mb-2">
                                        <span class="step-number">1</span>
                                        Basic Information
                                    </h6>
                                </div>

                                <div class="row g-3">
                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                                   placeholder="Enter full name" 
                                                   value="{{ old('name') }}" required>
                                            <label>
                                                <i class="fas fa-user me-2"></i>
                                                Name <span class="required-asterisk">*</span>
                                            </label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Created By -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control disabled-field" 
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
                                                   placeholder="Enter matric number" 
                                                   value="{{ old('staff_id_matric_no') }}" required>
                                            <label>
                                                <i class="fas fa-id-card me-2"></i>
                                                Staff/Matric No <span class="required-asterisk">*</span>
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
                                                   placeholder="Enter contact number" 
                                                   value="{{ old('contact_no') }}" required>
                                            <label>
                                                <i class="fas fa-phone me-2"></i>
                                                Contact Number <span class="required-asterisk">*</span>
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
                                                   placeholder="Enter email"
                                                   value="{{ old('email') }}" required>
                                            <label>
                                                <i class="fas fa-envelope me-2"></i>
                                                Email <span class="required-asterisk">*</span>
                                            </label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Department - Custom Choices.js Implementation -->
                                    <div class="col-md-6">
                                        <div class="form-floating custom-choices-container">
                                            <select name="faculty_office_id" id="faculty_office_id"
                                                class="choices-select @error('faculty_office_id') is-invalid @enderror" required>
                                                <option value="">-- Select Department --</option>
                                                @if(isset($facultie))
                                                    @foreach($facultie as $faculty)
                                                        <option value="{{ $faculty->no_facultyOffice }}"
                                                            {{ old('faculty_office_id') == $faculty->no_facultyOffice ? 'selected' : '' }}>
                                                            {{ $faculty->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="faculty_office_id">
                                                <i class="fas fa-building me-2"></i>
                                                Department <span class="required-asterisk">*</span>
                                            </label>
                                            @error('faculty_office_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Purpose -->
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <textarea name="purpose_program_name" class="form-control @error('purpose_program_name') is-invalid @enderror" 
                                                      placeholder="Enter purpose" 
                                                      style="height: 100px;" required>{{ old('purpose_program_name') }}</textarea>
                                            <label>
                                                <i class="fas fa-bullseye me-2"></i>
                                                Purpose/Program Name <span class="required-asterisk">*</span>
                                            </label>
                                            @error('purpose_program_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Room Selection -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="text-primary fw-bold mb-2">
                                        <span class="step-number">2</span>
                                        Room Selection
                                    </h6>
                                </div>

                                <div id="rooms-container">
                                    <div class="room-selection-item mb-3" data-room-index="0">
                                        <div class="card border-0 bg-white shadow-sm rounded-3">
                                            <div class="card-body p-3">
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
                                                            <input type="text" class="form-control disabled-field" 
                                                                   value="{{ $room->name }}" readonly>
                                                            <label>
                                                                <i class="fas fa-door-open me-2"></i>
                                                                Room <span class="required-asterisk">*</span>
                                                            </label>
                                                            <input type="hidden" name="room_selections[0][room_id]" value="{{ $room->no_room }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="button" id="add-room-btn" class="btn btn-outline-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Add Another Room
                                    </button>
                                </div>
                            </div>

                            <!-- Step 3: Schedule Information -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="text-primary fw-bold mb-2">
                                        <span class="step-number">3</span>
                                        Schedule Information
                                    </h6>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control disabled-field"
                                                   value="{{ $start_date }}" readonly>
                                            <label>Start Date</label>
                                            <input type="hidden" name="start_date" value="{{ $start_date }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control disabled-field" 
                                                   value="{{ $end_date }}" readonly>
                                            <label>End Date</label>
                                            <input type="hidden" name="end_date" value="{{ $end_date }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="time" class="form-control disabled-field" 
                                                   value="{{ $start_time }}" readonly>
                                            <label>Start Time</label>
                                            <input type="hidden" name="start_time" value="{{ $start_time }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="time" class="form-control disabled-field" 
                                                   value="{{ $end_time }}" readonly>
                                            <label>End Time</label>
                                            <input type="hidden" name="end_time" value="{{ $end_time }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Event Information -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="text-primary fw-bold mb-2">
                                        <span class="step-number">4</span>
                                        Event Information
                                    </h6>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="number" name="no_of_participants" class="form-control @error('no_of_participants') is-invalid @enderror" 
                                                   placeholder="Enter number" 
                                                   value="{{ old('no_of_participants') }}" min="1" required>
                                            <label>
                                                <i class="fas fa-users me-2"></i>
                                                Number of Participants <span class="required-asterisk">*</span>
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
                                                Participant Category <span class="required-asterisk">*</span>
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
                                                Event Type <span class="required-asterisk">*</span>
                                            </label>
                                            @error('event_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12" id="other-participant-category" style="display: none;">
                                        <div class="form-floating">
                                            <input type="text" name="other_participant_category" class="form-control" 
                                                   placeholder="Specify category" 
                                                   value="{{ old('other_participant_category') }}">
                                            <label>
                                                <i class="fas fa-info-circle me-2"></i>
                                                Other Participant Category <span class="required-asterisk">*</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 5: Document Upload -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="text-primary fw-bold mb-2">
                                        <span class="step-number">5</span>
                                        Document Upload
                                    </h6>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="upload-area border-2 border-dashed border-primary rounded-3 p-4 text-center" id="upload-area">
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
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
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
                                                <li class="mb-2"><i class="fas fa-info-circle text-info me-2"></i>Call <strong>07-453 3313</strong> for more information</li>
                                            </ul>
                                        </div>
                                        
                                        <div class="form-check p-0">
                                            <div class="d-flex align-items-start">
                                                <input class="form-check-input me-3 mt-1 @error('declaration_accepted') is-invalid @enderror" 
                                                       type="checkbox" name="declaration_accepted" id="declaration_accepted" 
                                                       value="1" {{ old('declaration_accepted') ? 'checked' : '' }} required>
                                                <label class="form-check-label fw-semibold text-dark" for="declaration_accepted">
                                                    I have read, understood, and agree to comply with all the terms and conditions stated above.
                                                    <span class="required-asterisk">*</span>
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
                        </div>
                    </div>
                </div>
                
                <!-- Room Details Sidebar -->
                <div class="col-lg-4 col-12">
                    <div class="room-details-card">
                        <div class="room-card-header">
                            <h4 class="room-card-title">
                                <i class="fas fa-door-open me-2"></i>
                                Reservation Summary
                            </h4>
                        </div>
                        
                        <div class="room-card-body">
                            <div class="room-image-container">
                                @if ($room->image)
                                    <img src="{{ asset('storage/' . $room->image) }}" class="room-image" alt="Room Image">
                                @else
                                    <img src="{{ asset('images/ruang terbuka.jpg') }}" class="room-image" alt="No Image Available">
                                @endif
                            </div>
                            
                            <div class="room-details-list">
                                <div class="room-detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-door-closed text-primary"></i>
                                    </div>
                                    <div class="detail-content">
                                        <small class="detail-label">Room Name</small>
                                        <div class="detail-value">{{ $room->name }}</div>
                                    </div>
                                </div>
                                
                                <div class="room-detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-users text-success"></i>
                                    </div>
                                    <div class="detail-content">
                                        <small class="detail-label">Capacity</small>
                                        <div class="detail-value">{{ $room->capacity }} Guests</div>
                                    </div>
                                </div>
                            </div>

                            <div class="room-detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-couch text-info"></i>
                                </div>
                                <div class="detail-content">
                                    <small class="detail-label">Furniture</small>
                                        <div class="detail-value">{{ implode(', ', $room->furnitures->pluck('name')->toArray()) ?: 'N/A' }}</div>
                                </div>
                            </div>
                                    
                            <div class="room-detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-tv text-warning"></i>
                                </div>
                                 <div class="detail-content">
                                    <small class="detail-label">Electronic Equipment</small>
                                    <div class="detail-value">{{ implode(', ', $room->electronics->pluck('name')->toArray()) ?: 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="mt-4 p-3 bg-light rounded-3">
                                <h6 class="text-primary fw-bold mb-2">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    Quick Tips
                                </h6>
                                <div class="small text-muted">
                                    <div class="mb-2">
                                        <i class="fas fa-calendar-alt me-2 text-info"></i>
                                        3 days advance booking required
                                    </div>
                                    <div class="mb-0">
                                        <i class="fas fa-phone me-2 text-warning"></i>
                                        Call 07-453 3313 for assistance
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="room-card-footer">
                            <button type="submit" class="btn btn-primary w-100" id="submit-reservation-btn">
                                <span class="btn-text">
                                    <i class="fas fa-check-circle me-2"></i>
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
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<script>
document.addEventListener('DOMContentLoaded', function() {
    let roomCount = 1;
    const selectedRooms = new Set();

// Initialize Choices.js
    const departmentSelect = document.getElementById('faculty_office_id');
    if (departmentSelect) {
        const choices = new Choices(departmentSelect, {
            searchEnabled: true,
            searchPlaceholderValue: 'Search departments...',
            itemSelectText: '',
            position: 'bottom',
            shouldSort: false,
            allowHTML: true,
            classNames: {
                containerOuter: 'choices',
                containerInner: 'choices__inner',
                input: 'choices__input',
                inputCloned: 'choices__input--cloned',
                list: 'choices__list',
                listItems: 'choices__list--multiple',
                listSingle: 'choices__list--single',
                listDropdown: 'choices__list--dropdown',
                item: 'choices__item',
                itemSelectable: 'choices__item--selectable',
                itemDisabled: 'choices__item--disabled',
                itemChoice: 'choices__item--choice',
                placeholder: 'choices__placeholder',
                group: 'choices__group',
                groupHeading: 'choices__heading',
                button: 'choices__button',
                activeState: 'is-active',
                focusState: 'is-focused',
                openState: 'is-open',
                disabledState: 'is-disabled',
                highlightedState: 'is-highlighted',
                selectedState: 'is-selected',
                flippedState: 'is-flipped',
                loadingState: 'is-loading',
                noResults: 'has-no-results',
                noChoices: 'has-no-choices'
            }
        });

        // Add has-value class when a value is selected
        departmentSelect.addEventListener('change', function() {
            const choicesElement = document.querySelector('.choices');
            if (this.value) {
                choicesElement.classList.add('has-value');
            } else {
                choicesElement.classList.remove('has-value');
            }
        });

        // Check initial value
        if (departmentSelect.value) {
            document.querySelector('.choices').classList.add('has-value');
        }
    }
    
    // Add initial room to selected set
    const initialRoomId = document.querySelector('input[name="room_selections[0][room_id]"]')?.value;
    if (initialRoomId) {
        selectedRooms.add(initialRoomId);
    }

    // Get available rooms data
    const availableRoomsData = @json($rooms ?? []);

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

    participantCategorySelect.addEventListener('change', toggleOtherCategory);
    // Check initial state
    toggleOtherCategory();

    // Add room functionality
    document.getElementById('add-room-btn').addEventListener('click', function() {
        const availableRooms = availableRoomsData.filter(room => 
            !selectedRooms.has(room.no_room.toString())
        );
        
        if (availableRooms.length === 0) {
            showNotification('No more rooms available', 'warning');
            return;
        }

        let roomOptionsHtml = '<option value="">-- Select Room --</option>';
        availableRooms.forEach(room => {
            roomOptionsHtml += `<option value="${room.no_room}">${room.name}</option>`;
        });
        roomOptionsHtml += '<option value="other">Other (Please Specify)</option>';

        const roomHtml = `
            <div class="room-selection-item mb-3" data-room-index="${roomCount}">
                <div class="card border-0 bg-white shadow-sm rounded-3">
                    <div class="card-body p-3">
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
                                        Room <span class="required-asterisk">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 other-room-description" style="display: none;">
                                <div class="form-floating">
                                    <input type="text" name="room_selections[${roomCount}][other_room_description]" class="form-control" 
                                           placeholder="Specify room">
                                    <label>
                                        <i class="fas fa-edit me-2"></i>
                                        Please Specify Room <span class="required-asterisk">*</span>
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

    // Remove room functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-room')) {
            const roomItem = e.target.closest('.room-selection-item');
            const roomSelect = roomItem.querySelector('.room-select');
            const selectedRoomId = roomSelect?.value;
            
            // Remove from selected rooms
            if (selectedRoomId && selectedRoomId !== 'other') {
                selectedRooms.delete(selectedRoomId);
            }
            
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
            updateAvailableRooms();
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
            const previousValue = e.target.dataset.previousValue;
            
            // Update selected rooms
            if (previousValue && previousValue !== 'other') {
                selectedRooms.delete(previousValue);
            }
            if (selectedValue && selectedValue !== 'other') {
                selectedRooms.add(selectedValue);
            }
            
            e.target.dataset.previousValue = selectedValue;
            
            // Handle "other" option
            if (selectedValue === 'other') {
                otherDescContainer.style.display = 'block';
                otherDescInput.setAttribute('required', 'required');
            } else {
                otherDescContainer.style.display = 'none';
                otherDescInput.removeAttribute('required');
                otherDescInput.value = '';
            }
            
            updateAvailableRooms();
        }
    });

    function updateAvailableRooms() {
        document.querySelectorAll('.room-select').forEach(select => {
            const currentValue = select.value;
            const availableRooms = availableRoomsData.filter(room =>
                !selectedRooms.has(room.no_room.toString()) || room.no_room.toString() === currentValue
            );
            
            let roomOptionsHtml = '<option value="">-- Select Room --</option>';
            availableRooms.forEach(room => {
                const selected = room.no_room.toString() === currentValue ? 'selected' : '';
                roomOptionsHtml += `<option value="${room.no_room}" ${selected}>${room.name}</option>`;
            });
            roomOptionsHtml += `<option value="other" ${currentValue === 'other' ? 'selected' : ''}>Other (Please Specify)</option>`;
            
            select.innerHTML = roomOptionsHtml;
        });
    }

    // File upload handling
    const fileInput = document.getElementById('document_file');
    const uploadArea = document.getElementById('upload-area');
    const filePreviewArea = document.getElementById('file-preview-area');

    uploadArea.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleFileUpload(file);
        }
    });

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
    document.getElementById('remove-file-btn').addEventListener('click', function() {
        if (confirm('Remove this file?')) {
            fileInput.value = '';
            uploadArea.style.display = 'block';
            filePreviewArea.style.display = 'none';
            showNotification('File removed', 'info');
        }
    });

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
    document.querySelector('form').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submit-reservation-btn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnSpinner = submitBtn.querySelector('.btn-spinner');
        
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
        submitBtn.disabled = true;
    });

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
<style>
/* Modern Choices.js Styling with Gradient and Glassmorphism Effect */
.choices {
    margin-bottom: 0;
    position: relative;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.choices__inner {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
    border: 2px solid #e2e8f0;
    font-size: 1rem;
    min-height: 58px;
    padding: 1rem 1.25rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
    backdrop-filter: blur(10px);
}

.choices__inner:hover {
    border-color: #667eea;
    box-shadow: 0 7px 14px rgba(102, 126, 234, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    transform: translateY(-1px);
}

.choices.is-focused .choices__inner {
    border-color: #5a67d8;
    box-shadow: 0 0 0 4px rgba(90, 103, 216, 0.15);
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
}

.choices__list--single {
    padding: 0;
    display: flex;
    align-items: center;
    height: 100%;
}

.choices__item--selectable {
    color: #1a1660;
    font-weight: 500;
    letter-spacing: 0.01em;
}

.choices__placeholder {
    color: #a0aec0;
    opacity: 1;
    font-style: italic;
}

/* Dropdown styling - Glassmorphism Effect */
.choices__list--dropdown {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1), 0 5px 10px rgba(0, 0, 0, 0.05);
    margin-top: 8px;
    overflow: hidden;
    z-index: 1050;
}

.choices__list--dropdown .choices__item {
    padding: 14px 20px;
    font-size: 0.95rem;
    border-bottom: 1px solid rgba(237, 242, 247, 0.7);
    transition: all 0.2s ease;
    position: relative;
}

.choices__list--dropdown .choices__item:last-child {
    border-bottom: none;
}

.choices__list--dropdown .choices__item--selectable {
    color: #4a5568;
    transition: all 0.2s ease;
}

.choices__list--dropdown .choices__item--selectable.is-highlighted {
    background: #1a1660;
    color: white;
    padding-left: 28px;
    background-color: #1a1660;
    color: #1a1660;
}

.choices__list--dropdown .choices__item--selectable.is-highlighted:before {
    content: "→";
    position: absolute;
    left: 12px;
    opacity: 0.8;

}

/* Search input styling */
.choices__input {
    background-color: transparent;
    border: none;
    color: #4a5568;
    font-size: 0.95rem;
    padding: 12px 20px;
    margin: 0;
    border-bottom: 1px solid #e2e8f0;
    border-radius: 0;
}

.choices__input:focus {
    outline: none;
    box-shadow: none;
}

.choices__input::placeholder {
    color: #a0aec0;
}

/* Arrow styling */
.choices[data-type*="select-one"]:after {
    border-color: #667eea transparent transparent transparent;
    margin-top: -2.5px;
    right: 20px;
    width: 10px;
    height: 10px;
    border-width: 2px;
    transition: all 0.3s ease;
}

.choices[data-type*="select-one"].is-open:after {
    border-color: transparent transparent #667eea transparent;
    margin-top: -7.5px;
}

/* Error state */
.choices.is-invalid .choices__inner {
    border-color: #fc8181;
    background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
    box-shadow: 0 0 0 4px rgba(252, 129, 129, 0.15);
}

/* Hide original selects completely */
.choices-select {
    display: none !important;
    background-color: #1a1660;
}

/* Floating label adjustments */
.custom-choices-container.form-floating {
    position: relative;
}

.form-floating .choices {
    padding-top: 10px;
}

.form-floating > .choices > .choices__inner > label {
    position: absolute;
    top: 0.8rem;
    left: 1.25rem;
    font-size: 0.85rem;
    opacity: 0.7;
    color: #718096;
    transition: all 0.2s ease;
    pointer-events: none;
    z-index: 1;
}

.choices[data-type*="select-one"] .choices__inner .choices__list--single .choices__item {
    padding-top: 0.5rem;
}

/* When dropdown has value, adjust label */
.choices.has-value .form-floating > label,
.choices.is-focused .form-floating > label {
    top: 0.4rem;
    left: 1rem;
    font-size: 0.75rem;
    opacity: 1;
    color: #667eea;
    font-weight: 600;
}

/* Animation for the dropdown */
.choices__list--dropdown {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 10px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

/* Group headings in dropdown */
.choices__heading {
    border-bottom: 1px solid #e2e8f0;
    color: #667eea;
    font-weight: 600;
    padding: 12px 20px;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .choices__inner {
        min-height: 52px;
        padding: 0.875rem 1rem;
    }
    
    .choices[data-type*="select-one"]:after {
        right: 16px;
    }
}

/* Custom scrollbar for dropdown */
.choices__list--dropdown::-webkit-scrollbar {
    width: 6px;
}

.choices__list--dropdown::-webkit-scrollbar-track {
    background: rgba(237, 242, 247, 0.5);
    border-radius: 3px;
}

.choices__list--dropdown::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

.choices__list--dropdown::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}
</style>
@endpush