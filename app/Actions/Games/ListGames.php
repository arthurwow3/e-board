<?php

namespace App\Actions\Games;

use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Publisher;
use Inertia\Inertia;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;

class ListGames
{
    use AsAction;

    public function handle(Request $request)
    {
        $query = Game::query();

        if ($request->filled('name')) {
            $query->where('title', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('publisher_id')) {
            $query->where('publisher_id', $request->publisher_id);
        }

        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->genre_id);
        }

        if ($request->filled('purchase_date')) {
            $query->whereDate('purchase_date', $request->purchase_date);
        }

        $games = $query->with(['publisher', 'genre']) // se houver relacionamento
        ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();


        return Inertia::render('Games/Index', [
            'games' => GameResource::collection($games),
            'filters' => $request->only(['name', 'publisher_id', 'genre_id', 'purchase_date']),
            'publishers' => Publisher::all(['id', 'name']),
            'genres' => Genre::all(['id', 'name']),
        ]);
    }
}
