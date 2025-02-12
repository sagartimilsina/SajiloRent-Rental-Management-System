<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id_from',
        'user_id_to',
        'property_id',
        'message',
        'attachments',
        'reaction',
        'voice_message',
    ];

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_id_from');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'user_id_to');
    }

    public function property()
    {
        return $this->belongsTo(Propeerty::class, 'property_id');
    }
}
