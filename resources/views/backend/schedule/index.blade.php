@extends('backend.layouts.master')
@section('title','LibraRoom Reservation System')
@section('main-content')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <i class="fas fa-calendar-times me-3"></i>
                    Unavailable Rooms
                </h1>
                <p class="subtitle">Manage room availability schedules</p>
            </div>
            <div class="header-actions mt-3 mt-lg-0">
                <a href="{{route('schedule.create')}}" class="btn btn-create">
                    <i class="fas fa-plus me-2"></i>
                    <span>Manage Schedule</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Card with Modern Design -->
    <div class="modern-card">
        <div class="card-body p-0">
            @if($schedules->isNotEmpty())
                <!-- Search and Filter Section -->
                <div class="search-section p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchInput" class="form-control search-input" placeholder="Search rooms, dates, or times...">
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <div class="stats-info">
                                <span class="badge badge-info">
                                    <i class="fas fa-ban me-1"></i>
                                    {{$schedules->total()}} Unavailable Rooms
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bulk Actions Section (Optional Enhancement) -->
                <div class="bulk-actions-section p-3 border-bottom d-none" id="bulkActionsSection">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="selected-count">0</span> schedule(s) selected
                        </div>
                        <div class="bulk-buttons">
                            <button type="button" class="btn btn-sm btn-danger" id="bulkDeleteBtn">
                                <i class="fas fa-trash me-1"></i>
                                Delete Selected
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary" id="clearSelectionBtn">
                                Clear Selection
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table modern-table" id="scheduleTable">
                            <thead>
                                <tr>
                                    <th class="checkbox-column">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                            <label class="form-check-label" for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th class="sortable" data-column="1">
                                        <span>ID</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="2">
                                        <span>Room</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="3">
                                        <span>Date</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="4">
                                        <span>Start Time</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="5">
                                        <span>End Time</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="6">
                                        <span>Status</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Optimize database queries by getting all rooms at once
                                    $roomIds = $schedules->pluck('roomid')->unique();
                                    $rooms = DB::table('rooms')->whereIn('no_room', $roomIds)->pluck('name', 'no_room');
                                @endphp
                                
                                @foreach($schedules as $schedule)
                                    @php
                                        $room = $rooms[$schedule->roomid] ?? 'Unknown Room';
                                        $isExpired = \Carbon\Carbon::parse($schedule->invalid_date)->isPast();
                                        $isToday = \Carbon\Carbon::parse($schedule->invalid_date)->isToday();
                                    @endphp
                                    <tr class="table-row {{ $isExpired ? 'expired-row' : '' }}" data-id="{{$schedule->id}}">
                                        <td class="checkbox-column">
                                            <div class="form-check">
                                                <input class="form-check-input row-checkbox" type="checkbox" value="{{$schedule->id}}" id="check{{$schedule->id}}">
                                                <label class="form-check-label" for="check{{$schedule->id}}"></label>
                                            </div>
                                        </td>
                                        <td class="id-cell">
                                            <span class="id-badge">#{{$schedule->id}}</span>
                                        </td>
                                        <td class="room-cell">
                                            <div class="room-info">
                                                <i class="fas fa-door-open me-2 text-primary"></i>
                                                <span class="room-name">{{ $room }}</span>
                                            </div>
                                        </td>
                                        <td class="date-cell">
                                            <div class="date-info">
                                                <i class="fas fa-calendar me-2 {{ $isToday ? 'text-warning' : 'text-info' }}"></i>
                                                <span class="date-text">
                                                    {{date('M d, Y', strtotime($schedule->invalid_date))}}
                                                    @if($isToday)
                                                        <small class="badge bg-warning text-dark ms-1">Today</small>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td class="time-cell">
                                            <span class="time-badge start-time">
                                                <i class="fas fa-clock me-1"></i>
                                                {{date('h:i A', strtotime($schedule->invalid_time_start))}}
                                            </span>
                                        </td>
                                        <td class="time-cell">
                                            <span class="time-badge end-time">
                                                <i class="fas fa-clock me-1"></i>
                                                {{date('h:i A', strtotime($schedule->invalid_time_end))}}
                                            </span>
                                        </td>
                                        <td class="status-cell">
                                            @if($isExpired)
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-history me-1"></i>
                                                    Expired
                                                </span>
                                            @elseif($isToday)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-exclamation-circle me-1"></i>
                                                    Active Today
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-ban me-1"></i>
                                                    Scheduled
                                                </span>
                                            @endif
                                        </td>
                                        <td class="action-cell">
                                            <div class="action-buttons">
                                                <a href="{{route('schedule.edit',$schedule->id)}}"
                                                   class="action-btn edit-btn"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="Edit Schedule">
                                                   <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <!-- Enhanced delete form with better error handling -->
                                                <form method="POST"
                                                      action="{{ route('backend.schedule.destroy', $schedule->id) }}"
                                                      class="d-inline delete-form"
                                                      data-room-name="{{ $room }}"
                                                      data-schedule-id="{{ $schedule->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="action-btn delete-btn dltBtn"
                                                            data-id="{{ $schedule->id }}"
                                                            data-room-name="{{ $room }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Delete Schedule">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>

                                                <!-- Quick view button (optional) -->
                                                <button type="button"
                                                        class="action-btn view-btn"
                                                        data-id="{{ $schedule->id }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Quick View"
                                                        onclick="showScheduleDetails({{ json_encode([
                                                            'id' => $schedule->id,
                                                            'room' => $room,
                                                            'date' => date('M d, Y', strtotime($schedule->invalid_date)),
                                                            'start_time' => date('h:i A', strtotime($schedule->invalid_time_start)),
                                                            'end_time' => date('h:i A', strtotime($schedule->invalid_time_end)),
                                                            'batch_id' => $schedule->batch_id
                                                        ]) }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
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
                                Showing {{$schedules->firstItem()}} to {{$schedules->lastItem()}}
                                of {{$schedules->total()}} results
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pagination-wrapper">
                                {{ $schedules->links('pagination::bootstrap-5') }}
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
                        <h3 class="empty-title">No Unavailable Rooms</h3>
                        <p class="empty-description">
                            All rooms are currently available for booking.
                            You can manage schedules to set unavailable periods.
                        </p>
                        <a href="{{route('schedule.create')}}" class="btn btn-create">
                            <i class="fas fa-plus me-2"></i>
                            Create Schedule
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick View Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">Schedule Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="scheduleModalBody">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" class="btn btn-primary" id="editScheduleBtn">Edit Schedule</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .expired-row {
        opacity: 0.7;
        background-color: #f8f9fa;
    }
    
    .checkbox-column {
        width: 40px;
        text-align: center;
    }
    
    .bulk-actions-section {
        background-color: #e3f2fd;
        border-left: 4px solid #2196f3;
    }
    
    .status-cell .badge {
        font-size: 0.75rem;
    }
    
    .action-btn.view-btn {
        background-color: #17a2b8;
        color: white;
    }
    
    .action-btn.view-btn:hover {
        background-color: #138496;
    }
</style>
@endpush

@push('scripts')
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Bulk selection functionality
    $('#selectAll').change(function() {
        $('.row-checkbox').prop('checked', this.checked);
        updateBulkActions();
    });

    $('.row-checkbox').change(function() {
        updateBulkActions();
        
        // Update select all checkbox
        var totalCheckboxes = $('.row-checkbox').length;
        var checkedCheckboxes = $('.row-checkbox:checked').length;
        $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    function updateBulkActions() {
        var selectedCount = $('.row-checkbox:checked').length;
        $('.selected-count').text(selectedCount);
        
        if (selectedCount > 0) {
            $('#bulkActionsSection').removeClass('d-none');
        } else {
            $('#bulkActionsSection').addClass('d-none');
        }
    }

    // Bulk delete functionality
    $('#bulkDeleteBtn').click(function() {
        var selectedIds = $('.row-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            swal("No Selection", "Please select at least one schedule to delete.", "warning");
            return;
        }

        swal({
            title: "Delete Multiple Schedules?",
            text: `Are you sure you want to delete ${selectedIds.length} schedule(s)? This action cannot be undone.`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn-light",
                },
                confirm: {
                    text: "Delete All",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                }
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // Perform bulk delete via AJAX
                $.ajax({
                    url: '{{ route("backend.schedule.bulk-destroy") }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ids: selectedIds
                    },
                    beforeSend: function() {
                        swal({
                            title: "Deleting...",
                            text: "Please wait while we process your request.",
                            icon: "info",
                            buttons: false,
                            closeOnClickOutside: false,
                        });
                    },
                    success: function(response) {
                        swal({
                            title: "Success!",
                            text: response.success,
                            icon: "success",
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON?.error || 'An error occurred while deleting schedules.';
                        swal("Error!", errorMessage, "error");
                    }
                });
            }
        });
    });

    // Clear selection
    $('#clearSelectionBtn').click(function() {
        $('.row-checkbox, #selectAll').prop('checked', false);
        updateBulkActions();
    });

    // Enhanced search functionality with debounce
    const debouncedSearch = debounce(function(value) {
        $('#scheduleTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
        updateSearchStats();
    }, 300);

    $('#searchInput').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        debouncedSearch(value);
    });

    // Table sorting functionality (updated for new column structure)
    $('.sortable').click(function() {
        var table = $('#scheduleTable');
        var rows = table.find('tbody tr:visible').toArray();
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
            
            // Handle numeric values (ID column)
            if (column === 1) {
                aVal = parseInt(aVal.replace('#', ''));
                bVal = parseInt(bVal.replace('#', ''));
                return isAsc ? aVal - bVal : bVal - aVal;
            }
            
            // Handle date values
            if (column === 3) {
                aVal = new Date(aVal);
                bVal = new Date(bVal);
                return isAsc ? aVal - bVal : bVal - aVal;
            }
            
            // Handle time values
            if (column === 4 || column === 5) {
                aVal = new Date('1970/01/01 ' + aVal);
                bVal = new Date('1970/01/01 ' + bVal);
                return isAsc ? aVal - bVal : bVal - aVal;
            }
            
            // Handle text values
            return isAsc ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
        });

        table.find('tbody').empty().append(rows);
    });

    // Enhanced delete confirmation
    $('.dltBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var scheduleId = $(this).data('id');
        var roomName = $(this).data('room-name');
        
        swal({
            title: "Delete Schedule?",
            text: `Are you sure you want to delete the schedule for "${roomName}"? This action cannot be undone.`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn-light",
                },
                confirm: {
                    text: "Delete",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                }
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                swal({
                    title: "Deleting...",
                    text: "Please wait while we process your request.",
                    icon: "info",
                    buttons: false,
                    closeOnClickOutside: false,
                });
                
                form.submit();
            }
        });
    });

    // Search input focus effect
    $('#searchInput').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });

    // Function to update search statistics
    function updateSearchStats() {
        var visibleRows = $('#scheduleTable tbody tr:visible').length;
        var totalRows = $('#scheduleTable tbody tr').length;
        
        if (visibleRows !== totalRows) {
            $('.stats-info').html(`
                <span class="badge badge-info">
                    <i class="fas fa-search me-1"></i>
                    ${visibleRows} of ${totalRows} results
                </span>
            `);
        } else {
            $('.stats-info').html(`
                <span class="badge badge-info">
                    <i class="fas fa-ban me-1"></i>
                    ${totalRows} Unavailable Rooms
                </span>
            `);
        }
    }

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 75) {
            e.preventDefault();
            $('#searchInput').focus();
        }
        
        if (e.keyCode === 27 && $('#searchInput').is(':focus')) {
            $('#searchInput').val('').trigger('keyup');
        }
    });
});

// Quick view modal function
function showScheduleDetails(schedule) {
    var modalContent = `
        <div class="row">
            <div class="col-md-6">
                <strong>Schedule ID:</strong><br>
                <span class="badge bg-primary">#${schedule.id}</span>
            </div>
            <div class="col-md-6">
                <strong>Room:</strong><br>
                <i class="fas fa-door-open me-1"></i> ${schedule.room}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <strong>Date:</strong><br>
                <i class="fas fa-calendar me-1"></i> ${schedule.date}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <strong>Start Time:</strong><br>
                <i class="fas fa-clock me-1"></i> ${schedule.start_time}
            </div>
            <div class="col-md-6">
                <strong>End Time:</strong><br>
                <i class="fas fa-clock me-1"></i> ${schedule.end_time}
            </div>
        </div>
        ${schedule.batch_id ? `
        <hr>
        <div class="row">
            <div class="col-md-12">
                <strong>Batch ID:</strong><br>
                <code>${schedule.batch_id}</code>
            </div>
        </div>
        ` : ''}
    `;
    
    $('#scheduleModalBody').html(modalContent);
    $('#editScheduleBtn').attr('href', `/backend/schedule/${schedule.id}/edit`);
    $('#scheduleModal').modal('show');
}

// Performance optimization: Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endpush