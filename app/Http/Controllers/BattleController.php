<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Models\Meme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class BattleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Battle::with(['user', 'memes'])
            ->withCount('memes');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'open') {
                $query->where('deadline', '>', now());
            } elseif ($request->status === 'closed') {
                $query->where('deadline', '<=', now());
            }
        }

        $battles = $query
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('battles.index', compact('battles'));
    }

    public function create()
    {
        return view('battles.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:now'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $battle = Battle::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('battles.show', $battle)
            ->with('success', 'Battle créée avec succès !');
    }

    public function show(Battle $battle)
    {
        $battle->load(['memes.user', 'memes.votes']);
        $rankedMemes = $battle->getRankedMemes();

        return view('battles.show', compact('battle', 'rankedMemes'));
    }

    public function edit(Battle $battle)
    {
        Gate::authorize('update', $battle);

        return view('battles.edit', compact('battle'));
    }

    public function update(Request $request, Battle $battle)
    {
        Gate::authorize('update', $battle);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:now'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $battle->update([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline
        ]);

        return redirect()->route('battles.show', $battle)
            ->with('success', 'Battle mise à jour avec succès !');
    }
    public function destroy(Battle $battle)
    {
        Gate::authorize('delete', $battle);

        $battle->delete();

        return redirect()->route('battles.index')
            ->with('success', 'Battle supprimée avec succès !');
    }
}
