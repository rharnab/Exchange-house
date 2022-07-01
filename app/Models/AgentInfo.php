<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentInfo extends Model
{
    use HasFactory;
    protected $table = "agent_infos";
    protected $guarded = [];
    public function country()
    {
        return $this->belongsTo(CountryInfo::class,'country_id');
    }
    public function bank()
    {
        return $this->belongsTo(BankInfo::class,'bankCode');
    }
}
