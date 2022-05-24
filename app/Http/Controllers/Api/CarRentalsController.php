<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BillResource;
use App\Http\Resources\CarRentalsResource;
use App\Http\Resources\CarsResource;
use App\Models\Car;
use App\Models\CarRental;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class CarRentalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car_rental   = CarRental::all();
        $data    = [
            'car_rentals' => CarRentalsResource::collection($car_rental)
        ];
        $message = 'CarRental retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }


    /**
     * Find the total rent.
     *
     * @return Amount Decimal
     */
    public function calculateCarRent($car, $days)
    {
        $carObj =   Car::where('id', $car)->first();
        $amount =   0;
        $years  =   floor($days / 365);
        $amount +=  $years * $carObj->rent_yearly;
        $days   =   $days - $years * 365;
        $months =   floor($days / 30);
        $amount +=  $months * $carObj->rent_monthly;
        $days   =   $days - $months * 30;
        $weeks  =   floor($days / 7);
        $amount +=  $weeks * $carObj->rent_weekly;
        $days   =   $days - $weeks * 7;
        $amount +=  $days * $carObj->rent_daily;
        return $amount;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'car_id' => 'required',
            'pickup_on' => 'required',
            'duration_in_days' => 'required'
        ]);

        $validatedData['amount'] = $this->calculateCarRent($validatedData['car_id'], $validatedData['duration_in_days']);
        $dropoff_on    =   new Carbon($validatedData['pickup_on']);
        $validatedData['dropoff_on']    =   $dropoff_on->addDays($validatedData['duration_in_days']);
        $car_rental = CarRental::orderBy('id', 'DESC')->first();
        if ($car_rental) {
            $no_only      = substr($car_rental->booking_no, 2);
            $idno = ltrim($no_only, '0');
            $booking_no = $idno + 1;
        } else {
            $booking_no = 1;
        }
    //    $next_number = str_pad($booking_no, 10, "0", STR_PAD_LEFT);
        $next_number = $booking_no;
    
        $validatedData['booking_no'] = 'BK' . $next_number;
        $branch_id =  Car::where('id', $validatedData['car_id'])->pluck('branch_id')->first();

        $validatedData['branch_id'] = $branch_id;
        $data['discount'] = '0';
        $data['final_amount'] = $validatedData['amount'];
        $data['payment_status'] = '0';
        $validatedData['user_id']   =   auth()->user()->id;
        $carRental             =    CarRental::create($validatedData);
        $car = CarRental::with('car', 'branch')->where('id', $carRental->id)->first();
        $data   = $this->formatRentDetails($car);
        $message    =   'Rental Booking successful!';
        $status_code   = 200;

        if (!$carRental) {
            $data   = null;
            $message    =   'Rental Booking not successful!';
            $status_code   = 401;
        }
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function show(CarRental $car_rental)
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

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarRental $car_rental)
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

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cities  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarRental $car_rental)
    {
        /* $city->delete();
        $data    = null;
        $message = 'Cities deleted successfully';
        $status_code    = 200; */

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }


    public function myRentList(Request $request)
    {
        $user_id = auth()->user()->id;
        $rules = [
            'from_date'       => 'required|date',
            'to_date'         => 'required|date|after_or_equal:from_date'
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.carRental.validation_error');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $from = Carbon::parse($request->from_date)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($request->to_date)->format('Y-m-d') . ' 23:59:59';

        $car = CarRental::with('car', 'branch')->where('user_id', $user_id)->orderBy('id', 'DESC')->whereBetween('pickup_on', [$from, $to]);
        $car = $car->simplePaginate(10);
        $car->getCollection()->transform(function ($value) {
            return $this->formatRentDetails($value);
        });

        $message = 'My car rental details retrieved successfully';
        $status_code    = 200;
        return response(['data' => $car, 'message' => $message, 'status_code' => $status_code]);
    }


    protected function formatRentDetails($row)
    {
        $newdata['id'] = $row->id;
        $newdata['booking_no'] = $row->booking_no;
        $newdata['user_id'] = $row->user_id;
        $newdata['car_id'] = $row->car_id;
        $newdata['branch_id'] = $row->branch_id;
        $newdata['branch_name'] = isset($row->branch->name) ? $row->branch->name : '';
        $newdata['branch_code'] = isset($row->branch->branch_code) ? $row->branch->branch_code : '';
        $newdata['booking_status'] = $row->booking_status;
        $newdata['pickup_on'] = $row->pickup_on;
        $newdata['duration_in_days'] = $row->duration_in_days;
        $newdata['dropoff_on'] = $row->dropoff_on;
        $newdata['amount'] = $row->amount;
        $dropoff_on = new Carbon($row->dropoff_on);
        $current_date = Carbon::now();

        $remaining_time = $current_date->diff($dropoff_on);

        $time = array();
        if ($remaining_time->y != 0) {
            $time[]  = $remaining_time->y . " Year ";
        }
        if ($remaining_time->m != 0) {
            $time[] = $remaining_time->m . " Months ";
        }
        if ($remaining_time->d != 0) {
            $time[] = $remaining_time->d . " Day ";
        }
        if ($remaining_time->h != 0) {
            $time[] = $remaining_time->h . " Hour ";
        }
        if ($remaining_time->i != 0) {
            $time[] = $remaining_time->i . " Mins ";
        }

        $format_time = implode("", $time);
        $newdata['remaining_time'] = $format_time;
        $newdata['created_at'] = $row->created_at;
        $newdata['car_name'] = $row->car->car_name;
        $newdata['car_model_year'] = $row->car->model_year;
        $newdata['registration_no'] = $row->car->registration_no;

        return $newdata;
    }

    public function myBillList(Request $request)
    {

        $user_id = auth()->user()->id;
        $rules = [
            'from_date'       => 'required|date',
            'to_date'         => 'required|date|after_or_equal:from_date'
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   trans('api.carBill.validation_error');
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $from = Carbon::parse($request->from_date)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($request->to_date)->format('Y-m-d') . ' 23:59:59';

        $bill = CarRental::with('car', 'branch')->where('user_id', $user_id)->orderBy('id', 'DESC')->whereBetween('pickup_on', [$from, $to]);
        $bill = $bill->simplePaginate(10);
        $bill->getCollection()->transform(function ($value) {
            return $this->formatBillDetails($value);
        });


        $message = 'Bill details retrieved successfully';
        $status_code    = 200;
        return response(['data' => $bill, 'message' => $message, 'status_code' => $status_code]);
    }

    protected function formatBillDetails($row)
    {
        $newdata['id'] = $row->id;
        $newdata['booking_no'] = $row->booking_no;
        $newdata['user_id'] = $row->user_id;
        $newdata['car_id'] = $row->car_id;
        $newdata['branch_id'] = $row->branch_id;
        $newdata['branch_name'] = isset($row->branch->name) ? $row->branch->name : '';
        $newdata['branch_code'] = isset($row->branch->branch_code) ? $row->branch->branch_code : '';
        $newdata['booking_status'] = $row->booking_status;
        $newdata['pickup_on'] = $row->pickup_on;
        $newdata['duration_in_days'] = $row->duration_in_days;
        $newdata['dropoff_on'] = $row->dropoff_on;
        $newdata['amount'] = $row->amount;
        $dropoff_on = new Carbon($row->dropoff_on);
        $current_date = Carbon::now();

        $remaining_time = $current_date->diff($dropoff_on);

        $time = array();
        if ($remaining_time->y != 0) {
            $time[]  = $remaining_time->y . " Year ";
        }
        if ($remaining_time->m != 0) {
            $time[] = $remaining_time->m . " Months ";
        }
        if ($remaining_time->d != 0) {
            $time[] = $remaining_time->d . " Day ";
        }
        if ($remaining_time->h != 0) {
            $time[] = $remaining_time->h . " Hour ";
        }
        if ($remaining_time->i != 0) {
            $time[] = $remaining_time->i . " Mins ";
        }

        $format_time = implode("", $time);
        $newdata['remaining_time'] = $format_time;
        $newdata['created_at'] = $row->created_at;
        $newdata['car_name'] = $row->car->car_name;
        $newdata['car_model_year'] = $row->car->model_year;
        $newdata['registration_no'] = $row->car->registration_no;
        $newdata['bill_download_link'] = URL::to('api/car_rent_bill/pdf/' . $row->id);
        return $newdata;
    }

    public function carRentBillPdf($id)
    {
        set_time_limit(300);
        $data['car_rental'] =  CarRental::with('user', 'car')->findOrFail($id);
        // dd($data);
        $pdf = PDF::loadView('car_rentals.car_rental_invoice_pdf', $data);
        return $pdf->download('invoice' . time() . '.pdf');
    }
}
