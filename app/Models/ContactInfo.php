<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;
    protected $fillable = ['address', 'phone','phone_2', 'email','email_2', 'social_links'];
    protected $casts = [
        'social_links' => 'array',
    ];
}
