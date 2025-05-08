<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with(['booking.user', 'booking.car'])
            ->latest()
            ->paginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function show(Notification $notification)
    {
        $notification->load(['booking.user', 'booking.car.brand']);
        
        // Mark notification as read
        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        return view('admin.notifications.show', compact('notification'));
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = Notification::where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }

    public function getRecent()
    {
        $notifications = Notification::with(['booking.user', 'booking.car'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            });

        return response()->json(['notifications' => $notifications]);
    }
} 