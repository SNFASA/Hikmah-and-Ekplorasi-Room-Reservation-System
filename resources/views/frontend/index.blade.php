@extends('frontend.layouts.master')

@section('title','LibraRoom Reservation system')

@section('main-content')
<div class="container mt-5">
    <!-- Outer Box -->
    <div class="search-box">
        <!-- Inner Box -->
        <div class="input-box shadow-lg">
            <form id="filterForm" class="d-flex justify-content-center" method="GET" action="{{ route('filter.available.rooms') }}">
                <div class="input-group rounded-pill">
                    <!-- WHERE (Dropdown) -->
                    <span class="input-group-text border-0 bg-white fw-bold">Type Room</span>
                    <select name="type_room" class="form-control" aria-label="Select Room Type">
                        <option value="All" {{ $type_room == 'All' ? 'selected' : '' }}>All</option>
                        <option value="HIKMAH" {{ $type_room == 'HIKMAH' ? 'selected' : '' }}>HIKMAH</option>
                        <option value="EKSLORASI" {{ $type_room == 'EKSLORASI' ? 'selected' : '' }}>EKSLORASI</option>
                    </select>

                    <!-- CHECK IN -->
                    <span class="input-group-text border-0 bg-white fw-bold">Check in</span>
                    <input type="date" value="{{ $date }}" class="form-control border-0" name="date" aria-label="Check in">

                    <!-- START TIME -->
                    <span class="input-group-text border-0 bg-white fw-bold">Start time</span>
                    <input type="time" name="start_time" value="{{ $start_time }}" class="form-control border-0" aria-label="Start time">

                    <!-- END TIME -->
                    <span class="input-group-text border-0 bg-white fw-bold">End time</span>
                    <input type="time" name="end_time" value="{{ $end_time }}" class="form-control border-0" aria-label="End time">

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
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>List Room Reservation</h2>
            </div>
        </div>
        <div id="results" class="row">
            <!-- The results will be inserted dynamically via JavaScript -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchForm = document.getElementById('filterForm');
            const resultsContainer = document.getElementById('results');

            searchForm.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                const formData = new FormData(searchForm);

                fetch('{{ route("filter.available.rooms") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = ''; // Clear previous results
                    if (data.length > 0) {
                        data.forEach(room => {
                            const roomCard = `
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('images/') }}/${room.type_room === 'EKSPLORASI' ? 'OIP2.jpeg' : 'OIP.jpeg'}" class="card-img-top" alt="Room Image">
                                        <div class="card-body">
                                            <h5 class="card-title">${room.name}</h5>
                                            <p class="card-text">Capacity: ${room.capacity}</p>
                                            <p class="card-text">Furniture: ${room.furnitures.map(f => f.name).join(', ') || 'N/A'}</p>
                                            <p class="card-text">Electronics: ${room.electronics.map(e => e.name).join(', ') || 'N/A'}</p>
                                            <a href="/room/reserve/${room.id}" class="btn btn-primary">Reserve Now</a>
                                        </div>
                                    </div>
                                </div>`;
                            resultsContainer.insertAdjacentHTML('beforeend', roomCard);
                        });
                    } else {
                        resultsContainer.innerHTML = '<p class="col-12 text-center">No rooms available for the selected criteria.</p>';
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
