<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name',
        'created_by'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function permission() {
        return $this->hasOne(Permission::class, 'role_id');
    }
}
