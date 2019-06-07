<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    const UNVERIFIED = false;
    const VERIFIED = true;
    const CUSTOMER = 1;
    const MANAGER = 2;
    const ADMIN = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'remember_token', 'full_name', 'email', 'password', 'phone', 'birth_date','user_level',
        'image', 'lat', 'lng', 'region', 'postal_code', 'verified', 'verification_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function is_customer(){
        return $this->user_level == User::CUSTOMER;
    }
    public function is_manager(){
        return $this->user_level == User::MANAGER;
    }
    public function is_admin(){
        return $this->user_level == User::ADMIN;
    }
    public function is_verified(){
        return $this->verified == User::VERIFIED;
    }

    public static function generate_verification_code(){
        return Str::random(40);
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }
    public function favorites(){
        return $this->belongsToMany('App\Product')->using('App\Favorite');
    }
    public function cart(){
        return $this->hasMany('App\Cart');
    }
}
