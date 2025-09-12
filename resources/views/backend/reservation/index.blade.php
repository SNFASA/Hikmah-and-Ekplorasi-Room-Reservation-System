@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')

<!-- Main Container with Enhanced Styling -->
<div class="container-fluid px-4">
    <!-- Header Section with Gradient Background -->
    <div class="header-section mb-4">
        <div class="row align-items-center">
            <div class="col-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        
        <div class="header-content d-flex flex-column flex-lg-row justify-content-between align-items-center">
            <div class="header-title">
                <h1 class="main-title text-primary">
                    <i class="fas fa-calendar-check me-3"></i>
                    Reservation Facilities Management
                </h1>
                <p class="subtitle">Manage all room reservations and bookings</p>
            </div>
            <div class="header-actions mt-3 mt-lg-0">
                <a href="{{ route('backend.reservation.create') }}" class="btn btn-create">
                    <i class="fas fa-plus me-2"></i>
                    <span>Add Reservation</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Card with Modern Design -->
    <div class="modern-card">
        <div class="card-body p-0">
            @if($reservation->count() > 0)
                <!-- Search and Filter Section -->
                <div class="search-section p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchInput" class="form-control search-input" placeholder="Search purpose, room, student ID, or status...">
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <div class="stats-info">
                                <span class="badge badge-info">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    {{$reservation->count()}} Total Reservations
                                </span>
                                <span class="badge badge-success ms-2">
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{$reservation->where('status', 'approved')->count()}} Approved
                                </span>
                                <span class="badge badge-warning ms-2">
                                    <i class="fas fa-clock me-1"></i>
                                    {{$reservation->where('status', 'pending')->count()}} Pending
                                </span>
                                <span class="badge badge-danger ms-2">
                                    <i class="fas fa-times-circle me-1"></i>
                                    {{$reservation->where('status', 'rejected')->count()}} Rejected
                                </span>
                                <span class="badge badge-danger ms-2">
                                    <i class="fas fa-times-circle me-1"></i>
                                    {{$reservation->where('status', 'canceled')->count()}} Canceled
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table modern-table" id="bookingTable">
                            <thead>
                                <tr>
                                    <th class="sortable" data-column="0">
                                        <span>S.N.</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="1">
                                        <span>Purpose</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th>List Student/Staff</th>
                                    <th class="sortable" data-column="3">
                                        <span>Room</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="4">
                                        <span>Date & Time</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="5">
                                        <span>Status</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservation as $reservations)
                                    <tr class="table-row" data-id="{{$reservations->id}}">
                                        <td class="id-cell">
                                            <span class="id-badge">#{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="purpose-cell">
                                            <div class="purpose-info">
                                                <i class="fas fa-bookmark me-2 text-primary"></i>
                                                <span class="purpose-text">{{ $reservations->purpose_program_name}}</span>
                                            </div>
                                        </td>
                                        <td class="students-cell">
                                            @if($reservations->listStudentBooking)
                                                <div class="students-list">
                                                    @php
                                                        // Get the student/staff information
                                                        $student = $reservations->listStudentBooking;
                                                    @endphp
                                                    <span class="student-tag">
                                                        <i class="fas fa-user me-1"></i>
                                                        @if($student->user)
                                                            {{ $student->user->name ?? $student->user->no_matriks }}
                                                        @else
                                                            {{ $student->no_matriks ?? 'N/A' }}
                                                        @endif
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus me-1"></i>
                                                    None
                                                </span>
                                            @endif
                                        </td>
                                        <td class="room-cell">
                                            <div class="room-info">
                                                <i class="fas fa-door-open me-2 text-primary"></i>
                                                <span class="room-name">{{ $reservations->room->name ?? 'N/A'}}</span>
                                            </div>
                                        </td>
                                        <td class="datetime-cell">
                                            <div class="datetime-info">
                                                <div class="date-section">
                                                    <i class="fas fa-calendar me-1 text-info"></i>
                                                    <span class="booking-date">
                                                        {{ \Carbon\Carbon::parse($reservations->start_date)->format('M d, Y') }}
                                                        @if($reservations->start_date != $reservations->end_date)
                                                            - {{ \Carbon\Carbon::parse($reservations->end_date)->format('M d, Y') }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="time-section mt-1">
                                                    <i class="fas fa-clock me-1 text-warning"></i>
                                                    <span class="booking-time">
                                                        {{ \Carbon\Carbon::parse($reservations->start_time)->format('g:i A') }} - 
                                                        {{ \Carbon\Carbon::parse($reservations->end_time)->format('g:i A') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="status-cell">
                                            @php
                                                $statusClasses = [
                                                    'approved' => 'success',
                                                    'pending' => 'warning',
                                                    'rejected' => 'danger',
                                                    'canceled' => 'secondary'
                                                ];
                                                $statusIcons = [
                                                    'approved' => 'check-circle',
                                                    'pending' => 'clock',
                                                    'rejected' => 'times-circle',
                                                    'canceled' => 'ban'
                                                ];
                                                $statusClass = $statusClasses[$reservations->status] ?? 'secondary';
                                                $statusIcon = $statusIcons[$reservations->status] ?? 'question-circle';
                                            @endphp
                                            <span class="status-badge status-{{ $statusClass }}">
                                                <i class="fas fa-{{ $statusIcon }} me-1"></i>
                                                {{ ucfirst($reservations->status) }}
                                            </span>
                                        </td>
                                        <td class="action-cell">
                                            <div class="action-buttons">
                                                <a href="{{ route('backend.reservation.show', $reservations->id) }}"
                                                   class="action-btn view-btn"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="View Booking">
                                                   <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('backend.reservation.edit', $reservations->id) }}"
                                                   class="action-btn edit-btn"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="Edit Booking">
                                                   <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('backend.reservation.destroy', $reservations->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button"
                                                            class="action-btn delete-btn dltBtn"
                                                            data-id="{{ $reservations->id }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Delete Booking">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Enhanced Pagination -->
                <div class="pagination-section p-4 border-top">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="pagination-info">
                                Showing {{$reservation->firstItem()}} to {{$reservation->lastItem()}}
                                of {{$reservation->total()}} results
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pagination-wrapper">
                                {{ $reservation->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State with Better Design -->
                <div class="empty-state">
                    <div class="empty-state-content">
                        <div class="empty-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="empty-title">No Reservation Found</h3>
                        <p class="empty-description">
                            Get started by creating your first Reservation Facilities.
                            You can schedule room reservations and manage student lists.
                        </p>
                        <a href="{{ route('backend.reservation.create') }}" class="btn btn-create">
                            <i class="fas fa-plus me-2"></i>
                            Create Reservation Facilities
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Enhanced search functionality
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#bookingTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Table sorting functionality
    $('.sortable').click(function() {
        var table = $('#bookingTable');
        var rows = table.find('tbody tr').toArray();
        var column = $(this).data('column');
        var isAsc = !$(this).hasClass('asc');
        
        // Remove all sort classes
        $('.sortable').removeClass('asc desc');
        $('.sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
        
        // Add appropriate class and icon
        if (isAsc) {
            $(this).addClass('asc');
            $(this).find('.sort-icon').removeClass('fa-sort').addClass('fa-sort-up');
        } else {
            $(this).addClass('desc');
            $(this).find('.sort-icon').removeClass('fa-sort').addClass('fa-sort-down');
        }

        rows.sort(function(a, b) {
            var aVal = $(a).find('td').eq(column).text().trim();
            var bVal = $(b).find('td').eq(column).text().trim();
            
            // Handle numeric values
            if (!isNaN(aVal) && !isNaN(bVal)) {
                return isAsc ? aVal - bVal : bVal - aVal;
            }
            
            // Handle text values
            return isAsc ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
        });

        table.find('tbody').empty().append(rows);
        
        // Re-animate rows
        setTimeout(function() {
            $('#bookingTable tbody tr').each(function(index) {
                $(this).css('animation-delay', (index * 0.05) + 's');
                $(this).addClass('fadeInUp');
            });
        }, 50);
    });

    // Enhanced delete confirmation
    $('.dltBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var bookingId = $(this).data('id');
        
        swal({
            title: "Delete Reservation?",
            text: "This action cannot be undone. The reservation and all its data will be permanently deleted.",
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
                    text: "Delete",
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
                    title: "Deleting...",
                    text: "Please wait while we process your request.",
                    icon: "info",
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
                
                form.submit();
            }
        });
    });

    // Add smooth transitions for table rows
    $('#bookingTable tbody tr').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });

    // Search input focus effect
    $('#searchInput').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
});

// Add loading states for better UX
$(window).on('beforeunload', function() {
    $('body').addClass('loading');
});
</script>
@endpush