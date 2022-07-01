<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanctionLog extends Model
{
    use HasFactory;
    protected $table = 'sanction_logs';
    protected $guarded = [];

    public function customer() {
        return $this->belongsTo(CustomerInfo::class,'operation_id');
    }
    public function account()
    {
        return $this->belongsTo(AccountOpening::class,'operation_id');
    }
}
