<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountOpening extends Model
{
    use HasFactory;
    protected $table = 'account_openings';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(CustomerInfo::class);
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function branch() {
        return $this->belongsTo(BranchInfo::class);
    }
}
