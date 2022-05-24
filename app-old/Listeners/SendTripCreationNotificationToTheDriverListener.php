<?php

namespace App\Listeners;

use App\Events\NewTripHasCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Models\Trip;
use App\Models\Driver;
use App\Http\Controllers\Api\CustomersTripsController;
use App\Models\TripRequestLog;
use GuzzleHttp\Promise\Create;

//use App\Traits\FormatApiResponseData;

class SendTripCreationNotificationToTheDriverListener
{

    //use FormatApiResponseData;
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
     * @param  NewTripHasCreatedEvent  $event
     * @return void
     */
    public function handle(NewTripHasCreatedEvent $event)
    {
        //The trip model send from Event
        $trip   =   $event->trip;
        $trip_details   =   $event->trip_details;

        //Send push notification to nearby drivers by fetching the trip start location from trip
        $fcm_server_key = config('fcm.fcm_app_key');
        $km = 0.008997742; //1 km = 0.008997742 degree
        $drivers_distance = 5;
        $query      = Driver::Distance('location', $trip->from_location, $drivers_distance * $km)->active()->available();
        $driver_ids = $query->take(5)->pluck('user_id');
        //dd($query->toSql());
        //$driver_ids =  [4];
        //Log the notifications
        if (count($driver_ids)) {
            foreach ($driver_ids as $key => $user_id) {
                TripRequestLog::create(['user_id' => $user_id, 'trip_id' => $trip->id, 'status' => 0]);
            }
            //Log the notifications
        }
        if(count($driver_ids)){
            $device_tokens = DB::table('user_devices')->whereIn('user_id', $driver_ids)->pluck('device_token')->toArray();
            foreach($device_tokens as $token){
                $notificationData = [
                    'to' => $token,
                    'notification' => [
                        'title' => 'New Trip Request',
                        'body' => 'You have a new trip request.',
                    ],
                    'data' => [
                        'trip_details' => $trip_details,
                    ]
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:key=' . $fcm_server_key));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_exec($ch);
                curl_close($ch);
            }
            //Update the trip to Pending status after sending the notification
            $trip->status = '2';
            $trip->save();
        }
    }
}
