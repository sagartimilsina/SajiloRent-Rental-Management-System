<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contracts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contracts';

    protected $fillable = [
        'user_id',
        'property_id',
        'contract_type',
        'contract_start_date',
        'contract_end_date',
        'contract_file',
        'contract_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function property()
    {
        return $this->belongsTo(Propeerty::class, 'property_id', 'id');
    }

}
