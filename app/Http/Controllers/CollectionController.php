<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Nft;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * Display the user's NFT collection with value tracking.
     * Users buy NFTs, values change over days, sell when profitable.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $today = Carbon::now();
        $user = Auth::user();
        $nfts = Nft::where('user_id', $user->id)->get();

        // Calculate days held and portfolio stats
        $totalInvested = 0;
        $totalValue = 0;
        $totalNfts = $nfts->count();
        foreach ($nfts as $nft) {
            // For demo, assume bought_price = value at purchase, current_price = value now
            $nft->bought_price = $nft->value; // Replace with real purchase price if tracked
            $nft->current_price = $nft->value; // Replace with real current value if tracked
            $nft->days_held = $nft->created_at ? Carbon::parse($nft->created_at)->diffInDays($today) : 0;
            $nft->can_sell = true; // Add logic if needed
            $totalInvested += $nft->bought_price;
            $totalValue += $nft->current_price;
        }
        $totalProfit = $totalValue - $totalInvested;
        return view('collection', compact('nfts', 'totalInvested', 'totalValue', 'totalProfit', 'totalNfts'));
    }
}
