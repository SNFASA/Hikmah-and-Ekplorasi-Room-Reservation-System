<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center py-3" href="{{ route('ppp.dashboard') }}">
    <div class="sidebar-brand-icon">
      <i class="fas fa-tools"></i>
    </div>
    <div class="sidebar-brand-text mx-3">PPP</div>
  </a>

  <hr class="sidebar-divider my-0 border-light">

  <!-- Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{ route('ppp.dashboard') }}">
      <i class="fas fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- Heading -->
  <div class="sidebar-heading text-light px-3 small text-uppercase">
    LibraRoom
  </div>
  <!-- Room -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#roomCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="roomCollapse">
      <i class="fas fa-door-closed"></i>
      <span>Room</span>
    </a>
    <div id="roomCollapse" class="collapse" data-parent="#accordionSidebar">
      <div class="bg-light rounded collapse-inner p-2">
        <h6 class="collapse-header text-primary small">Room Options:</h6>
        <a class="collapse-item d-block py-1" href="{{ route('ppp.room.index') }}">Room</a>
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
            <a class="collapse-item d-block py-1" href="{{ route('ppp.furniture.index') }}">View Furniture</a>
            <a class="collapse-item d-block py-1" href="{{ route('ppp.furniture.create') }}">Add Furniture</a>
          </div>
        </div>

        <!-- Electronic -->
        <a class="collapse-item collapsed" href="#electronicCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="electronicCollapse">
          Electronic
        </a>
        <div id="electronicCollapse" class="collapse" data-parent="#equipmentCollapse">
          <div class="bg-white rounded px-3 py-2">
            <a class="collapse-item d-block py-1" href="{{ route('ppp.electronic.index') }}">View Electronic</a>
            <a class="collapse-item d-block py-1" href="{{ route('ppp.electronic.create') }}">Add Electronic</a>
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
        <a class="collapse-item d-block py-1" href="{{ route('ppp.maintenance.index') }}">Maintenance</a>
        <a class="collapse-item d-block py-1" href="{{ route('ppp.maintenance.create') }}">Add Maintenance</a>
      </div>
    </div>
  </li>

  <!-- Sidebar Toggler -->
  <div class="text-center d-none d-md-inline my-3">
    <button class="btn btn-light btn-circle" id="sidebarToggle"><i class="fas fa-angle-double-left"></i></button>
  </div>

</ul>
