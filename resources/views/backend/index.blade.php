@extends('backend.layouts.master')
@section('title','PTTA Reservation system')
@section('main-content')
<div class="container-fluid" style="font-family: 'Inter', 'Nunito', sans-serif; background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%); min-height: 100vh;">
    @include('backend.layouts.notification')

    <!-- Page Heading with Gradient Background -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card p-4 rounded shadow-sm position-relative overflow-hidden">
                <div class="welcome-overlay"></div>
                <div class="position-relative">
                    <h1 class="h2 mb-2 text-white font-weight-bold">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Overview
                    </h1>
                    <p class="text-white-50 mb-0">Welcome back! Here's what's happening with your PTTA system today.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row">
        <!-- Booking Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card card h-100 shadow-sm border-0 card-hover-primary">
                <div class="card-body p-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="stats-label text-primary text-uppercase mb-2">Active Bookings</div>
                            <div class="stats-number h4 mb-0 font-weight-bold text-dark">
                                {{ \App\Models\bookings::countActiveBooking() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon bg-primary">
                                <i class="fas fa-book text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Electronic Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card card h-100 shadow-sm border-0 card-hover-success">
                <div class="card-body p-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="stats-label text-success text-uppercase mb-2">Electronics</div>
                            <div class="stats-number h4 mb-0 font-weight-bold text-dark">
                                {{ \App\Models\electronic::countActiveElectronic() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon bg-success">
                                <i class="fas fa-desktop text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Furniture Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card card h-100 shadow-sm border-0 card-hover-info">
                <div class="card-body p-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="stats-label text-info text-uppercase mb-2">Furniture</div>
                            <div class="stats-number h4 mb-0 font-weight-bold text-dark">
                                {{ \App\Models\furniture::countActiveFurniture() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon bg-info">
                                <i class="fas fa-chair text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card card h-100 shadow-sm border-0 card-hover-warning">
                <div class="card-body p-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="stats-label text-warning text-uppercase mb-2">Available Rooms</div>
                            <div class="stats-number h4 mb-0 font-weight-bold text-dark">
                                {{ \App\Models\room::countActiveRoom() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stats-icon bg-warning">
                                <i class="fas fa-door-closed text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Bar Chart for Total Bookings per Month -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow-sm border-0 chart-card">
                <div class="card-header bg-gradient-primary text-white border-0 py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-chart-bar me-2"></i>Monthly Booking Analytics
                            </h6>
                            <small class="text-white-50">Track your booking trends over time</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4" style="min-height: 350px;">
                    <canvas id="myBookingsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Enhanced Pie Chart -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow-sm border-0 chart-card">
                <div class="card-header bg-gradient-success text-white border-0 py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-users me-2"></i>User Analytics
                            </h6>
                            <small class="text-white-50">Recent user registrations</small>
                        </div>
                        <span class="badge badge-light">7 Days</span>
                    </div>
                </div>
                <div class="card-body p-4" style="min-height: 370px;">
                    <div id="pie_chart" style="width:100%; height:100%; max-width:350px; margin: 0 auto;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-info text-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-clock me-2"></i>Recent System Activity
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">Activity</th>
                                    <th class="border-0 py-3">Type</th>
                                    <th class="border-0 py-3">User</th>
                                    <th class="border-0 py-3">Time</th>
                                    <th class="border-0 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities ?? [] as $activity)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <i class="{{ $activity->icon }} text-primary me-2"></i>
                                            {{ $activity->description }}
                                        </td>
                                        <td>{!! $activity->type_badge !!}</td>
                                        <td>{{ $activity->user_name }}</td>
                                        <td class="text-muted">{{ $activity->time_ago }}</td>
                                        <td>{!! $activity->status_badge !!}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fas fa-info-circle me-2"></i>
                                            No recent activities found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Enable Bootstrap tooltips --}}
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
</script>

{{-- Enhanced Pie chart --}}
<script type="text/javascript">
  var analytics = <?php echo $users; ?>;

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
      var data = google.visualization.arrayToDataTable(analytics);
      var options = {
          title: 'User Registration Trends',
          titleTextStyle: {
            color: '#5a5c69',
            fontSize: 16,
            fontName: 'Inter'
          },
          backgroundColor: 'transparent',
          legend: {
            position: 'bottom',
            textStyle: {color: '#5a5c69', fontSize: 12, fontName: 'Inter'}
          },
          pieHole: 0.5,
          pieSliceText: 'percentage',
          slices: {
            0: { color: '#1cc88a' },
            1: { color: '#36b9cc' },
            2: { color: '#f6c23e' },
            3: { color: '#4e73df' },
            4: { color: '#e74a3b' }
          },
          chartArea: {
            left: 20,
            top: 40,
            width: '85%',
            height: '70%'
          },
          pieSliceTextStyle: {
            color: 'white',
            fontSize: 12,
            fontName: 'Inter'
          },
          tooltip: {
            textStyle: {
              fontName: 'Inter'
            }
          }
      };
      var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
      chart.draw(data, options);
  }
</script>

{{-- Enhanced Bar chart --}}
<script type="text/javascript">
  const url = "{{ route('bookings.getBookingsByMonth') }}";
  axios.get(url)
    .then(function(response) {
      const data = response.data;
      const months = data.map(item => item.month);
      const totalBookings = data.map(item => item.total_bookings);

      const gradientColors = [
        {bg: 'rgba(78, 115, 223, 0.8)', border: '#4e73df'},
        {bg: 'rgba(28, 200, 138, 0.8)', border: '#1cc88a'},
        {bg: 'rgba(54, 185, 204, 0.8)', border: '#36b9cc'},
        {bg: 'rgba(246, 194, 62, 0.8)', border: '#f6c23e'},
        {bg: 'rgba(231, 74, 59, 0.8)', border: '#e74a3b'},
        {bg: 'rgba(133, 135, 150, 0.8)', border: '#858796'},
        {bg: 'rgba(253, 126, 20, 0.8)', border: '#fd7e14'},
        {bg: 'rgba(111, 66, 193, 0.8)', border: '#6f42c1'},
        {bg: 'rgba(32, 201, 151, 0.8)', border: '#20c997'},
        {bg: 'rgba(255, 193, 7, 0.8)', border: '#ffc107'},
        {bg: 'rgba(102, 16, 242, 0.8)', border: '#6610f2'},
        {bg: 'rgba(253, 94, 83, 0.8)', border: '#fd5e53'}
      ];

      const ctx = document.getElementById('myBookingsChart').getContext('2d');
      
      // Create gradient for each bar
      const backgroundColors = months.map((_, idx) => {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        const color = gradientColors[idx % gradientColors.length];
        gradient.addColorStop(0, color.bg);
        gradient.addColorStop(1, color.bg.replace('0.8', '0.4'));
        return gradient;
      });

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: months,
          datasets: [{
            label: 'Total Bookings',
            data: totalBookings,
            backgroundColor: backgroundColors,
            borderColor: months.map((_, idx) => gradientColors[idx % gradientColors.length].border),
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
            hoverBackgroundColor: months.map((_, idx) => gradientColors[idx % gradientColors.length].bg),
            hoverBorderColor: months.map((_, idx) => gradientColors[idx % gradientColors.length].border),
            hoverBorderWidth: 3
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            intersect: false,
            mode: 'index'
          },
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              backgroundColor: 'rgba(0,0,0,0.8)',
              titleColor: 'white',
              bodyColor: 'white',
              borderColor: 'rgba(255,255,255,0.1)',
              borderWidth: 1,
              cornerRadius: 8,
              displayColors: false,
              titleFont: {
                family: 'Inter',
                size: 14
              },
              bodyFont: {
                family: 'Inter',
                size: 13
              }
            }
          },
          scales: {
            x: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  family: 'Inter',
                  size: 12
                },
                color: '#858796'
              }
            },
            y: {
              beginAtZero: true,
              grid: {
                color: 'rgba(133, 135, 150, 0.1)',
                drawBorder: false
              },
              ticks: {
                font: {
                  family: 'Inter',
                  size: 12
                },
                color: '#858796',
                callback: function(value) {
                  return value.toLocaleString();
                }
              }
            }
          },
          animation: {
            duration: 1000,
            easing: 'easeInOutQuart'
          }
        }
      });
    })
    .catch(function(error) {
      console.error('Error loading bookings data:', error);
      // Show error message in chart area
      document.getElementById('myBookingsChart').style.display = 'none';
      const chartContainer = document.getElementById('myBookingsChart').parentElement;
      chartContainer.innerHTML = '<div class="text-center text-muted p-4"><i class="fas fa-exclamation-triangle fa-3x mb-3"></i><br>Error loading chart data</div>';
    });
</script>

{{-- Add some interactive animations --}}
<script>
$(document).ready(function() {
    // Add loading animation
    $('.stats-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
    
    // Counter animation for stats numbers
    $('.stats-number').each(function() {
        const $this = $(this);
        const countTo = parseInt($this.text());
        
        $({ countNum: 0 }).animate({
            countNum: countTo
        }, {
            duration: 2000,
            easing: 'swing',
            step: function() {
                $this.text(Math.floor(this.countNum));
            },
            complete: function() {
                $this.text(countTo);
            }
        });
    });
});
</script>

@endpush