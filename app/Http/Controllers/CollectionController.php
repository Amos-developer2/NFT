<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Nft;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * Display all NFTs - owned, available for purchase, and owned by others.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $today = Carbon::now();
        $user = Auth::user();
        $adminIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        
        // Get user's owned NFTs
        $ownedNfts = Nft::where('user_id', $user->id)
            ->whereNotNull('user_id')
            ->get();
        
        // Get all NFTs available for purchase (owned by admin)
        $availableNfts = Nft::whereIn('user_id', $adminIds)->get();
        
        // Get NFTs owned by other users (not admin, not current user)
        $otherUsersNfts = Nft::whereNotNull('user_id')
            ->where('user_id', '!=', $user->id)
            ->whereNotIn('user_id', $adminIds)
            ->with('user')
            ->get();
        
        // All NFTs combined
        $allNfts = Nft::all();
        
        // Popular collections (group by rarity and get counts)
        $popularCollections = [
            [
                'name' => 'Legendary Collection',
                'icon' => '👑',
                'count' => Nft::where('rarity', 'Legendary')->count(),
                'color' => '#fbbf24',
                'rarity' => 'Legendary'
            ],
            [
                'name' => 'Epic Collection',
                'icon' => '🎯',
                'count' => Nft::where('rarity', 'Epic')->count(),
                'color' => '#a855f7',
                'rarity' => 'Epic'
            ],
            [
                'name' => 'Rare Collection',
                'icon' => '💎',
                'count' => Nft::where('rarity', 'Rare')->count(),
                'color' => '#3b82f6',
                'rarity' => 'Rare'
            ],
            [
                'name' => 'Common Collection',
                'icon' => '⭐',
                'count' => Nft::where('rarity', 'Common')->count(),
                'color' => '#64748b',
                'rarity' => 'Common'
            ],
        ];

        // Calculate portfolio stats for owned NFTs
        $totalInvested = 0;
        $totalValue = 0;
        $totalNfts = $ownedNfts->count();
        
        foreach ($ownedNfts as $nft) {
            $nft->bought_price = $nft->purchase_price ?? $nft->price ?? $nft->value;
            $nft->current_price = $nft->value ?? $nft->price;
            $nft->days_held = $nft->updated_at ? Carbon::parse($nft->updated_at)->diffInDays($today) : 0;
            $nft->can_sell = !$nft->auctions()->where('status', 'Live')->exists();
            $nft->is_owned = true;
            $totalInvested += $nft->bought_price;
            $totalValue += $nft->current_price;
        }
        
        // Prepare available NFTs
        foreach ($availableNfts as $nft) {
            $nft->is_owned = false;
        }
        
        // Prepare other users' NFTs
        foreach ($otherUsersNfts as $nft) {
            $nft->is_owned = false;
            $nft->owner_name = $nft->user ? $nft->user->name : 'Unknown';
        }
        
        $totalProfit = $totalValue - $totalInvested;
        
        return view('collection', compact(
            'ownedNfts', 
            'availableNfts',
            'otherUsersNfts',
            'allNfts',
            'popularCollections',
            'totalInvested', 
            'totalValue', 
            'totalProfit', 
            'totalNfts'
        ));
    }
}
