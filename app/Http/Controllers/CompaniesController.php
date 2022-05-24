<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Country;
use App\Models\City;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompaniesController extends Controller
{

    /**
     * Display a listing of the companies.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
        * Ajax call by datatable for listing of the companies.
        */
        if ($request->ajax()) {
            $data =  User::with('company')->where('user_type_id',5)->get();
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('city') && $request->get('city')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                //return Str::contains($row['phone'], $request->get('phone')) ? true : false;
                                return $row['user']['city_id'] == $request->get('city');
                            });
                        }
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['phone'].$row['name'].$row['surname']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function($company){
                        return view('companies.datatable', compact('company'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $companies = Company::with('user')->paginate(25);
        $cities = City::where('is_active',1)->pluck('name','id')->all();
        return view('companies.index', compact('companies','cities'));
    }

    /**
     * Show the form for creating a new company.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::pluck('name','id')->all();
        $country_code = Country::pluck('phone_code','id')->all();
        $cities = City::where('is_active',1)->pluck('name','id')->all();
        return view('companies.create',compact('countries','cities','country_code'));
    }

    /**
     * Store a new company in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
            $data = $this->getData($request);
            $data['profile_image'] = '';
            if($request->hasFile('logo')) {

                $log_path = $request->file('logo')->store('companies/logo');
                $data['profile_image'] =  $log_path;
            }
            $user_data['password'] = Hash::make($data['password']);
            $user_data['user_type_id'] = 5;
            $user_data['country_id'] = $data['country_code'];
            $user_data['city_id'] =  $data['city'];
            $user_data['address'] =  $data['address'];
            $user_data['phone'] =  $data['phone'];
            $user_data['email'] =  $data['email'];
            $user_data['name'] =  $data['name'];
            $user_data['profile_image'] =  $data['profile_image'];
            $user_data['is_active']    =  $data['is_active'];
            unset($data['country']);
            unset($data['city']);
            $user_id = User::insertGetId($user_data);
            $wallet['user_id'] =  $user_id;
            $wallet['user_type'] =  5;
            $wallet['amount'] =  0;
            $wallet['is_active'] =  1;
            Wallet::create($wallet);
            if($request->hasFile('cr_doc')) {

                $cr_doc = $request->file('cr_doc')->store('companies/cr_doc');
                $data['cr_doc'] =  $cr_doc;
            }
            $companies_data['user_id']      =  $user_id;
            $companies_data['cr_no']        =  $data['cr_no'];
            $companies_data['cr_doc']       =  $data['cr_doc'] ?? '';
            $companies_data['latitude']     =  $data['latitude'];
            $companies_data['longitude']    =  $data['longitude'];
            Company::create($companies_data);

            return redirect()->route('companies.company.index')
                ->with('success_message', trans('companies.model_was_added'));
    }

    /**
     * Display the specified company.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $company = User::with('company')->findOrFail($id);

        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $company =  User::with('company')->findOrFail($id);;
        $countries = Country::pluck('name','id')->all();
        $cities = City::where('is_active',1)->pluck('name','id')->all();
        $country_code = Country::pluck('phone_code','id')->all();

        return view('companies.edit', compact('company','countries','cities','country_code'));
    }

    /**
     * Update the specified company in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
            $data = $this->getData($request);

            $user =  User::findOrFail($id);
            $company = Company::where('user_id',$id)->first();
            if(!empty( $company )){
            if($request->hasFile('cr_doc')) {

                $cr_doc = $request->file('cr_doc')->store('companies/cr_doc');
                $data['cr_doc'] =  $cr_doc;
            } else {
                $data['cr_doc'] = @$company->cr_doc;
            }
           // $companies_data['user_id']      =  $user_id;
            $companies_data['cr_no']        =  $data['cr_no'];
            $companies_data['cr_doc']       =  $data['cr_doc'];
            $companies_data['latitude']     =  $data['latitude'];
            $companies_data['longitude']    =  $data['longitude'];
            //$companies_data['country_code']    =  $data['country_code'];
            $company->update($companies_data);
            }

            $company = Company::where('user_id',$id)->first();
            if($request->hasFile('logo')) {

                $log_path = $request->file('logo')->store('companies/logo');
                $data['profile_image'] =  $log_path;
            } else {
                $data['profile_image'] =  $user->profile_image;
            }
            $user_data['country_id'] =  $data['country_code'];
            $user_data['city_id'] =  $data['city'];
            $user_data['address'] =  $data['address'];
            $user_data['phone'] =  $data['phone'];
            $user_data['email'] =  $data['email'];
            $user_data['name'] =  $data['name'];
            $user_data['profile_image'] =  $data['profile_image'];
            $user_data['is_active']    =  $data['is_active'];
            $user->update($user_data);
            return redirect()->route('companies.company.index')
                ->with('success_message', trans('companies.model_was_updated'));
    }

    /**
     * Remove the specified company from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $company = Company::where('user_id', $id);
            $company->delete();

            $user = User::findOrFail($id);
            $user->delete();


            return redirect()->route('companies.company.index')
                ->with('success_message', trans('companies.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('companies.unexpected_error')]);
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
            'name' => 'required|string|min:1|max:300',
            'email' => 'required|string|min:1|max:300',
            'phone' => 'required|string|min:1|max:300',
            'password' => 'nullable|string|min:1|max:255',
            'address' => 'required',
            'zipcode' => 'nullable',
            'city' => 'nullable',
            'country' => 'nullable',
            'country_code' => 'nullable',
            'cr_no' => 'nullable',
            'cr_doc' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'is_active' => 'boolean|nullable',
        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
