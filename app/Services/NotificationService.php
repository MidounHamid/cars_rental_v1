<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Booking;
use App\Events\NewNotification;

class NotificationService
{
    public function createBookingNotification(Booking $booking, string $type)
    {
        $message = $this->generateNotificationMessage($booking, $type);
        
        $notification = Notification::create([
            'booking_id' => $booking->id,
            'type' => $type,
            'message' => $message
        ]);

        // Broadcast the notification
        broadcast(new NewNotification($notification))->toOthers();

        return $notification;
    }

    private function generateNotificationMessage(Booking $booking, string $type): string
    {
        $carInfo = "{$booking->car->brand->name} {$booking->car->model}";
        $userInfo = "{$booking->user->name} ({$booking->user->email})";
        $dates = "from " . $booking->start_date->format('M d, Y') . " to " . $booking->end_date->format('M d, Y');

        switch ($type) {
            case 'booking_confirmation':
                return "New booking confirmed for {$carInfo} by {$userInfo} {$dates}";
            case 'booking_cancellation':
                return "Booking cancelled for {$carInfo} by {$userInfo} {$dates}";
            case 'booking_completion':
                return "Booking completed for {$carInfo} by {$userInfo} {$dates}";
            default:
                return "Booking status updated for {$carInfo} by {$userInfo} {$dates}";
        }
    }
} 