<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'nft_id',
        'user_id',
        'starting_price',
        'highest_bid',
        'status',
        'end_time',
        'paid_out'
    ];

    protected $casts = [
        'paid_out' => 'boolean',
    ];
    public function nft()
    {
        return $this->belongsTo(Nft::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // Add seller relationship for auction
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the user who placed the highest bid.
     */
    public function getHighestBidderAttribute()
    {
        $bid = $this->bids()->orderByDesc('amount')->first();
        return $bid ? $bid->user : null;
    }
}
