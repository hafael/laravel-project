<?php

namespace App\Models;

use Hafael\LaraFlake\Traits\LaraFlakeTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable //implements MustVerifyEmail
{
    use LaraFlakeTrait,
        HasApiTokens,
        HasFactory,
        HasProfilePhoto,
        HasTeams,
        Notifiable;
        //TwoFactorAuthenticatable;

    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'lastname', 
        'email', 
        'phone', 
        'password', 
        'currency', 
        'language', 
        'country',
        'spend_limit_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected $attributes = [
        'spend_limit_code' => 'DEMO_TIER',
        'currency' => 'BRL',
        'language' => 'pt_BR',
        'country' => 'BRA',
    ];

    public function isAdmin()
    {
        return str_ends_with($this->email, '@autum.com.br') || $this->email === 'villa655321verde@gmail.com';
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function setPhoneAttribute($phone)
    {
        return $this->attributes['phone'] = (new Phone($phone))->globalNumber();
    }

    public function accountLimits()
    {
        return $this->currentSpendUser->toArray();
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'is_admin' => $this->isAdmin(),
        ]);
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }

    public function spendLimit()
    {
        return $this->belongsTo('App\Models\SpendLimit', 'spend_limit_code', 'code');
    }

    public function currentSpendUser()
    {
        return $this->hasOne('App\Models\CurrentSpendUser');
    }

}
