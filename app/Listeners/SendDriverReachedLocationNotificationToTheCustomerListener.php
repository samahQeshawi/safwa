<?php

namespace App\Listeners;

use App\Events\DriverHasReachedTheLocationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDriverReachedLocationNotificationToTheCustomerListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DriverHasReachedTheLocationEvent  $event
     * @return void
     */
    public function handle(DriverHasReachedTheLocationEvent $event)
    {
        //
    }
}
