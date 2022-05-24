<?php

namespace App\Listeners;

use App\Events\TripStatusHasUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SendTripStatusUpdateNotificationToTheCustomerListener
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
     * @param  TripStatusHasUpdatedEvent  $event
     * @return void
     */
    public function handle(TripStatusHasUpdatedEvent $event)
    {
        //The trip model send from Event
        $trip   =   $event->trip;
        $trip_details   =   $event->trip_details;

        if ($trip->status == 10){ //Trip cancelled by driver
            $title  =   "Trip has cancelled by the driver";
            $body  =    "Trip has cancelled by the driver";
            $user_id    =   $trip->customer_id;
        }elseif($trip->status == 11){  //Trip cancelled by customer
            $title  =   "Trip has cancelled by the customer";
            $body  =    "Trip has cancelled by the customer";
            $user_id    =   $trip->driver_id;
        }else{  //Trip status updated by driver
            $title  =   "Trip status has been updated";
            $body  =    "Trip status has been updated";
            $user_id    =   $trip->customer_id;
        }

        //Send push notification to the customer with trip details
        //$fcm_server_key = config('fcm.fcm_app_key');
        $fcm_server_key = 'AAAAIZKRCcs:APA91bFyYxr7FGgV88i9WcT23iKIjNkZS2exVhYUnhpmzmyxMH1CAIz2z2FYVP4ymr1wZ5q1J0nsCano9F8eGeT__XjBKISZrjcOy_x1oyMnGjFdcYh3P3JZUUazE8ITT8vMGM5OwzIY';
        $device_token_first = DB::table('user_devices')->where('user_id',$user_id)->pluck('device_token')->toArray();
        $device_token = count($device_token_first) ? $device_token_first[0] : [];
        $notificationData = [
            'to' => $device_token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => [
                'trip_details' => $trip_details
            ],
            'content_available' => 1
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:key=' . $fcm_server_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

    }
}
