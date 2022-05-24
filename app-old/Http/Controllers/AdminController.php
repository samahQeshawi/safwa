<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
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
            $data = User::where('user_type_id',2)->get();
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
                        return Str::contains(Str::lower($row['phone'].$row['email'].$row['name'].$row['surname']), Str::lower($request->get('keyword'))) ? true : false;
                    });
                }                

            })
            ->addIndexColumn()
                    ->addColumn('action', function($user_admin){
                        return view('user_admin.datatable', compact('user_admin'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $user_admin = User::where('user_type_id',2)->paginate(25);
        $cities = City::where('is_active',1)->pluck('name','id')->all();
        return view('user_admin.index', compact('user_admin','cities'));
    }

    /**
     * Show the form for creating a new customer.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::pluck('name','id')->all();
        $cities = City::where('is_active',1)->pluck('name','id')->all();
        return view('user_admin.create', compact('countries','cities'));
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
       /*  try { */

            $data = $this->getData($request);

            $data['password'] = Hash::make($data['password']); //Encrypting password
            $data['country_id'] = $data['country']; //driver user type
            $data['city_id'] =  $data['city']; //driver user type
			$data['user_type_id'] = 2;
           /* if($request->hasFile('profile_image')) {

                $profile_image_path = $request->file('profile_image')->store('customers/profile');
                $data['profile_image'] =  $profile_image_path;
            }*/
            unset($data['country']);
            unset($data['city']);
			$user_id = User::insertGetId($data);
            $wallet['user_id'] =  $user_id;
            $wallet['user_type'] =  2;
            $wallet['amount'] =  0;
            $wallet['is_active'] =  1;
            Wallet::create($wallet);            
            return redirect()->route('user_admin.index')
                ->with('success_message', trans('user_admin.model_was_added'));
        /* } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('drivers.unexpected_error')]);
        } */
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
        $user_admin = User::findOrFail($id);

        return view('user_admin.show', compact('user_admin'));
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

        $user_admin = User::findOrFail($id);
        $countries = Country::pluck('name','id')->all();
        $cities = City::where('is_active',1)->pluck('name','id')->all();
        return view('user_admin.edit', compact('user_admin','countries','cities'));
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
            $user->update($data);

            return redirect()->route('user_admin.index')
                ->with('success_message', trans('user_admin.model_was_updated'));

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
            $user_admin = User::findOrFail($id);
            $user_admin->delete();

            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('user_admin.index')
                ->with('success_message', trans('user_admin.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('user_admin.unexpected_error')]);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request, $id=0)
    {
        $rules = [
            'name' => 'required|string|min:1|max:255',
            'surname' => 'required|string|min:1|max:255',
            'email' => 'required|email|unique:users|min:1|max:255',
            'password' => 'nullable|string|min:1|max:255',
            'phone' => 'required|unique:users|min:1|max:20',
            'gender' => 'nullable',
            'country' => 'required',
            'city' => 'required',
        ];

        //Validating unique for update ignoring the same record
        if ($id) {
            $rules = array_merge($rules,[
                'email' =>  [
                    'required',
                    'min:1',
                    'max:255',
                    Rule::unique('users')->ignore($id),
                ],
                'phone' =>  [
                    'required',
                    'min:1',
                    'max:20',
                    Rule::unique('users')->ignore($id),
                ]
            ]);
        }
        $data = $request->validate($rules);
        $data['is_active'] = $request->has('is_active');
        return $data;
    }

}
