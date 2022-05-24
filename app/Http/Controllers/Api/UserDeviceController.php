<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserDeviceResource;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserDeviceController extends Controller
{
    function __construct()
    {
    }

    public function add_user_device(Request $request)
    {
        $rules = [
            'deviceToken'       => 'required',
            'deviceOs' => 'required',
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
        $data['device_token'] = $request->deviceToken;
        $data['device_os'] = $request->deviceOs;

        $update['user_id'] = $user_id;
        $userdevice = UserDevice::updateOrCreate($update, $data);

        $data    = [
            'userdevice' => UserDeviceResource::make($userdevice)
        ];

        $message = 'User device details retrieved successfully.';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }
}
