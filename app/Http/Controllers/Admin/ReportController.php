<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountOpening;
use App\Models\LogInfo;
use App\Models\SanctionLog;
use App\Models\Transaction;
use App\Models\SenderTransactionReceivingBank;
use App\Models\CustomerInfo;
use App\Models\TransactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
            "exchange_location" => $single_get_bank->exchange_house_location,
            "bank_name" => $single_get_bank->rec_bank_name,
            "transaction"=>[],
            "amount"=>0
        ];

        $get_data = DB::select(DB::raw("SELECT tr.sender_ex_h_location,exh.name as exchange_house_location, tr.receiver_bank, bi.name as rec_bank_name, COUNT(tr.receiver_bank) as count_rec_bank, (
            CASE
                WHEN tr.payment_mode = '1' THEN 'CASH'
                WHEN tr.payment_mode = '2' && tr.receiver_bank=tr.agent_code THEN 'Account'
                WHEN tr.payment_mode = '2' && tr.receiver_bank<>tr.agent_code THEN 'EFTN'

                ELSE 1
            END) AS trn_type,COUNT(tr.id) no_of_trn, sum(tr.originated_amount) as total_zar_amt, SUM(tr.disbursement_amount) as total_bdt_amt FROM `transactions` tr LEFT JOIN ex_h_branches exh on tr.sender_ex_h_location = exh.id
        LEFT JOIN bank_infos bi on tr.receiver_bank = bi.id
        WHERE receiver_bank is NOT null and stLevel=1 and tr.receiver_bank='$single_get_bank->receiver_bank'   GROUP BY  payment_mode"));

        foreach($get_data as $single_get_data){

            $trn_data = [
                "exchange_house_location" => $single_get_data->exchange_house_location,
                "trn_type" => $single_get_data->trn_type,
                "no_of_trn" => $single_get_data->no_of_trn,
                "total_zar_amt" => $single_get_data->total_zar_amt,
                "total_bdt_amt" => $single_get_data->total_bdt_amt,
            ];

            $transaction_array['bank'][$single_get_bank->receiver_bank]['amount'] += $single_get_data->total_bdt_amt;
            array_push($transaction_array['bank'][$single_get_bank->receiver_bank]['transaction'], $trn_data);

        }



    }


       $data = [
           "get_data" => $transaction_array
       ];

    //    return $data;
        return view('admin.report.transaction_payout_summary_report.details', $data);


    }

    //end public function transaction_payout_summary_report_details

    // ####################  end transaction payout summary report ###########


    // ##############  id type expire date report

        public function id_type_expire_date_report(){
            return view('admin.report.id_type_expire_date_report.index');
        }
        // start function id_type_expire_date_report_details
         public function id_type_expire_date_report_details(Request $request){

            if(!empty($request->start_date) && !empty($request->end_date)){

                $start_date = $request->start_date;
                $end_date = $request->end_date;

                $date_sql = "  and (ci.expire_date BETWEEN '$start_date' and '$end_date')";

            }else{
                $date_sql = "";
            }

            $get_data = DB::select(DB::raw("SELECT  ci.id,ao.account_no,  exh.name as exchange_house_location, ci.id_number, ci.expire_date,ci.contact_number, ci.remarks FROM `customer_infos` ci
            LEFT JOIN account_openings ao on  ci.id = ao.customer_id
            LEFT JOIN ex_h_branches exh on ci.entry_by_house_location = exh.id
            where ci.expire_date is NOT null $date_sql"));

             $data = [
                 "get_data" => $get_data
             ];

            //  return $data;

            return view('admin.report.id_type_expire_date_report.details', $data);

         }
         // end function id_type_expire_date_report_details
         // ############## end id type expire date report

         // cashier wise task report
         public function cashier_wise_task_report(){

            return view('admin.report.cashier_wise_task_report.index');
         }



         public function cashier_wise_task_report_details(Request $request){
            return view('admin.report.cashier_wise_task_report.details');
         }

         // end cashier wise task report


         // new customer creation report
         public function new_customer_creation_report(){
            return view('admin.report.new_customer_creation_report.index');
         }

         public function new_customer_creation_report_details(Request $request){

            if(!empty($request->start_date)){

                $start_date = $request->start_date;

                $start_date_sql = " and ci.entry_date >= '$start_date' ";

            }else{
                $start_date_sql = "";
            }


            if(!empty($request->end_date)){

                $end_date = $request->end_date;

                $end_date_sql = " and ci.entry_date <= '$end_date' ";

            }else{
                $end_date_sql = "";
            }

            $condition = $start_date_sql . $end_date_sql;


           $get_data = DB::select(DB::raw("SELECT ci.created_at, ci.name, ao.account_no,ci.id_type,
            ci.id_number, ci.contact_number, ci.entry_date, ci.entry_by, it.name as id_type_name FROM `customer_infos` ci
            LEFT JOIN account_openings ao on ci.id = ao.customer_id
            LEFT JOIN identification_types it on ci.id_type = it.id
             WHERE ci.status='1'
              $condition "));

            $data = [
                "get_data" => $get_data
            ];


            return view('admin.report.new_customer_creation_report.details', $data);
         }

    // end new customer creation report

    // start function payment_method_wise_report
    public function payment_method_wise_report(){
        return view('admin.report.payment_method_wise_report.index');
    }


    public function payment_method_wise_report_details(){
        return view('admin.report.payment_method_wise_report.details');
    }

    // end payement method wise report

    //start rate history report
    public function rate_history_report(){
        return view('admin.report.rate_history_report.index');
    }

    public function rate_history_report_details(){
        return view('admin.report.rate_history_report.details');
    }

     //end rate history report


     // start reconcilation report
     public function reconcilation_report(){

        return view('admin.report.reconcilation-report.index');
     }

     public function reconcilation_report_details(){
        return view('admin.report.reconcilation-report.details');
     }

    // end reconcilation report

    // start function remitter_certificate
    public function remitter_certificate(){
        $get_customer = CustomerInfo::where('status',1)->get();
        $data = [
            "get_customer" => $get_customer
        ];
        return view('admin.report.remitter-certificate.index', $data);
    }

    public function remitter_certificate_details(Request $request){

       $remitter_ceritificate = $request->remitter_ceritificate;
       $start_date = $request->start_date;
       $end_date = $request->end_date;

       $pdf = PDF::loadView('admin.report.remitter-certificate.pdf');


        return $pdf->stream('remitter-certificate'.'.pdf');

    }

    // end function remitter_certificate

    // start function remitter_transaction_history
    public function remitter_transaction_history(){
        return view('admin.report.remitter-transaction-history.index');
    }

    public function remitter_transaction_history_details(){

        $pdf = PDF::loadView('admin.report.remitter-transaction-history.pdf');
        return $pdf->stream('remitter-transaction-history'.'.pdf');

    }
    // end function remitter_transaction_history


    //Sanction screening report for customer
    public function sanctionReportCustomer() {
        return view('admin.report.sanction.customerSearch');
    }
    public function sanctionReportCustomerGenerate(Request $request) {
        if($request->type == 'Customer create') {
            $data = SanctionLog::where('type', 'Customer')->where('operation_name','Customer create')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.customer', [
                'data' => $data
            ]);

        } elseif ($request->type == 'Customer authorize') {
            $data = SanctionLog::where('type', 'Customer')->where('operation_name','Customer authorize')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.customer', [
                'data' => $data
            ]);
        } elseif ($request->type == 'Customer update') {
            $data = SanctionLog::where('type', 'Customer')->where('operation_name','Customer update')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.customer', [
                'data' => $data
            ]);
        } else {
            $data = SanctionLog::where('type', 'Customer')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.customer', [
                'data' => $data
            ]);
        }
    }

    //Sanction screening report for account
    public function sanctionReportAccount() {
        return view('admin.report.sanction.accountSearch');
    }
    public function sanctionReportAccountGenerate(Request $request) {
        if($request->type == 'Account create') {
            $data = SanctionLog::where('type', 'Account')->where('operation_name','Account create')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.account', [
                'data' => $data
            ]);

        } elseif ($request->type == 'Account authorize') {
            $data = SanctionLog::where('type', 'Account')->where('operation_name','Account authorize')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.account', [
                'data' => $data
            ]);
        } elseif ($request->type == 'Account update') {
            $data = SanctionLog::where('type', 'Account')->where('operation_name','Account update')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.account', [
                'data' => $data
            ]);
        } else {
            $data = SanctionLog::where('type', 'Account')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.account', [
                'data' => $data
            ]);
        }
    }

    //Sanction screening report for transaction
    public function sanctionReportTransaction() {
        return view('admin.report.sanction.transactionSearch');
    }
    public function sanctionReportTransactionGenerate(Request $request) {
        if($request->type == 'Transaction create') {
            $data = SanctionLog::where('type', 'Transaction')->where('operation_name','Transaction create')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.transaction', [
                'data' => $data
            ]);

        } elseif ($request->type == 'Transaction authorize') {
            $data = SanctionLog::where('type', 'Transaction')->where('operation_name','Transaction authorize')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.transaction', [
                'data' => $data
            ]);
        } else {
            $data = SanctionLog::where('type', 'Transaction')->whereBetween('entry_date', [$request->startDate, $request->endDate])->get();
            return view('admin.report.sanction.transaction', [
                'data' => $data
            ]);
        }
    }

    //Sanction screening report for individual user/account
    public function individualSearch() {
        return view('admin.report.sanction.individualSearch');
    }
    public function individualSearchReportGenerate(Request $request) {
        $searchData = $request->search;
        if ($searchData === null) {
            //Store data into transaction log table
            $logData = new TransactionLog();
            $logData->model_name = 'Sanction Logs';
            $logData->operation_name = 'Sanction report for individual create user';
            $logData->status = 'Failed';
            $logData->reason = 'Empty field found';
            $logData->entry_by = Auth::user()->user_id;
            $logData->entry_date = now();
            $logData->ip_address = $request->ip();
            $logData->save();
            return redirect()->route('admin.sanction.individual.report')->with('message','Empty field found!!');
        } else {
            //Search user from customer or account table based on the input
            $customerCheck = DB::select("SELECT cu.* FROM customer_infos cu WHERE (cu.contact_number = '$searchData' OR cu.id_number='$searchData') AND cu.status = 1 ");
            if ($customerCheck) {
                $info = $customerCheck[0];
                return view('admin.report.sanction.individual', [
                    'info' => $info
                ]);
            } else {
                //Store data into transaction log table
                $logData = new TransactionLog();
                $logData->model_name = 'Sanction Logs';
                $logData->operation_name = 'Sanction report for individual create user';
                $logData->status = 'Failed';
                $logData->reason = 'No data found';
                $logData->entry_by = Auth::user()->user_id;
                $logData->entry_date = now();
                $logData->ip_address = $request->ip();
                $logData->save();
                return redirect()->route('admin.sanction.individual.report')->with('message','No data found!!');
            }

        }
    }

}
