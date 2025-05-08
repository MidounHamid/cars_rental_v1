@extends('admin.layouts.app')

@section('content')
<div class="table-container">
    <div class="header-actions">
        <h1>Notifications</h1>
        <button id="markAllAsRead" class="btn btn-primary">Mark All as Read</button>
    </div>

    <div class="notifications-list">
        @forelse ($notifications as $notification)
            <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}" data-id="{{ $notification->id }}">
                <div class="notification-content">
                    <div class="notification-header">
                        <span class="notification-type">{{ ucfirst($notification->type) }}</span>
                        <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notification-message">{{ $notification->message }}</p>
                    <div class="notification-details">
                        <div class="car-info">
                            <strong>Car:</strong> {{ $notification->booking->car->brand->name }} {{ $notification->booking->car->model }}
                        </div>
                        <div class="user-info">
                            <strong>User:</strong> {{ $notification->booking->user->name }} ({{ $notification->booking->user->email }})
                        </div>
                        <div class="booking-dates">
                            <strong>Dates:</strong> {{ $notification->booking->start_date->format('M d, Y') }} - {{ $notification->booking->end_date->format('M d, Y') }}
                        </div>
                    </div>
                </div>
                @if (!$notification->is_read)
                    <button class="mark-as-read-btn" onclick="markAsRead({{ $notification->id }})">
                        <span class="material-symbols-rounded">check</span>
                    </button>
                @endif
            </div>
        @empty
            <div class="no-notifications">
                <p>No notifications found.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $notifications->links() }}
    </div>
</div>

@push('styles')
<style>
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .notification-item {
        background: white;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .notification-item.unread {
        border-left: 4px solid #2196f3;
    }

    .notification-content {
        flex: 1;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .notification-type {
        font-weight: 600;
        color: #2196f3;
    }

    .notification-time {
        color: #666;
        font-size: 0.9em;
    }

    .notification-message {
        margin: 8px 0;
        color: #333;
    }

    .notification-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-top: 12px;
        font-size: 0.9em;
        color: #666;
    }

    .mark-as-read-btn {
        background: none;
        border: none;
        color: #2196f3;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        transition: background-color 0.3s ease;
    }

    .mark-as-read-btn:hover {
        background-color: rgba(33, 150, 243, 0.1);
    }

    .no-notifications {
        text-align: center;
        padding: 40px;
        color: #666;
    }
</style>
@endpush

@push('scripts')
<script>
    function markAsRead(id) {
        fetch(`/admin/notifications/${id}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const notification = document.querySelector(`.notification-item[data-id="${id}"]`);
                notification.classList.remove('unread');
                notification.classList.add('read');
                notification.querySelector('.mark-as-read-btn').remove();
                updateNotificationCount();
            }
        });
    }

    document.getElementById('markAllAsRead').addEventListener('click', function() {
        fetch('/admin/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                    item.classList.add('read');
                    const markAsReadBtn = item.querySelector('.mark-as-read-btn');
                    if (markAsReadBtn) markAsReadBtn.remove();
                });
                updateNotificationCount();
            }
        });
    });

    function updateNotificationCount() {
        fetch('/admin/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.nav-btn .badge');
                if (badge) {
                    badge.textContent = data.count;
                    if (data.count === 0) {
                        badge.style.display = 'none';
                    } else {
                        badge.style.display = 'flex';
                    }
                }
            });
    }
</script>
@endpush
@endsection 