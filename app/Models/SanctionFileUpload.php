<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanctionFileUpload extends Model
{
    use HasFactory;
    protected $table = 'sanction_file_uploads';
    protected $guarded = [];
}
