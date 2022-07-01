<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanctionCheck extends Model
{
    use HasFactory;
    protected $table = "sanction_checks";
    protected $guarded = [];
}
