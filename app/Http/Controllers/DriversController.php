<?php

namespace App\Http\Controllers;

use App\Events\UpdateDriverLocationEvent;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CarMake;
use App\Models\Car;
use App\Models\City;
use App\Models\Country;
use App\Models\CarType;
use App\Models\Category;
use App\Models\Driver;
use App\Models\FuelType;
use App\Models\CarPhoto;
use App\Models\Service;
use App\Models\TripRoute;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DriversController extends Controller
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
     * Display a listing of the drivers.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the drivers.
         */
        if ($request->ajax()) {
            $data = User::with('driver')->where('user_type_id', 3)->get();

            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('city') && $request->get('city')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return $row['city_id'] == $request->get('city');
                        });
                    }
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['phone'] . $row['email'] . $row['name'] . $row['surname']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                    if ($request->get('safwa_driver') == "1") {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return $row['driver']['is_safwa_driver'];
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($driver) {
                    return view('drivers.datatable', compact('driver'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }

        $drivers = User::with('driver')->where('user_type_id', 3)->paginate(25);
        $cities = City::where('is_active', 1)->pluck('name', 'id')->all();

        return view('drivers.index', compact('drivers', 'cities'));
    }

    /**
     * For listing online drivers in vuejs realtime traCKING.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function onlineDrivers()
    {
        $drivers = Driver::active()->available()->get();
        $online_drivers = $drivers->map->only(['user_id', 'location','lat','lng']);
        //dd($drivers);
        return  $online_drivers;
    }

    /**
     * For listing online drivers in vuejs realtime traCKING.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function tripRoutes($trip_id)
    {
        if (!$trip_id) return [];
        $routes = TripRoute::where('trip_id',$trip_id)->orderBy('trip_id')->orderBy('id')->get();
        $trip_routes = $routes->map->only(['lat','lng']);
        //dd($trip_routes);
        return  $trip_routes;
    }

    /**
     * Show the form for creating a new driver.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::pluck('name', 'id')->all();
        $nationalities = Country::pluck('name', 'id')->all();
        $country_code = Country::pluck('phone_code', 'id')->all();
        $cities = City::where('is_active', 1)->pluck('name', 'id')->all();

        $branches = Branch::pluck('name', 'id')->all();
        //print_r($branches);
        $categories = array();
        //dd($categories);
        $cartype = CarType::pluck('name', 'id')->all();
        $carmake = CarMake::pluck('car_make', 'id')->all();
        //$services = Service::pluck('service','id')->all();
        $fueltype = FuelType::pluck('fuel_type', 'id')->all();

        $services = Service::whereIn('id', [1, 2])->pluck('service', 'id')->all();

        return view('drivers.create', compact('countries', 'cities', 'branches', 'categories', 'nationalities', 'country_code', 'cartype', 'carmake', 'fueltype', 'services'));
    }

    /**
     * Store a new driver in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        /*  try { */
        $data = $this->getData($request);
        $data['profile_image'] = $data['national_file'] = $data['iqama_file'] = $data['license_file'] = $data['birth_certificate_file'] = $data['passport_file'] = '';
        if ($request->hasFile('profile_image')) {

            $profile_image_path = $request->file('profile_image')->store('drivers/profile');
            $data['profile_image'] =  $profile_image_path;
        }
        if ($request->hasFile('birth_certificate_file')) {

            $birth_file_path = $request->file('birth_certificate_file')->store('drivers/birth_certificate');
            $data['birth_certificate_file'] =  $birth_file_path;
        }
        if ($request->hasFile('passport_file')) {

            $passport_file_path = $request->file('passport_file')->store('drivers/passport');
            $data['passport_file'] =  $passport_file_path;
        }
        if ($request->hasFile('insurance_file')) {

            $insurance_file_path = $request->file('insurance_file')->store('drivers/passport');
            $data['insurance_file'] =  $insurance_file_path;
        }
        if ($request->hasFile('national_file')) {

            $national_file_path = $request->file('national_file')->store('drivers/national');
            $data['national_file'] =  $national_file_path;
        } else {
            back()->with('error', 'National ID file is Mandatory.');
        }
        if ($request->hasFile('license_file')) {

            $license_file_path = $request->file('license_file')->store('drivers/license');
            $data['license_file'] =  $license_file_path;
        }
        $data['password'] = Hash::make($data['password']); //Encrypting password
        $data['user_type_id'] = 3; //driver user type
        $data['country_id'] =  $data['country_code']; //driver user type
        $data['city_id'] =  $data['city']; //driver user type
        //$data['is_active'] =  $data['is_active'];
        //$data['car_type_id'] =  $data['car_type']; //driver car type

        unset($data['country']);
        unset($data['city']);
        User::create($data); //create user
        $newuser = User::where('email', '=', $data['email'])->where('user_type_id', 3)->first()->toArray();

        //Cars
        $data['registration_file'] = $data['insurance_file'] = '';
        if ($request->hasFile('registration_file')) {

            $registration_path = $request->file('registration_file')->store('cars/registration');
            $data['registration_file'] =  $registration_path;
        }
        if ($request->hasFile('insurance_file')) {

            $insurance_path = $request->file('insurance_file')->store('cars/insurance');
            $data['insurance_file'] =  $insurance_path;
        }
        $data['service_id'] = 3;
        $data['user_id'] = $newuser['id'];
        $car_data = Car::create($data);
        if ($request->hasFile('photo_upload')) {
            $car_photos = array();
            $is_main = 0;
            $main_image = isset($request->main_image) ? $request->main_image : 0;
            foreach ($request->file('photo_upload') as $index => $file) {
                if ($main_image == $index) {
                    $is_main = 1;
                } else {
                    $is_main = 0;
                }
                $photo_path = $file->store('cars/photo');
                $car_photos[] = new CarPhoto(['photo_file' => $photo_path, 'is_main' => $is_main]);
            }
            $car_data->carPhotos()->saveMany($car_photos);
        }
        //Cars


        $wallet['user_id'] =  $newuser['id'];
        $wallet['user_type'] =  3;
        $wallet['amount'] =  0;
        $wallet['is_active'] =  1;
        Wallet::create($wallet);
        $driver['user_id'] = $newuser['id'];
        $driver['dob'] =   $data['dob'];
        $driver['is_safwa_driver'] = $data['is_safwa_driver'];
        //$driver['profile_image'] = $data['profile_image'];
        $driver['birth_certificate_file'] = $data['birth_certificate_file'];
        $driver['passport_file'] = $data['passport_file'];
        //$driver['insurance_expiry_date'] = $data['insurance_expiry_date'];
        $driver['insurance_file'] = $data['insurance_file'];
        $driver['national_file'] = $data['national_file'];
        $driver['license_file'] = $data['license_file'];
        $driver['national_id'] = $data['national_id'];
        $driver['nationality_id'] = $data['nationality_id'];
        $driver['is_active'] = $data['is_active'];
        Driver::create($driver); //create driver




        return redirect()->route('drivers.driver.index')
            ->with('success_message', trans('drivers.model_was_added'));
        /* } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('drivers.unexpected_error')]);
        } */
    }

    /**
     * Display the specified driver.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {

        $driver = User::with('driver')->findOrFail($id);
        $car = Car::where('user_id', $id)->first();
    	return view('drivers.show', compact('driver', 'car'));
    }

    /**
     * Show the form for editing the specified driver.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        //we get user_id here and we join user table with driver table

        $driver = User::with('driver')->findOrFail($id);
        $nationalities = Country::pluck('name', 'id')->all();
        $car = Car::where('user_id', $id)->first();
        $countries = Country::pluck('name', 'id')->all();
        $cities = City::where('is_active', 1)->pluck('name', 'id')->all();
        $cartype = CarType::pluck('name', 'id')->all();
        if (isset($car->id))
            $car_photo = CarPhoto::where('car_id', $car->id)->pluck('photo_file', 'id')->all();
        else
            $car_photo = [];

        $carmake = CarMake::pluck('car_make', 'id')->all();
        $services = Service::whereIn('id', [1, 2])->pluck('service', 'id')->all();
        $fueltype = FuelType::pluck('fuel_type', 'id')->all();
        $categories = $car ? Category::where('service_id', $car->service_id)->pluck('category', 'id') : [];
        $country_code = Country::pluck('phone_code', 'id')->all();
        return view('drivers.edit', compact('driver', 'car', 'countries', 'country_code', 'nationalities', 'cities', 'cartype', 'car_photo', 'carmake', 'fueltype', 'services', 'categories'));
    }

    /**
     * Update the specified driver in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {


        $data = $this->getData($request, $id);
        $user   =   User::findOrFail($id);
        //dd($data);
        //$car_data = Car::where('user_id',$user->id)->first();
        //$car_data->update($data);



        if ($request->hasFile('profile_image')) {
            $profile_image_path = $request->file('profile_image')->store('drivers/profile');
            $data['profile_image'] =  $profile_image_path;
        } else {
            $data['profile_image'] =  $user->profile_image;
        }
        $data['city_id'] =  $data['city']; //driver user type
        $data['country_id'] =  $data['country_code'];

        if ($data['password'] && !empty($data['password']))
            $data['password'] = Hash::make($data['password']); //Encrypting password
        else
            unset($data['password']);

       /*  $lat = $data['lat'];
        $lng = $data['lng'];
        unset($data['lat']);
        unset($data['lng']); */

        $user->update($data);




        //$data['country_id'] = $data['country']; //driver user type
        $driver = Driver::where('user_id', $id)->first();

      /*   $driver->location = new Point($lat, $lng);    // (lat, lng)
        $driver->save(); */

        //Fire the event to broadcast the location update
       // UpdateDriverLocationEvent::dispatch($user);

        if ($request->hasFile('birth_certificate_file')) {

            $birth_file_path = $request->file('birth_certificate_file')->store('drivers/birth_certificate');
            $data['birth_certificate_file'] =  $birth_file_path;
        } else {
            $data['birth_certificate_file'] =  $driver->birth_certificate_file;
        }
        if ($request->hasFile('passport_file')) {

            $passport_file_path = $request->file('passport_file')->store('drivers/passport');
            $data['passport_file'] =  $passport_file_path;
        } else {
            $data['passport_file'] =  $driver->passport_file;
        }
        if ($request->hasFile('insurance_file')) {

            $insurance_file_path = $request->file('insurance_file')->store('drivers/insurance');
            $data['insurance_file'] =  $insurance_file_path;
        } else {
            $data['insurance_file'] =  $driver->insurance_file;
        }
        if ($request->hasFile('national_file')) {

            $national_file_path = $request->file('national_file')->store('drivers/national');
            $data['national_file'] =  $national_file_path;
        } else {
            $data['national_file'] =  $driver->national_file;
        }
        if ($request->hasFile('license_file')) {

            $license_file_path = $request->file('license_file')->store('drivers/license');
            $data['license_file'] =  $license_file_path;
        } else {
            $data['license_file'] = $driver->license_file;
        }
        //$data['car_type_id'] =  $data['car_type'];
        $driver_data['dob'] =   $data['dob'];
        $driver_data['is_safwa_driver'] = $data['is_safwa_driver'];
        $driver_data['is_active'] = $data['is_active'];
        $driver_data['car_type_id'] = $data['car_type_id'];
        //$driver_data['profile_image'] = $data['profile_image'];
        $driver_data['birth_certificate_file'] = $data['birth_certificate_file'];
        $driver_data['passport_file'] = $data['passport_file'];
        $driver_data['insurance_file'] = $data['insurance_file'];
        $driver_data['national_file'] = $data['national_file'];
        $driver_data['license_file'] = $data['license_file'];
        $driver_data['national_id'] = $data['national_id'];
        $driver_data['nationality_id'] = $data['nationality_id'];

        //dd($driver_data);
        $driver->update($driver_data);


        $car_data = Car::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        if ($request->hasFile('photo_upload')) {
            $car_photos = array();
            $is_main = 0;
            $main_image = isset($request->main_image) ? $request->main_image : 0;
            $car_data->carPhotos()->delete();
            foreach ($request->file('photo_upload') as $index => $file) {
                if ($main_image == $index) {
                    $is_main = 1;
                } else {
                    $is_main = 0;
                }
                $photo_path = $file->store('cars/photo');
                $car_photos[] = new CarPhoto(['photo_file' => $photo_path, 'is_main' => $is_main]);
            }
            $car_data->carPhotos()->saveMany($car_photos);
        }

        return redirect()->route('drivers.driver.index')
            ->with('success_message', trans('drivers.model_was_updated'));
    }

    /**
     * Remove the specified driver from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $driver = Driver::where('user_id', $id);
            $driver->delete();

            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('drivers.driver.index')
                ->with('success_message', trans('drivers.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('drivers.unexpected_error')]);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request, $id = 0)
    {
        $rules = [
           /*  'lat' => 'nullable',
            'lng' => 'nullable', */
            'name' => 'required|string|min:1|max:255',
            'surname' => 'nullable',
            'email' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    $query->where('user_type_id', 3);
                }),
            ],
            'phone' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    $query->where('user_type_id', 3);
                }),
            ],
            'password' => 'required|string|min:1|max:255',
            'gender' => 'nullable',
            'country' => 'nullable',
            'country_code' => 'required',
            'nationality_id' => 'required',
            'city' => 'required',
            'car_type' => 'nullable',
            'dob' => 'nullable',
            'is_active' => 'boolean|nullable',
            'is_safwa_driver' => 'boolean|nullable',
            'birth_certificate_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'passport_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'insurance_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'national_id' => 'required',
            'national_file' => 'required|mimes:jpg,jpeg,png|max:5120',
            'license_file' => 'required|mimes:jpg,jpeg,png|max:5120',
            'category_id'   => 'required',
            'car_name'   => 'required|string|min:1|max:255',
            'car_type_id'   => 'required',
            'car_make_id'   => 'required',
            'fuel_type_id'   => 'nullable',
            'model_year'   => 'required',
            'transmission'   => 'required',
            'color'   => 'nullable',
            'engine_no'   => 'nullable',
            'description'   => 'nullable',
            'registration_no'   => 'required',
        ];

        //Validating unique for update ignoring the same record
        if ($id) {
            $rules = array_merge($rules, [
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                        $query->where('user_type_id', 3);
                    }),
                ],
                'phone' => [
                    'required',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                        $query->where('user_type_id', 3);
                    }),
                ],
                'password' => 'nullable|string|min:1|max:255',
            ]);


            $driver = Driver::where('user_id', $id)->first();
            if ($driver->national_file) {
                $rules = array_merge($rules, [
                    'national_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                ]);
            }
            if ($driver->license_file) {
                $rules = array_merge($rules, [
                    'license_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                ]);
            }
        }

        //The custom validation messages
        $custom_messages    =   [
            'car_make_id.required' => 'The Car Brand is required',
        ];

        $data = $request->validate($rules, $custom_messages);

        $data['is_active'] = $request->has('is_active');
        $data['is_safwa_driver'] = $request->has('is_safwa_driver');
        if (!$request->service_id) {
            $data['service_id'] = 2;
        } else {
            $data['service_id'] = $request->service_id;
        }
        return $data;
    }
}
