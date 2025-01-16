<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Abouts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abouts';


    protected $fillable = [
        'about_title',
        'about_description',
        'about_image',
        'about_publish_status',
    ];
}
