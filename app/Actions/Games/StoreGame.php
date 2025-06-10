<?php

namespace App\Actions\Games;

use App\Models\Game;
use Illuminate\Support\Carbon;

class StoreGame
{
    public function handle(array $data)
    {
        // Upload do ícone
        if (isset($data['icon']) && $data['icon']) {
            $iconPath = $data['icon']->store('games/icons', 'public');
            $data['icon'] = $iconPath;
        }

        // Upload das imagens

        if (isset($data['images']) && is_array($data['images'])) {
            $paths = [];
            foreach ($data['images'] as $image) {
                if ($image) {
                    $paths[] = $image->store('games/images', 'public');
                }
            }
            unset($data['images']);
        }

        if (isset($data['players_range']) && is_array($data['players_range'])) {
            $data['players_min'] = $data['players_range'][0] ?? null;
            $data['players_max'] = $data['players_range'][1] ?? null;
        }

        unset($data['players_range']);

        $game = Game::create($data);

        if (!empty($paths)) {
            foreach ($paths as $path) {
                $game->gallery()->create(['path' => $path]);
            }
        }

        return $game;
    }
}
