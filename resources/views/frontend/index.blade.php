@extends('frontend.layouts.master')

@section('title', 'LibraRoom Reservation System')

@section('main-content')
<div class="container mt-5">
    <!-- Search Box -->
    <div class="search-box">
        <div class="input-box shadow-lg">
            <form action="{{ route('filter.available.rooms') }}" method="POST" id="filterForm">
                @csrf
                <div class="container mt-5">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
            
                    <!-- Search Box -->
                    <div class="search-box">
                        <div class="input-box shadow-lg">
                            <div class="input-group rounded-pill">
                                <!-- Room Type -->
                                <span class="input-group-text border-0 bg-white fw-bold">Type Room</span>
                                <select name="type_room" class="form-control border-0">
                                    <option value="All" {{ $type_room == 'All' ? 'selected' : '' }}>All</option>
                                    <option value="EKSPLORASI" {{ $type_room == 'EKSPLORASI' ? 'selected' : '' }}>Eksplorasi</option>
                                    <option value="HIKMAH" {{ $type_room == 'HIKMAH' ? 'selected' : '' }}>Hikmah</option>
                                </select>
            
                                <!-- Date -->
                                <span class="input-group-text border-0 bg-white fw-bold">Date</span>
                                <input type="date" name="date" class="form-control border-0" value="{{ $date }}" required>
            
                                <!-- Start Time -->
                                <span class="input-group-text border-0 bg-white fw-bold">Start Time</span>
                                <input type="time" name="start_time" class="form-control border-0" value="{{ $start_time }}" required>
            
                                <!-- End Time -->
                                <span class="input-group-text border-0 bg-white fw-bold">End Time</span>
                                <input type="time" name="end_time" class="form-control border-0" value="{{ $end_time }}" required>
            
                                <!-- Search Button -->
                                <button class="btn btn-primary rounded-circle px-3" type="submit">
                                    <i class="bi bi-search text-white"></i>
                                </button>
                            </div>
                        </div>
                    </div>
            
                    <!-- Filters -->
                    <div class="container mt-4">
                        <div class="row">
                            <!-- Furniture Filter -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Furniture</label>
                                @foreach ($furnitureCategories as $furniture)
                                <div>
                                    <label>
                                        <input type="checkbox" name="furniture_category[]" value="{{ $furniture->category }}" 
                                               {{ in_array($furniture->category, $furniture_category) ? 'checked' : '' }}>
                                        {{ $furniture->category }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
            
                            <!-- Electronics Filter -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Electronics</label>
                                @foreach ($electronicCategories as $electronics)
                                <div>
                                    <label>
                                        <input type="checkbox" name="electronic_category[]" value="{{ $electronics->category }}" 
                                               {{ in_array($electronics->category, $electronic_category) ? 'checked' : '' }}>
                                        {{ $electronics->category }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Product Area -->
<div class="product-area section">
    <div id="results" class="container mt-5">
        {{-- No Request and No Result --}}
        @if (!request()->hasAny(['furniture_category', 'electronic_category', 'date', 'start_time', 'end_time']) && $rooms->isEmpty())
            <p class="text-center">Welcome! Use the filter options to search for rooms.</p>
        
        {{-- Has Request but No Result --}}
        @elseif (request()->hasAny(['furniture_category', 'electronic_category', 'date', 'start_time', 'end_time']) && $rooms->isEmpty())
            <p class="text-center">No rooms available matching your search criteria. Please try different filters.</p>
        
        {{-- Has Request and Has Result --}}
        @else
            <div class="container mt-5">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach ($rooms as $room)
                        <div class="col">
                            <div class="card h-100">
                                {{-- Display Room Image Based on Type --}}
                                <img src="{{ asset($room->type_room === 'EKSPLORASI' ? 'images/OIP 2.jpeg' : 'images/OIP.jpeg') }}" class="card-img-top" alt="Room Image">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $room->name }}</h5>
                                    <p class="card-text">Capacity: {{ $room->capacity }}</p>
                                    <p class="card-text">Furniture: 
                                        {{ implode(', ', $room->furnitures->pluck('name')->toArray()) ?: 'N/A' }}
                                    </p>
                                    <p class="card-text">Electronics: 
                                        {{ implode(', ', $room->electronics->pluck('name')->toArray()) ?: 'N/A' }}
                                    </p>
                                    <a href="{{ route('room.reserve', ['id' => $room->no_room , 'type_room' => $room->type_room, 'capacity' => $room->capacity, 'furnitures' => $room->furnitures, 'electronics' => $room->electronics , 'date' => $date, 'start_time'=> $start_time, 'end_time' => $end_time]) }}" class="btn btn-primary">Reserve Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
