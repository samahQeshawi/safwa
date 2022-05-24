<?php

namespace App\Events;

use App\Models\Trip;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TheTripHasCompletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trip;
    public $trip_details;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Trip $trip, $trip_details)
    {
        $this->trip = $trip;
        $this->trip_details = $trip_details;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
