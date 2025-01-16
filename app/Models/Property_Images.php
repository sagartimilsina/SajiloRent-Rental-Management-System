<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property_Images extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'property__images';

    protected $fillable = [
        'property_id',
        'property_image',
        'property_publish_status'
    ];

    public function property()
    {
        return $this->belongsTo(Propeerty::class, 'property_id');
    }


}
