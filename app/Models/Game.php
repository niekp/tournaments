<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['scorePlayer1', 'scorePlayer2'];

    /**
     * Player 1 of the match
     */
    public function player1() {
        return $this->belongsTo(Player::class);
    }

    /**
     * Player 2 of the match
     */
    public function player2() {
        return $this->belongsTo(Player::class);
    }

    /**
     * Winner of the match
     */
    public function winner() {
        return $this->belongsTo(Player::class);
    }

    /**
     * Get the tournament of this match
     */
    public function tournament() {
        return $this->belongsTo(Tournament::class);
    }

    public function getWinnerText() {
        if ($this->winner) {
            return sprintf("%d - %d (%s)", 
                $this->scorePlayer1, 
                $this->scorePlayer2, 
                $this->winner->name
            );
        } else if ($this->scorePlayer1 == $this->scorePlayer2 && !!$this->scorePlayer1) {
            return sprintf("%d - %d", 
                $this->scorePlayer1, 
                $this->scorePlayer2
            );
        }

        return "";
    }
}
