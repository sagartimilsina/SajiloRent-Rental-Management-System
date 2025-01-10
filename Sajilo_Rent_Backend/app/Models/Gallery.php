<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'image',
        'gallery_type',
        'gallery_name',
        'gallery_publish_status',

    ];

    public function property()
    {
        return $this->belongsTo(Propeerty::class, 'property_id', 'id');
    }
}
