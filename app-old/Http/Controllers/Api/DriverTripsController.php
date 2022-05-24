<?php

namespace App\Http\Controllers\Api;

use App\Events\TheTripHasCompletedEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Rating;
use App\Models\Trip;
use App\Models\TripRequestLog;
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DriverTripsController extends Controller
{

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
            $message    =   'Validation Error!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $from = Carbon::parse($request->from_date)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($request->to_date)->format('Y-m-d') . ' 23:59:59';

        $trip = Trip::with('car', 'service', 'paymentMethod', 'driver', 'customer')->where('driver_id', $user_id)->orderBy('id', 'DESC');
        if (isset($request->from_date) && isset($request->to_date)) {
            $trip = $trip->whereBetween('pickup_on', [$from, $to]);
        }

        $trip = $trip->simplePaginate(10);

        $trip->getCollection()->transform(function ($value) {
            return $this->formatTripDetailsWithKey($value);
        });


        $message = 'Trips details retrieved successfully';
        $status_code    = 200;
        return response(['data' => $trip, 'message' => $message, 'status_code' => $status_code]);
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


        Trip::where('id', $request->trip_id)->update(['status' => $request->status]);
        $trip = Trip::with('car', 'service', 'paymentMethod', 'driver', 'customer')->where('id', $request->trip_id)->first();

        //Format Trip Details
        $trip_details = $this->formatTripDetailsWithKey($trip);

        //Call the TheTripHasCompletedEvent with this new trip
        if ($request->status == '8')
            event(new TheTripHasCompletedEvent($trip, $trip_details));

        //$trip = $this->formatTripDetails($trip);
        $data    = [
            'trip_details' => $trip_details
        ];

        $message = 'Trips status updated successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function formatTripDetails($row)
    {
        $newdata['id'] = $row->id;
        $newdata['is_now_trip'] = isset($row->is_now_trip) ? $row->is_now_trip : '';
        $newdata['trip_no'] = isset($row->trip_no) ? $row->trip_no : '';
        $newdata['service_id'] = isset($row->service_id) ? $row->service_id : '';
        $newdata['service_name'] = isset($row->service->service) ? $row->service->service : '';
        $newdata['customer_id'] = isset($row->customer_id) ? $row->customer_id : '' ;
        $newdata['customer_name'] = isset($row->customer->name) ? $row->customer->name : '';
        $newdata['driver_id'] = isset($row->driver_id) ? $row->driver_id : '';
        $newdata['driver_name'] = isset($row->driver->name) ? $row->driver->name : '';
        $newdata['car_id'] = isset($row->car_id) ? $row->car_id : '';
        $newdata['car_name'] = isset($row->car->car_name) ? $row->car->car_name : '' ;
        $newdata['from_address'] = isset($row->from_address) ? $row->from_address : '' ;
        $newdata['from_location_lat'] = optional($row->from_location)->getLat();
        $newdata['from_location_lng'] = optional($row->from_location)->getLng();
        $newdata['to_address'] = isset($row->to_address) ? $row->to_address : '';
        $newdata['to_location_lat'] = optional($row->to_location)->getLat();
        $newdata['to_location_lng'] = optional($row->to_location)->getLng();
        $newdata['pickup_on'] = Carbon::parse($row->pickup_on);
        $newdata['dropoff_on'] = Carbon::parse($row->dropoff_on);
        $newdata['distance'] = isset($row->distance) ? $row->distance : '';
        $newdata['category_id'] = isset($row->category_id) ? $row->category_id : '';
        $newdata['minimum_charge'] = isset($row->minimum_charge) ? $row->minimum_charge : '' ;
        $newdata['km_charge'] = isset($row->km_charge) ? $row->km_charge : '';
        $newdata['cancellation_charge'] = isset($row->cancellation_charge) ? $row->cancellation_charge : '';
        $newdata['amount'] = isset($row->amount) ? $row->amount : '';
        $newdata['discount'] = isset($row->discount) ? $row->discount : '';
        $newdata['tax'] = isset($row->tax) ? $row->tax : '';
        $newdata['final_amount'] = isset($row->final_amount) ? $row->final_amount : '';
        $newdata['payment_method_id'] = isset($row->payment_method) ? $row->payment_method : '';
        $newdata['payment_method_name'] = isset($row->paymentMethod->name) ? $row->paymentMethod->name : '';
        $newdata['payment_status'] = isset($row->payment_status) ? $row->payment_status : '';
        $newdata['status'] = isset($row->status) ? $row->status : '';

        return $newdata;
    }


    public function update_driver_cancellation_trip_notes(Request $request)
    {

        $rules = [
            'trip_id'       => 'required',
            'driver_cancellation_notes' => 'required',
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

        Trip::where('id', $request->trip_id)->update(['driver_cancellation_notes' => $request->driver_cancellation_notes]);
        $trip = Trip::with('car', 'service', 'paymentMethod', 'driver', 'customer')->where('id', $request->trip_id)->first();

        $TripDetails = $this->formatTripDetails($trip);
        $data    = [
            'trip' => $TripDetails
        ];

        $message = 'Trips Driver note  updated successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);

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
        $cancelleation  =   number_format(100 * $cancelled / $total, 2);
        return $cancelleation;
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


}
