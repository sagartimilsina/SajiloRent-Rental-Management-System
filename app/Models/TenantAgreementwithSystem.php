<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenantAgreementwithSystem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'request_id',
        'status',
        'agreement_status',
        'agreement_file',
        'agreement',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function request()
    {
        return $this->belongsTo(Request_owner_lists::class, 'request_id');
    }
}
