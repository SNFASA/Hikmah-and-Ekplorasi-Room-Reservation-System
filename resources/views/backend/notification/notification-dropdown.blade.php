<h6 class="dropdown-header">
  Notifications Center
</h6>

@if($notifications->count() > 0)
    @foreach($notifications as $notification)
        <a class="dropdown-item d-flex align-items-center" href="{{ route('notification.detail', $notification->id) }}">
            <div class="mr-3">
                <div class="icon-circle bg-primary">
                    <i class="fas {{ $notification->data['fas'] ?? 'fa-bell' }} text-white"></i>
                </div>
            </div>
            <div>
                <div class="small text-gray-500">{{ $notification->created_at->format('F d, Y h:i A') }}</div>
                <span class="@if($notification->unread()) font-weight-bold @else small text-gray-500 @endif">
                    {{ $notification->data['title'] ?? 'New Notification' }}
                </span>
            </div>
        </a>
        @if($loop->index + 1 == 5)
            @break
        @endif
    @endforeach
@else
    <div class="dropdown-item text-center text-gray-500">
        <i class="fas fa-inbox fa-2x mb-2"></i>
        <p class="mb-0">No notifications</p>
    </div>
@endif

<a class="dropdown-item text-center small text-gray-500" href="{{ route('notification.index') }}">
    Show All Notifications
</a>