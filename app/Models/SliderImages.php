<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SliderImages extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'slider_images';

    protected $fillable = [
        'slider_image',
        'title',
        'sub_title',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
