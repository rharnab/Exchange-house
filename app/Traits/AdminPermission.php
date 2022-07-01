<?php

namespace App\Traits;

Trait AdminPermission{
    public function checkRequestPermission(){
        if (
            //Role section
            empty(auth()->user()->role->permission['permission']['role.index']['list'])  && \Route::is('role.index') ||
            empty(auth()->user()->role->permission['permission']['role.create']['create'])  && \Route::is('role.create') ||
            empty(auth()->user()->role->permission['permission']['role.edit']['edit'])  && \Route::is('role.edit') ||
            empty(auth()->user()->role->permission['permission']['role']['view'])  && \Route::is('role') ||
            empty(auth()->user()->role->permission['permission']['role.destroy']['delete'])  && \Route::is('role.destroy') ||
            //Permission section
            empty(auth()->user()->role->permission['permission']['permission.index']['list'])  && \Route::is('permission.index') ||
            empty(auth()->user()->role->permission['permission']['permission.create']['create'])  && \Route::is('permission.create') ||
            empty(auth()->user()->role->permission['permission']['permission.edit']['edit'])  && \Route::is('permission.edit') ||
            empty(auth()->user()->role->permission['permission']['permission']['view'])  && \Route::is('permission') ||
            empty(auth()->user()->role->permission['permission']['permission.destroy']['delete'])  && \Route::is('permission.destroy') ||
            //Agent section
            empty(auth()->user()->role->permission['permission']['agent.index']['list'])  && \Route::is('admin.agent_info') ||
            empty(auth()->user()->role->permission['permission']['agent.create']['create'])  && \Route::is('admin.store_agent_info') ||
            empty(auth()->user()->role->permission['permission']['agent.edit']['edit'])  && \Route::is('admin.agent_info_edit') ||
            empty(auth()->user()->role->permission['permission']['agent']['view'])  && \Route::is('admin.agent_info') ||
            empty(auth()->user()->role->permission['permission']['agent.auth']['auth'])  && \Route::is('admin.agent_info_authorize') ||
            empty(auth()->user()->role->permission['permission']['agent.decline']['decline'])  && \Route::is('admin.agent_info_decline') ||
            //Currency section
            empty(auth()->user()->role->permission['permission']['currency.index']['list'])  && \Route::is('admin.agent_info') ||
            empty(auth()->user()->role->permission['permission']['currency']['view'])  && \Route::is('admin.currency') ||
            empty(auth()->user()->role->permission['permission']['currency.create']['create'])  && \Route::is('admin.currency_store') ||
            empty(auth()->user()->role->permission['permission']['currency.edit']['edit'])  && \Route::is('admin.currency_edit') ||
            //Currency rate section
            empty(auth()->user()->role->permission['permission']['rate']['view'])  && \Route::is('admin.currency_rate') ||
            empty(auth()->user()->role->permission['permission']['rate.index']['list'])  && \Route::is('admin.currency_rate') ||
            empty(auth()->user()->role->permission['permission']['rate.create']['create'])  && \Route::is('admin.currency_rate_create') ||
            empty(auth()->user()->role->permission['permission']['rate.edit']['edit'])  && \Route::is('admin.currency_rate_edit') ||
            empty(auth()->user()->role->permission['permission']['rate.auth']['auth'])  && \Route::is('admin.currency_rate_authorize')||
            empty(auth()->user()->role->permission['permission']['rate.decline']['decline'])  && \Route::is('admin.currency_rate_decline')||
            //Transaction fee section
            empty(auth()->user()->role->permission['permission']['fee']['view'])  && \Route::is('admin.transaction_charge_list') ||
            empty(auth()->user()->role->permission['permission']['fee.index']['list'])  && \Route::is('admin.transaction_charge_list') ||
            empty(auth()->user()->role->permission['permission']['fee.create']['create'])  && \Route::is('admin.transaction_charge_create') ||
            empty(auth()->user()->role->permission['permission']['fee.edit']['edit'])  && \Route::is('admin.transaction_charge_edit') ||
            empty(auth()->user()->role->permission['permission']['fee.auth']['auth'])  && \Route::is('admin.transaction_charge_authorize')||
            empty(auth()->user()->role->permission['permission']['fee.decline']['decline'])  && \Route::is('admin.transaction_charge_decline') ||
            //Customer section
            empty(auth()->user()->role->permission['permission']['customer']['view'])  && \Route::is('admin.transaction_charge_list') ||
            empty(auth()->user()->role->permission['permission']['customer.index']['list'])  && \Route::is('admin.customer_list') ||
            empty(auth()->user()->role->permission['permission']['customer.create']['create'])  && \Route::is('admin.customer_add') ||
            empty(auth()->user()->role->permission['permission']['customer.edit']['edit'])  && \Route::is('admin.customer_edit') ||
            empty(auth()->user()->role->permission['permission']['customer.auth']['auth'])  && \Route::is('admin.customer_auth') ||
            empty(auth()->user()->role->permission['permission']['customer.decline']['decline'])  && \Route::is('admin.transaction_charge_decline') ||
            //Account section
            empty(auth()->user()->role->permission['permission']['account']['view'])  && \Route::is('admin.account_list') ||
            empty(auth()->user()->role->permission['permission']['account.index']['list'])  && \Route::is('admin.account_list') ||
            empty(auth()->user()->role->permission['permission']['account.create']['create'])  && \Route::is('admin.account_create') ||
            empty(auth()->user()->role->permission['permission']['account.edit']['edit'])  && \Route::is('admin.account_edit') ||
            empty(auth()->user()->role->permission['permission']['account.auth']['auth'])  && \Route::is('admin.account_authorize') ||
            empty(auth()->user()->role->permission['permission']['account.decline']['decline'])  && \Route::is('admin.account_decline')||
            //Remittance section
            empty(auth()->user()->role->permission['permission']['remittance']['view'])  && \Route::is('admin.transaction.list') ||
            empty(auth()->user()->role->permission['permission']['remittance.index']['list'])  && \Route::is('admin.transaction.list') ||
            empty(auth()->user()->role->permission['permission']['remittance.create']['create'])  && \Route::is('admin.transaction_crate_search') ||
            empty(auth()->user()->role->permission['permission']['remittance.edit']['edit'])  && \Route::is('admin.account_edit') ||
            empty(auth()->user()->role->permission['permission']['remittance.auth']['auth'])  && \Route::is('admin.auth_trn') ||
            empty(auth()->user()->role->permission['permission']['remittance.decline']['decline'])  && \Route::is('admin.declined_trn') ||
            //User section
            empty(auth()->user()->role->permission['permission']['user']['view'])  && \Route::is('admin.user_list') ||
            empty(auth()->user()->role->permission['permission']['user.index']['list'])  && \Route::is('admin.user_list') ||
            empty(auth()->user()->role->permission['permission']['user.create']['create'])  && \Route::is('admin.user_create') ||
            empty(auth()->user()->role->permission['permission']['user.edit']['edit'])  && \Route::is('admin.user_edit') ||
            //Sanction screening section
            empty(auth()->user()->role->permission['permission']['sanction']['view'])  && \Route::is('admin.sanction.parameter')
        ) {
            return route('admin.dashboard');
        }
    }
}
