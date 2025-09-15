@extends('frontend.layouts.master')

@section('title', 'PTTA Reservation System')

@section('main-content')
<!-- Page Header -->
<div class="profile-header">
    <div class="container">
        <h1 class="profile-title">
            <i class="fas fa-building" style="color: white;"></i>
            PTTA Reservation System
        </h1>
        <p class="page-subtitle">Find and reserve the perfect room for your needs</p>
    </div>
</div>

<div class="container">
    <!-- Search Form -->
    <div class="search-container">
        <div class="search-header">
            <h2 class="search-title">
                <i class="fas fa-filter"></i>
                Search Available Rooms
            </h2>
        </div>

        <form action="{{ route('filter.available.rooms') }}" method="POST" id="filterForm">
            @csrf
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <!-- Main Filters -->
            <div class="main-filters">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-door-open"></i>
                        Room Type
                    </label>
                    <select name="type_room" class="form-select mb-0" required>
                        <option value="All">All Room Types</option>
                        @foreach($type_rooms as $type)
                            <option value="{{ $type->id }}"
                                {{ (old('type_room', $type_room ?? '') == $type->id) ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt"></i>
                        Date
                    </label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-clock"></i>
                        Start Time
                    </label>
                    <input type="time" name="start_time" class="form-control" value="{{ $start_time }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-clock"></i>
                        End Time
                    </label>
                    <input type="time" name="end_time" class="form-control" value="{{ $end_time }}" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-search">
                        <div class="spinner"></div>
                        <span class="search-text">
                            <i class="fas fa-search"></i>
                            Search Rooms
                        </span>
                    </button>
                </div>
            </div>

            <!-- Advanced Filters Accordion -->
            <div class="accordion-container">
                <!-- Furniture Filters -->
                <button type="button" class="accordion-button-custom" data-target="furniture-filters">
                    <span>
                        <i class="fas fa-couch"></i>
                        Furniture Requirements
                    </span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div id="furniture-filters" class="accordion-content">
                    <div class="filter-grid">
                        @foreach ($furnitureCategories as $furniture)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="furniture_category[]"
                                    value="{{ $furniture->id }}" id="furniture_{{ $furniture->id }}"
                                    {{ in_array($furniture->id, $furniture_category ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="furniture_{{ $furniture->id }}">
                                    {{ $furniture->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Electronics Filters -->
                <button type="button" class="accordion-button-custom" data-target="electronics-filters">
                    <span>
                        <i class="fas fa-laptop"></i>
                        Electronics Requirements
                    </span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div id="electronics-filters" class="accordion-content">
                    <div class="filter-grid">
                        @foreach ($electronicCategories as $electronics)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="electronic_category[]"
                                    value="{{ $electronics->id }}" id="electronics_{{ $electronics->id }}"
                                    {{ in_array($electronics->id, $electronic_category ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="electronics_{{ $electronics->id }}">
                                    {{ $electronics->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <div id="results">
        @if (!request()->hasAny(['furniture_category', 'electronic_category', 'date', 'start_time', 'end_time']) && $rooms->isEmpty())
            <div class="empty-state">
                <i class="fas fa-search empty-icon"></i>
                <h3 class="empty-title">Ready to Find Your Perfect Room?</h3>
                <p class="empty-text">Use the search filters above to discover available rooms that match your specific requirements.</p>
            </div>
        @elseif (request()->hasAny(['furniture_category', 'electronic_category', 'date', 'start_time', 'end_time']) && $rooms->isEmpty())
            <div class="empty-state">
                <i class="fas fa-exclamation-triangle empty-icon" style="color: #f56565;"></i>
                <h3 class="empty-title">No Rooms Found</h3>
                <p class="empty-text">We couldn't find any rooms matching your criteria. Try adjusting your filters or selecting a different time slot.</p>
            </div>
        @else
            <div class="rooms-grid">
                @foreach ($rooms as $room)
                    <div class="room-card">
                        @if ($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" class="room-image" alt="{{ $room->name }}">
                        @else
                            <img src="{{ asset('images/ruang terbuka.jpg') }}" class="room-image" alt="{{ $room->name }}">
                        @endif
                        
                        <div class="room-content">
                            <h3 class="room-title">{{ $room->name }}</h3>
                            
                            <div class="room-info">
                                <div class="room-detail">
                                    <i class="fas fa-users room-detail-icon"></i>
                                    <span class="room-detail-text">
                                        <strong>Capacity:</strong> {{ $room->capacity }} people
                                    </span>
                                </div>
                                
                                <div class="room-detail">
                                    <i class="fas fa-couch room-detail-icon"></i>
                                    <span class="room-detail-text">
                                        <strong>Furniture:</strong>
                                        {{ $room->furnitures->pluck('name')->implode(', ') ?: 'Not specified' }}
                                    </span>
                                </div>
                                
                                <div class="room-detail">
                                    <i class="fas fa-laptop room-detail-icon"></i>
                                    <span class="room-detail-text">
                                        <strong>Electronics:</strong>
                                        {{ $room->electronics->pluck('name')->implode(', ') ?: 'Not specified' }}
                                    </span>
                                </div>
                            </div>
                            
                            <a href="{{ route('room.reserve', [
                                'id' => $room->no_room,
                                'type_room' => $room->type_room,
                                'capacity' => $room->capacity,
                                'furnitures' => $room->furnitures,
                                'electronics' => $room->electronics,
                                'date' => $date,
                                'start_time'=> $start_time,
                                'end_time' => $end_time
                            ]) }}" class="btn-reserve">
                                <i class="fas fa-calendar-check"></i>
                                Reserve Now
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Accordion functionality
    const accordionButtons = document.querySelectorAll('.accordion-button-custom');
    
    accordionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetContent = document.getElementById(targetId);
            const chevron = this.querySelector('.fa-chevron-down');
            
            // Close all other accordions
            accordionButtons.forEach(otherButton => {
                if (otherButton !== this) {
                    const otherId = otherButton.getAttribute('data-target');
                    const otherContent = document.getElementById(otherId);
                    const otherChevron = otherButton.querySelector('.fa-chevron-down');
                    
                    otherButton.classList.remove('active');
                    otherContent.classList.remove('show');
                    otherChevron.style.transform = 'rotate(0deg)';
                }
            });
            
            // Toggle current accordion
            this.classList.toggle('active');
            targetContent.classList.toggle('show');
            
            if (this.classList.contains('active')) {
                chevron.style.transform = 'rotate(180deg)';
            } else {
                chevron.style.transform = 'rotate(0deg)';
            }
        });
    });

    // Form submission loading state
    const form = document.getElementById('filterForm');
    const searchButton = form.querySelector('.btn-search');
    
    form.addEventListener('submit', function() {
        searchButton.classList.add('loading');
        searchButton.disabled = true;
        
        // Reset after 10 seconds as fallback
        setTimeout(() => {
            searchButton.classList.remove('loading');
            searchButton.disabled = false;
        }, 10000);
    });

    // Smooth scroll to results when form is submitted
    if (document.querySelector('#results .rooms-grid') || document.querySelector('#results .empty-state')) {
        setTimeout(() => {
            document.getElementById('results').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 100);
    }
});
</script>

@endsection