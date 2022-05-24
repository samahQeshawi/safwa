<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodsResource;
use App\Models\PaymentMethod;
use App\Models\UserPaymentOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_method   = PaymentMethod::all();
        $data    = [
            'payment_methods' => PaymentMethodsResource::collection($payment_method)
        ];
        $message = 'Payment Method retrieved successfully';
        $status_code    = 200;
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
        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
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
    public function update(Request $request, City $city)
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
    public function destroy(City $city)
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

    public function user_payment_options(Request $request)
    {
        $user_id = auth()->user()->id;
        $payment_method   = UserPaymentOptions::with('paymentMethod')->where('user_id', $user_id)->get();

        $payment_method = $this->formatUserPaymentDetails($payment_method);

        $data    = [
            'user_payment_options' => PaymentMethodsResource::collection($payment_method)
        ];
        $message = 'User Payment Options retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function formatUserPaymentDetails($data)
    {
        $final_arr = array();
        foreach ($data as $row) {
            $newdata['id'] = $row->id;
            $newdata['user_id'] = $row->user_id;
            $newdata['is_default'] = $row->is_default;
            $newdata['payment_method_id'] = isset($row->payment_method_id) ? $row->payment_method_id : '';
            $newdata['name'] = isset($row->paymentMethod->name) ? $row->paymentMethod->name : '';
            $newdata['image_file'] = isset($row->paymentMethod->image_file) ? $row->paymentMethod->image_file : '';
            $final_arr[] = $newdata;
        }
        return $final_arr;
    }

    public function add_payment_options(Request $request)
    {
        $rules = [
            'paymentMethodId' => 'required',
            'isDefault' => 'required',
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

        $user_id = auth()->user()->id;
        $data['user_id'] = $user_id;
        $data['payment_method_id'] = $request->paymentMethodId;
        $data['payment_title'] = $request->paymentTitle;
        $data['is_default'] = $request->isDefault;


        $PaymentOptionsid = UserPaymentOptions::create($data)->id;

        $payment_method   = UserPaymentOptions::with('paymentMethod')->where('id', $PaymentOptionsid)->get();
        $payment_method = $this->formatUserPaymentDetails($payment_method);
        $data    = [
            'user_payment_options' => PaymentMethodsResource::collection($payment_method)
        ];
        $message = 'User Payment added successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function update_payment_default_options(Request $request)
    {
        $rules = [
            'isDefault' => 'required',
            'paymentMethodId' => 'required',
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

        $user_id = auth()->user()->id;
        $UserPaymentOption = UserPaymentOptions::where('user_id', $user_id)->update(['is_default' => 0]);
        $UserPaymentOption = UserPaymentOptions::where('user_id', $user_id)->where('payment_method_id', $request->paymentMethodId)->first();
        if (!isset($UserPaymentOption)) {
            $errors = 'Please add User payment details';
            $data   = null;
            $message    =   'Validation Error!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $UserPaymentOption->update(['is_default' => $request->isDefault]);


        $payment_option   = UserPaymentOptions::with('paymentMethod')->where('id', $UserPaymentOption->id)->get();
        $payment_option = $this->formatUserPaymentDetails($payment_option);
        $data    = [
            'user_payment_options' => PaymentMethodsResource::collection($payment_option)
        ];
        $message = 'Default payment option updated successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }
}
