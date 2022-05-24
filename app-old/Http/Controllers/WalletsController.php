<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\User;
use App\Models\UserType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;
use DataTables;

class WalletsController extends Controller
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
    public function index(Request $request,$utype=0)
    {

        /**
        * Ajax call by datatable for listing of the wallets.
        */
        if ($request->ajax()) {
            if($utype) {
                $data = Wallet::with('user.userType')->with('user')->where('user_type',$utype)->orderBy('id','desc')->get()->whereNotNull('user.id');//Get the customers wallets
            } else {
                $data = Wallet::with('user.userType')->with('user')->orderBy('id','desc')->get()->whereNotNull('user.id');
            }
            //$data3 = array_merge($data1,$data2);
            $datatable =  DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if ($request->has('user_type') && $request->get('user_type')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                //return Str::contains($row['phone'], $request->get('phone')) ? true : false;
                                return $row['user_type'] == $request->get('user_type');
                            });
                        }
                        if ($request->input('search.value') != "") {
                             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['user']['name'], $request->input('search.value')) ? true : false;
                            });
                        }
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function($wallet){
                        return view('wallet.datatable', compact('wallet'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $wallet = Wallet::paginate(25);
        $user_type = UserType::pluck('user_type','id')->all();
        return view('wallet.index', compact('wallet','user_type','utype'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create(Request $request)
    {
       // $users = User::whereIn('user_type_id',array('3','4','5'))->pluck('name','id')->all();
        //return view('wallet.create',compact('users'));
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
        /*try {

            $data = $this->getData($request);

            Wallet::create($data);

            return redirect()->route('wallet.index')
                ->with('success_message', trans('wallet.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('wallet.unexpected_error')]);
        }*/
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
        $wallet = Wallet::with('user.userType')->findOrFail($id);

        return view('wallet.show', compact('wallet'));
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
                'amount' => 'numeric|min:1|required',
                'user_type' => 'numeric|min:1|required',
                 'is_active' => 'boolean|nullable',
        ];

        $data = $request->validate($rules);
        $data['is_active'] = $request->has('is_active');
        return $data;
    }

    public function addWalletAmount(Request $request) {

        $rules = [
            'amount' => 'required',
            'user_id' => 'numeric|min:1|required',
            'note'=>'nullable',
        ];
        $data = $request->validate($rules);
        $wallet = Wallet::where('user_id',$data['user_id'])->first();
        $wallet->amount = $wallet->amount + $data['amount'];
        $wallet->save();
        $data['sender_id'] =  0;
        $data['done_by'] = Auth::id();
        $data['receiver_id'] = $data['user_id'];
        $data['amount'] = $data['amount'];
        $data['note'] = $data['note'];
        Transaction::create($data);
        $status = array('status' => 'true','amount' => $wallet->amount);
         return response()->json($status);
    }
    public function subtractWalletAmount(Request $request) {

        $rules = [
            'amount' => 'required',
            'user_id' => 'numeric|min:1|required',
            'note'=>'nullable',
        ];
        $data = $request->validate($rules);
        $wallet = Wallet::where('user_id',$data['user_id'])->first();
        $wallet->amount = $wallet->amount - $data['amount'];
        $wallet->save();
        $data['sender_id'] =  $data['user_id'];
        $data['done_by'] = Auth::id();
        $data['receiver_id'] = 0;
        $data['amount'] = $data['amount'];
        $data['note'] = $data['note'];
        Transaction::create($data);
        $status = array('status' => 'true','amount' => $wallet->amount);
         return response()->json($status);
    }
}
