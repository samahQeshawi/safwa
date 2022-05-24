<?php

namespace App\Http\Controllers\Api;

use App\Events\DriverHasAcceptedTheTripEvent;
use App\Events\DriverHasCollectedTheMoneyEvent;
use App\Events\UpdateDriverLocationEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriversResource;
use App\Listeners\SendNotificationToTheCustomerListener;
use App\Models\Car;
use App\Models\Driver;
use App\Models\User;
use App\Models\Trip;
use App\Models\Rating;
use App\Models\Otps;
use App\Models\Country;
use App\Models\DriverAvailableLog;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TripRequestLog;
use App\Models\TripRoute;
use App\Models\UserPaymentOption;
use App\Models\PaymentMethod;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Str;
use App\Models\TripTracking;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers   = Driver::all();
        $data    = [
            'drivers' => DriversResource::collection($drivers)
        ];
        $message = trans('api.driver.retrived_successfully');
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Register Driver.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $rules = [
            'name' => 'required|max:55',
            'email' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    $query->where('user_type_id', 3);
                }),
            ],
            'country_id' => 'required',
            'city_id' => 'required',
            'nationality_id' => 'required',
            'phone' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    $query->where('user_type_id', 3);
                }),
            ],
            'password' => 'required',
            'birth_certificate_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'passport_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'insurance_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'national_id' => 'required',
            'national_file' => 'required|mimes:jpg,jpeg,png|max:5120',
            'license_file' => 'required|mimes:jpg,jpeg,png|max:5120',
        ];
        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = $validatedData;
            $message    =   trans('api.driver.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $user_type_id =  3;
        $validatedData['password'] = Hash::make($request->password);
        $validatedData['socket_token'] = Str::random(50);
        $validatedData['user_type_id'] = $user_type_id;
        $driverData['nationality_id'] = $request->nationality_id;
        $driverData['national_id'] = $request->national_id;
        unset($validatedData['nationality_id']);
        $user = User::create($validatedData);
        $newDriver = User::where('phone', $validatedData['phone'])->where('user_type_id', $user_type_id)->where('country_id', $validatedData['country_id'])->first()->toArray();
        if ($request->hasFile('birth_certificate_file')) {

            $birth_file_path = $request->file('birth_certificate_file')->store('drivers/birth_certificate');
            $driver['birth_certificate_file'] =  $birth_file_path;
        }
        if ($request->hasFile('passport_file')) {

            $passport_file_path = $request->file('passport_file')->store('drivers/passport');
            $driver['passport_file'] =  $passport_file_path;
        }
        if ($request->hasFile('insurance_file')) {

            $insurance_file_path = $request->file('insurance_file')->store('drivers/passport');
            $driver['insurance_file'] =  $insurance_file_path;
        }
        if ($request->hasFile('national_file')) {

            $national_file_path = $request->file('national_file')->store('drivers/national');
            $driver['national_file'] =  $national_file_path;
        }
        if ($request->hasFile('license_file')) {

            $license_file_path = $request->file('license_file')->store('drivers/license');
            $driver['license_file'] =  $license_file_path;
        }
        $driver['user_id'] = $newDriver['id'];
        $driver['nationality_id'] = $driverData['nationality_id'];
        $driver['national_id'] = $driverData['national_id'];
        Driver::create($driver); //create customer
        $wallet_data['user_id'] = $newDriver['id'];
        $wallet_data['amount'] = 0;
        $wallet_data['user_type'] = '3';
        $wallet_data['is_active'] = '1';
        Wallet::create($wallet_data);
        $firstpaymentOption_data['user_id'] = $newDriver['id'];
        $firstpaymentOption_data['payment_method_id'] = config('constants.Cash');
        $firstpaymentOption_data['payment_title'] = 'Cash';
        $firstpaymentOption_data['is_default'] = '1';
        UserPaymentOption::create($firstpaymentOption_data);
        $secondpaymentOption_data['user_id'] = $newDriver['id'];
        $secondpaymentOption_data['payment_method_id'] = config('constants.Wallet');
        $secondpaymentOption_data['payment_title'] = 'Wallet';
        $secondpaymentOption_data['is_default'] = '0';
        UserPaymentOption::create($secondpaymentOption_data);
        $token = $this->generateNumericOTP(4);
        $newDateTime  = Carbon::now()->addMinutes(5)->toDateTimeString();
        //dd($validatedData);
        $data['country_id'] = $validatedData['country_id'];
        $data['phone'] = $newDriver['phone'];
        $data['otp'] = $token;
        $data['otp_expire_on']  = $newDateTime;
        $data['user_id'] = $newDriver['id'];
        $data['user_type_id'] =  $user_type_id;
        Otps::create($data);
        $tophone = $newDriver['phone'];
        $body = "Your OTP to verify mobile is " . $token;
        $response = $this->sms_otp($tophone, $body);
        // $accessToken = $user->createToken('authToken')->accessToken;
        $response = true;
        if ($response === false) {
            $data   = $newDriver;
            $message    =   trans('api.driver.register_not_successful');
            $status_code   = 500;
        } else {
            $id = $newDriver['id'];
            $driver   = Driver::with('user')->where('user_id', $id)->first();
            $trip_count =  Trip::where('driver_id', $id)->get()->count();
            $driver->trip_count = $trip_count;
            $rating_value = Rating::where('rated_for', $id)->avg('rating');
            $driver->rating_value = $rating_value;
            $balance = Wallet::where('user_id', $id)->first();
            $driver->account_balance = ($balance) ? $balance->amount : 0.00;
            $user_details = $this->formattedDriverData($driver);
            $data   = ['user' => $user_details, 'access_token' => null, 'verification' => false];
            //$data   = $newDriver;
            $message    =  trans('api.driver.register_successful');
            $status_code   = 200;
        }
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
    }
    /**
     * Login Driver.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $loginData = $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);
        $user_type_id = 3;
        $loginData['user_type_id'] = $user_type_id; //Restrict login to only user type 4, Customers
        //$loginData['country.phone_code'] = '+966'; //Restrict login to only user type 3, Drivers

        $country =   Country::where('phone_code', $request['phone_code'])->first();
        if (!$country) {
            $data   = null;
            $message    =   trans('api.driver.invalid_phone_code');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $loginData['country_id'] = $country->id;

        if (!auth()->attempt($loginData)) {

            $data   = null;
            $message    =    trans('api.driver.invalid_credentials');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $verification = !empty(auth()->user()->phone_verified_at) ? true : false;

        if (!$verification) {
            $otp = Otps::where('phone', $loginData['phone'])->where('user_type_id', $user_type_id)->orderBy('id', 'desc')->first();
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
                $data['user_type_id'] =  $user_type_id;
                Otps::create($data);
            }
            $tophone = $loginData['phone'];
            $body = "Your OTP to reset password is " . $token;
            $response = $this->sms_otp($tophone, $body);
            if ($response === false) {
                $data   = null;
                $message    =   trans('api.driver.sms_not_sent');
                $status_code   = 500;
            } else {
                $id = auth()->user()->id;
                $driver   = Driver::with('user')->where('user_id', $id)->first();
                $trip_count =  Trip::where('driver_id', $id)->get()->count();
                $driver->trip_count = $trip_count;
                $rating_value = Rating::where('rated_for', $id)->avg('rating');
                $driver->rating_value = $rating_value;
                $balance = Wallet::where('user_id', $id)->first();
                $driver->account_balance = ($balance) ? $balance->amount : 0.00;
                $user_details = $this->formattedDriverData($driver);
                $data   = ['user' => $user_details, 'access_token' => null, 'verification' => $verification];
                $message    =   trans('api.driver.sms_sent');
                $status_code   = 200;
            }
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        $checkActive    =   User::where('phone', $request->phone)->where('user_type_id', 3);
        $driverObj  =   $checkActive->first();

        // return response($driverObj);
        if ($driverObj) {
            if ($driverObj->is_active == 'Inactive') {
                $data   = null;
                $message    =   trans('api.driver.inactive');
                $status_code   = 422;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
        } else {
            $data   = null;
            $message    =    trans('api.driver.invalid_credentials');
            $status_code   = 422;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }


        $id = auth()->user()->id;
        $driver   = Driver::with('user')->where('user_id', $id)->first();
        $trip_count =  Trip::where('driver_id', $id)->get()->count();
        $driver->trip_count = $trip_count;
        $rating_value = Rating::where('rated_for', $id)->avg('rating');
        $driver->rating_value = $rating_value;
        $balance = Wallet::where('user_id', $id)->first();
        $driver->account_balance = ($balance) ? $balance->amount : 0.00;
        $user_details = $this->formattedDriverData($driver);
        $data   = ['user' => $user_details, 'access_token' => $accessToken, 'verification' => $verification];
        $message    =   trans('api.driver.loged_in');
        $status_code   = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }
    /**
     * offline or online availability.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_available_status(Request $request)
    {
        $rules = [
            'is_available' => 'required|boolean',
        ];
        $validatedData = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.driver.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $driver   = Driver::with('user')->where('user_id', $user_id)->first();
        if ($driver) {
            $message    =   trans('api.driver.updated_availability');
            if ($driver->is_available != $request->is_available) {
                $driver->is_available = $request->is_available;
                $driver->save();
                DriverAvailableLog::create([
                    'user_id' => $user_id,
                    'is_available' => $request->is_available,
                    'updated_on'   => Carbon::now()->toDateTimeString(),
                ]);
            } else {
                if ($driver->is_available)
                    $message    =   trans('api.driver.already_online');
                else
                    $message    =   trans('api.driver.already_offline');
            }
            $trip_count =  Trip::where('driver_id', $user_id)->get()->count();
            $driver->trip_count = $trip_count;
            $rating_value = Rating::where('rated_for', $user_id)->avg('rating');
            $driver->rating_value = $rating_value;
            $balance = Wallet::where('user_id', $user_id)->first();
            $driver->account_balance = ($balance) ? $balance->amount : 0.00;
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $verification = !empty(auth()->user()->phone_verified_at) ? true : false;
            $user_details = $this->formattedDriverData($driver);
            $data   = ['user' => $user_details, 'access_token' => $accessToken, 'verification' => $verification];
            $status_code   = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        } else {
            $data   = null;
            $message    =   trans('api.driver.failed_updation_availability');
            $status_code   = 500;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }
    public function customer_ratings(Request $request)
    {
        $rules = [
            'trip_id' => 'required',
            'rating' => 'required',
        ];

        $validatedData = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.driver.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $trip = Trip::where('driver_id', $user_id)->whereBetween('status', [8, 9])->where('id', $request->trip_id)->orderBy('id', 'desc')->first();
        if ($trip) {
            $check_rated = Rating::where('trip_id', $trip->id)->where('rated_for', $trip->customer_id)->first();
            if ($check_rated) {
                $check_rated->rating = $request->rating;
                $check_rated->done_by  = auth()->user()->id;
                $check_rated->save();
                $message    =   trans('api.customer.already_rated');
                $data   = $check_rated;
                $status_code   = 422;
            } else {
                $data['trip_id']  = $trip->id;
                $data['rated_by']  = $trip->driver_id;
                $data['rated_for']  = $trip->customer_id;
                $data['user_type']  = 'customer';
                $data['rating_comment']  = isset($request->rating_comment) ? $request->rating_comment : '';
                $data['rating']  = $request->rating;
                $data['done_by']  = auth()->user()->id;
                $rating             =    Rating::create($data);
                $message    =   trans('api.customer.rating_saved');
                $data   = $rating;
                $status_code   = 200;
            }
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        } else {
            $data   = null;
            $message    =   trans('api.driver.invalid_trip');
            $status_code   = 500;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }
    public function driver_ratings(Request $request)
    {
        $rules = [
            'trip_id' => 'required',
            'rating' => 'required',
        ];

        $validatedData = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.driver.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $trip = Trip::where('customer_id', $user_id)->whereBetween('status', [8, 9])->where('id', $request->trip_id)->orderBy('id', 'desc')->first();
        if ($trip) {
            $check_rated = Rating::where('trip_id', $trip->id)->where('rated_for', $trip->driver_id)->first();
            if ($check_rated) {
                $check_rated->rating = $request->rating;
                $check_rated->done_by  = auth()->user()->id;
                $check_rated->save();
                $message    =   trans('api.driver.already_rated');
                $data   = $check_rated;
                $status_code   = 422;
            } else {
                $data['trip_id']  = $trip->id;
                $data['rated_by']  = $trip->customer_id;
                $data['rated_for']  = $trip->driver_id;
                $data['user_type']  = 'driver';
                $data['rating_comment']  = isset($request->rating_comment) ? $request->rating_comment : '';
                $data['rating']  = $request->rating;
                $data['done_by']  = auth()->user()->id;
                $rating             =    Rating::create($data);
                $message    =   trans('api.driver.rating_saved');
                $data   = $rating;
                $status_code   = 200;
            }

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        } else {
            $data   = null;
            $message    =   trans('api.driver.invalid_trip');
            $status_code   = 500;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }
    public function collect_money(Request $request)
    {
        $rules = [
            'trip_id' => 'required',
            'amount_collected' => 'required',
        ];
        $validatedData = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.driver.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $commission = 10;
        $trip_commission = Setting::find(5);
        if ($trip_commission) {
            $commission = $trip_commission->value;
        }
        $trip = Trip::where('id', $request->trip_id)->first();
        $trip_details = $this->formatTripDetailsWithKey($trip);
        if ($trip && $trip->status == 8) { // Update the status to 9 for all the trip if it has completed
            //Change the Trip Status to 9
            //Update the trip as payment collected

            $trip->status = '9';
            if($trip->payment_method_id){
                $paymentMethod = PaymentMethod::findOrFail($trip->payment_method_id);
                $trip->payment_method = $paymentMethod->name;
                $trip->payment_method_id = $paymentMethod->id;
            } else {
                $trip->payment_method = 'Cash';
                $trip->payment_method_id = 1;

            }
            $trip->payment_status = 1;
            $trip->collected_money = $request->amount_collected;
            $trip->save();
            $amount_to_customer_wallet = $request->amount_collected - $trip->final_amount;
            $commission_amount  =   $commission * $trip->final_amount * .01;


            //Driver wallet
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
            $data['amount'] = $amount_to_driver_wallet;
            $data['done_by']  = auth()->user()->id;
            $data['sender_id'] = 0;
            $data['receiver_id'] = $trip->driver_id;
            $data['trip_id'] = $trip->id;
            $data['note'] = trans('api.driver.money_adjusted');
            Transaction::create($data);
            //Driver wallet

            //Customer wallet
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
            $data['amount'] = $amount_to_customer_wallet;
            $data['done_by']  = auth()->user()->id;
            $data['sender_id'] = 0;
            $data['receiver_id'] = $trip->customer_id;
            $data['trip_id'] = $trip->id;
            $data['note'] = trans('api.driver.money_adjusted');
            Transaction::create($data);
            //Customer wallet

            $trip_details = $this->formatTripDetailsWithKey($trip);
            //Call the DriverHasCollectedTheMoneyEvent with this new trip
            event(new DriverHasCollectedTheMoneyEvent($trip, $trip_details));

            $data   = $trip_details;
            $message    =   trans('api.driver.money_added_to_wallet');
            $status_code   = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);

            /*} else if ($balance == 0) {
                $device_token_first = DB::table('user_devices')->where('user_id', $trip->customer_id)->pluck('device_token')->toArray();
                $device_token = $device_token_first[0];
                $title = "Money Collected";
                $body = "Nothing to adjust";
                $this->send_push_notification($device_token, $title, $body);
                $data   = $trip;
                $message    =   trans('api.driver.money_collected');
                $status_code   = 200;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            } else {
                $data   = $trip;
                $message    =   trans('api.driver.nothing_to_adjust');
                $status_code   = 200;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }*/
        } else if ($trip->status < 8) {
            $data   = $trip_details;
            $message    =   trans('api.driver.invalid_money_collection_request');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        } else if ($trip->status == 9) {
            $data   = $trip_details;
            $message    =   trans('api.driver.already_collected');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        } else {
            $data   = null;
            $message    =   trans('api.driver.invalid_trip');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }
    public function update_location(Request $request)
    {
        $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
        ];
        $validatedData = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.driver.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $location = new Point($request->latitude, $request->longitude);
        $driver   = User::with('driver')->find($user_id);
        if ($driver) {
            $driver->driver->location = $location;
            $driver->driver->lat = $request->latitude;
            $driver->driver->lng = $request->longitude;
            $driver->driver->save();

            //If driver is en route of a trip
            $trip_id =  $request->trip_id ?? 0;
            if ($trip_id){
                TripRoute::create([
                    'trip_id' =>$trip_id,
                    'lat' => $request->latitude,
                    'lng' => $request->longitude
                    ]);
            }
            //Fire the event to broadcast the location update
            UpdateDriverLocationEvent::dispatch($driver);
           // event(new UpdateDriverLocationEvent($driver));
            $data   = $driver;
            $message    =   trans('api.driver.updated_location');
            $status_code   = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        } else {
            $data   = null;
            $message    =   trans('api.driver.failed_location_update');
            $status_code   = 500;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }
    /**
     * Trip Current Job .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCurrentJob(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $driver   = User::with('driver')->find($user_id);
        if ($driver->user_type_id == '3') {
            $trip = Trip::where('driver_id', $user_id)->whereBetween('status', [4, 8])->orderBy('id', 'desc')->first();
            if ($trip) {
                $data = $trip;
                $message    =   trans('api.driver.trip_in_progress');
                $status_code   = 200;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            } else {
                // $trip = Trip::whereBetween('status', [1, 2])->OrderByDistance('from_location', $driver->driver->location)->get();
                $trip = Trip::whereBetween('status', [1, 2])->Distance('from_location', $driver->driver->location, 0.23)->get();
                $data   = $trip;
                $message    =   trans('api.driver.trip_near_by');
                $status_code   = 200;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
        } else {
            $data   = null;
            $message    =   trans('api.driver.invalid_driver');
            $status_code   = 500;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
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
        $rating       =   $ratingObj->avg('rating') ? $ratingObj->avg('rating') : 5.0; //Average of the collection
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
        if (!$total) return 100.00;
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
        if (!$total) return 0.00;
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


    public function accept_job(Request $request)
    {
        $rules = [
            'trip_id' => 'required',
        ];
        $validatedData = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.driver.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $trip = null;
        //$trip = Trip::where('driver_id',$user_id)->whereBetween('status', [1, 2])->where('id', $request->trip_id)->orderBy('id', 'desc')->first();
        //Check the trip for status 'New' or 'Pending'
        $query  = Trip::whereBetween('status', [1, 2])->where('id', $request->trip_id)->orderBy('id', 'desc');
        //dd($query->toSql());
        $trip = $query->first();
        //dd($trip);
        if ($trip) {
            if (!empty($trip->driver_id)) {
                $data   = null;
                $message    =   trans('api.driver.accepted_driver');
                $status_code   = 500;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }

            $trip->driver_id = $user_id; //assign the driver to the trip
            $trip->car_id   =   Car::where('user_id', $user_id)->pluck('id')->first(); //assign the car to the trip//the drivers car
            $trip->status = '4';
            $trip->save();

            //Update the Log for those accepted
            TripRequestLog::updateOrCreate(
                ['user_id' => $user_id, 'trip_id' => $trip->id],
                ['status' => 1]
            );

            //Update the Location for Driver
            $cuurLoc = Driver::select('id','lat','lng')->where('user_id', $user_id)->get()->first();
            // return $cuurLoc;

            if ($cuurLoc){
                TripTracking::create([
                    'trip_id' => $trip->id,
                    'lat' => $cuurLoc->lat,
                    'lng' => $cuurLoc->lng
                ]);
            }

            // Send push notification
            // $device_token_first = DB::table('user_devices')->where('user_id', $trip->customer_id)->pluck('device_token')->toArray();
            // $device_token = $device_token_first[0];
            // $title = "Money Collected";
            // $body = "Nothing to adjust";
            // $this->send_push_notification($device_token, $title, $body);

            $trip_id =   $trip->id;

            $updated_trip = Trip::with('car', 'service', 'paymentMethod', 'customer')->where('id', $trip_id)->first();

            //Format Trip Details
            $trip_details = $this->formatTripDetailsWithKey($updated_trip);

            //Call the DriverHasAcceptedTheTripEvent with the trip details
            event(new DriverHasAcceptedTheTripEvent($updated_trip, $trip_details));

            $data   = $trip_details;
            //$message    =   trans('api.driver.trip_status_changed');
            $message    =   'The trip has accepeted by the driver';
            $status_code   = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        } else {
            $data   = null;
            //$message    =   trans('api.driver.invalid_driver');
            $message    =   'The trip cannot be accepted, either someone else has already accepted or the trip has expired.';
            $status_code   = 500;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }
    public function cancelled_job(Request $request)
    {
        $rules = [
            'trip_id' => 'required',
            'trip_status' => 'required',
        ];
        $validatedData = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.driver.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        if ($request->trip_status == '10' ||  $request->trip_status == '11') {
            $trip = null;
            $trip = Trip::where('driver_id', $user_id)->whereBetween('status', [4, 5])->where('id', $request->trip_id)->orderBy('id', 'desc')->first();
            if ($trip) {
                $trip->status = $request->trip_status;
                $trip->save();
                $data   = $trip;
                $message    =   trans('api.driver.trip_status_changed');
                $status_code   = 200;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            } else {
                $data   = null;
                $message    =   trans('api.driver.invalid_status');
                $status_code   = 500;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
        } else {
            $data   = null;
            $message    =   trans('api.driver.invalid_cancelled_status');
            $status_code   = 500;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }
    public function update_trip_status(Request $request)
    {
        $rules = [
            'trip_id' => 'required',
            'trip_status' => 'required',
        ];
        $validatedData = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.driver.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $trip = Trip::where('driver_id', $user_id)->where('id', $request->trip_id)->orderBy('id', 'desc')->first();

        if ($trip) {
            $trip->status = $request->trip_status;
            $trip->save();
            $data   = $trip;
            $message    =   trans('api.driver.trip_status_changed');
            $status_code   = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        } else {
            $data   = null;
            $message    =   trans('api.driver.invalid_driver');
            $status_code   = 500;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
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
        $message    =   trans('api.common.unauthorized_access');
        $status_code   = 422;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $driver   = Driver::with('user')->where('user_id', $id)->first();
        $trip_count =  Trip::where('driver_id', $id)->get()->count();
        $driver->trip_count = $trip_count;
        $rating_value = Rating::where('rated_for', $id)->avg('rating');
        $driver->rating_value = $rating_value;
        $balance = Wallet::where('user_id', $id)->first();
        $driver->account_balance = ($balance) ? $balance->amount : 0.00;
        if ($driver) {
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $verification = !empty(auth()->user()->phone_verified_at) ? true : false;
            $user_details = $this->formattedDriverData($driver);
            $data   = ['user' => $user_details, 'access_token' => $accessToken, 'verification' => $verification];
            //$data   = $driver;
            $message    =   trans('api.driver.show_successfully');
            $status_code   = 200;
        } else {
            $data = null;
            $message    =   trans('api.common.unauthorized_access');
            $status_code   = 422;
        }

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }
    /**
     * Get the driver details.
     *
     * @return \Illuminate\Http\Response
     */
    public function driver_details()
    {
        $id = auth()->user()->id;
        $driver   = Driver::with('user')->where('user_id', $id)->first();
        $trip_count =  Trip::where('driver_id', $id)->get()->count();
        $driver->trip_count = $trip_count;
        $rating_value = Rating::where('rated_for', $id)->avg('rating');
        $driver->rating_value = $rating_value;
        $balance = Wallet::where('user_id', $id)->first();
        $driver->account_balance = ($balance) ? $balance->amount : 0.00;
        if ($driver) {
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $verification = !empty(auth()->user()->phone_verified_at) ? true : false;
            $user_details = $this->formattedDriverData($driver);
            $data   = ['user' => $user_details, 'access_token' => $accessToken, 'verification' => $verification];
            //$data   = $driver;
            $message    =   trans('api.driver.show_successfully');
            $status_code   = 200;
        } else {
            $data = null;
            $message    =   trans('api.common.unauthorized_access');
            $status_code   = 422;
        }

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {

        try {
            $validator = $this->getValidator($request, $id);
            if ($validator->fails()) {
                $data = $validator->failed();;
                $message    =   trans('api.driver.validation_fail');
                $status_code = 500;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
            $user   =   User::findOrFail($id);



            if ($request->hasFile('profile_image')) {

                $profile_image_path = $request->file('profile_image')->store('drivers/profile');
                $user_data['profile_image'] =  $profile_image_path;
            } else {
                $user_data['profile_image'] =  $user->profile_image;
            }
            $data_update = $request->all();

            $user_data['name'] = $data_update['name'];
            $user_data['surname'] = $data_update['surname'];
            //$user_data['email'] = $data_update['email'];
            $user_data['gender'] = $data_update['gender'];
            //$user_data['phone'] = $data_update['phone'];

            $user->update($user_data);
            $driver = Driver::where('user_id', $id)->first();
            if ($request->hasFile('birth_certificate_file')) {

                $birth_file_path = $request->file('birth_certificate_file')->store('drivers/birth_certificate');
                $driver_data['birth_certificate_file'] =  $birth_file_path;
            } else {
                $driver_data['birth_certificate_file'] =  $driver->birth_certificate_file;
            }
            if ($request->hasFile('passport_file')) {

                $passport_file_path = $request->file('passport_file')->store('drivers/passport');
                $driver_data['passport_file'] =  $passport_file_path;
            } else {
                $driver_data['passport_file'] =  $driver->passport_file;
            }
            if ($request->hasFile('insurance_file')) {

                $insurance_file_path = $request->file('insurance_file')->store('drivers/passport');
                $driver_data['insurance_file'] =  $insurance_file_path;
            } else {
                $driver_data['insurance_file'] =  $driver->insurance_file;
            }
            if ($request->hasFile('national_file')) {

                $national_file_path = $request->file('national_file')->store('drivers/national');
                $driver_data['national_file'] =  $national_file_path;
            } else {
                $driver_data['national_file'] =  $driver->national_file;
            }
            if ($request->hasFile('license_file')) {


                $license_file_path = $request->file('license_file')->store('drivers/license');
                $driver_data['license_file'] =  $license_file_path;
            } else {
                $driver_data['license_file'] = $driver->license_file;
            }
            //$data['car_type_id'] =  $data['car_type'];
            $driver_data['is_safwa_driver'] = $request->has('is_safwa_driver');
            $driver_data['is_active'] = $request->has('is_active');
            $driver_data['dob'] =   $data_update['dob'];
            //$driver_data['is_safwa_driver'] = $data['is_safwa_driver'];
            //$driver_data['is_active'] = $data['is_active'];
            //$driver_data['car_type_id'] = $data['car_type_id'];
            //$driver_data['profile_image'] = $data['profile_image'];
            if ($request->has('national_id')) {
                $driver_data['national_id'] = $data_update['national_id'];
            }
            if ($request->has('nationality_id')) {
                $driver_data['nationality_id'] = $data_update['nationality_id'];
            }
            if ($request->hasFile('license_file')) {
                $license_file_path = $request->file('license_file')->store('drivers/license');
                $driver_data['license_file'] =  $license_file_path;
            } else {
                $driver_data['license_file'] = $driver->license_file;
            }
            $driver->update($driver_data);
            $driver_new  = Driver::with('user')->where('user_id', $id)->first();
            $trip_count =  Trip::where('driver_id', $id)->get()->count();
            $driver_new->trip_count = $trip_count;
            $rating_value = Rating::where('rated_for', $id)->avg('rating');
            $driver_new->rating_value = $rating_value;
            $balance = Wallet::where('user_id', $id)->first();
            $driver_new->account_balance =  ($balance) ? $balance->amount : 0.00;
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $verification = !empty(auth()->user()->phone_verified_at) ? true : false;
            $user_details = $this->formattedDriverData($driver_new);
            //$rating_comments =  Rating::where('rated_for', $id)->pluck('rating_comment', 'id');
            //$dt     =  Carbon::now();
            //$years_passed = number_format($dt->floatDiffInRealYears($driver->created_at), 1);
            $data   = ['user' => $user_details, 'access_token' => $accessToken, 'verification' => $verification];
            $message    =   trans('api.driver.driver_update');
            $status_code = 200;
        } catch (Exception $exception) {
            $data   = null;
            $message    =   trans('api.common.unauthorized_access');
            $status_code   = 422;
        }

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        $data   = null;
        $message    =   trans('api.common.unauthorized_access');
        $status_code   = 422;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function update_driver_details(Request $request)
    {
        try {
            $id = auth()->user()->id;
            $validator = $this->getValidator($request, $id);
            if ($validator->fails()) {
                $data = $validator->failed();;
                $message    =   trans('api.driver.validation_fail');
                $status_code = 500;
                return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            }
            $user   =   User::findOrFail($id);



            if ($request->hasFile('profile_image')) {

                $profile_image_path = $request->file('profile_image')->store('drivers/profile');
                $user_data['profile_image'] =  $profile_image_path;
            } else {
                $user_data['profile_image'] =  $user->profile_image;
            }
            $data_update = $request->all();

            $user_data['name'] = $data_update['name'];
            //$user_data['email'] = $data_update['email'];
            $user_data['gender'] = $data_update['gender'];
            //$user_data['phone'] = $data_update['phone'];
            $user_data['country_id'] = $data_update['country_id'];
            $user_data['city_id'] = $data_update['city_id'];

            $user->update($user_data);
            $driver = Driver::where('user_id', $id)->first();
            if ($request->hasFile('birth_certificate_file')) {

                $birth_file_path = $request->file('birth_certificate_file')->store('drivers/birth_certificate');
                $driver_data['birth_certificate_file'] =  $birth_file_path;
            } else {
                $driver_data['birth_certificate_file'] =  $driver->birth_certificate_file;
            }
            if ($request->hasFile('passport_file')) {

                $passport_file_path = $request->file('passport_file')->store('drivers/passport');
                $driver_data['passport_file'] =  $passport_file_path;
            } else {
                $driver_data['passport_file'] =  $driver->passport_file;
            }
            if ($request->hasFile('insurance_file')) {

                $insurance_file_path = $request->file('insurance_file')->store('drivers/passport');
                $driver_data['insurance_file'] =  $insurance_file_path;
            } else {
                $driver_data['insurance_file'] =  $driver->insurance_file;
            }
            if ($request->hasFile('national_file')) {

                $national_file_path = $request->file('national_file')->store('drivers/national');
                $driver_data['national_file'] =  $national_file_path;
            } else {
                $driver_data['national_file'] =  $driver->national_file;
            }
            if ($request->hasFile('license_file')) {


                $license_file_path = $request->file('license_file')->store('drivers/license');
                $driver_data['license_file'] =  $license_file_path;
            } else {
                $driver_data['license_file'] = $driver->license_file;
            }
            //$data['car_type_id'] =  $data['car_type'];
            $driver_data['is_safwa_driver'] = $request->has('is_safwa_driver');
            $driver_data['is_active'] = $request->has('is_active');
            $driver_data['dob'] =   $data_update['dob'];
            //$driver_data['is_safwa_driver'] = $data['is_safwa_driver'];
            //$driver_data['is_active'] = $data['is_active'];
            //$driver_data['car_type_id'] = $data['car_type_id'];
            //$driver_data['profile_image'] = $data['profile_image'];
            if ($request->has('national_id')) {
                $driver_data['national_id'] = $data_update['national_id'];
            }
            if ($request->has('nationality_id')) {
                $driver_data['nationality_id'] = $data_update['nationality_id'];
            }
            if ($request->hasFile('license_file')) {
                $license_file_path = $request->file('license_file')->store('drivers/license');
                $driver_data['license_file'] =  $license_file_path;
            } else {
                $driver_data['license_file'] = $driver->license_file;
            }
            $driver->update($driver_data);
            $driver_new  = Driver::with('user')->where('user_id', $id)->first();
            $trip_count =  Trip::where('driver_id', $id)->get()->count();
            $driver_new->trip_count = $trip_count;
            $rating_value = Rating::where('rated_for', $id)->avg('rating');
            $driver_new->rating_value = $rating_value;
            $balance = Wallet::where('user_id', $id)->first();
            $driver_new->account_balance = ($balance) ? $balance->amount : 0.00;
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $verification = !empty(auth()->user()->phone_verified_at) ? true : false;
            $user_details = $this->formattedDriverData($driver_new);
            //$rating_comments =  Rating::where('rated_for', $id)->pluck('rating_comment', 'id');
            //$dt     =  Carbon::now();
            //$years_passed = number_format($dt->floatDiffInRealYears($driver->created_at), 1);
            $data   = ['user' => $user_details, 'access_token' => $accessToken, 'verification' => $verification];
            $message    =   trans('api.driver.driver_update');
            $status_code = 200;
        } catch (Exception $exception) {
            $data   = null;
            $message    =   trans('api.common.unauthorized_access');
            $status_code   = 422;
        }

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        $data   = null;
        $message    =   trans('api.common.unauthorized_access');
        $status_code   = 422;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        $data   = null;
        $message    =  trans('api.common.unauthorized_access');
        $status_code   = 422;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Gets a new validator instance with the defined rules.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Support\Facades\Validator
     */
    protected function getValidator(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|min:1|max:255',
            'surname' => 'nullable|string|min:1|max:255',
            //'email' => 'required|email|unique:users|min:1|max:255',
            'password' => 'nullable|string|min:1|max:255',
            //'phone' => 'required|unique:users|min:1|max:20',
            'gender' => 'nullable',
            'country_id' => 'nullable',
            //'country_code' => 'required',
            'nationality_id' => 'nullable',
            'city_id' => 'nullable',
            'dob' => 'nullable',
            'is_active' => 'boolean|nullable',
            'is_safwa_driver' => 'boolean|nullable',
            'birth_certificate_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'passport_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'insurance_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'national_id' => 'nullable',
            'national_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'license_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
        ];
        return Validator::make($request->all(), $rules);
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
        $user_details['socket_token'] = $driver->user->socket_token;
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

        $user_details['rating'] = isset($driver->user_id) ? $this->userRating($driver->user_id)  : '';
        $user_details['acceptance'] = isset($driver->user_id) ? $this->driverAcceptance($driver->user_id)  : '';
        $user_details['cancellation'] = isset($driver->user_id) ? $this->driverCancellation($driver->user_id)  : '';

        return $user_details;
    }
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
    function sms_otp($tophone, $body)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, TRUE);

        //$fields = json_encode(['userName' => 'Ghorm', 'numbers' => $tophone, 'userSender' => 'Darlana', 'apiKey' => '5b8c561edecb39e06ac46393164177ee', 'msg' => $body]);
        $fields = json_encode(['userName' => 'SAFWA GROUP', 'numbers' => $tophone, 'userSender' => 'SAFWA', 'apiKey' => 'a3f01ee42eeaedb609a62fd3e509c9dc', 'msg' => $body]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
        ));

        $response = curl_exec($ch);

        return $response;
    }

    public function onlineHours(Request $request)
    {

        $user_id = auth()->user()->id;
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
            $message    =   trans('api.drivers.validation_error');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $from = Carbon::parse($request->from_date)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($request->to_date)->format('Y-m-d') . ' 23:59:59';
        $log   =   DriverAvailableLog::mylog()->whereBetween('updated_on', [$from, $to])->orderBy('updated_on')->pluck('updated_on', 'is_available');
        $onlineMinutes    =   0;
        $offset =  Carbon::parse($from);
        foreach ($log as $online => $time) {
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
        $onlineHours = floor($onlineMinutes / 60) . ":" . ($onlineMinutes - floor($onlineMinutes / 60) * 60);
        return $onlineHours;
    }

    function send_push_notification($device_token, $title, $body)
    {
        //$fcm_server_key = config('fcm.fcm_app_key');
        $fcm_server_key = 'AAAAIZKRCcs:APA91bFyYxr7FGgV88i9WcT23iKIjNkZS2exVhYUnhpmzmyxMH1CAIz2z2FYVP4ymr1wZ5q1J0nsCano9F8eGeT__XjBKISZrjcOy_x1oyMnGjFdcYh3P3JZUUazE8ITT8vMGM5OwzIY';
        $notificationData = [
            'to' => $device_token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'content_available' => 1
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:key=' . $fcm_server_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    function import_drivers(Request $request) {
        $drivers = User::select()->where('id', '>', 144)->get();
        foreach ($drivers as $user) {

            $driverData['user_id'] = $user->id;
            $driverData['nationality_id'] = 1;
            $driverData['national_id'] = '0';
            $driverData['iqama_no'] = $user->email;
            $driverData['is_safwa_driver'] = 1;
            $driverData['is_active'] = 1;
            $driverData['created_at'] = now();
            Driver::create($driverData); //create driver
            $wallet_data['user_id'] = $user->id;
            $wallet_data['amount'] = 0;
            $wallet_data['user_type'] = '3';
            $wallet_data['is_active'] = '1';
            Wallet::create($wallet_data);
            $firstpaymentOption_data['user_id'] = $user->id;
            $firstpaymentOption_data['payment_method_id'] = config('constants.Cash');
            $firstpaymentOption_data['payment_title'] = 'Cash';
            $firstpaymentOption_data['is_default'] = '1';
            UserPaymentOption::create($firstpaymentOption_data);
            $secondpaymentOption_data['user_id'] = $user->id;
            $secondpaymentOption_data['payment_method_id'] = config('constants.Wallet');
            $secondpaymentOption_data['payment_title'] = 'Wallet';
            $secondpaymentOption_data['is_default'] = '0';
            UserPaymentOption::create($secondpaymentOption_data);

        }

        // return $drivers;
        return "Your drivers list (".count($drivers).") is imported successfully in database.";
    }
}
