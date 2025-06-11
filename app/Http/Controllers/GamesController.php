<?php

namespace App\Http\Controllers;

use App\Actions\Games\DeleteGame;
use App\Actions\Games\GameListAction;
use App\Actions\Games\ListGames;
use App\Actions\Games\StoreGame;
use App\Exceptions\GameStoreException;
use App\Http\Requests\StoreGameRequest;
use App\Models\Game;
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
        try {
            app(StoreGame::class)->handle($request->validated());

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
        return app(ListGames::class)->handle($request);
    }

    public function destroy(Game $game)
    {
        return DeleteGame::run($game);
    }

}
