<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <div class="sidebar-brand-icon ">
        <i class="fas fa-building"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Media
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('file-manager')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Media Manager</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            LibraRoom
        </div>
    <!-- Schedule -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#scheduleCollapse" aria-expanded="true" aria-controls="scheduleCollapse">
        <i class="fas fa-calendar"></i>
        <span>Schedule</span>
      </a>
      <div id="scheduleCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Schedule Options:</h6>
          <a class="collapse-item" href="{{route('schedule.index')}}">Schedule</a>
          <a class="collapse-item" href="{{route('schedule.create')}}">Add schedule</a>
          <a class="collapse-item" href="{{ route('show.calendar.admin') }}">Calendar</a>
        </div>
      </div>
  </li>
    <!-- Booking -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bookingCollapse" aria-expanded="true" aria-controls="bookingCollapse">
          <i class="fas fa-book"></i>
          <span>Booking</span>
        </a>
        <div id="bookingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Booking Options:</h6>
            <a class="collapse-item" href="{{route('bookings.index')}}">Booking</a>
            <a class="collapse-item" href="{{route('bookings.create')}}">Add Booking</a>
          </div>
        </div>
    </li>
    {{-- Room --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#roomCollapse" aria-expanded="true" aria-controls="roomCollapse">
          <i class="fas fa-door-closed fa-2x"></i>
          <span>Room</span>
        </a>
        <div id="roomCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Room Options:</h6>
            <a class="collapse-item" href="{{route('room.index')}}">Room</a>
            <a class="collapse-item" href="{{route('room.create')}}">Add Room</a>
          </div>
        </div>
    </li>

    {{-- Equipment --}}
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#equipmentCollapse" aria-expanded="true" aria-controls="equipmentCollapse">
          <i class="fas fa-tools"></i>
          <span>Equipment</span>
      </a>
      <div id="equipmentCollapse" class="collapse" aria-labelledby="headingEquipment" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item collapsed" href="#" data-toggle="collapse" data-target="#furnitureCollapse" aria-expanded="false" aria-controls="furnitureCollapse">
                  Furniture
              </a>
              <div id="furnitureCollapse" class="collapse" aria-labelledby="headingFurniture" data-parent="#equipmentCollapse">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="{{ route('furniture.index') }}">View Furniture</a>
                      <a class="collapse-item" href="{{ route('furniture.create') }}">Add Furniture</a>
                  </div>
              </div>
              <a class="collapse-item collapsed" href="#" data-toggle="collapse" data-target="#electronicCollapse" aria-expanded="false" aria-controls="electronicCollapse">
                  Electronic
              </a>
              <div id="electronicCollapse" class="collapse" aria-labelledby="headingElectronic" data-parent="#equipmentCollapse">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="{{ route('electronic.index') }}">View Electronic</a>
                      <a class="collapse-item" href="{{ route('electronic.create') }}">Add Electronic</a>
                  </div>
              </div>
          </div>
      </div>
  </li>
  <!--Maintenance-->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#maintenanceCollapse" aria-expanded="true" aria-controls="maintenanceCollapse">
      <i class="fas fa-wrench"></i>
      <span>Maintenance</span>
    </a>
    <div id="maintenanceCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Maintenance Options:</h6>
        <a class="collapse-item" href="{{route('maintenance.index')}}">Maintenance</a>
        <a class="collapse-item" href="{{route('maintenance.create')}}">Add Maintenance</a>
      </div>
    </div>
  </li>
  <!--Feedback-->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#fdkCollapse" aria-expanded="true" aria-controls="fdkCollapse">
      <i class="fas fa-comment-dots"></i>
      <span>Feedback</span>
    </a>
    <div id="fdkCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Feedback Options:</h6>
        <a class="collapse-item" href="{{route('backend.feedback.index')}}">Feedback</a>
        <a class="collapse-item" href="{{route('backend.feedback.statistic')}}">Statistic</a>
      </div>
    </div>
  </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
     <!-- Heading -->
    <div class="sidebar-heading">
        General Settings
    </div>
     <!-- Users -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('users.index')}}">
            <i class="fas fa-users"></i>
            <span>Users</span></a>
    </li>
     <!-- General settings -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('settings')}}">
            <i class="fas fa-cog"></i>
            <span>Settings</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>