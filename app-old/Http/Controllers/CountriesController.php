<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class CountriesController extends Controller
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
     * Display a listing of the countries.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
        * Ajax call by datatable for listing of the countries.
        */
        if ($request->ajax()) {
            $data = Country::latest()->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($country){
                        return view('countries.datatable', compact('country'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $countries = Country::paginate(25);

        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new country.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        

        return view('countries.create');
    }

    /**
     * Store a new country in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Country::create($data);

            return redirect()->route('countries.country.index')
                ->with('success_message', trans('countries.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('countries.unexpected_error')]);
        }
    }

    /**
     * Display the specified country.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $country = Country::findOrFail($id);

        return view('countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified country.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);
        

        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified country in the storage.
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
            
            $country = Country::findOrFail($id);
            $country->update($data);

            return redirect()->route('countries.country.index')
                ->with('success_message', trans('countries.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('countries.unexpected_error')]);
        }
    }

    /**
     * Remove the specified country from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $country = Country::findOrFail($id);
            $country->delete();

            return redirect()->route('countries.country.index')
                ->with('success_message', trans('countries.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('countries.unexpected_error')]);
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
            'code' => 'string|min:1|nullable',
            'phone_code' => 'string|min:1|nullable',
            'nationality' => 'string|min:1|nullable',
            'is_active' => 'boolean|nullable', 
        ];
        
        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
