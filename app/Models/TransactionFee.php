<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionFee extends Model
{
    use HasFactory;
    protected $table = "transaction_fees";
    protected $guarded = [];
    public function country()
    {
        return $this->belongsTo(CountryInfo::class,'country_id');
    }
    public function currency() {
        return $this->belongsTo(CurrencyInfo::class, 'currency_id');
    }
}
