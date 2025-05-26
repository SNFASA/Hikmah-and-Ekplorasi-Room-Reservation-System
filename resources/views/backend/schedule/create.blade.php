@extends('backend.layouts.master')
@section('title', 'Schedule Create')
@section('main-content')

<div class="card">
    <h5 class="card-header">Manage Schedule Booking</h5>
    <div class="card-body">
        <form method="post" action="{{ route('schedule.store') }}">
            @csrf

            <!-- Date -->
            <div class="form-group">
                <label for="flatpickrDate">Unavailable Date <span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="invalid_date" value="{{ old('invalid_date') }}" class="form-control">
                @error('invalid_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Time Start -->
            <div class="form-group">
                <label for="flatpickrTimeStart">Start Time (Optional)</label>
                <input id="flatpickrTimeStart" type="text" name="invalid_time_start" value="{{ old('invalid_time_start') }}" class="form-control">
                @error('invalid_time_start') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Time End -->
            <div class="form-group">
                <label for="flatpickrTimeEnd">End Time (Optional)</label>
                <input id="flatpickrTimeEnd" type="text" name="invalid_time_end" value="{{ old('invalid_time_end') }}" class="form-control">
                @error('invalid_time_end') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Apply to All -->
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="apply_to_all" id="applyToAll" value="1" {{ old('apply_to_all') ? 'checked' : '' }}>
                <label class="form-check-label" for="applyToAll">Apply to All Rooms</label>
            </div>

            <!-- Room Selection -->
            <div class="form-group" id="roomSelector">
                <label>Select Room(s)</label>
                <div class="d-flex flex-wrap">
                    @foreach($rooms as $room)
                    <div class="form-check mr-3 mb-2" style="min-width: 150px;">
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
                    @endforeach
                </div>
                @error('no_room') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mb-3">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button class="btn btn-success" type="submit">Submit</button>
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

    // Disable room selector if apply to all is checked
    const checkbox = document.getElementById('applyToAll');
    const roomSelector = document.getElementById('roomSelector');
    
    function toggleRoomSelector() {
        const isChecked = checkbox.checked;
        roomSelector.style.display = isChecked ? 'none' : 'block';

        // Disable/enable all room checkboxes accordingly
        const roomCheckboxes = roomSelector.querySelectorAll('input[type="checkbox"]');
        roomCheckboxes.forEach(chk => {
            chk.disabled = isChecked;
        });
    }

    checkbox.addEventListener('change', toggleRoomSelector);
    toggleRoomSelector(); // initial check
</script>

@endpush
