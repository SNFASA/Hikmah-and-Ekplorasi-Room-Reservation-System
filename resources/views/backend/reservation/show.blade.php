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
                    Reservation Details
                </h1>
                <p class="subtitle">View complete Reservation information and associated data</p>
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
                        <h5 class="section-name">Reservation Information</h5>
                        <p class="section-description">Primary reservation details and scheduling</p>
                    </div>
                    <div class="section-status">
                        <span class="status-badge status-{{ $reservation->status == 'approved' ? 'success' : 'warning' }}">
                            <i class="fas fa-{{ $reservation->status == 'approved' ? 'check-circle' : 'clock' }} me-1"></i>
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-user me-2"></i>
                                    Created by
                                </label>
                                <div class="info-value">{{ $reservation->createdBy->user->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-user me-2"></i>
                                    Name
                                </label>
                                <div class="info-value">{{ $reservation->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-id-card me-2"></i>
                                    No Staff/Matriks
                                </label>
                                <div class="info-value">{{ $reservation->staff_id_matric_no }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-bullseye me-2"></i>
                                    Purpose
                                </label>
                                <div class="info-value">{{ $reservation->purpose_program_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-envelope me-2"></i>
                                    Email
                                </label>
                                <div class="info-value">{{ $reservation->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-phone me-2"></i>
                                    Phone Number
                                </label>
                                <div class="info-value">{{ $reservation->contact_no }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-building me-2"></i>
                                    Faculty/Office
                                </label>
                                <div class="info-value">{{ $reservation->facultyOffice->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Declaration Accepted
                                </label>
                                <div class="info-value">
                                    @if($reservation->declaration_accepted)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Yes
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>No
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-calendar me-2"></i>
                                    Start Date
                                </label>
                                <div class="info-value">{{ \Carbon\Carbon::parse($reservation->start_date)->format('F j, Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-calendar me-2"></i>
                                    End Date
                                </label>
                                <div class="info-value">{{ \Carbon\Carbon::parse($reservation->end_date)->format('F j, Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-clock me-2"></i>
                                    Start Time
                                </label>
                                <div class="info-value">{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-clock me-2"></i>
                                    End Time
                                </label>
                                <div class="info-value">{{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</div>
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
                    @if($reservation->room_id && $reservation->room)
                        <!-- Regular Room Information -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label class="info-label">
                                        <i class="fas fa-door-open me-2"></i>
                                        Room Name
                                    </label>
                                    <div class="info-value">{{ $reservation->room->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label class="info-label">
                                        <i class="fas fa-tag me-2"></i>
                                        Room Type
                                    </label>
                                    <div class="info-value">{{ $reservation->room->type->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <label class="info-label">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Status
                                    </label>
                                    <div class="info-value">
                                        <span class="room-status-badge">{{ $reservation->room->status }}</span>
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
                                        @forelse($reservation->room->furnitures as $furniture)
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
                                        @forelse($reservation->room->electronics as $electronic)
                                            <div class="amenity-item">
                                                <i class="fas fa-check-circle amenity-icon"></i>
                                                <span>{{ $electronic->name }}
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
                    @else
                        <!-- Other Room Description -->
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="info-item">
                                    <label class="info-label">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        Other Room Description
                                    </label>
                                    <div class="info-value">{{ $reservation->other_room_description ?? 'No room description provided' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reservation details Information Card -->
            <div class="modern-card mb-4">
                <div class="card-header-section">
                    <div class="section-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="section-name">Reservation Details</h5>
                        <p class="section-description">Details about the reservation</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-user-group me-2"></i>
                                    Number of participants
                                </label>
                                <div class="info-value">{{ $reservation->no_of_participants }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-user-group me-2"></i>
                                    Participants category
                                </label>
                                <div class="info-value">
                                    @if($reservation->participant_category == 'Other' && $reservation->other_participant_category)
                                        {{ $reservation->other_participant_category }}
                                    @else
                                        {{ $reservation->participant_category }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-desktop me-2"></i>
                                    Event type
                                </label>
                                <div class="info-value">{{ $reservation->event_type }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Preview Card -->
            @if($reservation->file_path)
            <div class="modern-card mb-4">
                <div class="card-header-section">
                    <div class="section-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="section-name">Supporting Document</h5>
                        <p class="section-description">Uploaded document preview</p>
                    </div>
                    <div class="section-actions">
                        <a href="{{ Storage::url($reservation->file_path) }}" download="{{ $reservation->file_original_name }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download me-1"></i>
                            Download
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="file-info mb-3">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-file me-1"></i>
                                    {{ $reservation->file_original_name }}
                                </small>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">
                                    <i class="fas fa-weight me-1"></i>
                                    {{ number_format($reservation->file_size / 1024, 2) }} KB
                                </small>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ strtoupper($reservation->file_type) }}
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="file-preview-container" style="height: 600px; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                        @php
                            $fileExtension = strtolower(pathinfo($reservation->file_original_name, PATHINFO_EXTENSION));
                            $fileUrl = Storage::url($reservation->file_path);
                        @endphp
                        
                        @if(in_array($fileExtension, ['pdf']))
                            <iframe src="{{ $fileUrl }}" 
                                    style="width: 100%; height: 100%; border: none;" 
                                    title="Document Preview">
                                <p>Your browser does not support iframes. 
                                   <a href="{{ $fileUrl }}" target="_blank">Click here to view the document</a>
                                </p>
                            </iframe>
                        @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <div class="text-center p-4" style="height: 100%; overflow-y: auto;">
                                <img src="{{ $fileUrl }}" 
                                     alt="Document Preview" 
                                     class="img-fluid" 
                                     style="max-height: 100%; object-fit: contain;">
                            </div>
                        @elseif(in_array($fileExtension, ['txt', 'md']))
                            <div class="p-4" style="height: 100%; overflow-y: auto; background: #f8f9fa; font-family: monospace; white-space: pre-wrap;">
                                @php
                                    try {
                                        $content = Storage::get($reservation->file_path);
                                        echo htmlspecialchars($content);
                                    } catch (Exception $e) {
                                        echo "Unable to preview this file. Please download to view.";
                                    }
                                @endphp
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-center">
                                <div>
                                    <i class="fas fa-file-alt fa-5x text-muted mb-3"></i>
                                    <h5 class="text-muted">Preview not available</h5>
                                    <p class="text-muted">This file type cannot be previewed inline.<br>
                                       Please download the file to view its contents.</p>
                                    <a href="{{ $fileUrl }}" download="{{ $reservation->file_original_name }}" class="btn btn-primary">
                                        <i class="fas fa-download me-2"></i>
                                        Download File
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!--Admin action-->
            <div class="modern-card mb-4">
                <div class="card-header-section">
                    <div class="section-icon">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="section-name">Admin Action</h5>
                        <p class="section-description">Manage this reservation</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-comments me-2"></i>
                                    Admin comment
                                </label>
                                <div class="info-value">{{ $reservation->admin_comment ?? 'No comment provided' }}</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-user me-2"></i>
                                    Updated By (Admin)
                                </label>
                                <div class="info-value">{{ $reservation->admin_updated_by ?? 'Not updated' }}</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-clock me-2"></i>
                                    Updated at 
                                </label>
                                <div class="info-value">
                                    @if($reservation->admin_updated_at)
                                        {{ \Carbon\Carbon::parse($reservation->admin_updated_at)->format('F j, Y H:i') }}
                                    @else
                                        Not updated
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="modern-card mb-4">
                <div class="card-header-section">
                    <div class="section-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="section-name">Quick Actions</h5>
                        <p class="section-description">Manage this reservation</p>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="quick-actions">
                        <a href="{{ route('backend.reservation.edit', $reservation->id) }}" class="quick-action-btn edit">
                            <i class="fas fa-edit"></i>
                            <span>Edit Reservation</span>
                        </a>
                        <form method="POST" action="{{ route('backend.reservation.destroy', $reservation->id) }}" class="d-inline w-100">
                            @csrf
                            @method('delete')
                            <button type="button" class="quick-action-btn delete dltBtn w-100" data-id="{{ $reservation->id }}">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete reservation</span>
                            </button>
                        </form>
                        <a href="{{ route('backend.reservation.index') }}" class="quick-action-btn secondary">
                            <i class="fas fa-list"></i>
                            <span>All Reservation</span>
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
                        <h5 class="section-name">Reservation Summary</h5>
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
                                <div class="stat-number">{{ $reservation->no_of_participants }}</div>
                                <div class="stat-label">Participants</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">
                                    {{ \Carbon\Carbon::parse($reservation->start_time)->diffInHours(\Carbon\Carbon::parse($reservation->end_time)) }}h
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
                                    {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays(\Carbon\Carbon::now(), false) }}
                                </div>
                                <div class="stat-label">Days {{ \Carbon\Carbon::parse($reservation->start_date)->isPast() ? 'Ago' : 'Until' }}</div>
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
            title: "Delete This Reservation?",
            text: "This action cannot be undone. The reservation and all its associated data will be permanently deleted.",
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
                    text: "Delete Reservation",
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
                    title: "Deleting Reservation...",
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
    
    .file-preview-container {
        background: #fff;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
    }
    
    .file-info {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }
    
    /* Print styles */
    @media print {
        .header-actions,
        .quick-actions,
        .btn,
        button,
        .file-preview-container {
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