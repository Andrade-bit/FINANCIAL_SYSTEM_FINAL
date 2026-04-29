<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = 'users';
    protected $primaryKey = 'usersID';
    public    $timestamps = true;

    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'username',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}