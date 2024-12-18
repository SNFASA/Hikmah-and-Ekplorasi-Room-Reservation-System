<header class="header shop">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Topbar -->
    <div class="topbar">
        <div  iv class="container">
            <div class="row">
                <div class="logoCus">
                    <a href="{{ route('home') }}"><img src="{{ asset('images/uthm.png') }}" alt="logo"></a>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                                $settings = DB::table('settings')->get();
                            @endphp
                            <li>
                                <i class="ti-headphone-alt"></i> 
                                @foreach($settings as $data) {{ $data->phone }} @endforeach
                            </li>
                            <li>
                                <i class="ti-email"></i> 
                                @foreach($settings as $data) {{ $data->email }} @endforeach
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="right-content">
                        <ul class="list-main">
                            @auth 
                                @if(Auth::user()->role == 'admin')
                                    <li><i class="ti-user"></i> <a href="{{ route('admin') }}">Dashboard</a></li>
                                @else 
                                    <li><i class="ti-user"></i> <a href="{{ route('user') }}">Dashboard</a></li>
                                @endif
                                <li><i class="ti-power-off"></i> <a href="{{ route('user.logout') }}">Logout</a></li>
                            @else
                                <li><i class="ti-power-off"></i>
                                    <a href="{{ route('login.form') }}">Login</a> / 
                                    <a href="{{ route('register.form') }}">Register</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Middle Inner -->

</header>

<!-- Custom CSS -->
<style>        /* Custom styling for box radius */
    .search-box {
        border-radius: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #whitesmoke;
        padding: 10px;
    }
    .input-box {
        border-radius: 20px;
        
    }
        /* Custom styles for form elements */
        .form-label {
            font-weight: bold;
        }

        .multiselect-container {
            max-height: 200px; /* Limit dropdown height */
            overflow-y: auto; /* Scrollbar for overflow */
        }

        .custom-multiselect {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
        }
    .logoCus{
       size: 50px
        margin: 20px 10px 20px 10px;
    }
        
</style>

<!-- JavaScript for Guest Count -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const decreaseBtn = document.getElementById('decreaseGuests');
        const increaseBtn = document.getElementById('increaseGuests');
        const guestCount = document.getElementById('guestCount');

        decreaseBtn.addEventListener('click', function () {
            let count = parseInt(guestCount.value);
            if (count > 1) {
                guestCount.value = count - 1;
            }
        });

        increaseBtn.addEventListener('click', function () {
            let count = parseInt(guestCount.value);
            guestCount.value = count + 1;
        });
    });  
</script>
    <!-- Bootstrap Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
      rel="stylesheet"
    /> 
    <!-- Bootstrap CSS -->

    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>