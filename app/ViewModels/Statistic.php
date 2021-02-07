<?php

namespace App\ViewModels;
use App\Models\Player;
class Statistic
{
    public function __construct(Player $player, int $gamesPlayed, int $gamesWon) {
        $this->player = $player;
        $this->gamesPlayed = $gamesPlayed;
        $this->gamesWon = $gamesWon;
    }

    public Player $player;
    public int $gamesPlayed;
    public int $gamesWon;

    public function getWinPercentage() : int {
        if ($this->gamesPlayed == 0) {
            return 0;
        }
        return round($this->gamesWon / $this->gamesPlayed * 100);
    }
}
