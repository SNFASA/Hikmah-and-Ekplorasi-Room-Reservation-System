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

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card booking-card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title text-white mb-0 fw-bold">
                                <i class="fas fa-cog me-2"></i>
                                Reservation Facilities Configuration
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Set up reservation details, schedule, and information
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
                    <form method="POST" action="{{ route('backend.reservation.store') }}" id="booking-form" enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Basic Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Basic Information
                                </h6>
                                <p class="text-muted mb-0 small">Enter the basic details for the reservation</p>
                            </div>

                            <div class="row g-4">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="inputName"
                                            type="text"
                                            name="name"
                                            class="form-control form-control-modern @error('name') is-invalid @enderror"
                                            placeholder="Enter full name"
                                            value="{{ old('name') }}"
                                            required
                                        >
                                        <label for="inputName">
                                            <i class="fas fa-user me-2"></i>
                                            Name <span class="text-danger">*</span>
                                        </label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Created By (Display logged-in user info) -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control form-control-modern"
                                            value="{{ auth()->user()->name ?? 'Current User' }}"
                                            readonly
                                        >
                                        <label>
                                            <i class="fas fa-user-check me-2"></i>
                                            Created By
                                        </label>
                                    </div>
                                    <!-- Hidden field for the actual created_by_matric_no -->
                                    <input type="hidden" name="created_by_matric_no" value="{{ auth()->user()->student_id ?? auth()->id() }}">
                                </div>

                                <!-- Staff ID/Matric No - Changed to text input -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="staff_id_matric_no"
                                            type="text"
                                            name="staff_id_matric_no"
                                            class="form-control form-control-modern @error('staff_id_matric_no') is-invalid @enderror"
                                            placeholder="Enter matric number (e.g., A12345678)"
                                            value="{{ old('staff_id_matric_no') }}"
                                            maxlength="255"
                                            required
                                        >
                                        <label for="staff_id_matric_no">
                                            <i class="fas fa-id-card me-2"></i>
                                            Staff/Matric No <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1 text-info"></i>
                                            <small>Enter a valid matric number. If not found in booking system, it will be automatically created.</small>
                                        </div>
                                        @error('staff_id_matric_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Contact Number -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="inputContactNo"
                                            type="text"
                                            name="contact_no"
                                            class="form-control form-control-modern @error('contact_no') is-invalid @enderror"
                                            placeholder="Enter contact number"
                                            value="{{ old('contact_no') }}"
                                            required
                                        >
                                        <label for="inputContactNo">
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
                                        <input
                                            id="inputEmail"
                                            type="email"
                                            name="email"
                                            class="form-control form-control-modern @error('email') is-invalid @enderror"
                                            placeholder="Enter email"
                                            value="{{ old('email') }}"
                                            required
                                        >
                                        <label for="inputEmail">
                                            <i class="fas fa-envelope me-2"></i>
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Faculty/Department -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="faculty_office_id" id="faculty_office_id" class="form-control form-control-modern @error('faculty_office_id') is-invalid @enderror" required>
                                            <option value="">-- Select Department --</option>
                                            @foreach($facultie as $faculties)
                                                <option value="{{ $faculties->no_facultyOffice }}" {{ old('faculty_office_id') == $faculties->no_facultyOffice ? 'selected' : '' }}>
                                                    {{ $faculties->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="faculty_office_id">
                                            <i class="fas fa-building me-2"></i>
                                            Department <span class="text-danger">*</span>
                                        </label>
                                        @error('faculty_office_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Purpose/Program Name -->
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea
                                            id="inputPurpose"
                                            name="purpose_program_name"
                                            class="form-control form-control-modern @error('purpose_program_name') is-invalid @enderror"
                                            placeholder="Enter purpose or program name"
                                            style="height: 100px;"
                                            required
                                        >{{ old('purpose_program_name') }}</textarea>
                                        <label for="inputPurpose">
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
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Room Selection
                                </h6>
                                <p class="text-muted mb-0 small">Select rooms for your reservation (you can book multiple rooms)</p>
                            </div>

                            <div id="rooms-container">
                                <div class="room-selection-item mb-4">
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
                                                <!-- Room Selection -->
                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <select name="room_selections[0][room_id]" class="form-control form-control-modern room-select @error('room_id') is-invalid @enderror" required>
                                                            <option value="">-- Select Room --</option>
                                                            @foreach($rooms as $room)
                                                                <option value="{{ $room->no_room }}" {{ old('room_id') == $room->no_room ? 'selected' : '' }}>
                                                                    {{ $room->name }}
                                                                </option>
                                                            @endforeach
                                                            <option value="other" {{ old('room_id') == 'other' ? 'selected' : '' }}>Other (Please Specify)</option>
                                                        </select>
                                                        <label>
                                                            <i class="fas fa-door-open me-2"></i>
                                                            Room <span class="text-danger">*</span>
                                                        </label>
                                                        @error('room_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Other Room Description (Only shows when "Other" is selected) -->
                                                <div class="col-md-12 other-room-description" style="display: none;">
                                                    <div class="form-floating">
                                                        <input
                                                            type="text"
                                                            name="room_selections[0][other_room_description]"
                                                            class="form-control form-control-modern @error('other_room_description') is-invalid @enderror"
                                                            placeholder="Please specify the room"
                                                            value="{{ old('other_room_description') }}"
                                                        >
                                                        <label>
                                                            <i class="fas fa-edit me-2"></i>
                                                            Please Specify Room <span class="text-danger">*</span>
                                                        </label>
                                                        @error('other_room_description')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add More Rooms Button -->
                            <div class="text-center">
                                <button type="button" id="add-room-btn" class="btn btn-outline-primary btn-lg rounded-pill px-4">
                                    <i class="fas fa-plus me-2"></i>
                                    Add Another Room
                                </button>
                                <p class="text-muted small mt-2 mb-0">Each room will create a separate reservation</p>
                            </div>
                        </div>

                        <!-- Step 3: Schedule Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">3</span>
                                    Schedule Information
                                </h6>
                                <p class="text-muted mb-0 small">Set the date and time for the reservation</p>
                            </div>

                            <div class="row g-4">
                                <!-- Start Date -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="startDate"
                                            type="date"
                                            name="start_date"
                                            class="form-control form-control-modern @error('start_date') is-invalid @enderror"
                                            value="{{ old('start_date') }}"
                                            required
                                        >
                                        <label for="startDate">
                                            <i class="fas fa-calendar me-2"></i>
                                            Start Date <span class="text-danger">*</span>
                                        </label>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="endDate"
                                            type="date"
                                            name="end_date"
                                            class="form-control form-control-modern @error('end_date') is-invalid @enderror"
                                            value="{{ old('end_date') }}"
                                            required
                                        >
                                        <label for="endDate">
                                            <i class="fas fa-calendar me-2"></i>
                                            End Date <span class="text-danger">*</span>
                                        </label>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Start Time -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="startTime"
                                            type="time"
                                            name="start_time"
                                            class="form-control form-control-modern @error('start_time') is-invalid @enderror"
                                            value="{{ old('start_time') }}"
                                            required
                                        >
                                        <label for="startTime">
                                            <i class="fas fa-clock me-2"></i>
                                            Start Time <span class="text-danger">*</span>
                                        </label>
                                        @error('start_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- End Time -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="endTime"
                                            type="time"
                                            name="end_time"
                                            class="form-control form-control-modern @error('end_time') is-invalid @enderror"
                                            value="{{ old('end_time') }}"
                                            required
                                        >
                                        <label for="endTime">
                                            <i class="fas fa-clock me-2"></i>
                                            End Time <span class="text-danger">*</span>
                                        </label>
                                        @error('end_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Event Information -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">4</span>
                                    Event Information
                                </h6>
                                <p class="text-muted mb-0 small">Enter the details for the event</p>
                            </div>
                            
                            <div class="row g-4">
                                <!-- Number of Participants -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input
                                            id="inputParticipants"
                                            type="number"
                                            name="no_of_participants"
                                            class="form-control form-control-modern @error('no_of_participants') is-invalid @enderror"
                                            placeholder="Enter number of participants"
                                            value="{{ old('no_of_participants') }}"
                                            min="1"
                                            required
                                        >
                                        <label for="inputParticipants">
                                            <i class="fas fa-users me-2"></i>
                                            Number of Participants <span class="text-danger">*</span>
                                        </label>
                                        @error('no_of_participants')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Participant Category -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select
                                            name="participant_category"
                                            id="participant_category"
                                            class="form-control form-control-modern @error('participant_category') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">-- Select Participant Category --</option>
                                            @foreach($participant_category as $category)
                                                <option value="{{ $category }}" {{ old('participant_category') == $category ? 'selected' : '' }}>
                                                    {{ $category }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="participant_category">
                                            <i class="fas fa-users me-2"></i>
                                            Participant Category <span class="text-danger">*</span>
                                        </label>
                                        @error('participant_category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Event Type -->
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select
                                            name="event_type"
                                            id="event_type"
                                            class="form-control form-control-modern @error('event_type') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">-- Select Event Type --</option>
                                            @foreach($event_type as $type)
                                                <option value="{{ $type }}" {{ old('event_type') == $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="event_type">
                                            <i class="fas fa-desktop me-2"></i>
                                            Event Type <span class="text-danger">*</span>
                                        </label>
                                        @error('event_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Other Participant Category (conditional) -->
                                <div class="col-md-12" id="other-participant-category" style="display: none;">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            name="other_participant_category"
                                            class="form-control form-control-modern @error('other_participant_category') is-invalid @enderror"
                                            placeholder="Specify other participant category"
                                            value="{{ old('other_participant_category') }}"
                                        >
                                        <label>
                                            <i class="fas fa-info-circle me-2"></i>
                                            Other Participant Category <span class="text-danger">*</span>
                                        </label>
                                        @error('other_participant_category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Document Upload -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">5</span>
                                    Document Upload
                                </h6>
                                <p class="text-muted mb-0 small">Upload supporting documents (Tentative/Program Poster/Official Letter)</p>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <!-- Upload Area -->
                                    <div class="upload-area border-2 border-dashed border-primary rounded-3 p-4 text-center" id="upload-area">
                                        <input
                                            type="file"
                                            name="document_file"
                                            id="document_file"
                                            class="d-none @error('document_file') is-invalid @enderror"
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                            required
                                        >
                                        <label for="document_file" class="upload-label cursor-pointer" id="upload-label">
                                            <div class="upload-icon mb-3">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                                            </div>
                                            <h6 class="text-primary fw-bold mb-2">Click to Upload Document</h6>
                                            <p class="text-muted mb-0">
                                                Tentative/Program Poster/Official Letter<br>
                                                <small>Supported formats: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</small>
                                            </p>
                                        </label>
                                    </div>
                                    
                                    <!-- File Preview Area -->
                                    <div id="file-preview-area" class="mt-4" style="display: none;">
                                        <div class="card border-success">
                                            <div class="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 text-success">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    Document Uploaded Successfully
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger" id="remove-file-btn">
                                                    <i class="fas fa-times me-1"></i>
                                                    Remove File
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <!-- File Preview -->
                                                    <div class="col-md-3">
                                                        <div class="text-center" id="file-preview-container">
                                                            <!-- Preview content will be inserted here -->
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- File Details -->
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
                                                            
                                                            <!-- Additional file info -->
                                                            <div class="mt-3">
                                                                <div class="row g-2">
                                                                    <div class="col-sm-6">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fas fa-calendar me-2 text-muted"></i>
                                                                            <small class="text-muted">Uploaded: <span id="upload-time"></span></small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="fas fa-shield-check me-2 text-success"></i>
                                                                            <small class="text-success">File validated successfully</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @error('document_file')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: Declaration Statement -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">6</span>
                                    Declaration Statement
                                </h6>
                                <p class="text-muted mb-0 small">Please read and accept the terms and conditions</p>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <div class="card border-0 bg-light rounded-3">
                                        <div class="card-body p-4">
                                            <div class="declaration-content mb-4">
                                                <h6 class="text-dark fw-bold mb-3">
                                                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                                                    Terms and Conditions
                                                </h6>
                                                <div class="declaration-text">
                                                    <ul class="list-unstyled">
                                                        <li class="mb-2">
                                                            <i class="fas fa-check-circle text-success me-2"></i>
                                                            I am fully responsible for the application and use of the space
                                                        </li>
                                                        <li class="mb-2">
                                                            <i class="fas fa-check-circle text-success me-2"></i>
                                                            Any changes to the program must be informed to PTTA
                                                        </li>
                                                        <li class="mb-2">
                                                            <i class="fas fa-check-circle text-success me-2"></i>
                                                            Application must be made 3 days before the date of use along with program tentative
                                                        </li>
                                                        <li class="mb-2">
                                                            <i class="fas fa-check-circle text-success me-2"></i>
                                                            I will comply with the rules set by the PTTA
                                                        </li>
                                                        <li class="mb-2">
                                                            <i class="fas fa-info-circle text-info me-2"></i>
                                                            Please call <strong>07-453 3313</strong> for more information
                                                        </li>
                                                        <li class="mb-2">
                                                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                                            Additional equipment are not provided
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <!-- Declaration Checkbox -->
                                            <div class="form-check p-0">
                                                <div class="d-flex align-items-start">
                                                    <input
                                                        class="form-check-input me-3 mt-1 @error('declaration_accepted') is-invalid @enderror"
                                                        type="checkbox"
                                                        name="declaration_accepted"
                                                        id="declaration_accepted"
                                                        value="1"
                                                        {{ old('declaration_accepted') ? 'checked' : '' }}
                                                        required
                                                    >
                                                    <label class="form-check-label fw-semibold text-dark" for="declaration_accepted">
                                                        I have read, understood, and agree to comply with all the terms and conditions stated above. 
                                                        I declare that all information provided is accurate and complete.
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                                @error('declaration_accepted')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Status Field -->
                        <input type="hidden" name="status" value="Pending">

                        <!-- Action Buttons -->
                        <div class="row fade-in">
                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                                        <div class="form-summary">
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Create Reservation?</h6>
                                            <p class="mb-0 text-muted small">Review your reservation details before creating</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('backend.reservation.index') }}"
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
                                                    Create Reservation(s)
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
                        Reservation Creation Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-calendar-alt text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">3 Days Notice</div>
                                    <small class="text-white">Application must be made 3 days in advance</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-door-open text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Multiple Rooms</div>
                                    <small class="text-white">Each room creates a separate reservation</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-id-card text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Matric Auto-Create</div>
                                    <small class="text-white">Valid matric numbers are automatically registered</small>
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
    console.log('Reservation Create Form initializing...');

    let roomCount = 1;

    // Set minimum date to today + 3 days
    const today = new Date();
    const minDate = new Date(today.setDate(today.getDate() + 3));
    const minDateString = minDate.toISOString().split('T')[0];
    
    $('#startDate, #endDate').attr('min', minDateString);

    // Handle room selection change - show/hide other description
    $(document).on('change', '.room-select', function() {
        const otherDescContainer = $(this).closest('.room-selection-item').find('.other-room-description');
        const otherDescInput = otherDescContainer.find('input');
        
        if ($(this).val() === 'other') {
            otherDescContainer.show();
            otherDescInput.attr('required', true);
        } else {
            otherDescContainer.hide();
            otherDescInput.attr('required', false);
            otherDescInput.val(''); // Clear the input
        }
    });

    // File upload handling with preview
    $('#document_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            handleFileUpload(file);
        }
    });

    // Handle file upload and preview
    function handleFileUpload(file) {
        // Check file size (5MB limit)
        if (file.size > 5 * 1024 * 1024) {
            showNotification('File size must be less than 5MB', 'error');
            $('#document_file').val('');
            return;
        }
        
        // Validate file type
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            showNotification('Please upload a valid file type (PDF, DOC, DOCX, JPG, PNG)', 'error');
            $('#document_file').val('');
            return;
        }
        
        // Show file preview
        showFilePreview(file);
        showNotification('Document uploaded successfully!', 'success');
    }

    // Display file preview
    function showFilePreview(file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
        const fileType = file.type;
        const uploadTime = new Date().toLocaleString();
        
        // Update file details
        $('#file-name-display').text(fileName);
        $('#file-size-display').text(fileSize);
        $('#file-type-display').text(getFileTypeDisplay(fileType));
        $('#upload-time').text(uploadTime);
        
        // Create file preview
        const previewContainer = $('#file-preview-container');
        
        if (file.type.startsWith('image/')) {
            // Image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.html(`
                    <img src="${e.target.result}" alt="File preview" class="file-preview img-thumbnail">
                `);
            };
            reader.readAsDataURL(file);
        } else {
            // Non-image file icon
            const icon = getFileIcon(fileType);
            previewContainer.html(`
                <div class="text-center">
                    <i class="${icon} file-icon"></i>
                    <div class="mt-2">
                        <small class="text-muted">${getFileTypeDisplay(fileType)}</small>
                    </div>
                </div>
            `);
        }
        
        // Hide upload area and show preview
        $('#upload-area').hide();
        $('#file-preview-area').show();
    }

    // Remove file functionality
    $('#remove-file-btn').on('click', function() {
        if (confirm('Are you sure you want to remove this file?')) {
            $('#document_file').val('');
            $('#upload-area').show();
            $('#file-preview-area').hide();
            showNotification('File removed', 'info');
        }
    });

    // Get file type display name
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

    // Get file icon based on type
    function getFileIcon(mimeType) {
        if (mimeType === 'application/pdf') return 'fas fa-file-pdf text-danger';
        if (mimeType.includes('word')) return 'fas fa-file-word text-primary';
        if (mimeType.includes('image')) return 'fas fa-file-image text-success';
        return 'fas fa-file text-muted';
    }

    // Show/hide other participant category
    $('#participant_category').on('change', function() {
        if ($(this).val() === 'Other') {
            $('#other-participant-category').show();
            $('input[name="other_participant_category"]').attr('required', true);
        } else {
            $('#other-participant-category').hide();
            $('input[name="other_participant_category"]').attr('required', false);
        }
    });

    // Add room functionality
    $('#add-room-btn').on('click', function() {
        const roomHtml = `
            <div class="room-selection-item mb-4">
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
                                    <select name="room_selections[${roomCount}][room_id]" class="form-control form-control-modern room-select" required>
                                        <option value="">-- Select Room --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->no_room }}">{{ $room->name }}</option>
                                        @endforeach
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
                                    <input
                                        type="text"
                                        name="room_selections[${roomCount}][other_room_description]"
                                        class="form-control form-control-modern"
                                        placeholder="Please specify the room"
                                    >
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
        
        $('#rooms-container').append(roomHtml);
        roomCount++;
        
        // Show remove buttons for all rooms if more than 1
        if ($('.room-selection-item').length > 1) {
            $('.remove-room').removeClass('d-none');
        }
        
        showNotification(`Room selection #${roomCount} added!`, 'success');
    });

    // Remove room functionality
    $(document).on('click', '.remove-room', function() {
        $(this).closest('.room-selection-item').fadeOut(300, function() {
            $(this).remove();
            
            // Hide remove buttons if only 1 room left
            if ($('.room-selection-item').length === 1) {
                $('.remove-room').addClass('d-none');
            }
            
            // Renumber rooms
            $('.room-selection-item').each(function(index) {
                $(this).find('h6').html(`<i class="fas fa-door-open me-2"></i>Room Selection #${index + 1}`);
                $(this).find('select[name*="room_id"]').attr('name', `room_selections[${index}][room_id]`);
                $(this).find('input[name*="other_room_description"]').attr('name', `room_selections[${index}][other_room_description]`);
            });
            
            roomCount = $('.room-selection-item').length;
            showNotification('Room selection removed', 'info');
        });
    });

    // Date validation
    $('#startDate, #endDate').on('change', function() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        
        if (startDate && endDate && startDate > endDate) {
            showNotification('End date must be after start date', 'error');
            $('#endDate').val('');
        }
    });

    // Time validation
    $('#startTime, #endTime').on('change', function() {
        const startTime = $('#startTime').val();
        const endTime = $('#endTime').val();
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        
        if (startTime && endTime && startDate && endDate && startDate === endDate && startTime >= endTime) {
            showNotification('End time must be after start time on the same date', 'error');
            $('#endTime').val('');
        }
    });

    // Matric number formatting and validation
    $('#staff_id_matric_no').on('input', function() {
        let value = $(this).val().trim().toUpperCase();
        $(this).val(value);
        
        // Clear previous validation states
        $(this).removeClass('is-valid is-invalid');
        
        // Basic format validation (optional - adjust as needed)
        if (value && value.length >= 3) {
            // Add visual feedback for valid format
            $(this).addClass('is-valid');
        }
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

    // Form validation
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Check matric number
        const matricNo = $('#staff_id_matric_no').val().trim();
        if (!matricNo) {
            errors.push('Please enter a staff/matric number');
            isValid = false;
        } else if (matricNo.length < 3) {
            errors.push('Staff/Matric number must be at least 3 characters');
            isValid = false;
        }

        // Check if at least one room is selected
        let roomSelected = false;
        $('.room-select').each(function() {
            if ($(this).val()) {
                roomSelected = true;
                return false;
            }
        });
        
        if (!roomSelected) {
            errors.push('Please select at least one room');
            isValid = false;
        }

        // Check if "other" rooms have descriptions
        $('.room-select').each(function() {
            if ($(this).val() === 'other') {
                const description = $(this).closest('.room-selection-item').find('input[name*="other_room_description"]').val();
                if (!description || !description.trim()) {
                    errors.push('Please specify the room name for "Other" selections');
                    isValid = false;
                }
            }
        });

        // Check file upload
        if (!$('#document_file').val()) {
            errors.push('Please upload a supporting document');
            isValid = false;
        }

        // Check declaration
        if (!$('#declaration_accepted').is(':checked')) {
            errors.push('Please accept the declaration statement');
            isValid = false;
        }

        // Check dates are at least 3 days in advance
        const startDate = new Date($('#startDate').val());
        const today = new Date();
        const minAllowedDate = new Date(today.setDate(today.getDate() + 3));
        
        if (startDate < minAllowedDate) {
            errors.push('Reservation must be made at least 3 days in advance');
            isValid = false;
        }

        if (!isValid) {
            showValidationErrors(errors);
        }

        return isValid;
    }

    // Show validation errors
    function showValidationErrors(errors) {
        $('.validation-alert').remove();

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

        $('#booking-form').before(alertHtml);

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

    // Form submission
    $('#booking-form').on('submit', function(e) {
        console.log('Form submitted');
        
        const btnText = $('#submitBtn .btn-text');
        const btnSpinner = $('#submitBtn .btn-spinner');
        
        // Show loading state
        btnText.addClass('d-none');
        btnSpinner.removeClass('d-none');
        $('#submitBtn').prop('disabled', true);
        
        // Validate form
        if (!validateForm()) {
            e.preventDefault();
            // Reset button state
            btnText.removeClass('d-none');
            btnSpinner.addClass('d-none');
            $('#submitBtn').prop('disabled', false);
            return;
        }
    });

    // Reset form
    $('#resetBtn').on('click', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            $('#booking-form')[0].reset();
            
            // Reset upload area
            $('#upload-area').show();
            $('#file-preview-area').hide();
            
            // Reset room selections to just one
            $('#rooms-container').html(`
                <div class="room-selection-item mb-4">
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
                                        <select name="room_selections[0][room_id]" class="form-control form-control-modern room-select" required>
                                            <option value="">-- Select Room --</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->no_room }}">{{ $room->name }}</option>
                                            @endforeach
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
                                        <input
                                            type="text"
                                            name="room_selections[0][other_room_description]"
                                            class="form-control form-control-modern"
                                            placeholder="Please specify the room"
                                        >
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
            `);
            
            roomCount = 1;
            $('#other-participant-category').hide();
            
            // Reset validation states
            $('.form-control').removeClass('is-valid is-invalid');
            
            showNotification('Form has been reset', 'info');
        }
    });

    // Initialize
    if ($('#participant_category').val() === 'Other') {
        $('#other-participant-category').show();
    }

    // Initialize room descriptions on page load if "other" is already selected
    $('.room-select').each(function() {
        if ($(this).val() === 'other') {
            $(this).closest('.room-selection-item').find('.other-room-description').show();
        }
    });

    console.log('Reservation Create Form initialized successfully');
});
</script>
@endpush