<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center py-3" href="{{ route('admin') }}">
    <div class="sidebar-brand-icon">
      <i class="fas fa-building"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Admin</div>
  </a>

  <hr class="sidebar-divider my-0 border-light">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{ route('admin') }}">
      <i class="fas fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider border-light">

  <!-- Heading -->
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

  <!-- Heading -->
  <div class="sidebar-heading text-light px-3 small text-uppercase">
    LibraRoom
  </div>

  <!-- Schedule Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#scheduleCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="scheduleCollapse">
      <i class="fas fa-calendar-alt"></i>
      <span>Schedule</span>
    </a>
    <div id="scheduleCollapse" class="collapse" data-parent="#accordionSidebar">
      <div class="bg-light rounded collapse-inner p-2">
        <h6 class="collapse-header text-primary small">Schedule Options:</h6>
        <a class="collapse-item d-block py-1" href="{{ route('schedule.index') }}">Schedule</a>
        <a class="collapse-item d-block py-1" href="{{ route('schedule.create') }}">Add Schedule</a>
        <a class="collapse-item d-block py-1" href="{{ route('show.calendar.admin') }}">Calendar</a>
      </div>
    </div>
  </li>

  <!-- Booking Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#bookingCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="bookingCollapse">
      <i class="fas fa-book"></i>
      <span>Booking</span>
    </a>
    <div id="bookingCollapse" class="collapse" data-parent="#accordionSidebar">
      <div class="bg-light rounded collapse-inner p-2">
        <h6 class="collapse-header text-primary small">Booking Options:</h6>
        <a class="collapse-item d-block py-1" href="{{ route('bookings.index') }}">Booking</a>
        <a class="collapse-item d-block py-1" href="{{ route('bookings.create') }}">Add Booking</a>
      </div>
    </div>
  </li>

  <!-- Room Menu -->
    <li class="nav-item">
    <a class="nav-link collapsed" href="#roomCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="roomCollapse">
      <i class="fas fa-door-closed"></i>
      <span>Room</span>
    </a>
    <div id="roomCollapse" class="collapse" data-parent="#accordionSidebar">
      <div class="bg-light rounded collapse-inner p-2">

        <!-- Furniture -->
        <a class="collapse-item collapsed" href="#roomCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="roomCollapse">
          Room
        </a>
        <div id="roomCollapse" class="collapse" data-parent="#roomCollapse">
          <div class="bg-white rounded px-3 py-2">
            <a class="collapse-item d-block py-1" href="{{ route('room.index') }}">View Room</a>
            <a class="collapse-item d-block py-1" href="{{ route('room.create') }}">Add Room</a>
          </div>
        </div>

        <!-- Electronic -->
        <a class="collapse-item collapsed" href="#typeCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="typeCollapse">
          Type Room
        </a>
        <div id="typeCollapse" class="collapse" data-parent="#typeCollapse">
          <div class="bg-white rounded px-3 py-2">
            <a class="collapse-item d-block py-1" href="{{ route('backend.type_room.index') }}">View Type Room</a>
            <a class="collapse-item d-block py-1" href="{{ route('backend.type_room.create') }}">Add Type Room</a>
          </div>
        </div>

      </div>
    </div>
  </li>
  <!-- Equipment Menu -->
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
            <a class="collapse-item d-block py-1" href="{{ route('furniture.index') }}">View Furniture</a>
            <a class="collapse-item d-block py-1" href="{{ route('furniture.create') }}">Add Furniture</a>
          </div>
        </div>

        <!-- Electronic -->
        <a class="collapse-item collapsed" href="#electronicCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="electronicCollapse">
          Electronic
        </a>
        <div id="electronicCollapse" class="collapse" data-parent="#equipmentCollapse">
          <div class="bg-white rounded px-3 py-2">
            <a class="collapse-item d-block py-1" href="{{ route('electronic.index') }}">View Electronic</a>
            <a class="collapse-item d-block py-1" href="{{ route('electronic.create') }}">Add Electronic</a>
          </div>
        </div>
        <!-- Category Equipment -->
        <a class="collapse-item collapsed" href="#categoryCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="categoryCollapse">
          category Equipment
        </a>
        <div id="categoryCollapse" class="collapse" data-parent="#categoryCollapse">
          <div class="bg-white rounded px-3 py-2">
            <a class="collapse-item d-block py-1" href="{{ route('backend.category.index') }}">View category</a>
            <a class="collapse-item d-block py-1" href="{{ route('backend.category.create') }}">Add category</a>
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
        <h6 class="collapse-header text-primary small">Maintenance Options:</h6>
        <a class="collapse-item d-block py-1" href="{{ route('maintenance.index') }}">Maintenance</a>
        <a class="collapse-item d-block py-1" href="{{ route('maintenance.create') }}">Add Maintenance</a>
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
        <h6 class="collapse-header text-primary small">Feedback Options:</h6>
        <a class="collapse-item d-block py-1" href="{{ route('backend.feedback.index') }}">Feedback</a>
        <a class="collapse-item d-block py-1" href="{{ route('backend.feedback.statistic') }}">Statistic</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider border-light d-none d-md-block">

  <!-- General Settings Heading -->
  <div class="sidebar-heading text-light px-3 small text-uppercase">
    General Settings
  </div>

  <!-- Users -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('users.index') }}">
      <i class="fas fa-users"></i>
      <span>Users</span>
    </a>
  </li>
   <!-- Department -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('settings') }}">
      <i class="fas fa-building"></i>
      <span>Department</span>
    </a>
  </li>
  <!-- Settings -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('settings') }}">
      <i class="fas fa-cog"></i>
      <span>Settings</span>
    </a>
  </li>


  <!-- Sidebar Toggler -->
  <div class="text-center d-none d-md-inline my-3">
    <button class="btn btn-light btn-circle" id="sidebarToggle"><i class="fas fa-angle-double-left"></i></button>
  </div>

</ul>
