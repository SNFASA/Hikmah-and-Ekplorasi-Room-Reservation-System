@extends('frontend.layouts.master')
@section('title','Send Feedback - PTTA Reservation System')
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
                        <i class="fas fa-comment-dots me-3"></i>
                        Send Feedback
                    </h2>
                    <p class="profile-subtitle">Share your experience and help us improve our service</p>
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

                <!-- Feedback Card -->
                <div class="feedback-card">
                    <div class="feedback-card-header">
                        <i class="fas fa-star"></i>
                        <h4>Your Feedback</h4>
                    </div>
                    
                    <div class="feedback-card-body">
                        @if (!$feedback)
                            <form action="{{ route('feedback.store') }}" method="POST" class="feedback-form">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                <!-- Rating Section -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-star-half-alt"></i>
                                        <h5>Rate Your Experience</h5>
                                        <p>How would you rate your overall experience?</p>
                                    </div>
                                    
                                    <div class="rating-container">
                                        <div id="starRating" class="star-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star star" data-value="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                        <div class="rating-text" id="ratingText">Click to rate</div>
                                        <input type="hidden" name="rating" id="rating" required>
                                    </div>
                                </div>

                                <!-- Comment Section -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-comment"></i>
                                        <h5>Additional Comments</h5>
                                        <p>Share your thoughts, suggestions, or any issues you encountered (optional)</p>
                                    </div>
                                    
                                    <div class="textarea-container">
                                        <textarea name="comment" id="comment" class="form-textarea" rows="4" placeholder="Describe your experience, any suggestions for improvement, or issues you encountered..."></textarea>
                                        <div class="textarea-counter">
                                            <span id="charCount">0</span>/500 characters
                                        </div>
                                    </div>
                                </div>

                                <!-- Damage Report Section -->
                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <h5>Report Damaged Equipment</h5>
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
                                                    @foreach($booking->room->furnitures as $furniture)
                                                        <div class="equipment-item">
                                                            <input class="equipment-checkbox" type="checkbox" name="damaged_furnitures[]" value="{{ $furniture->no_furniture }}" id="furniture{{ $furniture->no_furniture }}">
                                                            <label class="equipment-label" for="furniture{{ $furniture->no_furniture }}">
                                                                <div class="equipment-icon">🪑</div>
                                                                <div class="equipment-info">
                                                                    <div class="equipment-name">{{ $furniture->name }}</div>
                                                                    
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
                                    <button type="submit" class="btn-submit" id="submitBtn" disabled>
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Submit Feedback
                                        <div class="btn-loading">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Existing Feedback Display -->
                            <div class="existing-feedback">
                                <div class="feedback-status">
                                    <div class="status-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="status-content">
                                        <h5>Feedback Submitted</h5>
                                        <p>Thank you for sharing your experience with us!</p>
                                    </div>
                                </div>
                                
                                <div class="feedback-display">
                                    <div class="feedback-rating">
                                        <h6>Your Rating</h6>
                                        <div class="display-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $feedback->rating ? 'star-filled' : 'star-empty' }}"></i>
                                            @endfor
                                            <span class="rating-number">({{ $feedback->rating }}/5)</span>
                                        </div>
                                    </div>
                                    
                                    @if($feedback->comment)
                                        <div class="feedback-comment">
                                            <h6>Your Comment</h6>
                                            <div class="comment-text">{{ $feedback->comment }}</div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="feedback-actions">
                                    <a href="{{ route('frontend.pages.feedbackedit', $feedback->id) }}" class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i>
                                        Edit Feedback
                                    </a>
                                    
                                    <button class="btn-action btn-delete" onclick="confirmDeleteFeedback()">
                                        <i class="fas fa-trash"></i>
                                        Delete Feedback
                                    </button>
                                    
                                    <!-- Hidden form for deletion -->
                                    <form id="deleteFeedbackForm" action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="confirmation-modal">
    <div class="confirmation-backdrop"></div>
    <div class="confirmation-dialog">
        <div class="confirmation-header">
            <i class="fas fa-trash-alt"></i>
            <h4>Delete Feedback</h4>
        </div>
        <div class="confirmation-body">
            <p>Are you sure you want to delete your feedback? This action cannot be undone.</p>
        </div>
        <div class="confirmation-actions">
            <button class="btn-confirmation btn-cancel-confirm" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
                Cancel
            </button>
            <button class="btn-confirmation btn-confirm" onclick="deleteFeedback()">
                <i class="fas fa-trash"></i>
                Delete
            </button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Modern Profile Container */
.modern-profile-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
}

.profile-header {
    background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="0,0 1000,0 1000,60 0,100"/></svg>');
    background-size: cover;
    background-position: bottom;
}

.profile-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.profile-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
    position: relative;
    z-index: 1;
}

.btn-back {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    position: relative;
    z-index: 1;
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(255, 255, 255, 0.2);
}

/* Info Card */
.info-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(26, 22, 96, 0.1);
    border: 2px solid rgba(26, 22, 96, 0.08);
    overflow: hidden;
    animation: slideInUp 0.6s ease;
}

.info-card-header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.info-card-header h4 {
    margin: 0;
    font-weight: 700;
}

.info-card-body {
    padding: 2rem;
}

.info-detail {
    background: #f8f9ff;
    border-radius: 15px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 2px solid rgba(26, 22, 96, 0.05);
    transition: all 0.3s ease;
}

.info-detail:hover {
    border-color: rgba(26, 22, 96, 0.1);
    box-shadow: 0 3px 15px rgba(26, 22, 96, 0.08);
}

.info-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
    min-width: 0;
}

.info-label {
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    color: #1a1660;
    font-weight: 700;
    font-size: 1rem;
    word-break: break-word;
}

/* Feedback Card */
.feedback-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(26, 22, 96, 0.1);
    border: 2px solid rgba(26, 22, 96, 0.08);
    overflow: hidden;
    animation: slideInUp 0.6s ease 0.2s both;
}

.feedback-card-header {
    background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.feedback-card-header h4 {
    margin: 0;
    font-weight: 700;
}

.feedback-card-body {
    padding: 2rem;
}

/* Form Sections */
.form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid rgba(26, 22, 96, 0.08);
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 1rem;
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.section-header i {
    font-size: 2rem;
    color: #1a1660;
    margin-bottom: 1rem;
}

.section-header h5 {
    color: #1a1660;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
}

.section-header p {
    color: #6c757d;
    margin: 0;
    font-size: 0.95rem;
}

/* Star Rating */
.rating-container {
    text-align: center;
}

.star-rating {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.star {
    font-size: 2.5rem;
    color: #dee2e6;
    cursor: pointer;
    transition: all 0.3s ease;
    transform-origin: center;
}

.star:hover {
    transform: scale(1.1);
}

.star.selected,
.star.hover {
    color: #ffc107;
    text-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
}

.rating-text {
    color: #6c757d;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.rating-text.selected {
    color: #1a1660;
    font-weight: 700;
}

/* Textarea */
.textarea-container {
    position: relative;
}

.form-textarea {
    width: 100%;
    padding: 1rem 1.5rem;
    border: 2px solid #dee2e6;
    border-radius: 15px;
    font-size: 1rem;
    resize: vertical;
    min-height: 120px;
    transition: all 0.3s ease;
    font-family: inherit;
    background: #fafbff;
}

.form-textarea:focus {
    outline: none;
    border-color: #1a1660;
    box-shadow: 0 0 0 0.2rem rgba(26, 22, 96, 0.25);
    background: white;
}

.textarea-counter {
    position: absolute;
    bottom: 0.5rem;
    right: 1rem;
    color: #6c757d;
    font-size: 0.8rem;
    background: rgba(255, 255, 255, 0.9);
    padding: 0.2rem 0.5rem;
    border-radius: 5px;
}

/* Equipment Grid */
.equipment-grid {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.equipment-category {
    background: #f8f9ff;
    border-radius: 15px;
    padding: 1.5rem;
    border: 2px solid rgba(26, 22, 96, 0.05);
}

.category-title {
    color: #1a1660;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.equipment-items {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
}

.equipment-item {
    position: relative;
}

.equipment-checkbox {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.equipment-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border: 2px solid #dee2e6;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.equipment-label:hover {
    border-color: #1a1660;
    box-shadow: 0 3px 15px rgba(26, 22, 96, 0.1);
    transform: translateY(-2px);
}

.equipment-checkbox:checked + .equipment-label {
    border-color: #dc3545;
    background: linear-gradient(135deg, #fff5f5 0%, #ffeaea 100%);
}

.equipment-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.equipment-info {
    flex: 1;
    min-width: 0;
}

.equipment-name {
    font-weight: 600;
    color: #1a1660;
    margin-bottom: 0.25rem;
}

.equipment-category-name {
    font-size: 0.85rem;
    color: #6c757d;
}

.checkbox-indicator {
    width: 20px;
    height: 20px;
    border: 2px solid #dee2e6;
    border-radius: 4px;
    position: relative;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.equipment-checkbox:checked + .equipment-label .checkbox-indicator {
    background: #dc3545;
    border-color: #dc3545;
}

.equipment-checkbox:checked + .equipment-label .checkbox-indicator::after {
    content: '✓';
    position: absolute;
    top: -2px;
    left: 2px;
    color: white;
    font-weight: bold;
    font-size: 0.9rem;
}

/* Submit Button */
.form-actions {
    text-align: center;
    margin-top: 2rem;
}

.btn-submit {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    position: relative;
    min-width: 200px;
    justify-content: center;
    box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
}

.btn-submit:hover:not(:disabled) {
    background: linear-gradient(135deg, #218838 0%, #1ea899 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(40, 167, 69, 0.4);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-loading {
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    background: inherit;
    border-radius: inherit;
}

.btn-submit.loading .btn-loading {
    display: flex;
}

.btn-submit.loading > *:not(.btn-loading) {
    opacity: 0;
}

/* Existing Feedback Display */
.existing-feedback {
    text-align: center;
}

.feedback-status {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-radius: 15px;
    border: 2px solid #28a745;
}

.status-icon {
    width: 50px;
    height: 50px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.status-content h5 {
    color: #155724;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.status-content p {
    color: #155724;
    margin: 0;
}

.feedback-display {
    margin-bottom: 2rem;
}

.feedback-rating {
    margin-bottom: 2rem;
}

.feedback-rating h6 {
    color: #1a1660;
    font-weight: 700;
    margin-bottom: 1rem;
}

.display-stars {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.star-filled {
    color: #ffc107;
    font-size: 1.5rem;
}

.star-empty {
    color: #dee2e6;
    font-size: 1.5rem;
}

.rating-number {
    color: #6c757d;
    font-weight: 600;
    margin-left: 1rem;
}

.feedback-comment h6 {
    color: #1a1660;
    font-weight: 700;
    margin-bottom: 1rem;
}

.comment-text {
    background: #f8f9ff;
    padding: 1.5rem;
    border-radius: 15px;
    border: 2px solid rgba(26, 22, 96, 0.08);
    color: #495057;
    line-height: 1.6;
    text-align: left;
}

.feedback-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-action {
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-edit {
    background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
    color: white;
    box-shadow: 0 3px 15px rgba(26, 22, 96, 0.3);
}

.btn-edit:hover {
    background: linear-gradient(135deg, #141050 0%, #252269 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(26, 22, 96, 0.4);
}

.btn-delete {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    color: #dc3545;
    border: 2px solid #dc3545;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(220, 53, 69, 0.3);
}

/* Confirmation Modal */
.confirmation-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: none;
    animation: fadeIn 0.3s ease;
}

.confirmation-modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.confirmation-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.confirmation-dialog {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-width: 400px;
    width: 90%;
    position: relative;
    z-index: 10;
    animation: slideInDown 0.3s ease;
}

.confirmation-header {
    padding: 1.5rem 2rem 1rem;
    text-align: center;
    border-bottom: 2px solid rgba(26, 22, 96, 0.08);
}

.confirmation-header i {
    font-size: 3rem;
    color: #dc3545;
    margin-bottom: 1rem;
}

.confirmation-header h4 {
    color: #1a1660;
    font-weight: 700;
    margin: 0;
}

.confirmation-body {
    padding: 1.5rem 2rem;
    text-align: center;
}

.confirmation-body p {
    color: #495057;
    margin: 0;
    line-height: 1.5;
}

.confirmation-actions {
    padding: 1rem 2rem 2rem;
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-confirmation {
    flex: 1;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-cancel-confirm {
    background: #f8f9fa;
    color: #6c757d;
    border: 2px solid #dee2e6;
}

.btn-cancel-confirm:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

.btn-confirm {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    box-shadow: 0 3px 15px rgba(220, 53, 69, 0.3);
}

.btn-confirm:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-1px);
    box-shadow: 0 5px 20px rgba(220, 53, 69, 0.4);
}

/* Animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-header {
        padding: 2rem 0;
    }
    
    .profile-header .d-flex {
        flex-direction: column;
        gap: 1rem;
        align-items: center !important;
        text-align: center;
    }
    
    .profile-title {
        font-size: 2rem;
    }
    
    .profile-subtitle {
        font-size: 1rem;
    }
    
    .btn-back {
        align-self: stretch;
        justify-content: center;
    }
    
    .info-card-body,
    .feedback-card-body {
        padding: 1.5rem;
    }
    
    .equipment-items {
        grid-template-columns: 1fr;
    }
    
    .feedback-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-action {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .profile-header {
        padding: 1.5rem 0;
    }
    
    .profile-title {
        font-size: 1.75rem;
    }
    
    .info-card-body,
    .feedback-card-body {
        padding: 1rem;
    }
    
    .info-detail {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .star {
        font-size: 2rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
    }
    
    .section-header {
        margin-bottom: 1.5rem;
    }
    
    .equipment-category {
        padding: 1rem;
    }
    
    .equipment-label {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
        padding: 0.75rem;
    }
    
    .confirmation-dialog {
        width: 95%;
        margin: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Star Rating Functionality
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    const submitBtn = document.getElementById('submitBtn');
    
    if (ratingInput) {
        let selectedRating = 0;
        
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

        function checkFormValidity() {
            if (selectedRating > 0) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
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
                checkFormValidity();
                
                // Add animation effect
                stars.forEach(s => s.style.transform = 'scale(1.2)');
                setTimeout(() => {
                    stars.forEach(s => s.style.transform = 'scale(1)');
                }, 200);
            });
        });
    }
    
    // Character Counter for Comment
    const commentTextarea = document.getElementById('comment');
    const charCount = document.getElementById('charCount');
    
    if (commentTextarea && charCount) {
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
    
    // Equipment Selection Counter (optional enhancement)
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
});

// Delete Feedback Confirmation
function confirmDeleteFeedback() {
    document.getElementById('deleteConfirmModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteConfirmModal').classList.remove('show');
    document.body.style.overflow = '';
}

function deleteFeedback() {
    document.getElementById('deleteFeedbackForm').submit();
}

// Close modal when clicking backdrop
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('confirmation-backdrop')) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('deleteConfirmModal').classList.contains('show')) {
        closeDeleteModal();
    }
});
</script>
@endpush