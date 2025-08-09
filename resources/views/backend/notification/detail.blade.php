@extends('backend.layouts.master')
@section('title', 'View Booking')
@section('main-content')

<!-- Main Container with Enhanced Styling -->
<div class="container-fluid px-4">
    <!-- Header Section with Gradient Background -->
    <div class="header-section mb-4">
        <div class="header-content d-flex flex-column flex-lg-row justify-content-between align-items-center">
            <div class="header-title">
                <h1 class="main-title text-primary">
                    <i class="fas fa-calendar-check me-3"></i>
                    Booking Details
                </h1>
                <p class="subtitle">View complete booking information and associated data</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Booking Information -->
        <div class="col-lg-8">
            <!-- Booking Basic Info Card -->
            <div class="modern-card mb-4">
                <div class="card-header-section">
                    <div class="section-icon">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="section-name">Booking Information</h5>
                        <p class="section-description">Primary booking details and scheduling</p>
                    </div>
                    <div class="section-status">
                        <span class="status-badge status-{{ $booking->status == 'approved' ? 'success' : 'warning' }}">
                            <i class="fas fa-{{ $booking->status == 'approved' ? 'check-circle' : 'clock' }} me-1"></i>
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-bullseye me-2"></i>
                                    Purpose
                                </label>
                                <div class="info-value">{{ $booking->purpose }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-phone me-2"></i>
                                    Phone Number
                                </label>
                                <div class="info-value">{{ $booking->phone_number }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-calendar me-2"></i>
                                    Date
                                </label>
                                <div class="info-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-clock me-2"></i>
                                    Start Time
                                </label>
                                <div class="info-value">{{ \Carbon\Carbon::parse($booking->booking_time_start)->format('H:i') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-clock me-2"></i>
                                    End Time
                                </label>
                                <div class="info-value">{{ \Carbon\Carbon::parse($booking->booking_time_end)->format('H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Information Card -->
            <div class="modern-card mb-4">
                <div class="card-header-section">
                    <div class="section-icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="section-name">Room Information</h5>
                        <p class="section-description">Details about the reserved room and amenities</p>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-door-open me-2"></i>
                                    Room Name
                                </label>
                                <div class="info-value">{{ $booking->room->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-tag me-2"></i>
                                    Room Type
                                </label>
                                <div class="info-value">{{ $booking->room->type->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Status
                                </label>
                                <div class="info-value">
                                    <span class="room-status-badge">{{ $booking->room->status ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Furnitures Section -->
                        <div class="col-md-6">
                            <div class="amenity-section">
                                <h6 class="amenity-title">
                                    <i class="fas fa-couch me-2"></i>
                                    Furnitures
                                </h6>
                                <div class="amenity-list">
                                    @forelse($booking->room->furnitures as $furniture)
                                        <div class="amenity-item">
                                            <i class="fas fa-check-circle amenity-icon"></i>
                                            <span>{{ $furniture->name }}</span>
                                        </div>
                                    @empty
                                        <div class="amenity-item empty">
                                            <i class="fas fa-minus-circle amenity-icon"></i>
                                            <span>No furnitures assigned</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Electronics Section -->
                        <div class="col-md-6">
                            <div class="amenity-section">
                                <h6 class="amenity-title">
                                    <i class="fas fa-plug me-2"></i>
                                    Electronics
                                </h6>
                                <div class="amenity-list">
                                    @forelse($booking->room->electronics as $electronic)
                                        <div class="amenity-item">
                                            <i class="fas fa-check-circle amenity-icon"></i>
                                            <span>{{ $electronic->name }}
                                                @if($electronic->categories)
                                                    <small class="category-tag">({{ $electronic->category }})</small>
                                                @endif
                                            </span>
                                        </div>
                                    @empty
                                        <div class="amenity-item empty">
                                            <i class="fas fa-minus-circle amenity-icon"></i>
                                            <span>No electronics assigned</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Information Card -->
            <div class="modern-card">
                <div class="card-header-section">
                    <div class="section-icon ">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="section-name">Students List</h5>
                        <p class="section-description">Students associated with this booking</p>
                    </div>
                    <div class="section-badge">
                        <span class="count-badge">
                            {{ $booking->listStudentBookings->count() }} Students
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($booking->listStudentBookings->count() > 0)
                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table modern-students-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="student-header">
                                                <i class="fas fa-id-card me-2"></i>
                                                Matric Number
                                            </th>
                                            <th class="student-header">
                                                <i class="fas fa-user me-2"></i>
                                                Student Name
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($booking->listStudentBookings as $index => $student)
                                            <tr class="student-row" style="animation-delay: {{ $index * 0.1 }}s">
                                                <td class="student-cell">
                                                    <div class="student-id">
                                                        <span class="id-badge">{{ $student->no_matriks }}</span>
                                                    </div>
                                                </td>
                                                <td class="student-cell">
                                                    <div class="student-info">
                                                        <span class="student-name">{{ $student->user->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="empty-students">
                            <div class="empty-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <p class="empty-text">No students associated with this booking</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar with Quick Actions and Summary -->
        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="modern-card mb-4">
                <div class="card-header-section">
                    <div class="section-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="section-name">Quick Actions</h5>
                        <p class="section-description">Manage this booking</p>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="quick-actions">
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="quick-action-btn edit">
                            <i class="fas fa-edit"></i>
                            <span>Edit Booking</span>
                        </a>
                        <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}" class="d-inline w-100">
                            @csrf 
                            @method('delete')
                            <button type="button" class="quick-action-btn delete dltBtn w-100" data-id="{{ $booking->id }}">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete Booking</span>
                            </button>
                        </form>
                        <a href="{{ route('bookings.index') }}" class="quick-action-btn secondary">
                            <i class="fas fa-list"></i>
                            <span>All Bookings</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Booking Summary Card -->
            <div class="modern-card">
                <div class="card-header-section">
                    <div class="section-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="section-name">Booking Summary</h5>
                        <p class="section-description">Key metrics and information</p>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="summary-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $booking->listStudentBookings->count() }}</div>
                                <div class="stat-label">Students</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">
                                    {{ \Carbon\Carbon::parse($booking->booking_time_start)->diffInHours(\Carbon\Carbon::parse($booking->booking_time_end)) }}h
                                </div>
                                <div class="stat-label">Duration</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->diffInDays(\Carbon\Carbon::now()) > 0 ? \Carbon\Carbon::parse($booking->booking_date)->diffInDays(\Carbon\Carbon::now()) : 0 }}
                                </div>
                                <div class="stat-label">Days {{ \Carbon\Carbon::parse($booking->booking_date)->isPast() ? 'Ago' : 'Until' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize tooltips if using Bootstrap 5
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Enhanced delete confirmation
    $('.dltBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var bookingId = $(this).data('id');
        
        swal({
            title: "Delete This Booking?",
            text: "This action cannot be undone. The booking and all its associated data will be permanently deleted.",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn-light",
                    closeModal: true,
                },
                confirm: {
                    text: "Delete Booking",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // Add loading state
                swal({
                    title: "Deleting Booking...",
                    text: "Please wait while we process your request.",
                    icon: "info",
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
                
                // Redirect to bookings index after deletion
                form.submit();
            }
        });
    });

    // Add smooth animations for cards on load
    $('.modern-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
        $(this).addClass('fadeInUp');
    });

    // Add hover effects for info items
    $('.info-item').hover(
        function() {
            $(this).css('transform', 'translateX(5px)');
        },
        function() {
            $(this).css('transform', 'translateX(0px)');
        }
    );

    // Add click effects for quick action buttons
    $('.quick-action-btn').on('mousedown', function() {
        $(this).css('transform', 'scale(0.95)');
    }).on('mouseup mouseleave', function() {
        $(this).css('transform', 'scale(1)');
    });

    // Smooth scroll to sections (if you want to add navigation)
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if( target.length ) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });

    // Add loading states for better UX
    $('form').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...');
    });

    // Auto-refresh page data every 30 seconds (optional)
    // setInterval(function() {
    //     // You can add AJAX call here to refresh booking status
    //     console.log('Auto-refresh check...');
    // }, 30000);

    // Print functionality (optional)
    window.printBookingDetails = function() {
        window.print();
    };

    // Export functionality (optional)
    window.exportBookingDetails = function() {
        // You can implement export to PDF functionality here
        console.log('Export booking details...');
    };
});

// Add CSS animation classes
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fadeInUp {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    /* Print styles */
    @media print {
        .header-actions,
        .quick-actions,
        .btn,
        button {
            display: none !important;
        }
        
        .modern-card {
            box-shadow: none !important;
            border: 1px solid #ccc !important;
            break-inside: avoid;
            margin-bottom: 1rem !important;
        }
        
        .card-header-section {
            background: #f5f5f5 !important;
            -webkit-print-color-adjust: exact;
        }
        
        body {
            font-size: 12pt;
            line-height: 1.4;
        }
        
        .main-title {
            font-size: 18pt !important;
        }
        
        .section-name {
            font-size: 14pt !important;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush