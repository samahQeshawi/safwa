<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Branch;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BranchesController extends Controller
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
     * Display a listing of the categories.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the cartype.
         */
        if ($request->ajax()) {
            $data = Branch::latest()->get();
            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('branch_code') && $request->get('branch_code')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return $row['branch_code'] == $request->get('branch_code');
                        });
                    }
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['name'] . $row['phone'] . $row['email']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                    if ($request->has('city') && $request->get('city')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return $row['city_id'] == $request->get('city');
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($branch) {
                    return view('branches.datatable', compact('branch'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }

        $branch = Branch::paginate(25);
        $cities = City::active()->pluck('name', 'id')->all();
        $branch_code = Branch::pluck('branch_code', 'id')->all();
        return view('branches.index', compact('branch', 'cities', 'branch_code'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::active()->pluck('name', 'id')->all();
        $cities = City::active()->pluck('name', 'id')->all();
        $country_code = Country::active()->pluck('phone_code', 'id')->all();
        return view('branches.create', compact('countries', 'cities', 'country_code'));
    }

    /**
     * Store a new category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $data = $this->getData($request);
            //$data['country_code'] =  $data['country_code'];
            //$data['country_id'] =  $data['country'];
            $data['country_id'] =  $data['country_code'];
            $data['city_id'] =  $data['city'];

            if (isset($data['location'])) {
                list($location_latitude, $location_longitude)  =   explode(',', $data['location']);
            }

            unset($data['location']);
            unset($data['country']);
            unset($data['city']);
            unset($data['country_code']);

            $data['service_id'] = 3; //Braches for rent cars
            //Add Branch

            $branch_id = DB::table('branches')->insertGetId($data);

            //Update the point location
            $branch = Branch::find($branch_id);
            //location as Point
            if (isset($location_latitude) && isset($location_longitude)) {
                $branch->location = new Point($location_latitude, $location_longitude);    // (lat, lng)
            }

            $branch->save();

            return redirect()->route('branches.index')
                ->with('success_message', trans('branch.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('branch.unexpected_error')]);
        }
    }

    /**
     * Display the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $branch = Branch::findOrFail($id);

        return view('branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        $countries = Country::active()->pluck('name', 'id')->all();
        $cities = City::active()->pluck('name', 'id')->all();

        $lat = optional($branch->location)->getLat();
        $lng = optional($branch->location)->getLng();
        $branch['latitude'] = $lat;
        $branch['longitude'] = $lng;
        $country_code = Country::active()->pluck('phone_code', 'id')->all();
        return view('branches.edit', compact('branch', 'countries', 'cities', 'country_code'));
    }

    /**
     * Update the specified category in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);
        $branch = Branch::findOrFail($id);
        // $data['country_code'] =  $data['country_code'];
        $data['country_id'] =  $data['country_code'];
        $data['city_id'] =  $data['city'];
        if (isset($data['location'])) {
            list($location_latitude, $location_longitude)  =   explode(',', $data['location']);
        }

        unset($data['location']);
        unset($data['country']);
        unset($data['city']);
        unset($data['country_code']);

        // print_r($data); exit;
        $branch->update($data);

        //$data['service_id'] = 3; //Braches for rent cars
        //Add Branch
        //$branch_id = DB::table('branches')->insertGetId($data);

        //Update the point location
        //$branch = Branch::find($branch_id);
        //location as Point
        if (isset($location_latitude) && isset($location_longitude)) {
            $branch->location = new Point($location_latitude, $location_longitude);    // (lat, lng)
        }

        $branch->save();

        return redirect()->route('branches.index')
            ->with('success_message', trans('branch.model_was_updated'));
    }

    /**
     * Remove the specified category from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->delete();

            return redirect()->route('branches.index')
                ->with('success_message', trans('branch.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('branch.unexpected_error')]);
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
            'branch_code' => 'required|string|min:1|max:50',
            'address' => 'string|nullable',
            'email' => 'required|email|min:1|max:500',
            'phone' => 'required|min:1|max:20',
            'country_code' => 'nullable',
            'country' => 'nullable',
            'city' => 'nullable',
            'zipcode' => 'nullable',
            'location' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'is_active' => 'boolean|nullable',
        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }
}
