<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeCar extends Model
{
    protected $fillable = [
        'user_id',
        'bike_id',
        ];
    use HasFactory;
}
