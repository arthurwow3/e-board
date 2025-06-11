<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'purchase_price' => $this->purchase_price,
            'purchase_date' => $this->purchase_date?->format('d/m/Y'),
            'sale_price' => $this->sale_price,
            'sleeves' => $this->sleeves,
            'asset_costs' => $this->asset_costs,
            'icon'            => $this->icon,
            'icon_url'        => $this->icon ? Storage::url($this->icon) : null,
            'publisher'       => $this->publisher?->name,
            'genre'           => $this->genre?->name,

        ];
    }
}
