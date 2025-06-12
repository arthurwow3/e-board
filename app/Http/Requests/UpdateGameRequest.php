<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'required|string',
            'purchase_price' => 'required|numeric',
            'purchase_date' => 'nullable|date',
            'sale_price' => 'nullable|numeric',
            'asset_costs' => 'nullable|numeric',
            'sleeves' => 'nullable|integer',
            'sleeve_size' => 'nullable|string|max:10',
            'players_range' => 'nullable|array|size:2',
            'players_range.0' => 'nullable|integer',
            'players_range.1' => 'nullable|integer',
            'icon' => 'nullable|image|max:2048',
            'images.*' => 'nullable|file|image|max:4096',
            'image_previews' => 'nullable|array',
            'image_previews.*.id' => 'required|integer|exists:game_gallery,id',
            'image_previews.*.url' => 'required|string',
        ];
    }
}
