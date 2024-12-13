@extends('backend.layouts.master')
@section('title', 'LibraRoom Reservation System')
@section('main-content')

<div class="card">
    <h5 class="card-header">Manage Schedule Booking</h5>
    <div class="card-body">
        <form method="post" action="{{ route('schedule.store') }}">
            @csrf

            <!-- Date -->
            <div class="form-group">
                <label for="flatpickrDate" class="col-form-label">Unavailable Date <span class="text-danger">*</span></label>
                <input id="flatpickrDate" type="text" name="invalid_date" value="{{ old('invalid_date') }}" class="form-control">
                @error('invalid_date')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Start Time -->
            <div class="form-group">
                <label for="flatpickrTimeStart" class="col-form-label">Time Start <span class="text-danger">*</span></label>
                <input id="flatpickrTimeStart" type="text" name="invalid_time_start" value="{{ old('invalid_time_start') }}" class="form-control">
                @error('invalid_time_start')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- End Time -->
            <div class="form-group">
                <label for="flatpickrTimeEnd" class="col-form-label">Time End <span class="text-danger">*</span></label>
                <input id="flatpickrTimeEnd" type="text" name="invalid_time_end" value="{{ old('invalid_time_end') }}" class="form-control">
                @error('invalid_time_end')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Room Selection -->
            <div class="form-group">
                <label for="no_room" class="col-form-label">Room <span class="text-danger">*</span></label>
                <select name="no_room" class="form-control">
                    <option value="">-----Select Room-----</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->no_room }}" {{ old('no_room') == $room->no_room ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                    @endforeach
                </select>
                @error('no_room')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="form-group mb-3">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
<script>
    // Initialize Flatpickr for Date
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });

    // Initialize Flatpickr for Time Start
    flatpickr("#flatpickrTimeStart", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });

    // Initialize Flatpickr for Time End
    flatpickr("#flatpickrTimeEnd", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });
</script>
@endpush
