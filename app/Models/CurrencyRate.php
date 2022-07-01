<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;
    protected $table = "currency_rates";
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(CountryInfo::class,'country_id');
    }

    public function fromCurrency()
    {
        return $this->belongsTo(CurrencyInfo::class,'from_currency_id');
    }
    public function toCurrency()
    {
        return $this->belongsTo(CurrencyInfo::class,'to_currency_id');
    }

    public function bank()
    {
        return $this->belongsTo(BankInfo::class,'bank_id');
    }
}
