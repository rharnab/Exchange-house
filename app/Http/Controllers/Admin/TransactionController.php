<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentInfo;
use App\Models\BankInfo;
use App\Models\BranchInfo;
use App\Models\City;
use App\Models\CountryInfo;
use App\Models\CurrencyInfo;
use App\Models\CurrencyRate;
use App\Models\CustomerInfo;
use App\Models\LogInfo;
use App\Models\SanctionLog;
use App\Models\SubCountryInfo;
use App\Models\Transaction;
use App\Models\TransactionFee;
use App\Models\TransactionLog;
use App\Models\SenderTransactionReceivingBank;
use App\Models\ExHBranch;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    ###########################  Transaction Charge ###########################
    //Transaction charge list
    public function transaction_charge_list() {
        $get_transaction_charge_list = TransactionFee::where('status', '!=', 2)->latest()->get();
        $data =[
            "get_transaction_charge_list" => $get_transaction_charge_list
        ];
        return view('admin.commission-setup.index', $data);
    }

    //Transaction charge create
    public function transaction_charge() {
        $countryInfo = CountryInfo::all();
        $currency = CurrencyInfo::all();
        $data = [
            'countryInfo' => $countryInfo,
            'currency' => $currency
        ];
        return view('admin.commission-setup.create', $data);
    }
    public function transaction_charge_store(Request $request) {
        $country_id = $request->country_name;
        $start_amount = $request->start_amount;
        $end_amount = $request->end_amount;
        $charge = $request->charge;
        $currency_id = $request->currency_name;

        $request->validate([
            'country_name' => 'required',
            'start_amount' => 'required|numeric',
            'end_amount' => 'required|numeric',
            'charge' => 'required|numeric',
            'currency_name' => 'required',
        ],[
            'country_name.required' => 'Please, select country',
            'start_amount.required' => 'Start amount must numeric',
            'end_amount.required' => 'End amount must be numeric',
            'charge.required' => 'Charge must be numeric',
            'currency_name.required' => 'Select a currency',
        ]);

        if($end_amount < $charge ) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'TransactionFee';
            $logData->operation_name = 'Transaction charge store';
            $logData->status = 'Failed';
            $logData->reason = 'Charge is greater than end amount';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = $request->ip();
            $logData->save();
            return redirect()->route('admin.transaction_charge_list')->with('message','Charge should be less than end amount ');
        } else {
            if ($end_amount < $start_amount) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'TransactionFee';
                $logData->operation_name = 'Transaction charge store';
                $logData->status = 'Failed';
                $logData->reason = 'Start is greater than end amount';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = $request->ip();
                $logData->save();
                return redirect()->route('admin.transaction_charge_list')->with('message','Start should be less than end amount ');
            } else {
                $check_transaction_fee = DB::select("SELECT * FROM (SELECT * FROM `transaction_fees` WHERE start_amount BETWEEN '$start_amount' AND '$end_amount' OR end_amount BETWEEN '$start_amount' AND '$end_amount') b WHERE b.status IN (0,1) AND b.country_id = '$country_id' AND b.currency_id = '$currency_id'");
                if($check_transaction_fee != null) {
                    //Store data into log table
                    $logData = new LogInfo();
                    $logData->model_name = 'TransactionFee';
                    $logData->operation_name = 'Transaction charge store';
                    $logData->status = 'Failed';
                    $logData->reason = 'Data already stored';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = $request->ip();
                    $logData->save();
                    return redirect()->route('admin.transaction_charge_list')->with('message','Start amount must greater than previous end amount and end amount and charge amount should less than end amount!!');
                } else {
                    $transaction_charges = new TransactionFee();
                    $transaction_charges->country_id = $country_id;
                    $transaction_charges->start_amount = $start_amount;
                    $transaction_charges->end_amount = $end_amount;
                    $transaction_charges->currency_id = $request->currency_name;
                    $transaction_charges->charge = $request->charge;
                    $transaction_charges->entry_by = Auth::user()->user_id;
                    $transaction_charges->entry_date = date('Y-m-d');
                    $ok = $transaction_charges->save();
                    if($ok == true) {
                        //Store data into log table
                        $logData = new LogInfo();
                        $logData->model_name = 'TransactionFee';
                        $logData->operation_name = 'Transaction charge store';
                        $logData->status = 'Success';
                        $logData->reason = 'Transaction charge has been created successfully';
                        $logData->entry_by = Auth::user()->user_id;
                        $logData->previous_data = json_encode($transaction_charges);
                        $logData->entry_date = now();
                        $logData->ip_address = $request->ip();
                        $logData->save();
                        return redirect()->route('admin.transaction_charge_list')->with('message','Transaction charge has been created successfully!!');
                    } else {
                        //Store data into log table
                        $logData = new LogInfo();
                        $logData->model_name = 'TransactionFee';
                        $logData->operation_name = 'Transaction charge store';
                        $logData->status = 'Failed';
                        $logData->reason = 'Something went wrong';
                        $logData->entry_by = Auth::user()->user_id;
                        $logData->entry_date = now();
                        $logData->ip_address = $request->ip();
                        $logData->save();
                        return redirect()->route('admin.transaction_charge_list')->with('message','Something went wrong!!');
                    }
                }
            }
        }
    }

    //Transaction charge authorize
    public function transaction_charge_authorize($id) {
        $user_id = Auth::user()->user_id;
        $checkData = TransactionFee::where('id', $id)->first();
        if($checkData->entry_by == $user_id) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'TransactionFee';
            $logData->operation_name = 'Transaction charge authorize';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.transaction_charge_list')->with('message','You do not have the permission!!');
        }else{
            $dataStore = TransactionFee::findOrFail($id);
            $ok = TransactionFee::where('id', $id)->update([
                'status' => 1,
                'auth_by' => Auth::user()->user_id,
                'auth_date' => date('Y-m-d'),
            ]);
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'TransactionFee';
                $logData->operation_name = 'Transaction charge authorize';
                $logData->status = 'Success';
                $logData->reason = 'Transaction charge has been authorized successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.transaction_charge_list')->with('message','Transaction charge has been authorized successfully!!');
            }else{
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'TransactionFee';
                $logData->operation_name = 'Transaction charge authorize';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.transaction_charge_list')->with('message','Something went wrong!!');
            }
        }
    }

    //Transaction charge decline
    public function transaction_charge_decline($id) {
        $user_id = Auth::user()->user_id;
        $checkData = TransactionFee::where('id', $id)->first();
        if($checkData->entry_by == $user_id) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'TransactionFee';
            $logData->operation_name = 'Transaction charge decline';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.transaction_charge_list')->with('message','You do not have the permission!');
        }else{
            $dataStore = TransactionFee::findOrFail($id);
            $ok = TransactionFee::where('id', $id)->update([
                'status' => 2,
                'auth_by' => Auth::user()->user_id,
                'auth_date' => date('Y-m-d'),
            ]);

            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'TransactionFee';
                $logData->operation_name = 'Transaction charge decline';
                $logData->status = 'Success';
                $logData->reason = 'This Transaction charge declined successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                return redirect()->route('admin.transaction_charge_list')->with('message','This Transaction charge declined successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'TransactionFee';
                $logData->operation_name = 'Transaction charge decline';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.transaction_charge_list')->with('message','Something went wrong!!');
            }
        }
    }

    //Transaction charge edit
    public function transaction_charge_edit($id) {
        $get_edit_data = TransactionFee::where('id',  $id)->first();
        $countryInfo = CountryInfo::all();
        $currency = CurrencyInfo::all();
        $data=[
            'get_edit_data' => $get_edit_data,
            'countryInfo' => $countryInfo,
            'currency' => $currency,
        ];
        return view('admin.commission-setup.edit', $data);
    }

    public function update_transaction_charge(Request $request) {
        $id = $request->hidden_id;
        $country_id = $request->country_name;
        $start_amount = $request->start_amount;
        $end_amount = $request->end_amount;
        $charge = $request->charge;
        $currency_id = $request->currency_name;

        $request->validate([
            'country_name' => 'required',
            'start_amount' => 'required|numeric',
            'end_amount' => 'required|numeric',
            'charge' => 'required|numeric',
            'currency_name' => 'required',
        ],[
            'country_name.required' => 'Please, select country',
            'start_amount.required' => 'Start amount must numeric',
            'end_amount.required' => 'End amount must be numeric',
            'charge.required' => 'Charge must be numeric',
            'currency_name.required' => 'Select a currency',
        ]);

        if($end_amount < $charge ) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'TransactionFee';
            $logData->operation_name = 'Transaction charge update';
            $logData->status = 'Failed';
            $logData->reason = 'Charge should be less than start amount';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.transaction_charge_list')->with('message','Charge should be less than start amount!!');
        } else {
            if ($end_amount < $start_amount) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'TransactionFee';
                $logData->operation_name = 'Transaction charge update';
                $logData->status = 'Failed';
                $logData->reason = 'Start should be less than end amount';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.transaction_charge_list')->with('message','Start should be less than end amount!!');
            } else {
                $check_transaction_fee = DB::select("SELECT * FROM (SELECT * FROM `transaction_fees` WHERE start_amount BETWEEN '$start_amount' AND '$end_amount' OR end_amount BETWEEN '$start_amount' AND '$end_amount') b WHERE b.status IN (0,1) AND b.country_id = '$country_id' AND b.currency_id = '$currency_id'");
                if($check_transaction_fee != null) {
                    $data_id = $check_transaction_fee[0]->id;
                    if ($id == $data_id) {
                        $dataStore = TransactionFee::findOrFail($id);
                        $ok = TransactionFee::where('id', $id)->update([
                            'country_id' =>  $country_id,
                            'start_amount' => $start_amount,
                            'end_amount' => $end_amount,
                            'charge' => $charge,
                            'status' => 0,
                            'currency_id' => $request->currency_name,
                        ]);
                        if($ok == true) {
                            //Store data into log table
                            $logData = new LogInfo();
                            $logData->model_name = 'TransactionFee';
                            $logData->operation_name = 'Transaction charge update';
                            $logData->status = 'Success';
                            $logData->reason = 'Currency rate has been updated successfully';
                            $logData->previous_data = json_encode($dataStore);
                            $logData->entry_by = Auth::user()->user_id;
                            $logData->entry_date = now();
                            $logData->ip_address = request()->ip();
                            $logData->save();
                            return redirect()->route('admin.transaction_charge_list')->with('message','Transaction charge has been updated successfully!!');
                        } else {
                            //Store data into log table
                            $logData = new LogInfo();
                            $logData->model_name = 'TransactionFee';
                            $logData->operation_name = 'Transaction charge update';
                            $logData->status = 'Failed';
                            $logData->reason = 'Something went wrong';
                            $logData->entry_by = Auth::user()->user_id;
                            $logData->entry_date = now();
                            $logData->ip_address = request()->ip();
                            $logData->save();
                            return redirect()->route('admin.transaction_charge_list')->with('message','Something went wrong!!');
                        }
                    }
                } else {
                    //Store data into log table
                    $logData = new LogInfo();
                    $logData->model_name = 'TransactionFee';
                    $logData->operation_name = 'Transaction charge update';
                    $logData->status = 'Failed';
                    $logData->reason = 'Start amount must greater than previous end amount and end amount and charge amount should less than end amount';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.transaction_charge_list')->with('message','Start amount must greater than previous end amount and end amount and charge amount should less than end amount!!');
                }
            }
        }
    }

    ###########################  Transaction ###########################
    //Transaction create
    public function transactCreateSearch() {
        return view('admin.transaction.search');
    }
    public function transactCreateSearchData(Request $request) {
        $search = $request['search'];
        if ($search === null) {
            //Store data into transaction log table
            $logData = new TransactionLog();
            $logData->model_name = 'Transaction';
            $logData->operation_name = 'transact create search';
            $logData->status = 'Failed';
            $logData->reason = 'Empty field found';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = $request->ip();
            $logData->save();
            return redirect()->route('admin.transaction_crate_search')->with('message','Empty field found!!');
        } else {
            $customerCheck = DB::select("SELECT cu.*, c.name city, ci.name country,ao.account_no, ehb.name as exchange_house_location
             FROM customer_infos cu LEFT JOIN account_openings ao ON ao.customer_id = cu.id
             LEFT JOIN cities c ON c.id = cu.city_id
             LEFT JOIN country_infos ci ON ci.id = cu.country_id
             LEFT JOIN ex_h_branches ehb  ON cu.entry_by_house_location = ehb.id
              WHERE ((cu.contact_number = '$search' OR cu.id_number='$search') AND cu.status=1 )
              OR ( ao.account_no = '$search' AND ao.status='1')");
            if ($customerCheck) {
                $dataNew = $customerCheck[0];
                $countries = CountryInfo::all();
                $countryInfo = CountryInfo::all();
                $currencyInfo = CurrencyInfo::all();
                $SenderTransactionReceivingBank = SenderTransactionReceivingBank::all();
                $data = [
                    "countries" => $countries,
                    'countryInfo'=>$countryInfo,
                    'currencyInfo' => $currencyInfo,
                    'dataNew' => $dataNew,
                    'SenderTransactionReceivingBank' => $SenderTransactionReceivingBank,
                ];


                return view('admin.transaction.create', $data);

            } else {
                //Store data into transaction log table
                $logData = new TransactionLog();
                $logData->model_name = 'Transaction';
                $logData->operation_name = 'transact create search';
                $logData->status = 'Failed';
                $logData->reason = 'No data found';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = $request->ip();
                $logData->save();
                return redirect()->route('admin.transaction_crate_search')->with('message1','No data found!!');
            }
        }
    }

    //For calculation
    public function calculationRate(Request $request) {
        $from_currency = $request->input('from_currency');
        $to_currency = $request->input('to_currency');
        $from_amount = $request->input('from_amount');
        $bank_id = $request->input('agent_bank_name');
        $country_id = $request-> input('receiver_country');

        $get_convert_rates = CurrencyRate::where(function ($query) use ($from_currency) {
            $query->where('from_currency_id', $from_currency)
                ->orWhere('to_currency_id', $from_currency);
        })->where(function ($query) use ($to_currency) {
            $query->where('from_currency_id', $to_currency)
                ->orWhere('to_currency_id', $to_currency);
        })->where('bank_id', $bank_id)->where('country_id', $country_id)->latest()->first();

        $rate_amount = $get_convert_rates->rate_amount;
        if ($request->from_currency == $request->to_currency) {
            $bdt_amount = $from_amount ;
            return $bdt_amount ?? 0;
        } elseif($get_convert_rates->from_currency_id == $request->from_currency || $get_convert_rates->to_currency_id == $request->to_currency_id) {
            $bdt_amount = $rate_amount * $from_amount;
            return $bdt_amount ?? 0;
        } else {
            $bdt_amount = $from_amount / $rate_amount;
            return $bdt_amount ?? 0;
        }
    }

    //For total amount
    public function totalCost(Request $request) {
        $from_currency = $request->input('from_currency');
        $from_amount = $request->input('from_amount');
        $country_id = $request-> input('receiver_country');

        $charge = TransactionFee::where('country_id', $country_id)->where('currency_id',$from_currency)->where('start_amount', '<=', $from_amount)
            ->where('end_amount', '>=', $from_amount)->where('status', 1)->first();
        $cost = $charge->charge;
        $final_cost = $cost + $from_amount;
        return $final_cost ?? 0;
    }

    public function totalCost1(Request $request) {
        $from_currency = $request->input('from_currency');
        $from_amount = $request->input('from_amount');
        $country_id = $request-> input('receiver_country');

        $charge = TransactionFee::where('country_id', $country_id)->where('currency_id',$from_currency)->where('start_amount', '<=', $from_amount)
            ->where('end_amount', '>=', $from_amount)->where('status', 1)->first();
        $cost = $charge->charge;
        $final_cost = $cost;
        return $final_cost ?? 0;
    }

    //For sub country
    public function getSubCountryTrn(Request $request) {
        $country_id = $request->country_id;
        $SubCountryInfo = SubCountryInfo::where('country_id', $country_id)->get();

        $sleect='';
        $sleect="<select name='receiver_sub_country' class='form-control select2bs4' style='width: 100%;' required onchange='show_city(this.value);'>";
        $sleect.="<option value=''> --Select-- </option>";

        foreach($SubCountryInfo as $single_sub_country) {
            $sleect.="<option value='$single_sub_country->id'>$single_sub_country->name </option>";
        }
        $sleect.="</select>";
        return $sleect;
    }

    //For city
    public function geCityTrn(Request $request) {
        $receiver_country_id = $request->receiver_country_id;
        $subcountry_id = $request->subcountry_id;

        $get_cities = City::where('country_id',$receiver_country_id)->where('sub_country_id',$subcountry_id)->get();

        $select='';
        $select="<select name='receiver_city' id='receiver_city' class='form-control select2' style='width: 100%;' required >";
        $select.="<option value=''> --Select-- </option>";

        foreach($get_cities as $single_get_city){
            $select.="<option value='$single_get_city->id'>$single_get_city->name </option>";
        }
        $select.="</select>";
        return $select;
    }

    //For bank
    public function getReceiverBankFromCountry(Request $request){
        $country_id = $request->id;
        $bnk_data = BankInfo::where('country_id', $country_id)->get();

        $select='';
        $select="<select name='receiver_bank' id='receiver_bank' onclick='get_receiver_bank_branch(this.value);' class='form-control select2bs4' style='width: 100%;' required >";
        $select.="<option value=''> --Select-- </option>";

        foreach($bnk_data as $single_bank_data) {
            $select.="<option value='$single_bank_data->id'>$single_bank_data->name </option>";
        }
        $select.="</select>";
        return $select;
    }

    //Get receiver branch based on bank
    public function getReceiverBankBranchFromCountry(Request $request) {
        $bank_id = $request->bank_id;
        $get_branch_info = BranchInfo::where('bank_id', $bank_id)->get();

        $select='';
        $select="<select name='receiver_bank_branch' id='receiver_bank_branch'  class='form-control select2bs4' style='width: 100%;' required >";
        $select.="<option value=''> --Select-- </option>";

        foreach($get_branch_info as $single_branch_info) {
            $select.="<option value='$single_branch_info->id'>$single_branch_info->name </option>";
        }
        $select.="</select>";
        return $select;
    }

    //Get agent bank based on receiver country
    public function getAgentBankNameFromCountry(Request $request) {
        $country_id = $request->country_id;
        $get_agent_info = AgentInfo::where('country_id', $country_id)->get();

        $select='';
        $select="<select name='agent_name' id='agent_name'  class='form-control select2' style='width: 100%;' required >";
        $select.="<option value=''> --Select-- </option>";

        foreach($get_agent_info as $single_agent_info) {
            $bank_code = $single_agent_info->bankCode;
            $get_bank_info = BankInfo::where('id', $bank_code)->first();
            $select.="<option value='$get_bank_info->id'>$get_bank_info->name</option>";
        }
        $select.="</select>";
        return $select;
    }

    //Store transaction
    public function storeTransaction(Request $request) {
        $old_transaction = Transaction::all()->last();
        if($old_transaction === null) {
            $old_order_no = 50800000000001;
        } else {
            $old_order_no = $old_transaction->order_no;
        }
        $order_no = $old_order_no + 1;
        //Input validation
        $request->validate([
            'receiver_name' => 'required',
            'receiver_country' => 'required',
            'receiver_sub_country' => 'required',
            'receiver_city' => 'required',
            'receiver_address' => 'required',
            'receiver_contact' => 'required|numeric|digits_between:8,15',
            'sender_receiver_relation' => 'required',
            'purpose_of_sending' => 'required',
            'payment_mode' => 'required',
            'receiver_bank' => 'required_if:payment_mode,==,2',
            'receiver_bank_branch' => 'required_if:payment_mode,==,2',
            'receiver_acc_no' => 'required_if:payment_mode,==,2',
            'agent_bank_name' => 'required',
            'from_currency' => 'required',
            'to_currency' => 'required',
            'from_amount' => 'required|numeric',
        ],[
            'name.required' => 'Enter receiver name',
            'receiver_country.required' => 'Select receiver country',
            'receiver_sub_country.required' => 'Select receiver sub country',
            'receiver_city.required' => 'Select receiver city',
            'receiver_address.required' => 'Select receiver address',
            'receiver_contact.required' => 'Enter receiver contact number',
            'sender_receiver_relation.required' => 'Add relation between sender and receiver',
            'purpose_of_sending.required' => 'Add purpose of money',
            'payment_mode.required' => 'Select a payment mode',
            'receiver_bank.required_if' => 'Select a bank name',
            'receiver_bank_branch.required_if' => 'Select a bank branch name',
//            'receiver_acc_no.required_if' => 'Enter receiver account number',
            'agent_bank_name.required' => 'Enter agent bank number',
            'from_currency.required' => 'Select a currency',
            'to_currency.required' => 'Select a currency',
            'from_amount.required' => 'Enter amount',
        ]);

        $transaction = new Transaction();
        $transaction->sender_id = $request->sender_id;
        $transaction->sender_name = $request->sender_name;
        $transaction->sender_contact = $request->sender_contact;
        $transaction->sender_email = $request->sender_email;
        $transaction->sender_country = $request->sender_country;
        $transaction->sender_sub_country_level_1 = $request->sender_sub_country_level_1;
        $transaction->sender_address_line = $request->sender_address_line;
        $transaction->sender_account_number = $request->sender_account_number;
        $transaction->sender_transaction_receiving_mode = $request->sender_transaction_receiving_mode;
        $transaction->sender_transaction_receiving_bank = $request->sender_transaction_receiving_bank;
        $transaction->sender_ex_h_location = $request->entry_by_house_location;

        //Receiver info
        $transaction->receiver_name = $request->receiver_name;
        $transaction->receiver_country = $request->receiver_country;
        $transaction->receiver_sub_country_level_1 = $request->receiver_sub_country;
        $transaction->receiver_sub_country_level_2 = $request->receiver_city;
        $transaction->receiver_address = $request->receiver_address;
        $transaction->receiver_contact = $request->receiver_contact;
        $transaction->receiver_and_sender_relation = $request->sender_receiver_relation;
        $transaction->purpose_of_sending = $request->purpose_of_sending;
        $transaction->payment_mode = $request->payment_mode;
        $transaction->receiver_bank = $request->receiver_bank;
        $transaction->receiver_bank_branch = $request->receiver_bank_branch;
        $transaction->receiver_account_number = $request->receiver_acc_no;
        $transaction->receiver_dob = $request->receiver_dob;

        //Amount section
        $transaction->originated_currency = $request->from_currency;
        $transaction->originated_amount = $request->from_amount;
        $transaction->disbursement_currency = $request->to_currency;
        $transaction->disbursement_amount = $request->to_amount;
        $transaction->originated_customer_fee = $request->entry_amount - $request->from_amount;


        if($request->payment_mode == 1) {
            $trnTp = 'C';
        } else {
            $trnTp = 'A';
        }
        $transaction->order_no = $order_no;
        $transaction->transaction_pin = $order_no;
        $transaction->trn_date = now();
        $transaction->stLevel = 0;
        $transaction->agent_code = $request->agent_bank_name;
        $transaction->trnTp = $trnTp;

        $trn_rate = CurrencyRate::where('from_currency_id', $request->from_currency)->where('bank_id',$request->agent_bank_name)->first();
        $exchange_rate = $trn_rate->rate_amount;
        $transaction->exchange_rate = $exchange_rate;
        $transaction->remarks = $request->remarks;

        //Getting routing number
        if($request->receiver_bank == '' && $request->receiver_bank_branch == '') {
            $receiver_bank_br_routing_number = '';
        } else {
            $branch = BranchInfo::where('bank_id', $request->receiver_bank)->where('id', $request->receiver_bank_branch)->first();
            $receiver_bank_br_routing_number = $branch->routingNumber;
        }

        $transaction->receiver_bank_br_routing_number = $receiver_bank_br_routing_number;
        $transaction->entry_by = Auth::user()->user_id;
        $transaction->entry_date = now();

        $transaction->sanction_score = $request->sanctionsScreening;
        $transaction->sanction_table = $request->sanction_table;

        $ok = $transaction->save();

        //For sanction log
        $lastId = $transaction->id;
        $sanctionValue = $transaction->sanction_score;
        $sanctionTable = $transaction->sanction_table;
        $sanctionRemark = $transaction->sanction_remarks;


        if($ok == true) {

            $customer_contact = $request->sender_contact;
            /* customer screening update */
            if($request->customerScreening  != $request->old_screen){
                $customer_info = CustomerInfo::where('contact_number', $customer_contact)->update([
                    'sanction_score_auth' => $request->input('customerScreening'),
                    'sanction_table' => $request->input('customer_sanction_table'),

                ]);
            }
           /* customer screening update */

            //Store data into transaction log table
            $logData = new TransactionLog();
            $logData->model_name = 'Transaction';
            $logData->operation_name = 'Transaction store';
            $logData->status = 'Success';
            $logData->reason = 'Transaction has been added successfully';
            $logData->previous_data = json_encode($transaction);
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = $request->ip();
            $logData->save();

            //Store sanction log
            $sanctionLog = new SanctionLog();
            $sanctionLog->operation_name = 'Transaction create';
            $sanctionLog->operation_id = $lastId;
            $sanctionLog->type = 'Transaction';
            $sanctionLog->log_status = 'Success';
            $sanctionLog->sanction_value = $sanctionValue;
            $sanctionLog->sanction_table = $sanctionTable;
            $sanctionLog->sanction_remarks = $sanctionRemark;
            $sanctionLog->ip_address = $request->ip();
            $sanctionLog->entry_by = Auth::user()->user_id;
            $sanctionLog->entry_date = now();
            $sanctionLog->save();
            return redirect()->route('admin.transaction_auth')->with('message2','Transaction has been added successfully!!');
        } else {
            //Store data into transaction log table
            $logData = new TransactionLog();
            $logData->model_name = 'Transaction';
            $logData->operation_name = 'Transaction store';
            $logData->status = 'Failed';
            $logData->reason = 'Something went wrong';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = $request->ip();
            $logData->save();
            return redirect()->route('admin.transaction_crate_search')->with('message2','Something went wrong!!');
        }
    }     //end store transaction function



    //Display transaction list
    public function transactionList() {
        $transactions = Transaction::latest()->get();

        return view('admin.transaction.index', [
            'transactions' => $transactions
        ]);
    }

    public function transactionAuthList() {
        $transactions = Transaction::where('stLevel',0)->latest()->get();
        return view('admin.transaction.authorized', [
            'transactions' => $transactions
        ]);
    }

    //Transaction authentication
    /* public function authTransaction($id) {
        $permissionCheck = Transaction::where('id', $id)->first();
        $entry_by = $permissionCheck->entry_by;
        $order_no = $permissionCheck->order_no;
        $id = $permissionCheck->id;
        if(Auth::user()->user_id == $entry_by) {
            //Store data into transaction log table
            $logData = new TransactionLog();
            $logData->trn_id = $id;
            $logData->model_name = 'Transaction';
            $logData->operation_name = 'Transaction authorize';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.transaction_auth')->with('message2','You do not have the permission!!');
        } else {
            $dataStore = Transaction::findOrFail($id);
            $ok = Transaction::findOrFail($id)->update(['stLevel' => 1, 'auth_by' => Auth::user()->user_id, 'auth_date' => now()]);
            if($ok == true) {
                //Store data into transaction log table
                $logData = new TransactionLog();
                $logData->trn_id = $id;
                $logData->model_name = 'Transaction';
                $logData->operation_name = 'Transaction authorize';
                $logData->status = 'Success';
                $logData->reason = 'Transaction is being authorized successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.transaction_auth')->with('message1','Transaction is being authorized successfully!!')->with('message', $id);
            } else {
                //Store data into transaction log table
                $logData = new TransactionLog();
                $logData->trn_id = $id;
                $logData->model_name = 'Transaction';
                $logData->operation_name = 'Transaction authorize';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.transaction_auth')->with('message','Something went wrong!!');
            }
        }
    } */


    public function transaction_authorize(Request $request) {
        $id = $request->input('id');
        $auth_screening_parcent = (float) Auth::user()->screenig_permission;
        $screen_result = (float) $request->input('sanctionsScreening');

        //screening permission check
        if( $screen_result > $auth_screening_parcent){
            return redirect()->route('admin.account_authorize')->with('message','Sorry !! you can not authorize  above '. $auth_screening_parcent ." % ");
        }

        $permissionCheck = Transaction::where('id', $id)->first();
        $entry_by = $permissionCheck->entry_by;
        $order_no = $permissionCheck->order_no;
        $id = $permissionCheck->id;
        if(Auth::user()->user_id == $entry_by) {
            //Store data into transaction log table
            $logData = new TransactionLog();
            $logData->trn_id = $id;
            $logData->model_name = 'Transaction';
            $logData->operation_name = 'Transaction authorize';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.transaction_auth')->with('message2','You do not have the permission!!');
        } else {
            $dataStore = Transaction::findOrFail($id);
            $ok = Transaction::findOrFail($id)->update([
                'stLevel' => 1,
                'auth_by' => Auth::user()->user_id,
                'auth_date' => now(),
                'sanction_score_auth' => $request->input('sanctionsScreening'),
                'sanction_table' => $request->input('sanction_table'),
                'sanction_remarks' => $request->input('remarks'),
            ]);

            //For sanction log
            $lastId = $id;
            $sanctionValue = $request->input('sanctionsScreening');
            $sanctionTable = $request->input('sanction_table');
            $sanctionRemark = $request->input('remarks');

            if($ok == true) {
                //Store data into transaction log table
                $logData = new TransactionLog();
                $logData->trn_id = $id;
                $logData->model_name = 'Transaction';
                $logData->operation_name = 'Transaction authorize';
                $logData->status = 'Success';
                $logData->reason = 'Transaction is being authorized successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();

                //Store sanction log
                $sanctionLog = new SanctionLog();
                $sanctionLog->operation_name = 'Transaction authorize';
                $sanctionLog->operation_id = $lastId;
                $sanctionLog->type = 'Transaction';
                $sanctionLog->log_status = 'Success';
                $sanctionLog->sanction_value = $sanctionValue;
                $sanctionLog->sanction_table = $sanctionTable;
                $sanctionLog->sanction_remarks = $sanctionRemark;
                $sanctionLog->ip_address = $request->ip();
                $sanctionLog->entry_by = Auth::user()->user_id;
                $sanctionLog->entry_date = now();
                $sanctionLog->save();

                return redirect()->route('admin.transaction_auth')->with('message1','Transaction is being authorized successfully!!')->with('message', $id);
            } else {
                //Store data into transaction log table
                $logData = new TransactionLog();
                $logData->trn_id = $id;
                $logData->model_name = 'Transaction';
                $logData->operation_name = 'Transaction authorize';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.transaction_auth')->with('message','Something went wrong!!');
            }
        }
    }

    //Transaction declined
    public function declineTransaction($id) {
        $permissionCheck = Transaction::where('id', $id)->first();
        $entry_by = $permissionCheck->entry_by;
        if(Auth::user()->user_id == $entry_by) {
            //Store data into transaction log table
            $logData = new TransactionLog();
            $logData->trn_id = $id;
            $logData->model_name = 'Transaction';
            $logData->operation_name = 'Transaction decline';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.transaction_auth')->with('message2','You do not have the permission!!');
        } else {
            $dataStore = Transaction::findOrFail($id);
            $ok = Transaction::findOrFail($id)->update(['stLevel' => 3, 'auth_by' => Auth::user()->user_id, 'auth_date' => now()]);
            if($ok == true) {
                //Store data into transaction log table
                $logData = new TransactionLog();
                $logData->trn_id = $id;
                $logData->model_name = 'Transaction';
                $logData->operation_name = 'Transaction decline';
                $logData->status = 'Success';
                $logData->reason = 'Transaction is being declined successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.transaction_auth')->with('message2','Transaction is being declined successfully!!');
            } else {
                //Store data into transaction log table
                $logData = new TransactionLog();
                $logData->trn_id = $id;
                $logData->model_name = 'Transaction';
                $logData->operation_name = 'Transaction decline';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.transaction_auth')->with('message2','Something went wrong!!');
            }
        }
    }

    public function voucherPrint($id) {
        $trnData = Transaction::where('id',$id)->first();
        $order_no = $trnData->order_no;
        $dataStore = Transaction::findOrFail($id);
        Transaction::where('id', $id)->update([
            'voucher_print' => 1,
            'date_of_payment' => now()
        ]);

        $pdf = PDF::loadView('admin.transaction.pdf',[
            'trnData' => $trnData
        ]);
        $logData = new TransactionLog();
        $logData->trn_id = $id;
        $logData->model_name = 'Transaction';
        $logData->operation_name = 'Voucher print';
        $logData->status = 'Success';
        $logData->reason = 'Voucher has been print successfully';
        $logData->previous_data = json_encode($dataStore);
        $logData->entry_by = Auth::user()->user_id;
        $logData->entry_date = now();
        $logData->ip_address = request()->ip();
        $logData->save();
        //return $pdf->download($order_no.'.pdf');
        return $pdf->stream($order_no.'.pdf');
    }

    public function testvoucherPrint(){
        $pdf = PDF::loadView('admin.transaction.test_pdf');
        return $pdf->stream('test'.'.pdf');
    }

    //Track transaction
    public function trackTransaction() {
        return view('admin.transaction.track-transaction');
    }

    public function trackTransactionSearch(Request $request) {
        $search = $request['search'];
        if ($search === null) {
            $logData = new TransactionLog();
            $logData->model_name = 'Transaction';
            $logData->operation_name = 'Track transaction search';
            $logData->status = 'Failed';
            $logData->reason = 'Empty field found';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.trackTransaction')->with('message','Empty field found!!');
        } else {
            $trackData = Transaction::where('order_no', $search)->orWhere('transaction_pin', $search)->first();
            if ($trackData === null) {
                $logData = new TransactionLog();
                $logData->model_name = 'Transaction';
                $logData->operation_name = 'Track transaction search';
                $logData->status = 'Failed';
                $logData->reason = 'No data found';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.trackTransaction')->with('message','No data found!!');
            } else {
                $data_id = $trackData->id;
                $logData = new TransactionLog();
                $logData->model_name = 'Transaction';
                $logData->operation_name = 'Track transaction search';
                $logData->status = 'Success';
                $logData->reason = 'Data found';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                $track_trn = TransactionLog::where('trn_id', $data_id)->get();
                return view('admin.transaction.track-data', [
                    'trackData' => $trackData,
                    'search' => $search,
                    'track_trn' => $track_trn,
                ]);
            }
        }
    }
    //End function trackTransactionSearch

    public function authTransactionScreenModal(Request $request)
    {
         $id  = $request->input('id');
         $transaction = Transaction::findOrFail($id);
         $output = view('admin.transaction.screem_modal', compact('transaction'));

         echo $output;

    }
}
