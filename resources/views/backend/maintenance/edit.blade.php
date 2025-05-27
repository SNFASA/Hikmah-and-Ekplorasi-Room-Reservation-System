@extends('backend.layouts.master')
@section('title', 'Maintenance Edit')
@section('main-content')

<style>
    .card.shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.25);
        transition: box-shadow 0.3s ease-in-out;
    }
</style>

<div class="card shadow-sm border-0 mt-4">
    <h5 class="card-header bg-light font-weight-bold text-primary">Update Maintenance Report</h5>
    <div class="card-body">
        <form method="POST" action="{{ route('maintenance.update', $maintenances->id) }}">
            @csrf
            @method('PATCH')

            {{-- Reported By --}}
            <div class="form-group mb-3">
                <label for="reported_by">Reported By <span class="text-danger">*</span></label>
                <input id="reported_by" type="text" value="{{ $maintenances->reporter->no_matriks ?? 'N/A' }}" class="form-control" disabled>
            </div>

            {{-- Title --}}
            <div class="form-group mb-3">
                <label for="inputTitle">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="inputTitle" placeholder="Enter title" value="{{ old('title', $maintenances->title) }}" class="form-control">
                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Description --}}
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $maintenances->description) }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Date --}}
            <div class="form-group mb-3">
                <label for="flatpickrDate">Date <span class="text-danger">*</span></label>
                <input type="text" name="date_maintenance" id="flatpickrDate" value="{{ old('date_maintenance', $maintenances->date_maintenance) }}" class="form-control">
                @error('date_maintenance') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Item Type --}}
            <div class="form-group mb-3">
                <label for="itemType">Item Type</label>
                <select name="itemType" id="itemType" class="form-control">
                    <option value="">----- Select Item Type -----</option>
                    <option value="furniture" {{ old('itemType', $maintenances->itemType) == 'furniture' ? 'selected' : '' }}>Furniture</option>
                    <option value="electronic_equipment" {{ old('itemType', $maintenances->itemType) == 'electronic_equipment' ? 'selected' : '' }}>Electronic</option>
                    <option value="other" {{ old('itemType', $maintenances->itemType) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('itemType') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Item --}}
            <div class="form-group mb-3" id="itemid-wrapper">
                <label for="itemid">Item</label>
                <select name="itemid" id="itemid" class="form-control">
                    <option value="">----- Select Item -----</option>
                </select>
                @error('itemid') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Room --}}
            <div class="form-group mb-3">
                <label for="room_id">Room</label>
                <select name="room_id" id="room_id" class="form-control">
                    <option value="">----- Select Room -----</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->no_room }}" {{ old('room_id', $maintenances->room_id) == $room->no_room ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
                @error('room_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Status --}}
            <div class="form-group mb-4">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="pending" {{ old('status', $maintenances->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $maintenances->status) == 'in_progress' ? 'selected' : '' }}>In progress</option>
                    <option value="completed" {{ old('status', $maintenances->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Failed" {{ old('status', $maintenances->status) == 'Failed' ? 'selected' : '' }}>Failed</option>
                </select>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Submit Buttons --}}
            <div class="form-group mb-3 d-flex flex-column flex-sm-row justify-content-end gap-2">
                <a href="{{ route('maintenance.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
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
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
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

                data.forEach(item => {
                    const isSelected = "{{ old('itemid', $maintenances->itemid) }}" == item.id ? 'selected' : '';
                    select.append(`<option value="${item.id}" ${isSelected}>${item.name}</option>`);
                });

                $('#itemid-wrapper').html(`<label for="itemid" class="col-form-label">Item</label>`).append(select);
            });
        }
    });

    // Optionally trigger the change to preload the item on edit
    $(document).ready(function () {
        if ("{{ $maintenances->itemType }}") {
            $('#itemType').trigger('change');
        }
    });
</script>
@endpush
