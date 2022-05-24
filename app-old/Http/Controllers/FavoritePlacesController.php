<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FavoritePlace;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;
class FavoritePlacesController extends Controller
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
            $data = FavoritePlace::latest()->get();
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['name'].$row['phone'].$row['email']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                        
                                                       
                    })             
                    ->addIndexColumn()
                    ->addColumn('action', function($favorite_place){
                        return view('favorite_places.datatable', compact('favorite_place'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $favorite_place = FavoritePlace::paginate(25);
        return view('favorite_places.index', compact('favorite_place'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
	   $users = User::where('user_type_id','!=','1')->pluck('name','id')->all();
        return view('favorite_places.create',compact('users'));
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
            $data['user_id'] = Auth::id();
            $data = $this->getData($request);
            //location as Point
            $data['location'] = new Point( $data['latitude'], $data['longitude']);    // (lat, lng)
            $location = $data['location'];
            unset($data['latitude']);
            unset($data['longitude']);           
            unset($data['location']);           
            //FavoritePlace::create($data);
            $favorite_places_id = DB::table('favorite_places')->insertGetId($data);
            $favorite = FavoritePlace::find($favorite_places_id);
            $favorite->location = $location;    // (lat, lng)
            $favorite->save();

            return redirect()->route('favorite_places.index')
                ->with('success_message', trans('branch.model_was_added'));
        /*} catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('branch.unexpected_error')]);
        } */       
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
        $favorite_place = FavoritePlace::findOrFail($id);

        return view('favorite_places.show', compact('favorite_place'));
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
        $favorite_places = FavoritePlace::findOrFail($id);

        $lat = optional($favorite_places->location)->getLat();
        $lng = optional($favorite_places->location)->getLng();
        $favorite_places['latitude'] = $lat;
        $favorite_places['longitude'] = $lng;
        return view('favorite_places.edit', compact('favorite_places'));
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
        

            $data = $this->getData($request);
            $favorite_places = FavoritePlace::findOrFail($id);
           // $data['user_id'] = Auth::id();
            //location as Point
            $data['location'] = new Point( $data['latitude'], $data['longitude']);    // (lat, lng)
            unset($data['latitude']);
            unset($data['latitude']);

            //$data['location']  'Point('.$data['location'].')';
            $favorite_places->update($data);



            return redirect()->route('favorite_places.index')
                ->with('success_message', trans('favorite_places.model_was_updated'));

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
            $favorite_place = FavoritePlace::findOrFail($id);
            $favorite_place->delete();

            return redirect()->route('favorite_places.index')
                ->with('success_message', trans('favorite_places.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('favorite_places.unexpected_error')]);
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
			'title' => 'required|string|min:1|max:300',
            'address' => 'required|string',
            'location'=>'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'user_id'   => 'nullable',
        ];

        $data = $request->validate($rules);

        return $data;
    }
    public function getUser(Request $request)
    {
        $sender = [];
        if ($request->has('q')) {
            $search = $request->q;
            $sender = User::where('name', 'LIKE', "%$search%")->where('user_type_id','!=', '1')->get();
        }
        return response()->json($sender);
    }
}
