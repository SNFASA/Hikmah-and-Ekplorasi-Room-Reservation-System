@extends('ppp.layouts.master')
@section('title', 'Maintenance Edit')

@section('main-content')
<div class="card shadow-sm border-0 mt-4">
<h5 class="card-header bg-light font-weight-bold text-primary">Update Maintenance Report</h5>
    <div class="card-body ">
        <form method="post" action="{{ route('ppp.maintenance.update', $maintenances->id) }}">
            @csrf
            @method('PUT')

            <!-- Reported By -->
            <div class="form-group mb-3">
                <label for="reported_by">Reported By <span class="text-danger">*</span></label>
                <input type="text" id="reported_by" name="reported_by" value="{{ $reported_by }}" class="form-control-plaintext bg-white border rounded px-3 py-2" readonly>
                @error('reported_by')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Title -->
            <div class="form-group mb-3">
                <label for="inputTitle">Title <span class="text-danger">*</span></label>
                <input type="text" id="inputTitle" name="title" value="{{ $maintenances->title }}" class="form-control-plaintext bg-white border rounded px-3 py-2" readonly>
                @error('title')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" class="form-control-plaintext bg-white border rounded px-3 py-2" readonly>{{ $maintenances->description }}</textarea>
                @error('description')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Date -->
            <div class="form-group mb-3">
                <label for="flatpickrDate">Date <span class="text-danger">*</span></label>
                <input type="text" id="flatpickrDate" name="date_maintenance" value="{{ $maintenances->date_maintenance }}" class="form-control-plaintext bg-white border rounded px-3 py-2" readonly>
                @error('date_maintenance')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Item Type -->
            <div class="form-group mb-3">
                <label for="itemType">Item Type</label>
                <input type="text" id="itemType" name="itemType" value="{{ $maintenances->itemType }}" class="form-control-plaintext bg-white border rounded px-3 py-2" readonly>
                @error('itemType')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Item -->
            <div class="form-group mb-3">
                <label for="itemid">Item</label>
                <input type="text" id="itemid" name="itemid" value="{{ $itemName }}" class="form-control-plaintext bg-white border rounded px-3 py-2" readonly>
                @error('itemid')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Room -->
            <div class="form-group mb-3">
                <label for="room_id">Room</label>
                <input type="text" id="room_id" name="room_id" value="{{ $rooms->name ?? '' }}" class="form-control-plaintext bg-white border rounded px-3 py-2" readonly>
                @error('room_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Status -->
            <div class="form-group mb-4">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control bg-white border rounded px-3 py-2">
                    <option value="pending" {{ $maintenances->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $maintenances->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $maintenances->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ $maintenances->status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                @error('status')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <!-- Submit -->
            <div class="form-group mb-3 d-flex flex-column flex-sm-row justify-content-end gap-2">
                <a href="{{ route('ppp.maintenance.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button type="submit" class="btn btn-success text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css" />
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>
<script>
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });
</script>
@endpush
