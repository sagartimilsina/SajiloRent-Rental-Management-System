<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property_Review extends Model
{
    use HasFactory;

    protected $table = 'property__reviews';
    protected $fillable = [
        'property_id',
        'user_id',
        'property_review',
        'property_rating',
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
