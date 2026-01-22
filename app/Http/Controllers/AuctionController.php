<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::with('nft')->get();
        $userStats = [
            'auctionsActive' => Auction::where('status', 'Live')->count(),
            'auctionsWon' => Bid::where('user_id', Auth::id())->whereHas('auction', function ($q) {
                $q->where('status', 'Ended');
            })->count(),
            'bidsPlaced' => Bid::where('user_id', Auth::id())->count(),
        ];
        return view('auction', compact('auctions', 'userStats'));
    }

    public function bid(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $amount = $request->input('amount');
        if ($auction->status !== 'Live' || $amount <= $auction->highest_bid) {
            return back()->with('error', 'Invalid bid.');
        }
        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => Auth::id(),
            'amount' => $amount,
        ]);
        $auction->highest_bid = $amount;
        $auction->save();
        return back()->with('success', 'Bid placed successfully!');
    }
}
