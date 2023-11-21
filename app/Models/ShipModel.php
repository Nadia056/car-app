<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipModel extends Model
{
    protected $fillable = [
        'player_id',
        'game_id',
    ];

    use HasFactory;
}
