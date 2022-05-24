<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otps;
use App\Models\Trip;
use App\Models\Rating;
use App\Models\Driver;
use App\Models\UserDevice;
use App\Models\UserPaymentOption;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use phpseclib\Crypt\Hash as CryptHash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register new app user
     *
     * @return JSON
     */
    public function register(Request $request) {
        $user_type_id = 4; // Customer
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users',
            'phone' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    $query->where('user_type_id', 4);
                }),
            ],
            'password' => 'required|string|min:6',
            'country_id' => 'required|numeric',
            // 'user_type_id' => 'required|numeric',
        ]);
        if(!$request->has('name') || !$request->has('email') /* || !$request->has('phone') */ || !$request->has('password') ){
            return response()->json(['errors'=>'Please send name ,email and password to complete registration'], 200);
        }
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 200);
        }

        $pass = $request['password'];
        // $verification_code = mt_rand(100000, 999999);
        $request['password'] = Hash::make($pass);
        $request['socket_token'] = Str::random(50);
        $request['user_type_id'] = $user_type_id; // Customer
        // $request['verification_code'] = $verification_code;
        User::create($request->toArray());

        Auth::attempt(['email' => $request['email'], 'password' => $pass]);
        $user = Auth::user();

        $newCustomer = $user;

        $customer['user_id'] = $user->id;
        Customer::create($customer); //create customer

        $wallet_data['user_id'] = $newCustomer['id'];
        $wallet_data['amount'] = 0;
        $wallet_data['user_type'] = $user_type_id;
        $wallet_data['is_active'] = '1';
        Wallet::create($wallet_data);

        $sixthpaymentOption_data['user_id'] = $user->id;
        $sixthpaymentOption_data['payment_method_id'] = config('constants.Mada');
        $sixthpaymentOption_data['payment_title'] = 'Mada';
        $sixthpaymentOption_data['is_default'] = '0';
        UserPaymentOption::create($sixthpaymentOption_data);

        $firstpaymentOption_data['user_id'] = $newCustomer['id'];
        $firstpaymentOption_data['payment_method_id'] = config('constants.Cash');
        $firstpaymentOption_data['payment_title'] = 'Cash';
        $firstpaymentOption_data['is_default'] = '1';
        UserPaymentOption::create($firstpaymentOption_data);

        $secondpaymentOption_data['user_id'] = $newCustomer['id'];
        $secondpaymentOption_data['payment_method_id'] = config('constants.Wallet');
        $secondpaymentOption_data['payment_title'] = 'Wallet';
        $secondpaymentOption_data['is_default'] = '0';
        userPaymentOption::create($secondpaymentOption_data);

        $fifthpaymentOption_data['user_id'] = $newCustomer['id'];
        $fifthpaymentOption_data['payment_method_id'] = config('constants.Card');
        $fifthpaymentOption_data['payment_title'] = 'Credit/Debit Card';
        $fifthpaymentOption_data['is_default'] = '0';
        UserPaymentOption::create($fifthpaymentOption_data);

        // $thirdpaymentOption_data['user_id'] = $newCustomer['id'];
        // $thirdpaymentOption_data['payment_method_id'] = config('constants.Visa');
        // $thirdpaymentOption_data['payment_title'] = 'Visa Card';
        // $thirdpaymentOption_data['is_default'] = '0';
        // UserPaymentOption::create($thirdpaymentOption_data);

        // $fourthpaymentOption_data['user_id'] = $newCustomer['id'];
        // $fourthpaymentOption_data['payment_method_id'] = config('constants.Mastercard');
        // $fourthpaymentOption_data['payment_title'] = 'Master Card';
        // $fourthpaymentOption_data['is_default'] = '0';
        // UserPaymentOption::create($fourthpaymentOption_data);


        $token = $this->generateNumericOTP(4);
        $newDateTime  = Carbon::now()->addMinutes(5)->toDateTimeString();
        //dd($validatedData);
        $data['country_id'] = $request->country_id;
        $data['phone'] = $newCustomer['phone'];
        $data['otp'] = $token;
        $data['otp_expire_on']  = $newDateTime;
        $data['user_id'] = $newCustomer['id'];
        $data['user_type_id'] = $user_type_id;
        Otps::create($data);

        // SMS Gateway disabled
        $body = "Your OTP to verify mobile is " . $token;
        $response = $this->sms_otp($newCustomer['phone'], $body);


        $accessToken = $user->createToken('LaravelAuthApp')->accessToken;
        // $response = ['user'=>$user, 'access_token' => $accessToken ,'error'=>0 ];

        $data   = [
            //'user' => auth()->user(),
            'user_details' => $this->formatCustomerLoginResponse(auth()->user()),
            'phone_code' => $request['phone_code'],
            'access_token' => $accessToken,
            // 'verification' => $verification
        ];
        $message    =   trans('api.auth.loged_in');
        $status_code   = 200;

        return response(['data' => $data, 'verification' => false, 'message' => $message, 'status_code' => $status_code]);


        // // $response = ['success' => true , 'status'=> 200 , 'error'=>0];
        // return response($response, 200);
    }


    // public function register(Request $request)
    // {

    //     $user_type_id   =   4; //Customer
    //     $rules = [
    //         'name' => 'required|max:55',
    //         'email' => [
    //             'required',
    //             Rule::unique('users')->where(function ($query) {
    //                 $query->where('user_type_id', 4);
    //             }),
    //         ],
    //         'country_id' => 'required',
    //         'nationality_id' => 'required',
    //         'phone' => [
    //             'required',
    //             Rule::unique('users')->where(function ($query) {
    //                 $query->where('user_type_id', 4);
    //             }),
    //         ],
    //         'password' => 'required'
    //     ];

    //     $errors =   [];
    //     $validatedData = $request->all();

    //     $validator = Validator::make($validatedData, $rules);
    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->messages();
    //         $data   = $validatedData;
    //         $message    =   trans('api.auth.validation_error');
    //         $status_code   = 422;
    //         return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
    //     }

    //     $validatedData['password'] = Hash::make($request->password);
    //     $validatedData['socket_token'] = Str::random(50);
    //     $validatedData['user_type_id'] = $user_type_id;
    //     $customerData['nationality_id'] = $request->nationality_id;
    //     unset($validatedData['nationality_id']);
    //     $user = User::create($validatedData)->id;
    //     $newCustomer = User::where('phone', $validatedData['phone'])->where('user_type_id', $user_type_id)->where('country_id', $validatedData['country_id'])->first()->toArray();

    //     $customer['user_id'] = $newCustomer['id'];
    //     $customer['nationality_id'] = $customerData['nationality_id'];
    //     Customer::create($customer); //create customer
    //     $wallet_data['user_id'] = $newCustomer['id'];
    //     $wallet_data['amount'] = 0;
    //     $wallet_data['user_type'] = $user_type_id;
    //     $wallet_data['is_active'] = '1';
    //     Wallet::create($wallet_data);
    //     $firstpaymentOption_data['user_id'] = $newCustomer['id'];
    //     $firstpaymentOption_data['payment_method_id'] = config('constants.Cash');
    //     $firstpaymentOption_data['payment_title'] = 'Cash';
    //     $firstpaymentOption_data['is_default'] = '1';
    //     UserPaymentOption::create($firstpaymentOption_data);
    //     $secondpaymentOption_data['user_id'] = $newCustomer['id'];
    //     $secondpaymentOption_data['payment_method_id'] = config('constants.Wallet');
    //     $secondpaymentOption_data['payment_title'] = 'Wallet';
    //     $secondpaymentOption_data['is_default'] = '0';
    //     UserPaymentOption::create($secondpaymentOption_data);
    //     $token = $this->generateNumericOTP(4);
    //     $newDateTime  = Carbon::now()->addMinutes(5)->toDateTimeString();
    //     //dd($validatedData);
    //     $data['country_id'] = $validatedData['country_id'];
    //     $data['phone'] = $newCustomer['phone'];
    //     $data['otp'] = $token;
    //     $data['otp_expire_on']  = $newDateTime;
    //     $data['user_id'] = $newCustomer['id'];
    //     $data['user_type_id'] = $user_type_id;
    //     Otps::create($data);
    //     $tophone = $newCustomer['phone'];
    //     $body = "Your OTP to verify mobile is " . $token;
    //     $response = $this->sms_otp($tophone, $body);

    //     Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']]);
    //     $loggedUser = Auth::user();

    //     $accessToken = $loggedUser->createToken('authToken')->accessToken;

    //     // Auth::attempt(['email' => $request['email'], 'password' => $pass]);
    //     // $user = Auth::user();
    //     // $accessToken = $user->createToken('LaravelAuthApp')->accessToken;

    //     if ($response === false) {
    //         $data   = $newCustomer;
    //         $message    =   trans('api.auth.register_not_successful');
    //         $status_code   = 500;
    //     } else {
    //         $data   = $newCustomer;
    //         $message    =  trans('api.auth.register_successful');
    //         $status_code   = 200;

    //         // $response = ['token' => $token,'user'=>$user,'error'=>0 ];

    //     }
    //     return response([
    //         'data' => $data, 'message' => $message,
    //         'access_token' => $accessToken,
    //         'status_code' => $status_code, 'token' => $accessToken, 'errors' => $errors]);
    // }

    public function formatCustomerLoginResponse($row)
    {
        $newdata['user']['user_id'] = $row->id; //This is the primary key of users table
        $newdata['user']['name'] = $row->name;
        $newdata['user']['surname'] = $row->surname;
        $newdata['user']['zipcode'] = $row->zipcode;
        $newdata['user']['address'] = $row->address;
        $newdata['user']['phone'] = $row->phone;
        $newdata['user']['email'] = $row->email;
        $newdata['user']['gender'] = $row->gender;
        $newdata['user']['profile_image'] = $row->profile_image;
        $newdata['user']['dob'] = $row->dob;
        $newdata['user']['national_id'] = $row->national_id;
        $newdata['user']['socket_token'] = $row->socket_token;
        $newdata['country'] = $row->country;
        $newdata['nationality'] = $row->nationality;
        $newdata['city'] = $row->city;
        return $newdata;
    }

    public function login(Request $request)
    {

        $loginData = $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);
        $user_type_id   =   4;
        $loginData['user_type_id'] = $user_type_id; //Restrict login to only user type 4, Customers
        //$loginData['country.phone_code'] = '+966'; //Restrict login to only user type 3, Drivers
        $country =   Country::where('phone_code', $request['phone_code'])->first();
        if (!$country) {
            $data   = null;
            $message    =   trans('api.auth.invalid_phone_code');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $loginData['country_id'] = $country->id;


        if (!auth()->attempt($loginData)) {

            $data   = null;
            $message    =    trans('api.auth.invalid_credentials');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $verification = !empty(auth()->user()->phone_verified_at) ? true : false;
        if (!$verification) {
            $otp = Otps::where('phone', $loginData['phone'])->where('user_type_id', $loginData['user_type_id'])->orderBy('id', 'desc')->first();
            $token = $this->generateNumericOTP(4);
            $newDateTime  = Carbon::now()->addMinutes(5)->toDateTimeString();
            if ($otp) {
                $data['otp'] = $token;
                $data['otp_expire_on'] = $newDateTime;
                $otp->update($data);
            } else {
                $data['phone'] = $loginData['phone'];
                $data['country_id'] = $country->id;
                $data['otp'] = $token;
                $data['otp_expire_on']  = $newDateTime;
                $data['user_id'] = auth()->user()->id;
                $data['user_type_id'] = $user_type_id;
                Otps::create($data);
            }
            $tophone = $loginData['phone'];
            $body = "Your OTP to reset password is " . $token;
            $response = $this->sms_otp($tophone, $body);
            if ($response === false) {
                $data   = null;
                $message    =   trans('api.auth.sms_not_sent');
                $status_code   = 500;
            } else {
                $data   = null;
                $message    =   trans('api.auth.sms_sent');
                $status_code   = 200;
            }
            return response(['data' => $data, 'verification' => $verification, 'message' => $message, 'status_code' => $status_code]);
        }

        $driverObj    =   User::where('phone', $request->phone)->where('user_type_id', 4)->first();
        // $driverObj  =   $checkActive->first();
        if ($driverObj) {
            // echo $driverObj;
            if ($driverObj->is_active == 'Inactive') {
                $data   = null;
                $message    =   trans('api.customer.inactive');
                $status_code   = 422;
                return response(['data' => $data, 'verification' => $verification, 'message' => $message, 'status_code' => $status_code]);
            }
        } else {
            $data   = null;
            $message    =    trans('api.auth.invalid_credentials');
            $status_code   = 422;

            return response(['data' => $data, 'verification' => $verification, 'message' => $message, 'status_code' => $status_code]);
        }

        $data   = [
            //'user' => auth()->user(),
            'user_details' => $this->formatCustomerLoginResponse(auth()->user()),
            'phone_code' => $request['phone_code'],
            'access_token' => $accessToken,
            // 'verification' => $verification
        ];
        $message    =   trans('api.auth.loged_in');
        $status_code   = 200;
        return response(['data' => $data, 'verification' => $verification, 'message' => $message, 'status_code' => $status_code]);
    }


    public function resend_otp(Request $request)
    {
        $resend_otp = $request->validate([
            'phone' => 'required',
            'phone_code' => 'required',
            'user_type_id' => 'required'
        ]);
        $country =   Country::where('phone_code', $request->phone_code)->first();
        if (!$country) {
            $data   = null;
            $message    =   trans('api.auth.invalid_phone_code');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $user = User::where('phone', $request->phone)->where('user_type_id', $request->user_type_id)->where('country_id', $country->id)->first();
        if ($user) {
            $token = $this->generateNumericOTP(4);
            $newDateTime  = Carbon::now()->addMinutes(5)->toDateTimeString();
            $otp = Otps::where('phone', $request->phone)->where('user_type_id', $request->user_type_id)->orderBy('id', 'desc')->first();
            if (!$otp) {
                $data['phone'] = $request->phone;
                $data['country_id'] = $country->id;
                $data['otp'] = $token;
                $data['otp_expire_on']  = $newDateTime;
                $data['user_id'] = $user->id;
                $data['user_type_id'] =  $user->user_type_id;
                Otps::create($data);
            } else {
                $data['otp'] = $token;
                $data['otp_expire_on'] = $newDateTime;
                $otp->update($data);
            }
            $tophone = $request->phone;
            $body = "Your OTP to reset password is " . $token;


            $response = $this->sms_otp($tophone, $body);
            if ($response === false) {
                $data   = null;
                $message    =   trans('api.auth.sms_not_sent');
                $status_code   = 500;
            } else {
                $data   = null;
                $message    =   trans('api.auth.sms_sent');
                $status_code   = 200;
            }
        } else {
            $data   = null;
            $message    =    trans('api.auth.invalid_credentials');
            $status_code   = 422;
        }

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function send_otp(Request $request)
    {

        $send_otp = $request->validate([
            'phone' => 'required',
            'password' => 'required',
            'user_type_id' => 'required'
        ]);
        $country = Country::where('phone_code', $request['phone_code'])->first();

        if (!$country) {
            $data   = null;
            $message    =    trans('api.auth.invalid_phone_code');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $user = User::where('phone', $request->phone)->where('user_type_id', $request->user_type_id)->where('country_id', $country->id)->first();
        if ($user) {
            $token = $this->generateNumericOTP(4);
            $newDateTime  = Carbon::now()->addMinutes(5)->toDateTimeString();
            $otp = Otps::where('phone', $request->phone)->where('user_type_id', $request->user_type_id)->orderBy('id', 'desc')->first();
            if (!$otp) {
                $data['password'] = Hash::make($request->password);
                $data['phone'] = $request->phone;
                $data['country_id'] = $country->id;
                $data['otp'] = $token;
                $data['otp_expire_on']  = $newDateTime;
                $data['user_id'] = $user->id;
                $data['user_type_id'] =  $user->user_type_id;
                Otps::create($data);
            } else {
                $data['password'] = Hash::make($request->password);
                $data['otp'] = $token;
                $data['otp_expire_on'] = $newDateTime;
                $otp->update($data);
            }
            $tophone = $request->phone;
            $body = "Your OTP to reset password is " . $token;


            $response = $this->sms_otp($tophone, $body);
            if ($response === false) {
                $data   = null;
                $message    =   trans('api.auth.sms_not_sent');
                $status_code   = 500;
            } else {
                $data   = null;
                $message    =   trans('api.auth.sms_sent');
                $status_code   = 200;
            }
        } else {
            $data   = null;
            $message    =   trans('api.auth.invalid_phone');
            $status_code   = 422;
        }

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function verify_register_otp(Request $request)
    {
        $verify_otp = $request->validate([
            'phone' => 'required',
            'otp'   => 'required',
            'user_type_id' => 'required'
        ]);
        $country =   Country::where('phone_code', $request['phone_code'])->first();
        if (!$country) {
            $data   = null;
            $message    =   trans('api.auth.invalid_phone_code');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $user = User::where('phone', $request->phone)->where('user_type_id', $request->user_type_id)->where('country_id', $country->id)->first();
        if ($user) {
            $otp = Otps::where('phone', $request->phone)->where('user_type_id', $request->user_type_id)->orderBy('id', 'desc')->first();
            if ($otp) {
                if ($request->otp == $otp->otp) {
                    $expire_date = strtotime($otp->otp_expire_on);
                    $current_time = strtotime("now");
                    if ($expire_date > $current_time) {
                        if (!empty($user->phone_verified_at)) {
                            $data   = null;
                            $message    =   trans('api.auth.otp_already_verified');
                            $status_code   = 200;
                        } else {
                            $user->phone_verified_at = Carbon::now()->toDateTimeString();
                            $user->is_active = 1;
                            $user->save();
                            if ($request->user_type_id == '3') {
                                $accessToken = $user->createToken('authToken')->accessToken;
                                $verification = true;
                                $id = $user->id;
                                $driver   = Driver::with('user')->where('user_id', $id)->first();
                                $trip_count =  Trip::where('driver_id', $id)->get()->count();
                                $driver->trip_count = $trip_count;
                                $rating_value = Rating::where('rated_for', $id)->avg('rating');
                                $driver->rating_value = $rating_value;
                                $balance = Wallet::where('user_id', $id)->first();
                                $driver->account_balance = $balance->amount;
                                $user_details = $this->formattedDriverData($driver);
                                $data   = ['user' => $user_details, 'access_token' => $accessToken, 'verification' => $verification];
                                //Make the user Active
                                $user->is_active = 1;
                            } else {
                                $user_details = $user;
                                $user_details['phone_code'] = $user->country->phone_code;
                                $data   =   ['user' => $user_details];
                                //Make the customer Active
                                $customer   = Customer::where('user_id', $user->id)->first();
                                $customer->is_active = 1;
                                $customer->save();
                            }
                            $message    =   trans('api.auth.otp_verified');
                            $status_code   = 200;
                        }
                    } else {
                        $data   = null;
                        $message    =   trans('api.auth.otp_expired');
                        $status_code   = 500;
                    }
                } else {
                    $data   = null;
                    $message    =   trans('api.auth.otp_not_match');
                    $status_code   = 500;
                }
            } else {
                $data   = null;
                $message    =   trans('api.auth.otp_not_generated');
                $status_code   = 500;
            }
        } else {
            $data   = null;
            $message    =   trans('api.auth.invalid_phone');
            $status_code   = 422;
        }
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }


    public function verify_otp(Request $request)
    {
        $verify_otp = $request->validate([
            'phone' => 'required',
            'otp'   => 'required',
            'user_type_id' => 'required'
        ]);
        $country =   Country::where('phone_code', $request['phone_code'])->first();
        if (!$country) {
            $data   = null;
            $message    =   trans('api.auth.invalid_phone_code');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $user = User::where('phone', $request->phone)->where('user_type_id', $request->user_type_id)->where('country_id', $country->id)->first();
        if ($user) {
            $otp = Otps::where('phone', $request->phone)->where('user_type_id', $request->user_type_id)->orderBy('id', 'desc')->first();
            if ($otp) {
                if ($request->otp == $otp->otp) {
                    $expire_date = strtotime($otp->otp_expire_on);
                    $current_time = strtotime("now");
                    if ($expire_date > $current_time) {
                        $user->update(['password' => $otp->password]);
                        $user->save();
                        $verification = !empty($user->phone_verified_at) ? true : false;
                        $data   = [
                            'user' => $user,
                            'phone_code' => $country->phone_code,
                            'access_token' => $user->createToken('authToken')->accessToken,
                            'verification' => $verification
                        ];
                        $message    =   trans('api.auth.otp_verified');
                        $status_code   = 200;
                    } else {
                        $data   = null;
                        $message    =   trans('api.auth.otp_expired');
                        $status_code   = 500;
                    }
                } else {
                    $data   = null;
                    $message    =   trans('api.auth.otp_not_match');
                    $status_code   = 500;
                }
            } else {
                $data   = null;
                $message    =   trans('api.auth.otp_not_generated');
                $status_code   = 500;
            }
        } else {
            $data   = null;
            $message    =   trans('api.auth.invalid_phone');
            $status_code   = 422;
        }
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function reset_password(Request $request)
    {
        $reset_password = $request->validate([
            'phone' => 'required',
            'password'   => 'required'
        ]);
        $country =   Country::where('phone_code', $request['phone_code'])->first();
        if (!$country) {
            $data   = null;
            $message    =   trans('api.auth.invalid_phone_code');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $user = User::where('phone', $request->phone)->where('user_type_id', $request->user_type_id)->where('country_id', $country->id)->first();
        if (!$user) {
            $data   = null;
            $message    =   trans('api.auth.invalid_credentials');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $user->update(['password' => Hash::make($request->password)]);
        $data   = null;
        $message    =   trans('api.auth.password_reset');
        $status_code   = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }
    public function update_email(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users|min:1|max:255',
        ];
        $validatedData = $request->all();
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.auth.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $user = User::findOrFail($request->id);
        $user->email_verified_at = null;
        $user->email = $request->email;
        $user->save();
        $data   = $user;
        $message    =   trans('api.auth.email_changed');
        $status_code   = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    function formattedDriverData($driver)
    {
        $country_id = $driver->user->country_id;
        $country =   Country::find($country_id);
        $user_details['id'] = $driver->id;
        $user_details['user_id'] = $driver->user_id;
        $user_details['name'] = $driver->user->name;
        $user_details['surname'] = $driver->user->surname;
        $user_details['email'] = $driver->user->email;
        $user_details['phone'] = $driver->user->phone;
        $user_details['zipcode'] = $driver->user->zipcode;
        $user_details['address'] = $driver->user->address;
        $user_details['country_id'] = $driver->user->country_id;
        $user_details['city_id'] = $driver->user->city_id;
        $user_details['gender'] = $driver->user->gender;
        $user_details['user_type_id'] = $driver->user->user_type_id;
        $user_details['profile_image'] = $driver->user->profile_image;
        $user_details['email_verified_at'] = $driver->user->email_verified_at;
        $user_details['phone_verified_at'] = $driver->user->phone_verified_at;
        $user_details['is_active'] = $driver->user->is_active;
        $user_details['created_at'] = $driver->user->created_at;
        $user_details['updated_at'] = $driver->user->updated_at;
        $user_details['language'] = $driver->user->language;
        $user_details['nationality_id'] = $driver->nationality_id;
        $user_details['dob'] = $driver->dob;
        $user_details['location'] = $driver->location;
        $user_details['is_available'] = $driver->is_available;
        $user_details['birth_certificate_file'] = $driver->birth_certificate_file;
        $user_details['passport_file'] = $driver->passport_file;
        $user_details['id_number'] = $driver->id_number;
        $user_details['id_expiry_date'] = $driver->id_expiry_date;
        $user_details['stc_phone'] = $driver->stc_phone;
        $user_details['smart_phone_type'] = $driver->smart_phone_type;
        $user_details['national_id'] = $driver->national_id;
        $user_details['license_no'] = $driver->license_no;
        $user_details['iqama_no'] = $driver->iqama_no;
        $user_details['national_file'] = $driver->national_file;
        $user_details['iqama_file'] = $driver->iqama_file;
        $user_details['license_file'] = $driver->license_file;
        $user_details['insurance_expiry_date'] = $driver->insurance_expiry_date;
        $user_details['insurance_file'] = $driver->insurance_file;
        $user_details['car_type_id'] = $driver->car_type_id;
        $user_details['is_safwa_driver'] = $driver->is_safwa_driver;
        $user_details['trip_count'] = $driver->trip_count;
        $user_details['account_balance'] = $driver->account_balance;
        $user_details['rating_value'] = $driver->rating_value;
        $user_details['country']['id'] = $country->id;
        $user_details['country']['name'] = $country->name;
        $user_details['country']['nationality'] = $country->nationality;
        $user_details['country']['code'] = $country->code;
        $user_details['country']['phone_code'] = $country->phone_code;

        return $user_details;
    }
    public function update_phone(Request $request)
    {
        $rules = [
            'phone' => 'required|unique:users|min:1|max:20',
        ];
        $validatedData = $request->all();
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.auth.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $user = User::findOrFail($request->id);
        $user->phone_verified_at = null;
        $user->phone = $request->phone;
        $user->save();
        $token = $this->generateNumericOTP(4);
        $newDateTime  = Carbon::now()->addMinutes(5)->toDateTimeString();
        //dd($validatedData);
        $data['country_id'] = $user['country_id'];
        $data['phone'] = $user['phone'];
        $data['otp'] = $token;
        $data['otp_expire_on']  = $newDateTime;
        $data['user_id'] = $user['id'];
        $data['user_type_id'] = $user['user_type_id'];
        Otps::create($data);
        $tophone = $user['phone'];
        $body = "Your OTP to verify mobile is " . $token;
        $response = $this->sms_otp($tophone, $body);
        $data   = $user;
        $message    =   trans('api.auth.phone_changed');
        $status_code   = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }
    // Function to generate OTP
    function generateNumericOTP($n)
    {

        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";

        // Iterate for n-times and pick a single character
        // from generator and append it to $result

        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        // Return result
        return $result;
    }

    static public function sms_otp($tophone, $body)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, TRUE);

        //$fields = json_encode(['userName' => 'Ghorm', 'numbers' => $tophone, 'userSender' => 'Darlana', 'apiKey' => '5b8c561edecb39e06ac46393164177ee', 'msg' => $body]);
        $fields = json_encode(['userName' => 'SAFWA GROUP', 'numbers' => $tophone, 'userSender' => 'SAFWA', 'apiKey' => '8234807079ff3f01e49943a52f1e2e96', 'msg' => $body]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
        ));

        $response = curl_exec($ch);

        return $response;
    }

    /**
     * Terminate user's session
     *
     * @return JSON
     */
    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->delete();
        $response = 'You have been successfully logged out!';
        return response()->json(['msg'=>$response,'error'=>0],200);
    }

    /**
     * list Online Users
     *
     * @return JSON
     */
    public function listOnlineUsers(Request $request){
        // $request->user()->id;
        return User::select()->where('is_online', '1')->get();
    }


    /**
     * Terminate user's session
     *
     * @return JSON
     */
    public function msgForm(Request $request) {
        return view('realTimeMessaging')->with([
            'token' => $request->token
        ]);
    }

    // For testing
    public function sendNotification(Request $request)
    {
        // $result = NC::sendNotification($request);
        // $user = Auth::user();
        return $this->sendPushNotification([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user_id,
        ]);
    }

    public static function sendPushNotification($data, $object = null)
    {
        //========================
        $fcm_token = UserDevice::select('device_token')->where('user_id', $data['user_id'])->get()->first()->device_token;

        if( !empty($fcm_token) ) {
            // echo($fcm_token);
            // return "fcm_token = $fcm_token";
            $adds = '';
            $payload = '{';
            if( !empty($object) ) {
                $payload .= '
                "direct_boot_ok" : true ,';
                $key = key($object);    $val = current($object);
                $adds = '"'.$key.'": ' .json_encode($val) .', ';
            }
            $payload .= '
                "priority":"high",
                "notification": {
                    "title": "'. $data['title'] .'",
                    "body" : "'. $data['body'] .'"
                },
                "data" : {
                    "title": "'. $data['title'] .'",
                    "body" : "'. $data['body'] .'",
                    "content_available" : true,
                    '.$adds.'
                    "priority":"high"
                }
                "to":"'. $fcm_token .'"
                }';

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: key='.env('FCM_APP_KEY')
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $result = json_decode($response, true);
            // return $result; // for testing

            // echo($result);
            // Result Example::
            // {
            //     "multicast_id": 3536260293962525005,
            //     "success": 1,
            //     "failure": 0,
            //     "canonical_ids": 0,
            //     "results": [
            //         {
            //             "message_id": "0:1622153169810847%388958c7388958c7"
            //         }
            //     ]
            // }

            if(isset($result) && $result['success'] == '1') {
                return true;
            } else {
                // echo $response;
                return false;
            }
        } else return false;

        // return $result;
    }


    function add_card_wallet(Request $request) {
        $customers = User::select()->whereIn('user_type_id', [4,3])->get();
        foreach ($customers as $user) {
            // $fifthpaymentOption_data['user_id'] = $user->id;
            // $fifthpaymentOption_data['payment_method_id'] = config('constants.Mada');
            // $fifthpaymentOption_data['payment_title'] = 'Mada';
            // $fifthpaymentOption_data['is_default'] = '0';
            // UserPaymentOption::create($fifthpaymentOption_data);

            $sixthpaymentOption_data['user_id'] = $user->id;
            $sixthpaymentOption_data['payment_method_id'] = config('constants.Mada');
            $sixthpaymentOption_data['payment_title'] = 'Mada';
            $sixthpaymentOption_data['is_default'] = '0';
            UserPaymentOption::create($sixthpaymentOption_data);

            $firstpaymentOption_data['user_id'] = $user->id;
            $firstpaymentOption_data['payment_method_id'] = config('constants.Cash');
            $firstpaymentOption_data['payment_title'] = 'Cash';
            $firstpaymentOption_data['is_default'] = '1';
            UserPaymentOption::create($firstpaymentOption_data);

            $secondpaymentOption_data['user_id'] = $user->id;
            $secondpaymentOption_data['payment_method_id'] = config('constants.Wallet');
            $secondpaymentOption_data['payment_title'] = 'Wallet';
            $secondpaymentOption_data['is_default'] = '0';
            userPaymentOption::create($secondpaymentOption_data);

            $fifthpaymentOption_data['user_id'] = $user->id;
            $fifthpaymentOption_data['payment_method_id'] = config('constants.Card');
            $fifthpaymentOption_data['payment_title'] = 'Credit/Debit Card';
            $fifthpaymentOption_data['is_default'] = '0';
            UserPaymentOption::create($fifthpaymentOption_data);

        }

        // return $drivers;
        return "Your Customer list (".count($customers).") is added Card Wallet.";
    }


}
