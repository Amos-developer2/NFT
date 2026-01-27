<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Auction;
use App\Models\Nft;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    /**
     * Accept a bid (NFT owner can accept a bid from an auction)
     */
    public function accept(Request $request, $id)
    {
        $bid = Bid::with(['auction.nft', 'user'])->findOrFail($id);
        $auction = $bid->auction;
        $nft = $auction->nft;
        $user = Auth::user();

        // Check if the current user is the NFT owner
        if ($nft->user_id !== $user->id) {
            return redirect()->back()->with('error', 'You do not own this NFT.');
        }

        // Check if the auction is still active
        if ($auction->status !== 'active') {
            return redirect()->back()->with('error', 'This auction is no longer active.');
        }

        // Transfer NFT to the bidder
        $nft->user_id = $bid->user_id;
        $nft->save();

        // Update auction status
        $auction->status = 'completed';
        $auction->highest_bid = $bid->amount;
        $auction->save();

        // Add balance to the seller
        $user->balance += $bid->amount;
        $user->save();

        // Deduct balance from the bidder
        $bidder = $bid->user;
        $bidder->balance -= $bid->amount;
        $bidder->save();

        return redirect()->route('nft.show', $nft->id)->with('success', 'Bid accepted! NFT transferred to ' . $bidder->name);
    }
}
