<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class SettingController extends Controller
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
     * Display a general setting.
     *
     * @return Illuminate\View\View
     */
    public function general(Request $request)
    {
        $privacy = Setting::find('1');
        if($request->has('privacy_description')) {
            if($privacy) {
                $privacy->value = $request->privacy_description;
                $privacy->save();
               return redirect()->back();
            }
        }

        $terms = Setting::find('2');
        if($request->has('terms_conditions')) {
            if($terms) {
                $terms->value = $request->terms_conditions;
                $terms->save();
                 return redirect()->back();
            }
        }

        $delivery = Setting::find('3');
        if($request->has('delivery_amount')) {
            if($delivery) {
                $delivery->value = $request->delivery_amount;
                $delivery->save();
            }
        }
        $tax = Setting::find('5');
        if($request->has('tax')) {
            if($tax) {
                $tax->value = $request->tax;
                $tax->save();
            }
        }
        return view('setting.general', compact('privacy','terms','delivery','tax'));
    }

}
