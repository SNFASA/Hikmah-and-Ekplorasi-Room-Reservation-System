@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system|| Booking Create')
@section('main-content')

<div class="card">
    <h5 class="card-header">Add Booking</h5>
    <div class="card-body">
      <form method="post" action="{{route('backend.booking.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputpurpose" class="col-form-label">Purpose<span class="text-danger">*</span></label>
        <input id="inputpurpose" type="text" name="purpose" placeholder="Enter purpose"  value="{{old('purpose')}}" class="form-control">
        @error('purpose')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="flatpickrDate" class="col-form-label">Date<span class="text-danger">*</span></label>
          <input id="flatpickrDate" type="text" name="booking_date" value="{{ old('booking_date') }}" class="form-control">
          @error('booking_date')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="flatpickrTime" class="col-form-label">Time<span class="text-danger">*</span></label>
          <input id="flatpickrTime" type="text" name="booking_time" value="{{ old('booking_time') }}" class="form-control">
          @error('booking_time')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="inputPhoneNumber" class="col-form-label">Phone number<span class="text-danger">*</span></label>
        <input id="inputphoneNumber" type="text" name="Phonenumber" placeholder="Enter Phone number"  value="{{old('Phonenumber')}}" class="form-control">
        @error('Phonenumber')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        @php
          $rooms = DB::table('rooms')->select('no_room', 'name')->get();
          $liststudent = DB::table('list_student_booking')->select('id','user_no_matriks1')->get();
        @endphp
        <div class="form-group">
          <label for="room" class="col-form-label">Room</label>
            <select name="room" class="form-control">
              <option value="">-----Select Room-----</option>
                @foreach($rooms as $room)
                  <option value="{{ $room->room }}">{{ $room->rooom }}</option>
                @endforeach
            </select>
              @error('room')
                <span class="text-danger">{{ $message }}</span>
              @enderror
        </div>
        <div class="form-group">
          <label for="liststudent" class="col-form-label">Student book</label>
            <select name="room" class="form-control">
              <option value="">-----Select Student-----</option>
                @foreach($liststudent as $student)
                  <option value="{{ $student->id }}">{{ $room->$student }}</option>
                @endforeach
            </select>
              @error('liststudent')
                <span class="text-danger">{{ $message }}</span>
              @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });

    document.addEventListener("DOMContentLoaded", function () {
    // Initialize Flatpickr for date
    flatpickr("#flatpickrDate", {
        altInput: true,
        altFormat: "F j, Y", // Example: November 26, 2024
        dateFormat: "Y-m-d", // Format for form submission
    });

    // Initialize Flatpickr for time
    flatpickr("#flatpickrTime", {
        enableTime: true,
        noCalendar: true, // No calendar for time picker
        dateFormat: "H:i", // Format for form submission (24-hour format)
        time_24hr: true, // Enable 24-hour time format
    });
});

</script>
@endpush