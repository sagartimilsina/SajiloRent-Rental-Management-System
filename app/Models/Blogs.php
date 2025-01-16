<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blogs extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'blogs';

    protected $fillable = [
        'blog_title',
        'blog_description',
        'blog_image',
        'blog_publish_status',
    ];
}
