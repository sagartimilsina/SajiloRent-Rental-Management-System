<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategories extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sub_categories';

    protected $fillable = [
        'category_id',
        'sub_category_name',
        'created_by',
        'icon',
        'publish_status',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function properties()
    {
        return $this->hasMany(Propeerty::class, 'sub_category_id');
    }
}
