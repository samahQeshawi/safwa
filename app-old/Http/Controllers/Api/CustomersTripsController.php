<?php

namespace App\Http\Controllers\Api;

use App\Events\NewTripHasCreatedEvent;
use App\Events\TripStatusHasUpdatedEvent;
use App\Http\Controllers\API\DriversController as DriversController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TripResource;
use App\Models\Car;
use App\Models\Trip;
use App\Models\Service;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponReport;
use App\Models\Driver;
use App\Models\DriverAvailableLog;
use App\Models\Rating;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TripRequestLog;
use App\Models\TripRoute;
use App\Models\User;
use App\Models\Customer;
use App\Models\UserCoupon;
use App\Models\Wallet;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\Http\Controllers\Api\AuthController;

//use App\Traits\FormatApiResponseData;

class CustomersTripsController extends Controller
{
    //use FormatApiResponseData;

    function __construct()
    {
        new Carbon();
    }

    public function myRidesList(Request $request)
    {
        $user_id = auth()->user()->id;
        $rules = [
            'from_date'       => 'date',
            'to_date'         => 'date|after_or_equal:from_date'
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.auth.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $from = Carbon::parse($request->from_date)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($request->to_date)->format('Y-m-d') . ' 23:59:59';

        $trip = Trip::with('car', 'service', 'paymentMethod', 'driver', 'customer')->where('customer_id', $user_id)->orderBy('id', 'DESC');
        if (isset($request->from_date) && isset($request->to_date)) {
            $trip = $trip->whereBetween('pickup_on', [$from, $to]);
        }

        $trip = $trip->simplePaginate(10);

        $trip->getCollection()->transform(function ($value) {
            return $this->formatTripDetails($value);
        });


        $message = 'Trips details retrieved successfully';
        $status_code    = 200;
        return response(['data' => $trip, 'message' => $message, 'status_code' => $status_code]);
    }


    public function formatTripDetails($row)
    {
        $newdata['id'] = $row->id;
        $newdata['is_now_trip'] = isset($row->is_now_trip) ? $row->is_now_trip : '';
        $newdata['trip_no'] = isset($row->trip_no) ? $row->trip_no : '';
        $newdata['service_id'] = isset($row->service_id) ? $row->service_id : '';
        $newdata['service_name'] = isset($row->service->service) ? $row->service->service : '';
        $newdata['customer_id'] = isset($row->customer_id) ? $row->customer_id : '';
        $newdata['customer_name'] = isset($row->customer->name) ? $row->customer->name : '';
        $newdata['driver_id'] = isset($row->driver_id) ? $row->driver_id : '';
        $newdata['driver_name'] = isset($row->driver->name) ? $row->driver->name : '';
        $newdata['car_id'] = isset($row->car_id) ? $row->car_id : '';
        $newdata['car_name'] = isset($row->car->car_name) ? $row->car->car_name : '';
        $newdata['from_address'] = isset($row->from_address) ? $row->from_address : '';
        $newdata['from_location_lat'] = optional($row->from_location)->getLat();
        $newdata['from_location_lng'] = optional($row->from_location)->getLng();
        $newdata['to_address'] = isset($row->to_address) ? $row->to_address : '';
        $newdata['to_location_lat'] = optional($row->to_location)->getLat();
        $newdata['to_location_lng'] = optional($row->to_location)->getLng();
        $newdata['pickup_on'] = Carbon::parse($row->pickup_on);
        $newdata['dropoff_on'] = Carbon::parse($row->dropoff_on);
        $newdata['distance'] = isset($row->distance) ? $row->distance : '';
        $newdata['category_id'] = isset($row->category_id) ? $row->category_id : '';
        $newdata['minimum_charge'] = isset($row->minimum_charge) ? $row->minimum_charge : '';
        $newdata['km_charge'] = isset($row->km_charge) ? $row->km_charge : '';
        $newdata['cancellation_charge'] = isset($row->cancellation_charge) ? $row->cancellation_charge : '';
        $newdata['amount'] = isset($row->amount) ? $row->amount : '';
        $newdata['discount'] = isset($row->discount) ? $row->discount : '';
        $newdata['tax'] = isset($row->tax) ? $row->tax : '';
        $newdata['final_amount'] = isset($row->final_amount) ? $row->final_amount : '';
        $newdata['payment_method_id'] = isset($row->payment_method_id) ? $row->payment_method_id : '';
        $newdata['payment_method_name'] = isset($row->payment_method) ? $row->payment_method : '';
        $newdata['payment_status'] = isset($row->payment_status) ? $row->payment_status : '';
        $newdata['status'] = isset($row->status) ? $row->status : '';

        return $newdata;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function userWallet($user_id)
    {
        return Wallet::where('user_id', $user_id)->pluck('amount')->first();
    }

    /**
     * Get the Rating for the user.
     *
     * @return App\Models\Rating
     */
    public function userRating($id)
    {
        $ratingObj    =   Rating::where('rated_for', $id);
        $rating       =   $ratingObj->avg('rating'); //Average of the collection
        $rating       =   number_format($rating, 1);
        return $rating;
    }

    /**
     * Get the Acceptance percentage of the driver.
     *
     * @return App\Models\Rating
     */
    public function driverAcceptance($id)
    {
        $tripLogObj     =   TripRequestLog::where('user_id', $id);
        $total          =   $tripLogObj->count();
        $accepted       =   $tripLogObj->accepted()->count();
        if (!$total) return '';
        $acceptance    =   number_format(100 * $accepted / $total, 2);
        return $acceptance;
    }

    /**
     * Get the Cancellation percentage of the driver.
     *
     * @return App\Models\Rating
     */
    public function driverCancellation($id)
    {
        $tripObj     =   Trip::where('driver_id', $id);
        $total       =   $tripObj->count();
        $cancelled   =   $tripObj->where('status', 10)->count();
        if (!$total) return '';
        $cancellation  =   number_format(100 * $cancelled / $total, 2);
        return $cancellation;
    }


    public function formatTripDetailsWithKey($row)
    {

        $newdata['trip']['id'] = $row->id;
        $newdata['trip']['is_now_trip'] = isset($row->is_now_trip) ? $row->is_now_trip : '';
        $newdata['trip']['trip_no'] = isset($row->trip_no) ? $row->trip_no : '';
        $newdata['trip']['service_id'] = isset($row->service_id) ? $row->service_id : '';
        $newdata['trip']['service_name'] = isset($row->service->service) ? $row->service->service : '';
        $newdata['customer']['user_id'] = isset($row->customer_id) ? $row->customer_id : ''; //This is the primary key of users table
        $newdata['customer']['name'] = isset($row->customer->name) ? $row->customer->name : '';
        $newdata['customer']['phone_code'] = isset($row->customer->country->phone_code) ? $row->customer->country->phone_code : '';
        $newdata['customer']['phone'] = isset($row->customer->phone) ? $row->customer->phone : '';
        $newdata['customer']['profile_image'] = isset($row->customer->profile_image) && file_exists(url('storage/app/' . $row->customer->profile_image)) ? url('storage/app/' . $row->customer->profile_image) : '';
        $newdata['customer']['email'] = isset($row->customer->email) ? $row->customer->email : '';
        $newdata['customer']['rating'] = isset($row->customer_id) ? $this->userRating($row->customer_id)  : '';
        $newdata['driver']['driver_id'] = isset($row->driver_id) ? $row->driver_id : '';
        $newdata['driver']['driver_name'] = isset($row->driver->name) ? $row->driver->name : '';
        $newdata['driver']['phone_code'] = isset($row->driver->country->phone_code) ? $row->driver->country->phone_code : '';
        $newdata['driver']['phone'] = isset($row->driver->phone) ? $row->driver->phone : '';
        $newdata['driver']['profile_image'] = isset($row->driver->profile_image) && file_exists(url('storage/app/' . $row->driver->profile_image)) ? url('storage/app/' . $row->driver->profile_image) : '';
        $newdata['driver']['wallet'] = isset($row->driver_id) ? $this->userWallet($row->driver_id)  : '';
        $newdata['driver']['rating'] = isset($row->driver_id) ? $this->userRating($row->driver_id)  : '';
        $newdata['driver']['acceptance'] = isset($row->driver_id) ? $this->driverAcceptance($row->driver_id)  : '';
        $newdata['driver']['cancellation'] = isset($row->driver_id) ? $this->driverCancellation($row->driver_id)  : '';
        $newdata['car']['car_id'] = isset($row->car_id) ? $row->car_id : '';
        $newdata['car']['car_name'] = isset($row->car->car_name) ? $row->car->car_name : '';
        $newdata['car']['registration_no'] = isset($row->car->registration_no) ? $row->car->registration_no : '';
        $newdata['car']['color'] = isset($row->car->color) ? $row->car->color : '';
        $newdata['trip']['from_address'] = isset($row->from_address) ? $row->from_address : '';
        $newdata['trip']['from_location_lat'] = isset($row->from_location_lat) ? $row->from_location_lat : '';
        $newdata['trip']['from_location_lng'] = isset($row->from_location_lng) ? $row->from_location_lng : '';
        $newdata['trip']['to_address'] = isset($row->to_address) ? $row->to_address : '';
        $newdata['trip']['to_location_lat'] = isset($row->to_location_lat) ? $row->to_location_lat : '';
        $newdata['trip']['to_location_lng'] = isset($row->to_location_lng) ? $row->to_location_lng : '';
        $newdata['trip']['pickup_on'] = Carbon::parse($row->pickup_on);
        $newdata['trip']['dropoff_on'] = Carbon::parse($row->dropoff_on);
        $newdata['trip']['distance'] = isset($row->distance) ? $row->distance : '';
        $newdata['trip']['category_id'] = isset($row->category_id) ? $row->category_id : '';
        $newdata['trip']['minimum_charge'] = isset($row->minimum_charge) ? $row->minimum_charge : '';
        $newdata['trip']['km_charge'] = isset($row->km_charge) ? $row->km_charge : '';
        $newdata['trip']['cancellation_charge'] = isset($row->cancellation_charge) ? $row->cancellation_charge : '';
        $newdata['trip']['driver_cancellation_notes'] = isset($row->driver_cancellation_notes) ? $row->driver_cancellation_notes : '';
        $newdata['trip']['customer_cancellation_notes'] = isset($row->customer_cancellation_notes) ? $row->customer_cancellation_notes : '';
        $newdata['trip']['amount'] = isset($row->amount) ? $row->amount : '';
        $newdata['trip']['discount'] = isset($row->discount) ? $row->discount : '';
        $newdata['trip']['tax'] = isset($row->tax) ? $row->tax : '';
        $newdata['trip']['final_amount'] = isset($row->final_amount) ? $row->final_amount : '';
        $newdata['trip']['payment_method_id'] = isset($row->payment_method_id) ? $row->payment_method_id : '';
        $newdata['trip']['payment_method_name'] = isset($row->payment_method) ? $row->payment_method : '';
        $newdata['trip']['payment_status'] = isset($row->payment_status) ? $row->payment_status : '';
        $newdata['trip']['status'] = isset($row->status) ? $row->status : '';

        return $newdata;
    }

    /* public function tripPaymentHistory($id){//Receive user id



    } */

    public function getServices(Request $request)
    {

        $services   = Service::where('is_active', 1)->get();
        $data    = [
            'services' => TripResource::collection($services)
        ];
        $message = 'Service retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function getCategory(Request $request)
    {
        $rules = [
            'serviceid'       => 'required',
            'fromlatitude' => 'required',
            'fromlongitude' => 'required',
            'tolatitude' => 'required',
            'tolongitude' => 'required',
            'fromaddress' => 'required',
            'toaddress' => 'required',
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.auth.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        // $service_id = $request->serviceid;
        // $car = $this->get_service_category_car($service_id,$request);
        // if (!isset($car)) {
        //     $errors = $validator->errors()->messages();
        //     $data   = null;
        //     $message    =   'No car available in this category.';
        //     $status_code   = 422;
        //     return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        // }

        $category   = Category::with('categoryConfiguration')->where('is_active', 1)->where('service_id', $request->serviceid)->get();

        $category = $this->formatCategoryDetails($category, $request);
        $data    = [
            'category' => TripResource::collection($category)
        ];
        $message = 'Category retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function formatCategoryDetails($data, $request)
    {
        foreach ($data as $row) {
            $newdata['categoryId'] = $row->id;
            $newdata['categoryName'] = $row->category;
            $newdata['categoryImage'] = $row->image_file;
            $newdata['serviceId'] = isset($row->service_id) ? $row->service_id : '';
            $newdata['minCharge'] = isset($row->categoryConfiguration->minimum_charge) ? $row->categoryConfiguration->minimum_charge : '';
            $newdata['kmCharge'] = isset($row->categoryConfiguration->km_charge) ? $row->categoryConfiguration->km_charge : '';
            $newdata['cancellationCharge'] = isset($row->categoryConfiguration->cancellation_charge) ? $row->categoryConfiguration->cancellation_charge : '';
            $newdata['categoryId'] = $row->id;

            $trip_distance = $this->distance($request->fromlatitude, $request->fromlongitude, $request->tolatitude, $request->tolongitude, "K");
            $total_amount = 'No Details';
            if (isset($row->categoryConfiguration)) {
                $total_amount = $this->calculate_amount($row, $trip_distance);
            }

            $newdata['approximatePrice'] = $total_amount;

            $formatdata[] = $newdata;
        }


        return $formatdata;
    }


    public function addTripDetails(Request $request)
    {

        $user_id = auth()->user()->id;
        $rules = [
            'categoryId'       => 'required',
            'fromlatitude' => 'required',
            'fromlongitude' => 'required',
            'tolatitude' => 'required',
            'tolongitude' => 'required',
            'fromaddress' => 'required',
            'toaddress' => 'required',
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.auth.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        // $category_id = $request->category_id;

        //   $car = $this->get_category_car($category_id,$request);

        // calculate amount
        // print_r($request->categoryId);exit;
        // get distance from lat  long
        $category = Category::with('categoryConfiguration')->where('is_active', 1)->where('id', $request->categoryId)->first();

        if (!isset($category) || !isset($category['categoryConfiguration'])) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   'No category details.';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $distance = $this->distance($request->trip_pickup_latitude, $request->trip_pickup_longitude, $request->trip_drop_latitude, $request->trip_drop_longitude, "K");

        //dd($distance);

        $amount = 0.0;

        // print_r($category); exit;
        $total_amount = $this->calculate_amount($category, $distance);


        $trip = Trip::orderBy('id', 'DESC')->first();

        if ($trip) {
            $no_only = substr($trip->trip_no, 2);
            $idno = ltrim($no_only, '0');
            $trip_no = $idno + 1;
        } else {
            $trip_no = 1;
        }
        $next_number = str_pad($trip_no, 10, "0", STR_PAD_LEFT);

        $data['trip_no'] = 'TR' . $next_number;
        $data['from_location_lat'] = $request->fromlatitude;
        $data['from_location_lng'] = $request->fromlongitude;
        $data['from_location'] = new Point($request->fromlatitude, $request->fromlongitude);
        $data['to_location_lat'] = $request->tolatitude;
        $data['to_location_lng'] = $request->tolongitude;
        $data['to_location'] = new Point($request->tolatitude, $request->tolongitude);
        $data['is_now_trip'] = 1;
        $data['service_id'] = $category->service_id;
        $data['category_id'] = $category->id;
        $data['status'] = 'New';
        $data['customer_id'] = $user_id;
        // $data['driver_id'] = $car->user_id;
        // $data['car_id'] = $car->id;
        $data['from_address'] = $request->fromaddress;
        $data['to_address'] = $request->toaddress;
        // $data['pickup_on'] = Carbon::parse($request->pickup_on)->format('Y-m-d H:i:s');
        // $data['dropoff_on'] = Carbon::parse($request->dropoff_on)->format('Y-m-d H:i:s');
        $data['distance'] = $distance;
        // $data['category_id'] = $car->category_id;
        $data['minimum_charge'] = $category->categoryConfiguration->minimum_charge;
        $data['km_charge'] = $category->categoryConfiguration->km_charge;
        $data['cancellation_charge'] = $category->categoryConfiguration->cancellation_charge;
        $data['amount'] = $total_amount;
        $data['discount'] = 0;
        $data['tax'] = 0;
        $data['final_amount'] = $total_amount;
        $data['payment_method'] = 'Cash';
        $data['payment_method_id'] = 1;
        $data['payment_status'] = 0;
        $data['status'] = 1;

        $trip_id = Trip::create($data)->id; //Create Trip
        $trip = Trip::with('car', 'service', 'paymentMethod', 'customer')->where('id', $trip_id)->first();

        //finding the approximate distance using spatialTrait
        $to_point   =   $trip->to_location;
        $query      = Trip::DistanceValue('from_location', $to_point)->where('id', $trip_id); //find the distance between starting and ending points
        $distanceObj   =   $query->first();
        $km = 0.008997742; //kilometer to degree
        $distance   =   $distanceObj->distance / $km;
        $distance   =   number_format($distance, 2);
        $total_amount = $this->calculate_amount($category, $distance);
        $trip->distance = $distance;
        $trip->amount = $total_amount;
        $trip->final_amount = $total_amount;
        $trip->save();

        //Format Trip Details
        $trip_details = $this->formatTripDetailsWithKey($trip);

        // get nearest drivers and push notification to them
        $drivers = $this->push_nearest_drivers($data['from_location_lat'], $data['from_location_lng']);
        // echo $drivers;

        $test_notify = [];
        foreach($drivers as $item){
            $res = AuthController::sendPushNotification([
                'title' => "New Trip for You #".$trip_id,
                'body' => "New Trip for You #".$trip_id,
                'user_id' => $item['user_id'],
            ], ['trip_details' => $trip_details]);
            array_push($test_notify, ["user_id" => $item['user_id'], "push" => $res]);
        }

        //Call the NewTripHasCreatedEvent with this new trip
        // event(new NewTripHasCreatedEvent($trip, $trip_details));

        $data    = [
            'trip_details' => $trip_details
        ];

        $message = 'Trips details retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code ,'notify' => $test_notify ]);
    }

    public function formatTripRequestDetails($row)
    {
        $newdata['id'] = $row->id;
        $newdata['is_now_trip'] = $row->is_now_trip;
        $newdata['trip_no'] = $row->trip_no;
        $newdata['service_id'] = isset($row->service_id) ? $row->service_id : '';
        $newdata['service_name'] = isset($row->service->service) ? $row->service->service : '';
        $newdata['customer_id'] = $row->customer_id;
        $newdata['customer_name'] = isset($row->customer->name) ? $row->customer->name : '';
        $newdata['from_address'] = $row->from_address;
        $newdata['from_location_lat'] = optional($row->from_location)->getLat();
        $newdata['from_location_lng'] = optional($row->from_location)->getLng();
        $newdata['to_address'] = $row->to_address;
        $newdata['to_location_lat'] = optional($row->to_location)->getLat();
        $newdata['to_location_lng'] = optional($row->to_location)->getLng();
        $newdata['pickup_on'] = Carbon::parse($row->pickup_on);
        $newdata['dropoff_on'] = Carbon::parse($row->dropoff_on);
        $newdata['distance'] = $row->distance;
        $newdata['category_id'] = $row->category_id;
        $newdata['minimum_charge'] = $row->minimum_charge;
        $newdata['km_charge'] = $row->km_charge;
        $newdata['cancellation_charge'] = $row->cancellation_charge;
        $newdata['amount'] = $row->amount;
        $newdata['discount'] = $row->discount;
        $newdata['tax'] = $row->tax;
        $newdata['final_amount'] = $row->final_amount;
        $newdata['payment_method_id'] = $row->payment_method_id;
        $newdata['payment_method_name'] = isset($row->payment_method->name) ? $row->payment_method->name : '';
        $newdata['payment_status'] = $row->payment_status;
        $newdata['status'] = $row->status;

        return $newdata;
    }

    public function calculate_amount($data, $distance)
    {
        $total_amount = $data->categoryConfiguration->km_charge * $distance;

        if ($data->categoryConfiguration->minimum_charge > $total_amount) {
            $total_amount = $data->categoryConfiguration->minimum_charge;
        }
        return number_format($total_amount, 2, '.', '');
    }

    /**
     * Apply the coupon and update the final amount.
     *
     * @return Amount Decimal
     */
    public function applyCoupon(Request $request)
    {
        $rules = [
            'coupon'        => 'required',
            'trip_id'       => 'required',
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.auth.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $coupon = $request->coupon;
        $trip_id = $request->trip_id;

        $appliedCouponObj  =  CouponReport::whereIn('service_id', [1, 2])->where('coupon_code', $coupon)->where('applied_for_id', $trip_id);
        if ($appliedCouponObj->count()) {
            $data   =   null;
            $message = 'Coupon already applied!';
            $status_code    = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        $trip   =   Trip::find($trip_id);
        $amount =   $trip->amount;
        $data    = [
            'coupon_code' => $coupon,
            'amount'    => $amount,
            'discount' => null
        ];
        $message = 'Coupon applied successfully';
        $status_code    = 200;

        $couponObj =   Coupon::active()->where('coupon_code', $coupon);
        if (!$couponObj->count()) {
            $message = 'Invalid Coupon code!';
            $status_code    = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $couponObj =   $couponObj->where('coupon_from_date', '<=', now())->where('coupon_to_date', '>=', now());
        if (!$couponObj->count()) {
            $message = 'Coupon code expired!';
            $status_code    = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $couponObj =   $couponObj->first();
        if ($couponObj->coupon_limit) {
            $coupon_used_count  = CouponReport::where('coupon_code', $coupon)->count();
            if ($couponObj->coupon_limit <= $coupon_used_count) {
                $message = 'Coupon usage limit reached!';
                $status_code    = 422;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
        }
        if ($couponObj->use_percentage) {
            $discount = $amount * $couponObj->coupon_discount_percentage * 0.01;
            $discount = $couponObj->coupon_max_discount_amount < $discount ? $couponObj->coupon_max_discount_amount * 1 : $discount;
        } else {
            $discount = $couponObj->coupon_discount_amount * 1;
        }
        if ($discount > $amount)
            $discount = $amount;
        $trip->discount     = $discount;
        $discounted_ammount =   $trip->amount - $discount;
        $tax    =   $discounted_ammount * $trip->tax * 0.01;
        $trip->final_amount =  $discounted_ammount + $tax;
        $trip->save();

        /* Add the applied coupon details to coupon reports */

        $data['coupon_code'] = $coupon;
        $data['user_id'] = auth()->user()->id;
        $data['service_id'] = $trip->service_id;
        $data['applied_for_id'] = $trip->id;
        $data['applied_on'] = now();
        $data['total_amount'] = $trip->final_amount;
        $data['coupon_discount_amount'] = $trip->discount;
        CouponReport::create($data);

        $data   =   [
            'coupon_code' => $coupon,
            'amount'    => $amount,
            'discount' => $discount
        ];
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }
    /**
     * Get the coupon to apply.
     *
     * @return Amount Decimal
     */
    public function getCustomerCoupon($user_id)
    {
        $checkUserCoupon    =   UserCoupon::where('user_id', $user_id);
        if (!$checkUserCoupon->count()) {
            return null;
        }
        $coupon_code  =  $checkUserCoupon->first()->coupon_code;
        $couponObj =   Coupon::where('coupon_code', $coupon_code);
        if (!$couponObj->count()) {
            return null;
        }
        if (!$couponObj->active()->count()) {
            return null;
        }
        $coupon_details =   $couponObj->active()->first();
        return $coupon_details->coupon_code;
    }

    /**
     * Apply the coupon and update the final amount.
     *
     * @return Amount Decimal
     */
    public function applyAlreadyAddedCoupon($trip_id)
    {
        $user_id    =   Trip::where('id',$trip_id)->pluck('customer_id')->first();
        $coupon =   $this->getCustomerCoupon($user_id);
        if (!$coupon) {
            $data    = [
                'coupon_code' => null,
                'amount'    => null,
                'discount' => null
            ];
            $message = 'No coupons available';
            $status_code    = 422;
            return ['data' => $data, 'message' => $message, 'status_code' => $status_code];
        }
        $appliedCouponObj  =  CouponReport::whereIn('service_id', [1, 2])->where('coupon_code', $coupon)->where('applied_for_id', $trip_id);
        if ($appliedCouponObj->count()) {
            $data   =   null;
            $message = 'Coupon already applied!';
            $status_code    = 422;
            return ['data' => $data, 'message' => $message, 'status_code' => $status_code];
        }

        $trip   =   Trip::find($trip_id);
        $amount =   $trip->amount;
        $data    = [
            'coupon_code' => $coupon,
            'amount'    => $amount,
            'discount' => null
        ];
        $message = 'Coupon applied successfully';
        $status_code    = 200;

        $couponObj =   Coupon::active()->where('coupon_code', $coupon);
        if (!$couponObj->count()) {
            $message = 'Invalid Coupon code!';
            $status_code    = 422;
            return ['data' => $data, 'message' => $message, 'status_code' => $status_code];
        }
        $couponObj =   $couponObj->where('coupon_from_date', '<=', now())->where('coupon_to_date', '>=', now());
        if (!$couponObj->count()) {
            $message = 'Coupon code expired!';
            $status_code    = 422;
            return ['data' => $data, 'message' => $message, 'status_code' => $status_code];
        }
        $couponObj =   $couponObj->first();
        if ($couponObj->coupon_limit) {
            $coupon_used_count  = CouponReport::where('coupon_code', $coupon)->count();
            if ($couponObj->coupon_limit <= $coupon_used_count) {
                $message = 'Coupon usage limit reached!';
                $status_code    = 422;
                return ['data' => $data, 'message' => $message, 'status_code' => $status_code];
            }
        }
        //dd($couponObj);
        if ($couponObj->use_percentage) {
            $discount = $amount * $couponObj->coupon_discount_percentage * 0.01;
            $max_discount   =   $couponObj->coupon_max_discount_amount ? $couponObj->coupon_max_discount_amount : $amount;
            $discount = $max_discount < $discount ? $max_discount * 1 : $discount;
        } else {
            $discount = $couponObj->coupon_discount_amount * 1;
        }
        if ($discount > $amount)
            $discount = $amount;
        $trip->discount     = $discount;
        $discounted_ammount =   $trip->amount - $discount;
        $tax    =   $discounted_ammount * $trip->tax * 0.01;
        $trip->final_amount =  $discounted_ammount + $tax;
        $trip->save();

        /* Add the applied coupon details to coupon reports */

        $data['coupon_code'] = $coupon;
        $data['user_id'] = auth()->user()->id;
        $data['service_id'] = $trip->service_id;
        $data['applied_for_id'] = $trip->id;
        $data['applied_on'] = now();
        $data['total_amount'] = $trip->final_amount;
        $data['coupon_discount_amount'] = $trip->discount;
        CouponReport::create($data);
        $data['discount'] = $discount;
        $message = 'Coupon applied successfully!';
        $status_code    = 200;
        //Remove the applied coupon
        UserCoupon::where('user_id', $user_id)->where('coupon_code',$coupon)->delete();
        return ['data' => $data, 'message' => $message, 'status_code' => $status_code];
    }

    /**
     * Apply the coupon and update the final amount.
     *
     * @return Amount Decimal
     */
    public function appliedCouponDetails(Request $request)
    {
        $rules = [
            'trip_id'       => 'required',
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   'Validation Error!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $data    = null;
        $message = 'Coupon details fetched successfully';
        $status_code    = 200;

        /* Fetch applied coupon details */
        $trip_id = $request->trip_id;
        $appliedCouponObj  =  CouponReport::whereIn('service_id', [1, 2])->where('applied_for_id', $trip_id);
        if (!$appliedCouponObj->count()) {
            $message = 'Coupon details not available. Coupon code was not applied!';
            $status_code    = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        $appliedCouponObj   =   $appliedCouponObj->first();
        $data   =   [
            'coupon_code' => $appliedCouponObj->coupon_code,
            'amount'    => $appliedCouponObj->total_amount,
            'discount' => $appliedCouponObj->coupon_discount_amount,
            'date' => $appliedCouponObj->applied_on
        ];
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }


    /**
     * Find the total rent.
     *
     * @return Amount Decimal
     */
    public function removeCoupon(Request $request)
    {
        $rules = [
            'coupon'        => 'required',
            'trip_id'       => 'required',
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   'Validation Error!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $coupon = $request->coupon;
        $trip_id = $request->trip_id;
        $trip   =   Trip::find($trip_id);

        $amount =   $trip->amount;
        $discount = $trip->discount;
        $data    = [
            'coupon_code' => $coupon,
            'amount'    => $amount,
            'discount' => $discount
        ];
        $message = 'Coupon removed successfully';
        $status_code    = 200;

        if (!$trip->discount) {
            $data    = [
                'coupon_code' => $coupon,
                'amount'    => $amount,
                'discount' => $discount
            ];
            $message = 'Discount was not applied or applied zero discount!';
            $status_code    = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        $discounted_ammount =   $trip->amount - $trip->discount;
        $tax    =   $discounted_ammount * $trip->tax * 0.01;
        $trip->final_amount =  $trip->final_amount - $tax + $trip->discount;
        $trip->discount    = 0.00;
        $trip->save();

        $appliedCouponObj  =  CouponReport::whereIn('service_id', [1, 2])->where('applied_for_id', $trip_id);
        $appliedCouponObj->delete();

        $data   =   [
            'coupon_code' => $coupon,
            'amount'    => $amount,
            'discount' => $discount
        ];
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
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

    public function get_category_car($category_id, $request)
    {
        $customer_location  = new Point($request->latitude, $request->longitude);
        return Car::with('driver', 'categoryConfiguration')->inRandomOrder()->where('category_id', $category_id)->first();
    }

    public function get_service_category_car($service_id, $request)
    {
        $customer_location  = new Point($request->fromlatitude, $request->fromlongitude);
        return Car::with('driver', 'categoryConfiguration', 'category')->OrderByDistance('location', $customer_location)->where('service_id', $service_id)->get();
    }

    public function UpdateTripStatus(Request $request)
    {
        $rules = [
            'trip_id'       => 'required',
            'status' => 'required',
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   'Validation Error!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        //Skipping if we have a different dedicated api for status change
        //1 - create, 2- Pending, 3 - No driver, 4- Accept, 9- collect money (Skip for these)
        if (in_array($request->status, [1, 2, 3, 4, 9])) {
            $data   =   null;
            $message = 'Invalid user request! You have different API for the status - ' . $request->status;
            $status_code    = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        //Trying to go back in status
        $current_trip_query     =   Trip::where('id', $request->trip_id);
        $current_trip           =   $current_trip_query->first();
        $current_status         =   $current_trip_query->pluck('status')->first();
        if ($current_status == '3') {
            //Format Trip Details
            $trip_details = $this->formatTripDetailsWithKey($current_trip);
            $data   =   $trip_details;
            $message = 'The trip has ended as there were no drivers available on time';
            $status_code    = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        if ($current_status >= $request->status) {
            $data   =   null;
            $message = 'Invalid user request! You cannot go back or you are trying to update the same status.';
            $status_code    = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        if ($request->status == '10' ||  $request->status == '11') { //Cancel the trip
            if (auth()->user()->user_type_id == 4 && $request->status != 11) { //Cannot attempt driver cancellation from customer login
                $data   =   null;
                $message = 'Invalid user request!';
                $status_code    = 200;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
            if (auth()->user()->user_type_id == 3 && $request->status != 10) { //Cannot attempt customer cancellation from driver login
                $data   =   null;
                $message = 'Invalid user request!';
                $status_code    = 200;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
            if (auth()->user()->user_type_id == 3 && $current_status < 4) { //Driver cancellation attempting even before a driver has assigned to the trip
                $data   =   null;
                $message = 'Invalid user request!';
                $status_code    = 200;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
            $trip = null;
            $trip = Trip::whereIn('status', [1, 2, 3, 4, 5])->where('id', $request->trip_id)->orderBy('id', 'desc')->first();
            if ($trip) {
                //Deduct penalty amount if driver accepted the trip and the cancelled before starting the trip
                if ($trip->status == 4 || $trip->status == 5) { // if the driver either accepted or reached location after accepting
                    $commission = 10;
                    $trip_commission = Setting::find(5);
                    if ($trip_commission) {
                        $commission = $trip_commission->value;
                    }
                    $commission_amount  =   $commission * $trip->cancellation_charge * .01;
                    if ($request->status == '11') { //Customer cancelled the trip
                        //Customer wallet
                        $customer_wallet = Wallet::where('user_id', $trip->customer_id)->first();
                        if ($customer_wallet) {
                            $customer_wallet->amount -= $trip->cancellation_charge; //deduct the cancellation amount from customer wallet
                            $customer_wallet->save();
                        } else {
                            $wallet_data['user_id'] = $trip->customer_id;
                            $wallet_data['amount'] = 0 - $trip->cancellation_charge; //deduct the cancellation amount from customer wallet;
                            $wallet_data['user_type'] = '4';
                            $wallet_data['is_active'] = '1';
                            Wallet::create($wallet_data);
                        }
                        $data['amount'] = 0 - $trip->cancellation_charge;
                        $data['done_by']  = auth()->user()->id;
                        $data['sender_id'] = 0;
                        $data['receiver_id'] = $trip->customer_id;
                        $data['trip_id'] = $trip->id;
                        $data['note'] = trans('api.driver.debited_cancellation');
                        Transaction::create($data);
                        //Customer wallet
                        //Driver wallet
                        $amount_to_driver_wallet  =   $trip->cancellation_charge - $commission_amount; //Deduct the commission and add the remaining cancellation charge to driver wallet
                        $note = trans('api.driver.credited_cancellation');
                    } else if ($request->status == '10') { //Driver cancelled the trip
                        //Driver wallet
                        $amount_to_driver_wallet  =   0 - $trip->cancellation_charge; //Deduct the commission and add the remaining cancellation charge to driver wallet
                        $note = trans('api.driver.debited_cancellation');
                    }

                    //Driver wallet
                    //Credit the compensation charge to driver wallet
                    $driver_wallet = Wallet::where('user_id', $trip->driver_id)->first();
                    if ($driver_wallet) {
                        $driver_wallet->amount += $amount_to_driver_wallet;
                        $driver_wallet->save();
                    } else {
                        $wallet_data['user_id'] = $trip->driver_id;
                        $wallet_data['amount'] = $amount_to_driver_wallet;
                        $wallet_data['user_type'] = '3';
                        $wallet_data['is_active'] = '1';
                        Wallet::create($wallet_data);
                    }
                    $data['amount'] = $amount_to_driver_wallet;
                    $data['done_by']  = auth()->user()->id;
                    $data['sender_id'] = 0;
                    $data['receiver_id'] = $trip->driver_id;
                    $data['trip_id'] = $trip->id;
                    $data['note']   =   $note;
                    Transaction::create($data);
                    //Driver wallet
                }

                $trip->status = $request->status;
                $trip->save();

                //Format Trip Details
                $trip_details = $this->formatTripDetailsWithKey($trip);

                //Call the TripStatusHasUpdatedEvent with this
                event(new TripStatusHasUpdatedEvent($trip, $trip_details));

                $data   = $trip_details;


                //$message    =   trans('api.driver.trip_status_changed');
                if ($trip->status == 10) { //Trip cancelled by driver
                    $message  =   "Trip has cancelled by the driver";
                } elseif ($trip->status == 11) {  //Trip cancelled by customer
                    $message  =   "Trip has cancelled by the customer";
                }

                $status_code   = 200;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            } else {
                $data   = null;
                $message    =   trans('api.driver.invalid_status');
                $status_code   = 500;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
        }

        $dropoff_on   =   Trip::where('id', $request->trip_id)->whereNull('dropoff_on');
        if ($request->status == '6') { //Trip started and update the pickup time
            Trip::where('id', $request->trip_id)->update(['pickup_on' => now()]);
        }

        if ($request->status == '7' || (($request->status == '8' || $request->status == '9') && $dropoff_on->count())) { //Driver reached dropoff and update the dropoff time
            Trip::where('id', $request->trip_id)->update(['dropoff_on' => now()]);

            //Calculate the actual distance and amount
            $routes = TripRoute::where('trip_id',$request->trip_id)->orderBy('trip_id')->orderBy('id')->get();
            $trip_routes = $routes->map->only(['lat','lng']);
            $trip_distance = 0;
            for($i=1; $i< count($trip_routes); $i++){
                $trip_distance += $this->distance($trip_routes[$i-1]['lat'], $trip_routes[$i-1]['lng'], $trip_routes[$i]['lat'], $trip_routes[$i]['lng'], "K");
            }
            $category = Category::with('categoryConfiguration')->where('is_active', 1)->where('id', $current_trip->category_id)->first();
            $total_amount = $this->calculate_amount($category, $trip_distance);
            $distance   =   number_format($trip_distance, 2, '.', '');
            $current_trip->distance = $distance;
            $current_trip->amount = $total_amount;
            $current_trip->final_amount = $total_amount;
            $current_trip->save();
        }

        //Apply discount coupon, if any
        $message = '';
        if ($request->status == '8') { //Apply coupon on trip completion
            $coupon_details =   $this->applyAlreadyAddedCoupon($request->trip_id);
            $message .= $coupon_details['message'] . '. ';
            //Trip::where('id', $request->trip_id)->update(['pickup_on' => now()]);
        }


        Trip::where('id', $request->trip_id)->update(['status' => $request->status]);
        $trip = Trip::with('car', 'service', 'paymentMethod', 'driver', 'customer')->where('id', $request->trip_id)->first();

        //Format Trip Details
        $trip_details = $this->formatTripDetailsWithKey($trip);

        //Call the NewTripHasCreatedEvent with this new trip
        event(new TripStatusHasUpdatedEvent($trip, $trip_details));

        $data    = [
            'trip_details' => $trip_details
        ];

        $message .= 'Trips status updated successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function my_current_trip(Request $request)
    {
        $user_id = auth()->user()->id;
        $status = array(config('constants.New'), config('constants.Pending'), config('constants.No_driver_available'), config('constants.Driver_accepted'), config('constants.Driver_reached_pickup_location'), config('constants.Trip_started'), config('constants.Reached_destination'), config('constants.Completed_trip'));
        $data = null;
        $message = '';
        $status_code    = 200;
        if (auth()->user()->user_type_id == 4) { //Customer
            $user_field =   'customer_id';
        } elseif (auth()->user()->user_type_id == 3) { //Driver
            $user_field =   'driver_id';
        } else {
            $message = 'Invalid user request!';
            $status_code    = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        $query      = Trip::with('car', 'service', 'paymentMethod', 'driver', 'customer')->where($user_field, $user_id)->whereIn('status', $status)->orderBy('updated_at', 'desc'); //status 1-8
        if (!$query->count()) { // The user has no trips currently (status 0-8(completed ))
            //fetch the last trip which has a status greater than 8( money collected)
            // $last_trip = Trip::with('car', 'service', 'paymentMethod', 'driver', 'customer')->where($user_field, $user_id)->where('status', '>', 8)->orderBy('updated_at', 'desc');
            //$data = null;
            $message = 'You have no trips currently!'; // no trips with status 1-8
            /* if ($last_trip->count()) {
                $trip       = $last_trip->first();
                $trip_details = $this->formatTripDetailsWithKey($trip);
                $data['trip_details']    = $trip_details;
                $message .= 'Your last trip details are given!';
            } */

            $driver_location = Driver::where('user_id', $user_id)->first();
            $query      = Trip::orderByDistance('from_location', $driver_location->location)->whereIn('status', [1, 2]); //find the nearest trip for the driver who is free(having no trip with status 4,5,6,7,8)
            $nearest_trip = [];
            if ($query->count()) {
                $nearestTrip = $query->first();
                $nearest_trip = $this->formatTripDetailsWithKey($nearestTrip);
                $data['trip_details']    = $nearest_trip;
                $message .= 'You have a trip nearby you.';
            }
            $status_code    = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $trip       = $query->first();
        $trip_details = $this->formatTripDetailsWithKey($trip);
        $data['trip_details']    = $trip_details;
        $message = 'My trip details retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function update_customer_cancellation_trip_notes(Request $request)
    {

        $rules = [
            'trip_id'       => 'required',
            'customer_cancellation_notes' => 'required',
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   'Validation Error!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        Trip::where('id', $request->trip_id)->update(['customer_cancellation_notes' => $request->customer_cancellation_notes]);
        $trip = Trip::with('car', 'service', 'paymentMethod', 'driver', 'customer')->where('id', $request->trip_id)->first();

        $TripDetails = $this->formatTripDetails($trip);
        $data    = [
            'trip' => $TripDetails
        ];

        $message = 'Trips customer note  updated successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }


    public function onlineHours(Request $request)
    {
        $from = Carbon::parse($request->from_date)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($request->to_date)->format('Y-m-d') . ' 23:59:59';
        $logQuery   =   DriverAvailableLog::mylog()->whereBetween('updated_on', [$from, $to])->orderBy('updated_on','desc');
        $mylog    =   $logQuery->get();
        $onlineMinutes    =   0;
        $offset =  Carbon::parse($from);
        $online =   0;
        foreach ($mylog as $log) {
            $online =   $log['is_available'];
            $time   =   $log['updated_on'];
            $updateOn   =   Carbon::parse($time);
            $slotMins    =   $offset->diffInMinutes($updateOn);
            if (!$online) {
                $onlineMinutes += $slotMins;
            }
            $offset = Carbon::parse($time);
        }
        if ($online) {
            $slotMins    =   $offset->diffInMinutes($to);
            $onlineMinutes += $slotMins;
        }

        $driverAvailable   =   Driver::MyAvailability()->count();
        if (!count($mylog) && $driverAvailable) { //No logs within the date but the driver is available ever since
            $fromCarbon =   Carbon::parse($from);
            $toCarbon   =   Carbon::parse($to);
            $onlineMinutes =  $fromCarbon->diffInMinutes($toCarbon);
        }

        $onlineHours = floor($onlineMinutes / 60) . ":" . ($onlineMinutes - floor($onlineMinutes / 60) * 60);
        $onlineHoursHuman = CarbonInterval::minutes($onlineMinutes)->cascade()->forHumans();
        return [
            'onlineHours' => $onlineHours,
            'onlineHoursHuman' => $onlineHoursHuman
        ];
    }

    public function myTripsPaymentHistory(Request $request)
    {

        $user_id = auth()->user()->id;
        $user_type_id   =   auth()->user()->user_type_id;
        $rules = [
            'from_date'       => 'required|date',
            'to_date'         => 'required|date|after_or_equal:from_date'
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.tripPayment.validation_error');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $from = Carbon::parse($request->from_date)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($request->to_date)->format('Y-m-d') . ' 23:59:59';
        if ($user_type_id == 3) { //Driver
            $user_field =   'driver_id';
        } elseif ($user_type_id == 4) { //customer
            $user_field =   'customer_id';
        } else {
            $errors = '';
            $data   = null;
            $message    =   'Invalid User';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $trip_payment = Trip::where($user_field, $user_id)->orderBy('id', 'DESC')->whereBetween('created_at', [$from, $to]);
        $cash_total = Trip::where($user_field, $user_id)->where('payment_method_id', 1)->orderBy('id', 'DESC')->whereBetween('created_at', [$from, $to])->sum('final_amount');
        $trips_count     =   $trip_payment->count();
        $total_amount     =   $trip_payment->sum('final_amount');
        //$trip_payment->setAttribute('trips_count', $trips_count);
        $trip_payment = $trip_payment->simplePaginate(10);
        $trip_payment->getCollection()->transform(function ($value) {
            return $this->formatPaymentDetails($value);
        });


        $data   =   [
            'payment_history' => $trip_payment,
            'trips_count'   => $trips_count,
            'cash_total'    => $cash_total,
            'total_amount'    => $total_amount
        ];
        if ($user_type_id == 3) { //Driver
            $data['online_hours'] =   $this->onlineHours($request);
        }

        $message = 'Payment details retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    protected function formatPaymentDetails($row)
    {
        $newdata['id'] = $row->id;
        $newdata['trip_no'] = $row->trip_no;
        if (auth()->user()->user_type_id == 3) { //Driver
            $newdata['user_id'] = isset($row->driver_id) ? $row->driver_id : 0;
        } elseif (auth()->user()->user_type_id == 4) { //customer
            $newdata['user_id'] = isset($row->customer_id) ? $row->customer_id : 0;
        }
        $newdata['customer_id'] = isset($row->customer_id) ? $row->customer_id : 0;
        $newdata['driver_id'] = isset($row->driver_id) ? $row->driver_id : 0;
        $newdata['service_id'] = $row->service_id;
        $newdata['pickup_on'] = $row->pickup_on;
        $newdata['dropoff_on'] = $row->dropoff_on;
        $newdata['customer_name'] = isset($row->customer_id) ? User::where('id',$row->customer_id)->pluck('name')->first() : '';
        $newdata['driver_name'] = isset($row->driver_id) ? User::where('id',$row->driver_id)->pluck('name')->first() : '';
        $newdata['amount'] = $row->final_amount;
        $newdata['payment_method'] = $row->payment_method;
        $newdata['payment_status'] = $row->payment_status;/*
        $newdata['booking_status'] = $row->booking_status;
        $newdata['pickup_on'] = $row->pickup_on;
        $newdata['duration_in_days'] = $row->duration_in_days;
        $newdata['dropoff_on'] = $row->dropoff_on;
        $newdata['amount'] = $row->amount;
        $dropoff_on = new Carbon($row->dropoff_on);
        $current_date = Carbon::now();

        $remaining_time = $current_date->diff($dropoff_on);

        $time = array();
        if ($remaining_time->y != 0) {
            $time[]  = $remaining_time->y . " Year ";
        }
        if ($remaining_time->m != 0) {
            $time[] = $remaining_time->m . " Months ";
        }
        if ($remaining_time->d != 0) {
            $time[] = $remaining_time->d . " Day ";
        }
        if ($remaining_time->h != 0) {
            $time[] = $remaining_time->h . " Hour ";
        }
        if ($remaining_time->i != 0) {
            $time[] = $remaining_time->i . " Mins ";
        }

        $format_time = implode("", $time);
        $newdata['remaining_time'] = $format_time; */
        $newdata['created_at'] = $row->created_at;
        /*  $newdata['car_name'] = $row->car->car_name;
        $newdata['car_model_year'] = $row->car->model_year;
        $newdata['registration_no'] = $row->car->registration_no;
        $newdata['bill_download_link'] = URL::to('api/car_rent_bill/pdf/' . $row->id); */
        return $newdata;
    }

    /* public function carRentBillPdf($id)
    {
        set_time_limit(300);
        $data['car_rental'] =  CarRental::with('user', 'car')->findOrFail($id);
        $pdf = PDF::loadView('car_rentals.car_rental_invoice_pdf', $data);
        return $pdf->download('invoice' . time() . '.pdf');
    } */

    //Broadcast the nearby drivers to the customers

    public function customer_nearest_drivers(Request $request)
    {
        $customer_current_lat   = $request->current_lat;
        $customer_current_lng   = $request->current_lng;
        $customer_location      = new Point($customer_current_lat, $customer_current_lng);
        $customer   = User::with('customer')->find(auth()->user()->id);
        if ($customer) {
            $customer->customer->location = $customer_location;
            $customer->customer->lat = $customer_current_lat;
            $customer->customer->lng = $customer_current_lng;
            $customer->customer->save();
        }
        $query      = Driver::orderByDistance('location', $customer_location)->active()->available(); //find the nearest trip for the driver who is free(having no trip with status 4,5,6,7,8)
       // dd($query->get());
        if (!$query->count()) {
            return $query->count();
           // return response(['data' => $query->take(5), 'message' => 'No driver', 'status_code' => 222]);
        }else{
            return $query->get()->take(5);
            //return response(['data' => $query->get()->take(5), 'message' => 'Drivers', 'status_code' => 222]);
        }
    }

    public function push_nearest_drivers($lat, $lng)
    {
        $customer_location      = new Point($lat, $lng);
        // $customer   = User::with('customer')->find(auth()->user()->id);

        // if ($customer) {
        //     $customer->customer->location = $location;
        //     $customer->customer->lat = $lat;
        //     $customer->customer->lng = $lng;
        //     $customer->customer->save();
        // }
        $query      = Driver::orderByDistance('location', $customer_location)->active()->available(); //find the nearest trip for the driver who is free(having no trip with status 4,5,6,7,8)
       // dd($query->get());

        if (!$query->count()) {
            return $query->count();
           // return response(['data' => $query->take(5), 'message' => 'No driver', 'status_code' => 222]);
        } else {
            $list = $query->get()->take(100);

            return $list;
            //return response(['data' => $query->get()->take(5), 'message' => 'Drivers', 'status_code' => 222]);
        }
    }

    public function get_chat_by_trip(Request $request)
    {
        $user_id = auth()->user()->id;
        $chat = Message::where('trip_id', $request->trip_id)->where(function ($query) use ($user_id) {
            $query->where('sender_id', $user_id)
                  ->orWhere('receiver_id', $user_id);
        });

        if (!$chat->count()) {
            // return $chat->count();
            $message = 'No messages found';
            $status_code    = 202;
            return response(['data' => [], 'message' => $message, 'status_code' => $status_code]);
        } else {
            $message = 'Trips chat customer list successfully';
            $status_code    = 200;
            return response(['data' => $chat->get(), 'message' => $message, 'status_code' => $status_code]);
        }
    }


}
