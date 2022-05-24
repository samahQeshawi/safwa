<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use DataTables;

class CouponsController extends Controller
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
            $data = Coupon::get();


            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('coupon_code') && $request->get('coupon_code')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['coupon_code'] == $request->get('coupon_code');
                            });
                        }
                        if ($request->has('city') && $request->get('city')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['place_id'] == $request->get('city');
                            });
                        }
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['coupon_code'].$row['coupon_name']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }
                    })
                    ->addIndexColumn()
                    /*->addColumn('status', function($store){
                        return view('stores.status', compact('store'));
                    })*/
                    ->addColumn('action', function($coupon){
                        return view('coupon.datatable', compact('coupon'));
                    })
                    //->rawColumns(['status','action'])
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $coupon = Coupon::paginate(25);
        $coupon_code = Coupon::pluck('coupon_code','id')->all();
        return view('coupon.index', compact('coupon','coupon_code'));
    }

    /**
     * Show the form for creating a new store.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        return view('coupon.create');
    }

    /**
     * Store a new store in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $this->getData($request);
		$data['coupon_from_date'] = date('Y-m-d h:i:s', strtotime($data['coupon_from_date']));
		$data['coupon_to_date'] = date('Y-m-d h:i:s', strtotime($data['coupon_to_date']));
        if($request->hasFile('coupon_image')) {

            $coupon_image_path = $request->file('coupon_image')->store('coupons');
            $data['coupon_image'] =  $coupon_image_path;
        }
        Coupon::create($data);

        return redirect()->route('coupon.index')
            ->with('success_message', trans('coupon.model_was_added'));
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
        $coupon = Coupon::findOrFail($id);

        return view('coupon.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified store.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified store in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        if ($request->has('status')){
            $data['is_active'] = 1;
        }else{
            $data = $this->getData($request);
        }
        $coupon = Coupon::findOrFail($id);
        if($request->hasFile('coupon_image')) {

            $coupon_image_path = $request->file('coupon_image')->store('coupons');
            $data['coupon_image'] =  $coupon_image_path;
        }  else {
            $data['coupon_image'] = $coupon->coupon_image;
        }
        $coupon->update($data);

        return redirect()->route('coupon.index')
            ->with('success_message', trans('coupon.model_was_updated'));
    }

    /**
     * Remove the specified store from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();

            return redirect()->route('coupon.index')
                ->with('success_message', trans('coupon.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('coupon.unexpected_error')]);
        }
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
            'coupon_name' => 'required',
            'description' => 'required',
            'use_percentage' =>'boolean|nullable',
            'coupon_discount_percentage' => 'nullable',
            'coupon_max_discount_amount' => 'nullable',
            'coupon_discount_amount' => 'nullable',
            'coupon_code' => 'required',
            'coupon_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'coupon_type'  => 'nullable',
            'coupon_limit' => 'nullable',
            'coupon_from_date' => 'required|date',
            'coupon_to_date' => 'required|date',
            'is_active' => 'boolean|nullable',
        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
