@extends('frontend.layouts.master')

@section('title', 'LibraRoom Reservation System')

@section('main-content')
<style>
    body {
        background-color: whitesmoke;
    }

    .card {
        transition: transform 0.2s, box-shadow 0.2s;
        background-color: #ffffff;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(67, 93, 186, 0.2);
        border: 1px solid #435dba;
    }

    .btn-outline-primary:hover {
        background-color: #435dba;
        color: white;
    }

    .input-group .form-control:focus {
        border-color: #435dba;
        box-shadow: 0 0 0 0.25rem rgba(67, 93, 186, 0.25);
    }

    .input-group-text {
        background-color: #f8f9fa;
    }
</style>

<div class="container mt-5">
    <!-- Search Box -->
    <div class="search-box">
        <form action="{{ route('filter.available.rooms') }}" method="POST" id="filterForm">
            @csrf
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="search-box rounded-5">
                <div class="input-box shadow-lg p-4 bg-white rounded-5">
                    <div class="input-group flex-column flex-md-row gap-2 rounded-5">
                        <!-- Room Type -->
                        <span class="input-group-text border-0 fw-bold">
                            <i class="fa fa-door-open me-1"></i> Type Room
                        </span>
                        <select name="type_room" class="form-control border-0">
                            <option value="All" {{ $type_room == 'All' ? 'selected' : '' }}>All</option>
                            <option value="EKSPLORASI" {{ $type_room == 'EKSPLORASI' ? 'selected' : '' }}>Eksplorasi</option>
                            <option value="HIKMAH" {{ $type_room == 'HIKMAH' ? 'selected' : '' }}>Hikmah</option>
                        </select>

                        <!-- Date -->
                        <span class="input-group-text border-0 fw-bold">
                            <i class="fa fa-calendar-alt me-1"></i> Date
                        </span>
                        <input type="date" name="date" class="form-control border-0" value="{{ $date }}" required>

                        <!-- Start Time -->
                        <span class="input-group-text border-0 fw-bold">
                            <i class="fa fa-clock me-1"></i> Start
                        </span>
                        <input type="time" name="start_time" class="form-control border-0" value="{{ $start_time }}" required>

                        <!-- End Time -->
                        <span class="input-group-text border-0 fw-bold">
                            <i class="fa fa-clock me-1"></i> End
                        </span>
                        <input type="time" name="end_time" class="form-control border-0" value="{{ $end_time }}" required>

                        <!-- Search Button -->
                        <button class="btn btn-primary rounded-circle px-3" type="submit">
                            <i class="fa fa-search text-white"></i>
                        </button>
                    </div>
                    <!-- Filters -->
                    <div class="container mt-4">
                        <div class="row">
                            <!-- Furniture Filter -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"><i class="fa fa-chair me-2"></i>Furniture</label>
                                @foreach ($furnitureCategories as $furniture)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="furniture_category[]" value="{{ $furniture->category }}" 
                                            {{ in_array($furniture->category, $furniture_category) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $furniture->category }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Electronics Filter -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"><i class="fa fa-plug me-2"></i>Electronics</label>
                                @foreach ($electronicCategories as $electronics)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="electronic_category[]" value="{{ $electronics->category }}" 
                                            {{ in_array($electronics->category, $electronic_category) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $electronics->category }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Product Area -->
<div class="product-area section">
    <div id="results" class="container mt-5">
        @if (!request()->hasAny(['furniture_category', 'electronic_category', 'date', 'start_time', 'end_time']) && $rooms->isEmpty())
            <p class="text-center text-muted"><i class="fa fa-info-circle me-1"></i>Use the filters above to find available rooms.</p>
        @elseif (request()->hasAny(['furniture_category', 'electronic_category', 'date', 'start_time', 'end_time']) && $rooms->isEmpty())
            <p class="text-center text-danger"><i class="fa fa-exclamation-circle me-1"></i>No rooms matched your filters. Try again.</p>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach ($rooms as $room)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset($room->type_room === 'EKSPLORASI' ? 'images/OIP 2.jpeg' : 'images/OIP.jpeg') }}" class="card-img-top" alt="Room Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $room->name }}</h5>
                                <p class="card-text"><i class="fa fa-users me-1"></i> Capacity: {{ $room->capacity }}</p>
                                <p class="card-text"><i class="fa fa-chair me-1"></i> Furniture: 
                                    {{ implode(', ', $room->furnitures->pluck('name')->toArray()) ?: 'N/A' }}
                                </p>
                                <p class="card-text"><i class="fa fa-plug me-1"></i> Electronics: 
                                    {{ implode(', ', $room->electronics->pluck('name')->toArray()) ?: 'N/A' }}
                                </p>
                                <a href="{{ route('room.reserve', [
                                    'id' => $room->no_room,
                                    'type_room' => $room->type_room,
                                    'capacity' => $room->capacity,
                                    'furnitures' => $room->furnitures,
                                    'electronics' => $room->electronics,
                                    'date' => $date,
                                    'start_time'=> $start_time,
                                    'end_time' => $end_time
                                ]) }}" class="btn btn-outline-primary w-100">
                                    <i class="fa fa-calendar-check me-1"></i> Reserve Now
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection