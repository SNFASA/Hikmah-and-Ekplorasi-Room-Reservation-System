@extends('frontend.layouts.master')
@section('title', 'Edit Feedback - PTTA Reservation System')
@section('main-content')
@php
    use Carbon\Carbon;
@endphp

<div class="modern-profile-container">
    <div class="profile-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="profile-title">
                        <i class="fas fa-edit me-3"></i>
                        Edit Feedback
                    </h2>
                    <p class="profile-subtitle">Update your experience and help us improve our service</p>
                </div>
                <a href="{{ route('my.bookings') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Bookings
                </a>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Booking Info Card -->
                <div class="info-card mb-4">
                    <div class="info-card-header">
                        <i class="fas fa-info-circle"></i>
                        <h4>Booking Information</h4>
                    </div>
                    <div class="info-card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-detail">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Booking Date</small>
                                        <div class="info-value">{{ Carbon::parse($booking->booking_date)->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-detail">
                                    <div class="info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Time</small>
                                        <div class="info-value">{{ $booking->booking_time_start }} - {{ $booking->booking_time_end }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-detail">
                                    <div class="info-icon">
                                        <i class="fas fa-door-open"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Room</small>
                                        <div class="info-value">{{ $booking->room->name }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-detail">
                                    <div class="info-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Phone Number</small>
                                        <div class="info-value">{{ $booking->phone_number }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="info-detail">
                                    <div class="info-icon">
                                        <i class="fas fa-bullseye"></i>
                                    </div>
                                    <div class="info-content">
                                        <small class="info-label">Purpose</small>
                                        <div class="info-value">{{ $booking->purpose }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Feedback Card -->
                <div class="feedback-card">
                    <div class="feedback-card-header edit-header">
                        <i class="fas fa-edit"></i>
                        <h4>Update Your Feedback</h4>
                    </div>
                    
                    <div class="feedback-card-body">
                        <form action="{{ route('feedback.update', $feedback->id) }}" method="POST" class="feedback-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                            <!-- Current Feedback Notice -->
                            <div class="current-feedback-notice">
                                <div class="notice-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="notice-content">
                                    <h6>Current Feedback</h6>
                                    <p>You can modify your rating, comment, and damage reports below. Changes will be saved when you submit.</p>
                                </div>
                            </div>

                            <!-- Rating Section -->
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-star-half-alt"></i>
                                    <h5>Update Your Rating</h5>
                                    <p>How would you rate your overall experience?</p>
                                </div>
                                
                                <div class="rating-container">
                                    <div id="starRating" class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star star {{ $feedback->rating >= $i ? 'selected' : '' }}" data-value="{{ $i }}"></i>
                                        @endfor
                                    </div>
                                    <div class="rating-text selected" id="ratingText">
                                        @switch($feedback->rating)
                                            @case(1) Poor - Needs major improvement @break
                                            @case(2) Fair - Below expectations @break
                                            @case(3) Good - Meets expectations @break
                                            @case(4) Very Good - Above expectations @break
                                            @case(5) Excellent - Outstanding experience @break
                                            @default Click to rate @break
                                        @endswitch
                                    </div>
                                    <input type="hidden" name="rating" id="rating" value="{{ $feedback->rating }}" required>
                                </div>
                            </div>

                            <!-- Comment Section -->
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-comment"></i>
                                    <h5>Update Your Comments</h5>
                                    <p>Share your thoughts, suggestions, or any issues you encountered (optional)</p>
                                </div>
                                
                                <div class="textarea-container">
                                    <textarea name="comment" id="comment" class="form-textarea" rows="4" placeholder="Describe your experience, any suggestions for improvement, or issues you encountered...">{{ old('comment', $feedback->comment) }}</textarea>
                                    <div class="textarea-counter">
                                        <span id="charCount">{{ strlen(old('comment', $feedback->comment)) }}</span>/500 characters
                                    </div>
                                </div>
                            </div>

                            <!-- Damage Report Section -->
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <h5>Update Damage Reports</h5>
                                    <p>Please check any items that were damaged or not working properly</p>
                                </div>
                                
                                <div class="equipment-grid">
                                    @if($booking->room->furnitures->count() > 0)
                                        <div class="equipment-category">
                                            <h6 class="category-title">
                                                <i class="fas fa-couch"></i>
                                                Furniture
                                            </h6>
                                            <div class="equipment-items">
                                                @foreach($booking->room->furnitures as $item)
                                                    <div class="equipment-item">
                                                        <input class="equipment-checkbox" type="checkbox" name="damaged_furnitures[]" value="{{ $item->no_furniture }}" id="furniture{{ $item->no_furniture }}">
                                                        <label class="equipment-label" for="furniture{{ $item->no_furniture }}">
                                                            <div class="equipment-icon">🪑</div>
                                                            <div class="equipment-info">
                                                                <div class="equipment-name">{{ $item->name }}</div>
                                                                
                                                            </div>
                                                            <div class="checkbox-indicator"></div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($booking->room->electronics->count() > 0)
                                        <div class="equipment-category">
                                            <h6 class="category-title">
                                                <i class="fas fa-laptop"></i>
                                                Electronics
                                            </h6>
                                            <div class="equipment-items">
                                                @foreach($booking->room->electronics as $item)
                                                    <div class="equipment-item">
                                                        <input class="equipment-checkbox" type="checkbox" name="damaged_electronics[]" value="{{ $item->no_electronicEquipment }}" id="electronic{{ $item->no_electronicEquipment }}">
                                                        <label class="equipment-label" for="electronic{{ $item->no_electronicEquipment }}">
                                                            <div class="equipment-icon">💻</div>
                                                            <div class="equipment-info">
                                                                <div class="equipment-name">{{ $item->name }}</div>
                                                                
                                                            </div>
                                                            <div class="checkbox-indicator"></div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-actions">
                                <button type="submit" class="btn-submit" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>
                                    Update Feedback
                                    <div class="btn-loading">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Star Rating Functionality
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    const submitBtn = document.getElementById('submitBtn');
    
    let selectedRating = parseInt(ratingInput.value) || 0;
    
    const ratingTexts = {
        1: 'Poor - Needs major improvement',
        2: 'Fair - Below expectations',
        3: 'Good - Meets expectations',
        4: 'Very Good - Above expectations',
        5: 'Excellent - Outstanding experience'
    };

    function highlightStars(rating) {
        stars.forEach(star => {
            const value = parseInt(star.getAttribute('data-value'));
            star.classList.toggle('selected', value <= rating);
        });
    }

    function updateRatingText(rating) {
        if (rating > 0) {
            ratingText.textContent = ratingTexts[rating];
            ratingText.classList.add('selected');
        } else {
            ratingText.textContent = 'Click to rate';
            ratingText.classList.remove('selected');
        }
    }

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const value = parseInt(star.getAttribute('data-value'));
            highlightStars(value);
            updateRatingText(value);
        });

        star.addEventListener('mouseout', () => {
            highlightStars(selectedRating);
            updateRatingText(selectedRating);
        });

        star.addEventListener('click', () => {
            selectedRating = parseInt(star.getAttribute('data-value'));
            ratingInput.value = selectedRating;
            highlightStars(selectedRating);
            updateRatingText(selectedRating);
            
            // Add animation effect
            stars.forEach(s => s.style.transform = 'scale(1.2)');
            setTimeout(() => {
                stars.forEach(s => s.style.transform = 'scale(1)');
            }, 200);
        });
    });

    // Initial setup
    highlightStars(selectedRating);
    updateRatingText(selectedRating);
    
    // Character Counter for Comment
    const commentTextarea = document.getElementById('comment');
    const charCount = document.getElementById('charCount');
    
    if (commentTextarea && charCount) {
        // Set initial count
        const initialCount = commentTextarea.value.length;
        charCount.textContent = initialCount;
        
        commentTextarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            // Change color based on character count
            if (count > 450) {
                charCount.style.color = '#dc3545';
            } else if (count > 400) {
                charCount.style.color = '#ffc107';
            } else {
                charCount.style.color = '#6c757d';
            }
            
            // Limit to 500 characters
            if (count > 500) {
                this.value = this.value.substring(0, 500);
                charCount.textContent = '500';
            }
        });
    }
    
    // Form Submission with Loading State
    const feedbackForm = document.querySelector('.feedback-form');
    if (feedbackForm && submitBtn) {
        feedbackForm.addEventListener('submit', function(e) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            // Re-enable if form submission fails (fallback)
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }, 5000);
        });
    }
    
    // Equipment Selection Animation
    const equipmentCheckboxes = document.querySelectorAll('.equipment-checkbox');
    equipmentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.checked) {
                label.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    label.style.transform = 'scale(1)';
                }, 100);
            }
        });
    });
    
    // Form Change Detection
    let formChanged = false;
    const formElements = feedbackForm.querySelectorAll('input, textarea, select');
    
    formElements.forEach(element => {
        element.addEventListener('change', function() {
            formChanged = true;
        });
    });
    
    // Warn user about unsaved changes when leaving page
    window.addEventListener('beforeunload', function(e) {
        if (formChanged && !submitBtn.classList.contains('loading')) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    });
    
    // Reset form changed flag when submitting
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', function() {
            formChanged = false;
        });
    }
});
</script>
@endpush