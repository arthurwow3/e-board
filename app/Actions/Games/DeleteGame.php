<?php

namespace App\Actions\Games;

use App\Models\Game;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteGame
{
    use AsAction;

    public function handle(Game $game)
    {
        try {
            $game->delete();

            return Redirect::route('games.index')
                ->with('success', 'Jogo excluído com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao excluir jogo', [
                'game_id' => $game->id,
                'message' => $e->getMessage(),
            ]);

            return Redirect::route('games.index')
                ->with('error', 'Não foi possível excluir o jogo. Tente novamente.');
        }
    }
}

