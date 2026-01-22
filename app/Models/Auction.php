<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'nft_id',
        'starting_price',
        'highest_bid',
        'status',
        'end_time'
    ];

    public function nft()
    {
        return $this->belongsTo(Nft::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
