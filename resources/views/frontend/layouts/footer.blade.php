
	<!-- Start Footer Area -->
<!-- Start Footer Area -->
<footer class="footer text-white pt-5" style="background-color: #171258;">

    <!-- Footer Top -->
    <div class="footer-top section">
        <div class="container">
            <div class="row gy-4">
                <!-- Logo & Address -->
                <div class="col-lg-5 col-md-6 col-12 d-flex">
                    <img src="{{ asset('images/PTTA Logo Footer.png') }}" alt="PTTA Logo" class="me-3" style="width: 150px; height:150px ;">
                    <div>
                        @php $settings = DB::table('settings')->get(); @endphp
                        <h6 class="fw-bold">Tunku Tun Aminah Library</h6>
                        <p>Universiti Tun Hussein Onn Malaysia (UTHM),<br>
                        86400 Parit Raja, Batu Pahat, Johor, Malaysia.</p>
                        <p>Phone: <strong>@foreach($settings as $data) {{$data->phone}} @endforeach</strong></p>
                        <p>Fax: +607-4533199</p>
                        <p>Whatsapp: +607-4533318</p>
                        <p>Email: @foreach($settings as $data) {{$data->email}} @endforeach</p>
                    </div>
                </div>

                <!-- UTHM Links -->
                <div class="col-lg-2 col-md-6 col-12">
                    <h6 class="fw-bold">UTHM Links</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-link me-2 text-primary"></i> UTHM Website</li>
                        <li><i class="fas fa-link me-2 text-primary"></i> UTHM Journals</li>
                        <li><i class="fas fa-link me-2 text-primary"></i> UTHM Periodicals</li>
                        <li><i class="fas fa-link me-2 text-primary"></i> UTHM e-Bookstore</li>
                        <li><i class="fas fa-link me-2 text-primary"></i> UTHM e-News</li>
                        <li><i class="fas fa-link me-2 text-primary"></i> UTHM WeCare</li>
                    </ul>
                </div>

                <!-- Related Links -->
                <div class="col-lg-3 col-md-6 col-12">
                    <h6 class="fw-bold">Related Links</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-link me-2 text-primary"></i> My UniNet</li>
                        <li><i class="fas fa-link me-2 text-primary"></i> National Library of Malaysia</li>
                        <li><i class="fas fa-link me-2 text-primary"></i> u-Pustaka</li>
                        <li><i class="fas fa-link me-2 text-primary"></i> Katalog Induk Kebangsaan (KIK)</li>
                        <li><i class="fas fa-link me-2 text-primary"></i> Perbadanan Perpustakaan Awam Johor</li>
                    </ul>
                </div>

                <!-- Social & Visitor Counter -->
                <div class="col-lg-2 col-md-6 col-12">
                    <h6 class="fw-bold">Follow Us</h6>
                    <div class="d-flex gap-2 fs-5 mb-3">
                        <a href="#" class="text-white hover-opacity"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white hover-opacity"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white hover-opacity"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="text-white hover-opacity"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-white hover-opacity"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->

    <!-- Copyright -->
    <div class="copyright border-top border-secondary mt-4 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0 small">Copyright © {{date('Y')}} 
                        <a href="https://github.com/SNFASA" class="text-info" target="_blank">SYED NABIL</a> 
                        - All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- /End Footer Area -->

<style>
.hover-opacity:hover {
    opacity: 0.75;
    transition: 0.3s ease;
}
.footer a {
    text-decoration: none;
}
.footer a:hover {
    color: #0d6efd; /* Bootstrap primary */
}

</style>

	<!-- /End Footer Area -->
 
	<!-- Jquery -->
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
	<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
	<!-- Popper JS -->
	<script src="{{asset('frontend/js/popper.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<!-- Color JS -->
	<script src="{{asset('frontend/js/colors.js')}}"></script>
	<!-- Slicknav JS -->
	<script src="{{asset('frontend/js/slicknav.min.js')}}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{asset('frontend/js/owl-carousel.js')}}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{asset('frontend/js/magnific-popup.js')}}"></script>
	<!-- Waypoints JS -->
	<script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
	<!-- Countdown JS -->
	<script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script>
	<!-- Nice Select JS -->
	<script src="{{asset('frontend/js/nicesellect.js')}}"></script>
	<!-- Flex Slider JS -->
	<script src="{{asset('frontend/js/flex-slider.js')}}"></script>
	<!-- ScrollUp JS -->
	<script src="{{asset('frontend/js/scrollup.js')}}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script>
	{{-- Isotope --}}
	<script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script>
	<!-- Easing JS -->
	<script src="{{asset('frontend/js/easing.js')}}"></script>

	<!-- Active JS -->
	<script src="{{asset('frontend/js/active.js')}}"></script>

	
	@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>
	  <style>
		.logocustom{
			size: 5pc;
		}
	  </style>