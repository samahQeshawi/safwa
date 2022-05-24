<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Driver;
use App\Models\Trip;
use Illuminate\Support\Facades\File;

class ChatController extends Controller
{
    //
    public function __construct()
    {
    }

    public function getCurrentTrips(){

        // $x = DB::table('trips')
        //     ->select('users.phone','users.email','trips.status','users.id as user_id','trips.id','trips.trip_no','users.name','users.email','users.phone','users.profile_image','cars.color','cars.car_name','trips.from_location_lat','trips.from_location_lng','trip_trackings.lat','trip_trackings.lng')
        //     ->join('users','users.id','=','trips.driver_id')
        //     ->join('cars','trips.car_id','=','cars.id')
        //     ->join('trip_trackings','trip_trackings.trip_id','=','trips.id')
        //     ->whereIn('trips.status', array(4,5,6,7,8,9))
        //     ->get();

        $x=Trip::select('trips.id','users.name','users.email','users.phone','users.profile_image','cars.color','cars.car_name')
            ->join('drivers','drivers.id','=','trips.driver_id')
            ->join('users','users.id','=','drivers.user_id')
            ->join('cars','trips.car_id','=','cars.id')
            ->where('trips.is_now_trip', 1)
            ->get();

        /*
        foreach ($x as $user) {
            echo $user->name;
        }
*/
        return $x;
    }


    public function preview_image(Request $request)
    {
        $path = storage_path('app/' . $request->file);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($file);
        return  $base64;
    }

    public function old_messages(Request $request)
    {
        $x = $request->user_id;
        $old_msgs = DB::table('messages')
            ->Where(function ($query) use ($x) {
                $query->Where(function ($query) use ($x) {
                    $query->where('sender_id', '=', 1)
                        ->where('receiver_id', '=', $x);
                })
                    ->orWhere(function ($query) use ($x) {
                        $query->where('sender_id', '=', $x)
                            ->where('receiver_id', '=', 1);
                    });
            })
            ->where('id', '<', $request->msg_id)
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();




        if ($old_msgs->count() > 0) {
            return response()->json(['code' => 0, 'messages' => $old_msgs]);
        }
        return response()->json(['code' => 8]);
    }

}
