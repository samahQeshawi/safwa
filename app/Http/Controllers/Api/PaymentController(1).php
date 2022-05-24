<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodsResource;
use App\Models\PaymentMethod;
use App\Models\UserPaymentOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use App\Events\AutoPaymentCompleteEvent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// use Devinweb\LaravelHyperpay\Facades\LaravelHyperpay;
use App\Models\Transaction;
use App\Http\Controllers\Api\AuthController;
use App\Models\CarRental;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\Wallet;
use App\Events\PaymentStatusPaidEvent;
// use App\Services\TripServices;

class PaymentController extends CustomersTripsController
{

    function __construct()
    {
        // $this->tripService = new TripServices();
    }
    #################### ------------
    public static function checkout(Request $request, $createRegistration = false)
    {
        // $request = new Request($data_arr);
        // $user = auth()->user();
        $user = User::where('id', auth()->user()->id)->with('city')->get()->first();
        // return $user;

        $prevlink = env('SANDBOX_MODE') == true ? "test." : "";
        $url = "https://" . $prevlink . "oppwa.com/v1/checkouts";
        if($request->payment_method_id == config('constants.Mada')) {
            $data = "entityId=". env('ENTITY_ID_MADA');
        }
        else $data = "entityId=". env('ENTITY_ID');

        if( $createRegistration ) {
            $data .= "&notificationUrl=http://www.example.com/notify";
            $data .= "&createRegistration=true";
        } else {
            $data .= "&merchantTransactionId=" . $request->id_no .
            "&testMode=EXTERNAL" .
            "&amount=" . $request->amount .
            "&currency=" . $request->currency .
            "&paymentType=DB" .
            "&customer.email=" . $user->email .
            // "&customer.street1=" . $user->address .
            // "&customer.city=" . $user->city->name .
            // "&customer.state=" . $user->city->name .
            // "&customer.country=SA" .
            // "&customer.postcode=" . $user->zipcode .
            "&customer.givenName=" . $user->name .
            "&customer.surname=" . $user->surname ;
        }
        if( isset($request->registrations[0]) ) {
            $data .= "&registrations[0].id=". $request->registrations[0];
        }
        if( isset($request->registrations[1]) ) {
            $data .= "&registrations[1].id=". $request->registrations[1];
        }
        if( isset($request->registrations[0]) || isset($request->registrations[1]) ) {
            $data .= "&standingInstruction.source=CIT" .
            "&standingInstruction.mode=REPEATED" .
            "&standingInstruction.type=UNSCHEDULED" .
            "&shopperResultUrl=com.wasltec.Safwa.payments";
        }

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
        $payment_method_id = '';
        if( $request->product_type == "trip" ) {
            $query = Trip::find($request->product_id);
            $id_no = $query->trip_no;
            $payment_method_id = $query->payment_method_id;
        } else if( $request->product_type == "booking" ) {
            $query = Booking::find($request->product_id);
            $id_no = $query->booking_no;
            // $payment_method_id = $query->payment_method_id;
        }
        $request->id_no = $id_no;
        $request->payment_method_id = $payment_method_id;

        $result = $this->checkout($request);

        if(isset($result['id'])) {
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
        if($request->service_type == 'booking')
            $payment_method_id = Booking::find($request->id)->payment_method_id;
        else if($request->service_type == 'trip')
            $payment_method_id = Trip::find($request->id)->payment_method_id;

        // return $request;
    	$commission = 10;
        $trip_details = [];
        $notify['notify'] = [];
        $data = [];
        $prevlink = env('SANDBOX_MODE') == true ? "test." : "";
        $url = "https://" . $prevlink . "oppwa.com/v1/checkouts/" . $request->checkout_id . "/payment?";

        if($payment_method_id == config('constants.Mada')) {
            $url .= "entityId=". env('ENTITY_ID_MADA');
        }
        else $url .= "entityId=". env('ENTITY_ID');

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

    	// return $result;
        // Result Example
        // {
        //     "id": "8ac7a4a17b7d2020017b7dc658516014",
        //     "paymentType": "DB",
        //     "paymentBrand": "VISA",
        //     "amount": "20.00",
        //     "currency": "SAR",
        //     "descriptor": "4955.7828.4856 Tahudat AL safwa",
        //     "result": {
        //         "code": "000.100.110",
        //         "description": "Request successfully processed in 'Merchant in Integrator Test Mode'"
        //     },
        //     "resultDetails": {
        //         "ConnectorTxID1": "8ac7a4a17b7d2020017b7dc658516014"
        //     },
        //     "card": {
        //         "bin": "411111",
        //         "binCountry": "US",
        //         "last4Digits": "1111",
        //         "holder": "Fgg H",
        //         "expiryMonth": "08",
        //         "expiryYear": "2022"
        //     },
        //     "customer": {
        //         "ip": "51.252.100.89",
        //         "ipCountry": "SA"
        //     },
        //     "customParameters": {
        //         "SHOPPER_MSDKIntegrationType": "Checkout UI",
        //         "SHOPPER_device": "iPhone8,2",
        //         "CTPE_DESCRIPTOR_TEMPLATE": "",
        //         "SHOPPER_OS": "iOS 14.7.1",
        //         "SHOPPER_MSDKVersion": "2.58.0"
        //     },
        //     "risk": {
        //         "score": "100"
        //     },
        //     "buildNumber": "271ba226dc1e1aa1c297778e594d94428a0b9227@2021-08-24 13:58:51 +0000",
        //     "timestamp": "2021-08-25 14:46:00+0000",
        //     "ndc": "ECDC3BDAE934429EF03762E8A7924196.uat01-vm-tx02"
        // }

    	// return $result;
        $status_code = $result['result']['code'];
        $successResult1 = '/^(000\.000\.|000\.100\.1|000\.[36])/';
        $successResult2 = '/^(000\.400\.0[^3]|000\.400\.100)/';
        if(preg_match($successResult1, $status_code) || preg_match($successResult2, $status_code)) {
            // return $result;
            $message = $result['result']['description'];
            $status = explode(' ', $message);   $status = $status[1];
            $status_code = $result['result']['code'];
            $successResult1 = '/^(000\.000\.|000\.100\.1|000\.[36])/';
            $successResult2 = '/^(000\.400\.0[^3]|000\.400\.100)/';
            if(preg_match($successResult1, $status_code) || preg_match($successResult2, $status_code)) {

                $tranaction_data['status'] = $status;
                $tranaction_data['data'] = $result['result'];
                $tranaction_data['trackable_data'] = $result;
                $tranaction_data['amount'] = 0;
                $tranaction_data['brand'] = $request->brand;
                $tranaction_data['note'] = 'Transaction pending with card number: XXXXXXXXXXXX' . $result['card']['last4Digits'];
                $tranaction_data['done_by'] = auth()->user()->id;
                if($request->service_type == 'booking')
                    $tranaction_data['booking_id'] = $request->id;
                else if($request->service_type == 'trip')
                    $tranaction_data['trip_id'] = $request->id;

                Transaction::updateOrCreate(['checkout_id' => $request->checkout_id], $tranaction_data );
            }

// 			test here
            if($status == 'successfully') {
                $user_id = auth()->user()->id;
                $mobile = auth()->user()->phone;

                $transaction = Transaction::where('checkout_id', $request->checkout_id)->get()->first();

                // save card token if exists
                if( isset($result['registrationId']) ) {
                    $payment_method_id = PaymentMethod::where('key_name', $request->brand)->get()->first()->id;
                    if(!isset($request->holder_name)) $request->holder_name = "";
                    UserPaymentOption::create([
                        'user_id' => $user_id,
                        'payment_method_id' => $payment_method_id,
                        'payment_title' => $request->brand,
                        'holder_name' => $request->holder_name,
                        'cc_last4' => $request->cc_last4,
                        'registration_id' => $result['registrationId']
                    ]);
                }

            	// return $transaction;

                if( !empty($transaction->booking_id) ) {
                    CarRental::updateOrCreate(
                        ['id' => $transaction->booking_id],
                        ['payment_status' => '1']
                    );
                    $booking = CarRental::where('id',$transaction->booking_id)->get()->first();
                } else if( !empty($transaction->trip_id) ) {

                    $trip = Trip::where('id', $transaction->trip_id)->get()->first();

                	// return $trip;	// for test
                    if($trip->payment_status == 0){
                        $trip->payment_status = 1;
                        $trip->collected_money = $result['amount'];
                        $trip->status = '9';
                        $trip->save();

                        $amount_to_customer_wallet = $result['amount']; // $trip->final_amount;
                        $commission_amount  =   $commission * $trip->final_amount * .01;
                        $amount_to_driver_wallet  =   $trip->final_amount - $commission_amount;
                        $driver_wallet = Wallet::where('user_id', $trip->driver_id)->first();

                    	// ===========
                        // Driver Wallet
                        if ($driver_wallet) {
                            // $driver_wallet->amount += $amount_to_driver_wallet;
                            // $driver_wallet->save();
                        } else {
                            $wallet_data['user_id'] = $trip->driver_id;
                            $wallet_data['amount'] = $amount_to_driver_wallet;
                            $wallet_data['user_type'] = '3';
                            $wallet_data['is_active'] = '1';
                            $wal = Wallet::create($wallet_data);
                        	// return $wal;
                        }
                        // $data['amount'] = $amount_to_driver_wallet;
                        // $data['done_by']  = auth()->user()->id;
                        // $data['sender_id'] = 0;
                        // $data['receiver_id'] = $trip->driver_id;
                        // $data['trip_id'] = $trip->id;
                        // $data['note'] = trans('api.driver.money_adjusted');


                        $transaction->status = "Completed";
                        $transaction->trackable_data = $result;
                        $transaction->amount = $result['amount'];
                        $transaction->note = 'Transaction Completed with card number: XXXXXXXXXXXX' . $result['card']['last4Digits'];
                        $transaction->save();

                        // Customer wallet
                        $customer_wallet = Wallet::where('user_id', $trip->customer_id)->first();
                        if ($customer_wallet) {
                            $customer_wallet->amount += $amount_to_customer_wallet;
                            $customer_wallet->save();
                        } else {
                            $wallet_data['user_id'] = $trip->customer_id;
                            $wallet_data['amount'] = $amount_to_customer_wallet;
                            $wallet_data['user_type'] = '4';
                            $wallet_data['is_active'] = '1';
                            Wallet::create($wallet_data);
                        }

                        $trip_details = $this->formatTripDetailsWithKey($trip);
                    	// =============
                        $sms = "You've made transaction for trip #". $trip->trip_no;
                        AuthController::sms_otp($mobile , $sms);

                        $driver_push = AuthController::sendPushNotification([
                            'title' => "Money Collected for trip #" . $trip->trip_no,
                            'body' => "Tranaction Completed and Money Collected for trip #" . $trip->trip_no,
                            'user_id' => $trip->driver_id,
                        ], ['trip_details' => $trip_details]);
                        $notify['notify'] = [
                            'user_id' => $trip->driver_id ,
                            'push' => $driver_push,
                        ];
                        // array_push($test_notify, ["user_id" => $item['user_id'], "push" => $res]);

                    //Customer wallet
                    }

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
                $data = ["trip" => $trip_details]
                    + ["customer_sms" => [ 'message' => $sms_message , 'status_code' => $sms_status_code ]
                    + $notify
                ];
            }
        } else {
            $message = "Faild to get payment gateway details";
            $status_code    = 500;
        }

        return response(['data' => [$data + ["hyperpay_response" => $result]], 'message' => $message, 'status_code' => $status_code]);
    }

    #################### ------------
    public function get_registration_token(Request $request)
    {
        $result = $this->checkout($request, true);

        if(isset($result['id'])) {
            $data['done_by'] = auth()->user()->id;
            // $data['checkout_id'] = $result['id'];
            // $data['status'] = 'pending';
            // $data['data'] = $result['result'];
            // Transaction::create($data);

            $message = 'successfully created checkout for card registration';
            $status_code    = 200;
        } else {
            $message = 'Faild to create checkout for card registration';
            $status_code    = 500;
        }

        return response(['data' => $result, 'message' => $message, 'status_code' => $status_code]);
    }

    // =================
    public function registration_payment(Request $request)
    {
        $payment_method_id = null;
        if( $request->product_type == "trip" ) {
            $query = Trip::find($request->product_id);
            $id_no = $query->trip_no;
            $payment_method_id = $query->payment_method_id;
        } else if( $request->product_type == "booking" ) {
            $query = Booking::find($request->product_id);
            $id_no = $query->booking_no;
            $payment_method_id = $query->payment_method_id;
        }
        // $request->id_no = $id_no;
        // $request->payment_method_id = $payment_method_id;

        // $mark = substr($request->cc_number, 0, 1);
        // $Brand = $paymentType = "";
        // if($mark == '4') {
        //     $Brand = "VISA";
        //     $paymentType = "DB";
        // }
        // else if ($mark == '5') {
        //     $Brand = "MASTER";
        //     $paymentType = "PA";
        // }
        $prevlink = env('SANDBOX_MODE') == true ? "test." : "";
        $url = "https://" . $prevlink . "oppwa.com/v1/registrations/". $request->card_token ."/payments";

        if($payment_method_id == config('constants.Mada')) {
            $data = "entityId=". env('ENTITY_ID_MADA');
        }
        else $data = "entityId=". env('ENTITY_ID');

        $data .= "&amount=" . $request->amount .
                    "&currency=" . $request->currency .
                    "&paymentType=PA" .
                    // "&paymentBrand=" . $Brand .
                    // "&card.number=" . $request->cc_number .
                    // "&card.holder=" . $request->cc_holder .
                    // "&card.expiryMonth=" . $request->cc_expiryMonth .
                    // "&card.expiryYear=" . $request->cc_expiryYear .
                    // "&card.cvv=" . $request->cc_cvv .
                    "&standingInstruction.source=MIT" .
                    "&standingInstruction.mode=REPEATED" .
                    "&standingInstruction.type=UNSCHEDULED" .
                    "&shopperResultUrl=com.wasltec.Safwa.payments";


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

        return json_decode($responseData , true);
        // return $responseData;
    }

   // =================
    public function auto_payment(Request $request) {
        $commission = 10;
        $rules = [
            'registration_id' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'service' => 'required',
            'id' => 'required',
            'user_id' => 'required',
        ];
        $data_arr = $request->all();
        $validator = Validator::make($data_arr, $rules);
        $request = new Request([
            'card_token' => $data_arr['registration_id'],
            'amount' => $data_arr['amount'],
            'currency' => $data_arr['currency'],
        ]);
        $result = $this->registration_payment($request);
        $payment_option['registration_id'] = $data_arr['registration_id'];
        $paymentData =UserPaymentOption::where($payment_option)->first();
        // $result = json_decode($responseData , true);

        $data_arr['trip_id'] = null;
        $data_arr['booking_id'] = null;

        if($result) {
            // return $result;
            $message = $result['result']['description'];
            $status = explode(' ', $message);   $status = $status[1];
            $status_code = $result['result']['code'];
            $successResult1 = '/^(000\.000\.|000\.100\.1|000\.[36])/';
            $successResult2 = '/^(000\.400\.0[^3]|000\.400\.100)/';
            if(preg_match($successResult1, $status_code) || preg_match($successResult2, $status_code)) {
            if( $data_arr['service'] == 'trip' ) $data_arr['trip_id'] = $data_arr['id'];
            else if( $data_arr['service'] == 'booking' ) $data_arr['booking_id'] = $data_arr['id'];

            $transaction = Transaction::create([
                'amount' => $data_arr['amount'],
                'currency' => $data_arr['currency'],
                'done_by' => $data_arr['user_id'],
                'booking_id' => $data_arr['booking_id'],
                'trip_id' => $data_arr['trip_id'],
                'checkout_id' => $result['ndc'],
                // 'amount' => $data_arr['currency'],
                'status' => $status,
                'data' => $result['result'],
                'brand' => $paymentData['payment_title'] ,
                'note' => 'Transaction ' .$status. ' with card number: XXXXXXXXXXXX' . $paymentData['cc_last4']
            ]);

            if($status == 'successfully' && $transaction) {
                $mobile = User::find($data_arr['user_id'])->phone;
                $body = "Your transaction successfully processed with card # **" . $data_arr['payment_option']['cc_last4'];
                $sms_response = AuthController::sms_otp($mobile , $body);

                $trip = Trip::where('id',$data_arr['trip_id'])->first();
                $trip_details = $this->formatTripDetailsWithKey($trip);
                $commission_amount  =   $commission * $trip->final_amount * .01;
                $amount_to_driver_wallet  =   $trip->final_amount - $commission_amount;
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
                $data_tran['amount'] = $amount_to_driver_wallet;
                $data_tran['done_by']  = $trip->customer_fid;
                $data['sender_id'] = 0;
                $data['receiver_id'] = $trip->driver_id;
                $data['trip_id'] = $trip->id;
                $data['note'] = trans('api.driver.money_adjusted');
                Transaction::create($data);
                //Call the TripStatusHasUpdatedEvent with this
                event(new AutoPaymentCompleteEvent($trip, $trip_details));

                $status_code = 200;
                // send email/sms to customer
                // SMS Gateway disabled
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
                } else {
                    $message = "Payment Declined";
                    $status_code    = 500;
                }
            } else {
                $message = "Payment Declined";
                $status_code    = 500;
            }
        } else {
            $message = "Faild to connect payment gateway";
            $status_code    = 500;
        }
        return ['data' => $result, 'message' => $message, 'status_code' => $status_code];
    }


    // server-to-server Payments
    #################### ------------
    public function initialPayment(Request $request)
    {
        // $mark = substr($request->cc_number, 0, 1);
        // $Brand = $paymentType = "";
        // if($mark == '4') {
        //     $Brand = "VISA";
        //     $paymentType = "DB";
        // }
        // else if ($mark == '5') {
        //     $Brand = "MASTER";
        //     $paymentType = "PA";
        // }
        $prevlink = env('SANDBOX_MODE') == true ? "test." : "";
        $url = "https://" . $prevlink . "oppwa.com/v1/payments";
        $data = "entityId=". env('ENTITY_ID') .
                    "&amount=" . $request->amount .
                    "&currency=" . env('CURRENCY') .
                    // "&paymentBrand=" . $Brand .
                    // "&paymentType=" . $paymentType .
                    // "&card.number=" . $request->cc_number .
                    // "&card.holder=" . $request->cc_holder .
                    // "&card.expiryMonth=" . $request->cc_expiryMonth .
                    // "&card.expiryYear=" . $request->cc_expiryYear .
                    // "&card.cvv=" . $request->cc_cvv .
                    "&standingInstruction.source=CIT" .
                    "&standingInstruction.mode=INITIAL" .
                    "&standingInstruction.type=UNSCHEDULED" .
                    "&shopperResultUrl=com.wasltec.Safwa.payments";

        if( isset($request->registrations[0]) ) {
            $data .= "&registrations[0].id=". $request->registrations[0];
        }
        if( isset($request->registrations[1]) ) {
            $data .= "&registrations[1].id=". $request->registrations[1];
        }


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

    public function get_payment_status_only(Request $request){

        $prevlink = env('SANDBOX_MODE') == true ? "test." : "";
        $url = "https://" . $prevlink . "oppwa.com/v1/checkouts/" . $request->checkout_id . "/payment?";

        if($request->payment_method_id == config('constants.Mada')) {
            $url .= "entityId=". env('ENTITY_ID_MADA');
        }
        else $url .= "entityId=". env('ENTITY_ID');

        // return $url;
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
            $successResult1 = '/^(000\.000\.|000\.100\.1|000\.[36])/';
            $successResult2 = '/^(000\.400\.0[^3]|000\.400\.100)/';
            if(preg_match($successResult1, $status_code) || preg_match($successResult2, $status_code)) {
                $message = "Payment Status Successfulle";
                $status_code    = 200;
            } else {
                 $message = "Faild to connect payment gateway";
                  $status_code    = 500;
            }
        }
        return response(['data' => $result, 'message' => $message, 'status_code' => $status_code]);
    }

    public function save_registration_token(Request $request){
        $rules = [
            'registration_token' => 'required',
            'brand' => 'required',
            'payment_method_id' => 'required',
            'cc_last' => 'required|max:4',
            'is_default' => 'nullable|max:1',
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
        $data['registration_id'] =  $request->registration_token;
        $data['payment_method_id'] =  $request->payment_method_id;
        //$data['registration_id'] = $request->registration_token;
        $PaymentOptions = UserPaymentOption::where($data)->first();
        if(empty($PaymentOptions)){

            $data['payment_title'] = $request->brand;
            $data['cc_last4'] = $request->cc_last;
            if(isset($request->is_default)){
                $data['is_default']    = $request->is_default;
            }
            $data['registration_id'] = $request->registration_token;
            $PaymentOptionsid = UserPaymentOption::create($data)->id;
        } else {
            $data['payment_title'] = $request->brand;
            $data['cc_last4'] = $request->cc_last;
            if(isset($request->is_default)){
                $data['is_default']    = $request->is_default;
            }
            $data['registration_id'] = $request->registration_token;
            $PaymentOptions->delete();
            $PaymentOptionsid = UserPaymentOption::create($data)->id;

        }
        $status_code = 200;
        $message = "Successfully Saved Registration Token";
        $result = [
                    'verify' => [
                        'message' => "Successfully Saved Registration Token" ,
                        'status_code' => $status_code
                    ]
                ];
         return response(['data' => $result, 'message' => $message, 'status_code' => $status_code]);
    }

}
