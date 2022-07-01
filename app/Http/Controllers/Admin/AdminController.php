<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountOpening;
use App\Models\AgentInfo;
use App\Models\BankInfo;
use App\Models\CountryInfo;
use App\Models\CurrencyInfo;
use App\Models\CurrencyRate;
use App\Models\CustomerInfo;
use App\Models\LogInfo;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        $get_customer_count = CustomerInfo::count();
        $get_account_opening_count = AccountOpening::count();
        $get_transaction_count = Transaction::count();
        $get_authorized_transaction_count = Transaction::where('stLevel',1)->count();
        $get_last_10_authorized_transaction = Transaction::where('stLevel',1)->latest()->limit(10)->get();
        $get_currency_rate_last_10 = CurrencyRate::select('rate_amount','from_currency_id','to_currency_id', 'country_id', 'bank_id')->groupBy('rate_amount')->orderBy('entry_date', 'desc')->limit(10)->get();

        $data = [
            "get_customer_count" => $get_customer_count,
            "get_account_opening_count" => $get_account_opening_count,
            "get_transaction_count" => $get_transaction_count,
            "get_authorized_transaction_count" => $get_authorized_transaction_count,
            "get_last_10_authorized_transaction" => $get_last_10_authorized_transaction,
            "get_currency_rate_last_10" => $get_currency_rate_last_10,
        ];
        return view('admin.home', $data);
    }

    #################### Currency Section #############
    //Currency list
    public function currency_list() {
        $CurrencyInfo = CurrencyInfo::latest()->get();
        $data = [
            "CurrencyInfo" => $CurrencyInfo
        ];
        return view('admin.currency.index', $data);
    }

    //Currency store
    public function currency_store(Request $request) {
        $name = $request->name;
        $currency_code = $request->currency_code;

        $request->validate([
            'name' => 'required',
            'currency_code' => 'required|numeric'
        ],[
            'name.required' => 'Enter currency name',
            'currency_code.required' => 'Currency code must be a numeric value',
        ]);

        $currency_name_check = CurrencyInfo::where('name', $name)->orWhere('code', $currency_code)->first();
        if( $currency_name_check === null) {
            $currency = new CurrencyInfo();
            $currency->name = $request->name;
            $currency->code = $request->currency_code;
            $currency->entry_by = Auth::user()->user_id;
            $currency->entry_date = now();
            $ok = $currency->save();
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyInfo';
                $logData->operation_name = 'Currency store';
                $logData->status = 'Success';
                $logData->reason = 'Currency has been added successfully';
                $logData->previous_data = json_encode($currency);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = $request->ip();
                $logData->save();
                return redirect()->route('admin.currency')->with('message','Currency has been added successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyInfo';
                $logData->operation_name = 'Currency store';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = $request->ip();
                $logData->save();
                return redirect()->route('admin.currency')->with('message','Something went wrong!!');
            }
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CurrencyInfo';
            $logData->operation_name = 'Currency store';
            $logData->status = 'Failed';
            $logData->reason = 'Data already exist';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = $request->ip();
            $logData->save();
            return redirect()->route('admin.currency')->with('message','Data already exist!!');
        }
    }

    //Currency update
    public function currency_edit(Request $request) {
        $currency_id =  $request->id;
        $get_single_data = CurrencyInfo::where('id',$currency_id)->first();
        $data=[
            'get_single_data' => $get_single_data
        ];
        return view('admin.currency.edit', $data);
    }
    public function currency_update(Request $request) {
        $id = $request->hidden_id;
        $name = $request->name;
        $currency_code = $request->currency_code;
        $currency_check = CurrencyInfo::where('name', $request->name)->orWhere('code', $currency_code)->first();

        $request->validate([
            'name' => 'required',
            'currency_code' => 'required|numeric'
        ],[
            'name.required' => 'Enter currency name',
            'currency_code.required' => 'Currency code must be a numeric value',
        ]);
        if($currency_check == null) {
            $dataStore = CurrencyInfo::findOrFail($id);
            $ok = CurrencyInfo::findOrFail($id)->update(['name' => $name, 'code' => $currency_code, 'entry_by' => Auth::user()->user_id, 'entry_date' => now()]);
            if($ok == true)
            {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyInfo';
                $logData->operation_name = 'Currency update';
                $logData->status = 'Success';
                $logData->reason = 'Currency has been updated successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = $request->ip();
                $logData->save();
                return redirect()->route('admin.currency')->with('message','Currency has been updated successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyInfo';
                $logData->operation_name = 'Currency update';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = $request->ip();
                $logData->save();
                return redirect()->route('admin.currency')->with('message','Something went wrong!!');
            }
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CurrencyInfo';
            $logData->operation_name = 'Currency update';
            $logData->status = 'Failed';
            $logData->reason = 'Data already exist';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = $request->ip();
            $logData->save();
            return redirect()->route('admin.currency')->with('message','Data already exist!!');
        }
    }


    #################### Currency Rate Section ################
    //Currency rate list
    public function currency_rate() {
        $get_currency_rate = CurrencyRate::latest()->get();

        $data =[
            "get_currency_rate" => $get_currency_rate
        ];
        return view('admin.rate.index', $data);
    }

    //Currency rate create
    public function currency_rate_create() {
        $CountryInfo = CountryInfo::all();
        $CurrencyInfo = CurrencyInfo::all();
        $agents = AgentInfo::all();
        $data=[
            'CountryInfo'=>$CountryInfo,
            'CurrencyInfo'=>$CurrencyInfo,
            'agents' => $agents,
        ];
        return view('admin.rate.create', $data);
    }

    //Get bank from country
    public function get_bank_from_country_id(Request $request) {
        $country_id =  $request->country_id;
        $bnk_data = BankInfo::where('country_id', $country_id)->get();
        $select='';
        $select="<select name='bank_id' id='bank_id' class='form-control select2bs4' style='width: 100%;' required >";
        $select.="<option value=''> --Select-- </option>";

        foreach($bnk_data as $single_bank_data){
            $select.="<option value='$single_bank_data->id'>$single_bank_data->name </option>";
        }
        $select.="</select>";
        return $select;
    }

    //Get bank from country
    public function getBankWithAgent(Request $request) {
        $country_id =  $request->country_id;
        //$bnk_data = BankInfo::where('country_id', $country_id)->get();
        $bnk_data = DB::select("select bank.name, bank.id from bank_infos as bank, agent_infos as agent WHERE bank.id = agent.bankCode AND bank.country_id = agent.country_id AND bank.country_id = '$country_id'");
        $select='';
        $select="<select name='bank_id' id='bank_id' class='form-control select2bs4' style='width: 100%;' required >";
        $select.="<option value=''> --Select-- </option>";

        foreach($bnk_data as $single_bank_data){
            $select.="<option value='$single_bank_data->id'>$single_bank_data->name </option>";
        }
        $select.="</select>";
        return $select;
    }

    //Get currency from country
    public function get_currency_from_country_id(Request $request) {
        $country_id =  $request->country_id;
        $country_info_data = CountryInfo::where('id', $country_id)->first();
        $currency_id = $country_info_data->currency_id;

        $get_currency_info = CurrencyInfo::where('id', $currency_id)->get();

        $select='';
        $select="<select name='currency_name' id='currency_name' class='form-control select2bs4' style='width: 100%;' required >";
        $select.="<option value=''> --Select-- </option>";

        foreach($get_currency_info as $single_currency_info){
            $select.="<option value='$single_currency_info->id'>$single_currency_info->name </option>";
        }
        $select.="</select>";
        return $select;
    }

    //Currency rate store
    public function currency_rate_store(Request $request) {
        $currency_id = $request->currency_name;
        $country_id = $request->country_name;
        $bank_id = $request->bank_id;
        $rate_amount = $request->rate_amount;
        $today_date = date('Y-m-d');

        $request->validate([
            'currency_name' => 'required',
            'from_currency' => 'required',
            'country_name' => 'required',
            'bank_id' => 'required',
            'rate_amount' => 'required|numeric',
        ],[
            'currency_name.required' => 'Please, enter currency name',
            'country_name.required' => 'Please, enter country name',
            'bank_id.required' => 'Please, select bank',
            'rate_amount.required' => 'Rate amount must be numeric',
        ]);

        $check_currency_rate_exist = CurrencyRate::where('bank_id', $bank_id)->where('entry_date', $today_date)->where('from_currency_id', $request->from_currency)->first();

        if($check_currency_rate_exist === null) {
            $currency_rates = new CurrencyRate();
            $currency_rates->from_currency_id = $request->from_currency;
            $currency_rates->to_currency_id = $request->currency_name;
            $currency_rates->country_id = $request->country_name;
            $currency_rates->bank_id = $request->bank_id;
            $currency_rates->rate_amount = $request->rate_amount;
            $currency_rates->entry_by = Auth::user()->user_id;
            $currency_rates->entry_date = date('Y-m-d');
            $ok = $currency_rates->save();
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyRate';
                $logData->operation_name = 'Currency rate store';
                $logData->status = 'Success';
                $logData->reason = 'Currency rate has been created successfully';
                $logData->previous_data = json_encode($currency_rates);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = $request->ip();
                $logData->save();
                return redirect()->route('admin.currency_rate')->with('message','Currency rate has been created successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyRate';
                $logData->operation_name = 'Currency rate store';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = $request->ip();
                $logData->save();
                return redirect()->route('admin.currency_rate_create')->with('message','Something went wrong!!');
            }
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CurrencyRate';
            $logData->operation_name = 'Currency rate store';
            $logData->status = 'Failed';
            $logData->reason = 'Data already exist';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = $request->ip();
            $logData->save();
            return redirect()->route('admin.currency_rate')->with('message','Data already exist!!');
        }
    }

    //Currency rate authorize
    public function currency_rate_authorize($id) {
        $user_id = Auth::user()->user_id;
        $checkAuth = CurrencyRate::where('id', $id)->first();

        if($checkAuth->entry_by == $user_id) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CurrencyRate';
            $logData->operation_name = 'Currency rate authorized';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission to authorized';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.currency_rate')->with('message','You do not have the permission to authorized!!');
        } else {
            $dataStore = CurrencyRate::findOrFail($id);
            $ok = CurrencyRate::where('id', $id)->update([
                'status' => 1,
                'auth_by' =>Auth::user()->user_id,
                'auth_date'=>date('Y-m-d'),
            ]);

            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyRate';
                $logData->operation_name = 'Currency rate authorize';
                $logData->status = 'Success';
                $logData->reason = 'Currency rate has been authorized successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.currency_rate')->with('message','Currency rate has been authorized successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyRate';
                $logData->operation_name = 'Currency rate authorize';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.currency_rate')->with('message','Something went wrong!!');
            }
        }
    }

    //Currency rate decline
    public function currency_rate_decline($id) {
        $user_id = Auth::user()->user_id;
        $checkAuth = CurrencyRate::where('id',  $id)->first();
        if($checkAuth->entry_by == $user_id) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CurrencyRate';
            $logData->operation_name = 'Currency rate decline';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission to authorized';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.currency_rate')->with('message','You do not have the permission to authorized!');
        }else{
            $dataStore = CurrencyRate::findOrFail($id);
            $ok = CurrencyRate::where('id', $id)->update([
                'status'=> 2,
                'auth_by'=> Auth::user()->user_id,
                'auth_date'=> date('Y-m-d'),
            ]);

            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyRate';
                $logData->operation_name = 'Currency rate decline';
                $logData->status = 'Success';
                $logData->reason = 'Currency rate has been declined successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.currency_rate')->with('message','Currency rate has been declined successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyRate';
                $logData->operation_name = 'Currency rate decline';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.currency_rate')->with('message','Something went wrong!!');
            }
        }
    }

    //Currency rate edit
    public function currency_rate_edit($id) {
        $get_edit_data = CurrencyRate::where('id', $id)->first();
        $CountryInfo = CountryInfo::all();
        $CurrencyInfo = CurrencyInfo::all();
        $bnk_data = BankInfo::all();

        $data=[
            'get_edit_data' => $get_edit_data,
            'CountryInfo'=>$CountryInfo,
            'CurrencyInfo'=>$CurrencyInfo,
            'bnk_data'=>$bnk_data,
        ];
        return view('admin.rate.edit', $data);
    }

    //Currency rate update
    public function currency_rate_update(Request $request) {
        $today_date = date('Y-m-d');
        $id = $request->hidden_id;

        $check_currency_rate_exist = CurrencyRate::where('bank_id', $request->bank_id)->where('entry_date', $today_date)->first();

        if($check_currency_rate_exist === null) {
            $dataStore = CurrencyRate::findOrFail($id);
            $ok = CurrencyRate::where('id', $id)->update([
                'from_currency_id' =>  $request->from_currency,
                'to_currency_id' =>  $request->currency_name,
                'country_id' =>  $request->country_name,
                'bank_id' =>  $request->bank_id,
                'rate_amount' =>  $request->rate_amount,
                'status' => 0,
                'auth_by' => Auth::user()->user_id,
                'auth_date' => now(),
            ]);

            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyRate';
                $logData->operation_name = 'Currency rate update';
                $logData->status = 'Success';
                $logData->reason = 'Currency rate has been updated successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.currency_rate')->with('message','Currency rate has been updated successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CurrencyRate';
                $logData->operation_name = 'Currency rate update';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.currency_rate')->with('message','Something went wrong!!');
            }

        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CurrencyRate';
            $logData->operation_name = 'Currency rate update';
            $logData->status = 'Failed';
            $logData->reason = 'Data already exist';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.currency_rate')->with('message','Data already exist!!');
        }
    }


    ############ Agent Info ##############
    //Agent info
    public function agent_info_list() {
        $agent_info_list = AgentInfo::latest()->get();
        $data=[
            "agent_info_list" => $agent_info_list
        ];
        return view('admin.agent_info.agent_info_list', $data);
    }

    //Agent info create
    public function agent_info() {
        $CountryInfo = CountryInfo::all();
        $CurrencyInfo = CurrencyInfo::all();
        $bnk_data = BankInfo::all();
        $data=[
            'CountryInfo'=>$CountryInfo,
            'CurrencyInfo' => $CurrencyInfo,
            'bnk_data' => $bnk_data,
        ];
        return view("admin.agent_info.create", $data);
    }
    public function agent_info_store(Request $request) {
        $request->validate([
            'contact' => 'required|numeric|digits_between:8,15',
            'email' => 'required',
            'bank_id' => 'required',
            'country_id' => 'required',
            'address' => 'required',
        ],[
            'contact.required' => 'Enter contact number',
            'email.required' => 'Enter email address',
            'country_id.required' => 'Select a country',
            'bank_id.required' => 'Select a bank',
            'address.required' => 'Enter corporate address',
        ]);

        $check_transaction_charge_exist = AgentInfo::where('bankCode', $request->bank_id)->first();

        if($check_transaction_charge_exist === null) {
            $agent_info = new AgentInfo();
            $agent_info->country_id  = $request->country_id;
            $agent_info->contact  = $request->contact;
            $agent_info->email  = $request->email;
            $agent_info->bankCode  = $request->bank_id;
            $agent_info->corporate_address  = $request->address;
            $agent_info->entry_by = Auth::user()->user_id;
            $agent_info->entry_date = date('Y-m-d');

            $ok = $agent_info->save();
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'AgentInfo';
                $logData->operation_name = 'Agent store';
                $logData->status = 'Success';
                $logData->reason = 'Agent Info  has been created successfully';
                $logData->previous_data = json_encode($agent_info);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.agent_info_list')->with('message','Agent Info  has been created successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'AgentInfo';
                $logData->operation_name = 'Agent store';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.agent_info')->with('message','Something went wrong!!');
            }
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'AgentInfo';
            $logData->operation_name = 'Agent store';
            $logData->status = 'Failed';
            $logData->reason = 'Data already Exist';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.agent_info_list')->with('message','Data already exist!!');
        }
    }

    //Agent info authorize
    public function agent_info_authorize($id) {
        $user_id = Auth::user()->user_id;
        $if_entry_by_me = AgentInfo::where('id', $id)->first();
        if($if_entry_by_me->entry_by == $user_id) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'AgentInfo';
            $logData->operation_name = 'Agent store';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.agent_info_list')->with('message','You do not have the permission!!');
        } else {
            $dataStore = AgentInfo::findOrFail($id);
            $ok = AgentInfo::where('id', $id)->update([
                "status" => 1,
                "auth_by" => $user_id,
                "auth_date" => date('Y-m-d'),
            ]);
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'AgentInfo';
                $logData->operation_name = 'Agent authorize';
                $logData->status = 'Success';
                $logData->reason = 'Agent Info has been authorize successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.agent_info_list')->with('message','Agent Info has been authorize successfully');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'AgentInfo';
                $logData->operation_name = 'Agent authorize';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.agent_info_list')->with('message','Something went wrong!!');
            }
        }
    }

    //Agent info decline
    public function agent_info_decline($id) {
        $user_id = Auth::user()->user_id;
        $if_entry_by_me = AgentInfo::where('id', $id)->first();
        if($if_entry_by_me->entry_by == $user_id){
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'AgentInfo';
            $logData->operation_name = 'Agent decline';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.agent_info_list')->with('message','You do not have the permission!!');
        } else {
            $dataStore = AgentInfo::findOrFail($id);
            $ok = AgentInfo::where('id', $id)->update([
                "status" => 2 ,
                "auth_by" => $user_id,
                "auth_date" => date('Y-m-d'),
            ]);
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'AgentInfo';
                $logData->operation_name = 'Agent decline';
                $logData->status = 'Success';
                $logData->reason = 'Agent Info has been decline successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.agent_info_list')->with('message','Agent Info has been decline successfully');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'AgentInfo';
                $logData->operation_name = 'Agent decline';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.agent_info_list')->with('message','Something went wrong!!');
            }
        }
    }

    //Agent info edit
    public function agent_info_edit($id) {
        $get_edit_data = AgentInfo::where('id', $id)->first();
        $countryInfo = CountryInfo::all();
        $bnk_data = BankInfo::all();
        $data=[
            'get_edit_data' => $get_edit_data,
            'countryInfo'=>$countryInfo,
            'bnk_data'=>$bnk_data,
        ];
        return view('admin.agent_info.edit_agent', $data);
    }
    public function update_agent_info(Request $request){
        $id = $request->hidden_id;

        $request->validate([
            'contact' => 'required|numeric',
            'email' => 'required',
            'bank_id' => 'required',
            'address' => 'required',
        ],[
            'contact.required' => 'Enter contact',
            'email.required' => 'Enter email ',
            'bank_id.required' => 'Enter bank id ',
            'address.required' => 'Enter address ',
        ]);
        $check_transaction_charge_exist = AgentInfo::where('bankCode', $request->bank_id)->first();
        if($check_transaction_charge_exist != null) {
            $dataStore = AgentInfo::findOrFail($id);
            $ok = AgentInfo::where('id', $id)->update([
                "country_id" => $request->country_id,
                "contact" => $request->contact,
                "status" => 0,
                "email" => $request->email,
                "bankCode" => $request->bank_id,
                "corporate_address" => $request->address,
            ]);
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'AgentInfo';
                $logData->operation_name = 'Agent update';
                $logData->status = 'Success';
                $logData->reason = 'Agent Info has been updated successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.agent_info_list')->with('message','Agent Info has been updated successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'AgentInfo';
                $logData->operation_name = 'Agent update';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.agent_info_list')->with('message','Something went wrong!!');
            }
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'AgentInfo';
            $logData->operation_name = 'Agent update';
            $logData->status = 'Failed';
            $logData->reason = 'Data already exist';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.agent_info_list')->with('message','Data already exist!!');
        }
    }

    //Profile section
    public function profileIndex() {
        return view('admin.profile.index');
    }

    //Update personal information
    public function updateProfileData(Request $request) {
        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Your name is required',
        ]);

        $user = User::findOrFail(Auth::id());
        $user->name = $request->name;
        $ok = $user->save();

        if($ok == true) {
            return redirect()->route('admin.profile.index')->with('message','Data has been updated successfully!!');
        } else {
            return redirect()->route('admin.profile.index')->with('message','Something went wrong. Please try letter!!');
        }

    }

    //Update password
    public function updateAdminPassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:old_password',
            'password_confirmation' => 'required'
        ], [
            'old_password.required' => 'Please enter your current password',
            'new_password.required' => 'Please enter your new password and new password must be different form current password',
            'password_confirmation.required' => 'New password and confirm password does not matched',
        ]);

        $db_pass = Auth::user()->password;
        $current_password = $request->old_password;
        $newPass = $request->new_password;
        $confirmPass = $request->password_confirmation;

        if (Hash::check($current_password,$db_pass)) {
            if ($newPass === $confirmPass) {
                $ok = User::findOrFail(Auth::id())->update([
                    'password' => Hash::make($newPass)
                ]);
                if($ok == true) {
                    Auth::logout();
                    return redirect()->route('admin.profile.index')->with('message','Data has been updated successfully!!');
                } else {
                    return redirect()->route('admin.profile.index')->with('message','Something went wrong. Please try letter!!');
                }
            } else {
                return redirect()->route('admin.profile.index')->with('message','New and confirm password not matched!!');
            }
        } else {
            return redirect()->route('admin.profile.index')->with('message','Old password not matched!!');
        }
    }
}
