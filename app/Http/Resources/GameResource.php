<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GameResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'description'     => $this->description,
            'players_min'     => $this->players_min,
            'players_max'     => $this->players_max,
            'publisher_id'    => $this->publisher_id,
            'genre_id'        => $this->genre_id,
            'purchase_price'  => $this->purchase_price,
            'purchase_date'   => $this->purchase_date?->format('Y-m-d'),
            'sale_price'      => $this->sale_price,
            'sleeves'         => $this->sleeves,
            'asset_costs'     => $this->asset_costs,
            'sleeve_size'     => $this->sleeve_size,
            'icon'            => $this->icon,
            'icon_url'        => $this->icon ? Storage::url($this->icon) : null,
            'publisher'       => $this->publisher?->name,
            'genre'           => $this->genre?->name,
            'created_at'      => $this->created_at?->toDateTimeString(),
            'updated_at'      => $this->updated_at?->toDateTimeString(),

            // Imagens da galeria
            'images' => $this->whenLoaded('gallery', function () {
                return $this->gallery->map(function ($img) {
                    return [
                        'id' => $img->id,
                        'url' => Storage::url($img->path),
                        'path' => $img->path,
                    ];
                });
            }),
        ];
    }

}
