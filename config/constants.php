<?php

return [

        'New'=>1,

        'Pending'=>2,

        'No_driver_available'=>3,

        'Driver_accepted'=>4,

        'Driver_reached_pickup_location'=>5,

        'Trip_started'=>6,

        'Reached_destination'=>7,

        'Completed_trip'=>8,

        'Money_collected'=>9,

        'Trip_cancelled_by_driver'=>10,

        'Trip_cancelled_by_customer'=>11,


        'Mada'=>1,
        'Cash'=>2,
        'Wallet'=>3,
        'Card'=>4,

        // 'Mastercard'=>3,

        // 'Visa'=>4,

        // 'Visa Electron'=>5,

        // 'RuPay'=>6,

        // 'Maestro'=>7,

        // 'Contactless'=>10,

        'CHAT_SOCKET_PORT' => env('CHAT_SOCKET_PORT'),
        'CHAT_SOCKET_HOST' => env('CHAT_SOCKET_HOST'),
        'CHAT_SOCKET_CLIENT' => env('CHAT_SOCKET_CLIENT')

];

