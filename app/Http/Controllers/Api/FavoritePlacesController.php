<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoritePlacesResource;
use App\Models\FavoritePlace;
use App\Models\Direction;
use Exception;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FavoritePlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*  public function index()
    {
        $favorite_places   = FavoritePlace::all();
        $data    = [
            'favorite_places' => FavoritePlacesResource::collection($favorite_places)
        ];
        $message = 'Favorite Places retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    } */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function myFavoritePlaces()
    public function index()
    {

        $user_id = auth()->user()->id;
        $favorite_places   = FavoritePlace::where('user_id', $user_id)->get();
        $data    = [
            'favorite_places' => FavoritePlacesResource::collection($favorite_places)
        ];
        $message = 'Favorite Places retrieved successfully';
        $status_code    = 200;
        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $favoriteData   =   $data   =   $request->all();
        $favoriteData['user_id'] = auth()->user()->id;
        $data   =   $favoriteData;
        $rules = [
            'title' => 'required|string|min:1|max:300',
            'address' => 'required|string',
            'location' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   'Validation Error';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        //location as Point
        $location   = '';
        $latitude   =   $request->latitude ? $favoriteData['latitude'] : '';
        $longitude  =   $request->longitude ? $favoriteData['longitude'] : '';
        if (isset($latitude) && isset($longitude)) {
            $location = new Point($latitude, $longitude);    // (lat, lng)
        }
        unset($favoriteData['latitude']);
        unset($favoriteData['longitude']);
        unset($favoriteData['location']);
        //FavoritePlace::create($data);
        $favorite_places_id = DB::table('favorite_places')->insertGetId($favoriteData);
        $favorite = FavoritePlace::find($favorite_places_id);
        //if (isset($favoriteData['latitude']) && isset($favoriteData['longitude'])) {
        if (isset($latitude) && isset($longitude)) {
            $favorite->location = $location;    // (lat, lng)
            $favorite->save();
        }

        $data   = $favorite;
        $message    =   'Favorite Places added successfully!';
        $status_code   = 200;


        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FavoritePlace  $favorite_places
     * @return \Illuminate\Http\Response
     */
    public function show(FavoritePlace $favorite_places)
    {

        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FavoritePlace  $favorite_places
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FavoritePlace $favorite_places)
    {


        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FavoritePlace  $favorite_places
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavoritePlace $favorite_places)
    {
        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
    }

    public function delete_favorite_place(Request $request)
    {
        $rules = [
            'id'       => 'required|numeric',
        ];

        $errors =   [];
        $validatedData = $request->all();

        $validator = Validator::make($validatedData, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   'Validation Error!';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }

        $FavoritePlace = FavoritePlace::find($request->id);
        $user_id = auth()->user()->id;
        $favorite_places   = FavoritePlace::where('user_id', $user_id)->get();
        $data    = [
            'favorite_places' => FavoritePlacesResource::collection($favorite_places)
        ];
        if ($FavoritePlace) {
            // try {
            $FavoritePlace->delete($request->id);
            $favorite_places   = FavoritePlace::where('user_id', $user_id)->get();
            $data    = [
                'favorite_places' => FavoritePlacesResource::collection($favorite_places)
            ];
            $message = 'Favorite Places deleted successfully';
            $status_code    = 200;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            //return response(['message' => $message, 'status_code' => $status_code]);
            /* } catch (\Exception $exception) {
                return response()->json(['status_code' => 401, 'error' => $exception->getMessage()]);
            }*/
        } else {
            $status_code = 401;
            $message = 'Data Not Found';
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
            //return response()->json(['status_code' => $status_code, 'error' => $error]);
        }
    }

    public function directions(Request $request)
    {
        $directions  =   $request->all();
        $rules = [
            'from_lat' => 'required',
            'from_long' => 'required',
            'to_lat' => 'required',
            'to_long' => 'required',
        ];
        $validator = Validator::make($directions, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $data   = null;
            $message    =   'Validation Error';
            $status_code   = 422;
            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code, 'errors' => $errors]);
        }
        $direction_data = Direction::where('from_lat', $directions['from_lat'])
            ->where('from_long', $directions['from_long'])
            ->where('to_lat', $directions['to_lat'])
            ->where('to_long', $directions['to_long'])->first();
        if ($direction_data) {
            $direction_data['direction'] = json_decode($direction_data['direction']);
            $data   = $direction_data;
            $message    =   'Direction Data';
            $status_code   = 200;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        } else {
            $direction_url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $directions['from_lat'] . "," . $directions['from_long'] . "&destination=" . $directions['to_lat'] . "," . $directions['to_long'] . "&key=" . env('GOOGLE_CLOUD_KEY');

            $direction_details = file_get_contents($direction_url);
            $directions['direction'] = $direction_details;
            $direction_data = Direction::create($directions);
            $direction_data['direction'] = json_decode($direction_data['direction']);
            $data   = $direction_data;
            $message    =   'Direction Data';
            $status_code   = 200;

            return response(['data' => $data, 'message' => $message, 'status_code' => $status_code]);
        }
    }
}
