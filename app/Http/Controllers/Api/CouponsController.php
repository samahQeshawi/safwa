<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponReport;
use App\Models\CarRental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Display a list of offers/valid coupon codes.
     *
     * @return \Illuminate\Http\Response
     */
    public function offers()
    {

        $query = Coupon::active()->where('coupon_to_date', '>=', now()); // Get all the active coupons which are not expired
        if ($query->count()) {
            $offers =   $query->get();
            $data   = $offers;
            $message    =   trans('api.coupon.current_offers_fetched');
            $status_code   = 200;
        } else {
            $data   = null;
            $message    =   trans('api.coupon.currently_no_offers');
            $status_code   = 200;
        }

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
            'coupon_name' => 'required',
            'coupon_description' => 'nullable',
            'use_percentage' => 'boolean|nullable',
            'coupon_discount_percentage' => 'nullable',
            'coupon_max_discount_amount' => 'nullable',
            'coupon_discount_amount' => 'nullable',
            'coupon_code' => 'required|unique:coupons,coupon_code',
            'coupon_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'coupon_type'  => 'nullable',
            'coupon_limit' => 'nullable',
            'coupon_from_date' => 'date',
            'coupon_to_date' => 'date',
            'is_active' => 'boolean|nullable',
        );
        $messages = array(
            'coupon_code.unique' => 'Coupon code already exists.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $messages = $validator->messages();
            $errors = $messages->all();
            $data   = null;
            $message    =   $errors;
            $status_code   = 401;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $data = $request->all();
        $data['coupon_from_date'] = date('Y-m-d h:i:s', strtotime($data['coupon_from_date']));
        $data['coupon_to_date'] = date('Y-m-d h:i:s', strtotime($data['coupon_to_date']));
        if ($request->hasFile('coupon_image')) {

            $coupon_image_path = $request->file('coupon_image')->store('coupons');
            $data['coupon_image'] =  $coupon_image_path;
        }
        $coupon  =  Coupon::create($data);;
        if (!$coupon) {
            $data   = null;
            $message    =   trans('api.coupon.add_unsuccess');
            $status_code   = 401;
        }
        $data   = $coupon;
        $message    =   trans('api.coupon.add_success');
        $status_code   = 200;


        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        /* $show_city   = new CitiesResource($city);
        $data    = [
            'city'=> $show_city
        ];
        $message = 'Cities details retrieved successfully';
        $status_code    = 200; */

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        /* $city->update($request->all());

        $updated_city   = new CitiesResource($city);
        $data    = [
            'city'=> $updated_city
        ];
        $message = 'Cities updated successfully';
        $status_code    = 200; */

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        /* $city->delete();
        $data    = null;
        $message = 'Cities deleted successfully';
        $status_code    = 200; */

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function apply_coupon(Request $request)
    {
        $rules = array(
            'car_rental_id' => 'required',
            'coupon_code' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            $errors = $messages->all();
            $data   = null;
            $message    =   $errors;
            $status_code   = 401;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $data = $request->all();
        $coupon = Coupon::where('coupon_code', $data['coupon_code'])->firstOrFail();
        $car_rental = CarRental::with('car')->findOrFail($data['car_rental_id']);
        $total_amount = $car_rental->amount;
        //Get the discount amount
        if ($coupon->use_percentage) {
            $discount_percentage = ($total_amount * ($coupon->coupon_discount_percentage / 100));
            $max_discount = $coupon->coupon_max_discount_amount;
            $discount = min($discount_percentage, $max_discount);
        } else {
            $discount = $cooupon->coupon_discount_amount;
        }
        //Check Dates
        $apply_discount = false;
        $date_today = date("Y-m-d h:i:s");
        if ($date_today < $coupon->coupon_to_date) {
            if ($date_today > $coupon->coupon_from_date) {
                //Check Limitation
                if ($coupon->coupon_type = '1') {
                    $apply_discount = true;
                } else if ($coupon->coupon_type == '2') {
                    if ($coupon->coupon_limit > 1) {
                        $coupon->coupon_limit -= 1;
                        $coupon->save();
                        $apply_discount = true;
                    } else {
                        $data   = null;
                        $message    =   trans('api.coupon.coupon_limit_exceeded');
                        $status_code   = 500;
                        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
                    }
                }
            } else {
                $data   = null;
                $message    =   trans('api.coupon.coupon_not_active');
                $status_code   = 500;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
        } else {
            $data   = null;
            $message    =   trans('api.coupon.coupon_expired');
            $status_code   = 401;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        if ($apply_discount) {
            //check if coupon is already applied
            $coupon_exists = CouponReport::where('coupon_code', $data['coupon_code'])->where('user_id', Auth::guard('api')->user()->id)->first();
            if (!$coupon_exists) {
                $coupon_data['coupon_code'] = $coupon->coupon_code;
                $coupon_data['user_id'] = Auth::guard('api')->user()->id;
                $coupon_data['service_id'] = $car_rental->car->service_id;
                $coupon_data['applied_for_id'] = $car_rental->id;
                $coupon_data['applied_on'] =  $date_today;
                $coupon_data['total_amount'] =  $total_amount;
                $coupon_data['coupon_discount_amount'] =  $discount;
                $coupon_report  =  CouponReport::create($coupon_data);
                $car_rental->discount = $discount;
                $car_rental->final_amount -= $discount;
                $car_rental->save();
                if (!$coupon_report) {
                    $data   = null;
                    $message    =   trans('api.coupon.apply_discount_unsuccess');
                    $status_code   = 401;
                } else {
                    $data   = $coupon_report;
                    $message    =   trans('api.coupon.apply_discount_success');
                    $status_code   = 200;
                    return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
                }
            } else {
                $data   = null;
                $message    =   trans('api.coupon.coupon_already_applied');
                $status_code   = 401;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
        }
    }
}
