@extends('frontend.layouts.master')
@section('title', 'Edit Feedback')
@section('main-content')

<div class="container mt-5">
    <div class="card shadow rounded">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Feedback</h4>
            <a href="{{ route('my.bookings') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <strong>Booking Date:</strong> {{ $booking->booking_date }}<br>
                <strong>Time:</strong> {{ $booking->booking_time_start }} - {{ $booking->booking_time_end }}<br>
                <strong>Room:</strong> {{ $booking->room->name }}<br>
                <strong>Purpose:</strong> {{ $booking->purpose }}<br>
                <strong>Phone Number:</strong> {{ $booking->phone_number }}
            </div>

            <hr>

            <form action="{{ route('feedback.update', $feedback->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                {{-- Star Rating --}}
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div id="starRating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star star {{ $feedback->rating >= $i ? 'selected' : '' }}" data-value="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" value="{{ $feedback->rating }}" required>
                </div>

                {{-- Comment --}}
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment (optional)</label>
                    <textarea name="comment" id="comment" class="form-control" rows="3">{{ old('comment', $feedback->comment) }}</textarea>
                </div>

                {{-- Damaged Equipment --}}
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
                                    <label class="form-check-label"  for="electronic{{ $item->no_electronicEquipment }}">
                                        💻 {{ $item->name }} ({{ $item->category }})
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Feedback
                </button>
            </form>
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

    .star.hover,
    .star.selected {
        color: #ffc107;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');
        let selectedRating = parseInt(ratingInput.value) || 0;

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

        // Initial highlight
        highlightStars(selectedRating);
    });
</script>
@endpush

@endsection
