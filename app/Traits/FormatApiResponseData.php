<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatApiResponseData
{


    public function formatTripDetailsWithKey($row)
    {
        $newdata['trip']['id'] = $row->id;
        $newdata['trip']['is_now_trip'] = isset($row->is_now_trip) ? $row->is_now_trip : '';
        $newdata['trip']['trip_no'] = isset($row->trip_no) ? $row->trip_no : '';
        $newdata['trip']['service_id'] = isset($row->service_id) ? $row->service_id : '';
        $newdata['trip']['service_name'] = isset($row->service->service) ? $row->service->service : '';
        $newdata['customer']['user_id'] = isset($row->customer_id) ? $row->customer_id : '';//This is the primary key of users table
        $newdata['customer']['name'] = isset($row->customer->name) ? $row->customer->name : '';
        $newdata['customer']['phone'] = isset($row->customer->phone) ? $row->customer->phone : '';
        $newdata['customer']['email'] = isset($row->customer->email) ? $row->customer->email : '';
        //$newdata['customer']['rating'] = isset($row->customer_id) ? \App\Http\Controllers\API\UsersController->userRating($row->customer_id)  :'';
        $newdata['driver']['driver_id'] = isset($row->driver_id) ? $row->driver_id : '';
        $newdata['driver']['driver_name'] = isset($row->driver->name) ? $row->driver->name : '';
        $newdata['car']['car_id'] = isset($row->car_id) ? $row->car_id : '';
        $newdata['car']['car_name'] = isset($row->car->car_name) ? $row->car->car_name : '';
        $newdata['trip']['from_address'] = isset($row->from_address) ? $row->from_address : '';
        $newdata['trip']['from_location_lat'] = optional($row->from_location)->getLat();
        $newdata['trip']['from_location_lng'] = optional($row->from_location)->getLng();
        $newdata['trip']['to_address'] = isset($row->to_address) ? $row->to_address : '';
        $newdata['trip']['to_location_lat'] = optional($row->to_location)->getLat();
        $newdata['trip']['to_location_lng'] = optional($row->to_location)->getLng();
        $newdata['trip']['pickup_on'] = Carbon::parse($row->pickup_on);
        $newdata['trip']['dropoff_on'] = Carbon::parse($row->dropoff_on);
        $newdata['trip']['distance'] = isset($row->distance) ? $row->distance : '';
        $newdata['trip']['category_id'] = isset($row->category_id) ? $row->category_id : '';
        $newdata['trip']['minimum_charge'] = isset($row->minimum_charge) ? $row->minimum_charge : '';
        $newdata['trip']['km_charge'] = isset($row->km_charge) ? $row->km_charge : '';
        $newdata['trip']['cancellation_charge'] = isset($row->cancellation_charge) ? $row->cancellation_charge : '';
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
