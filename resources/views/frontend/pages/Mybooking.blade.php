@extends('frontend.layouts.master')
@section('title','My Bookings - PTTA Reservation System')
@section('main-content')
@php
    use Carbon\Carbon;
@endphp

<div class="modern-profile-container">
    <div class="profile-header">
        <div class="container">
            <h2 class="profile-title">
                <i class="fas fa-bookmark me-3"></i>
                My Bookings
            </h2>
            <p class="profile-subtitle">Manage your room reservations and bookings</p>
        </div>
    </div>

    <div class="container py-4">
        <div class="bookings-grid" id="bookingsGrid">
            @forelse($bookingDetails as $booking)
                @php
                    $bookingEnd = Carbon::parse($booking->booking_date . ' ' . $booking->booking_time_end);
                    $isUpcoming = $bookingEnd->isFuture();
                    $bookingStart = Carbon::parse($booking->booking_date . ' ' . $booking->booking_time_start);
                    $duration = $bookingStart->diffInHours($bookingEnd) . 'h ' . ($bookingStart->diffInMinutes($bookingEnd) % 60) . 'm';
                @endphp
                
                <div class="booking-card" data-booking-id="{{ $booking->booking_id }}">
                    <!-- Status Badge -->
                    <div class="booking-status-badge {{ $isUpcoming ? 'status-upcoming' : 'status-completed' }}">
                        <i class="fas {{ $isUpcoming ? 'fa-clock' : 'fa-check-circle' }}"></i>
                        {{ $isUpcoming ? 'Upcoming' : 'Completed' }}
                    </div>
                    
                    <!-- Room Image/Icon -->
                    <div class="booking-image">
                        <div class="room-icon-container">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="booking-date-overlay">
                            <span class="date-day">{{ Carbon::parse($booking->booking_date)->format('d') }}</span>
                            <span class="date-month">{{ Carbon::parse($booking->booking_date)->format('M') }}</span>
                        </div>
                    </div>
                    
                    <div class="booking-content">
                        <h3 class="booking-room-title">{{ $booking->room_name }}</h3>
                        
                        <div class="booking-info">
                            <div class="booking-detail">
                                <i class="fas fa-calendar-alt booking-detail-icon"></i>
                                <span class="booking-detail-text">
                                    <strong>Date:</strong> {{ Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                </span>
                            </div>
                            
                            <div class="booking-detail">
                                <i class="fas fa-clock booking-detail-icon"></i>
                                <span class="booking-detail-text">
                                    <strong>Time:</strong> {{ $booking->booking_time_start }} - {{ $booking->booking_time_end }}
                                </span>
                            </div>
                            
                            <div class="booking-detail">
                                <i class="fas fa-hourglass-half booking-detail-icon"></i>
                                <span class="booking-detail-text">
                                    <strong>Duration:</strong> {{ $duration }}
                                </span>
                            </div>
                            
                            <div class="booking-detail participants-detail">
                                <i class="fas fa-users booking-detail-icon"></i>
                                <div class="booking-detail-text">
                                    <strong>Participants:</strong>
                                    <div class="participants-badges">
                                        @foreach($booking->students as $student)
                                            <span class="participant-badge">{{ $student }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="booking-actions">
                            @if ($isUpcoming)
                                <!-- Future booking: Show Cancel and Edit -->
                                <button class="btn-booking-action btn-cancel" onclick="confirmCancelBooking({{ $booking->booking_id }})">
                                    <i class="fas fa-times-circle"></i>
                                    Cancel
                                </button>
                                
                                <a href="{{ route('booking.edit', $booking->booking_id) }}" class="btn-booking-action btn-edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                            @else
                                <!-- Past booking: Show Feedback and Delete -->
                                <a href="{{ route('frontend.pages.feedbackcreate', ['booking_id' => $booking->booking_id]) }}" class="btn-booking-action btn-feedback">
                                    <i class="fas fa-comment-dots"></i>
                                    Feedback
                                </a>
                                
                                <button class="btn-booking-action btn-delete" onclick="confirmDeleteBooking({{ $booking->booking_id }})">
                                    <i class="fas fa-trash-alt"></i>
                                    Delete
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-bookings">
                    <div class="empty-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3 class="empty-title">No Bookings Found</h3>
                    <p class="empty-description">You don't have any room reservations yet. Start by booking a room!</p>
                    <a href="{{ route('home') }}" class="btn-empty-action">
                        <i class="fas fa-plus-circle me-2"></i>
                        Book a Room
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="confirmation-modal">
    <div class="confirmation-backdrop"></div>
    <div class="confirmation-dialog">
        <div class="confirmation-header">
            <i class="fas fa-exclamation-triangle"></i>
            <h4 id="confirmationTitle">Confirm Action</h4>
        </div>
        <div class="confirmation-body">
            <p id="confirmationMessage">Are you sure you want to perform this action?</p>
        </div>
        <div class="confirmation-actions">
            <button class="btn-confirmation btn-cancel-confirm" onclick="closeConfirmationModal()">
                <i class="fas fa-times"></i>
                Cancel
            </button>
            <button class="btn-confirmation btn-confirm" id="confirmButton">
                <i class="fas fa-check"></i>
                Confirm
            </button>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
// Global variables for confirmation modal
let currentBookingId = null;
let currentAction = null;

// Show confirmation modal
function showConfirmationModal(title, message, action, bookingId) {
    currentBookingId = bookingId;
    currentAction = action;
    
    document.getElementById('confirmationTitle').textContent = title;
    document.getElementById('confirmationMessage').textContent = message;
    document.getElementById('confirmationModal').classList.add('show');
    document.body.style.overflow = 'hidden';
    
    // Set up confirm button
    const confirmBtn = document.getElementById('confirmButton');
    confirmBtn.onclick = function() {
        if (currentAction === 'cancel') {
            performCancelBooking(currentBookingId);
        } else if (currentAction === 'delete') {
            performDeleteBooking(currentBookingId);
        }
    };
}

// Close confirmation modal
function closeConfirmationModal() {
    document.getElementById('confirmationModal').classList.remove('show');
    document.body.style.overflow = '';
    currentBookingId = null;
    currentAction = null;
}

// Confirm cancel booking
function confirmCancelBooking(bookingId) {
    showConfirmationModal(
        'Cancel Booking',
        'Are you sure you want to cancel this booking? This action cannot be undone.',
        'cancel',
        bookingId
    );
}

// Confirm delete booking (UI only)
function confirmDeleteBooking(bookingId) {
    showConfirmationModal(
        'Delete Booking',
        'Are you sure you want to remove this booking from your view? This will only hide it from your interface.',
        'delete',
        bookingId
    );
}

// Perform actual cancel booking (redirects to backend)
function performCancelBooking(bookingId) {
    // Create and submit form for backend cancellation
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/cancel-booking/${bookingId}`;
    
    // Add CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Add method override
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    
    form.appendChild(csrfToken);
    form.appendChild(methodField);
    document.body.appendChild(form);
    
    closeConfirmationModal();
    form.submit();
}

// Perform delete booking (UI only)
function performDeleteBooking(bookingId) {
    const bookingCard = document.querySelector(`[data-booking-id="${bookingId}"]`);
    
    if (bookingCard) {
        bookingCard.classList.add('removing');
        
        setTimeout(() => {
            bookingCard.remove();
            
            // Check if no bookings left
            const remainingCards = document.querySelectorAll('.booking-card:not(.removing)');
            if (remainingCards.length === 0) {
                showEmptyState();
            }
        }, 500);
    }
    
    closeConfirmationModal();
}

// Show empty state when all bookings are deleted
function showEmptyState() {
    const bookingsGrid = document.getElementById('bookingsGrid');
    bookingsGrid.innerHTML = `
        <div class="empty-bookings">
            <div class="empty-icon">
                <i class="fas fa-calendar-times"></i>
            </div>
            <h3 class="empty-title">No Bookings Found</h3>
            <p class="empty-description">You don't have any room reservations to display.</p>
            <a href="${window.location.origin}/room" class="btn-empty-action">
                <i class="fas fa-plus-circle me-2"></i>
                Book a Room
            </a>
        </div>
    `;
}

// Close modal when clicking backdrop
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('confirmation-backdrop')) {
        closeConfirmationModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('confirmationModal').classList.contains('show')) {
        closeConfirmationModal();
    }
});

// Add stagger animation to cards on load
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.booking-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endpush