<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomersController extends Controller
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
     * Display a listing of the customers.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the drivers.
         */
        if ($request->ajax()) {
            $data = User::with('customer')->where('user_type_id', 4)->get();
            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('city') && $request->get('city')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            //return Str::contains($row['phone'], $request->get('phone')) ? true : false;
                            return $row['city_id'] == $request->get('city');
                        });
                    }
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['phone'] . $row['email'] . $row['name'] . $row['surname']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($customer) {
                    return view('customer.datatable', compact('customer'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }

        $customer = User::with('customer')->where('user_type_id', 4)->paginate(25);
        $cities = City::where('is_active', 1)->pluck('name', 'id')->all();
        return view('customer.index', compact('customer', 'cities'));
    }

    /**
     * Show the form for creating a new customer.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $country_code = Country::pluck('phone_code', 'id')->all();
        $nationalities = Country::pluck('name', 'id')->all();
        $cities =  City::where('is_active', 1)->pluck('name', 'id')->all();
        return view('customer.create', compact('country_code', 'cities', 'nationalities'));
    }

    /**
     * Store a new customer in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //try {

        $data = $this->getData($request);

        $data['password'] = Hash::make($data['password']); //Encrypting password
        $data['country_id'] = $data['country']; //driver user type
        $data['city_id'] =  $data['city']; //driver user type
        $data['user_type_id'] = 4;
        if ($request->hasFile('profile_image')) {

            $profile_image_path = $request->file('profile_image')->store('customers/profile');
            $data['profile_image'] =  $profile_image_path;
        }
        unset($data['country']);
        unset($data['city']);
        User::create($data);
        $newuser = User::where('email', '=', $data['email'])->where('user_type_id', 4)->first()->toArray();
        $wallet['user_id'] =  $newuser['id'];
        $wallet['user_type'] =  4;
        $wallet['amount'] =  0;
        $wallet['is_active'] =  1;
        Wallet::create($wallet);
        if ($request->hasFile('national_file')) {

            $national_file_path = $request->file('national_file')->store('customers/national');
            $data['national_file'] =  $national_file_path;
            $customer['national_file'] = $data['national_file'];
        }
        if ($request->hasFile('license_file')) {

            $license_file_path = $request->file('license_file')->store('customers/license');
            $data['license_file'] =  $license_file_path;
            $customer['license_file'] = $data['license_file'];
        }
        $customer['user_id'] = $newuser['id'];
        $customer['dob'] = $data['dob'];
        $customer['national_id'] = $data['national_id'];
        $customer['nationality_id'] = $data['nationality_id'];
        Customer::create($customer); //create driver
        return redirect()->route('customer.index')
            ->with('success_message', trans('customer.model_was_added'));
        /*} catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('drivers.unexpected_error')]);
        }*/
    }
    /**
     * Display the specified customer.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $customer = User::with('customer')->findOrFail($id);
        return view('customer.show', compact('customer'));
    }

    /**
     * Display the specified customer.
     *
     * @param int $id-','id')->all();
     * /**
     * Show the form for editing the specified driver.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $customer = User::with('customer')->findOrFail($id);
        $country_code = Country::pluck('phone_code', 'id')->all();
        $nationalities = Country::pluck('name', 'id')->all();
        $cities = City::where('is_active', 1)->pluck('name', 'id')->all();
        return view('customer.edit', compact('customer', 'country_code', 'nationalities', 'cities'));
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
        $data['country_id'] = $data['country']; //driver user type
        $data['city_id'] =  $data['city']; //driver user type
        if ($request->hasFile('profile_image')) {
            $profile_image_path = $request->file('profile_image')->store('customers/profile');
            $data['profile_image'] =  $profile_image_path;
        } else {
            $data['profile_image'] =  $user->profile_image;
        }
        //Update the password only if provided
        if ($data['password'] && !empty($data['password']))
            $data['password'] = Hash::make($data['password']); //Encrypting password
        else
            unset($data['password']);
        $user->update($data);

        $customer = Customer::where('user_id', $id)->first();

        if ($request->hasFile('national_file')) {

            $national_file_path = $request->file('national_file')->store('customers/national');
            $data['national_file'] =  $national_file_path;
        } else {
            $data['national_file'] = '';
        }
        if ($request->hasFile('license_file')) {

            $license_file_path = $request->file('license_file')->store('customers/license');
            $data['license_file'] =  $license_file_path;
        } else {
            $data['license_file'] = '';
        }
        $customer_data['is_active'] = $data['is_active'];
        $customer_data['dob'] = $data['dob'];
        $customer_data['national_file'] = $data['national_file'];
        $customer_data['license_file'] = $data['license_file'];
        $customer_data['national_id'] = $data['national_id'];
        $customer_data['nationality_id'] = $data['nationality_id'];
        if(!empty($customer))
        $customer->update($customer_data);
        return redirect()->route('customer.index')
            ->with('success_message', trans('customer.model_was_updated'));
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
            $customer = Customer::where('user_id', $id);
            $customer->delete();

            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('customer.index')
                ->with('success_message', trans('customer.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('customer.unexpected_error')]);
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
            'name' => 'required|string|min:1|max:255',
            'surname' => 'nullable',
            'email' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    $query->where('user_type_id', 4);
                }),
            ],
            'phone' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    $query->where('user_type_id', 4);
                }),
            ],
            'password' => 'required|string|min:1|max:255',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'country' => 'nullable',
            'city' => 'nullable',
            'nationality_id' => 'nullable',
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'national_id' => 'nullable',
            'national_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'license_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
        ];

        //Validating unique for update ignoring the same record
        if ($id) {
            $rules = array_merge($rules, [
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                        $query->where('user_type_id', 4);
                    }),
                ],
                'phone' => [
                    'required',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                        $query->where('user_type_id', 4);
                    }),
                ],
                'password' => 'nullable|string|min:1|max:255',
            ]);
        }
        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

    public function getNearestDrivers($id)
    {
        $customer   = User::with('customer')->find($id);
        //dd($customer);
        if ($customer->customer->location) {
            $query      = Driver::orderByDistance('location', $customer->customer->location)->active()->available(); //find the nearest trip for the driver who is free(having no trip with status 4,5,6,7,8)
            if (!$query->count()) {
                return $query->count();
            } else {
                return $query->get()->take(5);
            }
        }
    }
}
