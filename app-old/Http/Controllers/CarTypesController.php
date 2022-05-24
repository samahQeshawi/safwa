<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class CarTypesController extends Controller
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
            $data = CarType::latest()->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($cartype){
                        return view('cartype.datatable', compact('cartype'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $cartype = CarType::paginate(25);

        return view('cartype.index', compact('cartype'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        

        return view('cartype.create');
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
            
            CarType::create($data);

            return redirect()->route('cartype.index')
                ->with('success_message', trans('cartype.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('cartype.unexpected_error')]);
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
        $cartype = CarType::findOrFail($id);

        return view('cartype.show', compact('cartype'));
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
        $cartype = CarType::findOrFail($id);
        

        return view('cartype.edit', compact('cartype'));
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
        try {
            
            $data = $this->getData($request);
            
            $cartype = CarType::findOrFail($id);
            $cartype->update($data);

            return redirect()->route('cartype.index')
                ->with('success_message', trans('cartype.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('cartype.unexpected_error')]);
        }
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
            $cartype = CarType::findOrFail($id);
            $cartype->delete();

            return redirect()->route('cartype.index')
                ->with('success_message', trans('cartype.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('cartype.unexpected_error')]);
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
                'name' => 'string|min:1|nullable',
                'seats' => 'numeric|min:1|nullable',
            'is_active' => 'boolean|nullable', 
        ];
        
        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
