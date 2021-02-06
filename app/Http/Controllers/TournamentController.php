<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Support\Str;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\GameRepository;
use App\Repositories\TournamentRepository;

class TournamentController extends Controller
{
    private $gameRepository;
    private $tournamentRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GameRepository $gameRepository, TournamentRepository $tournamentRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->middleware('auth');
    }

    /**
     * Show all tournaments and a form to create a new one.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('tournament.tournaments', [
            'tournaments' => Auth::user()->tournaments
        ]);
    }

    /**
     * Add a new tournament
     
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function new(Request $request) {
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
            'players' => ['required'],
        ]);

        $tournament = $this->tournamentRepository->create($validatedData['title']);

        $this->tournamentRepository->linkPlayers($tournament, $validatedData['players']);
        $this->gameRepository->generateGames($tournament->id);
        return redirect()->route('tournaments');
    }

    /**
     * Edit a tournament
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(int $id) {
        if ($tournament = Auth::User()->tournaments->firstWhere('id', $id)) {
            return view('tournament.edit', [
                'tournament' => $tournament
            ]);
        }

        return redirect()->route('tournaments');
    }

    /**
     * Save changes in tournament
     
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function editSave(Request $request, int $id) {
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
            'players' => ['required'],
        ]);

        $tournament = $this->tournamentRepository->edit($id, $validatedData['title']);
        $this->tournamentRepository->linkPlayers($tournament, $validatedData['players']);
        $this->gameRepository->generateGames($tournament->id);

        return redirect()->route('tournaments');
    }

    /**
     * Delete a tournament
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function delete(int $id) {
        $this->tournamentRepository->delete($id);
        return redirect()->route('tournaments');
    }

}
