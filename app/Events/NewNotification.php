<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    /**
     * Create a new event instance.
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications'),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'notification' => [
                'id' => $this->notification->id,
                'type' => $this->notification->type,
                'message' => $this->notification->message,
                'created_at' => $this->notification->created_at->diffForHumans(),
                'booking' => [
                    'id' => $this->notification->booking->id,
                    'car' => [
                        'brand' => $this->notification->booking->car->brand->name,
                        'model' => $this->notification->booking->car->model,
                    ],
                    'user' => [
                        'name' => $this->notification->booking->user->name,
                        'email' => $this->notification->booking->user->email,
                    ],
                    'start_date' => $this->notification->booking->start_date->format('M d, Y'),
                    'end_date' => $this->notification->booking->end_date->format('M d, Y'),
                ],
            ],
        ];
    }
} 