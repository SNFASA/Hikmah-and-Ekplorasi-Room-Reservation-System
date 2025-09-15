@extends('frontend.layouts.master')
@section('title','PTTA Reservation System')
@section('main-content')

<div class="container mt-5">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-comment-dots"></i> Send Feedback</h4>
            <a href="{{ route('my.bookings') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <p><strong>Booking Date:</strong> {{ $booking->booking_date }}</p>
            <p><strong>Time:</strong> {{ $booking->booking_time_start }} - {{ $booking->booking_time_end }}</p>
            <p><strong>Room:</strong> {{ $booking->room->name }}</p>
            <p><strong>Purpose:</strong> {{ $booking->purpose }}</p>
            <p><strong>Phone Number:</strong> {{ $booking->phone_number }}</p>

            <hr>

            @if (!$feedback)
                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div id="starRating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star star" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating" required>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment (optional)</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Describe any suggestions or issues..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Report Damaged Equipment</label>
                        <div class="row">
                            @foreach($booking->room->furnitures as $item)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="damaged_furnitures[]" value="{{ $item->no_furniture }}" id="furniture{{ $item->no_furniture }}">
                                        <label class="form-check-label" for="furniture{{ $item->no_furniture }}">
                                            🪑 {{ $item->name }} ({{ $item->category }})
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                            @foreach($booking->room->electronics as $item)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="damaged_electronics[]" value="{{ $item->no_electronicEquipment }}" id="electronic{{ $item->no_electronicEquipment }}">
                                        <label class="form-check-label" for="electronic{{ $item->no_electronicEquipment }}">
                                            💻 {{ $item->name }} ({{ $item->category }})
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Submit Feedback
                    </button>
                </form>
            @else
                <div class="alert alert-info">
                    <strong>You have already submitted feedback for this booking.</strong>
                </div>

                <p><strong>Rating:</strong> {{ $feedback->rating }}</p>
                <p><strong>Comment:</strong> {{ $feedback->comment ?? '-' }}</p>

                <div class="d-flex gap-2">
                    <a href="{{ route('frontend.pages.feedbackedit', $feedback->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Feedback
                    </a>

                    <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Feedback
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .star {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
    }

    .star.selected,
    .star.hover {
        color: #ffc107;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');
        if (!ratingInput) return;
        let selectedRating = 0;

        function highlightStars(rating) {
            stars.forEach(star => {
                const value = parseInt(star.getAttribute('data-value'));
                star.classList.toggle('selected', value <= rating);
            });
        }

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const value = parseInt(star.getAttribute('data-value'));
                highlightStars(value);
            });

            star.addEventListener('mouseout', () => {
                highlightStars(selectedRating);
            });

            star.addEventListener('click', () => {
                selectedRating = parseInt(star.getAttribute('data-value'));
                ratingInput.value = selectedRating;
                highlightStars(selectedRating);
            });
        });
    });
</script>
@endpush

@endsection
