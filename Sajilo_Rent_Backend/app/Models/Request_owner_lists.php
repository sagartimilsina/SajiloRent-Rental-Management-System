<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request_owner_lists extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'request_owner_lists';
    protected $fillable = [
        'user_id',
        'residential_address',
        'national_id',
        'govt_id_proof',
        'agree_terms',
        'business_name',
        'pan_registration_id',
        'business_type',
        'business_proof',
        'status',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



}
