<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogInfo;
use App\Models\RoleTable;
use App\Models\User;
use App\Models\ExHBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    //Admin list without user and admin
    public function userList() {
        $users = User::whereNotIn('role_id', [1, 2])->latest()->get();
        return view('admin.user.index',compact('users'));
    }
    //Admin registration
    public function userCreate() {
        $roles = RoleTable::whereNotIn('id', [1,2])->get();
        $get_ex_h_branch = ExHBranch::all();

        return view('admin.user.create', [
            'roles' => $roles,
            'get_ex_h_branch' => $get_ex_h_branch,

        ]);
    }
    public function userStore(Request $request){
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'role_id' => 'required',
            'ex_h_branch' => 'required',
            'screenig_permission' => 'required|numeric',
        ],[
            'user_id.required' => 'Please enter user ID',
            'name.required' => 'Please enter name',
            'email.required' => 'Please enter a valid email address',
            'password.required' => 'Please enter password',
            'role_id.required' => 'Please select a user role',
            'ex_h_branch.required' => 'Please, Select a Branch',
            'screenig_permission.required' => 'Enter sanction permission value',
        ]);

        $check_user = User::where('user_id', $request->user_id)->orWhere('email', $request->email)->first();
        if($check_user === null) {
            $user_store = new User();
            $user_store->user_id = $request->input('user_id');
            $user_store->name = $request->input('name');
            $user_store->email = $request->input('email');
            $user_store->password = Hash::make($request->input('password'));
            $user_store->role_id = $request->input('role_id');
            $user_store->house_location = $request->input('ex_h_branch');
            $user_store->screenig_permission = $request->input('screenig_permission');
            $ok = $user_store->save();

            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'User';
                $logData->operation_name = 'User store';
                $logData->status = 'Success';
                $logData->reason = 'User  has been created successfully';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.user_list')->with('message','User has been created successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'User';
                $logData->operation_name = 'User store';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.user_list')->with('message','Something went wrong!!');
            }
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'User';
            $logData->operation_name = 'user store';
            $logData->status = 'Failed';
            $logData->reason = 'Data already Exist';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.user_list')->with('message','Data already exist!!');
        }
    }

    //Update user
    public function userEdit($id) {
        $roles = RoleTable::whereNotIn('id', [1,2])->get();
        $user = User::findOrFail($id);
        $get_ex_h_branch = ExHBranch::all();

        return view('admin.user.edit', [
            'roles' => $roles,
            'user' => $user,
            'get_ex_h_branch' => $get_ex_h_branch,
        ]);
    }
    public function userUpdate(Request $request) {
        $update_id = $request->input('update_id');
        $dataStore = User::findOrFail($update_id);
        $user_update = User::findOrFail($update_id);
        if ($user_update->user_id == $request->user_id || $user_update->email == $request->email) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'User';
            $logData->operation_name = 'User update';
            $logData->status = 'Failed';
            $logData->reason = 'Data already exist';
            $logData->previous_data = json_encode($dataStore);
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.user_list')->with('message','Data already exist!!');
        } else {
            $user_update = User::findOrFail($update_id);
            $user_update->user_id = $request->input('user_id');
            $user_update->name = $request->input('name');
            $user_update->email = $request->input('email');
            $user_update->role_id = $request->input('role_id');
            $user_update->house_location = $request->input('ex_h_branch');
            $user_update->screenig_permission = $request->input('screenig_permission');
            $ok = $user_update->save();
            if ($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'User';
                $logData->operation_name = 'User authorize';
                $logData->status = 'Success';
                $logData->reason = 'User is being authorized successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.user_list')->with('message','User has been updated successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'User';
                $logData->operation_name = 'User update';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.user_list')->with('message','Something went wrong!!');
            }
        }
    }

    //Active user
    public function activeUser($id){
        $dataStore = User::findOrFail($id);
        $ok = User::findOrFail($id)->update(['status' => 1, 'auth_date' => now()]);
        if($ok == true) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'User';
            $logData->operation_name = 'User authorize';
            $logData->status = 'Success';
            $logData->reason = 'User is being authorized successfully';
            $logData->previous_data = json_encode($dataStore);
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.user_list')->with('message','User is being authorized successfully!!');
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'User';
            $logData->operation_name = 'User authorize';
            $logData->status = 'Failed';
            $logData->reason = 'Something went wrong';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.user_list')->with('message','Something went wrong!!');
        }
    }

    //Deactivate user
    public function inactiveUser($id){
        $dataStore = User::findOrFail($id);
        $ok = User::findOrFail($id)->update(['status' => 2,'auth_date' => now()]);
        if($ok == true) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'User';
            $logData->operation_name = 'User decline';
            $logData->status = 'Success';
            $logData->reason = 'User is being declined successfully';
            $logData->previous_data = json_encode($dataStore);
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.user_list')->with('message','User is being declined successfully!!');
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'User';
            $logData->operation_name = 'User decline';
            $logData->status = 'Failed';
            $logData->reason = 'Something went wrong';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.user_list')->with('message','Something went wrong!!');
        }
    }
}
