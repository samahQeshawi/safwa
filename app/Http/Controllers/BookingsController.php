<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Exports\InvoicesExport;
use App\Models\Booking;
use App\Models\User;
use App\Models\CarType;
use App\Mail\BookingEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Exception;
use DataTables;
use PDF;

class BookingsController extends Controller
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
            $data = Booking::with('customer')->latest()->get();
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('car_type') && $request->get('car_type')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['car_type_id'] == $request->get('car_type');
                            });
                        }
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['booking_no']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }
                        if ($request->has('start_date') && $request->get('start_date')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['start_date'] == $request->get('start_date');
                            });
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function($booking){
                        return view('booking.datatable', compact('booking'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $booking = Booking::paginate(25);
        $car_type =  CarType::pluck('name','id')->all();
        return view('booking.index', compact('booking','car_type'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $driver = User::where('user_type_id',3)->pluck('name','id')->all();
        $customer = User::where('user_type_id',4)->pluck('name','id')->all();
		$cartype = CarType::pluck('name','id')->all();
        return view('booking.create',compact('driver','customer','cartype'));
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

            $data = $this->getData($request);
            $booking = Booking::orderBy('id', 'DESC')->first();
            if($booking) {
                $no_only      = substr($booking->booking_no, 2);
                $idno = ltrim($no_only, '0');
                $booking_no = $idno + 1;

            } else {
                $booking_no = 1;
            }
            $next_number = str_pad($booking_no, 10, "0", STR_PAD_LEFT);
            $data['booking_no'] = 'BK' . $next_number;
            Booking::create($data);

            return redirect()->route('booking.index')
                ->with('success_message', trans('booking.model_was_added'));
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
        $booking = Booking::findOrFail($id);
        return view('booking.show', compact('booking'));
    }

    /**
     * Display the specified Booking invoice.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function showInvoice($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking.invoice', compact('booking'));
    }

    /**
     * Display the specified Booking invoice.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function printInvoice($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking.invoice_print', compact('booking'));
    }

    /**
     * Print the pdf  invoice.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function pdfInvoice($id)
    {
        $data['booking'] = Booking::findOrFail($id);
        //return Excel::download(new InvoicesExport($booking), 'invoice'.time().'.pdf');
        $pdf = PDF::loadView('booking.invoice_pdf', $data);
        return $pdf->download('invoice'.time().'.pdf');
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
        $booking = Booking::findOrFail($id);
        $driver = User::where('user_type_id',3)->pluck('name','id')->all();
        $customer = User::where('user_type_id',4)->pluck('name','id')->all();
		$cartype = CarType::pluck('name','id')->all();
        return view('booking.edit', compact('booking','driver','customer','cartype'));
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

            $booking = Booking::findOrFail($id);
            $booking->update($data);

            return redirect()->route('booking.index')
                ->with('success_message', trans('booking.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('booking.unexpected_error')]);
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
            $booking = Booking::findOrFail($id);
            $booking->delete();

            return redirect()->route('booking.index')
                ->with('success_message', trans('booking.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('booking.unexpected_error')]);
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
            'customer_id' => 'required',
            'start_destination' => 'required',
            'start_latitude' => 'required',
            'start_longitude' => 'required',
            'end_destination' => 'required',
            'end_latitude' => 'required',
            'end_longitude' => 'required',
            'distance' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'amount' => 'required',
            'landmark' => 'required',
            'start_address' => 'required',
            'car_type_id' => 'required',
            'driver_id' => 'required',
            'status'    => 'required',
        ];

        $data = $request->validate($rules);

        return $data;
    }

    public function sendBookingEmail(Request $request){


        $rules = [
            'booking_id' => 'required',
            'email' => 'required',
        ];
        $data = $request->validate($rules);
        $booking['booking'] = Booking::findOrFail($data['booking_id']);
        $email_list = explode(',',$data['email']);
        foreach($email_list as $to_email){
            $to_email = trim($to_email);
            Mail::to($to_email)->send(new BookingEmail($booking));
        }
        $status = array('status' => 'true');
         return response()->json($status);

    }
}
