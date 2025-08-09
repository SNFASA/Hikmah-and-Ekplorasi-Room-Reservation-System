<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow justify-content-between align-items-center">
        <!-- Left side controls -->
        <div class="d-flex flex-row gap-2 align-items-center">
            <!-- Sidebar Toggle -->
            <button id="sidebarToggleTop" class="btn btn-link btn-circle me-2" type="button" data-toggle="tooltip" data-placement="bottom" title="Toggle Sidebar">
                <i class="fa fa-bars"></i>
            </button>
            
            <!-- Admin Controls - Visible on larger screens -->
            <div class="admin-controls d-none d-md-flex flex-row">
                <a href="{{route('storage.link')}}" class="btn btn-outline-warning flex-row btn-sm px-3 shadow-sm">
                    <i class="fas fa-link me-1"></i>
                    <span class="btn-text">Storage Link</span>
                </a>
                <a href="{{route('cache.clear')}}" class="btn btn-outline-danger flex-row btn-sm px-3 shadow-sm">
                    <i class="fas fa-trash-alt me-1"></i>
                    <span class="btn-text">Cache Clear</span>
                </a>
            </div>

            <!-- Admin Controls - Mobile version (icons only) -->
            <div class="admin-controls admin-controls-mobile d-md-none d-flex flex-row">
                <a href="{{route('storage.link')}}" class="btn btn-outline-warning btn-sm px-2 shadow-sm" data-toggle="tooltip" title="Storage Link">
                    <i class="fas fa-link"></i>
                </a>
                <a href="{{route('cache.clear')}}" class="btn btn-outline-danger btn-sm px-2 shadow-sm" data-toggle="tooltip" title="Cache Clear">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </div>

        <!-- Right side navigation -->
        <ul class="navbar-nav ml-auto d-flex flex-row align-items-center">
            
            <!-- Mobile Search Toggle (Visible only on small screens) -->
            <!-- Home page -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link" href="{{route('home')}}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Home" role="button">
                    <i class="fas fa-home fa-fw"></i>
                </a>
            </li>

            <!-- Nav Item - Alerts -->

            <!-- Divider (Hidden on small screens) -->
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth()->user()->name}}</span>
                    <img class="img-profile rounded-circle" src="{{asset('backend/img/avatar.png')}}" alt="User Avatar">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{url('ppp.profile')}}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{url('ppp.change-password')}}">
                        <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                        Change Password
                    </a>
                    <a class="dropdown-item" href="{{url('settings')}}">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> 
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
</nav>

<script>
// Initialize tooltips for Bootstrap 4
document.addEventListener('DOMContentLoaded', function() {
    // Bootstrap 4 with jQuery
    if (typeof $ !== 'undefined' && $.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }
    
    // Bootstrap 4 dropdown initialization
    if (typeof $ !== 'undefined' && $.fn.dropdown) {
        $('.dropdown-toggle').dropdown();
    }
});

// Sidebar toggle functionality
document.getElementById('sidebarToggleTop')?.addEventListener('click', function() {
    // Add your sidebar toggle logic here
    console.log('Sidebar toggle clicked');
});
</script>