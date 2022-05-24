<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Booking;
use App\Models\Trip;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;
use Illuminate\Support\Facades\App;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Sets the language.
     *
    */
    public function lang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $roles = auth()->user()->getRoleNames();

        $total_customers = User::where('user_type_id',4)->count();;
        $total_cities = City::count();
        $total_drivers = User::where('user_type_id',3)->count();
        $total_bookings = Booking::count();
        $total_trip = Trip::count();
        $trips=$this->getCurrentTrips();
        return view('home', compact('total_customers','total_cities','total_drivers','total_bookings','total_trip','trips'));
    }

    public function getCurrentTrips()
    {
        


        $x = DB::table('trips')
            ->select('users.phone','users.email','trips.status','users.id as user_id','trips.id','trips.trip_no','users.name','users.email','users.phone','users.profile_image','cars.color','cars.car_name','trips.from_location_lat','trips.from_location_lng','trip_trackings.lat','trip_trackings.lng')
            ->join('users','users.id','=','trips.driver_id')
            ->join('cars','trips.car_id','=','cars.id')
            ->join('trip_trackings','trip_trackings.trip_id','=','trips.id')
            // ->whereIn('trips.status', array(4,5,6,7,8,9))
            ->get();


        return $x;
    }
}
