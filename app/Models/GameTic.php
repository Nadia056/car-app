<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTic extends Model
{
    protected $fillable = ['board', 'currentPlayer', 'status',];

    protected $casts = [
        'board' => 'array'
    ];

    public function isOver()
    {
        return $this->status !== null;
    }

    public function isWinningMove($row, $column, $player)
    {
        // Check for winning move logic
        // ...

        return false;
    }

    public function isBoardFull()
    {
        foreach ($this->board as $row) {
            foreach ($row as $cell) {
                if ($cell === '') {
                    return false;
                }
            }
        }

        return true;
    }
}
