@extends('backend.layouts.master')
@section('title','LibraRoom Reservation system ')
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
                    <i class="fas fa-tools me-3"></i>
                    Maintenance Management
                </h1>
                <p class="subtitle">Track and manage all maintenance reports</p>
            </div>
            <div class="header-actions mt-3 mt-lg-0">
                <a href="{{ route('maintenance.create') }}" class="btn btn-create">
                    <i class="fas fa-plus me-2"></i>
                    <span>Add Report</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Card with Modern Design -->
    <div class="modern-card">
        <div class="card-body p-0">
            @if($maintenance->isNotEmpty())
                <!-- Search and Filter Section -->
                <div class="search-section p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchInput" class="form-control search-input" placeholder="Search reports, type, item, or status...">
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <div class="stats-info">
                                <span class="badge badge-info">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    {{$maintenance->count()}} Total Reports
                                </span>
                                <span class="badge badge-success ms-2">
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{$maintenance->where('status', 'completed')->count()}} Completed
                                </span>
                                <span class="badge badge-warning ms-2">
                                    <i class="fas fa-clock me-1"></i>
                                    {{$maintenance->where('status', 'pending')->count()}} Pending
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table modern-table" id="maintenanceTable">
                            <thead>
                                <tr>
                                    <th class="sortable" data-column="0">
                                        <span>ID</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="1">
                                        <span>Title</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="2">
                                        <span>Type</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="3">
                                        <span>Item</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="4">
                                        <span>Status</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maintenance as $report)
                                    <tr class="table-row" data-id="{{$report->id}}">
                                        <td class="id-cell">
                                            <span class="id-badge">#{{$report->id}}</span>
                                        </td>
                                        <td class="title-cell">
                                            <div class="title-info">
                                                <i class="fas fa-clipboard-list me-2 text-primary"></i>
                                                <span class="title-name">{{ $report->title }}</span>
                                            </div>
                                        </td>
                                        <td class="type-cell">
                                            <span class="type-badge">
                                                <i class="fas fa-tag me-1"></i>
                                                {{ $report->itemType }}
                                            </span>
                                        </td>
                                        <td class="item-cell">
                                            <span class="item-badge">
                                                <i class="fas fa-cog me-1"></i>
                                                {{ $report->itemName }}
                                            </span>
                                        </td>
                                        <td class="status-cell">
                                            @if($report->status == 'completed')
                                                <span class="status-badge status-success">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Completed
                                                </span>
                                            @elseif($report->status == 'pending')
                                                <span class="status-badge status-warning">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Pending
                                                </span>
                                            @elseif($report->status == 'in_progress')
                                                <span class="status-badge status-info">
                                                    <i class="fas fa-spinner me-1"></i>
                                                    In Progress
                                                </span>
                                            @else
                                                <span class="status-badge status-danger">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    {{ ucfirst($report->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="action-cell">
                                            <div class="action-buttons">
                                                <a href="{{ route('maintenance.edit', $report->id) }}"
                                                   class="action-btn edit-btn"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="Edit Report">
                                                   <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('maintenance.destroy', $report->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button"
                                                            class="action-btn delete-btn dltBtn"
                                                            data-id="{{ $report->id }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Delete Report">
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
                                Showing {{$maintenance->firstItem()}} to {{$maintenance->lastItem()}}
                                of {{$maintenance->total()}} results
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pagination-wrapper">
                                {{ $maintenance->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State with Better Design -->
                <div class="empty-state">
                    <div class="empty-state-content">
                        <div class="empty-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3 class="empty-title">No Maintenance Reports Found</h3>
                        <p class="empty-description">
                            Get started by creating your first maintenance report.
                            You can track repairs, maintenance tasks, and equipment status.
                        </p>
                        <a href="{{ route('maintenance.create') }}" class="btn btn-create">
                            <i class="fas fa-plus me-2"></i>
                            Create Report
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
        $('#maintenanceTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Table sorting functionality
    $('.sortable').click(function() {
        var table = $('#maintenanceTable');
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
            $('#maintenanceTable tbody tr').each(function(index) {
                $(this).css('animation-delay', (index * 0.05) + 's');
                $(this).addClass('fadeInUp');
            });
        }, 50);
    });

    // Enhanced delete confirmation
    $('.dltBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var reportId = $(this).data('id');
        
        swal({
            title: "Delete Maintenance Report?",
            text: "This action cannot be undone. The report and all its data will be permanently deleted.",
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
    $('#maintenanceTable tbody tr').each(function(index) {
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