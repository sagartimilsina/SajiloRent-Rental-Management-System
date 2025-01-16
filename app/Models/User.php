<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'google_id',
        'role_id',
        'otp_code',
        'otp_code_send_at',
        'otp_code_verified_at',
        'otp_code_expires_at',
        'otp_is_verified',
        'avatar',
        'status',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(UserRoleManagement::class, 'role_id');
    }


    public function category()
    {
        return $this->hasMany(Categories::class, 'created_by');
    }

    public function property()
    {
        return $this->hasMany(Propeerty::class, 'created_by');
    }

    public function subcategory()
    {
        return $this->hasMany(SubCategories::class, 'created_by');
    }

    public function user_property()
    {
        return $this->hasMany(Users_Property::class, 'user_id');
    }

    public function property_review()
    {
        return $this->hasMany(Property_Review::class, 'user_id');
    }

    public function tenant_agreement()
    {
        return $this->hasMany(TenantAgreementwithSystem::class, 'user_id');
    }
}
