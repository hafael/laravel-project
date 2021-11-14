<?php

namespace App\Models;

use Hafael\LaraFlake\Traits\LaraFlakeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invitation extends Model
{
    use LaraFlakeTrait,
        HasFactory, 
        Notifiable;

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
        'email',
        'token',
        'sent_at',
        'registered_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

}
