@extends('frontend.layouts.master')

@section('title','LibraRoom Reservation system')

@section('main-content')
<div class="container mt-5">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Outer Box -->
    <div class="search-box">
        <!-- Inner Box -->
        <div class="input-box shadow-lg">
            <form id="filterForm" class="d-flex justify-content-center" method="GET" action="{{ route('home') }}">
                <div class="input-group rounded-pill">
                    <!-- WHERE (Dropdown) -->
                    <span class="input-group-text border-0 bg-white fw-bold">Type Room</span>
                    <select name="type_room" class="form-control border-0">
                        <option value="All" {{ $type_room === 'All' ? 'selected' : '' }}>All</option>
                        <option value="EKSPLORASI" {{ $type_room === 'EKSPLORASI' ? 'selected' : '' }}>Eksplorasi</option>
                        <option value="HIKMAH" {{ $type_room === 'HIKMAH' ? 'selected' : '' }}>Hikmah</option>
                        <!-- Add other options as needed -->
                    </select>
                    

                    <!-- CHECK IN -->
                    <span class="input-group-text border-0 bg-white fw-bold">Check in</span>
                    <input type="date" value="{{ $date }}" class="form-control border-0" name="date" aria-label="Check in">

                    <!-- START TIME -->
                    <span class="input-group-text border-0 bg-white fw-bold">Start time</span>
                    <input type="time" id="start_time" name="start_time" class="form-control border-0" value="{{ old('start_time', $start_time) }}">

                    <!-- END TIME -->
                    <span class="input-group-text border-0 bg-white fw-bold">End time</span>
                    <input type="time" id="end_time" name="end_time" class="form-control border-0" value="{{ old('end_time', $end_time) }}">

                    <!-- GUEST COUNT -->
                    <span class="input-group-text border-0 bg-white fw-bold">Guest</span>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-primary btn-sm" type="button" id="decreaseGuests">-</button>
                        <input type="text" id="guestCount" class="form-control text-center border-0" value="1" style="width: 50px;" readonly>
                        <button class="btn btn-outline-primary btn-sm"  type="button" id="increaseGuests">+</button>
                    </div>

                    <!-- SEARCH BUTTON -->
                    <button class="btn btn-primary rounded-circle px-3" type="submit">
                        <i class="bi bi-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div> 
</div>

<!-- Filters -->
<div class="container mt-5">
    <div class="row">
        <!-- Furniture Dropdown -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Furniture</label>
            <div class="dropdown">
                <button class="btn btn-outline-primary w-100 dropdown-toggle" type="button" id="furnitureDropdown" data-bs-toggle="dropdown">
                    Select Furniture
                </button>
                <ul class="dropdown-menu p-2 multiselect-container">
                    @foreach ($furnitureCategories as $furniture)
                        <li><label class="form-check-label w-100">
                            <input type="checkbox" name="furniture_category[]" value="{{ $furniture->category }}" class="form-check-input" 
                            {{ in_array($furniture->category, $furniture_category) ? 'checked' : '' }}> {{ $furniture->category }}
                        </label></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Electronic Equipment Dropdown -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Electronic Equipment</label>
            <div class="dropdown">
                <button class="btn btn-outline-primary w-100 dropdown-toggle" type="button" id="electronicsDropdown" data-bs-toggle="dropdown">
                    Select Equipment
                </button>
                <ul class="dropdown-menu p-2 multiselect-container">
                    @foreach ($electronicCategories as $electronics)
                        <li><label class="form-check-label w-100">
                            <input type="checkbox" name="electronic_category[]" value="{{ $electronics->category }}" class="form-check-input" 
                            {{ in_array($electronics->category, $electronic_category) ? 'checked' : '' }}> {{ $electronics->category }}
                        </label></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>  
</div>

<!-- Results Section for Static Data -->
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

@push('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('filterForm');
    const resultsContainer = document.getElementById('results');

    if (!resultsContainer) {
        console.error('Results container not found!');
        return; // Exit if the results container is not found
    }

    searchForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        const formData = new FormData(searchForm);

        // Collect selected furniture categories (ensure they're selected checkboxes)
        const furnitureCategories = Array.from(document.querySelectorAll('input[name="furniture_category[]"]:checked'))
            .map(input => input.value);
        furnitureCategories.forEach((category) => formData.append('furniture_category[]', category));

        // Collect selected electronic categories
        const electronicCategories = Array.from(document.querySelectorAll('input[name="electronic_category[]"]:checked'))
            .map(input => input.value);
        electronicCategories.forEach((category) => formData.append('electronic_category[]', category));

        // Send data to the filter route
        fetch('{{ route("filter.available.rooms") }}?' + new URLSearchParams(Object.fromEntries(formData)), {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        .then(response => response.json()) // Parse the JSON response
        .then(data => {
    resultsContainer.innerHTML = ''; // Clear previous results

    // No Request and No Result
    if (!searchForm.querySelectorAll('input[name]:checked').length && data.rooms.length === 0) {
        resultsContainer.innerHTML = '<p class="text-center">Welcome! Use the filter options to search for rooms.</p>';
    }
    // Has Request but No Result
    else if (data.rooms.length === 0) {
        resultsContainer.innerHTML = '<p class="text-center">No rooms available matching your search criteria. Please try different filters.</p>';
    }
    // Has Request and Has Result
    else {
        const rowContainer = document.createElement('div');
        rowContainer.className = 'row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4';

        data.rooms.forEach(room => {
            const furnitureNames = room.furnitures.length ? room.furnitures.map(f => f.name).join(', ') : 'N/A';
            const electronicsNames = room.electronics.length ? room.electronics.map(e => e.name).join(', ') : 'N/A';

            const roomCard = `
            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('images/') }}/${room.type_room === 'EKSPLORASI' ? 'OIP 2.jpeg' : 'OIP.jpeg'}" class="card-img-top" alt="Room Image">
                    <div class="card-body">
                        <h5 class="card-title">${room.name}</h5>
                        <p class="card-text">Capacity: ${room.capacity}</p>
                        <p class="card-text">Furniture: ${furnitureNames}</p>
                        <p class="card-text">Electronics: ${electronicsNames}</p>
                        <a href="{{ route('room.reserve', ['id' => $room->no_room , 'type_room' => $room->type_room, 'capacity' => $room->capacity, 'furnitures' => $room->furnitures, 'electronics' => $room->electronics , 'date' => $date, 'start_time'=> $start_time, 'end_time' => $end_time]) }}" class="btn btn-primary">Reserve Now</a>
                    </div>
                </div>
            </div>`;
            rowContainer.insertAdjacentHTML('beforeend', roomCard);
        });

        resultsContainer.appendChild(rowContainer);
    }
})

        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred while searching for rooms. Please try again later.');
        });
    });
});
</script>

@endpush