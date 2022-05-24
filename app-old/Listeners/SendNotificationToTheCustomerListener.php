<?php

namespace App\Listeners;

use App\Events\DriverHasAcceptedTheTripEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SendNotificationToTheCustomerListener
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
     * @param  DriverHasAcceptedTheTripEvent  $event
     * @return void
     */
    public function handle(DriverHasAcceptedTheTripEvent $event)
    {
        //The trip model send from Event
        $trip   =   $event->trip;
        $trip_details   =   $event->trip_details;
        //Send push notification to the customer with trip details
        $fcm_server_key = config('fcm.fcm_app_key');

        $device_token_first = DB::table('user_devices')->where('user_id',$trip->customer_id)->pluck('device_token')->toArray();
        $device_token = count($device_token_first) ? $device_token_first[0] : [];
        $notificationData = [
            'to' => $device_token,
            'notification' => [
                'title' => 'Trip Accepted by the Driver',
                'body' => 'You are receiving a trip details',
            ],
            'data' => [
                'trip_details' => $trip_details
            ]
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:key=' . $fcm_server_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        //Update the trip to Pending status after sending the notification
        //$trip->status = '4';
        //$trip->save();
    }
}
