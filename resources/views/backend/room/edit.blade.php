@extends('backend.layouts.master')
@section('title','Room Edit')
@section('main-content')

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">
                        <i class="fas fa-edit me-2"></i>
                        Edit Room
                    </h2>
                    <p class="text-muted mb-0">Update room details, furniture and electronic equipment</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="badge bg-primary text-white px-3 py-2 rounded-pill">
                        <i class="fas fa-edit me-1"></i>
                        Edit Mode
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
                                Room Configuration - {{ $room->name }}
                            </h5>
                            <p class="mb-0 mt-1 opacity-75">
                                Update room details, capacity, and equipment
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="creation-info">
                                <small class="d-block opacity-75">Last Modified:</small>
                                <strong>{{ now()->format('M d, Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body bg-light p-4">
                    <form method="POST" action="{{ route('room.update', $room->no_room) }}" id="roomEditForm">
                        @csrf
                        @method('PATCH')
                        <!-- Step 1: Room Details -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">1</span>
                                    Basic Room Information
                                </h6>
                                <p class="text-muted mb-0 small">Update the basic details for this room</p>
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
                                            value="{{ old('name', $room->name) }}"
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
                                            value="{{ old('capacity', $room->capacity) }}"
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
                                                    {{ (old('type_room', $room->type_room) == $type->id) ? 'selected' : '' }}>
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
                                            <option value="valid" {{ old('status', $room->status) == 'valid' ? 'selected' : '' }}>Valid</option>
                                            <option value="invalid" {{ old('status', $room->status) == 'invalid' ? 'selected' : '' }}>Invalid</option>
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

                        <!-- Step 2: Furniture Selection -->
                        <div class="form-section mb-5 fade-in">
                            <div class="section-header mb-4">
                                <h6 class="text-primary fw-bold mb-2">
                                    <span class="step-number">2</span>
                                    Furniture Management
                                </h6>
                                <p class="text-muted mb-0 small">Add or remove furniture items from this room</p>
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
                                                    @if(!in_array($furniture->no_furniture, $selectedFurnitures->pluck('no_furniture')->toArray()))
                                                        <option value="{{ $furniture->no_furniture }}" data-name="{{ $furniture->name }}">{{ $furniture->name }}</option>
                                                    @endif
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
                                                <span id="furnitureCount">{{ $selectedFurnitures->count() }}</span> items
                                            </span>
                                        </h6>
                                        <ul id="selected-furniture" class="list-group list-group-flush">
                                            @foreach($selectedFurnitures as $selectedFurniture)
                                                <li class="list-group-item d-flex justify-content-between align-items-center" data-item-id="{{ $selectedFurniture->no_furniture }}">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-chair me-3 text-primary"></i>
                                                        <span class="fw-semibold">{{ $selectedFurniture->name }}</span>
                                                    </div>
                                                    <button type="button" class="btn remove-item remove-furniture" data-item-id="{{ $selectedFurniture->no_furniture }}" data-name="{{ $selectedFurniture->name }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </li>
                                                <input type="hidden" name="furniture[]" value="{{ $selectedFurniture->no_furniture }}" data-item-id="{{ $selectedFurniture->no_furniture }}">
                                            @endforeach
                                        </ul>
                                        <div id="furniture-hidden-inputs">
                                            <!-- Additional hidden inputs will be added here -->
                                        </div>
                                        <div id="furniture-empty-state" class="text-center py-4 text-muted" style="{{ $selectedFurnitures->count() > 0 ? 'display: none;' : '' }}">
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
                                    Electronic Equipment Management
                                </h6>
                                <p class="text-muted mb-0 small">Add or remove electronic equipment from this room</p>
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
                                                    @if(!in_array($electronic->no_electronicEquipment, $selectedElectronics->pluck('no_electronicEquipment')->toArray()))
                                                        <option value="{{ $electronic->no_electronicEquipment }}" data-name="{{ $electronic->name }}">{{ $electronic->name }}</option>
                                                    @endif
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
                                                <span id="electronicsCount">{{ $selectedElectronics->count() }}</span> items
                                            </span>
                                        </h6>
                                        <ul id="selected-electronics" class="list-group list-group-flush">
                                            @foreach($selectedElectronics as $selectedElectronic)
                                                <li class="list-group-item d-flex justify-content-between align-items-center" data-item-id="{{ $selectedElectronic->no_electronicEquipment }}">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-laptop me-3 text-primary"></i>
                                                        <span class="fw-semibold">{{ $selectedElectronic->name }}</span>
                                                    </div>
                                                    <button type="button" class="btn remove-item remove-electronics" data-item-id="{{ $selectedElectronic->no_electronicEquipment }}" data-name="{{ $selectedElectronic->name }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </li>
                                                <input type="hidden" name="electronicEquipment[]" value="{{ $selectedElectronic->no_electronicEquipment }}" data-item-id="{{ $selectedElectronic->no_electronicEquipment }}">
                                            @endforeach
                                        </ul>
                                        <div id="electronics-hidden-inputs">
                                            <!-- Additional hidden inputs will be added here -->
                                        </div>
                                        <div id="electronics-empty-state" class="text-center py-4 text-muted" style="{{ $selectedElectronics->count() > 0 ? 'display: none;' : '' }}">
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
                                            <h6 class="mb-1 fw-bold text-dark">Ready to Update Room?</h6>
                                            <p class="mb-0 text-muted small">Review your changes before updating</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('room.index') }}" 
                                               class="btn btn-outline-danger  btn-lg rounded-pill px-4 shadow-sm">
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
                                                    Update Room
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
                        Room Edit Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Update Fields</div>
                                    <small class="text-white">Modify any field as needed</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="tip-icon me-3">
                                    <i class="fas fa-exchange-alt text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-white">Manage Equipment</div>
                                    <small class="text-white">Add or remove furniture & electronics</small>
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
                                    <small class="text-white">Click update to save your changes</small>
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
    console.log('Room Edit Form initializing...');
    
    // Store original data for reset functionality
    let originalFurnitureOptions = [];
    let originalElectronicsOptions = [];
    let originalFormData = {};
    
    // Store original form data
    originalFormData = {
        name: $('#inputName').val(),
        capacity: $('#capacity').val(),
        type_room: $('select[name="type_room"]').val(),
        status: $('select[name="status"]').val()
    };
    
    // Initialize original options (available items)
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

    // Progress tracking function
    function updateProgress() {
        let progress = 0;
        const total = 4; // Total required fields

        // Check room name
        if ($('#inputName').val().trim()) progress++;
        
        // Check capacity
        if ($('#capacity').val() && parseInt($('#capacity').val()) > 0) progress++;
        
        // Check room type
        if ($('select[name="type_room"]').val()) progress++;
        
        // Check status
        if ($('select[name="status"]').val()) progress++;

        const percentage = (progress / total) * 100;
        $('#formProgress').css('width', percentage + '%');
        
        console.log('Progress updated:', percentage + '%');
    }

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
            
            // Remove hidden input (both original and new)
            $(`input[name="furniture[]"][value="${itemId}"]`).remove();
            
            // Add back to select options
            $('#furniture-select').append(`<option value="${itemId}" data-name="${itemName}">${itemName}</option>`);
            
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
            
            // Remove hidden input (both original and new)
            $(`input[name="electronicEquipment[]"][value="${itemId}"]`).remove();
            
            // Add back to select options
            $('#electronic-equipment-select').append(`<option value="${itemId}" data-name="${itemName}">${itemName}</option>`);
            
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

    // Form validation function
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

        $('#roomEditForm').before(alertHtml);

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
        
        if (!confirm('Are you sure you want to reset all changes? This will restore the original room data.')) {
            return;
        }
        
        // Reset basic form fields to original values
        $('#inputName').val(originalFormData.name);
        $('#capacity').val(originalFormData.capacity);
        $('select[name="type_room"]').val(originalFormData.type_room);
        $('select[name="status"]').val(originalFormData.status);
        
        // Reset would require a page reload to restore original selected items
        // This is because we need to get the original selected items from the server
        showNotification('To fully reset, please refresh the page', 'info');
        
        updateCounters();
        updateProgress();
    }

    // Event Listeners
    
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
    $('#roomEditForm').on('submit', function(e) {
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
        resetForm();
    });

    // Form field change listeners for progress tracking
    $('#inputName, #capacity, select[name="type_room"], select[name="status"]').on('input change', function() {
        updateProgress();
    });

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl+Enter to submit
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            if (validateForm()) {
                $('#roomEditForm').submit();
            }
        }
        
        // Escape to focus on reset
        if (e.key === 'Escape') {
            $('#resetBtn').focus();
        }
    });

    // Enter key to add selected items
    $('#furniture-select').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSelectedFurniture();
        }
    });

    $('#electronic-equipment-select').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSelectedElectronics();
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

    // Initialize counters, progress, and empty states
    updateCounters();
    updateProgress();

    console.log('Room Edit Form initialized successfully');
    console.log('Available furniture options:', originalFurnitureOptions.length);
    console.log('Available electronics options:', originalElectronicsOptions.length);
});
</script>
@endpush