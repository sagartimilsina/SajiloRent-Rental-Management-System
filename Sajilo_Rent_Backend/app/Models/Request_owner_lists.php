<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request_owner_lists extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'request_owner_lists';
    protected $fillable = ['user_id', 'company_name', 'company_address', 'company_contact', 'government_issued_id', 'business_registration_file', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



}
