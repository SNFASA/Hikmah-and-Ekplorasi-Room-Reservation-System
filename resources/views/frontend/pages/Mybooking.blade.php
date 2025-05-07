@extends('frontend.layouts.master')
@section('title','LibraRoom Reservation system ')
@section('main-content')
@php
    use Carbon\Carbon;
@endphp
<div class="container mt-5">
  <h1 class="mb-4 text-primary">My Bookings</h1>

  @forelse($bookingDetails as $booking)
      <div class="card shadow mb-4">
          <div class="card-body">
              <h5 class="card-title text-center text-md-left">
                  <i class="fas fa-door-open text-primary"></i> Room: {{ $booking->room_name }}
              </h5>
              <ul class="list-unstyled row">
                  <li class="col-md-3 mb-2">
                      <i class="fas fa-calendar-alt text-secondary"></i> Date: {{ $booking->booking_date }}
                  </li>
                  <li class="col-md-3 mb-2">
                      <i class="fas fa-clock text-secondary"></i> Time Start: {{ $booking->booking_time_start }}
                  </li>
                  <li class="col-md-3 mb-2">
                      <i class="fas fa-clock text-secondary"></i> Time End: {{ $booking->booking_time_end }}
                  </li>
                  <li class="col-md-12 mt-2">
                      <i class="fas fa-users text-secondary"></i> Participants:
                      @foreach($booking->students as $student)
                          <span class="badge badge-pill badge-info mx-1">{{ $student }}</span>
                      @endforeach
                  </li>
              </ul>

              <hr>

              <div class="d-flex justify-content-end">
                  @php
                      $bookingEnd = Carbon::parse($booking->booking_date . ' ' . $booking->booking_time_end);
                  @endphp

                  @if ($bookingEnd->isFuture())
                      <!-- CANCEL -->
                      <form method="POST" action="{{ route('cancel.booking', $booking->booking_id) }}" class="mr-2">
                          @csrf
                          @method('delete')
                          <button class="btn btn-outline-danger btn-sm">
                              <i class="fas fa-times-circle"></i> Cancel
                          </button>
                      </form>

                      <!-- EDIT -->
                      <a href="{{ route('booking.edit', $booking->booking_id) }}" class="btn btn-outline-primary btn-sm">
                          <i class="fas fa-edit"></i> Edit
                      </a>
                  @else
                      <!-- FEEDBACK -->
                      <a href="{{ route('frontend.pages.feedbackcreate', ['booking_id' => $booking->booking_id]) }}" class="btn btn-success btn-sm">
                          <i class="fas fa-comment-dots"></i> Feedback
                      </a>
                  @endif
              </div>
          </div>
      </div>
  @empty
      <div class="alert alert-warning">You have no bookings.</div>
  @endforelse
</div>

@endsection
