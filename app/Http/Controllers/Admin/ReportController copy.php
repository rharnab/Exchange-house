<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountOpening;
use App\Models\LogInfo;
use App\Models\Transaction;
use App\Models\SenderTransactionReceivingBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //Transaction
    public function transaction_report() {
        return view('admin.report.transaction_report.index');
    }
    public function transaction_report_show(Request $request) {
        $get_transaction_report = Transaction::whereBetween('trn_date',[$request->start_date, $request->end_date])->orWhere('stLevel', $request->status)->orderBy('id','desc')->get();
        //Store data into log table
        $logData = new LogInfo();
        $logData->model_name = 'Transaction';
        $logData->operation_name = 'Transaction report';
        $logData->status = 'Success';
        $logData->reason = 'Generate transaction report';
        $logData->entry_by = Auth::user()->user_id;
        $logData->entry_date = now();
        $logData->ip_address = request()->ip();
        $logData->save();
        return view('admin.report.transaction_report.show', [
            'get_transaction_report' => $get_transaction_report
        ]);
    }

    //Account
    public function account_report() {
        return view('admin.report.account_report.index');
    }
    public function account_report_show(Request $request) {
        $get_account_report =  AccountOpening::whereBetween('entry_date',[$request->start_date, $request->end_date])->orWhere('status', $request->status)->orderBy('id','desc')->get();
        //Store data into log table
        $logData = new LogInfo();
        $logData->model_name = 'AccountOpening';
        $logData->operation_name = 'Account opening report';
        $logData->status = 'Success';
        $logData->reason = 'Generate account opening report';
        $logData->entry_by = Auth::user()->user_id;
        $logData->entry_date = now();
        $logData->ip_address = request()->ip();
        $logData->save();
        return view('admin.report.account_report.show', [
            'get_account_report' => $get_account_report
        ]);

    }

    // account report show

// ################### bank wise online summary report #####################

    //start function bank_wise_online_summary_report
    public function bank_wise_online_summary_report(){
        
        $get_sender_tr_rec_bank = SenderTransactionReceivingBank::all();

        $data =[
            "get_sender_tr_rec_bank" => $get_sender_tr_rec_bank
        ];

       
        return view('admin.report.bank_wise_online_summary_report.index',$data);
    }

    //end function bank_wise_online_summary_report



    // start function bank_wise_online_summary_report_details
    public function bank_wise_online_summary_report_details(Request $request){
        
       

        if(!empty($request->fund_receiving_bank)){

            $fund_receiving_bank = $request->fund_receiving_bank;
            $fund_rec_bank_sql= "  and t.sender_transaction_receiving_bank='$fund_receiving_bank'  ";
        }else{
            $fund_rec_bank_sql="";
        }

        if(!empty($request->start_date) && !empty($request->end_date)){

            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $date_sql = " and t.entry_date between '$start_date' and '$end_date' ";
        }else{
            $date_sql ="";
        }

        $condition = $date_sql.$fund_rec_bank_sql; 

        
       
        $get_data = DB::select(DB::raw("SELECT strb.bank_name, 
		t.sender_ex_h_location,
        exh.name as exchange_house_location,
        COUNT(t.id) as number_of_total_transaction, 
        sum(t.originated_amount) +sum(t.originated_customer_fee) as zar_with_charge, t.remarks  
        FROM `transactions` t 
        LEFT JOIN sender_transaction_receiving_bank strb on t.sender_transaction_receiving_bank=strb.id 
        LEFT JOIN ex_h_branches exh on t.sender_ex_h_location = exh.id
         WHERE  t.sender_transaction_receiving_bank is NOT null 
         $condition  
         GROUP BY t.sender_transaction_receiving_bank"));

        $data = [
            "get_data" => $get_data
        ];

        return view('admin.report.bank_wise_online_summary_report.details', $data);
    }
    // end function bank_wise_online_summary_report_details

    // ################### end bank wise online summary report #####################




    // ##################  beneficiary wise report ##################
    // start function beneficiary_wise_report
    public function beneficiary_wise_report(){
        
        return view('admin.report.beneficiary_wise_report.index');
    }

    // end function beneficiary_wise_report


    //start function beneficiary_wise_report_details
    public function beneficiary_wise_report_details(Request $request){
        
        if(!empty($request->start_date) && !empty($request->end_date)){

            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $sql_date = " WHERE tr.entry_date BETWEEN '$start_date' and '$end_date' ";
            
        }else{
            $sql_date ="";
        }

        $condition = $sql_date;

  
      $get_data =  DB::select(DB::raw("SELECT tr.trn_date,tr.receiver_name, tr.order_no, 
      bi.name as bank_name,bri.name as branch_name, tr.payment_mode, tr.sender_name, 
      tr.sender_account_number, tr.disbursement_amount, tr.originated_amount, 
      (tr.originated_amount + tr.originated_customer_fee) as total_zar_received,
       tr.sender_transaction_receiving_mode, tr.sender_ex_h_location, 
       exh.name as exchange_location FROM `transactions` tr  
       LEFT JOIN bank_infos bi on tr.receiver_bank=bi.id LEFT JOIN 
       branch_infos bri on tr.receiver_bank_branch = bri.id
      LEFT JOIN ex_h_branches exh on tr.sender_ex_h_location = exh.id
      $condition "));



        $data=[
            "get_data" =>  $get_data
        ];
        
       return view("admin.report.beneficiary_wise_report.details", $data);

    }
     //end function beneficiary_wise_report_details

    // ##################  beneficiary wise report ##################



    // ####################  transaction payout summary report ###########

    public function transaction_payout_summary_report(){
        return view('admin.report.transaction_payout_summary_report.index');
    }


    //start public function transaction_payout_summary_report_details
    public function transaction_payout_summary_report_details(Request $request){

        $transaction_array = [];

        $get_bank = DB::select(DB::raw("SELECT tr.sender_ex_h_location,exh.name as exchange_house_location, tr.receiver_bank,bi.name as rec_bank_name, COUNT(tr.receiver_bank) as count_rec_bank FROM `transactions` tr LEFT JOIN ex_h_branches exh on tr.sender_ex_h_location = exh.id
        LEFT JOIN bank_infos bi on tr.receiver_bank = bi.id
         WHERE receiver_bank is NOT null and stLevel=1 GROUP BY receiver_bank"));

        foreach($get_bank as $single_get_bank){       
            $transaction_array['bank'][$single_get_bank->receiver_bank] = [
                "bank_name" => $single_get_bank->rec_bank_name,
                "total_amount" => 0,
                "transactions" => []                
            ];
        }


                
        foreach($get_bank as $single_get_bank){  

            $get_data = DB::select(DB::raw("SELECT tr.sender_ex_h_location,exh.name as exchange_house_location, tr.receiver_bank, bi.name as rec_bank_name, COUNT(tr.receiver_bank) as count_rec_bank, (
                CASE 
                    WHEN tr.payment_mode = '1' THEN 'CASH'
                    WHEN tr.payment_mode = '2' && tr.receiver_bank=tr.agent_code THEN 'Account'
                    WHEN tr.payment_mode = '2' && tr.receiver_bank<>tr.agent_code THEN 'EFTN'
                
                    ELSE 1
                END) AS trn_type,COUNT(tr.id) no_of_trn, sum(tr.originated_amount) as total_zar_amt, SUM(tr.disbursement_amount) as total_bdt_amt FROM `transactions` tr LEFT JOIN ex_h_branches exh on tr.sender_ex_h_location = exh.id
            LEFT JOIN bank_infos bi on tr.receiver_bank = bi.id
            WHERE receiver_bank is NOT null and stLevel=1 and tr.receiver_bank='$single_get_bank->receiver_bank'   GROUP BY  payment_mode"));
           
            foreach($get_data as $single_data){
                $trn_info = [
                    "sender_ex_h_location"    => $single_data->sender_ex_h_location,
                    "exchange_house_location" => $single_data->exchange_house_location,
                    "receiver_bank"           => $single_data->receiver_bank,
                    "rec_bank_name"           => $single_data->rec_bank_name,
                    "count_rec_bank"          => $single_data->count_rec_bank,
                    "trn_type"                => $single_data->trn_type,
                    "no_of_trn"               => $single_data->no_of_trn,
                    "total_zar_amt"           => $single_data->total_zar_amt,
                    "total_bdt_amt"           => $single_data->total_bdt_amt
                ];

                $transaction_array['bank'][$single_data->receiver_bank]['total_amount'] += $single_data->total_bdt_amt;

                array_push($transaction_array['bank'][$single_data->receiver_bank]['transactions'], $trn_info);
            }

        }

         // return $transaction_array;

       
        
        $data = [
          
            "get_data" => $transaction_array
        ];

     

        return view('admin.report.transaction_payout_summary_report.details', $data);
    }

    //end public function transaction_payout_summary_report_details

    // ####################  end transaction payout summary report ###########

}
