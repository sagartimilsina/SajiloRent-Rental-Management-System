<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mortage_Records extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'mortage_records';

    protected $fillable = [
        'user_id',
        'property_id',
        'mortage_amount',
        'mortage_start_date',
        'mortage_end_date',
        'mortage_file',
        'mortage_status',
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
