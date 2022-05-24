<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use DataTables;

class TransactionsController extends Controller
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
         * Ajax call by datatable for listing of the transaction.
         */
        if ($request->ajax()) {
            $data = Transaction::leftJoin('bookings', 'bookings.id', '=', 'transactions.booking_id')->with('receiver', 'sender')->select('transactions.*','bookings.booking_no')->get();
            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {                    
                    if ($request->has('sender') && $request->get('sender')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            //return Str::contains($row['phone'], $request->get('phone')) ? true : false;
                            return $row['sender_id'] == $request->get('sender');
                        });
                    }                                                            
                })            
                ->addIndexColumn()
                ->addColumn('action', function ($transaction) {
                    return view('transaction.datatable', compact('transaction'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }

        $transaction = Transaction::paginate(25);
        $user_list = User::pluck("name","id")->all();
        return view('transaction.index', compact('transaction','user_list'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {

        //$driver = User::join('drivers', 'drivers.user_id', '=', 'users.id')->where('user_type_id',3)->pluck('users.name','drivers.id')->all();
        //$customer = User::join('customers', 'customers.user_id', '=', 'users.id')->where('user_type_id',4)->pluck('users.name','customers.id')->all();
        $sender = $receiver = User::pluck('name', 'id')->all();
        return view('transaction.create', compact('sender', 'receiver'));
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
            $data['done_by'] = Auth::id();
            Transaction::create($data);

            return redirect()->route('transaction.index')
                ->with('success_message', trans('transaction.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('transaction.unexpected_error')]);
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
        $transaction = Transaction::with('sender', 'receiver')->findOrFail($id);

        return view('transaction.show', compact('transaction'));
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
        $transaction = Transaction::with('receiver', 'sender')->findOrFail($id);
        $sender = $receiver = User::pluck('name', 'id')->all();
        return view('transaction.edit', compact('transaction', 'sender', 'receiver'));
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
            $data['done_by'] = Auth::id();
            $transaction = Transaction::findOrFail($id);
            $transaction->update($data);

            return redirect()->route('transaction.index')
                ->with('success_message', trans('transaction.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('transaction.unexpected_error')]);
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
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();

            return redirect()->route('transaction.index')
                ->with('success_message', trans('transaction.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('transaction.unexpected_error')]);
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
            'sender_id' => 'numeric|required',
            'receiver_id' => 'numeric|required',
            'booking_id' => 'numeric|nullable',
            'amount' => 'numeric|required',
            'note' => "nullable"
        ];

        $data = $request->validate($rules);

        return $data;
    }

    public function getBooking(Request $request)
    {
        $booking = [];
        if ($request->has('q')) {
            $search = $request->q;
            $booking = Booking::select('id', 'booking_no')
                ->where('id', 'LIKE', "%$search%")
                ->orWhere('booking_no', 'LIKE', "%$search%")
                ->orWhere('start_destination', 'LIKE', "%$search%")
                ->orWhere('end_destination', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($booking);
    }

    public function getTrip(Request $request)
    {
        $trip = [];
        if ($request->has('q')) {
            $search = $request->q;
            $trip = Trip::select('id', 'trip_no')
                ->where('id', 'LIKE', "%$search%")
                ->orWhere('trip_no', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($trip);
    }
    public function getSender(Request $request)
    {
        $sender = [];
        if ($request->has('q')) {
            $search = $request->q;
            $sender = User::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($sender);
    }
    public function getReceiver(Request $request)
    {
        $receiver = [];
        if ($request->has('q')) {
            $search = $request->q;
            $receiver = User::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($receiver);
    }
    public function getBookingRequest(Request $request)
    {
        $booking_data = [];
        if ($request->has('id')) {
            $booking = Booking::with('customer.user', 'driver.user')
                ->where('id',  $request->id)
                ->first();

            $booking_data = array('id' => $booking->id, 'booking_no' => $booking->booking_no, 'customer_id' => $booking->customer->user->id, 'customer_name' => $booking->customer->user->name, 'driver_id' => $booking->driver->user->id, 'driver_name' => $booking->driver->user->name);
        }
        return response()->json($booking_data);
    }
}
