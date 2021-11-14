<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpendLimit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'price',
        'contacts',
        'requests',
        'throttle',
    ];

    public function forUser()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'spend_limit_code', 'code');
    }
}
