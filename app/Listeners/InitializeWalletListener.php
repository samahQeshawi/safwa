<?php

namespace App\Listeners;

use App\Events\NewDriverHasRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InitializeWalletListener
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
     * @param  NewDriverHasRegisteredEvent  $event
     * @return void
     */
    public function handle(NewDriverHasRegisteredEvent $event)
    {
        //
    }
}
