<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class CitiesController extends Controller
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
     * Display a listing of the cities.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
        * Ajax call by datatable for listing of the cities.
        */
        if ($request->ajax()) {
            $data = City::latest()->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($city){
                        return view('cities.datatable', compact('city'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $cities = City::with('country')->paginate(25);

        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new city.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::pluck('name','id')->all();

        return view('cities.create', compact('countries'));
    }

    /**
     * Store a new city in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            City::create($data);

            return redirect()->route('cities.city.index')
                ->with('success_message', trans('cities.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('cities.unexpected_error')]);
        }
    }

    /**
     * Display the specified city.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $city = City::with('country')->findOrFail($id);

        return view('cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified city.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);
        $countries = Country::pluck('name','id')->all();

        return view('cities.edit', compact('city','countries'));
    }

    /**
     * Update the specified city in the storage.
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
            
            $city = City::findOrFail($id);
            $city->update($data);

            return redirect()->route('cities.city.index')
                ->with('success_message', trans('cities.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('cities.unexpected_error')]);
        }
    }

    /**
     * Remove the specified city from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();

            return redirect()->route('cities.city.index')
                ->with('success_message', trans('cities.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('cities.unexpected_error')]);
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
                'name' => 'string|min:1|max:255|nullable',
            'country_id' => 'numeric|min:0|max:4294967295|nullable',
            'is_active' => 'boolean|nullable', 
        ];
        
        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
