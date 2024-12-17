@extends('frontend.layouts.master')
@section('title','E-SHOP || HOME PAGE')
@section('main-content')
<!-- Start Product Area -->
<!-- Start Product Area -->
<div class="product-area section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>List Room Reservation</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    <div class="tab-content isotope-grid" id="myTabContent">
                         <!-- Start Single Tab -->
                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ">
                                <div class="single-product">
                                    <div class="card" style="width: 18rem; margin-left: 20px;">
                                        <img class="card-img-top" src="{{asset('images/OIP.jpeg')}}" alt="Card image cap">
                                        <div class="card-body">
                                          <h5 class="card-title">Card title</h5>
                                          <p class="card-text">Capacity : 5 guest </p>
                                          <p class="card-text">Furniture: Chiar , desk , JapanisTable</p>
                                          <p class="card-text">Electronic Equipment: Computer</p>
                                          <a href="#"class="btn btn-lg btn-primary">Reserve Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ">
                                <div class="single-product">
                                    <div class="card" style="width: 18rem;">
                                        <img class="card-img-top" src="{{asset('images/OIP.jpeg')}}" alt="Card image cap">
                                        <div class="card-body">
                                          <h5 class="card-title">Card title</h5>
                                          <p class="card-text">Capacity : 5 guest </p>
                                          <p class="card-text">Furniture: Chiar , desk , JapanisTable</p>
                                          <p class="card-text">Electronic Equipment: Computer</p>
                                          <a href="#"class="btn btn-lg btn-primary">Reserve Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                         <!--/ End Single Tab -->


                    <!--/ End Single Tab -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
    <style>
        /* Banner Sliding */
        #Gslider .carousel-inner {
        background: #000000;
        color:black;
        }

        #Gslider .carousel-inner{
        height: 550px;
        }
        #Gslider .carousel-inner img{
            width: 100% !important;
            opacity: .8;
        }

        #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        color: #0d6efd;
        }

        #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: black;
        margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
        bottom: 70px;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>

        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });

        });

        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine : 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function(){
            $(this).on('click', function(){
                for(var i=0; i<isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });
    </script>
    <script>
         function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>

@endpush
