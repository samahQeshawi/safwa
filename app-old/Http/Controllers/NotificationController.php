<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use Auth;

class NotificationController extends Controller
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
        * Ajax call by datatable for listing of the car make.
        */
        if ($request->ajax()) {
            $data = Notification::latest()->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($notification){
                        return view('notifications.datatable', compact('notification'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $notification = Notification::paginate(25);

        return view('notifications.index', compact('notification'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {


        return view('notifications.create');
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

            Notification::create($data);

            return redirect()->route('notification.index')
                ->with('success_message', trans('notification.model_was_added'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('notification.unexpected_error')]);
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
        $notification = Notification::findOrFail($id);

        return view('notifications.show', compact('notification'));
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
        $notification = Notification::findOrFail($id);


        return view('notifications.edit', compact('notification'));
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

            $notification = Notification::findOrFail($id);
            $notification->update($data);

            return redirect()->route('notification.index')
                ->with('success_message', trans('notification.model_was_updated'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('notification.unexpected_error')]);
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
            $notification = Notification::findOrFail($id);
            $notification->delete();

            return redirect()->route('notification.index')
                ->with('success_message', trans('notification.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('notification.unexpected_error')]);
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
                'title' => 'string|min:1|nullable',
                'body' => 'string|min:1|nullable',
            'is_active' => 'boolean|nullable',
        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }
    /**
     * Get the send message.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */

    public function  send(Request $request,$id){
        if($id) {
            $notification = Notification::findOrFail($id);
            return view('notifications.send', compact('notification'));
        } else {
            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('notification.unexpected_error')]);
        }
    }
    /**
     * send notification.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function send_notification(Request $request) {
        //$data['']
        //NotificationDetail::create($data);
        $rules = [
        'notification_id' => 'required',
        'send_as'   => 'required',
        ];
        $data = $request->validate($rules);
        if(isset($request->all_users)){
            $details['notification_id'] = $data['notification_id'];
            $details['format'] = $data['send_as'];
            $details['user_type_id'] = 0;
            $details['user_id'] = 0;
            $details['sent_by'] = Auth::id();
            $user = User::all();
            NotificationDetail::create($details);
            return redirect()->route('notification.index')
                    ->with('success_message', trans('notification.notification_sent'));
        } else if(!empty($request->all_user_type)) {
            foreach($request->all_user_type as $user_type){
                $details['notification_id'] = $data['notification_id'];
                $details['format'] = $data['send_as'];
                $details['user_type_id'] = $user_type;
                $details['user_id'] = 0;
                $details['sent_by'] = Auth::id();
                $user = User::where('user_type_id',$details['user_type_id'])->get();
                NotificationDetail::create($details);
            }
            return redirect()->route('notification.index')
                    ->with('success_message', trans('notification.notification_sent'));
        } else if(!empty($request->send_to)) {
            foreach($request->send_to as $id){
                $user = User::findOrFail($id);
                $details['notification_id'] = $data['notification_id'];
                $details['format'] = $data['send_as'];
                $details['user_type_id'] = $user->user_type_id;
                $details['user_id'] = $user->id;
                $details['sent_by'] = Auth::id();
                if($details['format'] == 'sms'){
                    NotificationDetail::create($details);
                } else if ($details['format'] == 'push_notification') {
                     NotificationDetail::create($details);
                }
            }
            return redirect()->route('notification.index')
                ->with('success_message', trans('notification.notification_sent'));
       } else {
            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('notification.unexpected_error')]);
       }
    }
    /**
     * get users.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return json
     */
    public function getUser(Request $request){
        $list_users = [];
        if($request->has('q')){
            $search = $request->q;
            $list_users =User::select("id", "name")
                    ->where('name', 'LIKE', "%$search%")
                    ->where('user_type_id','!=','1')
                    ->get();
        }
        return response()->json($list_users);

    }

    public function send_sms($id,$notification) {
            $tophone =  $id;
            $notification = Notification::findOrFail($notification);
            $body = strip_tags($notification['body']);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, TRUE);

            //$fields = json_encode(['userName' => 'Ghorm', 'numbers' => $tophone,'userSender' => 'Darlana','apiKey' => '5b8c561edecb39e06ac46393164177ee','msg' => $body]);
            $fields = json_encode(['userName' => 'SAFWA GROUP', 'numbers' => $tophone, 'userSender' => 'SAFWA', 'apiKey' => 'a3f01ee42eeaedb609a62fd3e509c9dc', 'msg' => $body]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Content-Type: application/json",));

            $response = curl_exec($ch);

            if ($response === false) {
                $response = curl_error($ch);
                return true;
            } else {
                return false;
            }
    }
}
