<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ScreenFileUploadController;
use App\Http\Controllers\Controller;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes(['register' => false]);

Route::get('/', function () {
    return view('auth.login');
})->name('site_login');

//Admin routes
Route::group(['prefix'=>'admin','middleware' =>['admin','auth', 'permission']], function(){
    //Dashboard section
    Route::get('/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');

    //Customer section
    Route::get('/customer-list',[CustomerController::class, 'index'])->name('admin.customer_list');
    Route::get('/customer-registration',[CustomerController::class, 'addCustomer'])->name('admin.customer_add');
    Route::get('/get-city/{id}',[CustomerController::class,'getCity']);
    Route::post('/store-customer', [CustomerController::class, 'store'])->name('admin.customer_store');
    Route::get('/download-document/{id}', [CustomerController::class, 'downloadDoc'])->name('admin.download_doc');
    Route::get('/customer-authorize', [CustomerController::class, 'authCustomer'])->name('admin.customer_auth');
    Route::get('/customer-active/{id}',[CustomerController::class,'activeCustomer']);
    Route::get('/customer-inactive/{id}',[CustomerController::class,'inactiveCustomer']);
    Route::get('/customer-edit', [CustomerController::class, 'edit'])->name('admin.customer_edit');
    Route::post('/customer-search', [CustomerController::class, 'searchCustomer'])->name('admin.customer_search');
    Route::post('/customer-update', [CustomerController::class, 'update'])->name('admin.customer_update');
    Route::get('/customer-delete/{id}',[CustomerController::class,'deleteCustomer']);

    ################################## update with sanction screen ###########################
    Route::post("authcustomerScreen", [CustomerController::class, 'authcustomerScreenModal'])->name('authcustomerScreen');
    Route::post('customer-authorize', [CustomerController::class, 'customer_authorize'])->name('admin.customer.autrize');
    ################################## update with sanction screen ###########################



    //Currency section
    Route::get('/currency',[AdminController::class, 'currency_list'])->name('admin.currency');
    Route::post('/currency-store',[AdminController::class, 'currency_store'])->name('admin.currency_store');
    Route::get('/currency-edit/{id}',[AdminController::class, 'currency_edit'])->name('admin.currency_edit');
    Route::post('/currency-update',[AdminController::class, 'currency_update'])->name('admin.currency_update');

    //Account section
    Route::get('/account-list', [AccountController::class, 'index'])->name('admin.account_list');
    Route::get('/account-create', [AccountController::class, 'create'])->name('admin.account_create');
    Route::get('/customer-search-for-account', [AccountController::class, 'searchCustomerForAccount'])->name('admin.customer_search_for_account');
    Route::get('/get-rate/{id}',[AccountController::class,'get_rate']);
    Route::post('/store-account', [AccountController::class, 'store'])->name('admin.account_store');
    Route::get('/download-signature/{id}', [AccountController::class, 'downloadSignature'])->name('admin.download_signature');
    Route::get('/account-active/{id}',[AccountController::class,'activeAccount']);
    Route::get('/account-inactive/{id}',[AccountController::class,'inactiveAccount'])->name('admin.account_decline');
    Route::get('/account-authorize', [AccountController::class, 'unauthorizedData'])->name('admin.account_authorize');
    Route::get('/account-edit',[AccountController::class, 'updateAccount'])->name('admin.account_edit');
    Route::post('/account-search', [AccountController::class, 'searchAccountToUpdate'])->name('admin.search_account');
    Route::post('/account-update', [AccountController::class, 'updateAccountInfo'])->name('admin.account_update');

    ################################## update with sanction screen ###########################
    Route::post("authAccountScreen", [AccountController::class, 'authAccountScreenModal'])->name('authAccountScreen');
    Route::post('account-authorize', [AccountController::class, 'account_authorize'])->name('admin.account.autrize');
    ################################## update with sanction screen ###########################

    //Currency rate section
    Route::get('/currency-rate-list',[AdminController::class, 'currency_rate'])->name('admin.currency_rate');
    Route::get('/currency-rate-create',[AdminController::class, 'currency_rate_create'])->name('admin.currency_rate_create');
    Route::post('/currency-rate-store',[AdminController::class, 'currency_rate_store'])->name('admin.currency_rate_store');
    Route::post('/get-bank-from-country-id',[AdminController::class, 'get_bank_from_country_id'])->name('admin.get_bank_from_country_id');

    Route::post('/get-bank-from-country-id-with-agent',[AdminController::class, 'getBankWithAgent'])->name('admin.get_bank_with_agent');

    Route::post('/get-currency-from-country-id',[AdminController::class, 'get_currency_from_country_id'])->name('admin.get_currency_from_country_id');
    Route::get('/currency-rate-authorize/{id}',[AdminController::class, 'currency_rate_authorize'])->name('admin.currency_rate_authorize');
    Route::get('/currency-rate-decline/{id}',[AdminController::class, 'currency_rate_decline'])->name('admin.currency_rate_decline');
    Route::get('/currency-rate-edit/{id}',[AdminController::class, 'currency_rate_edit'])->name('admin.currency_rate_edit');
    Route::post('/currency-rate-update',[AdminController::class, 'currency_rate_update'])->name('admin.update_currency_rate');

    //Transaction Charge or commission
    Route::get('/transaction-charge-list',[TransactionController::class, 'transaction_charge_list'])->name('admin.transaction_charge_list');
    Route::get('/transaction-charge-create',[TransactionController::class, 'transaction_charge'])->name('admin.transaction_charge_create');
    Route::post('/transaction-charge-store',[TransactionController::class, 'transaction_charge_store'])->name('admin.transaction_charge_store');
    Route::get('/transaction-charge-authorize/{id}',[TransactionController::class, 'transaction_charge_authorize'])->name('admin.transaction_charge_authorize');
    Route::get('/transaction-charge-decline/{id}',[TransactionController::class, 'transaction_charge_decline'])->name('admin.transaction_charge_decline');
    Route::get('/transaction-charge-edit/{id}',[TransactionController::class, 'transaction_charge_edit'])->name('admin.transaction_charge_edit');
    Route::post('/update_transaction_charge',[TransactionController::class, 'update_transaction_charge'])->name('admin.update_transaction_charge');

     ################################## update with sanction screen ###########################
     Route::post("authTransactionScreen", [TransactionController::class, 'authTransactionScreenModal'])->name('authTransactionScreen');
     Route::post('transaction-authorize', [TransactionController::class, 'transaction_authorize'])->name('admin.transaction.autrize');
     ################################## update with sanction screen ###########################

    //Agent setup section
    Route::get('/agent-info',[AdminController::class, 'agent_info'])->name('admin.agent_info');
    Route::post('/agent-info-store',[AdminController::class, 'agent_info_store'])->name('admin.store_agent_info');
    Route::get('/agent-info-list',[AdminController::class, 'agent_info_list'])->name('admin.agent_info_list');
    Route::get('/agent-info-authorize/{id}',[AdminController::class, 'agent_info_authorize'])->name('admin.agent_info_authorize');
    Route::get('/agent-info-decline/{id}',[AdminController::class, 'agent_info_decline'])->name('admin.agent_info_decline');
    Route::get('/agent-info-edit/{id}',[AdminController::class, 'agent_info_edit'])->name('admin.agent_info_edit');
    Route::post('/update_agent_info',[AdminController::class, 'update_agent_info'])->name('admin.update_agent_info');

    //Transaction section
    Route::get('/transaction-search', [TransactionController::class, 'transactCreateSearch'])->name('admin.transaction_crate_search');
    Route::get('/transaction-search-result', [TransactionController::class, 'transactCreateSearchData'])->name('admin.transaction_crate_search_data');
    Route::post('/transaction-store', [TransactionController::class, 'storeTransaction'])->name('admin.transaction_store');
    Route::get('/transaction-list',[TransactionController::class, 'transactionList'])->name('admin.transaction.list');
    Route::get('/transaction-to-authorized-list',[TransactionController::class, 'transactionAuthList'])->name('admin.transaction_auth');
    Route::get('/transaction-authorized/{id}', [TransactionController::class, 'authTransaction'])->name('admin.auth_trn');
    Route::get('/transaction-declined/{id}', [TransactionController::class, 'declineTransaction'])->name('admin.declined_trn');

    Route::post('/transaction-get-sub-country',[TransactionController::class, 'getSubCountryTrn'])->name('admin.get_sub_country_trn');
    Route::post('/transaction-get-city',[TransactionController::class, 'geCityTrn'])->name('admin.get_city_trn');
    Route::post('/transaction-get-receiver-bank-from-country',[TransactionController::class, 'getReceiverBankFromCountry'])->name('admin.get_receiver_bank_from_country_trn');
    Route::post('/transaction-get-receiver-bank-branch-from-country',[TransactionController::class, 'getReceiverBankBranchFromCountry'])->name('admin.get_receiver_bank_branch_from_country_trn');
    Route::post('/transaction-get-agent-bank-name-from-country',[TransactionController::class, 'getAgentBankNameFromCountry'])->name('admin.get_agent_bank_name_from_country_trn');

    //For calculation
    Route::post('/rate-calculation', [TransactionController::class, 'calculationRate'])->name('admin.rate-calculation');
    Route::post('/total-cost', [TransactionController::class, 'totalCost'])->name('admin.total_cost');
    Route::post('/total-cost1', [TransactionController::class, 'totalCost1'])->name('admin.total_cost1');

    //To print voucher
    Route::get('/transaction-voucher-print/{id}', [TransactionController::class, 'voucherPrint']);
    // Route::get('/test-transaction-voucher-print', [TransactionController::class, 'testvoucherPrint']);

    //Track transaction
    Route::get('/track-transaction', [TransactionController::class, 'trackTransaction'])->name('admin.trackTransaction');
    Route::post('/track-transaction-search', [TransactionController::class, 'trackTransactionSearch'])->name('admin.track_transaction_search');

    //Report section
    //Transaction
    Route::get('/transaction-report', [ReportController::class, 'transaction_report'])->name('admin.transaction_report');
    Route::get('/transaction-report-show', [ReportController::class, 'transaction_report_show'])->name('admin.transaction_report_show');
    //Account
    Route::get('/account-report', [ReportController::class, 'account_report'])->name('admin.account_report');
    Route::get('/account-report-show', [ReportController::class, 'account_report_show'])->name('admin.account_report_show');

    //Role and permission section
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);

    //User register section
    Route::get('/user-list',[AdminUserController::class, 'userList'])->name('admin.user_list');
    Route::get('/user-create',[AdminUserController::class, 'userCreate'])->name('admin.user_create');
    Route::post('/user-store',[AdminUserController::class, 'userStore'])->name('admin.user_store');
//    Route::get('/user-active/{id}',[AdminUserController::class,'activeUser'])->name('admin.user_active');
//    Route::get('/user-inactive/{id}',[AdminUserController::class,'inactiveUser'])->name('admin.user_inactive');
    Route::get('/user-edit/{id}',[AdminUserController::class, 'userEdit'])->name('admin.user_edit');
    Route::post('/user-update',[AdminUserController::class, 'userUpdate'])->name('admin.user_update');



    // bank wise online summary report
    Route::get('/bank-wise-online-summary-report', [ReportController::class, 'bank_wise_online_summary_report'])->name('admin.bank_wise_online_summary_report');
    Route::post('/bank-wise-online-summary-report-details', [ReportController::class, 'bank_wise_online_summary_report_details'])->name('admin.bank_wise_online_summary_report_details');

    // Beneficiary Wise Report
    Route::get('/beneficiary-wise-report', [ReportController::class, 'beneficiary_wise_report'])->name('admin.beneficiary_wise_report');
    Route::post('/beneficiary-wise-report-details', [ReportController::class, 'beneficiary_wise_report_details'])->name('admin.beneficiary_wise_report_details');

    // Transaction Payout Summary Report
    Route::get('/transaction-payout-summary-report', [ReportController::class, 'transaction_payout_summary_report'])->name('admin.transaction_payout_summary_report');
    Route::post('/transaction-payout-summary-report-details', [ReportController::class, 'transaction_payout_summary_report_details'])->name('admin.transaction_payout_summary_report_details');

     // Transaction Payout Summary Report
      Route::get('/id-type-expire-date-report', [ReportController::class, 'id_type_expire_date_report'])->name('admin.id_type_expire_date_report');
     Route::post('/id-type-expire-date-report-details', [ReportController::class, 'id_type_expire_date_report_details'])->name('admin.id_type_expire_date_report_details');

     // Cashier Wise Task Report

     Route::get('/cashier-wise-task-report', [ReportController::class, 'cashier_wise_task_report'])->name('admin.cashier_wise_task_report');
     Route::post('/cashier-wise-task-report-details', [ReportController::class, 'cashier_wise_task_report_details'])->name('admin.cashier_wise_task_report_details');

     // new customer creation report
     Route::get('new-customer-creation-report', [ReportController::class, 'new_customer_creation_report'])->name('admin.new_customer_creation_report');
     Route::post('new-customer-creation-report-details', [ReportController::class, 'new_customer_creation_report_details'])->name('admin.new_customer_creation_report_details');

    // payment method wise report
    Route::get('payment-method-wise-report', [ReportController::class, 'payment_method_wise_report'])->name('admin.payment_method_wise_report');
    Route::post('payment-method-wise-report-details', [ReportController::class, 'payment_method_wise_report_details'])->name('admin.payment_method_wise_report_details');


    // Rate history report
    Route::get('rate-history-report', [ReportController::class, 'rate_history_report'])->name('admin.rate_history_report');
    Route::post('rate-history-report-details', [ReportController::class, 'rate_history_report_details'])->name('admin.rate_history_report_details');


    // reconcilation report
    Route::get('reconcilation-report', [ReportController::class, 'reconcilation_report'])->name('admin.reconcilation-report');
    Route::post('reconcilation-report-details', [ReportController::class, 'reconcilation_report_details'])->name('admin.reconcilation-report-details');

    // remitter-certificate
    Route::get('remitter-certificate', [ReportController::class, 'remitter_certificate'])->name('admin.remitter-certificate');
    Route::post('remitter-certificate-details', [ReportController::class, 'remitter_certificate_details'])->name('admin.remitter-certificate-details');

    //remitter-transaction-history
    Route::get('remitter-transaction-history', [ReportController::class, 'remitter_transaction_history'])->name('admin.remitter-transaction-history');
    Route::post('remitter-transaction-history-details', [ReportController::class, 'remitter_transaction_history_details'])->name('admin.remitter-transaction-history-details');


    //Profile settings
    Route::get('/profile', [AdminController::class, 'profileIndex'])->name('admin.profile.index');
    Route::post('/update/data',[AdminController::class, 'updateProfileData'])->name('admin.update.profile');
    Route::post('/update/password',[AdminController::class, 'updateAdminPassword'])->name('admin.update.password');

    //Sanction screen section
    //Route::post('/get-sanction-data',[CustomerController::class,'sanctionCheck'])->name('admin.sanctionCheck');
    Route::get('/read-data-d', [CustomerController::class,'readDta']);

    //Sanction screening parameter section
    Route::get('/sanction-screening/parameter-setup', [AccountController::class, 'sanctionIndex'])->name('admin.sanction.parameter');
    Route::post('/sanction-screening/parameter-setup/update',[AccountController::class, 'updateSanctionInfo'])->name('admin.sanction.parameter.update');
    Route::post('/sanction-screening/score-check/update',[AccountController::class, 'updateSanctionCheck'])->name('admin.sanction.check.update');

    //Sanction screening report
    Route::get('/sanction-report/customer', [ReportController::class, 'sanctionReportCustomer'])->name('admin.sanction.customer.report');
    Route::get('/sanction-report/customer/generate', [ReportController::class, 'sanctionReportCustomerGenerate'])->name('admin.sanction.customer.report.generate');

    Route::get('/sanction-report/account', [ReportController::class, 'sanctionReportAccount'])->name('admin.sanction.account.report');
    Route::get('/sanction-report/account/generate', [ReportController::class, 'sanctionReportAccountGenerate'])->name('admin.sanction.account.report.generate');

    Route::get('/sanction-report/transaction', [ReportController::class, 'sanctionReportTransaction'])->name('admin.sanction.transaction.report');
    Route::get('/sanction-report/transaction/generate', [ReportController::class, 'sanctionReportTransactionGenerate'])->name('admin.sanction.transaction.report.generate');

    Route::get('/sanction-report/individual', [ReportController::class, 'individualSearch'])->name('admin.sanction.individual.report');
    Route::get('/sanction-report/individual/generate', [ReportController::class, 'individualSearchReportGenerate'])->name('admin.sanction.individual.report.generate');

    //Excel file upload for sanction screening
    Route::get('/excel/sanction-screen/index', [ScreenFileUploadController::class,'sanctionScreenFileIndex'])->name('admin.screening_file_upload');
    Route::post('/excel/sanction-screen/store', [ScreenFileUploadController::class,'sanctionScreenFileStore'])->name('admin.screening_data_store');
//    Route::get('test-data', [ScreenFileUploadController::class, 'addSanction']);

    Route::get('/export-result/sanction-screen/', [ScreenFileUploadController::class,'exportData'])->name('admin.sanction.exportToExcel');



});

//User routes
Route::group(['prefix'=>'user','middleware' =>['user','auth']], function(){
    Route::get('dashboard',[UserController::class, 'index'])->name('user.dashboard');
});



######################################################## Global saction screen route ###############
Route::post('sanctionScreeCheck',[Controller::class,'sanctionScreeCheck'])->name('sanctionScreeCheck');
######################################################## Global saction screen route ###############

################################################# excel file upload #########################################
// Route::group(['prefix' => 'admin', 'as'=> 'admin.'], function(){
//     Route::get('sanction-screen', [ScreenFileUploadController::class,'index'])->name('screening_file_upload');
//     Route::post('sanction-screen', [ScreenFileUploadController::class,'store'])->name('screening_data_store');
// });
################################################# excel file upload #########################################
