<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountriesResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries   = Country::all();
        $data    = [
            'countries'=> CountriesResource::collection($countries)
        ];
        $message = 'Countries retrieved successfully';
        $status_code    = 200;
        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
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
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data'=>$data, 'message'=>$message, 'status_code'=>$status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Countries  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        /* $show_country   = new CountriesResource($country);
        $data    = [
            'country'=> $show_country
        ];
        $message = 'Countries details retrieved successfully';
        $status_code    = 200; */

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Countries  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        /* $country->update($request->all());

        $updated_country   = new CountriesResource($country);
        $data    = [
            'country'=> $updated_country
        ];
        $message = 'Countries updated successfully';
        $status_code    = 200; */

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Countries  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        /* $country->delete();
        $data    = null;
        $message = 'Countries deleted successfully';
        $status_code    = 200; */

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }
}
