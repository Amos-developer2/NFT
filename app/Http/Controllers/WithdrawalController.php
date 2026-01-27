<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WithdrawalController extends Controller
{
    /**
     * Show the withdrawal form.
     */
    public function show()
    {
        return view('withdrawal');
    }

    /**
     * Process the withdrawal request.
     */
    public function process(Request $request)
    {
        // Validate the withdrawal request
        $validated = $request->validate([
            'network' => 'required|in:trc20,bep20',
            'wallet_address' => 'required|string|min:10|max:100',
            'amount' => 'required|numeric|min:12',
            'withdrawal_pin' => 'required|string|size:4',
        ], [
            'amount.min' => 'Minimum withdrawal amount is 12 USDT.',
            'withdrawal_pin.size' => 'Withdrawal PIN must be 4 digits.',
        ]);

        $user = Auth::user();

        // Verify withdrawal PIN against user's stored PIN with bcrypt guard
        if (!$user->withdrawal_pin || !preg_match('/^\$2[aby]\$/', $user->withdrawal_pin)) {
            return back()->withErrors(['withdrawal_pin' => 'Your withdrawal PIN is not set correctly. Please reset your PIN.']);
        }
        if (!Hash::check($validated['withdrawal_pin'], $user->withdrawal_pin)) {
            return back()->withErrors(['withdrawal_pin' => 'Invalid withdrawal PIN.']);
        }

        // TODO: Check if user has sufficient balance
        // if ($user->balance < $validated['amount']) {
        //     return back()->withErrors(['amount' => 'Insufficient balance.']);
        // }

        // Calculate fee based on network
        $fee = $validated['network'] === 'trc20' ? 1.00 : 0.50;
        $receiveAmount = $validated['amount'] - $fee;

        // TODO: Create withdrawal record in database
        // Withdrawal::create([
        //     'user_id' => $user->id,
        //     'network' => $validated['network'],
        //     'wallet_address' => $validated['wallet_address'],
        //     'amount' => $validated['amount'],
        //     'fee' => $fee,
        //     'receive_amount' => $receiveAmount,
        //     'status' => 'pending',
        // ]);

        // TODO: Deduct balance from user account
        // $user->decrement('balance', $validated['amount']);

        return redirect()->route('user.withdrawal.history')
            ->with('success', 'Withdrawal request submitted successfully. You will receive $' . number_format($receiveAmount, 2) . ' within 10-30 minutes.');
    }

    /**
     * Show the withdrawal history.
     */
    public function history()
    {
        // TODO: Fetch actual withdrawal records from database
        // $withdrawals = Withdrawal::where('user_id', Auth::id())
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        // Sample data for now
        $totalWithdrawals = 5;
        $pendingCount = 2;
        $completedCount = 3;

        return view('withdrawal-history', compact('totalWithdrawals', 'pendingCount', 'completedCount'));
    }
}
