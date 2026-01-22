<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Nft;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get statistics
        $totalUsers = User::count();
        $totalNfts = Nft::count();
        $activeAuctions = Auction::where('status', 'active')
            ->where('end_time', '>', now())
            ->count();
        $totalDeposits = Deposit::where('status', 'finished')->sum('amount');
        
        // Today's stats
        $newUsersToday = User::whereDate('created_at', Carbon::today())->count();
        $totalBids = Bid::count();
        $pendingDeposits = Deposit::whereIn('status', ['pending', 'waiting'])->count();
        $pendingWithdrawals = 0; // Assuming withdrawals model exists
        
        // Recent data
        $recentUsers = User::latest()->take(5)->get();
        $recentDeposits = Deposit::with('user')->latest()->take(5)->get();
        $recentNfts = Nft::latest()->take(5)->get();
        $recentAuctions = Auction::with('nft')
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalNfts',
            'activeAuctions',
            'totalDeposits',
            'newUsersToday',
            'totalBids',
            'pendingDeposits',
            'pendingWithdrawals',
            'recentUsers',
            'recentDeposits',
            'recentNfts',
            'recentAuctions'
        ));
    }
}
