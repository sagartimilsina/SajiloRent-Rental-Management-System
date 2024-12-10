<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleManagement extends Model
{
    use HasFactory;
    protected $table = 'user_role_management';

    protected $fillable = [
        'role_name',
    ];
}
