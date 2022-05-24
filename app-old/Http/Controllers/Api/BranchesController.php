<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BranchesResource;
use App\Models\Branch;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches   = Branch::all();
        $data    = [
            'branches' => BranchesResource::collection($branches)
        ];
        $message = 'Branches retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
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

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {


        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nearestBranches(Request $request)
    {

        $rules = [
            'latitude' => 'required',
            'longitude' => 'required'
        ];
        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.auth.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $customer_location  =   new Point($request->latitude, $request->longitude);
        // $query = Branch::select()->OrderByDistanceSphere('location', $customer_location);
        $query = Branch::select()->OrderByDistance('location', $customer_location);

        $branches     = $query->simplePaginate(10);
        $data    = [
            'branches' => BranchesResource::collection($branches)
        ];
        $message = 'Branches retrieved successfully';
        $status_code    = 200;
        return response(['data' => $branches, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
    }
}
