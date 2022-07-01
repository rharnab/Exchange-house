<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CountryInfo;
use App\Models\CustomerInfo;
use App\Models\CustomerType;
use App\Models\Gender;
use App\Models\IdentificationType;
use App\Models\LogInfo;
use App\Models\MaritalStatus;
use App\Models\Occupation;
use App\Models\SanctionLog;
use App\Models\ScreenOfac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{
    //All data
    public function index() {
        $customers = CustomerInfo::latest()->get();
        return view('admin.customer.index', [
            'customers' => $customers,
        ]);
    }

    //Register section
    public function addCustomer() {
        $type_ids = IdentificationType::all();
        $countries = CountryInfo::all();
        $occupations = Occupation::all();
        $customer_type = CustomerType::all();
        $gender = Gender::all();
        $marital_status = MaritalStatus::all();
        return view('admin.customer.register', [
            'type_ids' => $type_ids,
            'countries' => $countries,
            'occupations' => $occupations,
            'customer_type' => $customer_type,
            'gender' => $gender,
            'marital_status' => $marital_status
        ]);
    }

    //Get city with ajax
    public function getCity($id) {
        $city = City::where('country_id',$id)->orderBy('name','ASC')->get();
        return json_encode($city);
    }

    //Store data
    public function store(Request $request) {
        //Check the existing customer
        $house_location = Auth::user()->house_location;
        if(!empty($house_location)){
            $entry_by_house_location = $house_location;
        }else{
            $entry_by_house_location ='';
        }

        $customerCheck = CustomerInfo::where('email', $request->email)->orWhere('id_number', $request->id_number)->first();
        if ($customerCheck === null) {
            if ($request->customer_type == 'Individual') {
                //Requirement check and validation the input
                $request->validate([
                    'name' => 'required',
                    'customer_type' => 'required',
                    'id_type' => 'required',
                    'id_number' => 'required|min:9',
                    'doc_name' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                    'contact_number' => 'required|numeric|digits_between:8,15',
                    'email' => 'required',
                    'country_id' => 'required',
                    'city_id' => 'required',
                    'company_name' => 'required',
                    'company_address' => 'required',
                    'company_phone' => 'required|numeric|digits_between:8,15',
                    'dob' => 'required',
                    'place_of_birth' => 'required',
                    'gender' => 'required',
                    'marital_status' => 'required',
                    'occupation_id' => 'required',
                    'father_name' => 'required',
                    'mother_name' => 'required',
                    'present_address' => 'required',
                    'permanent_address' => 'required',
                    'work_permit_id_number' => 'required|min:10',
                    'work_permit_id_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                    'sanctionsScreening' => 'required',
                    'sanction_table' => 'required',
                ],[
                    'name.required' => 'Enter customer name',
                    'customer_type.required' => 'Select customer type',
                    'id_type.required' => 'Select a Type',
                    'id_number.required' => 'Enter id number',
                    'doc_name.required' => 'Add document',
                    'contact_number.required' => 'Contact number only contains numeric value',
                    'email.required' => 'Enter email address',
                    'country_id.required' => 'Choose a country',
                    'city_id.required' => 'Choose a city',
                    'company_name.required' => 'Enter company name',
                    'company_address.required' => 'Enter company address',
                    'company_phone.required' => 'Enter company contact number',
                    'dob.required' => 'Select customer date of birth',
                    'place_of_birth.required' => 'Enter customer place of birth',
                    'gender.required' => 'Select customer gender',
                    'marital_status.required' => 'Select customer marital status',
                    'occupation_id.required' => 'Select customer occupation',
                    'father_name.required' => 'Enter customer father name',
                    'mother_name.required' => 'Enter customer mother name',
                    'present_address.required' => 'Enter customer present address',
                    'work_permit_id_number.required' => 'Enter customer work permit id number',
                    'work_permit_id_image.required' => 'Enter customer work permit id document image ',
                ]);

                //Store the customer information
                $entry_by = Auth::user()->user_id;

                $image = $request->file('doc_name');
                $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalName();
                $directory = 'img/customer/'.$request->id_number.'/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;

                $image2 = $request->file('work_permit_id_image');
                $imageName2 = hexdec(uniqid()).'.'.$image2->getClientOriginalName();
                $directory2 = 'img/customer/'.$request->work_permit_id_number.'/';
                $image2->move($directory2, $imageName2);
                $imageUrl2 = $directory2.$imageName2;

                $customer = new CustomerInfo();
                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->expire_date = $request->exp_date;
                $customer->dob = $request->dob;
                $customer->place_of_birth = $request->place_of_birth;
                $customer->gender = $request->gender;
                $customer->marital_status = $request->marital_status;
                $customer->occupation_id = $request->occupation_id;
                $customer->father_name = $request->father_name;
                $customer->mother_name = $request->mother_name;
                $customer->present_address = $request->present_address;
                $customer->permanent_address = $request->permanent_address;
                $customer->id_type = $request->id_type;
                $customer->id_number = $request->id_number;
                $customer->doc_name = $imageUrl;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->entry_by = $entry_by;
                $customer->entry_by_house_location = $entry_by_house_location;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->work_permit_id_image = $imageUrl2;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;

                if($ok == true) {
                    //Store data into log table
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer store';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been added successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();

                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer create';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();

                    return redirect()->route('admin.customer_auth')->with('message','Customer has been added successfully!!');
                } else {
                    //Store data into log table
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer store';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_add')->with('message','Something went wrong!!');
                }
            } else {
                //Requirement check and validation the input
                $request->validate([
                    'name' => 'required',
                    'customer_type' => 'required',
                    'id_type' => 'required',
                    'id_number' => 'required',
                    'doc_name' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                    'contact_number' => 'required|numeric|digits_between:8,15',
                    'email' => 'required',
                    'country_id' => 'required',
                    'city_id' => 'required',
                    'company_name' => 'required',
                    'company_address' => 'required',
                    'company_phone' => 'required|numeric|digits_between:8,15',
                    'work_permit_id_number' => 'required|min:10',
                    'work_permit_id_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                ],[
                    'name.required' => 'Enter customer name',
                    'customer_type.required' => 'Select customer type',
                    'id_type.required' => 'Select a Type',
                    'id_number.required' => 'Enter id number',
                    'doc_name.required' => 'Add document',
                    'contact_number.required' => 'Contact number only contains numeric value',
                    'email.required' => 'Enter email address',
                    'country_id.required' => 'Choose a country',
                    'city_id.required' => 'Choose a city',
                    'company_name.required' => 'Enter company name',
                    'company_address.required' => 'Enter company address',
                    'company_phone.required' => 'Enter company contact number',
                    'work_permit_id_number.required' => 'Enter customer work permit id number',
                    'work_permit_id_image.required' => 'Enter customer work permit id document image ',
                ]);

                //Store the customer information
                $entry_by = Auth::user()->user_id;
                $image = $request->file('doc_name');
                $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalName();
                $directory = 'img/customer/'.$request->id_number.'/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;

                $image2 = $request->file('work_permit_id_image');
                $imageName2 = hexdec(uniqid()).'.'.$image2->getClientOriginalName();
                $directory2 = 'img/customer/'.$request->work_permit_id_number.'/';
                $image2->move($directory2, $imageName2);
                $imageUrl2 = $directory2.$imageName2;

                $customer = new CustomerInfo();
                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->id_type = $request->id_type;
                $customer->expire_date = $request->exp_date;
                $customer->id_number = $request->id_number;
                $customer->doc_name = $imageUrl;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->entry_by = $entry_by;
                $customer->entry_by_house_location = $entry_by_house_location;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->work_permit_id_image = $imageUrl2;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;
                if($ok == true) {
                    //Store data into log table
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer store';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been added successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();

                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer create';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();

                    return redirect()->route('admin.customer_auth')->with('message','Customer has been added successfully!!');
                } else {
                    //Store data into log table
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer store';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_add')->with('message','Something went wrong!!');
                }
            }
        } else {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CustomerInfo';
            $logData->operation_name = 'Customer store';
            $logData->status = 'Failed';
            $logData->reason = 'Data already stored';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.customer_add')->with('message','Data already stored!!');
        }
    }
    //End store function


    //Download customer document
    public function downloadDoc($id) {
        $download_data = CustomerInfo::where('id', $id)->firstOrFail();
        $pathToFile = ($download_data->doc_name);
        return response()->download($pathToFile);
    }

    //Customer authorization section
    public function authCustomer() {
        $customers = CustomerInfo::latest()->where('status', 0)->get();
        return view('admin.customer.authorized', [
            'customers' => $customers
        ]);
    }
    //Active customer
   /*  public function activeCustomer($id) {
        $checkAuth = CustomerInfo::where('id', $id)->value('entry_by');
        if(Auth::user()->user_id == $checkAuth) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CustomerInfo';
            $logData->operation_name = 'Customer authorize';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.customer_auth')->with('message','You do not have the permission!!');
        } else {
            $dataStore = CustomerInfo::findOrFail($id);
            $ok = CustomerInfo::findOrFail($id)->update(['status' => 1, 'auth_by' => Auth::user()->user_id, 'auth_date' => now()]);
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CustomerInfo';
                $logData->operation_name = 'Customer authorize';
                $logData->status = 'Success';
                $logData->reason = 'Customer is being authorized successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.customer_auth')->with('message','Customer is being authorized successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CustomerInfo';
                $logData->operation_name = 'Customer authorize';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.customer_auth')->with('message','Something went wrong!!');
            }
        }
    } */
    //authorize user
    public function customer_authorize(Request $request)
    {
        $id = $request->input('id');
        $auth_screening_parcent = (float) Auth::user()->screenig_permission;
        $screen_result = (float) $request->input('sanctionsScreening');

        //screening permission check
        if( $screen_result > $auth_screening_parcent){
            return redirect()->route('admin.customer_auth')->with('message','Sorry !! you can not authorize  above '. $auth_screening_parcent ." % ");
        }

        $checkAuth = CustomerInfo::where('id', $id)->value('entry_by');
        if(Auth::user()->user_id == $checkAuth) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CustomerInfo';
            $logData->operation_name = 'Customer authorize';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.customer_auth')->with('message','You do not have the permission!!');
        } else {
            $dataStore = CustomerInfo::findOrFail($id);
            $ok = CustomerInfo::findOrFail($id)->update([
                'status' => 1,
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
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CustomerInfo';
                $logData->operation_name = 'Customer authorize';
                $logData->status = 'Success';
                $logData->reason = 'Customer is being authorized successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();

                //Store sanction log
                $sanctionLog = new SanctionLog();
                $sanctionLog->operation_name = 'Customer authorize';
                $sanctionLog->operation_id = $lastId;
                $sanctionLog->type = 'Customer';
                $sanctionLog->log_status = 'Success';
                $sanctionLog->sanction_value = $sanctionValue;
                $sanctionLog->sanction_table = $sanctionTable;
                $sanctionLog->sanction_remarks = $sanctionRemark;
                $sanctionLog->ip_address = $request->ip();
                $sanctionLog->entry_by = Auth::user()->user_id;
                $sanctionLog->entry_date = now();
                $sanctionLog->save();

                return redirect()->route('admin.customer_auth')->with('message','Customer is being authorized successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CustomerInfo';
                $logData->operation_name = 'Customer authorize';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.customer_auth')->with('message','Something went wrong!!');
            }
        }
    }

    //Inactive customer
    public function inactiveCustomer($id) {
        $checkAuth = CustomerInfo::where('id', $id)->value('entry_by');
        if(Auth::user()->user_id == $checkAuth) {
            //Store data into log table
            $logData = new LogInfo();
            $logData->model_name = 'CustomerInfo';
            $logData->operation_name = 'Customer decline';
            $logData->status = 'Failed';
            $logData->reason = 'You do not have the permission';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.customer_auth')->with('message','You do not have the permission!!');
        } else {
            $dataStore = CustomerInfo::findOrFail($id);
            $ok = CustomerInfo::findOrFail($id)->update(['status' => 2, 'auth_by' => Auth::user()->user_id, 'auth_date' => now()]);
            if($ok == true) {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CustomerInfo';
                $logData->operation_name = 'Customer decline';
                $logData->status = 'Success';
                $logData->reason = 'Something went wrong';
                $logData->reason = 'Customer is being declined successfully';
                $logData->previous_data = json_encode($dataStore);
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.customer_auth')->with('message','Customer is being declined successfully!!');
            } else {
                //Store data into log table
                $logData = new LogInfo();
                $logData->model_name = 'CustomerInfo';
                $logData->operation_name = 'Customer decline';
                $logData->status = 'Failed';
                $logData->reason = 'Something went wrong';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.customer_auth')->with('message','Something went wrong!!');
            }
        }
    }

    //Update customer information
    public function edit() {
        return view('admin.customer.update');
    }
    public function searchCustomer(Request $request) {
        $search = $request['search'];
        if ($search === null) {
            $logData = new LogInfo();
            $logData->model_name = 'CustomerInfo';
            $logData->operation_name = 'search customer';
            $logData->status = 'Failed';
            $logData->reason = 'Empty field found';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.customer_edit')->with('message','Empty field found!!');
        } else {
            $customerCheck = CustomerInfo::where('id_number', $search)->where('status', 1)->orWhere('contact_number', $search)->first();
            if ($customerCheck === null) {
                $logData = new LogInfo();
                $logData->model_name = 'CustomerInfo';
                $logData->operation_name = 'search customer';
                $logData->status = 'Failed';
                $logData->reason = 'No data found';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = request()->ip();
                $logData->save();
                return redirect()->route('admin.customer_edit')->with('message','No data found!!');
            } else {
                $type_ids = IdentificationType::all();
                $countries = CountryInfo::all();
                $cities = City::all();
                $customer = CustomerInfo::where('id_number', $search)->where('status', 1)->orWhere('contact_number', $search)->first();
                $occupations = Occupation::all();
                $customer_type = CustomerType::all();
                $gender = Gender::all();
                $marital_status = MaritalStatus::all();
                return view('admin.customer.search', [
                    'search' => $search,
                    'customer' => $customer,
                    'type_ids' => $type_ids,
                    'countries' => $countries,
                    'cities' => $cities,
                    'occupations' => $occupations,
                    'customer_type' => $customer_type,
                    'gender' => $gender,
                    'marital_status' => $marital_status,
                ]);
            }
        }
    }


    public function update(Request $request) {
        $id = $request->cus_id;
        $entry_by = Auth::user()->user_id;
        $customer = CustomerInfo::findOrFail($id);
        $image = $request->file('doc_name');
        $image2 = $request->file('work_permit_id_image');
        $request->validate([
            'name' => 'required',
            'customer_type' => 'required',
            'id_type' => 'required',
            'id_number' => 'required|min:9',
            'contact_number' => 'required|numeric|digits_between:8,15',
            'work_permit_id_number' => 'required|min:10',
            'email' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required|numeric|digits_between:8,15',
            'sanctionsScreening' => 'required',
            'sanction_table' => 'required',
        ],[
            'name.required' => 'Enter customer name',
            'customer_type.required' => 'Select customer type',
            'id_type.required' => 'Select a Type',
            'id_number.required' => 'Enter id number',
            'contact_number.required' => 'Contact number only contains numeric value',
            'email.required' => 'Enter email address',
            'country_id.required' => 'Choose a country',
            'city_id.required' => 'Choose a city',
            'company_name.required' => 'Enter company name',
            'company_address.required' => 'Enter company address',
            'company_phone.required' => 'Enter company contact number',
            'work_permit_id_number.required' => 'Enter customer work permit id number',
            'work_permit_id_image.required' => 'Enter customer work permit id document image',
        ]);
        if ($request->customer_type == 'Individual') {
            $request->validate([
                'dob' => 'required',
                'place_of_birth' => 'required',
                'gender' => 'required',
                'marital_status' => 'required',
                'occupation_id' => 'required',
                'father_name' => 'required',
                'mother_name' => 'required',
                'present_address' => 'required',
                'permanent_address' => 'required',
            ],[
                'dob.required' => 'Select customer date of birth',
                'place_of_birth.required' => 'Enter customer place of birth',
                'gender.required' => 'Select customer gender',
                'marital_status.required' => 'Select customer marital status',
                'occupation_id.required' => 'Select customer occupation',
                'father_name.required' => 'Enter customer father name',
                'mother_name.required' => 'Enter customer mother name',
                'present_address.required' => 'Enter customer present address',
                'permanent_address.required' => 'Enter customer permanent address',
            ]);
            if ($image && $image2) {
                $request->validate([
                    'doc_name' => 'required',
                    'work_permit_id_image' => 'required',
                ],[
                    'doc_name.required' => 'Add document',
                    'work_permit_id_image.required' => 'Enter customer work permit id document image',
                ]);

                $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalName();
                $directory = 'img/customer/'.$request->id_number.'/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;

                $image2 = $request->file('work_permit_id_image');
                $imageName2 = hexdec(uniqid()).'.'.$image2->getClientOriginalName();
                $directory2 = 'img/customer/'.$request->work_permit_id_number.'/';
                $image2->move($directory2, $imageName2);
                $imageUrl2 = $directory2.$imageName2;

                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->expire_date= $request->exp_date;
                $customer->dob = $request->dob;
                $customer->place_of_birth = $request->place_of_birth;
                $customer->gender = $request->gender;
                $customer->marital_status = $request->marital_status;
                $customer->occupation_id = $request->occupation_id;
                $customer->father_name = $request->father_name;
                $customer->mother_name = $request->mother_name;
                $customer->present_address = $request->present_address;
                $customer->permanent_address = $request->permanent_address;
                $customer->id_type = $request->id_type;
                $customer->id_number = $request->id_number;
                $customer->doc_name = $imageUrl;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->status = 0;
                $customer->entry_by = $entry_by;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->work_permit_id_image = $imageUrl2;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;

                if($ok == true) {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been updated successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();

                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer update';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();

                    return redirect()->route('admin.customer_auth')->with('message','Customer has been updated successfully!!');
                } else {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_search')->with('message','Something went wrong!!');
                }
            } elseif ($image) {
                $request->validate([
                    'doc_name' => 'required',
                ],[
                    'doc_name.required' => 'Add document',
                ]);

                $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalName();
                $directory = 'img/customer/'.$request->id_number.'/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;

                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->expire_date= $request->exp_date;
                $customer->dob = $request->dob;
                $customer->place_of_birth = $request->place_of_birth;
                $customer->gender = $request->gender;
                $customer->marital_status = $request->marital_status;
                $customer->occupation_id = $request->occupation_id;
                $customer->father_name = $request->father_name;
                $customer->mother_name = $request->mother_name;
                $customer->present_address = $request->present_address;
                $customer->permanent_address = $request->permanent_address;
                $customer->id_type = $request->id_type;
                $customer->id_number = $request->id_number;
                $customer->doc_name = $imageUrl;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->status = 0;
                $customer->entry_by = $entry_by;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;

                if($ok == true) {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been updated successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();

                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer update';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();
                    return redirect()->route('admin.customer_auth')->with('message','Customer has been updated successfully!!');
                } else {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_search')->with('message','Something went wrong!!');
                }
            } elseif ($image2) {

                $request->validate([
                    'work_permit_id_image' => 'required',
                ],[
                    'work_permit_id_image.required' => 'Enter customer work permit id document image ',
                ]);


                $image2 = $request->file('work_permit_id_image');
                $imageName2 = hexdec(uniqid()).'.'.$image2->getClientOriginalName();
                $directory2 = 'img/customer/'.$request->work_permit_id_number.'/';
                $image2->move($directory2, $imageName2);
                $imageUrl2 = $directory2.$imageName2;

                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->expire_date= $request->exp_date;
                $customer->dob = $request->dob;
                $customer->place_of_birth = $request->place_of_birth;
                $customer->gender = $request->gender;
                $customer->marital_status = $request->marital_status;
                $customer->occupation_id = $request->occupation_id;
                $customer->father_name = $request->father_name;
                $customer->mother_name = $request->mother_name;
                $customer->present_address = $request->present_address;
                $customer->permanent_address = $request->permanent_address;
                $customer->id_type = $request->id_type;
                $customer->id_number = $request->id_number;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->status = 0;
                $customer->entry_by = $entry_by;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->work_permit_id_image = $imageUrl2;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;

                if($ok == true) {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been updated successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();


                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer update';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();

                    return redirect()->route('admin.customer_auth')->with('message','Customer has been updated successfully!!');
                } else {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_search')->with('message','Something went wrong!!');
                }
            } else {
                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->dob = $request->dob;
                $customer->expire_date= $request->exp_date;
                $customer->place_of_birth = $request->place_of_birth;
                $customer->gender = $request->gender;
                $customer->marital_status = $request->marital_status;
                $customer->occupation_id = $request->occupation_id;
                $customer->father_name = $request->father_name;
                $customer->mother_name = $request->mother_name;
                $customer->present_address = $request->present_address;
                $customer->permanent_address = $request->permanent_address;
                $customer->id_type = $request->id_type;
                $customer->id_number = $request->id_number;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->status = 0;
                $customer->entry_by = $entry_by;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;

                if($ok == true) {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been updated successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();

                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer update';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();

                    return redirect()->route('admin.customer_auth')->with('message','Customer has been updated successfully!!');
                } else {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_search')->with('message','Something went wrong!!');
                }
            }
        } else {
            if ($image && $image2) {
                $request->validate([
                    'doc_name' => 'required',
                    'work_permit_id_image' => 'required',
                ],[
                    'doc_name.required' => 'Add document',
                    'work_permit_id_image.required' => 'Enter customer work permit id document image ',
                ]);

                $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalName();
                $directory = 'img/customer/'.$request->id_number.'/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;

                $image2 = $request->file('work_permit_id_image');
                $imageName2 = hexdec(uniqid()).'.'.$image2->getClientOriginalName();
                $directory2 = 'img/customer/'.$request->work_permit_id_number.'/';
                $image2->move($directory2, $imageName2);
                $imageUrl2 = $directory2.$imageName2;

                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->id_type = $request->id_type;
                $customer->expire_date= $request->exp_date;
                $customer->id_number = $request->id_number;
                $customer->doc_name = $imageUrl;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->status = 0;
                $customer->entry_by = $entry_by;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->work_permit_id_image = $imageUrl2;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;

                if($ok == true) {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been updated successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();

                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer update';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();
                    return redirect()->route('admin.customer_auth')->with('message','Customer has been updated successfully!!');
                } else {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_search')->with('message','Something went wrong!!');
                }
            } elseif ($image) {
                $request->validate([
                    'doc_name' => 'required',
                ],[
                    'doc_name.required' => 'Add document',
                ]);

                $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalName();
                $directory = 'img/customer/'.$request->id_number.'/';
                $image->move($directory, $imageName);
                $imageUrl = $directory.$imageName;

                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->id_type = $request->id_type;
                $customer->expire_date= $request->exp_date;
                $customer->id_number = $request->id_number;
                $customer->doc_name = $imageUrl;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->status = 0;
                $customer->entry_by = $entry_by;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;

                if($ok == true) {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been updated successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();

                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer update';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();

                    return redirect()->route('admin.customer_auth')->with('message','Customer has been updated successfully!!');
                } else {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_search')->with('message','Something went wrong!!');
                }
            } elseif ($image2) {
                $request->validate([
                    'work_permit_id_image' => 'required',
                ],[
                    'work_permit_id_image.required' => 'Enter customer work permit id document image ',
                ]);

                $image2 = $request->file('work_permit_id_image');
                $imageName2 = hexdec(uniqid()).'.'.$image2->getClientOriginalName();
                $directory2 = 'img/customer/'.$request->work_permit_id_number.'/';
                $image2->move($directory2, $imageName2);
                $imageUrl2 = $directory2.$imageName2;

                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->id_type = $request->id_type;
                $customer->expire_date= $request->exp_date;
                $customer->id_number = $request->id_number;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->status = 0;
                $customer->entry_by = $entry_by;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->work_permit_id_image = $imageUrl2;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;

                if($ok == true) {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been updated successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();

                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer update';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();

                    return redirect()->route('admin.customer_auth')->with('message','Customer has been updated successfully!!');
                } else {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_search')->with('message','Something went wrong!!');
                }
            } else {
                $customer->name = $request->name;
                $customer->customer_type= $request->customer_type;
                $customer->id_type = $request->id_type;
                $customer->expire_date= $request->exp_date;
                $customer->id_number = $request->id_number;
                $customer->contact_number = $request->contact_number;
                $customer->email = $request->email;
                $customer->country_id = $request->country_id;
                $customer->city_id = $request->city_id;
                $customer->company_name = $request->company_name;
                $customer->company_address = $request->company_address;
                $customer->company_phone = $request->company_phone;
                $customer->status = 0;
                $customer->entry_by = $entry_by;
                $customer->entry_date = now();
                $customer->work_permit_id_number = $request->work_permit_id_number;
                $customer->remarks = $request->remarks;

                $customer->sanction_score = $request->sanctionsScreening;
                $customer->sanction_table = $request->sanction_table;
                $ok = $customer->save();

                //For sanction log
                $lastId = $customer->id;
                $sanctionValue = $customer->sanction_score;
                $sanctionTable = $customer->sanction_table;
                $sanctionRemark = $customer->sanction_remarks;

                if($ok == true) {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Success';
                    $logData->reason = 'Customer has been updated successfully';
                    $logData->previous_data = json_encode($customer);
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();

                    //Store sanction log
                    $sanctionLog = new SanctionLog();
                    $sanctionLog->operation_name = 'Customer update';
                    $sanctionLog->operation_id = $lastId;
                    $sanctionLog->type = 'Customer';
                    $sanctionLog->log_status = 'Success';
                    $sanctionLog->sanction_value = $sanctionValue;
                    $sanctionLog->sanction_table = $sanctionTable;
                    $sanctionLog->sanction_remarks = $sanctionRemark;
                    $sanctionLog->ip_address = $request->ip();
                    $sanctionLog->entry_by = Auth::user()->user_id;
                    $sanctionLog->entry_date = now();
                    $sanctionLog->save();
                    return redirect()->route('admin.customer_auth')->with('message','Customer has been updated successfully!!');
                } else {
                    $logData = new LogInfo();
                    $logData->model_name = 'CustomerInfo';
                    $logData->operation_name = 'Customer update';
                    $logData->status = 'Failed';
                    $logData->reason = 'Something went wrong';
                    $logData->entry_by = Auth::user()->user_id;
                    $logData->entry_date = now();
                    $logData->ip_address = request()->ip();
                    $logData->save();
                    return redirect()->route('admin.customer_search')->with('message','Something went wrong!!');
                }
            }
        }
    }  //update


    //Delete section
    public function deleteCustomer($id) {
        $customer = CustomerInfo::findOrFail($id);
        $ok = $customer->delete();
        if($ok == true) {
            $logData = new LogInfo();
            $logData->model_name = 'CustomerInfo';
            $logData->operation_name = 'Customer delete';
            $logData->status = 'Success';
            $logData->reason = 'Customer has been deleted successfully';
            $logData->previous_data = json_encode($customer);
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.customer_list')->with('message','Customer has been deleted successfully!!');
        }
        else {
            $logData = new LogInfo();
            $logData->model_name = 'CustomerInfo';
            $logData->operation_name = 'Customer delete';
            $logData->status = 'Failed';
            $logData->reason = 'Something went wrong';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = request()->ip();
            $logData->save();
            return redirect()->route('admin.customer_list')->with('message','Something went wrong!!');
        }
    }


    public function readDta() {
        $customer = ScreenOfac::all()->take(1);
        dd($customer);
    }

    public function authcustomerScreenModal(Request $request)
    {
         $id = $request->input('id');
         $customer = CustomerInfo::findOrFail($id);
         $output = view('admin.customer.screem_modal', compact('customer'));
         echo $output;

    }

}
