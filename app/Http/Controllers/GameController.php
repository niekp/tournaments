<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Game;
use App\Models\Tournament;
use App\Repositories\GameRepository;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller {    
    private $gameRepository;

    public function __construct(GameRepository $gameRepository) {
        $this->gameRepository = $gameRepository;
    }

    // No auth middleware to make the link to a tournament sharable
    // Check the auth by GUID inside the methods

    /**
     * Show round robin scren
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(string $guid) {
        if (!$tournament = Tournament::where('guid', $guid)->first()) {
            return redirect()->route('tournaments');
        }

        return view("game.index", [
            'tournament' => $tournament
        ]);
    }
    
    /**
     * Get a form in a modal to enter the score
     *
     * @param  string $guid
     * @param  int $id
     * @return void
     */
    public function getGameModal(string $guid, int $id) {
        $game = Game::find($id);
        if ($game->tournament->guid != $guid) {
            return response('Unauthenticated.', 401);
        }

        return view("game.game-modal", [
            'game' => $game
        ]);
    }

    /**
     * Show round robin scren
     *
     * @return Redirect
     */
    public function save(string $guid, int $id, Request $request) {
        $game = Game::find($id);
        if ($game->tournament->guid != $guid) {
            return response('Unauthenticated.', 401);
        }
        $validatedData = $request->validate([
            'scorePlayer1' => ['required', 'integer'],
            'scorePlayer2' => ['required', 'integer'],
        ]);

        $this->gameRepository->saveScore(
            $game, 
            $validatedData['scorePlayer1'], 
            $validatedData['scorePlayer2']
        );

        return redirect()->route('games', [ 'guid' => $game->tournament->guid ]);
    }

}
