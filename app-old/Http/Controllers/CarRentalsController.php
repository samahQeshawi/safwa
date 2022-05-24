<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarRental;
use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Exception;
use DataTables;
use PDF;

class CarRentalsController extends Controller
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
            $data = CarRental::with('user')->latest()->get();
            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['booking_no']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($car_rental) {
                    return view('car_rentals.datatable', compact('car_rental'));
                })
                ->rawColumns(['action'])
                ->editColumn('payment_status', function ($data) {
                    return $data->payment_status ? 'Paid' : 'Not Paid';
                })
                ->make(true);
            return $datatable;
        }

        $car_rental = CarRental::paginate(25);
        return view('car_rentals.index', compact('car_rental'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $users = User::active()->where('user_type_id', '4')->pluck('name', 'id')->all();
        $cars = Car::where('service_id', '3')->pluck('car_name', 'id')->all();
        return view('car_rentals.create', compact('users', 'cars'));
    }

    /**
     * Find the total rent.
     *
     * @return Amount Decimal
     */
    public function calculateCarRent($car, $days)
    {
        $carObj =   Car::where('id', $car)->first();
        $amount =   0;
        $years  =   floor($days / 365);
        $amount +=  $years * $carObj->rent_yearly;
        $days   =   $days - $years * 365;
        $months =   floor($days / 30);
        $amount +=  $months * $carObj->rent_monthly;
        $days   =   $days - $months * 30;
        $weeks  =   floor($days / 7);
        $amount +=  $weeks * $carObj->rent_weekly;
        $days   =   $days - $weeks * 7;
        $amount +=  $days * $carObj->rent_daily;
        return $amount;
    }

    /**
     * Find the total rent.
     *
     * @return Amount Decimal
     */
    public function calculateCarRentByDate(Request $data)
    {
        $from = $data->pickup_on;
        $to = $data->dropoff_on;
        $car_id = $data->car_id;
        $pickup_on = Carbon::parse($from);
        $dropoff_on = Carbon::parse($to);
        $total_days =   $days = $pickup_on->diffInDays($dropoff_on);

        $carObj =   Car::where('id', $car_id)->first();
        $amount =   0;
        $years  =   floor($days / 365);
        $amount +=  $years * $carObj->rent_yearly;
        $days   =   $days - $years * 365;
        $months =   floor($days / 30);
        $amount +=  $months * $carObj->rent_monthly;
        $days   =   $days - $months * 30;
        $weeks  =   floor($days / 7);
        $amount +=  $weeks * $carObj->rent_weekly;
        $days   =   $days - $weeks * 7;
        $amount +=  $days * $carObj->rent_daily;
        return json_encode(['amount' => $amount , 'days' => $total_days]);
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
        $car_rental = CarRental::orderBy('id', 'DESC')->first();
        if ($car_rental) {
            $no_only      = substr($car_rental->booking_no, 2);
            $idno = ltrim($no_only, '0');
            $booking_no = $idno + 1;
        } else {
            $booking_no = 1;
        }
        $next_number = str_pad($booking_no, 10, "0", STR_PAD_LEFT);
        $data['booking_no'] = 'BK' . $next_number;
        $data['discount'] = '0';

        $pickup_on = Carbon::parse($data['pickup_on']);
        $dropoff_on = Carbon::parse($data['dropoff_on']);


        $diff = $pickup_on->diffInDays($dropoff_on);

        $data['amount'] = $this->calculateCarRent($data['car_id'], $diff);
        $data['final_amount'] = $data['amount'];
        $data['payment_status'] = '0';
        CarRental::create($data);

        return redirect()->route('car_rentals.index')
            ->with('success_message', trans('car_rental.model_was_added'));
    }


    /**
     * Display the specified Car Rental.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $car_rental = CarRental::findOrFail($id);
        return view('car_rentals.show', compact('car_rental'));
    }


    /**
     * Display the specified Car Rentals invoice.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function showInvoice($id)
    {
        $car_rental = CarRental::findOrFail($id);
        return view('car_rentals.invoice', compact('car_rental'));
    }

    /**
     * Display the specified CarRental invoice.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function printInvoice($id)
    {
        $car_rental = CarRental::findOrFail($id);
        return view('car_rentals.invoice_print', compact('car_rental'));
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
        $data['car_rental'] = CarRental::findOrFail($id);
        //return Excel::download(new InvoicesExport($booking), 'invoice'.time().'.pdf');
        $pdf = PDF::loadView('car_rentals.invoice_pdf', $data);
        return $pdf->download('invoice' . time() . '.pdf');
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
        $car_rental = CarRental::findOrFail($id);
        $users = User::where('user_type_id', '!=', '1')->pluck('name', 'id')->all();
        $cars = Car::pluck('car_name', 'id')->all();
        return view('car_rentals.edit', compact('car_rental', 'users', 'cars'));
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

            $car_rental = CarRental::findOrFail($id);
            $car_rental->update($data);
            $data['final_amount'] = $car_rental->amount - $car_rental->dscount;
            $car_rental->update($data);
            return redirect()->route('car_rentals.index')
                ->with('success_message', trans('car_rental.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('car_rental.unexpected_error')]);
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
            $car_rental = CarRental::findOrFail($id);
            $car_rental->delete();

            return redirect()->route('car_rentals.index')
                ->with('success_message', trans('car_rental.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('car_rental.unexpected_error')]);
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
            'user_id' => 'required',
            'car_id' => 'required',
            'pickup_on' => 'required',
            'duration_in_days' => 'required',
            'dropoff_on' => 'required',
            'amount' => 'required',
        ];

        $data = $request->validate($rules);

        return $data;
    }
}
