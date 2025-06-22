<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Claimer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email',
        'full_name',
        'location',
        'dob',
        'phone',
        'password',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
