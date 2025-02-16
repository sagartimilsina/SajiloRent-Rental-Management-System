<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyMessage extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'property_id',
        'user_id',
        'subject',
        'message',
        'read_status',
    ];

    public function property()
    {
        return $this->belongsTo(Propeerty::class, 'property_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
