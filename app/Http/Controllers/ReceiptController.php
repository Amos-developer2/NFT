<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    /**
     * Display all receipts for the authenticated user
     */
    public function index()
    {
        $receipts = Receipt::where('user_id', Auth::id())
            ->with(['nft', 'user'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('receipt.index', compact('receipts'));
    }

    /**
     * Show a single receipt
     */
    public function show($id)
    {
        $receipt = Receipt::findOrFail($id);
        
        // Ensure user can only view their own receipts
        if ($receipt->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('receipt.show', compact('receipt'));
    }

    /**
     * Download receipt as HTML
     */
    public function download($id)
    {
        $receipt = Receipt::findOrFail($id);
        
        // Ensure user can only download their own receipts
        if ($receipt->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $filename = 'receipt-' . $receipt->receipt_number . '.html';
        
        return response()->view('receipt.download', compact('receipt'), 200)
            ->header('Content-Disposition', "attachment; filename=$filename");
    }
}
