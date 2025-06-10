<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'players_range' => 'required|array|size:2',
            'players_range.*' => 'integer|min:1|max:100',
            'publisher_id' => 'required|integer|exists:publishers,id',
            'genre_id' => 'required|integer|exists:genres,id',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'sale_price' => 'nullable|numeric|min:0',
            'sleeves' => 'nullable|integer|min:0',
            'asset_costs' => 'nullable|numeric|min:0',
            'sleeve_size' => 'nullable|string|in:P,M,G,GG',
            'icon' => 'nullable|file|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'file|image|max:4096',
        ];
    }
}
