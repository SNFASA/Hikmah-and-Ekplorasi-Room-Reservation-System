<!-- Header -->
<header class="header shop">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Topbar -->
    <div class="topbar bg-light py-2 border-bottom">
        <div class="container">
            <div class="row align-items-center justify-content-between">

                <!-- Logo & Contact -->
                <div class="col-md-3 col-12 d-flex flex-column align-items-start">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/uthm.png') }}" alt="logo" style="max-height: 60px;">
                    </a>
                    @php
                        $settings = DB::table('settings')->get();
                    @endphp
                    <div class="mt-2 d-flex align-items-center flex-wrap text-dark small">
                        <i class="fas fa-phone-alt me-2"></i>
                        <span class="me-3">
                            @foreach($settings as $data)
                                {{ $data->phone }}
                            @endforeach
                        </span>
                        <i class="fas fa-envelope me-2"></i>
                        <span>
                            @foreach($settings as $data)
                                {{ $data->email }}
                            @endforeach
                        </span>
                    </div>
                </div>

                <!-- Navigation Menu + Right Content -->
                <div class="col-md-9 col-12 d-flex flex-wrap justify-content-end align-items-center gap-3 mt-3 mt-md-0">
                    <!-- Navigation Menu -->
                    <a href="{{ route('home') }}" class="text-decoration-none text-dark">
                        <i class="fas fa-home me-1"></i> Home
                    </a>

                    @auth
                        <a href="{{ route('my.bookings') }}" class="text-decoration-none text-dark">
                            <i class="fas fa-bookmark me-1"></i> My Booking
                        </a>
                        <a href="{{ route('show.calendar') }}" class="text-decoration-none text-dark">
                            <i class="fas fa-calendar-alt me-1"></i> Schedule Booking
                        </a>

                        @if(Auth::user()->role == 'user')
                            <a href="{{ route('user.change.password.form') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-key me-1"></i> Change Password
                            </a>
                            <a href="{{ route('user-profile') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-user me-1"></i> Profile
                            </a>
                        @endif

                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="text-decoration-none text-dark">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

                        <!-- Right Content (Dashboard Links) -->
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('admin') }}" class="text-decoration-none text-dark">
                                <i class="ti-user me-1"></i> Dashboard
                            </a>
                        @elseif(Auth::user()->role == 'ppp')
                            <a href="{{ route('ppp.dashboard') }}" class="text-decoration-none text-dark">
                                <i class="ti-user me-1"></i> Dashboard
                            </a>
                        @endif
                    @else
                        <!-- Guest: Login / Register -->
                        <a href="{{ route('login.form') }}" class="text-decoration-none text-dark">
                            <i class="ti-power-off me-1"></i> Login
                        </a>
                        <span class="text-muted">||</span>
                        <a href="{{ route('register.form') }}" class="text-decoration-none text-dark">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
