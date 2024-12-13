@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system ')
@section('main-content')

<div class="card">
    <h5 class="card-header">Manage Schedule Booking</h5>
    <div class="card-body">
        <form method="post" action="{{ route('schedule.update', $schedule->id) }}">
            @csrf 
            @method('PATCH')
        <!-- Date -->
        <div class="form-group">
            <label for="flatpickrDate" class="col-form-label">Unavailable Date<span class="text-danger">*</span></label>
            <input id="flatpickrDate" type="text" name="invalid_date" value="{{ $schedule->invalid_date }}" class="form-control">
            @error('invalid_date')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
  
          <!-- Start Time -->
          <div class="form-group">
            <label for="flatpickrTime" class="col-form-label">Time Start<span class="text-danger">*</span></label>
            <input id="flatpickrTimeStart" type="text" name="invalid_time_start" value="{{ $schedule->invalid_time_start}}" class="form-control">
            @error('invalid_time_start')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
  
          <!-- End Time -->
          <div class="form-group">
            <label for="flatpickrTime" class="col-form-label">Time End<span class="text-danger">*</span></label>
            <input id="flatpickrTimeEnd" type="text" name="invalid_time_end" value="{{ $schedule->invalid_time_end }}" class="form-control">
            @error('invalid_time_end')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <select name="no_room" class="form-control">
            <option value="">-----Select Room-----</option>
            @foreach($rooms as $room)
                <option value="{{ $room->no_room }}" {{ $schedule->roomid == $room->no_room ? 'selected' : '' }}>
                    {{ $room->name }}
                </option>
            @endforeach
        </select>
        
          <div class="form-group mb-3">
            <button class="btn btn-success" type="submit">Update</button>
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
        altFormat: "F j, Y", // Example: November 26, 2024
        dateFormat: "Y-m-d", // Format for form submission
    });

    // Initialize Flatpickr for Time Start
    flatpickr("#flatpickrTimeStart", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // 24-hour format
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