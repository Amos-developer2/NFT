<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NftPriceHistory extends Model
{
    protected $fillable = [
        'nft_id',
        'price',
        'recorded_at',
    ];

    public function nft(): BelongsTo
    {
        return $this->belongsTo(Nft::class);
    }
}
