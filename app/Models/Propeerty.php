<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Propeerty extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'propeerties';

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'property_name',
        'property_description',
        'property_price',
        'property_discount',
        'property_location',
        'property_image',
        'property_quantity',
        'property_sell_price',
        'property_expiry',
        'property_publish_status',
        'created_by',
        'map_link',
        'views_count',
        'property_booked_quantity',

    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategories::class, 'sub_category_id');
    }

    public function user_property()
    {
        return $this->hasMany(Users_Property::class, 'property_id');
    }

    public function propertyImages()
    {
        return $this->hasMany(Property_Images::class, 'property_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'property_id');
    }
}
