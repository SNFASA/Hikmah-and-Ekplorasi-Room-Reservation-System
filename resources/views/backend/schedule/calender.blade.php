@extends('backend.layouts.master')
@section('title','Schedule Reserved Room')
@section('main-content')

<div class="container-fluid mt-4 px-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary fw-bold mb-1">Schedule Overview</h2>
                    <p class="text-muted mb-0">Manage and view all reserved rooms</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="legend-item d-flex align-items-center me-3">
                        <div class="legend-dot bg-success me-2"></div>
                        <small class="text-muted">Available</small>
                    </div>
                    <div class="legend-item d-flex align-items-center me-3">
                        <div class="legend-dot bg-danger me-2"></div>
                        <small class="text-muted">Reserved</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Card -->
    <div class="card calendar-card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-gradient-primary text-white p-4 border-0">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Room Reservations Calendar
                    </h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                        <button class="btn btn-light btn-sm rounded-pill px-3" onclick="calendar.today()">
                            <i class="fas fa-clock me-1"></i> Today
                        </button>
                        <button class="btn btn-outline-light btn-sm rounded-pill px-3" onclick="calendar.changeView('timeGridWeek')">
                            <i class="fas fa-th me-1"></i> Week
                        </button>
                        <button class="btn btn-outline-light btn-sm rounded-pill px-3" onclick="calendar.changeView('timeGridDay')">
                            <i class="fas fa-calendar-day me-1"></i> Day
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0 bg-light">
            <div id="calendar" class="modern-calendar"></div>
        </div>
    </div>
</div>

@endsection

@push('styles')


@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Show loading spinner
    const calendarEl = document.getElementById('calendar');
    calendarEl.innerHTML = '<div class="calendar-loading"><div class="spinner"></div></div>';

    // Initialize calendar after a brief delay for smooth loading
    setTimeout(function() {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: window.innerWidth < 768 ? 'timeGridDay' : 'timeGridWeek',
            slotMinTime: '07:00:00',
            slotMaxTime: '20:00:00',
            height: 'auto',
            aspectRatio: 1.8,
            
            // Header Configuration
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },

            // Button Text
            buttonText: {
                today: 'Today',
                week: 'Week',
                day: 'Day'
            },

            // Events
            events: @json($events),

            // Event Rendering
            eventContent: function (info) {
                const container = document.createElement('div');
                container.style.display = 'flex';
                container.style.flexDirection = 'column';
                container.style.alignItems = 'flex-start';
                container.style.width = '100%';
                container.style.height = '100%';
                container.style.overflow = 'hidden';

                // Time element
                const timeEl = document.createElement('div');
                timeEl.className = 'fc-event-time';
                timeEl.textContent = `${info.event.start.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                })} - ${info.event.end.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                })}`;

                // Title element
                const titleEl = document.createElement('div');
                titleEl.className = 'fc-event-title';
                titleEl.textContent = info.event.title || 'Untitled Event';
                titleEl.style.marginTop = '2px';

                // Room info if available
                if (info.event.extendedProps.room) {
                    const roomEl = document.createElement('div');
                    roomEl.style.fontSize = '0.7rem';
                    roomEl.style.opacity = '0.8';
                    roomEl.style.marginTop = '1px';
                    roomEl.textContent = `Room: ${info.event.extendedProps.room}`;
                    container.appendChild(roomEl);
                }

                container.appendChild(timeEl);
                container.appendChild(titleEl);

                return { domNodes: [container] };
            },

            // Event Classification
            eventClassNames: function(info) {
                const status = info.event.extendedProps.status || 'reserved';
                return [`event-${status}`];
            },

            // Calendar Options
            eventOverlap: false,
            slotEventOverlap: false,
            nowIndicator: true,
            scrollTime: '08:00:00',
            allDaySlot: false,
            slotDuration: '00:30:00',
            slotLabelInterval: '01:00:00',
            
            // Interactions
            eventClick: function(info) {
                // Create modern modal or alert
                showEventDetails(info.event);
            },

            dateClick: function(info) {
                console.log('Date clicked:', info.dateStr);
            },

            // Loading
            loading: function(bool) {
                if (bool) {
                    calendarEl.style.opacity = '0.7';
                } else {
                    calendarEl.style.opacity = '1';
                }
            },

            // Responsive
            windowResize: function() {
                if (window.innerWidth < 768) {
                    calendar.changeView('timeGridDay');
                } else {
                    calendar.changeView('timeGridWeek');
                }
            }
        });

        // Render calendar
        calendar.render();

        // Make calendar globally accessible
        window.calendar = calendar;

        // Add smooth transitions
        setTimeout(() => {
            document.querySelectorAll('.fc-event').forEach(event => {
                event.style.transition = 'all 0.3s ease';
            });
        }, 500);

    }, 300);

    // Event Details Modal Function
    function showEventDetails(event) {
        const modal = `
            <div class="modal fade" id="eventModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-gradient-primary text-white">
                            <h5 class="modal-title fw-bold">
                                <i class="fas fa-calendar-check me-2"></i>
                                Event Details
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h6 class="text-primary fw-bold">${event.title}</h6>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted">Start Time</small>
                                    <div class="fw-semibold">${event.start.toLocaleString()}</div>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted">End Time</small>
                                    <div class="fw-semibold">${event.end.toLocaleString()}</div>
                                </div>
                                ${event.extendedProps.room ? `
                                <div class="col-12 mb-2">
                                    <small class="text-muted">Room</small>
                                    <div class="fw-semibold">${event.extendedProps.room}</div>
                                </div>
                                ` : ''}
                                ${event.extendedProps.description ? `
                                <div class="col-12 mb-2">
                                    <small class="text-muted">Description</small>
                                    <div class="fw-semibold">${event.extendedProps.description}</div>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remove existing modal
        const existingModal = document.getElementById('eventModal');
        if (existingModal) existingModal.remove();
        
        // Add new modal
        document.body.insertAdjacentHTML('beforeend', modal);
        
        // Show modal
        const modalInstance = new bootstrap.Modal(document.getElementById('eventModal'));
        modalInstance.show();
    }

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (!window.calendar) return;
        
        switch(e.key) {
            case 'ArrowLeft':
                if (e.ctrlKey) {
                    e.preventDefault();
                    window.calendar.prev();
                }
                break;
            case 'ArrowRight':
                if (e.ctrlKey) {
                    e.preventDefault();
                    window.calendar.next();
                }
                break;
            case 't':
                if (e.ctrlKey) {
                    e.preventDefault();
                    window.calendar.today();
                }
                break;
        }
    });
});
</script>
@endpush