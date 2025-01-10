<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintaintanceRequests extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maintaintance_requests';
    protected $fillable = [
        'property_id',
        'user_id',
        'request_type',
        'request_description',
        'request_status',
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
