<?php

namespace App\Http\Controllers;

use App\Actions\Games\StoreGame;
use App\Http\Requests\StoreGameRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GamesController extends Controller
{
    public function create()
    {
        return Inertia::render('Games/Create', [
            'auth' => [
                'user' => auth()->user(),
            ]
        ]);
    }

    public function store(StoreGameRequest $request)
    {
        $game = app(StoreGame::class)->handle($request->validated());
        return redirect()->route('games.index')
            ->with('success', 'Jogo cadastrado com sucesso!');
    }

    public function index(){
        return Inertia::render('Games/Index', [
            'auth' => [
                'user' => auth()->user(),
            ]
        ]);
    }
}
