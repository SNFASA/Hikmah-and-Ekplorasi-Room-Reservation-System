@extends('frontend.layouts.master')
@section('title','Checkout Room')
@section('main-content')
<div class="container">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
    <h1>My Bookings</h1>

    @forelse($bookingDetails as $booking)
        <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
            <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                <div class="job-content">
                    <h5 class="text-center text-md-left">Room: {{ $booking->room_name }}</h5>
                    <ul class="d-md-flex flex-wrap text-capitalize ff-open-sans">
                        <li class="mr-md-4">
                            <i class="zmdi zmdi-calendar mr-2"></i> Date : {{ $booking->booking_date }}
                        </li>
                        <li class="mr-md-4">
                            <i class="zmdi zmdi-time mr-2"></i>Time Start : {{ $booking->booking_time_start }}
                        </li>
                        <li class="mr-md-4">
                            <i class="zmdi zmdi-time mr-2"></i> Time End : {{ $booking->booking_time_end }}
                        </li>
                        <li class="mr-md-4">Participants:</li>
                        @foreach($booking->students as $student)
                            <li style="margin-right: 10px;" > {{ $student }} </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <form method="POST" action="{{ route('cancel.booking', $booking->booking_id) }}">
                @csrf
                @method('delete')
                <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                    <i class="fas fa-trash-alt" data-id="{{ $booking->booking_id }}">CANCEL</i>
                </button>
            </form> 
            <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
              <a href="{{ route('booking.edit', $booking->booking_id) }}">Edit
              </a>
            </button>      
        </div>
    @empty
        <p>You have no bookings.</p>
    @endforelse
</div>
@endsection


@push('styles')
  <style>
  .ul {
      list-style: none; 
    }
    
    .list-disk li {
      list-style: none;
      margin-bottom: 12px;
    }
    
    .list-disk li:last-child {
      margin-bottom: 0;   
    }
    
    .job-box .img-holder {
      height: 65px;
      width: 65px;
      background-color: #4e63d7;
      background-image: -webkit-gradient(linear, left top, right top, from(rgba(78, 99, 215, 0.9)), to(#5a85dd));
      background-image: linear-gradient(to right, rgba(78, 99, 215, 0.9) 0%, #5a85dd 100%);
      font-family: "Open Sans", sans-serif;
      color: #fff;
      font-size: 22px;
      font-weight: 700;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: center;
          -ms-flex-pack: center;
              justify-content: center;
      -webkit-box-align: center;
          -ms-flex-align: center;
              align-items: center;
      border-radius: 65px;
    }
    
    .career-title {
      background-color: #4e63d7;
      color: #fff;
      padding: 15px;
      text-align: center;
      border-radius: 10px 10px 0 0;
      background-image: -webkit-gradient(linear, left top, right top, from(rgba(78, 99, 215, 0.9)), to(#5a85dd));
      background-image: linear-gradient(to right, rgba(78, 99, 215, 0.9) 0%, #5a85dd 100%);
    }
    
    .job-overview {
      -webkit-box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
              box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
      border-radius: 10px;
    }
    
    @media (min-width: 992px) {
      .job-overview {
        position: -webkit-sticky;
        position: sticky;
        top: 70px;
      }
    }
    
    .job-overview .job-detail ul {
      margin-bottom: 28px;
    }
    
    .job-overview .job-detail ul li {
      opacity: 0.75;
      font-weight: 600;
      margin-bottom: 15px;
    }
    
    .job-overview .job-detail ul li i {
      font-size: 20px;
      position: relative;
      top: 1px;
    }
    
    .job-overview .overview-bottom,
    .job-overview .overview-top {
      padding: 35px;
    }
    
    .job-content ul li {
      font-weight: 600;
      opacity: 0.75;
      border-bottom: 1px solid #ccc;
      padding: 10px 5px;
    }
    
    @media (min-width: 768px) {
      .job-content ul li {
        border-bottom: 0;
        padding: 0;
      }
    }
    
    .job-content ul li i {
      font-size: 20px;
      position: relative;
      top: 1px;
    }
    
    .mb-30 {
        margin-bottom: 30px;
    }
  <style>
@endpush
