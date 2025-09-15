@extends('ppp.layouts.master')
@section('title','PTTA Reservation system')
@section('main-content')
<div class="container-fluid" style="font-family: 'Inter', 'Nunito', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    @include('ppp.layouts.notification')

    <!-- Page Heading with Welcome Message -->
    <div class="welcome-section mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-content">
                    <h1 class="dashboard-title mb-2">
                        <i class="fas fa-tachometer-alt text-white me-3"></i>
                        PTTA Dashboard
                    </h1>
                    <p class="dashboard-subtitle text-white mb-0">
                        Welcome back! Here's what's happening with your facility management today.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="dashboard-time">
                    <span class="current-time text-white" id="current-time"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="row mb-5">
        <!-- Maintenance Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card card-maintenance">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Active Maintenance</div>
                        <div class="stats-number h4 mb-0 font-weight-bold text-dark">
                            {{ \App\Models\maintenance::countActiveMaintenance() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Electronic Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card card-electronic">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Electronic Equipment</div>
                        <div class="stats-number h4 mb-0 font-weight-bold text-dark">
                            {{ \App\Models\electronic::countActiveElectronic() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Furniture Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card card-furniture">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="fas fa-chair"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Furniture Items</div>
                        <div class="stats-number h4 mb-0 font-weight-bold text-dark">
                            {{ \App\Models\furniture::countActiveFurniture() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card card-room">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Available Rooms</div>
                        <div class="stats-number h4 mb-0 font-weight-bold text-dark">
                            {{ \App\Models\room::countActiveRoom() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Charts Section -->
    <div class="row">
        <!-- Maintenance Report Chart -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Maintenance Report
                    </div>
                </div>
                <div class="chart-body">
                    <div id="maintenance_pie_chart" class="chart-container"></div>
                </div>
            </div>
        </div>

        <!-- Furniture Chart -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">
                        <i class="fas fa-chart-pie text-success me-2"></i>
                        Furniture Distribution
                    </div>
                </div>
                <div class="chart-body">
                    <div id="furniture_pie_chart" class="chart-container"></div>
                </div>
            </div>
        </div>

        <!-- Electronic Equipment Chart -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">
                        <i class="fas fa-chart-pie text-info me-2"></i>
                        Electronic Equipment
                    </div>
                </div>
                <div class="chart-body">
                    <div id="electronic_pie_chart" class="chart-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize tooltips and time
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        updateTime();
        setInterval(updateTime, 1000);
        
        // Initialize mini charts
        initializeMiniCharts();
    });

    // Update current time
    function updateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        document.getElementById('current-time').textContent = now.toLocaleDateString('en-US', options);
    }

    // Initialize mini sparkline charts
    function initializeMiniCharts() {
        const miniChartOptions = {
            type: 'line',
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { display: false },
                    y: { display: false }
                },
                elements: {
                    point: { radius: 0 },
                    line: { borderWidth: 2 }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        };

        // Sample data for mini charts
        const sampleData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                data: [12, 19, 13, 15, 22, 18],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                fill: true
            }]
        };

        // Initialize charts for each stat card
        ['maintenance', 'electronic', 'furniture', 'room'].forEach(type => {
            const ctx = document.getElementById(`${type}-mini-chart`);
            if (ctx) {
                new Chart(ctx, {
                    ...miniChartOptions,
                    data: {
                        ...sampleData,
                        datasets: [{
                            ...sampleData.datasets[0],
                            borderColor: getColorByType(type),
                            backgroundColor: getColorByType(type, 0.1)
                        }]
                    }
                });
            }
        });
    }

    function getColorByType(type, alpha = 1) {
        const colors = {
            maintenance: `rgba(102, 126, 234, ${alpha})`,
            electronic: `rgba(6, 214, 160, ${alpha})`,
            furniture: `rgba(247, 37, 133, ${alpha})`,
            room: `rgba(247, 127, 0, ${alpha})`
        };
        return colors[type] || `rgba(102, 126, 234, ${alpha})`;
    }

    // Enhanced Google Charts
    google.charts.load('current', {'packages':['corechart']});

    // Enhanced chart options
    const enhancedChartOptions = {
        pieHole: 0.6,
        is3D: false,
        chartArea: {
            width: '90%',
            height: '80%',
            top: 20,
            left: 20,
            right: 20,
            bottom: 20
        },
        backgroundColor: 'transparent',
        legend: {
            position: 'bottom',
            alignment: 'center',
            textStyle: {
                fontSize: 12,
                color: '#6C757D'
            }
        },
        colors: ['#667eea', '#06D6A0', '#F72585', '#F77F00', '#7209b7', '#FF6B6B'],
        titleTextStyle: {
            fontSize: 16,
            fontName: 'Inter',
            color: '#2C3E50'
        },
        animation: {
            startup: true,
            easing: 'inAndOut',
            duration: 1000
        }
    };

    // Furniture Chart
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
            chartArea: { width: '90%', height: '80%' },
            backgroundColor: 'transparent',
            legend: {
                position: 'bottom',
                alignment: 'center',
                textStyle: {
                    fontSize: 12,
                    color: '#6C757D'
                }
            },
            colors: ['#667eea', '#06D6A0', '#F72585', '#F77F00', '#7209b7', '#FF6B6B'],
            titleTextStyle: {
                fontSize: 16,
                fontName: 'Inter',
                color: '#2C3E50'
            },
            animation: {
                startup: true,
                easing: 'inAndOut',
                duration: 1000
            }
        };
        var chart = new google.visualization.PieChart(document.getElementById('furniture_pie_chart'));
        chart.draw(data, options);
    }

    // Electronics Chart
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
            chartArea: { width: '90%', height: '80%' },
            backgroundColor: 'transparent',
            legend: {
                position: 'bottom',
                alignment: 'center',
                textStyle: {
                    fontSize: 12,
                    color: '#6C757D'
                }
            },
            colors: ['#667eea', '#06D6A0', '#F72585', '#F77F00', '#7209b7', '#FF6B6B'],
            titleTextStyle: {
                fontSize: 16,
                fontName: 'Inter',
                color: '#2C3E50'
            },
            animation: {
                startup: true,
                easing: 'inAndOut',
                duration: 1000
            }
        };
        var chart = new google.visualization.PieChart(document.getElementById('electronic_pie_chart'));
        chart.draw(data, options);
    }

    // Maintenance Chart
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
            chartArea: { width: '90%', height: '80%' },
            backgroundColor: 'transparent',
            legend: {
                position: 'bottom',
                alignment: 'center',
                textStyle: {
                    fontSize: 12,
                    color: '#6C757D'
                }
            },
            colors: ['#667eea', '#06D6A0', '#F72585', '#F77F00', '#7209b7', '#FF6B6B'],
            titleTextStyle: {
                fontSize: 16,
                fontName: 'Inter',
                color: '#2C3E50'
            },
            animation: {
                startup: true,
                easing: 'inAndOut',
                duration: 1000
            }
        };
        var chart = new google.visualization.PieChart(document.getElementById('maintenance_pie_chart'));
        chart.draw(data, options);
    }

    // Make charts responsive
    $(window).resize(function() {
        drawFurnitureChart();
        drawElectronicChart();
        drawMaintenanceChart();
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