<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyCheckinController extends Controller
{
    public function show()
    {
        // Example: You can fetch/check user check-in status here
        $user = Auth::user();
        $checkedInToday = false; // Replace with real logic
        $rewards = [
            '10 Stars',
            '5 Germs',
            'NFT Discount',
            '20 Stars',
            'Mystery Box',
            'No Reward'
        ];
        return view('daily-checkin', compact('checkedInToday', 'rewards'));
    }

    public function checkin(Request $request)
    {
        // Example: Save/check user check-in, randomize reward, etc.
        // For now, just return a random reward
        $reward = $request->input('reward', '');
        // Save check-in status to DB here
        return response()->json(['success' => true, 'reward' => $reward]);
    }
}
