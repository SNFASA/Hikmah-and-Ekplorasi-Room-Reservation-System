<!-- Header Section -->
<header class="bg-light" style="position: relative;">
    <!-- Social Media Icons - Positioned Higher -->
    <div class="social-media-top">
        <div class="container">
            <div class="d-flex justify-content-end py-2">
                <div class="d-flex align-items-center gap-3">
                    <a href="https://www.facebook.com/PTTAUTHM" class="social-icon"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/pttauthm/" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="https://x.com/i/flow/login?redirect_after_login=%2Fpttauthm" class="social-icon"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.tiktok.com/@pttauthm?lang=en" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.youtube.com/@pttauthm9142/featured" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header Content -->
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-start align-items-center">
            <!-- Logo and Title -->
            <div class="d-flex align-items-center">
                <div class="logo-container me-4">
                    <img src="{{ asset('images/uthm.png') }}" alt="UTHM Logo" class="logo-img">
                </div>
                <div class="text-center text-md-start">
                    <h4 class="main-title mb-1">Official Portal of Perpustakaan Tunku Tun Aminah</h4>
                    <h6 class="sub-title mb-0">PTTA Reservation System</h6>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top modern-navbar">
    <div class="container-fluid mx-7 d-flex">
        <button class="navbar-toggler modern-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarContent">
            <!-- Left Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link modern-nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home me-2"></i> Home
                    </a>
                </li>
                <!-- Auth sections would go here in actual implementation -->
                <li class="nav-item">
                    <a class="nav-link modern-nav-link" href="{{ route('my.bookings') }}">
                        <i class="fas fa-bookmark me-2"></i> My Booking
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link modern-nav-link" href="{{ route('show.calendar') }}">
                        <i class="fas fa-calendar-alt me-2"></i> Schedule Booking
                    </a>
                </li>
            </ul>

            <!-- Right Links -->
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(Auth::user()->role == 'user')
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle modern-nav-link" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i> Account
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('user-profile') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('user.change.password.form') }}"><i class="fas fa-key me-2"></i> Change Password</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item modern-dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link modern-nav-link" href="{{ route('admin') }}"><i class="ti-user me-1"></i> Dashboard</a>
                        </li>
                    @elseif(Auth::user()->role == 'ppp')
                        <li class="nav-item">
                            <a class="nav-link modern-nav-link" href="{{ route('ppp.dashboard') }}"><i class="ti-user me-1"></i> Dashboard</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link modern-nav-link" href="{{ route('login.form') }}">
                            <i class="ti-power-off me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link modern-nav-link" href="{{ route('register.form') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS (for dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

