<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\UserType;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use DataTables;

class ComplaintsController extends Controller
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
            $data = Complaint::with('service','from_user','against_user','trip')->latest()->get();
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('user_type') && $request->get('user_type')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                //return Str::contains($row['phone'], $request->get('phone')) ? true : false;
                                return $row['from_user_type'] == $request->get('user_type');
                            });
                        }
                        if ($request->has('service') && $request->get('service')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                //return Str::contains($row['phone'], $request->get('phone')) ? true : false;
                                return $row['service_id'] == $request->get('service');
                            });
                        }      
                        if ($request->has('status') && $request->get('status')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                //return Str::contains($row['phone'], $request->get('phone')) ? true : false;
                                return $row['status'] == $request->get('status');
                            });
                        }     
                        if ($request->has('keyword') && $request->get('keyword')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['from_user']['name'].$row['against_user']['name'].$row['trip']['trip_no'].$row['complaint_no']), Str::lower($request->get('keyword'))) ? true : false;
                            });
                        }                                                              
                    })            
                    ->addIndexColumn()
                    ->addColumn('action', function($complaint){
                        return view('complaints.datatable', compact('complaint'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }
        $user_type = UserType::pluck('user_type','id')->all();
        $service = Service::whereIn('id',['1','2'])->pluck('service','id')->all();
        $status = ['New' => 'New','Read'=>'Read','Processing'=>'Processing','Solved' => 'Solved'];
        $complaint = Complaint::paginate(25);

        return view('complaints.index', compact('complaint','user_type','service','status'));
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
        $complaint = Complaint::findOrFail($id);
        if($complaint->status == 'New'){
            $complaint->status = 'Read';
            $complaint->save();
        }
        
        return view('complaints.show', compact('complaint'));
    }

 

    /**
     * Remove the specified complaint from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $complaint = Complaint::findOrFail($id);
            $complaint->delete();

            return redirect()->route('complaint.index')
                ->with('success_message', trans('complaints.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('complaints.unexpected_error')]);
        }
    }

    /**
     * Get the change status.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    public function change_status(Request $request){

        $complaint = Complaint::findOrFail($request->id);
        $complaint->status = $request->status;
        $complaint->save();
        return response()->json(['status'=>true]); 
    }

}
