<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of withdrawals.
     */
    public function index(Request $request)
    {
        // Assuming you have a Withdrawal model, otherwise this shows user balance deductions
        // For now, this is a placeholder that can be expanded
        
        $users = User::select('id', 'name', 'email', 'balance')->get();
        
        return view('admin.withdrawals.index', compact('users'));
    }

    /**
     * Process a manual withdrawal.
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = User::findOrFail($validated['user_id']);

        if ($user->balance < $validated['amount']) {
            return redirect()->back()
                ->with('error', 'User has insufficient balance.');
        }

        $user->decrement('balance', $validated['amount']);

        return redirect()->route('admin.withdrawals.index')
            ->with('success', 'Withdrawal processed successfully. User balance deducted.');
    }
}
