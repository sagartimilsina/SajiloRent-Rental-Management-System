<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FAQ extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'f_a_q_s';

    protected $fillable = [
        'question',
        'answer',
        'faq_publish_status',
    ];
}
