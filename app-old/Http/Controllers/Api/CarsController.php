<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarsResource;
use App\Models\Branch;
use App\Models\Car;
use App\Models\Category;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars   = Car::all();
        $data    = [
            'cars'=> CarsResource::collection($cars)
        ];
        $message = 'Car retrieved successfully';
        $status_code    = 200;
        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rentalCars()
    {
        $cars   = Car::where('service_id','3')->orderBy('branch_id')->get();
        $data    = [
            'cars'=> CarsResource::collection($cars)
        ];
        $message = 'Car retrieved successfully';
        $status_code    = 200;
        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rentalCarsByNearestBranch(Request $request)
    {
        $validatedData = $request->validate([
            'latitude'=>'required',
            'longitude'=>'required'
        ]);
        $customer_location  =   new Point($request->latitude, $request->longitude);
        $query = Car::OrderByNearestBranch($customer_location);

        //filter by rental cars
        $query->where('service_id', 3);

        //filter by category
        $query->when(request('category_id', false), function ($q, $category_id) {
            return $q->where('category_id', $category_id);
        });

        //filter by branch
        $query->when(request('branch_id', false), function ($q, $branch_id) {
            return $q->where('branch_id', $branch_id);
        });

        $cars = $query->get();
        $paginated_data     = $query->simplePaginate(10);
        $data    = [
            'cars'=> CarsResource::collection($cars)
        ];
        $message = 'Car retrieved successfully';
        $status_code    = 200;
        return response([ 'paginated_data' => $paginated_data, 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }


/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rentalCarsByBranch(Request $request)
    {
        $rules = [
            'branch_id'=>'required'
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

        //filter by rental cars
        $query = Car::where('service_id', 3);

        //filter by category
        $query->when(request('category_id', false), function ($q, $category_id) {
            return $q->where('category_id', $category_id);
        });

        //filter by branch
        $query->when(request('branch_id', false), function ($q, $branch_id) {
            return $q->where('branch_id', $branch_id);
        });

        $cars = $query->get();
        $paginated_data     = $query->simplePaginate(10);
        $data    = [
            'cars'=> CarsResource::collection($cars)
        ];
        $message = 'Cars retrieved successfully';
        $status_code    = 200;
        return response([ 'data' => $paginated_data, 'message' => $message, 'status_code'=>$status_code]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rentalCarCategories()
    {

        $categories   = Category::where('service_id','3')->orderBy('category')->get();
        $data    = [
            'categories'=> CarsResource::collection($categories)
        ];
        $message = 'Car retrieved successfully';
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

    public function topcars(){
        $cars   =  DB::table("cars")
                  ->select("cars.*","car_rentals.count_booking","car_rentals.car_id")
                  ->leftJoin(DB::raw("(SELECT
                      count(car_id)as count_booking, car_id
                      FROM car_rentals
                      GROUP BY car_rentals.car_id
                      ) as car_rentals"),function($join){
                        $join->on("cars.id","=","car_rentals.car_id");
                  })
                  ->orderBy('count_booking', 'desc')
                  ->take(5)->get();
        $data    = [
            'cars'=> $cars
        ];
        $message = 'Car retrieved successfully';
        $status_code    = 200;
        return response([ 'data' => $data, 'message' => $message, 'status_code'=> $status_code]);
    }
}
