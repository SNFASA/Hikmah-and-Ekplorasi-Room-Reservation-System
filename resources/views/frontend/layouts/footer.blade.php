<!-- Start Footer Area -->
<footer class="footer text-white pt-5" style="background: linear-gradient(135deg, #171258 0%, #1a1660 100%);">
    <!-- Footer Top -->
    <div class="footer-top section">
        <div class="container">
            <div class="row gy-5">
                <!-- Logo & Address -->
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="footer-brand d-flex align-items-start gap-3 mb-4">
                        <div class="footer-logo">
                            <img src="{{ asset('images/PTTA Logo Footer.png') }}" alt="PTTA Logo" class="logo-image">
                        </div>
                        <div class="brand-info flex-1">
                            @php $settings = DB::table('settings')->get(); @endphp
                            <h5 class="brand-title">Tunku Tun Aminah Library</h5>
                            <p class="brand-subtitle">Excellence in Information Services</p>
                        </div>
                    </div>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt contact-icon"></i>
                            <div class="contact-content">
                                <strong>Address:</strong><br>
                                Universiti Tun Hussein Onn Malaysia (UTHM),<br>
                                86400 Parit Raja, Batu Pahat, Johor, Malaysia.
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <i class="fas fa-phone contact-icon"></i>
                            <div class="contact-content">
                                <strong>Phone:</strong> @foreach($settings as $data) {{$data->phone}} @endforeach
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <i class="fas fa-fax contact-icon"></i>
                            <div class="contact-content">
                                <strong>Fax:</strong> +607-4533199
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <i class="fab fa-whatsapp contact-icon"></i>
                            <div class="contact-content">
                                <strong>WhatsApp:</strong> +607-4533318
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <i class="fas fa-envelope contact-icon"></i>
                            <div class="contact-content">
                                <strong>Email:</strong> @foreach($settings as $data) {{$data->email}} @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UTHM Links -->
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="footer-section">
                        <h6 class="footer-title">
                            <i class="fas fa-university me-2"></i>
                            UTHM Links
                        </h6>
                        <ul class="footer-links">
                            <li><a href="https://www.uthm.edu.my/en/" class="footer-link">
                                <i class="fas fa-external-link-alt link-icon"></i>
                                UTHM Website
                            </a></li>
                            <li><a href="https://penerbit.uthm.edu.my/ojs/" class="footer-link">
                                <i class="fas fa-journal-whills link-icon"></i>
                                UTHM Journals
                            </a></li>
                            <li><a href="https://publisher.uthm.edu.my/periodicals/" class="footer-link">
                                <i class="fas fa-newspaper link-icon"></i>
                                UTHM Periodicals
                            </a></li>
                            <li><a href="http://e-bookstore.uthm.edu.my/" class="footer-link">
                                <i class="fas fa-shopping-cart link-icon"></i>
                                UTHM e-Bookstore
                            </a></li>
                            <li><a href="https://news.uthm.edu.my/ms/e-wacana/" class="footer-link">
                                <i class="fas fa-rss link-icon"></i>
                                UTHM e-News
                            </a></li>
                            <li><a href="https://wecare.uthm.edu.my/" class="footer-link">
                                <i class="fas fa-heart link-icon"></i>
                                UTHM WeCare
                            </a></li>
                        </ul>
                    </div>
                </div>

                <!-- Related Links -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="footer-section">
                        <h6 class="footer-title">
                            <i class="fas fa-link me-2"></i>
                            Related Links
                        </h6>
                        <ul class="footer-links">
                            <li><a href="http://perpun.upm.edu.my/myuninet/" class="footer-link">
                                <i class="fas fa-network-wired link-icon"></i>
                                My UniNet
                            </a></li>
                            <li><a href="https://www.pnm.gov.my/" class="footer-link">
                                <i class="fas fa-landmark link-icon"></i>
                                National Library of Malaysia
                            </a></li>
                            <li><a href="https://www.u-library.gov.my/portal/web/guest/home" class="footer-link">
                                <i class="fas fa-book-open link-icon"></i>
                                u-Pustaka
                            </a></li>
                            <li><a href="https://kik.pnm.gov.my/index.php/en/" class="footer-link">
                                <i class="fas fa-database link-icon"></i>
                                Katalog Induk Kebangsaan (KIK)
                            </a></li>
                            <li><a href="https://ppaj.johor.gov.my/" class="footer-link">
                                <i class="fas fa-building link-icon"></i>
                                Perbadanan Perpustakaan Awam Johor
                            </a></li>
                        </ul>
                    </div>
                </div>

                <!-- Social & Connect -->
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="footer-section">
                        <h6 class="footer-title">
                            <i class="fas fa-share-alt me-2"></i>
                            Follow Us
                        </h6>
                        
                        <div class="social-links mb-4">
                            <a href="https://www.facebook.com/PTTAUTHM" class="social-link facebook" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.instagram.com/pttauthm/" class="social-link instagram" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://x.com/i/flow/login?redirect_after_login=%2Fpttauthm" class="social-link twitter" aria-label="Twitter/X">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                            <a href="https://www.tiktok.com/@pttauthm?lang=en" class="social-link tiktok" aria-label="TikTok">
                                <i class="fab fa-tiktok"></i>
                            </a>
                            <a href="https://www.youtube.com/@pttauthm9142/featured" class="social-link youtube" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->

    <!-- Copyright -->
    <div class="copyright-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-12">
                    <div class="copyright-text">
                        <p class="mb-0">
                            Copyright © {{date('Y')}} 
                            <a href="https://github.com/SNFASA" class="developer-link" target="_blank">SYED NABIL</a>
                            - All Rights Reserved.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="footer-meta text-md-end text-center">
                        <span class="meta-item">
                            <i class="fas fa-code me-1"></i>
                            Made with <i class="fas fa-heart text-danger mx-1"></i> for UTHM
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- /End Footer Area -->
<!-- Scripts -->
<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('frontend/js/popper.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/js/colors.js')}}"></script>
<script src="{{asset('frontend/js/slicknav.min.js')}}"></script>
<script src="{{asset('frontend/js/owl-carousel.js')}}"></script>
<script src="{{asset('frontend/js/magnific-popup.js')}}"></script>
<script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
<script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script>
<script src="{{asset('frontend/js/nicesellect.js')}}"></script>
<script src="{{asset('frontend/js/flex-slider.js')}}"></script>
<script src="{{asset('frontend/js/scrollup.js')}}"></script>
<script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script>
<script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('frontend/js/easing.js')}}"></script>
<script src="{{asset('frontend/js/active.js')}}"></script>

@stack('scripts')

<script>
    // Alert auto-hide
    setTimeout(function(){
        $('.alert').slideUp();
    }, 5000);

    // Multi-level dropdown functionality
    $(function() {
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

    // Newsletter form functionality
    $(document).ready(function() {
        $('.newsletter-btn').on('click', function(e) {
            e.preventDefault();
            const email = $('.newsletter-input').val();
            
            if (email && isValidEmail(email)) {
                // Add your newsletter subscription logic here
                $(this).html('<i class="fas fa-check"></i>');
                setTimeout(() => {
                    $(this).html('<i class="fas fa-paper-plane"></i>');
                    $('.newsletter-input').val('');
                }, 2000);
            } else {
                $('.newsletter-input').focus().css('border-color', '#ff6b6b');
                setTimeout(() => {
                    $('.newsletter-input').css('border-color', 'rgba(255, 255, 255, 0.2)');
                }, 2000);
            }
        });

        // Enter key support for newsletter
        $('.newsletter-input').on('keypress', function(e) {
            if (e.which === 13) {
                $('.newsletter-btn').click();
            }
        });

        // Email validation function
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    });

    // Smooth scroll animation for footer links
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading animation to external links
        const externalLinks = document.querySelectorAll('.footer-link[href^="http"]');
        externalLinks.forEach(link => {
            link.addEventListener('click', function() {
                const icon = this.querySelector('.link-icon');
                const originalClass = icon.className;
                icon.className = 'fas fa-spinner fa-spin link-icon';
                
                setTimeout(() => {
                    icon.className = originalClass;
                }, 1000);
            });
        });
    });
</script>