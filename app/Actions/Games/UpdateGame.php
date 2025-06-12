<?php
namespace App\Actions\Games;

use App\Models\Game;
use App\Exceptions\GameStoreException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGame
{
    use AsAction;

    public function handle(Game $game, array $data)
    {
        try {
            // Upload do novo ícone (substitui o anterior)
            if (isset($data['icon']) && $data['icon']) {
                if ($game->icon) {
                    Storage::disk('public')->delete($game->icon);
                }

                $iconPath = $data['icon']->store('games/icons', 'public');
                $data['icon'] = $iconPath;
            } else {
                unset($data['icon']); // evita sobrescrever com null
            }

            // Upload de novas imagens (anexa à galeria existente)
            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $image) {
                    if ($image) {
                        $path = $image->store('games/images', 'public');
                        $game->gallery()->create(['path' => $path]);
                    }
                }
                unset($data['images']);
            }

            // Tratamento do players_range
            if (isset($data['players_range']) && is_array($data['players_range'])) {
                $data['players_min'] = $data['players_range'][0] ?? null;
                $data['players_max'] = $data['players_range'][1] ?? null;
            }

            unset($data['players_range']);

            // Atualização dos campos restantes
            $game->update($data);

            return redirect()
                ->route('games.index')
                ->with('success', 'Jogo atualizado com sucesso.');

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar jogo', [
                'game_id' => $game->id,
                'erro' => $e->getMessage(),
                'dados' => $data,
            ]);

            throw new GameStoreException('Não foi possível atualizar o jogo.');
        }
    }
}

