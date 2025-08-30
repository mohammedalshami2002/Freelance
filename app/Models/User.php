<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'email',
        'type_user',
        'password',
        'is_verified',
        'is_blocked',
    ];

    public function profile()
    {
        return $this->hasOne(Profile_Service_provider::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public function offer()
    {
        return $this->hasMany(Offer::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill__users');
    }

    public function verificationRequests()
    {
        return $this->hasMany(Request::class, 'user_id');
    }

    public function latestVerificationRequest()
    {
        return $this->hasOne(Request::class, 'user_id')->latestOfMany();
    }

    public function myWorks()
    {
        return $this->hasMany(My_Work::class, 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Transactions::class);
    }


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
}
