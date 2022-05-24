<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitiesResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginated_data     = City::simplePaginate(10);
        $cities             = City::all();
        $data    = [
            'cities'=> CitiesResource::collection($cities)
        ];

        $message = 'Cities retrieved successfully';
        $status_code    = 200;
        return response([ 'paginated_data' => $paginated_data, 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
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
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
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
    public function update(Request $request, City $city)
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
    public function destroy(City $city)
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

    public function getCities(Request $request)
    {
        $rules = [
            'country_id' => 'required',
        ];
        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.auth.validation_fail');;
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $cities = City::where('country_id',$request->country_id)->where('is_active','1')->get();
        $data    = [
            'cities'=> CitiesResource::collection($cities)
        ];

        $message = 'Cities retrieved successfully';
        $status_code    = 200;
        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }
}
