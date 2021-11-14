<?php

namespace App\Models;

use Hafael\LaraFlake\Traits\LaraFlakeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory,
        LaraFlakeTrait;

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
        'name', 'wallet_address'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
