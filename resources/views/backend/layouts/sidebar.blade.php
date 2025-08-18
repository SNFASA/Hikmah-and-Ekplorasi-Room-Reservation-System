<!-- resources/views/layouts/sidebar.blade.php -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar" style=" left: 0; top: 0;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-3" href="{{ route('admin') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-building"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <hr class="sidebar-divider my-0 border-light">

    <!-- Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider border-light">

    <!-- Media -->
    <div class="sidebar-heading text-light px-3 small text-uppercase">
        Media
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('file-manager') }}">
            <i class="fas fa-photo-video"></i>
            <span>Media Manager</span>
        </a>
    </li>

    <hr class="sidebar-divider border-light">

    <!-- LibraRoom -->
    <div class="sidebar-heading text-light px-3 small text-uppercase">
        LibraRoom
    </div>

    <!-- Schedule -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#scheduleCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="scheduleCollapse">
            <i class="fas fa-calendar-alt"></i>
            <span>Schedule</span>
        </a>
        <div id="scheduleCollapse" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-light rounded collapse-inner p-2">
                <h6 class="collapse-header text-primary small">Schedule Options:</h6>
                <a class="collapse-item" href="{{ route('schedule.index') }}"><i class="fas fa-list me-2"></i>Schedule</a>
                <a class="collapse-item" href="{{ route('schedule.create') }}"><i class="fas fa-plus me-2"></i>Add Schedule</a>
                <a class="collapse-item" href="{{ route('show.calendar.admin') }}"><i class="fas fa-calendar me-2"></i>Calendar</a>
            </div>
        </div>
    </li>

    <!-- Booking -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#bookingCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="bookingCollapse">
            <i class="fas fa-book"></i>
            <span>Booking</span>
        </a>
        <div id="bookingCollapse" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-light rounded collapse-inner p-2">
                <h6 class="collapse-header text-primary small">Booking Options:</h6>
                <a class="collapse-item" href="{{ route('bookings.index') }}"><i class="fas fa-list me-2"></i>Booking</a>
                <a class="collapse-item" href="{{ route('bookings.create') }}"><i class="fas fa-plus me-2"></i>Add Booking</a>
            </div>
        </div>
    </li>

    <!-- Room -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#roomMenuCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="roomMenuCollapse">
            <i class="fas fa-door-closed"></i>
            <span>Room</span>
        </a>
        <div id="roomMenuCollapse" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-light rounded collapse-inner p-2">

                <!-- Room Options -->
                <a class="collapse-item collapsed" href="#roomListCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="roomListCollapse">
                    Room
                </a>
                <div id="roomListCollapse" class="collapse" data-parent="#roomMenuCollapse">
                    <div class="bg-white rounded px-3 py-2">
                        <a class="collapse-item" href="{{ route('room.index') }}"><i class="fas fa-list me-2"></i>Room</a>
                        <a class="collapse-item" href="{{ route('room.create') }}"><i class="fas fa-plus me-2"></i>Add Room</a>
                    </div>
                </div>

                <!-- Type Room -->
                <a class="collapse-item collapsed" href="#typeRoomCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="typeRoomCollapse">
                    Type Room
                </a>
                <div id="typeRoomCollapse" class="collapse" data-parent="#roomMenuCollapse">
                    <div class="bg-white rounded px-3 py-2">
                        <a class="collapse-item" href="{{ route('backend.type_room.index') }}"><i class="fas fa-list me-2"></i>Type Room</a>
                        <a class="collapse-item" href="{{ route('backend.type_room.create') }}"><i class="fas fa-plus me-2"></i>Add Type Room</a>
                    </div>
                </div>

            </div>
        </div>
    </li>

    <!-- Equipment -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#equipmentCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="equipmentCollapse">
            <i class="fas fa-tools"></i>
            <span>Equipment</span>
        </a>
        <div id="equipmentCollapse" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-light rounded collapse-inner p-2">

                <!-- Furniture -->
                <a class="collapse-item collapsed" href="#furnitureCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="furnitureCollapse">
                    Furniture
                </a>
                <div id="furnitureCollapse" class="collapse" data-parent="#equipmentCollapse">
                    <div class="bg-white rounded px-3 py-2">
                        <a class="collapse-item" href="{{ route('furniture.index') }}"><i class="fas fa-list me-2"></i>Furniture</a>
                        <a class="collapse-item" href="{{ route('furniture.create') }}"><i class="fas fa-plus me-2"></i>Add Furniture</a>
                    </div>
                </div>

                <!-- Electronic -->
                <a class="collapse-item collapsed" href="#electronicCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="electronicCollapse">
                    Electronic
                </a>
                <div id="electronicCollapse" class="collapse" data-parent="#equipmentCollapse">
                    <div class="bg-white rounded px-3 py-2">
                        <a class="collapse-item" href="{{ route('electronic.index') }}"><i class="fas fa-list me-2"></i>Electronic</a>
                        <a class="collapse-item" href="{{ route('electronic.create') }}"><i class="fas fa-plus me-2"></i>Add Electronic</a>
                    </div>
                </div>

                <!-- Category -->
                <a class="collapse-item collapsed" href="#categoryCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="categoryCollapse">
                    Category Equipment
                </a>
                <div id="categoryCollapse" class="collapse" data-parent="#equipmentCollapse">
                    <div class="bg-white rounded px-3 py-2">
                        <a class="collapse-item" href="{{ route('backend.category.index') }}"><i class="fas fa-list me-2"></i>Category</a>
                        <a class="collapse-item" href="{{ route('backend.category.create') }}"><i class="fas fa-plus me-2"></i>Add Category</a>
                    </div>
                </div>

            </div>
        </div>
    </li>

    <!-- Maintenance -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#maintenanceCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="maintenanceCollapse">
            <i class="fas fa-wrench"></i>
            <span>Maintenance</span>
        </a>
        <div id="maintenanceCollapse" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-light rounded collapse-inner p-2">
                <a class="collapse-item" href="{{ route('maintenance.index') }}"><i class="fas fa-list me-2"></i>Maintenance</a>
                <a class="collapse-item" href="{{ route('maintenance.create') }}"><i class="fas fa-plus me-2"></i>Add Maintenance</a>
            </div>
        </div>
    </li>

    <!-- Feedback -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#fdkCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="fdkCollapse">
            <i class="fas fa-comment-dots"></i>
            <span>Feedback</span>
        </a>
        <div id="fdkCollapse" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-light rounded collapse-inner p-2">
                <a class="collapse-item" href="{{ route('backend.feedback.index') }}"><i class="fas fa-comments me-2"></i>Feedback</a>
                <a class="collapse-item" href="{{ route('backend.feedback.statistic') }}"><i class="fas fa-chart-bar me-2"></i>Statistic</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider border-light">

    <!-- General Settings -->
    <div class="sidebar-heading text-light px-3 small text-uppercase">
        General Settings
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
          <i class="fas fa-users"></i>
          <span>Users</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.facultyOffice.index') }}">
          <i class="fas fa-building"></i>
        <span>Faculty/Office</span>
      </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.department.index') }}">
          <i class="fas fa-building"></i>
        <span>Departiment</span>
      </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.course.index') }}">
          <i class="fas fa-building"></i>
        <span>Courses</span>
      </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('settings') }}">
          <i class="fas fa-cog"></i>
        <span>General Settings</span>
      </a>
    </li>

    <!-- Sidebar Toggler -->
    <div class="text-center my-3">
        <button class="btn btn-light btn-circle" id="sidebarToggle"><i class="fas fa-angle-double-left"></i></button>
    </div>
</ul>
<script>
  document.getElementById("sidebarToggle").addEventListener("click", function() {
    document.querySelector(".sidebar").classList.toggle("closed");
  });
</script>
