<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Trip;
use App\Models\Service;
use App\Models\Rating;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Exception;
use DataTables;
use PDF;
use DB;

class TripsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
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
     * Display a listing of the categories.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request, $trip_type = 0)
    {
        /**
         * Ajax call by datatable for listing of the cartype.
         */
        if ($request->ajax()) {
            if ($trip_type) {
                $type = ($trip_type == '1') ? 'Now' : 'Later';
                if ($type) {
                    $data = Trip::with('customer')->where('is_now_trip', 1)->get();
                } else {
                    $data = Trip::with('customer')->where('is_now_trip', 0)->get();
                }
            } else {
                $data = Trip::with('customer')->latest()->get();
            }
            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['trip_no']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($trip) {
                    return view('trip.datatable', compact('trip'));
                })
                 ->addColumn('trip_status', function ($trip) {
                    return view('trip.trip_status', compact('trip'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }

        $trip = Trip::paginate(25);

        return view('trip.index', compact('trip', 'trip_type'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $driver = User::where('user_type_id', 3)->pluck('users.name', 'users.id')->all();
        $customer = User::where('user_type_id', 4)->pluck('users.name', 'users.id')->all();
        $car = Car::pluck('car_name', 'id')->all();
        $services = Service::pluck('service', 'id')->all();
        $payment_method = PaymentMethod::pluck('name', 'id')->all();
        return view('trip.create', compact('driver', 'customer', 'car', 'services', 'payment_method'));
    }

    /**
     * Store a new category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);
        $trip = Trip::orderBy('id', 'DESC')->first();
        if ($trip) {
            $no_only      = substr($trip->trip_no, 2);
            $idno = ltrim($no_only, '0');
            $trip_no = $idno + 1;
        } else {
            $trip_no = 1;
        }
        $next_number = str_pad($trip_no, 10, "0", STR_PAD_LEFT);
        $data['trip_no'] = 'TR' . $next_number;
        $data['pickup_on'] =  date('Y-m-d H:i:s', strtotime($request->pickup_on));
        $data['dropoff_on'] =  date('Y-m-d H:i:s', strtotime($request->dropoff_on));
        $data['from_location'] = new Point($data['trip_pickup_latitude'], $data['trip_pickup_longitude']);
        $data['from_location_lat'] = $data['trip_pickup_latitude'];
        $data['from_location_lng'] = $data['trip_pickup_longitude'];
        $data['to_location'] = new Point($data['trip_drop_latitude'], $data['trip_drop_longitude']);
        $data['to_location_lat'] = $data['trip_drop_latitude'];
        $data['to_location_lng'] = $data['trip_drop_longitude'];

        $category = Category::with('categoryConfiguration')->where('is_active', 1)->where('id', $request->categoryId)->first();

        $total_amount   =   0;
        if (isset($category) && isset($category['categoryConfiguration'])) {
            $distance = $this->distance($request->trip_pickup_latitude, $request->trip_pickup_longitude, $request->trip_drop_latitude, $request->trip_drop_longitude, "K");
            $total_amount = $this->calculate_amount($category, $distance);
            $data['amount'] = $total_amount;
            $data['total_amount'] = $total_amount;
        }

        Trip::create($data);

        return redirect()->route('trip.index')
            ->with('success_message', trans('trip.model_was_added'));
    }

    /**
     * Display the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $trip = Trip::with('customer', 'driver', 'car', 'service', 'category', 'paymentMethod')->findOrFail($id);

        return view('trip.show', compact('trip'));
    }

    /**
     * Display the specified Booking invoice.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function showInvoice($id)
    {
        $trip = Trip::with('customer', 'driver', 'car')->findOrFail($id);
        return view('trip.invoice', compact('trip'));
    }
    /**
     * Display the specified Trip invoice.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function printInvoice($id)
    {
        $trip = Trip::with('customer', 'driver', 'car')->findOrFail($id);
        return view('trip.invoice_print', compact('trip'));
    }

    /**
     * Print the pdf  invoice.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function pdfInvoice($id)
    {
        $data['trip'] =  Trip::with('customer', 'driver', 'car')->findOrFail($id);;
        //return Excel::download(new InvoicesExport($booking), 'invoice'.time().'.pdf');
        $pdf = PDF::loadView('trip.invoice_pdf', $data);
        return $pdf->download('invoice' . time() . '.pdf');
    }
    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        $driver = User::where('user_type_id', 3)->pluck('users.name', 'users.id')->all();
        $customer = User::where('user_type_id', 4)->pluck('users.name', 'users.id')->all();
        $car = Car::pluck('car_name', 'id')->all();
        $services = Service::pluck('service', 'id')->all();
        $category = null;
        if ($trip->service_id) {
            $categories = Category::where('service_id', $trip->service_id)->pluck('category', 'id')->all();
        }
        $payment_method = PaymentMethod::pluck('name', 'id')->all();
        /* $from_lat = optional($trip->from_location)->getLat();
        $from_lng = optional($trip->from_location)->getLng(); */
        $trip['trip_pickup_latitude']  =  $trip->from_location_lat;
        $trip['trip_pickup_longitude']  =  $trip->from_location_lng;
        /* $to_lat = optional($trip->to_location)->getLat();
        $to_lng = optional($trip->to_location)->getLng(); */
        $trip['trip_drop_latitude']  =  $trip->to_location_lat;;
        $trip['trip_drop_longitude']  =  $trip->to_location_lng;;
        return view('trip.edit', compact('trip', 'driver', 'customer', 'car', 'services', 'payment_method', 'categories'));
    }

    /**
     * Update the specified category in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);
        $trip = Trip::findOrFail($id);
        // $data['pickup_on'] =  date('Y-m-d H:i:s', strtotime($request->pickup_on));
        // $data['dropoff_on'] =  date('Y-m-d H:i:s', strtotime($request->dropoff_on));
        // $data['from_location'] = new Point($data['trip_pickup_latitude'], $data['trip_pickup_longitude']);
        // $data['from_location_lat'] = $data['trip_pickup_latitude'];
        // $data['from_location_lng'] = $data['trip_pickup_longitude'];
        // $data['to_location'] = new Point($data['trip_drop_latitude'], $data['trip_drop_longitude']);
        // $data['to_location_lat'] = $data['trip_drop_latitude'];
        // $data['to_location_lng'] = $data['trip_drop_longitude'];
        // if($data['payment_status'] == 1){
        //     $data['status'] = 9;
        // }

        $trip->update($data);

        return redirect()->route('trip.index')
            ->with('success_message', trans('trip.model_was_updated'));
    }

    /**
     * Remove the specified category from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $trip = Trip::findOrFail($id);
            $trip->delete();

            return redirect()->route('trip.index')
                ->with('success_message', trans('trip.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('trip.unexpected_error')]);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            // 'pickup_on' => 'required',
            // 'dropoff_on' =>  'required',
            // 'from_address' => 'required',
            // //'from_location'=> 'required',
            // 'trip_pickup_latitude' => 'required',
            // 'trip_pickup_longitude' => 'required',
            // 'to_address' => 'required',
            // //'to_location' => 'required',
            // 'trip_drop_latitude' => 'required',
            // 'trip_drop_longitude' => 'required',
            // 'distance' => 'required',
            // 'km_charge' => 'required',
            // 'cancellation_charge' => 'required',
            // 'minimum_charge'    => 'required',
            // 'amount' => 'required',
            // 'discount' => 'required',
            // 'tax' => 'required',
            // 'final_amount' => 'required',
            // 'customer_id' => 'required',
            // 'driver_id' => 'required',
            // 'car_id' => 'required',
            'status' => 'nullable'
            // 'service_id' => 'nullable',
            // 'category_id' => 'nullable',
            // 'payment_method' => 'nullable',
        ];

        $data = $request->validate($rules);
        $data['is_now_trip'] = $request->has('is_now_trip');
        $data['payment_status'] = $request->has('payment_status');
        return $data;
    }
    public function getCategories(Request $request)
    {
        $categories = [];
        if ($request->has('id')) {
            $categories = Category::select("id", "category")
                ->where('service_id', $request->id)
                ->get();
        }
        return response()->json($categories);
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function calculate_amount($data, $distance)
    {
        $total_amount = $data->categoryConfiguration->km_charge * $distance;

        if ($data->categoryConfiguration->minimum_charge > $total_amount) {
            $total_amount = $data->categoryConfiguration->minimum_charge;
        }

        return number_format($total_amount, 2, '.', '');
    }


    /// ========== New for real-time tracking
    public function getCurrentTrips()
    {
        /*
                $x=Trips::select('users.id as user_id','trips.id','trips.trip_no','users.name','users.email','users.phone','users.profile_image','cars.color','cars.car_name','trips.from_location_lat','trips.from_location_lng')
                    //->join('drivers','drivers.id','=','trips.driver_id')
                    ->join('users','users.id','=','trips.driver_id')
                    ->join('cars','trips.car_id','=','cars.id')
                    ->whereIn('trips.status', array(4,5,6,7,8,9))
                    ->get();
        */
        // $x = DB::table('trips')
        //     ->select('users.phone', 'users.email', 'trips.status', 'users.id as user_id', 'trips.id', 'trips.trip_no', 'users.name', 'users.email', 'users.phone', 'users.profile_image', 'cars.color', 'cars.car_name', 'trips.from_location_lat', 'trips.from_location_lng')
        //     ->join('users', 'users.id', '=', 'trips.driver_id')
        //     ->join('cars', 'trips.car_id', '=', 'cars.id')
        //     ->whereIn('trips.status', array(4, 5, 6, 7, 8, 9))
        //     ->get();
        // $x = DB::table('trips')
        //     ->select('users.phone', 'users.email', 'trips.status', 'users.id as user_id', 'trips.id', 'trips.trip_no', 'users.name', 'users.email', 'users.phone', 'users.profile_image', 'cars.color', 'cars.car_name', 'trips.from_location_lat as lat', 'trips.from_location_lng as lng')
        //     ->join('users', 'users.id', '=', 'trips.driver_id')
        //     ->join('cars', 'trips.car_id', '=', 'cars.id')
        //     ->whereIn('trips.status', array(4, 5, 6, 7, 8, 9))
        //     ->get();


        $x = DB::table('trips')
            ->select('users.phone','users.email','trips.status','users.id as user_id','trips.id','trips.trip_no','users.name','users.email','users.phone','users.profile_image','cars.color','cars.car_name','trips.from_location_lat','trips.from_location_lng','trip_trackings.lat','trip_trackings.lng')
            ->join('users','users.id','=','trips.driver_id')
            ->join('cars','trips.car_id','=','cars.id')
            ->join('trip_trackings','trip_trackings.trip_id','=','trips.id')
            // ->whereIn('trips.status', array(4,5,6,7,8,9))
            ->get();


        // dd($x);
        /*

                foreach ($x as $user) {
                    echo $user->name."<br>";
                }
        dd();
        */
        return $x;
    }


}
