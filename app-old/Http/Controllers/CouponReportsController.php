<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CouponReport;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class CouponReportsController extends Controller
{

    /**
     * Display a listing of the stores.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
        * Ajax call by datatable for listing of the stores.
        */
        if ($request->ajax()) {
            $data = CouponReport::with('user','service','carRental.car')->get();


            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('coupon_code') && $request->get('coupon_code')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['coupon_code'] == $request->get('coupon_code');
                            });
                        }
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['coupon_code'].$row['user']['name']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                                                                                  
                    })             
                    ->addIndexColumn()
                    /*->addColumn('status', function($store){
                        return view('stores.status', compact('store'));
                    })*/
                    ->addColumn('action', function($coupon_report){
                        return view('coupon_reports.datatable', compact('coupon_report'));
                    })
                    //->rawColumns(['status','action'])
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $coupon_report = CouponReport::paginate(25);
        $coupon_code = Coupon::pluck('coupon_code','id')->all();
        return view('coupon_reports.index', compact('coupon_report','coupon_code'));
    }

 
    /**
     * Display the specified store.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $coupon_report = CouponReport::findOrFail($id);

        return view('coupon_reports.show', compact('coupon_report'));
    }

    public function view_coupons(Request $request,$code){
        $coupon_code = $code;
        if ($request->ajax()) {
            $data = CouponReport::with('user','service','carRental.car')->where('coupon_code',$code)->get();


            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('coupon_code') && $request->get('coupon_code')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['coupon_code'] == $request->get('coupon_code');
                            });
                        }
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['coupon_code'].$row['user']['name']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                                                                                  
                    })             
                    ->addIndexColumn()
                    /*->addColumn('status', function($store){
                        return view('stores.status', compact('store'));
                    })*/
                    ->addColumn('action', function($coupon_report){
                        return view('coupon_reports.datatable', compact('coupon_report'));
                    })
                    //->rawColumns(['status','action'])
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $coupon_report = CouponReport::paginate(25);
        $coupon_codes = Coupon::pluck('coupon_code','id')->all();
        return view('coupon_reports.view_coupon', compact('coupon_report','coupon_codes','coupon_code'));        
    }

}
