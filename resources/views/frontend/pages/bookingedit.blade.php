@extends('frontend.layouts.master')
@section('title','Checkout Edit Room')
@section('main-content')
    
    <!-- Start Modern Edit Booking -->
    <div class="modern-booking-container">
        <div class="booking-header">
            <div class="container">
                <h2 class="booking-title">
                    <i class="fas fa-edit me-3"></i>
                    Update Room Booking
                </h2>
                <p class="booking-subtitle">Modify your existing room reservation details</p>
            </div>
        </div>

        <div class="container py-5">
            <form class="modern-booking-form" method="POST" action="{{ route('booking.update', $booking->id) }}?no_room={{ $room->no_room }}">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <!-- Booking Form Section -->
                    <div class="col-lg-8 col-12">
                        <div class="booking-form-card">
                            <div class="form-card-header">
                                <h4 class="form-card-title">
                                    <i class="fas fa-sync-alt me-2"></i>
                                    Update Booking Information
                                </h4>
                                <p class="form-card-subtitle">Modify the booking details below</p>
                            </div>
                            
                            <div class="form-card-body">
                                <div class="row g-3">
                                    <!-- Purpose Field -->
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="modern-form-group">
                                            <label class="modern-form-label">
                                                <i class="fas fa-bullseye me-2"></i>
                                                Purpose <span class="required-asterisk">*</span>
                                            </label>
                                            <input type="text" name="purpose" class="modern-form-control" 
                                                   placeholder="Enter booking purpose" 
                                                   value="{{ $booking->purpose }}" required>
                                            @error('purpose')
                                                <div class="modern-error-message">
                                                    <i class="fas fa-exclamation-circle me-1"></i>
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Phone Number Field -->
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="modern-form-group">
                                            <label class="modern-form-label">
                                                <i class="fas fa-phone me-2"></i>
                                                Phone Number <span class="required-asterisk">*</span>
                                            </label>
                                            <input type="text" name="phone_number" class="modern-form-control" 
                                                   placeholder="011 12345678" 
                                                   value="{{ $booking->phone_number }}" required>
                                            @error('phone_number')
                                                <div class="modern-error-message">
                                                    <i class="fas fa-exclamation-circle me-1"></i>
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Start Time Field -->
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="modern-form-group">
                                            <label class="modern-form-label">
                                                <i class="fas fa-play-circle me-2"></i>
                                                Start Time <span class="required-asterisk">*</span>
                                            </label>
                                            <input type="time" name="booking_time_start" class="modern-form-control" 
                                                   value="{{ $booking->booking_time_start }}" required>
                                            @error('booking_time_start')
                                                <div class="modern-error-message">
                                                    <i class="fas fa-exclamation-circle me-1"></i>
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- End Time Field -->
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="modern-form-group">
                                            <label class="modern-form-label">
                                                <i class="fas fa-stop-circle me-2"></i>
                                                End Time <span class="required-asterisk">*</span>
                                            </label>
                                            <input type="time" name="booking_time_end" class="modern-form-control" 
                                                   value="{{ $booking->booking_time_end }}" required>
                                            @error('booking_time_end')
                                                <div class="modern-error-message">
                                                    <i class="fas fa-exclamation-circle me-1"></i>
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Date Field -->
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="modern-form-group">
                                            <label class="modern-form-label">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                Booking Date <span class="required-asterisk">*</span>
                                            </label>
                                            <input type="date" name="booking_date" class="modern-form-control" 
                                                   required value="{{ $booking->booking_date }}">
                                            @error('booking_date')
                                                <div class="modern-error-message">
                                                    <i class="fas fa-exclamation-circle me-1"></i>
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Students Section -->
                                    <div class="col-12">
                                        <div class="students-section-card">
                                            <h5 class="students-section-title">
                                                <i class="fas fa-users me-2"></i>
                                                Student Information
                                            </h5>
                                            <p class="students-section-subtitle">Update student details (minimum 4, maximum 10 students)</p>
                                            
                                            <div id="students-list" class="students-list">
                                                @foreach($selectedStudents as $index => $student)
                                                <div class="student-entry-card">
                                                    <div class="student-entry-header">
                                                        <h6 class="student-number">Student {{ $index + 1 }}</h6>
                                                        <button type="button" class="remove-student-btn" onclick="removeStudent(this)" {{ count($selectedStudents) <= 1 ? 'style=display:none' : '' }}>
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="modern-form-group">
                                                                <label class="modern-form-label">
                                                                    <i class="fas fa-id-card me-2"></i>
                                                                    Matric Number <span class="required-asterisk">*</span>
                                                                </label>
                                                                <input type="text" name="students[{{ $index }}][no_matriks]" required class="modern-form-control" placeholder="Enter matric number" value="{{ $student->no_matriks }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="modern-form-group">
                                                                <label class="modern-form-label">
                                                                    <i class="fas fa-user me-2"></i>
                                                                    Full Name <span class="required-asterisk">*</span>
                                                                </label>
                                                                <input type="text" name="students[{{ $index }}][name]" required class="modern-form-control" placeholder="Enter full name" value="{{ $student->name ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            
                                            <button type="button" id="add-student" class="modern-add-student-btn">
                                                <i class="fas fa-plus me-2"></i>
                                                Add Student
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Room Details Section -->
                    <div class="col-lg-4 col-12">
                        <div class="room-details-card">
                            <div class="room-card-header">
                                <h4 class="room-card-title">
                                    <i class="fas fa-door-open me-2"></i>
                                    Room Details
                                </h4>
                            </div>
                            
                            <div class="room-card-body">
                                <div class="room-image-container">
                                    @if ($room->image)
                                        <img src="{{ asset('storage/' . $room->image) }}" class="room-image" alt="Room Image">
                                    @else
                                        <img src="{{ asset('images/ruang terbuka.jpg') }}" class="room-image" alt="No Image Available">
                                    @endif
                                </div>
                                
                                <div class="room-details-list">
                                    <div class="room-detail-item">
                                        <div class="detail-icon">
                                            <i class="fas fa-door-closed text-primary"></i>
                                        </div>
                                        <div class="detail-content">
                                            <small class="detail-label">Room Name</small>
                                            <div class="detail-value">{{$room->name}}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="room-detail-item">
                                        <div class="detail-icon">
                                            <i class="fas fa-users text-success"></i>
                                        </div>
                                        <div class="detail-content">
                                            <small class="detail-label">Capacity</small>
                                            <div class="detail-value">{{$room->capacity}} Guests</div>
                                        </div>
                                    </div>
                                    
                                    <div class="room-detail-item">
                                        <div class="detail-icon">
                                            <i class="fas fa-couch text-info"></i>
                                        </div>
                                        <div class="detail-content">
                                            <small class="detail-label">Furniture</small>
                                            <div class="detail-value">{{ implode(', ', $room->furnitures->pluck('name')->toArray()) ?: 'N/A' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="room-detail-item">
                                        <div class="detail-icon">
                                            <i class="fas fa-tv text-warning"></i>
                                        </div>
                                        <div class="detail-content">
                                            <small class="detail-label">Electronic Equipment</small>
                                            <div class="detail-value">{{ implode(', ', $room->electronics->pluck('name')->toArray()) ?: 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="room-card-footer">
                                <button type="submit" class="modern-submit-btn">
                                    <i class="fas fa-sync-alt me-2"></i>
                                    Update Booking
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Modern Edit Booking -->
@endsection
@push('scripts')
<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() { 
        $("select.select2").select2(); 
    });
    $('select.nice-select').niceSelect();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-student').addEventListener('click', function() {
            const studentsList = document.getElementById('students-list');
            const currentCount = studentsList.children.length;

            // Check if the number of students is within the allowed range
            if (currentCount >= 10) {
                alert('You can only add a maximum of 10 students.');
                return;
            }

            const studentEntry = document.createElement('div');
            studentEntry.classList.add('student-entry-card');
            studentEntry.innerHTML = `
                <div class="student-entry-header">
                    <h6 class="student-number">Student ${currentCount + 1}</h6>
                    <button type="button" class="remove-student-btn" onclick="removeStudent(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fas fa-id-card me-2"></i>
                                Matric Number <span class="required-asterisk">*</span>
                            </label>
                            <input type="text" name="students[${currentCount}][no_matriks]" required class="modern-form-control" placeholder="Enter matric number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label class="modern-form-label">
                                <i class="fas fa-user me-2"></i>
                                Full Name <span class="required-asterisk">*</span>
                            </label>
                            <input type="text" name="students[${currentCount}][name]" required class="modern-form-control" placeholder="Enter full name">
                        </div>
                    </div>
                </div>
            `;
            studentsList.appendChild(studentEntry);
            updateStudentNumbers();
            updateRemoveButtonsVisibility();
        });
        
        // Function to remove student
        window.removeStudent = function(button) {
            const studentEntry = button.closest('.student-entry-card');
            const studentsList = document.getElementById('students-list');
            
            // Don't allow removal if only 1 student remains
            if (studentsList.children.length <= 1) {
                alert('You must have at least 1 student entry.');
                return;
            }
            
            studentEntry.remove();
            updateStudentNumbers();
            updateRemoveButtonsVisibility();
        };
        
        // Function to update student numbers
        function updateStudentNumbers() {
            const studentEntries = document.querySelectorAll('.student-entry-card');
            studentEntries.forEach((entry, index) => {
                const studentNumber = entry.querySelector('.student-number');
                studentNumber.textContent = `Student ${index + 1}`;
                
                // Update input names to maintain proper indexing
                const inputs = entry.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name.includes('[no_matriks]')) {
                        input.setAttribute('name', `students[${index}][no_matriks]`);
                    } else if (name.includes('[name]')) {
                        input.setAttribute('name', `students[${index}][name]`);
                    }
                });
            });
        }
        
        // Function to show/hide remove buttons
        function updateRemoveButtonsVisibility() {
            const removeButtons = document.querySelectorAll('.remove-student-btn');
            const studentsList = document.getElementById('students-list');
            
            removeButtons.forEach(button => {
                if (studentsList.children.length > 1) {
                    button.style.display = 'flex';
                } else {
                    button.style.display = 'none';
                }
            });
        }

        // Initial call to set remove button visibility
        updateRemoveButtonsVisibility();

        // Form submission validation
        document.querySelector('.modern-booking-form').addEventListener('submit', function(event) {
            const studentsList = document.getElementById('students-list');
            const count = studentsList.children.length;

            if (count < 4) {
                alert('You must add at least 4 students before submitting the form.');
                event.preventDefault(); // Stop form submission
            }
        });
    });
</script>
@endpush