<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardShip extends Model
{
    protected $fillable = [
        'card_id',
        'player_id',
        'game_id'
    ];
    use HasFactory;
}
