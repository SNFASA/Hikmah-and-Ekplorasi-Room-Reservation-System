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
                    <i class="fas fa-comments me-3"></i>
                    Feedback Management
                </h1>
                <p class="subtitle">View and analyze user feedback and ratings</p>
            </div>
            <div class="header-actions mt-3 mt-lg-0">
                <div class="stats-summary">
                    <span class="summary-item">
                        <i class="fas fa-star text-warning"></i>
                        <span class="ms-1">{{ number_format($feedbacks->avg('rating'), 1) ?? '0.0' }} Avg Rating</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card with Modern Design -->
    <div class="modern-card">
        <div class="card-body p-0">
            @if($feedbacks->isNotEmpty())
                <!-- Search and Filter Section -->
                <div class="search-section p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchInput" class="form-control search-input" placeholder="Search feedback, user, category, or comments...">
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <div class="stats-info">
                                <span class="badge badge-info">
                                    <i class="fas fa-comments me-1"></i>
                                    {{$feedbacks->count()}} Total Feedback
                                </span>
                                <span class="badge badge-success ms-2">
                                    <i class="fas fa-thumbs-up me-1"></i>
                                    {{$feedbacks->where('rating', '>=', 4)->count()}} Positive
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table modern-table" id="feedbackTable">
                            <thead>
                                <tr>
                                    <th class="sortable" data-column="0">
                                        <span>ID</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="1">
                                        <span>Booking No</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="2">
                                        <span>User</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="3">
                                        <span>Rating</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th class="sortable" data-column="4">
                                        <span>Category</span>
                                        <i class="fas fa-sort sort-icon"></i>
                                    </th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feedbacks as $feedback)
                                    <tr class="table-row" data-id="{{$feedback->id}}">
                                        <td class="id-cell">
                                            <span class="id-badge">#{{ $feedback->id }}</span>
                                        </td>
                                        <td class="booking-cell">
                                            @if($feedback->booking)
                                                <div class="booking-info">
                                                    <i class="fas fa-calendar-check me-2 text-primary"></i>
                                                    <span class="booking-number">{{ $feedback->booking->id }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus me-1"></i>
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td class="user-cell">
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="user-details">
                                                    <span class="user-name">{{ $feedback->user->no_matriks ?? 'Unknown' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="rating-cell">
                                            <div class="rating-display">
                                                <div class="stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $feedback->rating ? 'star-filled' : 'star-empty' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="rating-text">{{ $feedback->rating }}/5</span>
                                            </div>
                                        </td>
                                        <td class="category-cell">
                                            <span class="category-badge category-{{ strtolower(str_replace(' ', '-', $feedback->category)) }}">
                                                <i class="fas fa-tag text-primary me-1"></i>
                                                {{ $feedback->category }}
                                            </span>
                                        </td>
                                        <td class="comment-cell">
                                            <div class="comment-content">
                                                @if(strlen($feedback->comment) > 100)
                                                    <span class="comment-text">{{ substr($feedback->comment, 0, 100) }}...</span>
                                                    <button class="btn btn-link btn-sm read-more p-0 ms-1" onclick="toggleComment(this)">
                                                        Read More
                                                    </button>
                                                    <span class="full-comment d-none">{{ $feedback->comment }}</span>
                                                @else
                                                    <span class="comment-text">{{ $feedback->comment }}</span>
                                                @endif
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
                                Showing {{$feedbacks->firstItem()}} to {{$feedbacks->lastItem()}}
                                of {{$feedbacks->total()}} results
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pagination-wrapper">
                                {{ $feedbacks->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State with Better Design -->
                <div class="empty-state">
                    <div class="empty-state-content">
                        <div class="empty-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3 class="empty-title">No Feedback Found</h3>
                        <p class="empty-description">
                            No user feedback has been submitted yet.
                            Feedback will appear here once users start rating their bookings.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    // Enhanced search functionality
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#feedbackTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Table sorting functionality
    $('.sortable').click(function() {
        var table = $('#feedbackTable');
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
            
            // Handle numeric values (for rating and ID)
            if (!isNaN(aVal) && !isNaN(bVal)) {
                return isAsc ? aVal - bVal : bVal - aVal;
            }
            
            // Handle text values
            return isAsc ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
        });

        table.find('tbody').empty().append(rows);
        
        // Re-animate rows
        setTimeout(function() {
            $('#feedbackTable tbody tr').each(function(index) {
                $(this).css('animation-delay', (index * 0.05) + 's');
                $(this).addClass('fadeInUp');
            });
        }, 50);
    });

    // Add smooth transitions for table rows
    $('#feedbackTable tbody tr').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });

    // Search input focus effect
    $('#searchInput').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
});

// Comment expand/collapse functionality
function toggleComment(button) {
    var $button = $(button);
    var $commentText = $button.siblings('.comment-text');
    var $fullComment = $button.siblings('.full-comment');
    
    if ($fullComment.hasClass('d-none')) {
        $commentText.addClass('d-none');
        $fullComment.removeClass('d-none');
        $button.text('Show Less');
    } else {
        $commentText.removeClass('d-none');
        $fullComment.addClass('d-none');
        $button.text('Read More');
    }
}

// Add loading states for better UX
$(window).on('beforeunload', function() {
    $('body').addClass('loading');
});
</script>
@endpush