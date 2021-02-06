<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\Player;

class PlayerRepository
{        
    /**
     * Get or create a new player if it doesnt exist
     *
     * @param  string $name
     * @return Player
     */
    public function getOrCreate(string $name) : Player {
        if (!$player = Auth::user()->players->where('name', $name)->first()) {
            $player = new Player;
            $player->name = $name;
            $player->user_id = Auth::user()->id;
            $player->save();
        }
        
        return $player;
    }
}