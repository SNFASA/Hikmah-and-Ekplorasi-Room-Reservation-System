<!-- resources/views/layouts/sidebar.blade.php -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar" style=" left: 0; top: 0;">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-3" href="{{ route('ppp.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-building"></i>
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

    <hr class="sidebar-divider border-light">
    <!-- PTTA -->
    <div class="sidebar-heading text-light px-3 small text-uppercase">
        PTTA
    </div>
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
                        <a class="collapse-item" href="{{ route('ppp.room.index') }}"><i class="fas fa-list me-2"></i>Room</a>
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
                        <a class="collapse-item" href="{{ route('ppp.furniture.index') }}"><i class="fas fa-list me-2"></i>Furniture</a>
                        <a class="collapse-item" href="{{ route('ppp.furniture.create') }}"><i class="fas fa-plus me-2"></i>Add Furniture</a>
                    </div>
                </div>

                <!-- Electronic -->
                <a class="collapse-item collapsed" href="#electronicCollapse" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="electronicCollapse">
                    Electronic
                </a>
                <div id="electronicCollapse" class="collapse" data-parent="#equipmentCollapse">
                    <div class="bg-white rounded px-3 py-2">
                        <a class="collapse-item" href="{{ route('ppp.electronic.index') }}"><i class="fas fa-list me-2"></i>Electronic</a>
                        <a class="collapse-item" href="{{ route('ppp.electronic.create') }}"><i class="fas fa-plus me-2"></i>Add Electronic</a>
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
                <a class="collapse-item" href="{{ route('ppp.maintenance.index') }}"><i class="fas fa-list me-2"></i>Maintenance</a>
                <a class="collapse-item" href="{{ route('ppp.maintenance.create') }}"><i class="fas fa-plus me-2"></i>Add Maintenance</a>
            </div>
        </div>
    </li>    <!-- Sidebar Toggler -->
    <div class="text-center my-3">
        <button class="btn btn-light btn-circle" id="sidebarToggle"><i class="fas fa-angle-double-left"></i></button>
    </div>
</ul>
<script>
  document.getElementById("sidebarToggle").addEventListener("click", function() {
    document.querySelector(".sidebar").classList.toggle("closed");
  });
</script>
