@extends('frontend.layouts.master')
@section('title','Checkout Room')
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
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
                <form class="form" method="POST" action="">
                    @csrf
                    <div class="row"> 

                        <div class="col-lg-8 col-12">
                            <div class="checkout-form">
                                <h2>Make Your Checkout Here</h2>
                                <p>Please register in booking to checkout more quickly</p>
                                <!-- Form -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Propose<span>*</span></label>
                                            <input type="text" name="propose" placeholder="proposes booking" value="" value="">
                                           {{-- @error('propose')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror--}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Phone number<span>*</span></label>
                                            <input type="text" name="phone_number" placeholder="011 12345678" value="">
                                           {{-- @error('phone_number')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror--}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Start Time<span>*</span></label>
                                            <input type="time" name="booking_time_start" placeholder="" value="">
                                           {{-- @error('booking_time_start')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror--}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>End Time<span>*</span></label>
                                            <input type="time" name="booking_time_end" placeholder="" value="">
                                          {{--  @error('booking_time_end')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror--}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Date <span>*</span></label>
                                            <input type="date" name="booking_date" placeholder="" required value="">
                                           {{-- @error('phone')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div id="students-list" class="form-group">
                                            <div class="form-group">
                                                <label class="col-form-label">No Matriks:<span>*</span></label>
                                                <input type="text" name="students[0][no_matriks]" required class="form-control">
                                
                                                <label for="name[]" class="col-form-label"> Name:<span>*</span></label>
                                                <input type="text" name="students[0][name]" required class="form-control">
                                            </div>
                                          </div>
                                          <button type="button" id="add-student"class="btn btn-primary" style="margin:10px 0 10px 0">Add Student</button>
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
                                        <img class="card-img-top" src="{{asset('images/OIP.jpeg')}}" alt="Card image cap">
                                        <ul>
										    <li class="order_subtotal" data-price="">Room
                                                <span class="shipping">Hikmah 19</span>
                                            </li>
                                            <li class="shipping">Capacity<span>5 guest</span></li>
                                            <li class="shipping">Furniture<span>Chair, Desk</span></li>
                                            <li class="shipping">Electronic equipment<span>Computer , LCD projector</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--/ End Order Widget -->
                                <!-- Button Widget -->
                                <div class="single-widget get-button">
                                    <div class="content">
                                        <div class="button">
                                            <button type="submit" class="btn btn-primary">proceed to checkout</button>
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
		function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			// alert(checkbox);
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') ); 
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0; 
				// alert(coupon);
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});

	</script>
    <script>
            document.getElementById('add-student').addEventListener('click', function() {
            const studentsList = document.getElementById('students-list');
            const count = studentsList.children.length;

            // Check if the number of students is within the allowed range
            if (count >= 10) {
                alert('You can only add a maximum of 10 students.');
                return;
            }

            const studentEntry = document.createElement('div');
            studentEntry.classList.add('student-entry');
            studentEntry.innerHTML = `
            <label class="col-form-label" for="students{${count}][no_matriks]">No Matriks:</label>
            <input type="text" name="students[${count}][no_matriks]" required class="form-control">

            <label for="students[${count}[name]" class="col-form-label"> Name:</label>
            <input type="text" name="students[${count}][name]" required class="form-control">
            `;
            studentsList.appendChild(studentEntry);
        });

        // Ensure at least 4 students are present before form submission
        document.getElementById('your-form-id').addEventListener('submit', function(event) {
            const studentsList = document.getElementById('students-list');
            const count = studentsList.children.length;

            if (count < 4) {
                alert('You must add at least 4 students before submitting the form.');
                event.preventDefault(); // Stop form submission
            }
        });

    </script>

@endpush