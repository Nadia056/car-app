<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'activation_code',
        'active',];

        
    use HasFactory;
    use HasApiTokens;
  

}
