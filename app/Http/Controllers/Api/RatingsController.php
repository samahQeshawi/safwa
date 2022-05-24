<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data   = null;
        $message    =   'Unauthorized access!';
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

        $data = $request->validate([
            'rated_for' => 'required',
            'trip_id' => 'required',
            'rating' => 'required',
            'rating_comment' => 'nullable'
        ]);

        $data['user_type']  = 'driver';
        $data['rated_by']   =   $data['done_by'] = auth()->user()->id;
        $rating             =    Rating::create($data);

        $data   = $rating;
        $message    =   'Rating successful!';
        $status_code   = 200;

        if (!$rating){
            $data   = null;
            $message    =   'Rating not successful!';
            $status_code   = 401;
        }
        return response(['data'=>$data, 'message'=>$message, 'status_code'=>$status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        /* $show_city   = new CitiesResource($city);
        $data    = [
            'city'=> $show_city
        ];
        $message = 'Cities details retrieved successfully';
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
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        /* $city->update($request->all());

        $updated_city   = new CitiesResource($city);
        $data    = [
            'city'=> $updated_city
        ];
        $message = 'Cities updated successfully';
        $status_code    = 200; */

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        /* $city->delete();
        $data    = null;
        $message = 'Cities deleted successfully';
        $status_code    = 200; */

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }
}
