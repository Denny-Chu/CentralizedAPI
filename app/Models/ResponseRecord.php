<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class ResponseRecord extends Model
{

    protected $fillable = [
        'name', 'email',
    ];
    
    protected $hidden = [
        'password',
    ];
}
