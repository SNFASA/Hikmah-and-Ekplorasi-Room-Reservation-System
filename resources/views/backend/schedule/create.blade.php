@extends('backend.layouts.master')
@section('title', 'Schedule Create')
@section('main-content')

<div class="card shadow-sm border-0">
    <h5 class="card-header bg-light font-weight-bold text-primary">Manage Schedule Booking</h5>
    <div class="card-body">
        <form method="post" action="{{ route('schedule.store') }}">
            @csrf

            {{-- Date Picker --}}
            <div class="form-group">
                <label for="flatpickrDate" class="font-weight-semibold">Unavailable Date <span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="invalid_date" value="{{ old('invalid_date') }}" class="form-control">
                @error('invalid_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Time Start --}}
            <div class="form-group">
                <label for="flatpickrTimeStart" class="font-weight-semibold">Start Time<span class="text-danger">*</span></label>
                <input id="flatpickrTimeStart" type="text" name="invalid_time_start" value="{{ old('invalid_time_start') }}" class="form-control">
                @error('invalid_time_start') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Time End --}}
            <div class="form-group">
                <label for="flatpickrTimeEnd" class="font-weight-semibold">End Time<span class="text-danger">*</span></label>
                <input id="flatpickrTimeEnd" type="text" name="invalid_time_end" value="{{ old('invalid_time_end') }}" class="form-control">
                @error('invalid_time_end') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Apply to All --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="apply_to_all" id="applyToAll" value="1" {{ old('apply_to_all') ? 'checked' : '' }}>
                <label class="form-check-label font-weight-medium" for="applyToAll">Apply to All Rooms</label>
            </div>

            {{-- Room Selector --}}
            <div class="form-group" id="roomSelector">
                <label class="font-weight-semibold mb-2">Select Room(s)</label>
                <div class="row">
                    @foreach($rooms as $room)
                        <div class="col-md-4 col-sm-6 mb-2">
                            <div class="form-check rounded border p-2 bg-light hover-shadow transition">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="no_room[]" 
                                    id="room_{{ $room->no_room }}" 
                                    value="{{ $room->no_room }}"
                                    {{ in_array($room->no_room, old('no_room', [])) ? 'checked' : '' }}
                                    {{ old('apply_to_all') ? 'disabled' : '' }}
                                >
                                <label class="form-check-label" for="room_{{ $room->no_room }}">
                                    {{ $room->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('no_room') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="form-group mt-4 d-flex flex-column flex-sm-row justify-content-end gap-2">
                <button type="reset" class="btn btn-warning text-white mb-2 mb-sm-0 w-100 w-sm-auto shadow-sm transition" style="transition: all 0.3s;">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </button>
                <button class="btn btn-success text-white w-100 w-sm-auto shadow-sm transition" type="submit" style="transition: all 0.3s;">
                    <i class="fas fa-check mr-1"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });

    flatpickr("#flatpickrTimeStart", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });

    flatpickr("#flatpickrTimeEnd", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });

    // Toggle room selector
    const checkbox = document.getElementById('applyToAll');
    const roomSelector = document.getElementById('roomSelector');

    function toggleRoomSelector() {
        const isChecked = checkbox.checked;
        roomSelector.style.display = isChecked ? 'none' : 'block';

        const roomCheckboxes = roomSelector.querySelectorAll('input[type="checkbox"]');
        roomCheckboxes.forEach(chk => chk.disabled = isChecked);
    }

    checkbox.addEventListener('change', toggleRoomSelector);
    toggleRoomSelector(); // Initial state
</script>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
    }
    .transition {
        transition: all 0.2s ease-in-out;
    }
</style>
@endpush
