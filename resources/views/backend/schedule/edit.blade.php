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
                <input id="flatpickrDate" type="text" name="invalid_date" value="{{ $schedule->invalid_date }}" 
                       class="form-control form-control-clickbox @error('invalid_date') is-invalid @enderror" 
                       autocomplete="off">
                @error('invalid_date')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Start Time -->
            <div class="form-group mb-3">
                <label for="flatpickrTimeStart" class="col-form-label">Time Start <span class="text-danger">*</span></label>
                <input id="flatpickrTimeStart" type="text" name="invalid_time_start" value="{{ $schedule->invalid_time_start }}" 
                       class="form-control form-control-clickbox @error('invalid_time_start') is-invalid @enderror" 
                       autocomplete="off">
                @error('invalid_time_start')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- End Time -->
            <div class="form-group mb-3">
                <label for="flatpickrTimeEnd" class="col-form-label">Time End <span class="text-danger">*</span></label>
                <input id="flatpickrTimeEnd" type="text" name="invalid_time_end" value="{{ $schedule->invalid_time_end }}" 
                       class="form-control form-control-clickbox @error('invalid_time_end') is-invalid @enderror" 
                       autocomplete="off">
                @error('invalid_time_end')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Room Select -->
            <div class="form-group mb-4" id="roomSelector">
                <label class="font-weight-semibold mb-2">Select Room(s) <span class="text-danger">*</span></label>
                <div class="row">
                    @foreach($rooms as $room)
                        <div class="col-md-4 col-sm-6 mb-2">
                            <div class="form-check rounded border p-2 bg-light hover-shadow transition" 
                                style="cursor: pointer;">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="no_room[]" 
                                    id="room_{{ $room->no_room }}" 
                                    value="{{ $room->no_room }}"
                                    {{ (is_array(old('no_room', [$schedule->roomid])) && in_array($room->no_room, old('no_room', [$schedule->roomid]))) ? 'checked' : '' }}
                                >
                                <label class="form-check-label mb-0" for="room_{{ $room->no_room }}">
                                    {{ $room->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('no_room')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-0 d-flex flex-column flex-sm-row gap-2">
                <button type="submit" class="btn btn-success btn-md rounded" data-bs-toggle="tooltip" data-bs-placement="top" title="Update">
                    <i class="fas fa-check me-1"></i> Update
                </button>

                <a href="{{ route('schedule.index') }}" class="btn btn-danger btn-md rounded" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel">
                    <i class="fas fa-times me-1 "></i> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
  /* Card background with subtle border and shadow */
  .card {
    background-color: #fff;
  }

  /* Click box effect for inputs and selects */
  .form-control-clickbox {
    border: 1px solid #ced4da;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
    cursor: pointer;
  }
  .form-control-clickbox:focus {
    border-color: #198754; /* Bootstrap green */
    box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    outline: none;
    cursor: text;
  }

  /* Small round button */
  button.btn-sm.rounded-circle {
    width: 38px;
    height: 38px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Tooltip icon color */
  button.btn-success:hover, button.btn-success:focus {
    background-color: #157347 !important; /* Darker green */
    box-shadow: 0 0 8px rgba(21, 115, 71, 0.6);
  }
  .hover-shadow:hover {
  box-shadow: 0 0 10px rgba(0,0,0,0.15);
  transition: box-shadow 0.3s ease;
  }

</style>
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
<script>
  // Enable Bootstrap tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  });

  // Initialize Flatpickr for Date
  flatpickr("#flatpickrDate", {
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    disable: [
        @foreach ($unavailableSlots as $slot)
            "{{ $slot->invalid_date }}",
        @endforeach
        @foreach ($bookedSlots as $slot)
            "{{ $slot->booking_date }}",
        @endforeach
    ],
  });

  // Initialize Flatpickr for Time Start
  flatpickr("#flatpickrTimeStart", {
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
      time_24hr: true,
      disable: [
          // Disable unavailable times (schedule_booking table)
          @foreach ($unavailableSlots as $slot)
              {
                  from: "{{ $slot->invalid_date }} {{ $slot->invalid_time_start }}",
                  to: "{{ $slot->invalid_date }} {{ $slot->invalid_time_end }}",
              },
          @endforeach
          // Disable already booked times (bookings table)
          @foreach ($bookedSlots as $slot)
              {
                  from: "{{ $slot->booking_date }} {{ $slot->booking_time_start }}",
                  to: "{{ $slot->booking_date }} {{ $slot->booking_time_end }}",
              },
          @endforeach
      ]
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
