<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'players_range',
        'publisher_id',
        'genre_id',
        'purchase_price',
        'purchase_date',
        'sale_price',
        'sleeves',
        'asset_costs',
        'sleeve_size',
        'icon',
        'created_by',
        'players_min',
        'players_max',
    ];

    protected $casts = [
        'players_range' => 'array',
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'asset_costs' => 'decimal:2',
        'sleeves' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function gallery()
    {
        return $this->hasMany(GameImage::class);
    }

}
