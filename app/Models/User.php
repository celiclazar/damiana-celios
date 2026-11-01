<?php

namespace App\Models;

use Celios\Core\Models\User as CeliosUser;

class User extends CeliosUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'status',
        'phone',
        'avatar',
    ];
}
