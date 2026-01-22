<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nft extends Model
{
    protected $fillable = [
        'name',
        'image',
        'background',
        'value',
        'rarity'
    ];

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    // Owner of the NFT
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
