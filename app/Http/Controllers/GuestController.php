<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends TripsController
{
    //

    public function __construct()
    {
    }

    public function gps(){
        $trips=$this->getCurrentTrips();
        return view('gps',['trips'=>$trips]);

    }
    public function move(Request $request){
        return view('move1')->with([
            'token' => $request->token,
            'trip_id' => $request->trip_id,
        ]);
    }

    public function d(){

        return view('d');

    }
    public function d2(){

        return view('d2');

    }

}
