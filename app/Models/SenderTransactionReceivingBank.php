<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenderTransactionReceivingBank extends Model
{
    use HasFactory;
    protected $table = "sender_transaction_receiving_bank";
    protected $guarded = [];

}
