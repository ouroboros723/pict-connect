<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PhotoDeleteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $delete_target_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($delete_target_id)
    {
        $this->delete_target_id = $delete_target_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('event-lib');
    }

    public function broadcastWith()
    {
        return [
            'message' => 'photo_deleted',
            'delete_target_id' => $this->delete_target_id,
        ];
    }
}
