<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auction;

class AuctionApiController extends Controller
{
    public function live($id)
    {
        $auction = Auction::with('nft')->findOrFail($id);
        $highestBid = $auction->highest_bid;
        $timeLeft = $auction->end_time ? max(strtotime($auction->end_time) - time(), 0) : 0;
        return response()->json([
            'id' => $auction->id,
            'status' => $auction->status,
            'highest_bid' => $highestBid,
            'starting_price' => $auction->starting_price,
            'end_time' => $auction->end_time,
            'time_left' => gmdate('H:i:s', $timeLeft),
            'nft' => [
                'id' => $auction->nft->id ?? null,
                'name' => $auction->nft->name ?? null,
                'image' => $auction->nft->image ?? null,
                'background' => $auction->nft->background ?? null,
                'value' => $auction->nft->value ?? null,
                'rarity' => $auction->nft->rarity ?? null,
            ],
        ]);
    }
}
