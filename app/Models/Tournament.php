<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    protected $guarded = ['guid'];

    /**
     * Get the user that created the tournament.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the players of this tournament
     */
    public function players() {
        return $this->belongsToMany(Player::class, 'tournaments_players');
    }

    /**
     * Get the played matches of this tournament
     */
    public function games() {
        return $this->hasMany(Game::class);
    }
        
    /**
     * Get a game between 2 players
     *
     * @param  Player $player1
     * @param  Player $player2
     * @return Game
     */
    public function getGame(Player $player1, Player $player2) {
        return $this->games->where('player1_id', $player1->id)->where('player2_id', $player2->id)->first();
    }
}
