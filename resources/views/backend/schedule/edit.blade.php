@extends('backend.layouts.master')
@section('title','Schedule Edit')
@section('main-content')

<div class="card shadow-sm border mb-4">
    <h5 class="card-header bg-light font-weight-bold text-primary">Edit Schedule Booking</h5>
    <div class="card-body">
        <form method="post" action="{{ route('schedule.update', $schedule->id) }}">
            @csrf 
            @method('PATCH')

            <!-- Date -->
            <div class="form-group mb-3">
                <label for="flatpickrDate" class="col-form-label">Unavailable Date <span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="invalid_date" value="{{ old('invalid_date', $schedule->invalid_date) }}" 
                       class="form-control form-control-clickbox @error('invalid_date') is-invalid @enderror" 
                       autocomplete="off">
                @error('invalid_date')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Start Time -->
            <div class="form-group mb-3">
                <label for="flatpickrTimeStart" class="col-form-label">Time Start <span class="text-danger">*</span></label>
                <input id="flatpickrTimeStart" type="text" name="invalid_time_start" value="{{ old('invalid_time_start', $schedule->invalid_time_start) }}" 
                       class="form-control form-control-clickbox @error('invalid_time_start') is-invalid @enderror" 
                       autocomplete="off">
                @error('invalid_time_start')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- End Time -->
            <div class="form-group mb-3">
                <label for="flatpickrTimeEnd" class="col-form-label">Time End <span class="text-danger">*</span></label>
                <input id="flatpickrTimeEnd" type="text" name="invalid_time_end" value="{{ old('invalid_time_end', $schedule->invalid_time_end) }}" 
                       class="form-control form-control-clickbox @error('invalid_time_end') is-invalid @enderror" 
                       autocomplete="off">
                @error('invalid_time_end')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Apply to All Rooms -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="apply_to_all" id="applyToAll" value="1"
                {{ old('apply_to_all', $schedule->apply_to_all ?? false) ? 'checked' : '' }}>
                <label class="form-check-label font-weight-medium" for="applyToAll">Apply to All Rooms</label>
            </div>

            <!-- Room Selector -->
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
                                    {{ (is_array(old('no_room', $scheduleRooms)) && in_array($room->no_room, old('no_room', $scheduleRooms))) ? 'checked' : '' }}
                                    {{ old('apply_to_all', $schedule->apply_to_all ?? false) ? 'disabled' : '' }}
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

            <div class="form-group mb-0 d-flex flex-column flex-sm-row gap-2">
                <button type="submit" class="btn btn-success btn-md rounded" data-bs-toggle="tooltip" data-bs-placement="top" title="Update">
                    <i class="fas fa-check me-1"></i> Update
                </button>

                <a href="{{ route('schedule.index') }}" class="btn btn-danger btn-md rounded" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize flatpickr for date
    flatpickr('#flatpickrDate', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        disable: @json($unavailableSlots->pluck('invalid_date')->unique())
    });

    // Initialize flatpickr for time
    flatpickr('#flatpickrTimeStart', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });

    flatpickr('#flatpickrTimeEnd', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });

    // Toggle disabling room checkboxes if "Apply to All" is checked
    const applyToAllCheckbox = document.getElementById('applyToAll');
    const roomCheckboxes = document.querySelectorAll('input[name="no_room[]"]');

    function toggleRoomCheckboxes() {
        roomCheckboxes.forEach(checkbox => {
            checkbox.disabled = applyToAllCheckbox.checked;
            if (applyToAllCheckbox.checked) {
                checkbox.checked = false;
            }
        });
    }

    applyToAllCheckbox.addEventListener('change', toggleRoomCheckboxes);

    // Initialize on page load
    toggleRoomCheckboxes();
});
</script>
@endpush
