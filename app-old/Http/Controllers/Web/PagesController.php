<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Api\PaymentController;

class PagesController extends Controller
{

    /**
     * Display a general setting.
     *
     * @return Illuminate\View\View
     */
    public function privacy()
    {
        $page = Setting::find('1');
        return view('setting.page', compact('page'));
    }

    /**
     * Display a general setting.
     *
     * @return Illuminate\View\View
     */
    public function terms()
    {
        $page = Setting::find('2');
        return view('setting.page', compact('page'));
    }

    /**
     * Display a general setting.
     *
     * @return Illuminate\View\View
     */
    public function privacyPolicy()
    {
        $page = Setting::find('1');
        return view('privacy', compact('page'));
    }

    /**
     * Display a general setting.
     *
     * @return Illuminate\View\View
     */
    public function termsConditions()
    {
        $page = Setting::find('2');
        return view('terms', compact('page'));
    }

    /**
     * Display Sub Page.
     *
     * @return Illuminate\View\View
     */
    public function fleet()
    {
        return view('web.fleet' , [
            'page_title' => trans('web.fleet') ,
            'page_description' => trans('web.fleet') ,
            'page_keywords' => trans('web.fleet') ,
        ]);
    }

    /**
     * Display Sub Page.
     *
     * @return Illuminate\View\View
     */
    public function branches()
    {
        return view('web.branches' , [
            'page_title' => trans('web.branches') ,
            'page_description' => trans('web.branches') ,
            'page_keywords' => trans('web.branches') ,
        ]);
    }

    /**
     * Display Sub Page.
     *
     * @return Illuminate\View\View
     */
    public function contact()
    {
        return view('web.contact' , [
            'page_title' => trans('web.contact') ,
            'page_description' => trans('web.contact') ,
            'page_keywords' => trans('web.contact') ,
        ]);
    }

    /**
     * Display Sub Page.
     *
     * @return Illuminate\View\View
     */
    public function login()
    {
        return view('web.login' , [
            'page_title' => trans('web.customers_portal') ,
            'page_description' => trans('web.customers_portal') ,
            'page_keywords' => trans('web.customers_portal') ,
        ]);
    }


    /**
     * Display Sub Page.
     *
     * @return Illuminate\View\View
     */
    public function sign_up()
    {
        return view('web.sign_up' , [
            'page_title' => trans('web.customers_portal') ,
            'page_description' => trans('web.customers_portal') ,
            'page_keywords' => trans('web.customers_portal') ,
        ]);
    }

    /**
     * Display Sub Page.
     *
     * @return Illuminate\View\View
     */
    public function forgot_password()
    {
        return view('web.forgot_password' , [
            'page_title' => trans('web.customers_portal') ,
            'page_description' => trans('web.customers_portal') ,
            'page_keywords' => trans('web.customers_portal') ,
        ]);
    }







//  =========================


    /**
     * Display a general setting.
     *
     * @return Illuminate\View\View
     */
    public function checkouts()
    {
        // if( env('SANDBOX_MODE') == true)
        //     $base_url = "https://test.oppwa.com";
        // else $base_url = "https://live.oppwa.com";
        // $url = $base_url . "/v1/checkouts";
        // $data = "entityId=" . env('ENTITY_ID') .
        //             "&amount=10.00" .
        //             "&currency=" . env('CURRENCY') .
        //             "&paymentType=" . env('PAYMENT_TYPE');


        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://test.oppwa.com/v1/checkouts',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'entityId=8ac7a4c7798ed9e70179992028331615&amount=92.00&currency=SAR&paymentType=DB',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer OGFjN2E0Yzc3OThlZDllNzAxNzk5OTFmOWFlYjE2MTF8clp3elNaSzV5Uw==',
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        if(curl_errno($curl)) {
            return curl_error($curl);
        }
        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //                'Authorization:Bearer '. env('ACCESS_TOKEN')));
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $responseData = curl_exec($ch);
        // if(curl_errno($ch)) {
        //     return curl_error($ch);
        // }
        // curl_close($ch);

        $result = json_decode($response, true);
        return $result;
    }

    /**
     * Display a general setting.
     *
     * @return Illuminate\View\View
     */
    public function paymentTest()
    {
        $test_arr = [
            'user_id'=> 93,
            'product_id'=> 'a1-230-45',
            'product_type' => 'Test'
        ];
        $response  = PaymentController::checkout($test_arr);
        $resData = $response->original;

        return view('payment' , compact('resData') );
    }


}
