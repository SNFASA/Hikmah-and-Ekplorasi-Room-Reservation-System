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
                    <i class="fas fa-users me-3"></i>
                    User Management
                </h1>
                <p class="subtitle">Manage all users and their information</p>
            </div>
            <div class="header-actions mt-3 mt-lg-0">
                <a href="{{ route('users.create') }}" class="btn btn-create">
                    <i class="fas fa-plus me-2"></i>
                    <span>Add User</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Card with Modern Design -->
    <div class="modern-card">
        <div class="card-body p-0">
            @if(count($users) > 0)
                <!-- Search and Filter Section -->
                <div class="search-section p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchInput" class="form-control search-input" placeholder="Search users, email, faculty, or role...">
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <div class="stats-info">
                                <span class="badge badge-info">
                                    <i class="fas fa-users me-1"></i>
                                    {{$totalUsers}} Total Users
                                </span>
                                <span class="badge badge-primary ms-2">
                                    <i class="fas fa-user-check me-1"></i>
                                    {{$userCount}} Users
                                </span>
                                <span class="badge badge-secondary ms-2">
                                    <i class="fas fa-user-tie me-1"></i>
                                    {{$pppCount}} PPP
                                </span>
                                <span class="badge badge-warning ms-2">
                                    <i class="fas fa-user-tie me-1"></i>
                                    {{$adminCount}} Admins
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table modern-table" id="userTable">
                            <thead>
                                <tr>
                                    <th class="sortable" data-column="0">
                                        <span>S.N.</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="1">
                                        <span>No Matriks</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="2">
                                        <span>Name</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="3">
                                        <span>Email</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="4">
                                        <span>Faculty/Department</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="5">
                                        <span>Course</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="6">
                                        <span>Role</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    @php
                                        $faculty = DB::table('faculty_offices')->where('no_facultyOffice', $user->facultyOffice)->value('name'); 
                                        $course = DB::table('courses')->where('no_course', $user->course)->value('name');
                                    @endphp
                                    <tr class="table-row" data-id="{{$user->id}}">
                                        <td class="id-cell">
                                            <span class="id-badge">#{{ $user->id }}</span>
                                        </td>
                                        <td class="matriks-cell">
                                            <div class="matriks-info">
                                                <i class="fas fa-id-card me-2 text-primary"></i>
                                                <span class="matriks-number">{{ $user->no_matriks }}</span>
                                            </div>
                                        </td>
                                        <td class="user-cell">
                                            <div class="user-info">
                                                <i class="fas fa-user me-2 text-success"></i>
                                                <span class="user-name">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="email-cell">
                                            <div class="email-info">
                                                <i class="fas fa-envelope me-2 text-info"></i>
                                                <span class="email-address">{{ $user->email }}</span>
                                            </div>
                                        </td>
                                        <td class="faculty-cell">
                                            @if($faculty)
                                                <span class="faculty-badge">
                                                    <i class="fas fa-building me-1"></i>
                                                    {{ $faculty }}
                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus me-1"></i>
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td class="course-cell">
                                            @if($course)
                                                <span class="course-badge">
                                                    <i class="fas fa-graduation-cap me-1"></i>
                                                    {{ $course }}
                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus me-1"></i>
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td class="role-cell">
                                            <span class="role-badge role-{{ strtolower($user->role) }}">
                                                <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : 'user-graduate' }} me-1"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="action-cell">
                                            <div class="action-buttons">
                                                <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button"
                                                            class="action-btn delete-btn dltBtn"
                                                            data-id="{{ $user->id }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Delete User">
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
                                Showing {{$users->firstItem()}} to {{$users->lastItem()}}
                                of {{$users->total()}} results
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pagination-wrapper">
                                {{ $users->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State with Better Design -->
                <div class="empty-state">
                    <div class="empty-state-content">
                        <div class="empty-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="empty-title">No Users Found</h3>
                        <p class="empty-description">
                            Get started by creating your first user account.
                            You can add user details, assign roles, and manage permissions.
                        </p>
                        <a href="{{ route('users.create') }}" class="btn btn-create">
                            <i class="fas fa-plus me-2"></i>
                            Create User
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
        $('#userTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Table sorting functionality
    $('.sortable').click(function() {
        var table = $('#userTable');
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
            $('#userTable tbody tr').each(function(index) {
                $(this).css('animation-delay', (index * 0.05) + 's');
                $(this).addClass('fadeInUp');
            });
        }, 50);
    });

    // Enhanced delete confirmation
    $('.dltBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var userId = $(this).data('id');
        
        swal({
            title: "Delete User?",
            text: "This action cannot be undone. The user and all associated data will be permanently deleted.",
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
    $('#userTable tbody tr').each(function(index) {
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