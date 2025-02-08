<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payments extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'property_id',
        'property_quantity',
        'payment_method',
        'status',  // Changed from 'payment_status' to 'status' to match the column name in your migration
        'transaction_uuid',
        'transaction_code',
        'signature',
        'payment_date',
        'total_amount',
        'service_charge',  // Assuming these fields are in your schema
        'discount',
        'tax'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Propeerty::class);
    }
}
