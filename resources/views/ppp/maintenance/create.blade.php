@extends('ppp.layouts.master')
@section('title', 'Maintenance Create')
@section('main-content')

<style>
    .card.shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.25);
        transition: box-shadow 0.3s ease-in-out;
    }
</style>

<div class="card shadow-sm border-0 mt-4">
    <h5 class="card-header bg-light font-weight-bold text-primary">Add Maintenance Report</h5>
    <div class="card-body">
        <form method="post" action="{{ route('ppp.maintenance.store') }}">
            @csrf

            {{-- Reported By --}}
            <div class="form-group mb-3">
                <label for="reported_by" class="font-weight-semibold">Reported By <span class="text-danger">*</span></label>
                <input id="reported_by" type="text" name="reported_by" value="{{ $reported_by }}" class="form-control" disabled>
                @error('reported_by') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Title --}}
            <div class="form-group mb-3">
                <label for="inputTitle" class="font-weight-semibold">Title <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ old('title') }}" class="form-control">
                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Description --}}
            <div class="form-group mb-3">
                <label for="description" class="font-weight-semibold">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Date --}}
            <div class="form-group mb-3">
                <label for="flatpickrDate" class="font-weight-semibold">Date <span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="date_maintenance" value="{{ old('date_maintenance') }}" class="form-control">
                @error('date_maintenance') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Item Type --}}
            <div class="form-group mb-3">
                <label for="itemType" class="font-weight-semibold">Item Type</label>
                <select name="itemType" id="itemType" class="form-control">
                    <option value="">----- Select Item Type -----</option>
                    <option value="furniture" {{ old('itemType') == 'furniture' ? 'selected' : '' }}>Furniture</option>
                    <option value="electronic_equipment" {{ old('itemType') == 'electronic_equipment' ? 'selected' : '' }}>Electronic</option>
                    <option value="other" {{ old('itemType') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('itemType') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Item --}}
            <div class="form-group mb-3" id="itemid-wrapper">
                <label for="itemid" class="font-weight-semibold">Item</label>
                <select name="itemid" id="itemid" class="form-control">
                    <option value="">----- Select Item -----</option>
                </select>
                @error('itemid') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Room --}}
            <div class="form-group mb-3">
                <label for="room_id" class="font-weight-semibold">Room</label>
                <select name="room_id" id="room_id" class="form-control">
                    <option value="">----- Select Room -----</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->no_room }}" {{ old('room_id') == $room->no_room ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
                @error('room_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Submit --}}
            <div class="form-group mb-3 d-flex flex-column flex-sm-row justify-content-end gap-2">
                <a href="{{ route('ppp.electronic.index') }}" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button type="submit" class="btn btn-success text-white shadow-sm w-100 w-sm-auto">
                    <i class="fas fa-check me-1"></i> Submit
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // Initialize Flatpickr
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
                <label for="itemid" class="font-weight-semibold">Item</label>
                <select id="itemid" name="itemid" class="form-control">
                    <option value="">----- Select Item -----</option>
                </select>
            `);
            return;
        }

        if (type === 'other') {
            $('#itemid-wrapper').html(`
                <label for="item_text" class="font-weight-semibold">Item</label>
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

                $('#itemid-wrapper').html(`<label for="itemid" class="font-weight-semibold">Item</label>`).append(select);
            });
        }
    });
</script>
@endpush
