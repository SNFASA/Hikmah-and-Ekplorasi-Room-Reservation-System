// Real-time Notifications JavaScript for existing dropdown structure

// Initialize Pusher
const pusher = new Pusher('126345336d8adfa7da65', {
    cluster: 'mt1',
    encrypted: true,
    forceTLS: true,
});

// Subscribe to admin notifications channel (only for admin users)
if (window.authUser && window.authUser.role === 'admin') {
    const channel = pusher.subscribe('private-admin-notifications');
    
    // Listen for new booking notifications
    channel.bind('new.booking', function(data) {
        console.log('New booking notification received:', data);
        showNotificationToast('New Booking', data.message);
        updateNotificationDropdown();
        updateNotificationCount();
        playNotificationSound();
    });
    
    // Listen for new reservation notifications
    channel.bind('new.reservation', function(data) {
        console.log('New reservation notification received:', data);
        showNotificationToast('New Reservation', data.message);
        updateNotificationDropdown();
        updateNotificationCount();
        playNotificationSound();
    });
}

// Function to show toast notification
function showNotificationToast(title, message) {
    // Using a simple toast implementation - you can replace with your preferred toast library
    if (typeof toastr !== 'undefined') {
        toastr.info(message, title, {
            timeOut: 5000,
            extendedTimeOut: 2000,
            showMethod: 'slideDown',
            hideMethod: 'slideUp'
        });
    } else {
        // Fallback: create custom toast
        const toast = document.createElement('div');
        toast.className = 'custom-notification-toast';
        toast.innerHTML = `
            <div class="toast-header">
                <strong>${title}</strong>
                <button type="button" class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
            <div class="toast-body">${message}</div>
        `;
        
        // Add CSS if not already present
        if (!document.querySelector('#notification-toast-styles')) {
            const style = document.createElement('style');
            style.id = 'notification-toast-styles';
            style.textContent = `
                .custom-notification-toast {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: #fff;
                    border: 1px solid #dee2e6;
                    border-radius: 0.375rem;
                    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
                    z-index: 1055;
                    min-width: 300px;
                    max-width: 400px;
                    animation: slideInRight 0.3s ease-out;
                }
                .toast-header {
                    padding: 0.5rem 0.75rem;
                    background-color: #f8f9fa;
                    border-bottom: 1px solid #dee2e6;
                    border-radius: 0.375rem 0.375rem 0 0;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                .toast-body {
                    padding: 0.75rem;
                    font-size: 0.875rem;
                }
                .toast-close {
                    background: none;
                    border: none;
                    font-size: 1.5rem;
                    cursor: pointer;
                    color: #6c757d;
                }
                @keyframes slideInRight {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            document.head.appendChild(style);
        }
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 5000);
    }
}

// Function to update notification count in the existing badge
function updateNotificationCount() {
    fetch('/notifications/count', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update the existing notification count elements
        const countSpans = document.querySelectorAll('.count');
        const badgeCounters = document.querySelectorAll('.badge-counter');
        
        countSpans.forEach(span => {
            const displayCount = data.count > 5 ? '5+' : data.count.toString();
            span.textContent = displayCount;
            span.setAttribute('data-count', data.count);
        });
        
        badgeCounters.forEach(badge => {
            badge.style.display = data.count > 0 ? 'inline' : 'none';
        });
    })
    .catch(error => {
        console.error('Error updating notification count:', error);
    });
}

// Function to refresh the notification dropdown
function updateNotificationDropdown() {
    fetch('/notifications/dropdown', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        // Update the dropdown content
        const dropdownMenu = document.querySelector('#alertsDropdown').nextElementSibling;
        if (dropdownMenu) {
            dropdownMenu.innerHTML = html;
        }
    })
    .catch(error => {
        console.error('Error updating notification dropdown:', error);
        // Fallback: just refresh the page after a short delay
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    });
}

// Function to play notification sound
function playNotificationSound() {
    // Create audio element if it doesn't exist
    let audio = document.getElementById('notification-sound');
    if (!audio) {
        audio = document.createElement('audio');
        audio.id = 'notification-sound';
        audio.preload = 'auto';
        // Simple notification beep using Web Audio API
        audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmUSBjuZ3/LKdSYEKHzJ7+GORA==';
        document.body.appendChild(audio);
    }
    
    // Play the sound
    audio.play().catch(error => {
        console.log('Could not play notification sound:', error);
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update notification count on page load
    updateNotificationCount();
    
    // Set up CSRF token for all AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        window.csrfToken = csrfToken.getAttribute('content');
    }
    
    // Add event listeners for notification actions if they exist
    setupNotificationEventListeners();
});

// Function to setup event listeners for notification interactions
function setupNotificationEventListeners() {
    // Mark as read when notification item is clicked
    document.addEventListener('click', function(e) {
        const notificationLink = e.target.closest('.dropdown-item[href*="/notifications/"]');
        if (notificationLink) {
            const href = notificationLink.getAttribute('href');
            const notificationId = href.split('/').pop().split('?')[0];
            
            // Mark as read via AJAX (optional, since the server will handle it)
            fetch(`/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).catch(error => {
                console.log('Error marking notification as read:', error);
            });
        }
    });
}

// Utility function to format time ago (for any dynamic content)
function formatTimeAgo(date) {
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) return 'Just now';
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
    return `${Math.floor(diffInSeconds / 86400)} days ago`;
}

// Optional: Auto-refresh notifications every 30 seconds as fallback
setInterval(() => {
    if (window.authUser && window.authUser.role === 'admin') {
        updateNotificationCount();
    }
}, 30000);