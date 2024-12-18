@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system')
@section('main-content')
<div class="container-fluid">
    @include('backend.layouts.notification')
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
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Booking</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\bookings::countActiveBooking()}}</div>
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
    <div class="row">

    <!-- Bar Chart for Total Bookings per Month -->
    <div class="col-xl-8 col-lg-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Total Bookings per Month</h6>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="myBookingsChart"></canvas>
          </div>
        </div>
      </div>
    </div>
      <!-- Pie Chart -->
      <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body" style="overflow:hidden">
            <div id="pie_chart" style="width:350px; height:320px;">
          </div>
        </div>
      </div>
    </div>
    <!-- Content Row -->
    
  </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{-- pie chart --}}
<script type="text/javascript">
  var analytics = <?php echo $users; ?>

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart()
  {
      var data = google.visualization.arrayToDataTable(analytics);
      var options = {
          title : 'Last 7 Days registered user'
      };
      var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
      chart.draw(data, options);
  }
</script>
  {{-- line chart --}}
  <script type="text/javascript">
  // Fetch the total bookings data
  const url = "{{ route('bookings.getBookingsByMonth') }}";
  axios.get(url)
    .then(function(response) {
      const data = response.data;

      // Prepare data for the bar chart
      const months = data.map(item => item.month);
      const totalBookings = data.map(item => item.total_bookings);

      // Create the bar chart
      var ctx = document.getElementById('myBookingsChart');
      var myBookingsChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: months,
          datasets: [{
            label: 'Total Bookings',
            data: totalBookings,
            backgroundColor: "rgba(78, 115, 223, 0.5)",
            borderColor: "rgba(78, 115, 223, 1)",
            borderWidth: 1
          }]
        },
        options: {
          maintainAspectRatio: false,
          scales: {
            x: {
              beginAtZero: true
            },
            y: {
              beginAtZero: true
            }
          },
          responsive: true
        }
      });
    })
    .catch(function(error) {
      console.log(error);
    });
</script>
@endpush