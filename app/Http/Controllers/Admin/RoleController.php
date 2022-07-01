<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogInfo;
use App\Models\RoleTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = RoleTable::whereNotIn('id', [1,2])->get();
        return view('admin.role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'role_name' => 'required|min:3|max:150|regex:/[a-zA-Z0-9\s]+/'
        ],[
            'role_name.required' => 'Enter role name',
        ]);
        $role_check = RoleTable::where('role_name', $request->role_name)->first();
        if($role_check === null) {
            $role = new RoleTable();
            $role->role_name = $request->role_name;
            $role->created_by = Auth::user()->user_id;
            $ok = $role->save();
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'RoleTable';
                $logData->operation_name = 'Role store';
                $logData->status = 'Success';
                $logData->reason = 'Role  has been created successfully';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('role.index')->with('message','Role  has been created successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'RoleTable';
                $logData->operation_name = 'Role store';
                $logData->status = 'Failed';
                $logData->reason = 'Data already Exist';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('role.index')->with('message','Something went wrong!!');
            }
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'RoleTable';
            $logData->operation_name = 'Role store';
            $logData->status = 'Failed';
            $logData->reason = 'Data already Exist';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('role.index')->with('message','Data already exist!!');
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
        $role = RoleTable::findOrFail($id);
        return view('admin.role.edit', [
            'role' => $role
        ]);

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
            'role_name' => 'required|min:3|max:150|regex:/[a-zA-Z0-9\s]+/'
        ],[
            'role_name.required' => 'Enter role name',
        ]);
        $role_check = RoleTable::where('role_name', $request->role_name)->first();
        if($role_check === null) {
            $dataStore = RoleTable::findOrFail($id);
            $ok = RoleTable::where('id', $id)->update([
                "role_name" => $request->role_name,
                "created_by" => Auth::user()->user_id,
            ]);
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'RoleTable';
                $logData->operation_name = 'Role update';
                $logData->status = 'Success';
                $logData->reason = 'Role Info has been updated successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('role.index')->with('message','Role has been updated successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'RoleTable';
                $logData->operation_name = 'Role update';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('role.index')->with('message','Something went wrong!!');
            }
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'RoleTable';
            $logData->operation_name = 'Role update';
            $logData->status = 'Failed';
            $logData->reason = 'Data already exist';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('role.index')->with('message','Data already exist!!');
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
        $dataStore = RoleTable::findOrFail($id);
        $ok = RoleTable::findOrFail($id)->delete();
        if ($ok == true) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'RoleTable';
            $logData->operation_name = 'Role delete';
            $logData->status = 'Success';
            $logData->reason = 'Role Info has been deleted successfully';
            $logData->previous_data = json_encode($dataStore);
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('role.index')->with('message', 'Role has been deleted successfully!!');
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'RoleTable';
            $logData->operation_name = 'Role delete';
            $logData->status = 'Failed';
            $logData->reason = 'Something went wrong';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('role.index')->with('message', 'Something went wrong!!');
        }
    }
}
