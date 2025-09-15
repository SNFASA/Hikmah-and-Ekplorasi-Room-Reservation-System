@extends('backend.layouts.master')
@section('title','PTTA Reservation System || All Notifications')
@section('main-content')

<!-- Main Container with Enhanced Styling -->
<div class="container-fluid px-4">
    <!-- Header Section with Gradient Background -->
    <div class="header-section mb-4">
        <div class="header-content d-flex flex-column flex-lg-row justify-content-between align-items-center">
            <div class="header-title">
                <h1 class="main-title text-primary">
                    <i class="fas fa-bell me-3"></i>
                    Notifications
                </h1>
                <p class="subtitle">Stay updated with all your notifications</p>
            </div>
            <div class="header-actions mt-3 mt-lg-0">
                @if($notifications->count() > 0)
                    <form method="POST" action="{{ route('notification.mark-all-read') }}" class="d-inline me-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-success">
                            <i class="fas fa-check-double me-2"></i>
                            <span>Mark All Read</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Card with Modern Design -->
    <div class="modern-card">
        <div class="card-body p-0">
            @if($notifications->count() > 0)
                <!-- Search and Filter Section -->
                <div class="search-section p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchInput" class="form-control search-input" placeholder="Search notifications, title, or time...">
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <div class="stats-info">
                                @php
                                    $totalNotifications = Auth::user()->notifications()
                                        ->where(function($query) {
                                            $query->whereNull('data->is_deleted')
                                                  ->orWhere('data->is_deleted', '!=', true);
                                        })
                                        ->count();
                                    
                                    $unreadNotifications = Auth::user()->unreadNotifications()
                                        ->where(function($query) {
                                            $query->whereNull('data->is_deleted')
                                                  ->orWhere('data->is_deleted', '!=', true);
                                        })
                                        ->count();
                                    
                                    $readNotifications = $totalNotifications - $unreadNotifications;
                                @endphp
                                <span class="badge badge-info">
                                    <i class="fas fa-bell me-1"></i>
                                    {{ $totalNotifications }} Total
                                </span>
                                <span class="badge badge-warning ms-2">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ $unreadNotifications }} Unread
                                </span>
                                <span class="badge badge-success ms-2">
                                    <i class="fas fa-envelope-open me-1"></i>
                                    {{ $readNotifications }} Read
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table modern-table" id="notificationTable">
                            <thead>
                                <tr>
                                    <th class="sortable" data-column="0">
                                        <span>#</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="1">
                                        <span>Time</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="2">
                                        <span>Title</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                <tr class="table-row notification-row {{ $notification->unread() ? 'unread-notification' : 'read-notification' }}"
                                    data-id="{{$notification->id}}">
                                    <td class="id-cell">
                                        <span class="id-badge">#{{ $loop->iteration }}</span>
                                    </td>
                                    <td class="time-cell">
                                        <div class="time-info">
                                            <i class="fas fa-clock me-2 text-primary"></i>
                                            <div class="time-details">
                                                <span class="time-main">{{ $notification->created_at->format('M d, Y') }}</span>
                                                <small class="time-sub text-muted">{{ $notification->created_at->format('h:i A') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="title-cell">
                                        <div class="notification-content">
                                            @if($notification->unread())
                                                <div class="unread-indicator"></div>
                                            @endif
                                            <div class="notification-title">
                                                <span class="title-text">{{ $notification->data['title'] ?? 'Notification' }}</span>
                                                @if(isset($notification->data['message']))
                                                    <small class="notification-preview text-muted d-block">
                                                        {{ Str::limit($notification->data['message'], 60) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="status-cell">
                                        <span class="status-badge status-{{ $notification->unread() ? 'warning' : 'success' }}">
                                            <i class="fas fa-{{ $notification->unread() ? 'envelope' : 'envelope-open' }} me-1"></i>
                                            {{ $notification->unread() ? 'Unread' : 'Read' }}
                                        </span>
                                    </td>
                                    <td class="action-cell">
                                        <div class="action-buttons">
                                            <a href="{{ route('notification.detail', $notification->id) }}"
                                               class="action-btn view-btn"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               title="View Notification">
                                               <i class="fas fa-eye"></i>
                                            </a>
                                            @if($notification->unread())
                                                <form method="POST" action="{{ route('notification.mark-read', $notification->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="action-btn read-btn"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Mark as Read">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('notification.delete', $notification->id) }}" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button"
                                                        class="action-btn delete-btn dltBtn"
                                                        data-id="{{ $notification->id }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Delete Notification">
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
                @if(method_exists($notifications, 'links'))
                <div class="pagination-section p-4 border-top">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="pagination-info">
                                Showing {{$notifications->firstItem()}} to {{$notifications->lastItem()}}
                                of {{$notifications->total()}} results
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pagination-wrapper">
                                {{ $notifications->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <!-- Empty State with Better Design -->
                <div class="empty-state">
                    <div class="empty-state-content">
                        <div class="empty-icon">
                            <i class="fas fa-bell-slash"></i>
                        </div>
                        <h3 class="empty-title">No Notifications Yet</h3>
                        <p class="empty-description">
                            You're all caught up! When you receive new notifications,
                            they'll appear here to keep you informed.
                        </p>
                        <div class="empty-actions">
                            <a href="{{ route('notification.index') }}" class="btn btn-create">
                                <i class="fas fa-home me-2"></i>
                                Back to Dashboard
                            </a>
                        </div>
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
        $('#notificationTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
        
        // Update visible count
        var visibleRows = $('#notificationTable tbody tr:visible').length;
        if (value && visibleRows === 0) {
            if ($('#no-results').length === 0) {
                $('#notificationTable tbody').append(
                    '<tr id="no-results"><td colspan="5" class="text-center text-muted py-4">' +
                    '<i class="fas fa-search me-2"></i>No notifications found matching your search.' +
                    '</td></tr>'
                );
            }
        } else {
            $('#no-results').remove();
        }
    });

    // Table sorting functionality
    $('.sortable').click(function() {
        var table = $('#notificationTable');
        var rows = table.find('tbody tr:not(#no-results)').toArray();
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
            
            // Handle date values for time column
            if (column === 1) {
                var aDate = new Date(aVal);
                var bDate = new Date(bVal);
                return isAsc ? aDate - bDate : bDate - aDate;
            }
            
            // Handle text values
            return isAsc ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
        });

        table.find('tbody').empty().append(rows);
        
        // Re-animate rows
        setTimeout(function() {
            $('#notificationTable tbody tr').each(function(index) {
                $(this).css('animation-delay', (index * 0.05) + 's');
                $(this).addClass('fadeInUp');
            });
        }, 50);
    });

    // Enhanced delete confirmation
    $('.dltBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var notificationId = $(this).data('id');
        
        swal({
            title: "Delete Notification?",
            text: "This notification will be permanently deleted and cannot be recovered.",
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

    // Clear all notifications confirmation
    $('.clearAllBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        
        swal({
            title: "Clear All Notifications?",
            text: "This will permanently delete all your notifications. This action cannot be undone.",
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
                    text: "Clear All",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }
            },
            dangerMode: true,
        }).then((willClear) => {
            if (willClear) {
                // Add loading state
                swal({
                    title: "Clearing Notifications...",
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
    $('#notificationTable tbody tr').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });

    // Search input focus effect
    $('#searchInput').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });

    // Auto-refresh notification count every 30 seconds
    setInterval(function() {
        // You can add AJAX call here to fetch unread notifications count
    }, 30000);

    // Mark notification as read on row click
    $('.notification-row').on('click', function(e) {
        // Don't trigger if clicking on action buttons
        if (!$(e.target).closest('.action-buttons').length) {
            var notificationId = $(this).data('id');
            var isUnread = $(this).hasClass('unread-notification');
            
            if (isUnread) {
                // You can add AJAX call here to mark as read
                $(this).removeClass('unread-notification').addClass('read-notification');
                $(this).find('.unread-indicator').fadeOut();
                $(this).find('.status-badge').removeClass('status-warning').addClass('status-success');
                $(this).find('.status-badge i').removeClass('fa-envelope').addClass('fa-envelope-open');
                $(this).find('.status-badge').text(' Read');
            }
        }
    });

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 75) {
            e.preventDefault();
            $('#searchInput').focus();
        }
        
        // Escape to clear search
        if (e.keyCode === 27) {
            $('#searchInput').val('').trigger('keyup');
        }
    });

    // Show search shortcut tooltip
    $('#searchInput').attr('title', 'Press Ctrl+K to focus search, Esc to clear');
});

// Add loading states for better UX
$(window).on('beforeunload', function() {
    $('body').addClass('loading');
});

// Add custom scrollbar for webkit browsers
if (window.WebKitCSSMatrix) {
    $('body').addClass('webkit-scrollbar');
}
</script>
@endpush