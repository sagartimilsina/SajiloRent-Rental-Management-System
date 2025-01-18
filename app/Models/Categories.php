<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    protected $guard = [];


    protected $fillable = [
        'category_name',
        'icon',
        'publish_status',
        'created_by',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function properties()
    {
        return $this->hasMany(Propeerty::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategories::class, 'category_id');
    }
}
