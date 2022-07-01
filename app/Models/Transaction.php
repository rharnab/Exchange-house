<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $guarded = [];

    public function country() {
        return $this->belongsTo(CountryInfo::class, 'receiver_country');
    }

    public function agent() {
        return $this->belongsTo(BankInfo::class, 'agent_code');
    }

    public function currency() {
        return $this->belongsTo(CurrencyInfo::class, 'disbursement_currency');
    }

    public function receiverDivision() {
        return $this->belongsTo(SubCountryInfo::class, 'receiver_sub_country_level_1');
    }

    public function receiverCity() {
        return $this->belongsTo(City::class, 'receiver_sub_country_level_2');
    }

    public function receiverBank() {
        return $this->belongsTo(BankInfo::class, 'receiver_bank');
    }

    public function receiverBankBranch() {
        return $this->belongsTo(BranchInfo::class, 'receiver_bank_branch');
    }

    public function sCurrency() {
        return $this->belongsTo(CurrencyInfo::class, 'originated_currency');
    }

    // public function exHBranch(){
    //     return $this->belongsTo(ExHBranch::class, 'entry_by_house_location');
    // }

}
