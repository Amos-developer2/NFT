<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Display a listing of deposits.
     */
    public function index(Request $request)
    {
        $query = Deposit::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Filter by amount range
        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        $deposits = $query->latest()->paginate(15);
        $users = User::select('id', 'name')->get();
        
        // Statistics
        $totalDeposits = Deposit::where('status', 'finished')->sum('amount');
        $pendingDeposits = Deposit::whereIn('status', ['pending', 'waiting'])->sum('amount');
        $todayDeposits = Deposit::where('status', 'finished')
            ->whereDate('created_at', today())
            ->sum('amount');

        return view('admin.deposits.index', compact(
            'deposits', 
            'users', 
            'totalDeposits', 
            'pendingDeposits', 
            'todayDeposits'
        ));
    }

    /**
     * Display the specified deposit.
     */
    public function show(Deposit $deposit)
    {
        $deposit->load('user');
        return view('admin.deposits.show', compact('deposit'));
    }

    /**
     * Update the deposit status.
     */
    public function updateStatus(Request $request, Deposit $deposit)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,waiting,confirming,confirmed,finished,failed,expired',
        ]);

        $oldStatus = $deposit->status;
        $deposit->update(['status' => $validated['status']]);

        // If status changed to finished, credit user balance
        if ($validated['status'] === 'finished' && $oldStatus !== 'finished') {
            $deposit->user->increment('balance', $deposit->amount);
        }

        // If status changed from finished to something else, deduct balance
        if ($oldStatus === 'finished' && $validated['status'] !== 'finished') {
            $deposit->user->decrement('balance', $deposit->amount);
        }

        return redirect()->back()
            ->with('success', 'Deposit status updated successfully.');
    }

    /**
     * Manually create a deposit (admin credit).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,finished',
        ]);

        $validated['pay_id'] = 'ADMIN-' . uniqid();
        $validated['order_id'] = 'ADMIN-' . time();

        $deposit = Deposit::create($validated);

        // If marked as finished, credit user balance
        if ($validated['status'] === 'finished') {
            $deposit->user->increment('balance', $validated['amount']);
        }

        return redirect()->route('admin.deposits.index')
            ->with('success', 'Deposit created successfully.');
    }

    /**
     * Remove the specified deposit.
     */
    public function destroy(Deposit $deposit)
    {
        // If deposit was finished, deduct from user balance
        if ($deposit->status === 'finished') {
            $deposit->user->decrement('balance', $deposit->amount);
        }

        $deposit->delete();

        return redirect()->route('admin.deposits.index')
            ->with('success', 'Deposit deleted successfully.');
    }
}
