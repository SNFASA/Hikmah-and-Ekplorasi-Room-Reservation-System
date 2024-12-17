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
    <div class="container mt-5">
        <!-- Outer Box -->
        <div class="search-box">
            <!-- Inner Box -->
            <div class="input-box shadow-lg">
                <form class="d-flex justify-content-center">
                    <div class="input-group rounded-pill">
                        <!-- WHERE (Dropdown) -->
                        <span class="input-group-text border-0 bg-white fw-bold">Type Room</span>
                        <select class="form-select border-0" aria-label="Select Destination">
                            <option  value="city">City</option>
                            <option value="beach">Beach</option>
                        </select>

                        <!-- CHECK IN -->
                        <span class="input-group-text border-0 bg-white fw-bold">Check in</span>
                        <input type="date" class="form-control border-0" aria-label="Check in">

                        <!-- START TIME -->
                        <span class="input-group-text border-0 bg-white fw-bold">Start time</span>
                        <input type="time" class="form-control border-0" aria-label="Start time">

                        <!-- END TIME -->
                        <span class="input-group-text border-0 bg-white fw-bold">End time</span>
                        <input type="time" class="form-control border-0" aria-label="End time">

                        <!-- WHO -->
                        <span class="input-group-text border-0 bg-white fw-bold">Guest</span>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-primary btn-sm" type="button" id="decreaseGuests">-</button>
                            <input type="text" id="guestCount" class="form-control text-center border-0" value="1" style="width: 50px;" readonly>
                            <button class="btn btn-outline-primary btn-sm"  type="button" id="increaseGuests">+</button>
                        </div>

                        <!-- SEARCH BUTTON -->
                        <button class="btn btn-primary rounded-circle px-3" type="submit">
                            <i class="bi bi-search text-white"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Outer Box -->  
        
    </div>
        <div class="container mt-5"> 
            <!-- Row for Furniture and Electronic Equipment -->
            <div class="row">
                <!-- Furniture Dropdown -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Furniture</label>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Select Furniture
                        </button>
                        <ul class="dropdown-menu p-2 multiselect-container">
                            <li><label class="form-check-label w-100"><input type="checkbox" class="form-check-input"> Table</label></li>
                            <li><label class="form-check-label w-100"><input type="checkbox" class="form-check-input"> Chair</label></li>
                            <li><label class="form-check-label w-100"><input type="checkbox" class="form-check-input"> Sofa</label></li>
                            <li><label class="form-check-label w-100"><input type="checkbox" class="form-check-input"> Bed</label></li>
                        </ul>
                    </div>
                </div>
    
                <!-- Electronic Equipment Dropdown -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Electronic Equipment</label>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Select Equipment
                        </button>
                        <ul class="dropdown-menu p-2 multiselect-container">
                            <li><label class="form-check-label w-100"><input type="checkbox" class="form-check-input"> TV</label></li>
                            <li><label class="form-check-label w-100"><input type="checkbox" class="form-check-input"> Laptop</label></li>
                            <li><label class="form-check-label w-100"><input type="checkbox" class="form-check-input"> Fan</label></li>
                            <li><label class="form-check-label w-100"><input type="checkbox" class="form-check-input"> Microwave</label></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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
    document.addEventListener("DOMContentLoaded", function () {
            const furnitureDropdown = document.getElementById("furnitureDropdown");
            const electronicsDropdown = document.getElementById("electronicsDropdown");

            function updateButtonLabel(button, container) {
                const selectedItems = Array.from(container.querySelectorAll("input[type=checkbox]:checked"))
                    .map(checkbox => checkbox.nextElementSibling.innerText)
                    .join(", ");
                button.innerText = selectedItems || "Select Options";
            }

            // Handle Furniture Dropdown
            document.querySelectorAll("#furnitureDropdown + .dropdown-menu input[type=checkbox]").forEach(input => {
                input.addEventListener("change", function () {
                    updateButtonLabel(furnitureDropdown, furnitureDropdown.nextElementSibling);
                });
            });

            // Handle Electronics Dropdown
            document.querySelectorAll("#electronicsDropdown + .dropdown-menu input[type=checkbox]").forEach(input => {
                input.addEventListener("change", function () {
                    updateButtonLabel(electronicsDropdown, electronicsDropdown.nextElementSibling);
                });
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