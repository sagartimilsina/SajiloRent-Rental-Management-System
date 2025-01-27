<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Abouts extends Model
{
    use HasFactory;

    protected $table = 'abouts';


    protected $fillable = [
        'head',
        'title',
        'description',
        'image',
        'about_publish_status',
    ];
}
