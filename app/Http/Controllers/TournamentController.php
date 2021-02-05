<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        ]);

        $tournament = new Tournament;
        $tournament->title = $validatedData['title'];
        $tournament->user_id = Auth::user()->id;
        $tournament->save();

        return redirect()->route('tournaments');
    }

    /**
     * Edit a tournament
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id) {
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
    public function editSave(Request $request, $id) {
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
        ]);

        if ($tournament = Auth::User()->tournaments->firstWhere('id', $id)) {
            $tournament->title = $validatedData['title'];
            $tournament->save();
        }

        return redirect()->route('tournaments');
    }

    /**
     * Delete a tournament
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function delete($id) {
        if ($tournament = Auth::User()->tournaments->firstWhere('id', $id)) {
            $tournament->delete();
        }

        return redirect()->route('tournaments');
    }


}
