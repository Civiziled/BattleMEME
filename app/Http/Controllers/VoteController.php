<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Meme $meme)
    {
        if (!$meme->battle->isOpen()) {
            return redirect()->back()
                ->with('error', 'Cette battle est fermée depuis le ' . $meme->battle->deadline->format('d/m/Y à H:i'));
        }

        if ($meme->hasUserVoted(Auth::user())) {
            return redirect()->back()
                ->with('error', 'Vous avez déjà voté pour ce mème !');
        }
        if ($meme->user_id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas voter pour votre propre mème !');
        }

        if (!Gate::allows('vote', $meme)) {
            return redirect()->back()
                ->with('error', 'Vous n\'êtes pas autorisé à voter pour ce mème !');
        }

        Vote::create([
            'user_id' => Auth::id(),
            'meme_id' => $meme->id
        ]);

        return redirect()->back()
            ->with('success', 'Vote enregistré avec succès !');
    }

    public function destroy(Meme $meme)
    {
        $vote = Vote::where('user_id', Auth::id())
            ->where('meme_id', $meme->id)
            ->first();

        if (!$vote) {
            return redirect()->back()
                ->with('error', 'Vous n\'avez pas voté pour ce mème !');
        }

        if (!$meme->battle->isOpen()) {
            return redirect()->back()
                ->with('error', 'Cette battle est fermée depuis le ' . $meme->battle->deadline->format('d/m/Y à H:i'));
        }

        $vote->delete();

        return redirect()->back()
            ->with('success', 'Vote retiré avec succès !');
    }
}
