@extends('ppp.layouts.master')
@section('title','LibraRoom Reservation system')
@section('main-content')
<div class="container-fluid" style="font-family: 'Nunito', sans-serif;">
    @include('ppp.layouts.notification')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Maintenance -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2 card-hover-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Maintenance</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-900">{{ \App\Models\maintenance::countActiveMaintenance() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-primary" data-toggle="tooltip" data-placement="top" title="Active Maintenance"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Electronic -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2 card-hover-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Electronic</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-900">{{ \App\Models\electronic::countActiveElectronic() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-desktop fa-2x text-success" data-toggle="tooltip" data-placement="top" title="Active Electronics"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Furniture -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100 py-2 card-hover-info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Furniture</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-900">{{ \App\Models\furniture::countActiveFurniture() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chair fa-2x text-info" data-toggle="tooltip" data-placement="top" title="Active Furniture"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2 card-hover-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Room</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-900">{{ \App\Models\room::countActiveRoom() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-door-closed fa-2x text-warning" data-toggle="tooltip" data-placement="top" title="Active Rooms"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <!-- Maintenance Pie Chart -->
      <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Report</h6>
          </div>
          <div class="card-body" style="overflow:hidden">
            <div id="maintenance_pie_chart" style="width:100%; height:320px;"></div>
          </div>
        </div>
      </div>

      <!-- Furniture Pie Chart -->
      <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Furniture</h6>
          </div>
          <div class="card-body" style="overflow:hidden">
            <div id="furniture_pie_chart" style="width:100%; height:320px;"></div>
          </div>
        </div>
      </div>

      <!-- Electronic Equipment Pie Chart -->
      <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
        <div class="card shadow h-100">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Electronic Equipment</h6>
          </div>
          <div class="card-body" style="overflow:hidden">
            <div id="electronic_pie_chart" style="width:100%; height:320px;"></div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('styles')
<style>
  .card-hover-primary:hover {
    background-color: rgba(78, 115, 223, 0.1);
    box-shadow: 0 0 15px rgba(78, 115, 223, 0.3);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }
  .card-hover-success:hover {
    background-color: rgba(28, 200, 138, 0.1);
    box-shadow: 0 0 15px rgba(28, 200, 138, 0.3);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }
  .card-hover-info:hover {
    background-color: rgba(54, 185, 204, 0.1);
    box-shadow: 0 0 15px rgba(54, 185, 204, 0.3);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }
  .card-hover-warning:hover {
    background-color: rgba(246, 194, 62, 0.15);
    box-shadow: 0 0 15px rgba(246, 194, 62, 0.3);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }
  [data-toggle="tooltip"] {
    cursor: pointer;
  }
  @media (max-width: 576px) {
    h1.h3 {
      font-size: 1.5rem;
    }
  }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});

  // Furniture
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
          is3D: false,
          chartArea: { width: '90%', height: '80%' }
      };
      var chart = new google.visualization.PieChart(document.getElementById('furniture_pie_chart'));
      chart.draw(data, options);
  }

  // Electronics
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
          is3D: false,
          chartArea: { width: '90%', height: '80%' }
      };
      var chart = new google.visualization.PieChart(document.getElementById('electronic_pie_chart'));
      chart.draw(data, options);
  }

  // Maintenance
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
          is3D: false,
          chartArea: { width: '90%', height: '80%' }
      };
      var chart = new google.visualization.PieChart(document.getElementById('maintenance_pie_chart'));
      chart.draw(data, options);
  }
</script>
@endpush

