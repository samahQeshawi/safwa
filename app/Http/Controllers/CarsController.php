<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Branch;
use App\Models\CarMake;
use App\Models\CarType;
use App\Models\Service;
use App\Models\Category;
use App\Models\FuelType;
use App\Models\CarPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use DataTables;

class CarsController extends Controller
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
            $data = Car::with('carmake','category')->get();


            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('branch') && $request->get('branch')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['branch_id'] == $request->get('branch');
                            });
                        }
                        if ($request->has('category') && $request->get('category')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['category_id'] == $request->get('category');
                            });
                        }
                        if ($request->has('car_make') && $request->get('car_make')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['car_make_id'] == $request->get('car_make');
                            });
                        }
                        if ($request->has('car_model') && $request->get('car_model')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['model_year'] == $request->get('car_model');
                            });
                        }
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['car_name']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function($car){
                        return view('car.datatable', compact('car'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $car = Car::with('carmake')->paginate(25);
        $branchs = Branch::pluck('name','id')->all();
        $categories = Category::pluck('category','id')->all();
        $carmake = CarMake::pluck('car_make','id')->all();
        $carmodel = Car::groupBy('model_year')->pluck('model_year')->all();;
        return view('car.index', compact('car','branchs','categories','carmake','carmodel'));
    }

    /**
     * Show the form for creating a new car rental.
     *
     * @return Illuminate\View\View
     */
    public function create(Request $request)
    {
        $service_id = $request->get('service_type');
        $branches = Branch::pluck('name','id')->all();
        //print_r($branches);
        $categories = Category::where('service_id',$service_id)->pluck('category','id')->all();
        //dd($categories);
        $cartype = CarType::pluck('name','id')->all();
        $carmake = CarMake::pluck('car_make','id')->all();
        //$services = Service::pluck('service','id')->all();
        $fueltype = FuelType::pluck('fuel_type','id')->all();
        return view('car.create', compact('branches','categories','service_id','cartype','carmake','fueltype'));
    }

    /**
     * Store a new cars in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {


            $data = $this->getData($request);

            //$data['insurance_expiry_date'] = date('Y-m-d', strtotime($data['insurance_expiry_date']));
            $data['registration_file'] = $data['insurance_file'] = '';
            if($request->hasFile('registration_file')) {

                $registration_path = $request->file('registration_file')->store('cars/registration');
                $data['registration_file'] =  $registration_path;
            }
            if($request->hasFile('insurance_file')) {

                $insurance_path = $request->file('insurance_file')->store('cars/insurance');
                $data['insurance_file'] =  $insurance_path;
            }
            if(!isset($data['service_id'])){
                $data['service_id'] = 3;    
            }
            
            $car_data = Car::create($data);
           if($request->hasFile('photo_upload')) {
                $car_photos = array();
                $is_main = 0 ;
                $main_image = isset($request->main_image) ? $request->main_image : 0;
                foreach ($request->file('photo_upload') as $index => $file) {
                    if($main_image == $index){
                        $is_main = 1;
                    } else {
                        $is_main = 0 ;
                    }
                    $photo_path = $file->store('cars/photo');
                    $car_photos[] = new CarPhoto(['photo_file' => $photo_path,'is_main'=>$is_main]);
                }
                $car_data->carPhotos()->saveMany($car_photos);
            }
            return redirect()->route('car.index')
                ->with('success_message', trans('car.model_was_added'));
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
        $car = Car::with('carmake','location','cartype','service','category','carfuel','carPhotos')->findOrFail($id);
        return view('car.show', compact('car'));
    }

    /**
     * Show the form for editing the specified store.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        $service_id = $request->get('service_type');
        $car = Car::findOrFail($id);
        $car->insurance_expiry_date = \Carbon\Carbon::parse($car->insurance_expiry_date)->format('d-m-Y');
        $branches = Branch::pluck('name','id')->all();
        $cartype = CarType::pluck('name','id')->all();
        $carmake = CarMake::pluck('car_make','id')->all();
        //$services = Service::pluck('service','id')->all();
        $fueltype = FuelType::pluck('fuel_type','id')->all();
        $categories = Category::where('service_id',$service_id)->pluck('category','id')->all();
        $car_photo = CarPhoto::where('car_id',$id)->pluck('photo_file','id')->all();

        return view('car.edit', compact('car','branches','cartype','carmake','service_id','fueltype','categories','car_photo'));
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

        try {
            $data = $this->getData($request);

            $car = Car::findOrFail($id);
            //$data['insurance_expiry_date'] = date('Y-m-d', strtotime($data['insurance_expiry_date']));
            $data['registration_file'] = $data['insurance_file'] = '';
            if($request->hasFile('registration_file')) {

                $registration_path = $request->file('registration_file')->store('cars/registration');
                $data['registration_file'] =  $registration_path;
            } else {
                 $data['registration_file'] = $car->registration_file;
            }
            if($request->hasFile('insurance_file')) {

                $insurance_path = $request->file('insurance_file')->store('cars/insurance');
                $data['insurance_file'] =  $insurance_path;
            }  else {
                $data['insurance_file'] = $car->insurance_file;
            }
           if($request->hasFile('photo_upload')) {
                $car_photos = array();
                $is_main = 0 ;
                $main_image = isset($request->main_image) ? $request->main_image : 0;
                $car->carPhotos()->delete();
                foreach ($request->file('photo_upload') as $index => $file) {
                    if($main_image == $index){
                        $is_main = 1;
                    } else {
                        $is_main = 0 ;
                    }
                    $photo_path = $file->store('cars/photo');
                    $car_photos[] = new CarPhoto(['photo_file' => $photo_path,'is_main'=>$is_main]);
                }
                $car->carPhotos()->saveMany($car_photos);
            }
            $car->update($data);

            return redirect()->route('car.index')
                ->with('success_message', trans('car.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('car.unexpected_error')]);
        }
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
            $car = Car::findOrFail($id);
            $car->delete();

            return redirect()->route('car.index')
                ->with('success_message', trans('car.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('car.unexpected_error')]);
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
            'service_id' => 'required',
            'branch_id' => 'nullable',
            'car_name' => 'required|string|min:1',
            'rent_hourly' => 'nullable',
            'rent_daily' => 'nullable',
            'rent_weekly' => 'nullable',
            'rent_monthly' => 'nullable',
            'rent_yearly' => 'nullable',
            //'short_description' => 'string|min:1|nullable',
            'description' => 'string|min:1|nullable',
            'category_id' => 'nullable',
            'car_make_id' => 'nullable',
            'car_type_id' => 'nullable',
            'fuel_type_id' => 'nullable',
            'model_year' => 'nullable',
            'color' => 'nullable',
            'transmission' => 'nullable',
            //'engine' => 'nullable',
            'engine_no' => 'nullable',
            'seats' => 'nullable',
            'registration_no' => 'required',
            'cancellation_before' => 'nullable',
           //'insurance_expiry_date' => 'required',
            'registration_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'insurance_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            /*'star' => 'nullable',
            'meta_keyword' => 'nullable',
            'meta_description' => 'nullable',*/
        ];

        $data = $request->validate($rules);

        return $data;
    }
    public function view_cars(Request $request,$id){
        $service_id = $id;
        if ($request->ajax()) {
            $data = Car::with('carmake','category')->where('service_id',$id)->get();


            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('branch') && $request->get('branch')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['branch_id'] == $request->get('branch');
                            });
                        }
                        if ($request->has('category') && $request->get('category')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['category_id'] == $request->get('category');
                            });
                        }
                        if ($request->has('car_make') && $request->get('car_make')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['car_make_id'] == $request->get('car_make');
                            });
                        }
                        if ($request->has('car_model') && $request->get('car_model')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['model_year'] == $request->get('car_model');
                            });
                        }
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['car_name']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function($car){
                        return view('car.datatable', compact('car'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $car = Car::with('carmake')->paginate(25);
        $branchs = Branch::pluck('name','id')->all();
        $categories = Category::pluck('category','id')->all();
        $carmake = CarMake::pluck('car_make','id')->all();
        $carmodel = Car::groupBy('model_year')->pluck('model_year')->all();;
        return view('car.view', compact('car','branchs','categories','carmake','carmodel','service_id'));
    }
    public function getLocation(Request $request) {
        $locations = [];
        if($request->has('q')){
            $search = $request->q;
            $locations =Branch::select("id", "name")
                    ->where('name', 'LIKE', "%$search%")
                    ->get();
        }
        return response()->json($locations);

    }
    public function getCategories(Request $request) {
        $categories = [];
        if($request->has('id')){
            $categories =Category::select("id", "category")
                    ->where('service_id', $request->id)
                    ->get();
        }
        return response()->json($categories);

    }
}
