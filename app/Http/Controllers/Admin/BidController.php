<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Auction;
use App\Models\User;
use Illuminate\Http\Request;

class BidController extends Controller
{
    /**
     * Display a listing of bids.
     */
    public function index(Request $request)
    {
        $query = Bid::with(['auction.nft', 'user']);

        // Filter by auction
        if ($request->filled('auction_id')) {
            $query->where('auction_id', $request->auction_id);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Search by amount
        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        $bids = $query->latest()->paginate(15);
        $auctions = Auction::with('nft')->get();
        $users = User::select('id', 'name')->get();

        return view('admin.bids.index', compact('bids', 'auctions', 'users'));
    }

    /**
     * Display the specified bid.
     */
    public function show(Bid $bid)
    {
        $bid->load(['auction.nft', 'user']);
        return view('admin.bids.show', compact('bid'));
    }

    /**
     * Remove the specified bid.
     */
    public function destroy(Bid $bid)
    {
        $auction = $bid->auction;
        
        $bid->delete();

        // Update highest bid if needed
        if ($auction) {
            $highestBid = $auction->bids()->max('amount');
            $auction->update(['highest_bid' => $highestBid ?? $auction->starting_price]);
        }

        return redirect()->route('admin.bids.index')
            ->with('success', 'Bid deleted successfully.');
    }

    /**
     * Manually create a bid (for testing/admin purposes).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'auction_id' => 'required|exists:auctions,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $auction = Auction::findOrFail($validated['auction_id']);
        
        // Ensure bid is higher than current highest
        if ($validated['amount'] <= ($auction->highest_bid ?? $auction->starting_price)) {
            return redirect()->back()
                ->with('error', 'Bid amount must be higher than current highest bid.');
        }

        Bid::create($validated);

        // Update auction highest bid
        $auction->update(['highest_bid' => $validated['amount']]);

        return redirect()->route('admin.bids.index')
            ->with('success', 'Bid created successfully.');
    }
}
