<?php

namespace App\Events;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateDriverLocationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $driver; //The user object
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $driver)
    {
        $this->driver = $driver;
      //  dd($driver);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('driverLocation');
    }


    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $driver = [
            'user_id' => $this->driver->id,
            'name' => $this->driver->name,
            'location' => $this->driver->driver->location,
            'lat' => $this->driver->driver->lat,
            'lng' => $this->driver->driver->lng
        ];
        //dd($driver);
        return $driver;
    }
}
