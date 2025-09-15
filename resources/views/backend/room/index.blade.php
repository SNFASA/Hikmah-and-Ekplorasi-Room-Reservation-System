@extends('backend.layouts.master')
@section('title','PTTA Reservation System')
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
                    <i class="fas fa-door-open me-3"></i>
                    Room Management
                </h1>
                <p class="subtitle">Manage all rooms and their configurations</p>
            </div>
            <div class="header-actions mt-3 mt-lg-0">
                <a href="{{route('room.create')}}" class="btn btn-create">
                    <i class="fas fa-plus me-2"></i>
                    <span>Add Room</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Card with Modern Design -->
    <div class="modern-card">
        <div class="card-body p-0">
            @if(count($rooms) > 0)
                <!-- Search and Filter Section -->
                <div class="search-section p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchInput" class="form-control search-input" placeholder="Search rooms, capacity, type, or status...">
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <div class="stats-info">
                                <span class="badge badge-info">
                                    <i class="fas fa-door-open me-1"></i>
                                    {{$rooms->count()}} Total Rooms
                                </span>
                                <span class="badge badge-success ms-2">
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{$rooms->where('status', 'valid')->count()}} Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table modern-table" id="roomTable">
                            <thead>
                                <tr>
                                    <th class="sortable" data-column="0">
                                        <span>Room No.</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="1">
                                        <span>Name</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="2">
                                        <span>Capacity</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="3">
                                        <span>Type</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th>Furniture</th>
                                    <th>Electronics</th>
                                    <th class="sortable" data-column="6">
                                        <span>Status</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                    <tr class="table-row" data-id="{{$room->no_room}}">
                                        <td class="id-cell">
                                            <span class="id-badge">#{{$room->no_room}}</span>
                                        </td>
                                        <td class="room-cell">
                                            <div class="room-info">
                                                <i class="fas fa-door-open me-2 text-primary"></i>
                                                <span class="room-name">{{ $room->name }}</span>
                                            </div>
                                        </td>
                                        <td class="capacity-cell">
                                            <span class="capacity-badge">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $room->capacity }}
                                            </span>
                                        </td>
                                        <td class="type-cell">
                                            @if($room->type)
                                                <span class="type-badge">
                                                    <i class="fas fa-tag me-1"></i>
                                                    {{ $room->type->name }}
                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus me-1"></i>
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td class="furniture-cell">
                                            @if($room->furnitures->isNotEmpty())
                                                <div class="items-list">
                                                    @foreach($room->furnitures->take(2) as $furniture)
                                                        <span class="item-tag">{{ $furniture->name }}</span>
                                                    @endforeach
                                                    @if($room->furnitures->count() > 2)
                                                        <span class="more-items">+{{ $room->furnitures->count() - 2 }} more</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus me-1"></i>
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td class="electronics-cell">
                                            @if($room->electronics->isNotEmpty())
                                                <div class="items-list">
                                                    @foreach($room->electronics->take(2) as $electronic)
                                                        <span class="item-tag">{{ $electronic->name }}</span>
                                                    @endforeach
                                                    @if($room->electronics->count() > 2)
                                                        <span class="more-items">+{{ $room->electronics->count() - 2 }} more</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus me-1"></i>
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td class="status-cell">
                                            <span class="status-badge status-{{ $room->status === 'valid' ? 'success' : 'warning' }}">
                                                <i class="fas fa-{{ $room->status === 'valid' ? 'check-circle' : 'exclamation-triangle' }} me-1"></i>
                                                {{ ucfirst($room->status) }}
                                            </span>
                                        </td>
                                        <td class="action-cell">
                                            <div class="action-buttons">
                                                <a href="{{ route('room.edit', $room->no_room) }}"
                                                   class="action-btn edit-btn"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   title="Edit Room">
                                                   <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('room.destroy', $room->no_room) }}" class="d-inline">
                                                    @csrf 
                                                    @method('delete')
                                                    <button type="button"
                                                            class="action-btn delete-btn dltBtn"
                                                            data-id="{{ $room->no_room }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Delete Room">
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
                                Showing {{$rooms->firstItem()}} to {{$rooms->lastItem()}}
                                of {{$rooms->total()}} results
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pagination-wrapper">
                                {{ $rooms->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State with Better Design -->
                <div class="empty-state">
                    <div class="empty-state-content">
                        <div class="empty-icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <h3 class="empty-title">No Rooms Found</h3>
                        <p class="empty-description">
                            Get started by creating your first room.
                            You can add room details, capacity, and amenities.
                        </p>
                        <a href="{{route('room.create')}}" class="btn btn-create">
                            <i class="fas fa-plus me-2"></i>
                            Create Room
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
        $('#roomTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Table sorting functionality
    $('.sortable').click(function() {
        var table = $('#roomTable');
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
            $('#roomTable tbody tr').each(function(index) {
                $(this).css('animation-delay', (index * 0.05) + 's');
                $(this).addClass('fadeInUp');
            });
        }, 50);
    });

    // Enhanced delete confirmation
    $('.dltBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var roomId = $(this).data('id');
        
        swal({
            title: "Delete Room?",
            text: "This action cannot be undone. The room and all its data will be permanently deleted.",
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
    $('#roomTable tbody tr').each(function(index) {
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