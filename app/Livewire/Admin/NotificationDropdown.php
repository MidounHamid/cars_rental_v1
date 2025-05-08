<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Notification;

class NotificationDropdown extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    protected $listeners = ['notificationReceived' => 'refreshNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Notification::with(['booking.user', 'booking.car'])
            ->latest()
            ->take(5)
            ->get();

        $this->unreadCount = Notification::where('is_read', false)->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        $this->loadNotifications();
    }

    public function refreshNotifications()
    {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.admin.notification-dropdown');
    }
} 