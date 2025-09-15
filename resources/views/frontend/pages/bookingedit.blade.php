@extends('frontend.layouts.master')
@section('title','Checkout Edit Room')
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Update Booking</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
            <form class="form" method="POST" action="{{ route('booking.update', $booking->id) }}?no_room={{ $room->no_room }}">
                @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <div class="checkout-form">
                                <h2>Make Your Update Booking Here</h2>
                                <p>Please Update in booking to checkout more quickly</p>
                                <!-- Form -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Propose<span>*</span></label>
                                            <input type="text" name="purpose" placeholder="proposes booking"  value="{{ $booking->purpose }}" required>
                                            @error('purpose')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Phone number<span>*</span></label>
                                            <input type="text" name="phone_number" placeholder="011 12345678" value="{{ $booking->phone_number }}" required>
                                            @error('phone_number')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Start Time<span>*</span></label>
                                            <input type="time" name="booking_time_start" placeholder="" value="{{ $booking->booking_time_start }}" required  >                                           @error('booking_time_start')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>End Time<span>*</span></label>
                                            <input type="time" name="booking_time_end" placeholder="" value="{{ $booking->booking_time_end  }}" required >
                                           @error('booking_time_end')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Date <span>*</span></label>
                                            <input type="date" name="booking_date" placeholder="" required value="{{ $booking->booking_date }}" >                                            @error('booking_date')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div id="students-list" class="form-group">
                                            @foreach($selectedStudents as $index => $student)
                                            <div class="student-entry">
                                                <label>No Matriks:</label>
                                                <input type="text" name="students[{{ $index }}][no_matriks]" value="{{ $student->no_matriks }}" class="form-control">
                                                <label>Name:</label>
                                                <input type="text" name="students[{{ $index }}][name]" value="{{ $student->name ?? '' }}" class="form-control">
                                                <button type="button" class="btn btn-danger remove-student" style="margin:10px 0">Remove</button>
                                            </div>
                                            @endforeach
                                        </div>
                                        <button type="button" id="add-student" class="btn btn-primary" style="margin:10px 0">Add Student</button>
                                    </div>
                                    
                                </div>
                                <!--/ End Form -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="order-details">
                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2>Room Details</h2>
                                        <div class="content">
                                            @if ($room->image)
                                                <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top" alt="Room Image">
                                            @else
                                                <img src="{{ asset('images/ruang terbuka.jpg') }}" class="card-img-top" alt="No Image Available">
                                            @endif
                                            <ul>
                                                <li class="order_subtotal" data-price="">Room
                                                    <span class="shipping">{{$room->name}}</span>
                                                </li>
                                                <li class="shipping">Capacity<span>{{$room->capacity}} Guest</span></li>
                                                <li class="shipping">Furniture<span>{{ implode(', ', $room->furnitures->pluck('name')->toArray()) ?: 'N/A' }}</span></li>
                                                <li class="shipping">Electronic<span> {{ implode(', ', $room->electronics->pluck('name')->toArray()) ?: 'N/A' }}</span> <br>Equipment</li>
                                            </ul>
                                        </div>
                                </div>
                                <!--/ End Order Widget -->
                                <!-- Button Widget -->
                                <div class="single-widget get-button">
                                    <div class="content">
                                        <div class="button">
                                            <button type="submit" class="btn btn-primary">proceed to update checkout</button>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Button Widget -->
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </section>
    <!--/ End Checkout -->
@endsection
@push('styles')
	<style>
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#FF6F61 !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}
	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
<script>
    document.getElementById('add-student').addEventListener('click', function () {
        const studentsList = document.getElementById('students-list');
        const count = studentsList.children.length;

        if (count >= 10) {
            alert('You can only add a maximum of 10 students.');
            return;
        }

        const studentEntry = document.createElement('div');
        studentEntry.classList.add('student-entry');
        studentEntry.innerHTML = `
            <label>No Matriks:</label>
            <input type="text" name="students[${count}][no_matriks]" class="form-control" required>
            <label>Name:</label>
            <input type="text" name="students[${count}][name]" class="form-control" required>
            <button type="button" class="btn btn-danger remove-student" style="margin:10px 0">Remove</button>
        `;
        studentsList.appendChild(studentEntry);

        // Add event listener for new remove buttons
        attachRemoveEvent(studentEntry.querySelector('.remove-student'));
    });

    function attachRemoveEvent(button) {
        button.addEventListener('click', function () {
            const studentEntry = button.closest('.student-entry');
            studentEntry.remove();
        });
    }

    // Attach event listeners to existing remove buttons
    document.querySelectorAll('.remove-student').forEach(attachRemoveEvent);

    document.getElementById('your-form-id').addEventListener('submit', function (event) {
        const studentsList = document.getElementById('students-list');
        const count = studentsList.children.length;

        if (count < 4) {
            alert('You must add at least 4 students before submitting the form.');
            event.preventDefault();
        }
    });
</script>

@endpush



