<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CustomersController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $data   = null;
        $message    =   trans('api.common.unauthorized_access');
        $status_code   = 401;

        return response(['data'=>$data, 'message'=>$message, 'status_code'=>$status_code]);
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
        $status_code   = 401;

        return response(['data'=>$data, 'message'=>$message, 'status_code'=>$status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('customer.nationality')->find($id);
        if($user && $user->user_type_id == '4'){
            $customer_details = [
                                'name'=> $user->name,
                                'email' => $user->email,
                                'gender' => $user->gender,
                                'dob' => $user->customer->dob,
                                'phone' => $user->phone,
                                'nationality' => $user->customer->nationality->name,
                                'national_id' => $user->customer->national_id,
                                'profile_image' => $user->profile_image,
                            ];
            $data['customer_details'] = $customer_details;
            $message    =   trans('api.customer.customer_details');
            $status_code = 200;
        } else {
            $data   = null;
            $message    =   trans('api.common.unauthorized_access');
            $status_code   = 401;
        }

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }
    public function customer_details()
    {
        $id = auth()->user()->id;
        $user = User::with('customer.nationality')->find($id);
        if($user && $user->user_type_id == '4'){
            $customer_details = [
                                'name'=> $user->name,
                                'email' => $user->email,
                                'gender' => $user->gender,
                                'dob' => $user->customer->dob,
                                'phone' => $user->phone,
                                'nationality' => $user->customer->nationality->name,
                                'national_id' => $user->customer->national_id,
                                'profile_image' => $user->profile_image,
                            ];
            $data['customer_details'] = $customer_details;
            $message    =   trans('api.customer.customer_details');
            $status_code = 200;
        } else {
            $data   = null;
            $message    =   trans('api.common.unauthorized_access');
            $status_code   = 401;
        }

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $validator = $this->getValidator($request);
            if ($validator->fails()) {
                $data = null;
                $message    =   trans('api.customer.validation_fail');
                $status_code = 500;
                return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
            }
            $user = User::findOrFail($id);
            if($user) {
                $data_update = $request->all();
                $user_data['name'] = $data_update['name'];
                //$user_data['email'] = $data_update['email'];
                $user_data['gender'] = $data_update['gender'];
                //$user_data['phone'] = $data_update['phone'];
                if($request->hasFile('profile_image')) {
                    $profile_image_path = $request->file('profile_image')->store('customers/profile');
                    $data_update['profile_image'] =  $profile_image_path;
                }  else {
                    $data_update['profile_image'] = $user->profile_image;
                }
                $user_data['profile_image'] = $data_update['profile_image'];
                $user->update($user_data);
                $customer_data['nationality_id'] = $data_update['nationality'];
                $customer_data['national_id'] = $data_update['national_id'];
                $customer_data['dob'] = $data_update['dob'];
                $customer = Customer::where('user_id',$id)->first();
                $customer->update($customer_data);
                $customer_details = [
                        'name'=> $user->name,
                        'email' => $user->email,
                        'gender' => $user->gender,
                        'dob' => $customer->dob,
                        'phone' => $user->phone,
                        'nationality' => $customer->nationality->name,
                        'national_id' => $customer->national_id,
                        'profile_image' => $user->profile_image,
                    ];
                $data['customer_details'] = $customer_details;
                $message    =   trans('api.customer.customer_update');
                $status_code = 200;
            } else {
                $data   = null;
                $message    =   trans('api.common.unauthorized_access');
                $status_code   = 401;
            }
        } catch (Exception $exception) {
             $data   = null;
             $message    =   trans('api.common.unauthorized_access');
             $status_code   = 401;
        }

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);

    }

    public function update_customer_details(Request $request){

        try {
            $id = auth()->user()->id;
            $validator = $this->getValidator($request);
            if ($validator->fails()) {
                $data = null;
                $message    =   trans('api.customer.validation_fail');
                $status_code = 500;
                return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
            }
            $user = User::findOrFail($id);
            if($user) {
                $data_update = $request->all();
                $user_data['name'] = $data_update['name'];
                $user_data['surname'] = $data_update['surname'];
                $user_data['email'] = $data_update['email'];
                $user_data['zipcode'] = $data_update['zipcode'];
                $user_data['address'] = $data_update['address'];
                $user_data['gender'] = $data_update['gender'];
                $user_data['city_id'] = $data_update['city_id'];
                //$user_data['phone'] = $data_update['phone'];
                if($request->hasFile('profile_image')) {
                    $profile_image_path = $request->file('profile_image')->store('customers/profile');
                    $data_update['profile_image'] =  $profile_image_path;
                }  else {
                    $data_update['profile_image'] = $user->profile_image;
                }
                $user_data['profile_image'] = $data_update['profile_image'];
                $user->update($user_data);

                $customer_data['nationality_id'] = $data_update['nationality'];
                $customer_data['national_id'] = $data_update['national_id'];
                $customer_data['dob'] = $data_update['dob'];
                $customer = Customer::where('user_id',$id)->first();
                $customer->update($customer_data);
                $customer_details = [
                        'name'=> $user->name,
                        'surname' => $user->surname,
                        'email' => $user->email,
                        'zipcode' => $user->zipcode,
                        'address' => $user->address,
                        'city_id' => $user->city_id,
                        'gender' => $user->gender,
                        'dob' => $customer->dob,
                        'phone' => $user->phone,
                        'nationality' => $customer->nationality->name,
                        'national_id' => $customer->national_id,
                        'profile_image' => $user->profile_image,
                    ];
                $data['customer_details'] = $customer_details;
                $message    =   trans('api.customer.customer_update');
                $status_code = 200;
            } else {
                $data   = null;
                $message    =   trans('api.common.unauthorized_access');
                $status_code   = 401;
            }
        } catch (Exception $exception) {
             $data   = null;
             $message    =   trans('api.common.unauthorized_access');
             $status_code   = 401;
        }

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }
    /**
     * Update Store Image.
,     *
     * @param  \App\Models\Customer  $id
     * @return \Illuminate\Http\Response
     */

    public function update_profile_image(Request $request) {
         $rules = [
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
        ];
        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.customer.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        if($request->hasFile('profile_image')) {
            $profile_image_path = $request->file('profile_image')->store('customers/profile');
            $data_update['profile_image'] =  $profile_image_path;
        }
        $user = User::findOrFail($request->id);
        $user_data['profile_image'] = $data_update['profile_image'];
        $user->update($user_data);
        $data['user'] = $user;
        $message    =   trans('api.customer.customer_profile_updated');
        $status_code = 200;
        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }
    /**
     * Remove the specified resource from storage.
,     *
     * @param  \App\Models\Customer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data   = null;
        $message    =   trans('api.common.unauthorized_access');
        $status_code   = 401;

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
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
            'name' => 'required|string|min:1|max:255',
            'email' => 'nullable|string|min:1|max:255',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'phone' => 'required',
            'nationality' => 'nullable',
            'national_id' => 'nullable',
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
        ];

        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Gets a new validator instance with the defined rules.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Support\Facades\Validator
     */
    protected function getValidator(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:255',
            //'email' => 'nullable|string|min:1|max:255',
            'gender' => 'nullable',
            'dob' => 'nullable',
            //'phone' => 'required',
            'nationality' => 'nullable',
            'national_id' => 'nullable',
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
        ];

        return Validator::make($request->all(), $rules);
    }

}
