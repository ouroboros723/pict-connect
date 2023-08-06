<?php

namespace App\Events;

use http\Exception\RuntimeException;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Log;
use LogicException;

class PublicEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $event_kind;
    private ?int $delete_target_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event_kind, $delete_target_id = null)
    {
        $this->event_kind = $event_kind;
        $this->delete_target_id = $delete_target_id;
        Log::info('publicEvent constructed.');
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
        Log::info('broadcasting message.');
        if($this->event_kind === 'new_photo') {
            return [
                'message' => 'new_photo_posted',
            ];
        }

        if($this->event_kind === 'photo_deleted') {
            return [
                'message' => 'photo_deleted',
                'delete_target_id' => $this->delete_target_id,
            ];
        }

        throw new LogicException('invalid_event_kind');

    }
}
