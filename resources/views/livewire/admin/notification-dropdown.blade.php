<div>
    <div class="notification-dropdown" x-data="{ open: false }" @click.away="open = false">
        <button @click="open = !open" class="notification-trigger">
            <span class="material-symbols-rounded">notifications</span>
            @if($unreadCount > 0)
                <span class="notification-badge">{{ $unreadCount }}</span>
            @endif
        </button>

        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="notification-menu">
            <div class="notification-header">
                <h3>Notifications</h3>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="mark-all-read">
                        Mark all as read
                    </button>
                @endif
            </div>

            <div class="notification-list">
                @forelse($notifications as $notification)
                    <a href="{{ route('admin.notifications.show', $notification->id) }}" 
                       class="notification-item {{ !$notification->is_read ? 'unread' : '' }}" 
                       wire:key="notification-{{ $notification->id }}">
                        <div class="notification-content" wire:click="markAsRead({{ $notification->id }})">
                            <div class="notification-message">
                                <strong>{{ $notification->booking->user->name }}</strong> 
                                {{ strtolower($notification->type) }} a reservation
                            </div>
                            <div class="time-info">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="no-notifications">
                        <p>No notifications found</p>
                    </div>
                @endforelse
            </div>

            <div class="notification-footer">
                <a href="{{ route('admin.notifications.index') }}" class="view-all">
                    View all notifications
                </a>
            </div>
        </div>
    </div>

    <style>
        .notification-dropdown {
            position: relative;
        }

        .notification-trigger {
            position: relative;
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
        }

        .notification-trigger:hover {
            color: #2196f3;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #ff4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 350px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            margin-top: 8px;
            z-index: 1000;
        }

        .notification-header {
            padding: 16px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-header h3 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .mark-all-read {
            background: none;
            border: none;
            color: #2196f3;
            cursor: pointer;
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .mark-all-read:hover {
            background-color: rgba(33, 150, 243, 0.1);
        }

        .notification-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            display: block;
            text-decoration: none;
            color: inherit;
            padding: 16px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-item.unread {
            background-color: #f0f7ff;
        }

        .notification-message {
            font-size: 14px;
            color: #333;
            margin-bottom: 4px;
        }

        .time-info {
            color: #999;
            font-size: 12px;
        }

        .notification-footer {
            padding: 12px 16px;
            border-top: 1px solid #eee;
            text-align: center;
        }

        .view-all {
            color: #2196f3;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        .no-notifications {
            padding: 24px;
            text-align: center;
            color: #666;
        }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            window.Echo.private('notifications')
                .listen('NewNotification', (e) => {
                    @this.dispatch('notificationReceived');
                    
                    // Show SweetAlert notification
                    Swal.fire({
                        title: 'New Notification',
                        text: e.notification.message,
                        icon: 'info',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    });
                });
        });
    </script>
    @endpush
</div> 