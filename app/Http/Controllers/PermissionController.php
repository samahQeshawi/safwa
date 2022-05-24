<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionRoleMaster;
use App\Models\PermissionRole;
use App\Models\Service;
use Illuminate\Http\Request;
use Exception;
use DataTables;

class PermissionController extends Controller
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
        * Ajax call by datatable for listing of the categories.
        */
        if ($request->ajax()) {
            $data = Permission::latest()->get();
            $datatable =  DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($permission){
                        return view('permission.datatable', compact('permission'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            return $datatable;
        }

        $permissions = Permission::paginate(25);

        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new permission.
     *
     * @return Illuminate\View\View
     */
    public function create(Request $request)
    {
        $role_master = PermissionRoleMaster::all();
        return view('permission.create',compact('role_master'));
    }

    /**
     * Store a new permission in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //try {

            $data = $this->getData($request);
            $role_permission = $data['role_permission_id'];
            unset($data['role_permission_id']);
            $permission = Permission::create($data);
            foreach( $role_permission as $key => $per){
                $rolePerm = PermissionRole::where('role_id',$permission->id)->where('role_permission_id',$key)->first();
                if(!empty( $rolePerm)){
                    foreach( $per as $key1 => $val){
                        $rolePerm->{$key1} = $val;  

                        $rolePerm->save();
                    }  
                } else {
                    $rolePerm = new PermissionRole();
                    $rolePerm->role_id = $permission->id;
                    $rolePerm->role_permission_id = $key;
                    foreach( $per as $key1 => $val){
                        $rolePerm->{$key1} = $val;  

                        $rolePerm->save();  
                    }
                    
                }

             //PermissionConfiguration::where('permission_id', $permission->id)->delete();
            }
            return redirect()->route('permission.index')
                ->with('success_message', trans('permission.model_was_added'));
        // } catch (Exception $exception) {

        //     return back()->withInput()
        //         ->withErrors(['unexpected_error' => trans('permission.unexpected_error')]);
        // }
    }

    /**
     * Display the specified permission.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified permission.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        $permission = Permission::findOrFail($id);
        $re_roles = PermissionRole::where('role_id',$id)->get(['role_permission_id','view','add','edit','delete']);
        $permission_roles = [];
        foreach($re_roles as $ro){
                $permission_roles[$ro->role_permission_id] = array(
                    'view' => $ro->view,
                    'add' => $ro->add,
                    'edit' => $ro->edit,
                    'delete' => $ro->delete,

                );
        }
        $role_master = PermissionRoleMaster::all();
        return view('permission.edit', compact('permission','permission_roles','role_master'));
    }

    /**
     * Update the specified permission in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        //try {

            $data = $this->getData($request);
            
            $permission = Permission::findOrFail($id);
            $role_permission = $data['role_permission_id'];
            unset($data['role_permission_id']);
            $permission->update($data);
            PermissionRole::where('role_id',$id)->update(array('view'=>0,'add'=>0,'edit'=>0,'delete'=>0));
            foreach( $role_permission as $key => $per){
                $rolePerm = PermissionRole::where('role_id',$id)->where('role_permission_id',$key)->first();
                if(!empty( $rolePerm)){
                    foreach( $per as $key1 => $val){
                        $rolePerm->{$key1} = $val;  

                        $rolePerm->save();
                    }  
                } else {
                    $rolePerm = new PermissionRole();
                    $rolePerm->role_id = $id;
                    $rolePerm->role_permission_id = $key;
                    foreach( $per as $key1 => $val){
                        $rolePerm->{$key1} = $val;  

                        $rolePerm->save();  
                    }
                    
                }

             //PermissionConfiguration::where('permission_id', $permission->id)->delete();
            }
            return redirect()->route('permission.index')
                ->with('success_message', trans('permission.model_was_updated'));
        // } catch (Exception $exception) {

        //     return back()->withInput()
        //         ->withErrors(['unexpected_error' => trans('categories.unexpected_error')]);
        // }
    }

    /**
     * Remove the specified permission from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            //$delete = PermissionConfiguration::where('permission_id', $permission->id)->delete();
            return redirect()->route('permission.index')
                ->with('success_message', trans('permission.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('permission.unexpected_error')]);
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
                'user_type' => 'required',
                'role_permission_id.*'=> 'nullable'
                
            ];
        $data = $request->validate($rules);


        return $data;
    }

   

}
