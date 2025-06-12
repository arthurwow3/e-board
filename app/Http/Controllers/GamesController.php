<?php

namespace App\Http\Controllers;

use App\Actions\Games\DeleteGame;
use App\Actions\Games\ListGames;
use App\Actions\Games\StoreGame;
use App\Actions\Games\UpdateGame;
use App\Exceptions\GameStoreException;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Publisher;
use http\Client\Response;
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
    public function edit(Game $game)
    {
        $game->load('gallery');
        return Inertia::render('Games/Create', [
            'game' => (new GameResource($game))->resolve(), // importante: usar Resource
            'publishers' => Publisher::all(['id', 'name']),
            'genres' => Genre::all(['id', 'name']),
        ]);
    }

    public function update(UpdateGameRequest $request, Game $game)
    {
        return UpdateGame::run($game, $request->validated());
    }

    public function store(StoreGameRequest $request)
    {
        try {
            StoreGame::run($request->validated());

            return redirect()->route('games.index')
                ->with('success', 'Jogo cadastrado com sucesso!');
        } catch (GameStoreException $e) {
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function index(Request $request)
    {
        return ListGames::run($request);
    }

    public function destroy(Game $game)
    {
        return DeleteGame::run($game);
    }

}
