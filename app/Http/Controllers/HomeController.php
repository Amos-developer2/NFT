<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * API endpoint: Return the latest 2-minute change stat for the authenticated user as JSON.
     */
    public function portfolioChangeStat()
    {
        $user = auth()->user();
        $now = now();
        $userNfts = $user->nfts;
        $currentValue = $userNfts->sum('value');

        $snapshotAgo = \App\Models\PortfolioSnapshot::where('user_id', $user->id)
            ->where('created_at', '<=', $now->copy()->subSeconds(120))
            ->latest('created_at')->first();
        $change24h = 0;
        if ($snapshotAgo && $snapshotAgo->value > 0) {
            $change24h = (($currentValue - $snapshotAgo->value) / $snapshotAgo->value) * 100;
        }

        return response()->json([
            'change24h' => $change24h,
        ]);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard with NFTs available for purchase.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $now = now();
        $userNfts = $user->nfts;
        $currentValue = $userNfts->sum('value');

        // Fetch snapshot from ~2 minutes ago for change calculation
        $snapshotAgo = \App\Models\PortfolioSnapshot::where('user_id', $user->id)
            ->where('created_at', '<=', $now->copy()->subSeconds(120))
            ->latest('created_at')->first();
        $change24h = 0;
        if ($snapshotAgo && $snapshotAgo->value > 0) {
            $change24h = (($currentValue - $snapshotAgo->value) / $snapshotAgo->value) * 100;
        }

        // Save a portfolio snapshot every 2 minutes
        $lastSnapshot = \App\Models\PortfolioSnapshot::where('user_id', $user->id)
            ->latest('created_at')->first();
        if (!$lastSnapshot || $now->diffInSeconds($lastSnapshot->created_at) >= 120) {
            \App\Models\PortfolioSnapshot::create([
                'user_id' => $user->id,
                'value' => $currentValue,
            ]);
        }

        // Show all NFTs on homepage
        $nfts = \App\Models\Nft::all();
        $netWorth = $user->balance + $userNfts->sum('value');
        $profit = $userNfts->sum(function ($nft) {
            return ($nft->value ?? 0) - ($nft->purchase_price ?? 0);
        });
        $userStats = [
            'balance' => $user->balance,
            'balanceUsd' => $user->balance, // If you have a USD conversion, update here
            'nftsOwned' => $userNfts->count(),
            'netWorth' => $netWorth,
            'profit' => $profit,
            'change24h' => $change24h,
            'stars' => $user->stars ?? 0, // If you have a stars column, otherwise set to 0
        ];

        return view('home', compact('nfts', 'userStats'));
    }
}
