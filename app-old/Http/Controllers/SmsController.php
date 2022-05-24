<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Index page.
     *
     * @return view
     */
    public function index(Request $request){
    	return view('sms.create');
    }
    /**
     * Send a sms.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function send(Request $request)
    {
             $rules = [
            'send_to' => 'required',
            'text_message' => 'required',
        	];
        	$data = $request->validate($rules);
        	$tophone =  $data['send_to'];
			$body = strip_tags($data['text_message']);
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, TRUE);

            //$fields = json_encode(['userName' => 'Ghorm', 'numbers' => $tophone,'userSender' => 'Darlana','apiKey' => '5b8c561edecb39e06ac46393164177ee','msg' => $body]);
            $fields = json_encode(['userName' => 'SAFWA GROUP', 'numbers' => $tophone, 'userSender' => 'SAFWA', 'apiKey' => 'a3f01ee42eeaedb609a62fd3e509c9dc', 'msg' => $body]);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			  "Content-Type: application/json",));

			$response = curl_exec($ch);

			if ($response === false) {
				$response = curl_error($ch);
				return redirect()->route('sms.index')
                ->with('error_message', trans('sms.sms_unsuccessfully'));
			} else {
				return redirect()->route('sms.index')
                ->with('success_message', trans('sms.sms_sent_successfully'));
			}
    }

}
