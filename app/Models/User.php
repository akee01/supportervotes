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
        'email',
        'password',
        'detail',
        'star_rate',
        'role',
        'balance'
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

    public function polls(){
        return $this->hasMany(Poll::class);
    }

    public function votes(){
        return $this->hasMany(PollVote::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function c_payments(){
        return $this->hasMany(Payment::class,'creator_id');
    }

    public function stars(){
        return $this->hasMany(PremiumStars::class);
    }
}
