<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodsResource;
use App\Models\PaymentMethod;
use App\Models\UserPaymentOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

// use Devinweb\LaravelHyperpay\Facades\LaravelHyperpay;
use App\Models\Transaction;
use App\Http\Controllers\Api\AuthController;
use App\Models\CarRental;
use App\Models\Trip;

class PaymentController extends Controller
{
    #################### ------------
    public static function checkout(Request $request)
    {
        // $request = new Request($data_arr);
        $prevlink = env('SANDBOX_MODE') == true ? "test." : "";
        $url = "https://" . $prevlink . "oppwa.com/v1/checkouts";
        $data = "entityId=". env('ENTITY_ID') .
                "&amount=" . $request->amount .
                "&currency=" . $request->currency .
                "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . env('ACCESS_TOKEN')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        return json_decode($responseData , true);
    }

    #################### ------------
    public function get_payment_token(Request $request)
    {
        $result = $this->checkout($request);

        if($result['id']) {
            $data['amount'] = $request->amount;
            $data['currency'] = $request->currency;
            $data['done_by'] = auth()->user()->id;

            if($request->product_type == 'booking')
                $data['booking_id'] = $request->product_id;
            else if($request->product_type == 'trip')
                $data['trip_id'] = $request->product_id;

            $data['checkout_id'] = $result['id'];
            $data['status'] = 'pending';
            $data['data'] = $result['result'];
            Transaction::create($data);

            $message = 'successfully created checkout';
            $status_code    = 200;
        } else {
            $message = 'Faild to create checkout';
            $status_code    = 500;
        }

        return response(['data' => $result, 'message' => $message, 'status_code' => $status_code]);
    }


    public function get_payment_status(Request $request)
    {
        $prevlink = env('SANDBOX_MODE') == true ? "test." : "";
        $url = "https://" . $prevlink . "oppwa.com/v1/checkouts/" . $request->checkout_id . "/payment";
        $url .= "?entityId=" . env('ENTITY_ID');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . env('ACCESS_TOKEN')));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $result = json_decode($responseData , true);

        if($result) {
            $message = $result['result']['description'];
            $status = explode(' ', $message);   $status = $status[1];
            $status_code = $result['result']['code'];
            Transaction::updateOrCreate(
                ['checkout_id' => $request->checkout_id],
                [
                    'status' => $status,
                    'data' => $result['result'],
                    'brand' => $request->brand ,
                    'note' => 'Transaction successfully processed with card number: XXXXXXXXXXXX' . $request->cc_last4
                ]
            );

            // $transaction->update([
            //     'status' => $status,
            //     'data' => $result['result'],
            //     'brand' => $request->brand ,
            //     'note' => 'Transaction successfully processed with card number: XXXXXXXXXXXX' . $request->cc_last4
            // ]);
            if($status == 'successfully') {
                // $user_id = auth()->user()->id;
                $mobile = auth()->user()->phone;

                $transaction = Transaction::where('checkout_id', $request->checkout_id)->get()->first();

                if( !empty($transaction->booking_id) ) {
                    CarRental::updateOrCreate(
                        ['id' => $transaction->booking_id],
                        ['payment_status' => '1']
                    );
                    $booking = CarRental::where('id',$transaction->booking_id)->get()->first();
                    $sms = "You've ". $booking->booking_no ." Pickup on: ". $booking->pickup_on .", From: ". $booking->branch->name ." branch";
                    AuthController::sms_otp($mobile , $sms);
                } else if( !empty($transaction->trip_id) ) {
                    Trip::updateOrCreate(
                        ['id' => $transaction->trip_id],
                        ['payment_status' => '1']
                    );
                    $trip = Trip::where('id', $transaction->trip_id)->get()->first();
                    $sms = "You've ride# ". $trip->trip_no ." From Address: ". $trip->from_address;
                    AuthController::sms_otp($mobile , $sms);
                }
                $status_code = 200;
                // send email/sms to customer
                // SMS Gateway disabled
                $body = "Your transaction successfully processed with card # **" . $request->cc_last4;
                $sms_response = AuthController::sms_otp($mobile , $body);
                if ($sms_response === false) {
                    $sms_message    =   trans('api.auth.sms_not_sent');
                    $sms_status_code   = 500;
                } else {
                    $sms_message    =   trans('api.auth.sms_sent');
                    $sms_status_code   = 200;
                }
                $result = $result + [
                    'verify' => [
                        'message' => $sms_message ,
                        'status_code' => $sms_status_code
                    ]
                ];
            }
        } else {
            $message = "Faild to connect payment gateway";
            $status_code    = 500;
        }

        return response(['data' => $result, 'message' => $message, 'status_code' => $status_code]);
    }

    // server-to-server Payments
    #################### ------------
    public function initialPayment(Request $request)
    {
        $mark = substr($request->cc_number, 0, 1);
        $Brand = $paymentType = "";
        if($mark == '4') {
            $Brand = "VISA";
            $paymentType = "DB";
        }
        else if ($mark == '5') {
            $Brand = "MASTER";
            $paymentType = "PA";
        }
        $prevlink = env('SANDBOX_MODE') == true ? "test." : "";
        $url = "https://" . $prevlink . "oppwa.com/v1/payments";
        $data = "entityId=". env('ENTITY_ID') .
                    "&amount=" . $request->amount .
                    "&currency=" . env('CURRENCY') .
                    "&paymentBrand=" . $Brand .
                    "&paymentType=" . $paymentType .
                    "&card.number=" . $request->cc_number .
                    "&card.holder=" . $request->cc_holder .
                    "&card.expiryMonth=" . $request->cc_expiryMonth .
                    "&card.expiryYear=" . $request->cc_expiryYear .
                    "&card.cvv=" . $request->cc_cvv .
                    "&shopperResultUrl=https://safwagroups.com/initial-payment";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . env('ACCESS_TOKEN')));
            // 'Authorization:Bearer ' . env('ACCESS_TOKEN')));
            curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $message = 'Prepare Checkout Successfully';
        $status_code    = 200;

        return response(['data' => json_decode($responseData) , 'message' => $message, 'status_code' => $status_code]);

        // return $responseData;
    }

}
