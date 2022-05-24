<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FuelType;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class FuelTypesController extends Controller
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
     * Display a listing of the fuel types.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
        * Ajax call by datatable for listing of the fuel types.
        */
        if ($request->ajax()) {
            $data = FuelType::latest()->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($fuel_type){
                        return view('fuel_types.datatable', compact('fuel_type'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $fuel_types = FuelType::paginate(25);

        return view('fuel_types.index', compact('fuel_types'));
    }

    /**
     * Show the form for creating a new fuel type.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {


        return view('fuel_types.create');
    }

    /**
     * Store a new fuel type in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);

            FuelType::create($data);

            return redirect()->route('fuel_types.fuel_type.index')
                ->with('success_message', trans('fuel_types.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('fuel_types.unexpected_error')]);
        }
    }

    /**
     * Display the specified fuel type.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $fuelType = FuelType::findOrFail($id);

        return view('fuel_types.show', compact('fuelType'));
    }

    /**
     * Show the form for editing the specified fuel type.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $fuelType = FuelType::findOrFail($id);


        return view('fuel_types.edit', compact('fuelType'));
    }

    /**
     * Update the specified fuel type in the storage.
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

            $fuelType = FuelType::findOrFail($id);
            $fuelType->update($data);

            return redirect()->route('fuel_types.fuel_type.index')
                ->with('success_message', trans('fuel_types.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('fuel_types.unexpected_error')]);
        }
    }

    /**
     * Remove the specified fuel type from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $fuelType = FuelType::findOrFail($id);
            $fuelType->delete();

            return redirect()->route('fuel_types.fuel_type.index')
                ->with('success_message', trans('fuel_types.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('fuel_types.unexpected_error')]);
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
                'fuel_type' => 'required|string|min:1|max:255',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
