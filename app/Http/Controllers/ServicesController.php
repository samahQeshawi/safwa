<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class ServicesController extends Controller
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
     * Display a listing of the services.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
        * Ajax call by datatable for listing of the services.
        */
        if ($request->ajax()) {
            $data = Service::latest()->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($service){
                        return view('services.datatable', compact('service'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $services = Service::paginate(25);

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {


        return view('services.create');
    }

    /**
     * Store a new service in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);
            if($request->hasFile('service_image')) {

                $service_image_path = $request->file('service_image')->store('services');
                $data['service_image'] =  $service_image_path;
            }
            Service::create($data);

            return redirect()->route('services.service.index')
                ->with('success_message', trans('services.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('services.unexpected_error')]);
        }
    }

    /**
     * Display the specified service.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);


        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified service in the storage.
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

            $service = Service::findOrFail($id);
            if($request->hasFile('service_image')) {

                $service_image_path = $request->file('service_image')->store('services');
                $data['service_image'] =  $service_image_path;
            } else {
                $data['service_image'] =   $service->service_image;
            }
            $service->update($data);

            return redirect()->route('services.service.index')
                ->with('success_message', trans('services.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('services.unexpected_error')]);
        }
    }

    /**
     * Remove the specified service from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();

            return redirect()->route('services.service.index')
                ->with('success_message', trans('services.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('services.unexpected_error')]);
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
                'service' => 'required|string|min:1|max:255',
                'service_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'is_active' => 'boolean|nullable',
        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
