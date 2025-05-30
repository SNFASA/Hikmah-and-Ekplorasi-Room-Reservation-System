<!-- Header Section -->
<header class="bg-light shadow-sm">
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Topbar (Logo and Contact Info) -->
    <div class="container py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2 ms-auto order-lg-3">
            <a href="#" class="text-dark fs-5"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-dark fs-5"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-dark fs-5"><i class="fab fa-x-twitter"></i></a>
            <a href="#" class="text-dark fs-5"><i class="fab fa-tiktok"></i></a>
            <a href="#" class="text-dark fs-5"><i class="fab fa-youtube"></i></a>
        </div>
        <!-- Logo -->
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/uthm.png') }}" alt="UTHM Logo" style="height: 80px;" class="me-3">
            <div>
                <h5 class="mb-0 fw-bold">Official Portal of Perpustakaan Tunku Tun Aminah</h5>
                <h6 class="mb-0 text-muted">Hikmah and Eksplorasi Room Reservation System</h6>
            </div>
        </div>
    </div>
</header>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark  sticky-top shadow " style="z-index: 2000; background-color: #435dba;">
    <div class="container-fluid mx-5 d-flex">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarContent">
            <!-- Left Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('my.bookings') }}">
                            <i class="fas fa-bookmark me-1"></i> My Booking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('show.calendar') }}">
                            <i class="fas fa-calendar-alt me-1"></i> Schedule Booking
                        </a>
                    </li>
                @endauth
            </ul>

            <!-- Right Links -->
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(Auth::user()->role == 'user')
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i> Account
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('user-profile') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.change.password.form') }}"><i class="fas fa-key me-2"></i> Change Password</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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
                            <a class="nav-link text-white" href="{{ route('admin') }}"><i class="ti-user me-1"></i> Dashboard</a>
                        </li>
                    @elseif(Auth::user()->role == 'ppp')
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('ppp.dashboard') }}"><i class="ti-user me-1"></i> Dashboard</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login.form') }}">
                            <i class="ti-power-off me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register.form') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS (for dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .navbar-nav .nav-link:hover {
        color: #eb242b !important;
    }
    .dropdown-menu .dropdown-item:hover {
        color: #eb242b !important;
        background-color: transparent;
    }
</style>
