<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentSpendUser extends Model
{
    use HasFactory;

    protected $table = 'current_spend_user';

    protected $casts = [
        'max_requests' => 'integer',
        'max_contacts' => 'integer',
        'max_throttle' => 'integer',
        'requests' => 'integer',
        'contacts' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


}
