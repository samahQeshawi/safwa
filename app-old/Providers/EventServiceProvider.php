<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\NewCustomerHasRegisteredEvent::class => [
            \App\Listeners\InitializeWalletListener::class,
        ],
        \App\Events\NewDriverHasRegisteredEvent::class => [
            \App\Listeners\InitializeWalletListener::class,
        ],
        \App\Events\NewTripHasCreatedEvent::class => [
            \App\Listeners\SendTripCreationNotificationToTheDriverListener::class,
        ],
        \App\Events\DriverHasAcceptedTheTripEvent::class => [
            \App\Listeners\SendNotificationToTheCustomerListener::class,
        ],
        \App\Events\DriverHasCollectedTheMoneyEvent::class => [
            \App\Listeners\SendMoneyCollectedNotificationToTheCustomerListener::class,
        ],
        \App\Events\DriverHasReachedTheLocationEvent::class => [
            \App\Listeners\SendDriverReachedLocationNotificationToTheCustomerListener::class,
        ],
        \App\Events\TheTripHasCompletedEvent::class => [
            \App\Listeners\SendTripCompletionNotificationToTheCustomerListener::class,
        ],
        \App\Events\TripStatusHasUpdatedEvent::class => [
            \App\Listeners\SendTripStatusUpdateNotificationToTheCustomerListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
