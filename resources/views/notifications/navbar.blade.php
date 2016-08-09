@forelse($notifications as $notification)
    <li class="notification pad5 {{ $notification->getUnreadColorClass() }}">
        <div class="media">
            <div class="media-body notification-title">
                {!! $notification->body !!}

                <div class="notification-meta">
                    <small class="timestamp">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </li>
@empty
    <h3 class="text-center">No Notifications</h3>
@endforelse