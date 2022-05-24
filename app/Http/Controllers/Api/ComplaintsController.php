<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'service_id' => 'nullable',
            'car_rental_id' => 'nullable',
            'trip_id' => 'nullable',
            'against_user_id' => 'required',
            'subject' => 'required',
            'complaint' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.auth.validation_fail');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $data = $request->all();

        $complaint = Complaint::orderBy('id', 'DESC')->first();
        if ($complaint) {
            $no_only = substr($complaint->complaint_no, 2);
            $idno = ltrim($no_only, '0');
            $complaint_no = $idno + 1;
        } else {
            $complaint_no = 1;
        }
        $next_number = str_pad($complaint_no, 10, "0", STR_PAD_LEFT);

        $data['status'] =   'New';
        $data['complaint_no'] =  'RT'. $next_number;
        $data['service_id'] = $request->service_id ?? 2;//default to Request taxi
        $data['from_user_type'] =   auth()->user()->user_type_id;
        $data['from_user_id'] =   auth()->user()->id;
        $data['against_user_type'] =   User::where('id', $data['against_user_id'])->pluck('user_type_id')->first();
        $complaint  =  Complaint::create($data);;
        if (!$complaint) {
            $data   = null;
            $message    =   trans('api.complaints.add_failure');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
        $data   = $complaint;
        $message    =   trans('api.complaints.add_success');
        $status_code   = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
