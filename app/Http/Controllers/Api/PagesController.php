<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PagesController extends Controller
{

    /**
     * Display a general setting.
     *
     * @return Illuminate\View\View
     */
    public function privacy()
    {

        $data   = [
            'url' => '/privacy_policy'
        ];
        $message    =   'Privacy Policy url fetched successfully!';
        $status_code   = 200;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Display a general setting.
     *
     * @return Illuminate\View\View
     */
    public function terms()
    {

        $data   = [
            'url' => '/terms_conditions'
        ];
        $message    =   'Terms and Conditions url fetched successfully!';
        $status_code   = 200;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

}
