<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class UsersController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $users = User::paginate(10);

        $data = $users->transform(function ($user) {
            return $this->transform($user);
        });

        return $this->successResponse(
            'Users were successfully retrieved.',
            $data,
            [
                "draw" => 0,
                "recordsTotal" => $users->total(),
                "recordsFiltered" => $users->total()
            ]
        );
    }

    /**
     * Store a new user in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);

            $user = User::create($data);

            return $this->successResponse(
                'User was successfully added.',
                $this->transform($user)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->successResponse(
            'User was successfully retrieved.',
            $this->transform($user)
        );
    }

    /**
     * Update the specified user in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);

            $user = User::findOrFail($id);
            $user->update($data);

            return $this->successResponse(
                'User was successfully updated.',
                $this->transform($user)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified user from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return $this->successResponse(
                'User was successfully deleted.',
                $this->transform($user)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
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
            'email' => 'required|string|min:1|max:255',
            'email_verified_at' => 'nullable|date_format:j/n/Y g:i A',
            'password' => 'required|string|min:1|max:255',
            'remember_token' => 'nullable|string|min:0|max:100',
        ];

        return Validator::make($request->all(), $rules);
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
            'email' => 'required|string|min:1|max:255',
            'email_verified_at' => 'nullable|date_format:j/n/Y g:i A',
            'password' => 'required|string|min:1|max:255',
            'remember_token' => 'nullable|string|min:0|max:100',
        ];


        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving user to public friendly array
     *
     * @param App\Models\User $user
     *
     * @return array
     */
    protected function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
        ];
    }


    public function addCoupon(Request $request)
    {
        $user_id = auth()->user()->id;
        $rules = [
            'coupon_code'     => 'required|string'
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
        $coupon =   $validatedData['coupon_code'];

        //$checkUserCoupon    =   UserCoupon::where('user_id',auth()->user()->id)->where('coupon_code', $coupon)->count();
        $checkUserCoupon    =   UserCoupon::where('user_id', auth()->user()->id);

        //$checkUserCoupon    =   UserCoupon::where('coupon_code', $coupon)->count();
        if ($checkUserCoupon->count()) {
            $coupon_details    =   Coupon::active()->where('coupon_code', $checkUserCoupon->first()->coupon_code)->get();
            $data   = [
                'coupon_details' => $coupon_details
            ];
            $message    =   'You already have a coupon code!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $couponObj =   Coupon::active()->where('coupon_code', $coupon);
        if (!$couponObj->count()) {
            $data   = [
                'coupon_code' => $coupon
            ];
            $message = 'Invalid Coupon code!';
            $status_code    = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }

        $data   =   [
            'user_id' => $user_id,
            'coupon_id' => $couponObj->first()->id,
            'coupon_code' => $coupon
        ];

        $coupon_created    =   UserCoupon::create($data);
        if ($coupon_created) {
            $couponObj =   Coupon::active()->where('coupon_code', $coupon);
            $data   = [
                'coupon_details' => $couponObj->get(),
            ];
            $message = 'Coupon code added successfully!';
            $status_code    = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }

    public function getAddedCouponDetails()
    {
        $user_id = auth()->user()->id;
        $checkUserCoupon    =   UserCoupon::where('user_id', $user_id);
        if (!$checkUserCoupon->count()) {
            $data   = null;
            $message    =   'You have no coupons added!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $coupon_code  =  $checkUserCoupon->first()->coupon_code;
        $couponObj =   Coupon::where('coupon_code', $coupon_code);
        if (!$couponObj->count()) {
            $data   = [
                'coupon_code' => $coupon_code
            ];
            $message = 'Your coupon code is currently unavaiable!';
            $status_code    = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        if (!$couponObj->active()->count()) {
            $data   = [
                'coupon_code' => $coupon_code
            ];
            $message = 'Your coupon code is currently inactive!';
            $status_code    = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $coupon_details =   $couponObj->active()->first();
        $data   = [
            'coupon_details' => $coupon_details
        ];
        $message = 'Coupon code details fetched successfully!';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }


    public function removeCoupon(Request $request)
    {
        $user_id = auth()->user()->id;
        $rules = [
            'coupon_code'     => 'required|string'
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
        $coupon =   $validatedData['coupon_code'];
        $checkUserCoupon    =   UserCoupon::where('coupon_code', $coupon);
        if (!$checkUserCoupon->count()) {
            $data   = [
                'coupon_code' => $coupon
            ];
            $message    =   'You don\'t have this coupon code!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $userCouponId   =   $checkUserCoupon->first()->id;
        $data   =   [
            'user_id' => $user_id,
            'coupon_id' => $checkUserCoupon->first()->coupon_id,
            'coupon_code' => $coupon
        ];

        $coupon_removed    =   UserCoupon::destroy($userCouponId);
        if ($coupon_removed) {
            $message = 'Coupon code removed successfully!';
            $status_code    = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }
}
