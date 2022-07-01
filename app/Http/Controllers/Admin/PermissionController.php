<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogInfo;
use App\Models\Permission;
use App\Models\RoleTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::whereNotIn('role_id', [1,2])->with('role')->get();
        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = RoleTable::whereNotIn('id', [1,2])->get();
        return view('admin.permission.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|numeric|unique:permissions,role_id'
        ], [
            'role_id.required' => 'Select a role',
        ]);
        $ok = Permission::create($request->all());
        if($ok == true) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'Permission';
            $logData->operation_name = 'Permission store';
            $logData->status = 'Success';
            $logData->reason = 'Permission has been created successfully';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('permission.index')->with('message','Permission has been created successfully!!');
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'Permission';
            $logData->operation_name = 'Permission store';
            $logData->status = 'Failed';
            $logData->reason = 'Something went wrong';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('permission.index')->with('message', 'Something went wrong!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $roles = RoleTable::whereNotIn('id', [1,2])->get();
        return view('admin.permission.edit',compact('permission','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:permissions,role_id'
        ]);
        $dataStore = Permission::findOrFail($id);
        $ok = Permission::findOrFail($id)->update($request->all());
        if($ok == true) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'Permission';
            $logData->operation_name = 'Permission update';
            $logData->status = 'Success';
            $logData->reason = 'Permission has been created successfully';
            $logData->previous_data = json_encode($dataStore);
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('permission.index')->with('message','Permission has been update successfully!!');
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'Permission';
            $logData->operation_name = 'Permission update';
            $logData->status = 'Failed';
            $logData->reason = 'Something went wrong';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('permission.index')->with('message', 'Something went wrong!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataStore = Permission::findOrFail($id);
        $ok = permission::findOrFail($id)->delete();
        if($ok == true) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'Permission';
            $logData->operation_name = 'Permission delete';
            $logData->status = 'Success';
            $logData->reason = 'Permission has been delete successfully';
            $logData->previous_data = json_encode($dataStore);
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('permission.index')->with('message','Permission has been delete successfully!!');
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'Permission';
            $logData->operation_name = 'Permission delete';
            $logData->status = 'Failed';
            $logData->reason = 'Something went wrong';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('permission.index')->with('message', 'Something went wrong!!');
        }
    }
}
