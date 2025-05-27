@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system')
@section('main-content')
<div class="container-fluid" style="font-family: 'Nunito', sans-serif;">
    @include('backend.layouts.notification')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

      <!-- Booking -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow-sm h-100 py-2 card-hover-primary">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Booking</div>
                <div class="h5 mb-0 font-weight-bold text-gray-900">{{ \App\Models\bookings::countActiveBooking() }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-book fa-2x text-primary" data-toggle="tooltip" data-placement="top" title="Active Bookings"></i>
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
                <i class="fas fa-chair fa-2x text-info" data-toggle="tooltip" data-placement="top" title="Active Furnitures"></i>
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

      <!-- Bar Chart for Total Bookings per Month -->
      <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow-sm">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Total Bookings per Month</h6>
          </div>
          <div class="card-body" style="min-height: 300px;">
            <canvas id="myBookingsChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Pie Chart -->
      <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow-sm">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-success text-white">
            <h6 class="m-0 font-weight-bold">Users</h6>
          </div>
          <div class="card-body" style="overflow:hidden; min-height:320px;">
            <div id="pie_chart" style="width:100%; height:100%; max-width:350px; margin: 0 auto;"></div>
          </div>
        </div>
      </div>

    </div>
</div>
@endsection

@push('styles')
<style>
  /* Card hover backgrounds with transparent shades */
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

  /* Tooltip overrides */
  [data-toggle="tooltip"] {
    cursor: pointer;
  }

  /* Responsive tweaks */
  @media (max-width: 576px) {
    h1.h3 {
      font-size: 1.5rem;
    }
  }
</style>
@endpush

@push('scripts')
<script src="http://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Enable Bootstrap tooltips --}}
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
</script>

{{-- Pie chart --}}
<script type="text/javascript">
  var analytics = <?php echo $users; ?>;

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
      var data = google.visualization.arrayToDataTable(analytics);
      var options = {
          title: 'Last 7 Days Registered Users',
          backgroundColor: 'transparent',
          legend: { position: 'right', textStyle: {color: '#333', fontSize: 14} },
          pieHole: 0.4,
          slices: {
            0: { color: '#1cc88a' },  // match success green
            1: { color: '#36b9cc' },
            2: { color: '#f6c23e' },
            3: { color: '#4e73df' }
          },
          chartArea: { left: 20, top: 30, width: '85%', height: '75%' }
      };
      var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
      chart.draw(data, options);
  }
</script>

{{-- Bar chart --}}
<script type="text/javascript">
  const url = "{{ route('bookings.getBookingsByMonth') }}";
  axios.get(url)
    .then(function(response) {
      const data = response.data;
      const months = data.map(item => item.month);
      const totalBookings = data.map(item => item.total_bookings);

      const monthColors = [
        'rgba(78, 115, 223, 0.6)',  // Blue
        'rgba(28, 200, 138, 0.6)',  // Green
        'rgba(54, 185, 204, 0.6)',  // Cyan
        'rgba(246, 194, 62, 0.6)',  // Yellow
        'rgba(231, 74, 59, 0.6)',   // Red
        'rgba(133, 135, 150, 0.6)', // Gray
        'rgba(253, 126, 20, 0.6)',  // Orange
        'rgba(111, 66, 193, 0.6)',  // Purple
        'rgba(32, 201, 151, 0.6)',  // Teal
        'rgba(255, 193, 7, 0.6)',   // Amber
        'rgba(102, 16, 242, 0.6)',  // Indigo
        'rgba(253, 94, 83, 0.6)'    // Coral
      ];

      const monthBorderColors = monthColors.map(c => c.replace('0.6', '1')); // full opacity border

      const ctx = document.getElementById('myBookingsChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: months,
          datasets: [{
            label: 'Total Bookings',
            data: totalBookings,
            backgroundColor: months.map((_, idx) => monthColors[idx % monthColors.length]),
            borderColor: months.map((_, idx) => monthBorderColors[idx % monthBorderColors.length]),
            borderWidth: 1,
            hoverBackgroundColor: months.map((_, idx) => monthColors[idx % monthColors.length].replace('0.6', '0.8')),
            hoverBorderColor: months.map((_, idx) => monthBorderColors[idx % monthBorderColors.length])
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              beginAtZero: true,
              grid: { display: false }
            },
            y: {
              beginAtZero: true,
              grid: { color: '#e3e6f0' }
            }
          },
          plugins: {
            legend: { display: false },
            tooltip: {
              enabled: true,
              mode: 'index',
              intersect: false
            }
          },
          interaction: {
            mode: 'nearest',
            intersect: false
          }
        }
      });
    })
    .catch(function(error) {
      console.error('Error loading bookings data:', error);
    });
</script>

@endpush
