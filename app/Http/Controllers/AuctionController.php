<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nft_id' => 'required|exists:nfts,id',
            'starting_price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1|max:168',
        ]);
        $nft = \App\Models\Nft::findOrFail($request->nft_id);
        if ($nft->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        $startingPrice = (float) $request->starting_price;
        $duration = (int) $request->duration;
        $auction = new \App\Models\Auction();
        $auction->nft_id = $nft->id;
        $auction->starting_price = $startingPrice;
        $auction->status = 'Live';
        $auction->end_time = now()->addHours($duration);
        $auction->highest_bid = $startingPrice;
        $auction->save();
        return redirect()->route('auction', ['id' => $auction->id])->with('success', 'Auction started!');
    }

    public function create($nft_id)
    {
        $nft = \App\Models\Nft::findOrFail($nft_id);
        // Optionally, check if the user owns this NFT
        if ($nft->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        return view('auction-create', compact('nft'));
    }
    public function index()
    {
        $auctions = Auction::with('nft')->get();
        return view('auctions', compact('auctions'));
    }

    public function show($id)
    {
        $auction = Auction::with('nft')->findOrFail($id);
        $userStats = [
            'auctionsActive' => Auction::where('status', 'Live')->count(),
            'auctionsWon' => Bid::where('user_id', Auth::id())->whereHas('auction', function ($q) {
                $q->where('status', 'Ended');
            })->count(),
        ];
        return view('auction', compact('auction', 'userStats'));
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
