<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class RealTimeController extends TripsController
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
     * Display a listing of the services.
     *
     * @return Illuminate\View\View
     */
    public function realMap(Request $request)
    {
       $trips=$this->getCurrentTrips();
       return view('real-time.index', compact('trips'));
    }


}
