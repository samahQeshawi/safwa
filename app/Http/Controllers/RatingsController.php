<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\User;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use DataTables;

class RatingsController extends Controller
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
            $data = Rating::with('trip')->with('ratedBy')->with('ratedFor')->with('doneBy')->get();
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('rated_by') && $request->get('rated_by')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['rated_by'] == $request->get('rated_by');
                            });
                        }
                        if ($request->has('rated_for') && $request->get('rated_for')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['rated_for'] == $request->get('rated_for');
                            });
                        }
                        if ($request->has('trip') && $request->get('trip')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return $row['trip_id'] == $request->get('trip');
                            });
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function($rating){
                        return view('ratings.datatable', compact('rating'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $rating = Rating::paginate(25);
        $users = User::pluck('name','id')->all();
        $trips = Trip::pluck('trip_no','id')->all();
        return view('ratings.index', compact('rating','users','trips'));
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
        $rating = Rating::with('trip')->with('ratedBy')->with('ratedFor.userType')->with('doneBy')->findOrFail($id);

        return view('ratings.show', compact('rating'));
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
        $rating = Rating::findOrFail($id);
        $user = User::pluck('name','id')->all();

        return view('ratings.edit', compact('rating','user'));
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
            if(!empty($data['rated_for'])) {
                $user_rated_for = User::findOrFail($data['rated_for']);
                if($user_rated_for->user_type_id == '3')
                    $data['user_type'] = 'driver';
                else if($user_rated_for->user_type_id == '4')
                     $data['user_type'] = 'customer';
            }
            $rating = Rating::findOrFail($id);
            $data['done_by'] = Auth::id();
            $rating->update($data);

            return redirect()->route('rating.index')
                ->with('success_message', trans('ratings.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('ratings.unexpected_error')]);
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
            $rating = Rating::findOrFail($id);
            $rating->delete();

            return redirect()->route('rating.index')
                ->with('success_message', trans('ratings.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('ratings.unexpected_error')]);
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
                //'trip_id' => 'numeric|required',
                //'user_type' => 'numeric|min:0|max:50|nullable',
                //'rated_by' => 'numeric|required',
                //'rated_for' => 'numeric|required',
                'rating' => 'numeric|required',
                'rating_comment' => 'string|min:1|max:300',
        ];

        $data = $request->validate($rules);

        return $data;
    }

    /**
     * Get the trip from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */

    public function getTrip(Request $request)
    {
        $trip = [];
        if ($request->has('q')) {
            $search = $request->q;
            $booking = Trip::select('id', 'trip_number')
                ->where('id', 'LIKE', "%$search%")
                ->orWhere('trip_number', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($booking);
    }

   /**
     * Get the User from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */

    public function getUser(Request $request)
    {
        $user = [];
        if ($request->has('q')) {
            $search = $request->q;
            $user = User::select('id', 'name')
                ->where('name', 'LIKE', "%$search%")
                ->whereNotIn('user_type_id', ['1','2'])
                ->get();
        }
        return response()->json($user);
    }

}
