<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class PaymentMethodsController extends Controller
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
        * Ajax call by datatable for listing of the paymentmethod.
        */
        if ($request->ajax()) {
            $data = PaymentMethod::latest()->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($paymentmethod){
                        return view('paymentmethod.datatable', compact('paymentmethod'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $paymentmethod = PaymentMethod::paginate(25);

        return view('paymentmethod.index', compact('paymentmethod'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {


        return view('paymentmethod.create');
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
            if($request->hasFile('image_file')) {

                $payment_image_path = $request->file('image_file')->store('payment_method');
                $data['image_file'] =  $payment_image_path;
            }
            PaymentMethod::create($data);

            return redirect()->route('paymentmethod.index')
                ->with('success_message', trans('paymentmethod.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('paymentmethod.unexpected_error')]);
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
        $paymentmethod = PaymentMethod::findOrFail($id);

        return view('paymentmethod.show', compact('paymentmethod'));
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
        $paymentmethod = PaymentMethod::findOrFail($id);


        return view('paymentmethod.edit', compact('paymentmethod'));
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

            $paymentmethod = PaymentMethod::findOrFail($id);
           if($request->hasFile('image_file')) {

                $payment_image_path = $request->file('image_file')->store('payment_method');
                $data['image_file'] =  $payment_image_path;
            }  else {
                $data['image_file'] = $paymentmethod->image_file;
            }
            $paymentmethod->update($data);

            return redirect()->route('paymentmethod.index')
                ->with('success_message', trans('paymentmethod.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('paymentmethod.unexpected_error')]);
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
            $paymentmethod = PaymentMethod::findOrFail($id);
            $paymentmethod->delete();

            return redirect()->route('paymentmethod.index')
                ->with('success_message', trans('paymentmethod.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('paymentmethod.unexpected_error')]);
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
                'image_file' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'is_active' => 'boolean|nullable',
        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
