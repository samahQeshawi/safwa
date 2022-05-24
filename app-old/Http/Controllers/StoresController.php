<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Store;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class StoresController extends Controller
{

    /**
     * Display a listing of the stores.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
        * Ajax call by datatable for listing of the stores.
        */
        if ($request->ajax()) {
            $data = Store::with('company')->get();


            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    /*->addColumn('status', function($store){
                        return view('stores.status', compact('store'));
                    })*/
                    ->addColumn('action', function($store){
                        return view('stores.datatable', compact('store'));
                    })
                    //->rawColumns(['status','action'])
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $stores = Store::with('company')->paginate(25);

        return view('stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new store.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $companies = Company::pluck('name','id')->all();

        return view('stores.create', compact('companies'));
    }

    /**
     * Store a new store in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);

            Store::create($data);

            return redirect()->route('stores.store.index')
                ->with('success_message', trans('stores.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('stores.unexpected_error')]);
        }
    }

    /**
     * Display the specified store.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $store = Store::with('company')->findOrFail($id);

        return view('stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified store.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        $companies = Company::pluck('name','id')->all();

        return view('stores.edit', compact('store','companies'));
    }

    /**
     * Update the specified store in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        try {
            if ($request->has('status')){
                $data['is_active'] = 1;
            }else{
                $data = $this->getData($request);
            }
            $store = Store::findOrFail($id);
            $store->update($data);

            return redirect()->route('stores.store.index')
                ->with('success_message', trans('stores.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('stores.unexpected_error')]);
        }
    }

    /**
     * Remove the specified store from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $store = Store::findOrFail($id);
            $store->delete();

            return redirect()->route('stores.store.index')
                ->with('success_message', trans('stores.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('stores.unexpected_error')]);
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
                'name' => 'string|min:1|max:255',
            'phone' => 'string|min:1|nullable',
            'address' => 'string|min:1|nullable',
            'company_id' => 'required',
            'is_active' => 'boolean',
        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
