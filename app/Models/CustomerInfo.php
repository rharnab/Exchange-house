<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    use HasFactory;
    protected $table = "customer_infos";
    protected $guarded = [];

    public function identification()
    {
        return $this->belongsTo(IdentificationType::class,'id_type');
    }

    public function country()
    {
        return $this->belongsTo(CountryInfo::class,'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class, 'occupation_id');
    }

    public function exchangeBranch() {
        return $this->belongsTo(ExHBranch::class, 'entry_by_house_location');
    }
}
