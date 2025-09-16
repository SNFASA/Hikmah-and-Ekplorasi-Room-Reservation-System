@extends('frontend.layouts.master')
@section('title','Schedule Reserved Room')
@section('main-content')
<div class="modern-profile-container">
    <div class="profile-header">
        <div class="container">
            <h2 class="profile-title">
                <i class="fas fa-calendar-alt me-3"></i>
                Room Schedule
            </h2>
            <p class="profile-subtitle">View and manage reserved room schedules</p>
        </div>
    </div>

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="modern-calendar-card">
                    <div class="calendar-card-header">
                        <h4 class="calendar-title">
                            <i class="fas fa-clock me-2"></i>
                            Schedule Overview
                        </h4>
                        <div class="calendar-controls">
                            <div class="calendar-view-buttons">
                                <button id="weekViewBtn" class="calendar-control-btn active" data-view="timeGridWeek">
                                    <i class="fas fa-calendar-week me-1"></i>
                                    Week
                                </button>
                                <button id="dayViewBtn" class="calendar-control-btn" data-view="timeGridDay">
                                    <i class="fas fa-calendar-day me-1"></i>
                                    Day
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="calendar-card-body">
                        <div id="calendar" class="modern-calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Details Modal (Static HTML) -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow modern-modal">
            <div class="modal-header text-white modern-modal-header" id="modalHeader">
                <h5 class="modal-title fw-bold d-flex align-items-center mx-3" id="modalTitle">
                    <i class="fas fa-calendar me-2"></i>
                    Event Details
                </h5>
                <button type="button" class="btn-close btn-close-white modern-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body modern-modal-body" id="modalBody">
                <!-- Dynamic content will be inserted here -->
            </div>
            <div class="modal-footer border-0 modern-modal-footer">
                <button type="button" class="btn btn-outline-secondary modern-btn-secondary" data-bs-dismiss="modal" id="closeModalBtn">
                    <i class="fas fa-times me-1"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<style>
/* Modern Event Details Modal */
.modern-modal {
    border-radius: 20px;
    overflow: hidden;
    backdrop-filter: blur(20px);
}

.modern-modal-header {
    background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
    border: none;
    padding: 2rem 2rem;
    position: relative;
    overflow: hidden;
    border-radius: 20px 20px 20px 20px;
}

.modern-modal-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
    pointer-events: none;
}

.bg-gradient-danger.modern-modal-header {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.modern-close-btn {
    opacity: 0.9;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.2) !important;
    border-radius: 50% !important;
    width: 35px !important;
    height: 35px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border: none !important;
    color: white !important;
    font-size: 14px !important;
}

.modern-close-btn:hover {
    opacity: 1 !important;
    background: rgba(255, 255, 255, 0.3) !important;
    transform: scale(1.1) !important;
    color: white !important;
}

.modern-close-btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25) !important;
    background: rgba(255, 255, 255, 0.3) !important;
    color: white !important;
}

.modern-modal-body {
    background: linear-gradient(135deg, #fafbff 0%, #f8f9ff 100%);
    min-height: 300px;
}

.event-details-container {
    position: relative;
}

.event-title-section {
    text-align: center;
    position: relative;
}

.event-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
}

.event-badge.event-booked {
    background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(26, 22, 96, 0.3);
}

.event-badge.event-invalid {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.event-badge.event-default {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
}

.event-title-text {
    color: #1a1660;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 0;
    word-break: break-word;
}

.detail-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 20px rgba(26, 22, 96, 0.08);
    border: 2px solid rgba(26, 22, 96, 0.05);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.detail-card:hover {
    box-shadow: 0 8px 30px rgba(26, 22, 96, 0.15);
    transform: translateY(-2px);
    border-color: rgba(26, 22, 96, 0.1);
}

.detail-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.detail-content {
    flex: 1;
    min-width: 0;
}

.detail-label {
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
    display: block;
}

.detail-value {
    color: #1a1660;
    font-weight: 700;
    font-size: 1rem;
    word-break: break-word;
}

.modern-modal-footer {
    background: white;
    padding: 1.5rem 2rem;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.modern-btn-secondary {
    border-radius: 50px !important;
    padding: 0.75rem 1.5rem !important;
    font-weight: 600 !important;
    border: 2px solid #dee2e6 !important;
    transition: all 0.3s ease !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
    background: white !important;
    color: #6c757d !important;
}

.modern-btn-secondary:hover {
    background: red!important;
    border-color: #adb5bd !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    color: white !important;
}

.modern-btn-secondary:focus {
    background: #f8f9fa !important;
    border-color: #adb5bd !important;
    color: #495057 !important;
    box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25) !important;
}

.modern-btn-primary {
    background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
    border: none;
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(26, 22, 96, 0.3);
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #141050 0%, #252269 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(26, 22, 96, 0.4);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var eventModalElement = document.getElementById('eventModal');
    var eventModal = new bootstrap.Modal(eventModalElement);
    
    // Add event listener for close button
    document.getElementById('closeModalBtn').addEventListener('click', function() {
        eventModal.hide();
    });
    
    // Add event listener for X button in header
    document.querySelector('.modern-close-btn').addEventListener('click', function() {
        eventModal.hide();
    });
    
    // Add event listener for clicking outside modal
    eventModalElement.addEventListener('click', function(e) {
        if (e.target === eventModalElement) {
            eventModal.hide();
        }
    });
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        slotMinTime: '08:00:00',
        slotMaxTime: '19:00:00',
        events: @json($events),
        
        eventClassNames: function(info) {
            const title = info.event.title || '';
            if (title.includes('Blocked:') || title.includes('Invalid:')) {
                return ['fc-event-invalid']; 
            } else if (title.includes('Booked:')) {
                return ['fc-event-booked']; 
            } else if (title.includes('Reserved:')) {
                return ['fc-event-reserved'];
            }
            return []; 
        },
        
        eventContent: function (info) {
            var container = document.createElement('div');
            container.style.display = 'flex';
            container.style.flexDirection = 'column';
            container.style.alignItems = 'flex-start';
            container.style.width = '100%';
            container.style.color = '#fff';
            container.style.fontSize = '0.8rem';
            
            var timeEl = document.createElement('div');
            timeEl.className = 'fc-event-time';
            timeEl.innerHTML = `<i class="fas fa-clock me-1"></i>${info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
            
            var titleEl = document.createElement('div');
            titleEl.className = 'fc-event-title';
            titleEl.style.fontWeight = 'bold';
            titleEl.style.marginTop = '2px';
            
            const title = info.event.title || 'No Title';
            if (title.includes('Blocked:') || title.includes('Invalid:')) {
                titleEl.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i>${title}`;
            } else if (title.includes('Booked:')) {
                titleEl.innerHTML = `<i class="fas fa-bookmark me-1"></i>${title}`;
            } else if (title.includes('Reserved:')) {
                titleEl.innerHTML = `<i class="fas fa-calendar-check me-1"></i>${title}`;
            } else {
                titleEl.innerHTML = `<i class="fas fa-calendar me-1"></i>${title}`;
            }
            
            container.appendChild(timeEl);
            container.appendChild(titleEl);
            
            return { domNodes: [container] };
        },
        
        eventOverlap: false,
        slotEventOverlap: false,
        height: 'auto',
        nowIndicator: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        
        loading: function(isLoading) {
            if (isLoading) {
                document.querySelector('.modern-calendar').innerHTML =
                    '<div class="d-flex justify-content-center align-items-center" style="min-height: 300px;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            }
        },
        
        eventDidMount: function(info) {
            info.el.setAttribute(
                'title',
                `${info.event.title}\n${info.event.start.toLocaleString()} - ${info.event.end.toLocaleString()}`
            );
        },
        
        eventClick: function(info) {
            showEventDetails(info.event);
        }
    });
    
    // Helper function to calculate duration
    function calculateDuration(start, end) {
        const diff = end - start;
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        
        if (hours > 0 && minutes > 0) {
            return `${hours}h ${minutes}m`;
        } else if (hours > 0) {
            return `${hours}h`;
        } else {
            return `${minutes}m`;
        }
    }
    
    // Event Details Modal Function
    function showEventDetails(event) {
        const title = event.title || 'No Title';
        let eventTypeClass = 'bg-primary';
        let eventTypeIcon = 'fas fa-calendar';
        let badgeClass = 'bg-secondary';
        let eventType = 'Event';
        
        if (title.includes('Blocked:') || title.includes('Invalid:')) {
            eventTypeClass = 'bg-danger';
            eventTypeIcon = 'fas fa-exclamation-triangle';
            badgeClass = 'bg-danger';
            eventType = 'Blocked/Invalid';
        } else if (title.includes('Booked:')) {
            eventTypeClass = 'bg-success';
            eventTypeIcon = 'fas fa-bookmark';
            badgeClass = 'bg-success';
            eventType = 'Confirmed Booking';
        } else if (title.includes('Reserved:')) {
            eventTypeClass = 'bg-info';
            eventTypeIcon = 'fas fa-calendar-check';
            badgeClass = 'bg-info';
            eventType = 'Facility Reserved';
        }
        
        // Update modal header
        const modalHeader = document.getElementById('modalHeader');
        modalHeader.className = `modal-header text-white modern-modal-header ${eventTypeClass}`;
        
        const modalTitle = document.getElementById('modalTitle');
        modalTitle.innerHTML = `<i class="${eventTypeIcon} me-2"></i>Event Details`;
        
        // Update modal body
        const modalBody = document.getElementById('modalBody');
        modalBody.innerHTML = `
            <div class="event-details-container p-4">
                <div class="event-title-section mb-4">
                    <div class="event-badge ${eventType === 'Blocked/Invalid' ? 'event-invalid' : eventType === 'Confirmed Booking' ? 'event-booked' : 'event-default'} mb-2">
                        <i class="${eventTypeIcon} me-1"></i>
                        ${eventType}
                    </div>
                    <h4 class="event-title-text mb-0">${title}</h4>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-play text-success"></i>
                            </div>
                            <div class="detail-content">
                                <small class="detail-label">Start Time</small>
                                <div class="detail-value">${event.start.toLocaleString()}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-stop text-danger"></i>
                            </div>
                            <div class="detail-content">
                                <small class="detail-label">End Time</small>
                                <div class="detail-value">${event.end.toLocaleString()}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                            <div class="detail-content">
                                <small class="detail-label">Duration</small>
                                <div class="detail-value">${calculateDuration(event.start, event.end)}</div>
                            </div>
                        </div>
                    </div>
                    
                    ${event.extendedProps && event.extendedProps.room ? `
                    <div class="col-12">
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-door-open text-info"></i>
                            </div>
                            <div class="detail-content">
                                <small class="detail-label">Room</small>
                                <div class="detail-value">${event.extendedProps.room}</div>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                    
                    ${event.extendedProps && event.extendedProps.description ? `
                    <div class="col-12">
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-align-left text-muted"></i>
                            </div>
                            <div class="detail-content">
                                <small class="detail-label">Description</small>
                                <div class="detail-value">${event.extendedProps.description}</div>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
        
        // Show modal
        eventModal.show();
    }
    
    calendar.render();
    
    // Custom view buttons functionality
    document.getElementById('weekViewBtn').addEventListener('click', function() {
        calendar.changeView('timeGridWeek');
        updateActiveButton('weekViewBtn');
    });
    
    document.getElementById('dayViewBtn').addEventListener('click', function() {
        calendar.changeView('timeGridDay');
        updateActiveButton('dayViewBtn');
    });
    
    function updateActiveButton(activeId) {
        document.querySelectorAll('.calendar-control-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.getElementById(activeId).classList.add('active');
    }
});
</script>
@endpush