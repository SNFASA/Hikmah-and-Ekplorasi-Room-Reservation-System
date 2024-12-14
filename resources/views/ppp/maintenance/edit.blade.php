@extends('ppp.layouts.master')
@section('title', 'LibraRoom Reservation System')
@section('main-content')

<div class="card">
    <h5 class="card-header">Update Maintenance Report</h5>
    <div class="card-body">
        <form method="post" action="{{ route('ppp.maintenance.update', $maintenances->id) }}">
            @csrf
            @method('PUT') 
            
            <!-- Title -->
            <div class="form-group">
                <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ $maintenances->title }}" class="form-control" disabled>
                @error('title')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <!-- Description -->
            <div class="form-group">
                <label for="description" class="col-form-label">Description</label>
                <textarea class="form-control" id="description" name="description" disabled>{{ $maintenances->description }}</textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <!-- Date -->
            <div class="form-group">
                <label for="flatpickrDate" class="col-form-label">Date <span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="date_maintenance" value="{{ $maintenances->date_maintenance }}" class="form-control" disabled>
                @error('date_maintenance')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <!-- Item Type -->
            <div class="form-group">
                <label for="itemType" class="col-form-label">Item Type</label>
                <input id="itemType" type="text" name="itemType" value="{{ $maintenances->itemType }}" class="form-control" disabled>
                @error('itemType')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <!-- Item -->
            <div class="form-group" id="itemid-wrapper">
                <label for="itemid" class="col-form-label">Item</label>
                <input id="itemid" type="text" name="itemid" value="{{ $itemName }}" class="form-control" disabled>
                @error('itemid')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <!-- Room -->
            <div class="form-group">
                <label for="room_id" class="col-form-label">Room</label>
                <input id="room_id" type="text" name="room_id" value="{{ $rooms->name ?? '' }}" class="form-control" disabled>
                @error('room_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <!-- Status -->
            <div class="form-group">
                <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="pending" {{ $maintenances->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $maintenances->status == 'in_progress' ? 'selected' : '' }}>In progress</option>
                    <option value="completed" {{ $maintenances->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ $maintenances->status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <!-- Submit -->
            <div class="form-group mb-3">
                <button class="btn btn-success" type="submit">Update</button>
            </div>
        </form>
        
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="path/to/bootstrap.min.js"></script>
<script src="path/to/bootstrap-select.min.js"></script>

<script>
    // Initialize Flatpickr for Date
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y", // Example: November 26, 2024
        dateFormat: "Y-m-d", // Format for form submission
    });
    $('#itemType').change(function () {
    const type = $(this).val();
    const url = "{{ route('maintenance.items') }}?type=" + type;

    if (!type) {
        $('#itemid-wrapper').html(`
            <label for="itemid" class="col-form-label">Item</label>
            <select id="itemid" name="itemid" class="form-control">
                <option value="">----- Select Item -----</option>
            </select>
        `);
        return;
    }

    if (type === 'other') {
        $('#itemid-wrapper').html(`
            <label for="itemid_text" class="col-form-label">Item</label>
            <input type="text" id="itemid_text" name="itemid_text" class="form-control" placeholder="Enter item name">
        `);
    } else {
        $.get(url, function (data) {
            const select = $('<select id="itemid" name="itemid" class="form-control"></select>');
            select.append('<option value="">----- Select Item -----</option>');

            if (data.length > 0) {
                data.forEach(item => {
                    // Ensure 'item.id' corresponds to the primary key (e.g., 'no_furniture' or 'no_electronicEquipment')
                    select.append(`<option value="${item.id}">${item.name}</option>`);
                });
            }

            $('#itemid-wrapper').html(`
                <label for="itemid" class="col-form-label">Item</label>
            `).append(select);
        });
    }
});


    // $('select').selectpicker();
</script>
@endpush
