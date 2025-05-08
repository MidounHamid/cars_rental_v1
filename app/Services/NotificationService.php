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
        $userName = $booking->user->name;
        $carInfo = "{$booking->car->brand->name} {$booking->car->model}";
        $dates = "from " . $booking->start_date->format('M d, Y') . " to " . $booking->end_date->format('M d, Y');

        switch ($type) {
            case 'booking_confirmation':
                return "User {$userName} has confirmed a booking for {$carInfo} {$dates}";
            case 'booking_cancellation':
                return "User {$userName} has cancelled a booking for {$carInfo} {$dates}";
            case 'booking_completion':
                return "User {$userName} has completed a booking for {$carInfo} {$dates}";
            default:
                return "Booking status updated for {$carInfo} by {$userName} {$dates}";
        }
    }
} 