<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_Property extends Model
{
    use HasFactory;

    protected $table = 'users__properties';

    protected $fillable = [
        'user_id',
        'property_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function property()
    {
        return $this->belongsTo(Propeerty::class, 'property_id');
    }
}
