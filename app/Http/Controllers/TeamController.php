<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // Get stats for all 6 levels
        $levels = [];
        $totalTeam = 0;
        $totalActive = 0;
        $totalDeposits = 0;
        $totalCommission = 0;

        for ($i = 1; $i <= 6; $i++) {
            $stats = $user->getLevelStats($i);
            $levels[$i] = $stats;
            $totalTeam += $stats['total'];
            $totalActive += $stats['active'];
            $totalDeposits += $stats['deposits'];
            $totalCommission += $stats['commission'];
        }

        return view('team', compact(
            'levels',
            'totalTeam',
            'totalActive',
            'totalDeposits',
            'totalCommission'
        ));
    }
}
