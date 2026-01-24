<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyCheckin;
use Carbon\Carbon;
use App\Models\User;

class DailyCheckinController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $checkin = DailyCheckin::where('user_id', $user->id)
            ->where('checkin_date', $today)
            ->first();

        $alreadyCheckedIn = $checkin !== null;
        $rewards = [
            '10 Stars',
            '5 Germs',
            'NFT Discount',
            '20 Stars',
            'Mystery Box',
            'No Reward'
        ];
        $reward = $checkin ? $checkin->reward : null;

        return view('daily-checkin', compact('alreadyCheckedIn', 'rewards', 'reward'));
    }

    public function checkin(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $existing = DailyCheckin::where('user_id', $user->id)
            ->where('checkin_date', $today)
            ->first();
        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Already checked in today.', 'reward' => $existing->reward]);
        }

        $rewards = [
            '10 Stars',
            '5 Germs',
            'NFT Discount',
            '20 Stars',
            'Mystery Box',
            'No Reward'
        ];
        $index = $request->input('index');
        $reward = $rewards[$index] ?? $rewards[array_rand($rewards)];

        // Credit reward to user (example logic)
        if (str_contains($reward, 'Stars')) {
            $amount = (int) filter_var($reward, FILTER_SANITIZE_NUMBER_INT);
            $user->stars = ($user->stars ?? 0) + $amount;
            $user->save();
        } elseif (str_contains($reward, 'Germs')) {
            $amount = (int) filter_var($reward, FILTER_SANITIZE_NUMBER_INT);
            $user->germs = ($user->germs ?? 0) + $amount;
            $user->save();
        }
        // Add more reward logic as needed

        DailyCheckin::create([
            'user_id' => $user->id,
            'checkin_date' => $today,
            'reward' => $reward,
        ]);

        return response()->json(['success' => true, 'reward' => $reward]);
    }
}
