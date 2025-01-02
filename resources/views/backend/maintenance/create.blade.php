@extends('backend.layouts.master')
@section('title', 'Maintenance Create')
@section('main-content')

<div class="card">
    <h5 class="card-header">Add Maintenance Report</h5>
    <div class="card-body">
        <form method="post" action="{{ route('maintenance.store') }}">
            @csrf
            <!-- Title -->
            <div class="form-group">
                <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ old('title') }}" class="form-control">
                @error('title')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Description -->
            <div class="form-group">
                <label for="description" class="col-form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Date -->
            <div class="form-group">
                <label for="flatpickrDate" class="col-form-label">Date <span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="date_maintenance" value="{{ old('date_maintenance') }}" class="form-control">
                @error('date_maintenance')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Item Type -->
            <div class="form-group">
                <label for="itemType" class="col-form-label">Item Type</label>
                <select name="itemType" id="itemType" class="form-control">
                    <option value="">----- Select Item Type -----</option>
                    <option value="furniture" {{ old('itemType') == 'furniture' ? 'selected' : '' }}>Furniture</option>
                    <option value="electronic_equipment" {{ old('itemType') == 'electronic_equipment' ? 'selected' : '' }}>Electronic</option>
                    <option value="other" {{ old('itemType') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('itemType')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Item -->
            <div class="form-group" id="itemid-wrapper">
                <label for="itemid" class="col-form-label">Item</label>
                <select name="itemid" id="itemid" class="form-control">
                    <option value="">----- Select Item -----</option>
                </select>
                @error('itemid')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Room -->
            <div class="form-group">
                <label for="room_id" class="col-form-label">Room</label>
                <select name="room_id" id="room_id" class="form-control">
                    <option value="">----- Select Room -----</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->no_room }}" {{ old('room_id') == $room->no_room ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                    @endforeach
                </select>
                @error('room_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Submit -->
            <div class="form-group mb-3">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button type="submit" class="btn btn-success">Submit</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
                <label for="item_text" class="col-form-label">Item</label>
                <input type="text" id="item_text" name="item_text" class="form-control" placeholder="Enter item name">
            `);
        } else {
            $.get(url, function (data) {
                const select = $('<select id="itemid" name="itemid" class="form-control"></select>');
                select.append('<option value="">----- Select Item -----</option>');

                if (data.length > 0) {
                    data.forEach(item => {
                        select.append(`<option value="${item.id}">${item.name}</option>`);
                    });
                }

                $('#itemid-wrapper').html(`
                    <label for="itemid" class="col-form-label">Item</label>
                `).append(select);
            });
        }
    });
</script>
@endpush
