<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'color',];
    use HasFactory;
}
