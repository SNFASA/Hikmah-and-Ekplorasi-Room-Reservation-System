@extends('ppp.layouts.master')
@section('title','LibraRoom Reservation system')
@section('main-content')
<div class="container-fluid">
    @include('ppp.layouts.notification')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

      <!-- Category -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Maintenance</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\maintenance::countActiveMaintenance()}}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-book fa-2x "></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Products -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Electronic</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\electronic::countActiveElectronic()}}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-desktop fa-2x text-gray-800"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Furniture</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{\App\Models\furniture::countActiveFurniture()}}</div>
                  </div>
                  
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-chair fa-2x "></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--Posts-->
      <!---
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Room</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\room::countActiveRoom()}}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-door-closed fa-2x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">-->

    <!-- Bar Chart for Total Bookings per Month -->
    <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Report</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body" style="overflow:hidden">
          <div id="maintenance_pie_chart" style="width:350px; height:320px;"></div>
        </div>
      </div>
    </div>
      <!-- Pie Chart -->
      <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Furniture</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body" style="overflow:hidden">
            <div id="furniture_pie_chart" style="width:350px; height:320px;"></div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Electronic Equipment</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body" style="overflow:hidden">
            <div id="electronic_pie_chart" style="width:350px; height:320px;"></div>
          </div>
        </div>
      </div>
    <div class="card-body" style="overflow:hidden">
    </div>
    <!-- Content Row -->
    
  </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{-- pie chart --}}
<script type="text/javascript">
  // Load the Google Charts library
  google.charts.load('current', {'packages':['corechart']});

  // Draw Furniture Pie Chart
  google.charts.setOnLoadCallback(drawFurnitureChart);
  function drawFurnitureChart() {
      var furnitureData = <?php echo json_encode($furniture); ?>;
      var data = google.visualization.arrayToDataTable([
          ['Category', 'Count'],
          ...furnitureData.map(item => [item.category, item.count])
      ]);
      var options = {
          title: 'Furniture by Category',
          pieHole: 0.4,
          is3D: false
      };
      var chart = new google.visualization.PieChart(document.getElementById('furniture_pie_chart'));
      chart.draw(data, options);
  }

  // Draw Electronic Equipment Pie Chart
  google.charts.setOnLoadCallback(drawElectronicChart);
  function drawElectronicChart() {
      var electronicData = <?php echo json_encode($electronic); ?>;
      var data = google.visualization.arrayToDataTable([
          ['Category', 'Count'],
          ...electronicData.map(item => [item.category, item.count])
      ]);
      var options = {
          title: 'Electronic Equipment by Category',
          pieHole: 0.4,
          is3D: false
      };
      var chart = new google.visualization.PieChart(document.getElementById('electronic_pie_chart'));
      chart.draw(data, options);
  }

  // Draw Maintenance Pie Chart
  google.charts.setOnLoadCallback(drawMaintenanceChart);
  function drawMaintenanceChart() {
      var maintenanceData = <?php echo json_encode($maintenance); ?>;
      var data = google.visualization.arrayToDataTable([
          ['Status', 'Count'],
          ...maintenanceData.map(item => [item.status, item.count])
      ]);
      var options = {
          title: 'Maintenance by Status',
          pieHole: 0.4,
          is3D: false
      };
      var chart = new google.visualization.PieChart(document.getElementById('maintenance_pie_chart'));
      chart.draw(data, options);
  }
</script>


@endpush