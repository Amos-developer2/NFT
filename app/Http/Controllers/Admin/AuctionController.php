<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Nft;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuctionController extends Controller
{
    /**
     * Display a listing of auctions.
     */
    public function index(Request $request)
    {
        $query = Auction::with(['nft', 'bids']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter active/ended
        if ($request->filled('active')) {
            if ($request->active == 'active') {
                $query->where('end_time', '>', now());
            } else {
                $query->where('end_time', '<=', now());
            }
        }

        $auctions = $query->latest()->paginate(15);

        return view('admin.auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new auction.
     */
    public function create()
    {
        // Get NFTs that don't have active auctions
        $nfts = Nft::whereDoesntHave('auctions', function ($q) {
            $q->where('status', 'active')
                ->where('end_time', '>', now());
        })->get();

        return view('admin.auctions.create', compact('nfts'));
    }

    /**
     * Store a newly created auction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nft_id' => 'required|exists:nfts,id',
            'starting_price' => 'required|numeric|min:0',
            'end_time' => 'required|date|after:now',
            'status' => 'required|in:active,ended,cancelled',
        ]);

        Auction::create($validated);

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction created successfully.');
    }

    /**
     * Display the specified auction.
     */
    public function show(Auction $auction)
    {
        $auction->load(['nft', 'bids.user']);
        return view('admin.auctions.show', compact('auction'));
    }

    /**
     * Show the form for editing the specified auction.
     */
    public function edit(Auction $auction)
    {
        $nfts = Nft::all();
        return view('admin.auctions.edit', compact('auction', 'nfts'));
    }

    /**
     * Update the specified auction.
     */
    public function update(Request $request, Auction $auction)
    {
        $validated = $request->validate([
            'nft_id' => 'required|exists:nfts,id',
            'starting_price' => 'required|numeric|min:0',
            'highest_bid' => 'nullable|numeric|min:0',
            'end_time' => 'required|date',
            'status' => 'required|in:active,ended,cancelled',
        ]);

        $auction->update($validated);

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction updated successfully.');
    }

    /**
     * Remove the specified auction.
     */
    public function destroy(Auction $auction)
    {
        // Delete associated bids
        $auction->bids()->delete();
        $auction->delete();

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction deleted successfully.');
    }

    /**
     * End an auction manually.
     */
    public function endAuction(Auction $auction)
    {
        // Always set status to 'ended' (lowercase for consistency)
        if (strtolower($auction->status) !== 'ended') {
            $auction->status = 'ended';
            $auction->end_time = now();
        }

        // Ensure paid_out is boolean and not null
        if ($auction->paid_out === null) {
            $auction->paid_out = false;
        }

        // Only pay out if not already done
        if (!$auction->paid_out) {
            $highestBid = $auction->highest_bid;
            $highestBidObj = $auction->bids()->orderByDesc('amount')->first();
            $seller = $auction->seller;
            $nft = $auction->nft;
            if ($seller && $nft && $highestBidObj && $highestBid > 0) {
                $capital = $nft->purchase_price ?? $nft->price ?? $nft->value ?? 0;
                $profit = $highestBid - $capital;
                $seller->balance += ($capital + max($profit, 0));
                $seller->save();
                // Remove NFT from collection (burn)
                $nft->user_id = null;
                $nft->save();
                $auction->paid_out = true;
            }
        }
        $auction->save();

        return redirect()->back()
            ->with('success', 'Auction ended and seller credited if applicable.');
    }

    /**
     * Cancel an auction.
     */
    public function cancelAuction(Auction $auction)
    {
        $auction->update(['status' => 'cancelled']);

        return redirect()->back()
            ->with('success', 'Auction cancelled successfully.');
    }
}
