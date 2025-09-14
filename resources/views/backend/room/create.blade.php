@extends('backend.layouts.master')
@section('title', 'Room Create')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-door-open me-2"></i>
                        Add New Room
                    </h2>
                    <p class="text-muted mb-0">Create a new room with furniture and electronic equipment</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-success text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-plus me-1"></i>
                        New Room
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
            <div class="card room-card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white p-4 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title text-white mb-0 fw-bold">
                                <i class="fas fa-cog me-2"></i>
                                Room Configuration
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Set up room details, capacity, and equipment
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
                    <form method="POST" action="{{ route('room.store') }}" id="roomCreateForm" enctype="multipart/form-data">
                        @csrf
                        <!-- Step 1: Room Details -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Basic Room Information
                                </h6>
                                <p class="text-muted mb-0 small">Enter the basic details for the new room</p>
                            </div>

                            <div class="row g-4">
                                <!-- Room Name -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="inputName"
                                            type="text"
                                            name="name"
                                            class="form-control form-control-modern @error('name') is-invalid @enderror"
                                            placeholder="Enter room name"
                                            value="{{ old('name') }}"
                                            required
                                        >
                                        <label for="inputName">
                                            <i class="fas fa-tag me-2"></i>
                                            Room Name <span class="text-danger">*</span>
                                        </label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Capacity -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            id="capacity"
                                            type="number"
                                            min="1"
                                            name="capacity"
                                            class="form-control form-control-modern @error('capacity') is-invalid @enderror"
                                            placeholder="Enter capacity"
                                            value="{{ old('capacity') }}"
                                            required
                                        >
                                        <label for="capacity">
                                            <i class="fas fa-users me-2"></i>
                                            Capacity <span class="text-danger">*</span>
                                        </label>
                                        @error('capacity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <!-- Room Type -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="type_room" class="form-control form-control-modern @error('type_room') is-invalid @enderror" required>
                                            <option value="">-- Select Room Type --</option>
                                            @foreach($type_rooms as $type)
                                                <option value="{{ $type->id }}"
                                                    @if(old('type_room') == $type->id) selected @endif>
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="type_room">
                                            <i class="fas fa-building me-2"></i>
                                            Room Type <span class="text-danger">*</span>
                                        </label>
                                        @error('type_room')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="status" class="form-control form-control-modern @error('status') is-invalid @enderror" required>
                                            <option value="valid" {{ old('status', 'valid') == 'valid' ? 'selected' : '' }}>Valid</option>
                                            <option value="invalid" {{ old('status') == 'invalid' ? 'selected' : '' }}>Invalid</option>
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
                            <!-- Room Image Upload -->
                            <div class="row g-4 mt-2">
                                <div class="col-12">
                                    <div class="card border-0 bg-white shadow-sm rounded-3">
                                        <div class="card-body p-4">
                                            <h6 class="fw-bold text-dark mb-3">
                                                <i class="fas fa-camera me-2 text-primary"></i>
                                                Room Image <span class="text-danger">*</span>
                                            </h6>
                                            
                                            <div class="image-upload-container">
                                                <div class="image-upload-area border-2 border-dashed rounded-3 p-4 text-center position-relative @error('image') border-danger @enderror" 
                                                    id="imageUploadArea"
                                                    ondrop="dropHandler(event);" 
                                                    ondragover="dragOverHandler(event);"
                                                    ondragenter="dragEnterHandler(event);"
                                                    ondragleave="dragLeaveHandler(event);"
                                                    onclick="document.getElementById('imageInput').click()">
                                                    
                                                    <input type="file" 
                                                        name="image" 
                                                        id="imageInput" 
                                                        class="d-none @error('image') is-invalid @enderror" 
                                                        accept="image/*" 
                                                        required
                                                        value="{{ old('image') }}">
                                                    
                                                    <div id="uploadPlaceholder" class="upload-placeholder">
                                                        <div class="mb-3">
                                                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                                        </div>
                                                        <h6 class="fw-bold text-dark mb-2">Drop your room image here</h6>
                                                        <p class="text-muted mb-3">or click to browse files</p>
                                                        <button type="button" class="btn btn-outline-primary rounded-pill px-4" 
                                                                onclick="event.stopPropagation(); document.getElementById('imageInput').click()">
                                                            <i class="fas fa-folder-open me-2"></i>
                                                            Choose Image
                                                        </button>
                                                        <div class="mt-3">
                                                            <small class="text-muted">
                                                                <i class="fas fa-info-circle me-1"></i>
                                                                Supported formats: JPG, PNG, GIF (Max 5MB)
                                                            </small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="imagePreview" class="image-preview d-none">
                                                        <div class="position-relative d-inline-block">
                                                            <img id="previewImage" src="" class="img-fluid rounded-3 shadow-sm" style="max-height: 200px;">
                                                            <button type="button" class="btn btn-sm btn-danger rounded-circle position-absolute" 
                                                                    style="top: -10px; right: -10px;" 
                                                                    onclick="event.stopPropagation(); removeImage()">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <div class="mt-3">
                                                            <p class="fw-semibold text-dark mb-1" id="imageName"></p>
                                                            <small class="text-muted" id="imageSize"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @error('image')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Furniture Selection -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Furniture Selection
                                </h6>
                                <p class="text-muted mb-0 small">Add furniture items to this room</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex gap-3 align-items-end mb-3">
                                        <div class="flex-grow-1">
                                            <label class="form-label fw-semibold text-dark mb-2">
                                                <i class="fas fa-chair me-2 text-primary"></i>
                                                Available Furniture
                                            </label>
                                            <select id="furniture-select" class="form-control form-control-modern">
                                                <option value="">--Select Furniture--</option>
                                                @foreach($furnitures as $furniture)
                                                    <option value="{{ $furniture->no_furniture }}" data-name="{{ $furniture->name }}">{{ $furniture->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" id="add-selected-furniture" class="btn btn-success btn-lg rounded-pill px-4">
                                            <i class="fas fa-plus me-2"></i>
                                            Add
                                        </button>
                                    </div>
                                    
                                    @error('furniture')
                                        <div class="alert alert-danger rounded-3 mb-3">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="selected-items-container">
                                        <h6 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-list me-2 text-primary"></i>
                                            Selected Furniture
                                            <span class="badge selected-count rounded-pill ms-2">
                                                <span id="furnitureCount">0</span> items
                                            </span>
                                        </h6>
                                        <ul id="selected-furniture" class="list-group list-group-flush">
                                            <!-- Selected furniture items will appear here -->
                                        </ul>
                                        <div id="furniture-hidden-inputs">
                                            <!-- Hidden inputs for selected furniture will be added here -->
                                        </div>
                                        <div id="furniture-empty-state" class="text-center py-4 text-muted">
                                            <i class="fas fa-chair fa-2x mb-2 opacity-50"></i>
                                            <p class="mb-0">No furniture selected yet</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Electronic Equipment -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">3</span>
                                    Electronic Equipment
                                </h6>
                                <p class="text-muted mb-0 small">Add electronic equipment to this room</p>
                            </div>

                            <div class="card border-0 bg-white shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="d-flex gap-3 align-items-end mb-3">
                                        <div class="flex-grow-1">
                                            <label class="form-label fw-semibold text-dark mb-2">
                                                <i class="fas fa-laptop me-2 text-primary"></i>
                                                Available Equipment
                                            </label>
                                            <select id="electronic-equipment-select" class="form-control form-control-modern">
                                                <option value="">--Select Equipment--</option>
                                                @foreach($electronics as $electronic)
                                                    <option value="{{ $electronic->no_electronicEquipment }}" data-name="{{ $electronic->name }}">{{ $electronic->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" id="add-selected-equipment" class="btn btn-success btn-lg rounded-pill px-4">
                                            <i class="fas fa-plus me-2"></i>
                                            Add
                                        </button>
                                    </div>

                                    @error('electronicEquipment')
                                        <div class="alert alert-danger rounded-3 mb-3">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="selected-items-container">
                                        <h6 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-list me-2 text-primary"></i>
                                            Selected Equipment
                                            <span class="badge selected-count rounded-pill ms-2">
                                                <span id="electronicsCount">0</span> items
                                            </span>
                                        </h6>
                                        <ul id="selected-electronics" class="list-group list-group-flush">
                                            <!-- Selected electronics items will appear here -->
                                        </ul>
                                        <div id="electronics-hidden-inputs">
                                            <!-- Hidden inputs for selected electronics will be added here -->
                                        </div>
                                        <div id="electronics-empty-state" class="text-center py-4 text-muted">
                                            <i class="fas fa-laptop fa-2x mb-2 opacity-50"></i>
                                            <p class="mb-0">No equipment selected yet</p>
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
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Create Room?</h6>
                                            <p class="mb-0 text-muted small">Review your room configuration before creating</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('backend.room.index') }}"
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
                                                    Create Room
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
                        Room Creation Tips
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
                                    <i class="fas fa-camera text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Image Upload</div>
                                    <small class="text-white">JPG, PNG, GIF up to 5MB</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Add Equipment</div>
                                    <small class="text-white">Select and add furniture & electronics</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
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
    console.log('Room Create Form with Image Upload initializing...');
    
    // Store original data for reset functionality
    let originalFurnitureOptions = [];
    let originalElectronicsOptions = [];
    
    // Initialize original options
    $('#furniture-select option').each(function() {
        if ($(this).val()) {
            originalFurnitureOptions.push({
                value: $(this).val(),
                text: $(this).text(),
                name: $(this).data('name')
            });
        }
    });
    
    $('#electronic-equipment-select option').each(function() {
        if ($(this).val()) {
            originalElectronicsOptions.push({
                value: $(this).val(),
                text: $(this).text(),
                name: $(this).data('name')
            });
        }
    });

    // Image Upload Functions
$(document).ready(function() {
    // File input change event listener - THE MISSING PART!
    $('#imageInput').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleImageUpload(file);
        }
    });
    
    console.log('Image upload component initialized');
});

// Image Upload Functions
function handleImageUpload(file) {
    console.log('Handling image upload:', file.name);
    
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        showNotification('Please select a valid image file (JPG, PNG, GIF)', 'error');
        return;
    }
    
    // Validate file size (5MB = 5242880 bytes)
    if (file.size > 5242880) {
        showNotification('Image file size must be less than 5MB', 'error');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        // Show preview
        $('#previewImage').attr('src', e.target.result);
        $('#imageName').text(file.name);
        $('#imageSize').text(formatFileSize(file.size));
        
        // Hide placeholder, show preview
        $('#uploadPlaceholder').addClass('d-none');
        $('#imagePreview').removeClass('d-none');
        
        // Update upload area styling
        $('#imageUploadArea').removeClass('border-dashed').addClass('border-success');
        
        showNotification('Image uploaded successfully!', 'success');
        updateProgress();
    };
    reader.readAsDataURL(file);
}

function removeImage() {
    console.log('Removing image');
    
    // Clear file input
    $('#imageInput').val('');
    
    // Hide preview, show placeholder
    $('#imagePreview').addClass('d-none');
    $('#uploadPlaceholder').removeClass('d-none');
    
    // Reset upload area styling
    $('#imageUploadArea').removeClass('border-success').addClass('border-dashed');
    
    showNotification('Image removed', 'info');
    updateProgress();
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Drag and Drop Functions
window.dragOverHandler = function(ev) {
    ev.preventDefault();
    $('#imageUploadArea').addClass('drag-over');
};

window.dragEnterHandler = function(ev) {
    ev.preventDefault();
    $('#imageUploadArea').addClass('drag-over');
};

window.dragLeaveHandler = function(ev) {
    ev.preventDefault();
    $('#imageUploadArea').removeClass('drag-over');
};

window.dropHandler = function(ev) {
    ev.preventDefault();
    $('#imageUploadArea').removeClass('drag-over');
    
    const files = ev.dataTransfer.files;
    if (files.length > 0) {
        const file = files[0];
        $('#imageInput')[0].files = files;
        handleImageUpload(file);
    }
};

// Notification function (you can customize this based on your notification system)
function showNotification(message, type = 'info') {
    // Using simple alert for now - replace with your Laravel notification system
    // For example: toastr, sweet alert, or custom notification
    console.log(`${type.toUpperCase()}: ${message}`);
    
    // If you have toastr installed, use this instead:
    // toastr[type](message);
    
    // Or create a simple toast notification
    const alertClass = {
        'success': 'alert-success',
        'error': 'alert-danger',
        'info': 'alert-info',
        'warning': 'alert-warning'
    }[type] || 'alert-info';
    
    const toast = `
        <div class="toast align-items-center text-white ${alertClass.replace('alert', 'bg')} border-0" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 11;">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    $('body').append(toast);
    $('.toast').last().toast('show');
    
    // Remove after 5 seconds
    setTimeout(() => {
        $('.toast').last().remove();
    }, 5000);
}

// Progress update function (customize based on your progress indicator)
function updateProgress() {
    const hasImage = !$('#imagePreview').hasClass('d-none');
    // You can update a progress bar or step indicator here
    console.log('Progress updated:', hasImage ? 'Image uploaded' : 'No image');
}

// Make removeImage function global
window.removeImage = removeImage;

    // Update counters function
    function updateCounters() {
        const furnitureCount = $('#selected-furniture .list-group-item').length;
        const electronicsCount = $('#selected-electronics .list-group-item').length;
        
        $('#furnitureCount').text(furnitureCount);
        $('#electronicsCount').text(electronicsCount);
        
        // Show/hide empty states
        if (furnitureCount > 0) {
            $('#furniture-empty-state').hide();
            $('#selected-furniture').show();
        } else {
            $('#furniture-empty-state').show();
            $('#selected-furniture').hide();
        }
        
        if (electronicsCount > 0) {
            $('#electronics-empty-state').hide();
            $('#selected-electronics').show();
        } else {
            $('#electronics-empty-state').show();
            $('#selected-electronics').hide();
        }
        
        console.log('Counters updated - Furniture:', furnitureCount, 'Electronics:', electronicsCount);
    }

    // Add selected furniture function
    function addSelectedFurniture() {
        const selectedValue = $('#furniture-select').val();
        const selectedOption = $('#furniture-select option:selected');
        const selectedText = selectedOption.text();
        const selectedName = selectedOption.data('name') || selectedText;

        console.log('Adding furniture:', selectedValue, selectedText);

        if (!selectedValue) {
            showNotification('Please select furniture to add', 'warning');
            return;
        }

        // Check if already added
        if ($(`#selected-furniture li[data-item-id="${selectedValue}"]`).length > 0) {
            showNotification('This furniture is already added', 'info');
            return;
        }

        // Add to selected list
        const listItem = `
            <li class="list-group-item d-flex justify-content-between align-items-center fade-in" data-item-id="${selectedValue}">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chair me-3 text-primary"></i>
                    <span class="fw-semibold">${selectedText}</span>
                </div>
                <button type="button" class="btn remove-item remove-furniture" data-item-id="${selectedValue}" data-name="${selectedText}">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `;
        
        $('#selected-furniture').append(listItem);
        
        // Add hidden input
        $('#furniture-hidden-inputs').append(`<input type="hidden" name="furniture[]" value="${selectedValue}" data-item-id="${selectedValue}">`);
        
        // Remove from select options
        $(`#furniture-select option[value="${selectedValue}"]`).remove();
        $('#furniture-select').val('');
        
        updateCounters();
        updateProgress();
        showNotification(`${selectedText} added successfully!`, 'success');
    }

    // Add selected electronics function
    function addSelectedElectronics() {
        const selectedValue = $('#electronic-equipment-select').val();
        const selectedOption = $('#electronic-equipment-select option:selected');
        const selectedText = selectedOption.text();
        const selectedName = selectedOption.data('name') || selectedText;

        console.log('Adding electronics:', selectedValue, selectedText);

        if (!selectedValue) {
            showNotification('Please select equipment to add', 'warning');
            return;
        }

        // Check if already added
        if ($(`#selected-electronics li[data-item-id="${selectedValue}"]`).length > 0) {
            showNotification('This equipment is already added', 'info');
            return;
        }

        // Add to selected list
        const listItem = `
            <li class="list-group-item d-flex justify-content-between align-items-center fade-in" data-item-id="${selectedValue}">
                <div class="d-flex align-items-center">
                    <i class="fas fa-laptop me-3 text-primary"></i>
                    <span class="fw-semibold">${selectedText}</span>
                </div>
                <button type="button" class="btn remove-item remove-electronics" data-item-id="${selectedValue}" data-name="${selectedText}">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `;
        
        $('#selected-electronics').append(listItem);
        
        // Add hidden input
        $('#electronics-hidden-inputs').append(`<input type="hidden" name="electronicEquipment[]" value="${selectedValue}" data-item-id="${selectedValue}">`);
        
        // Remove from select options
        $(`#electronic-equipment-select option[value="${selectedValue}"]`).remove();
        $('#electronic-equipment-select').val('');
        
        updateCounters();
        updateProgress();
        showNotification(`${selectedText} added successfully!`, 'success');
    }

    // Remove furniture function
    function removeFurniture(itemId, itemName) {
        console.log('Removing furniture:', itemId, itemName);
        
        const listItem = $(`#selected-furniture li[data-item-id="${itemId}"]`);
        
        // Animate removal
        listItem.fadeOut(300, function() {
            $(this).remove();
            
            // Remove hidden input
            $(`#furniture-hidden-inputs input[data-item-id="${itemId}"]`).remove();
            
            // Add back to select options
            $('#furniture-select').append(`<option value="${itemId}">${itemName}</option>`);
            
            // Sort options alphabetically
            const options = $('#furniture-select option:not(:first)').sort(function(a, b) {
                return $(a).text().localeCompare($(b).text());
            });
            $('#furniture-select').append(options);
            
            updateCounters();
            updateProgress();
            showNotification(`${itemName} removed`, 'info');
        });
    }

    // Remove electronics function
    function removeElectronics(itemId, itemName) {
        console.log('Removing electronics:', itemId, itemName);
        
        const listItem = $(`#selected-electronics li[data-item-id="${itemId}"]`);
        
        // Animate removal
        listItem.fadeOut(300, function() {
            $(this).remove();
            
            // Remove hidden input
            $(`#electronics-hidden-inputs input[data-item-id="${itemId}"]`).remove();
            
            // Add back to select options
            $('#electronic-equipment-select').append(`<option value="${itemId}">${itemName}</option>`);
            
            // Sort options alphabetically
            const options = $('#electronic-equipment-select option:not(:first)').sort(function(a, b) {
                return $(a).text().localeCompare($(b).text());
            });
            $('#electronic-equipment-select').append(options);
            
            updateCounters();
            updateProgress();
            showNotification(`${itemName} removed`, 'info');
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

        // Auto-remove after 3 seconds
        setTimeout(() => {
            $('.notification-alert').fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    // Form validation function (updated to include image)
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Validate room name
        if (!$('#inputName').val().trim()) {
            errors.push('Room name is required');
            isValid = false;
        }

        // Validate capacity
        const capacity = parseInt($('#capacity').val());
        if (!capacity || capacity <= 0) {
            errors.push('Valid capacity is required');
            isValid = false;
        }

        // Validate room type
        if (!$('select[name="type_room"]').val()) {
            errors.push('Room type is required');
            isValid = false;
        }

        // Validate image upload
        if ($('#imageInput')[0].files.length === 0) {
            errors.push('Room image is required');
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

        $('#roomCreateForm').before(alertHtml);

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

    // Reset form function (updated to include image)
    function resetForm() {
        console.log('Resetting form...');
        
        // Reset form fields
        $('#roomCreateForm')[0].reset();
        
        // Reset image upload
        removeImage();
        
        // Clear selected items
        $('#selected-furniture').empty();
        $('#selected-electronics').empty();
        $('#furniture-hidden-inputs').empty();
        $('#electronics-hidden-inputs').empty();
        
        // Reset furniture select options
        $('#furniture-select').empty().append('<option value="">--Select Furniture--</option>');
        originalFurnitureOptions.forEach(option => {
            $('#furniture-select').append(`<option value="${option.value}" data-name="${option.name}">${option.text}</option>`);
        });
        
        // Reset electronics select options
        $('#electronic-equipment-select').empty().append('<option value="">--Select Equipment--</option>');
        originalElectronicsOptions.forEach(option => {
            $('#electronic-equipment-select').append(`<option value="${option.value}" data-name="${option.name}">${option.text}</option>`);
        });
        
        updateCounters();
        updateProgress();
        showNotification('Form has been reset', 'info');
    }

    // Event Listeners
    
    // Image input change event
    $('#imageInput').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleImageUpload(file);
        }
    });
    
    // Click to upload image
    $('#imageUploadArea').on('click', function() {
        $('#imageInput').click();
    });
    
    // Add furniture button click
    $('#add-selected-furniture').on('click', function(e) {
        e.preventDefault();
        addSelectedFurniture();
    });

    // Add electronics button click
    $('#add-selected-equipment').on('click', function(e) {
        e.preventDefault();
        addSelectedElectronics();
    });

    // Remove furniture button click (using event delegation)
    $(document).on('click', '.remove-furniture', function(e) {
        e.preventDefault();
        const itemId = $(this).data('item-id');
        const itemName = $(this).data('name');
        removeFurniture(itemId, itemName);
    });

    // Remove electronics button click (using event delegation)
    $(document).on('click', '.remove-electronics', function(e) {
        e.preventDefault();
        const itemId = $(this).data('item-id');
        const itemName = $(this).data('name');
        removeElectronics(itemId, itemName);
    });

    // Form submission with validation and loading state
    $('#roomCreateForm').on('submit', function(e) {
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
    $('#inputName, #capacity, select[name="type_room"], select[name="status"], #imageInput').on('input change', function() {
        updateProgress();
    });

    // Initialize counters, progress, and empty states
    updateCounters();
    updateProgress();

    console.log('Room Create Form with Image Upload initialized successfully');
    console.log('Furniture options loaded:', originalFurnitureOptions.length);
    console.log('Electronics options loaded:', originalElectronicsOptions.length);
});
</script>
@endpush