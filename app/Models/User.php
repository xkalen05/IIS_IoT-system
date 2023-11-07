<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    //@var string
    protected $table = 'user';

    //protected $primaryKey = 'login';

    //protected $password = 'password';

    protected $fillable = ['login','password'];
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    use HasFactory, HasApiTokens, Notifiable;
}
