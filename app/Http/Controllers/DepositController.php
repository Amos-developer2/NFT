<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function show()
    {
        return view('deposit');
    }

    public function showAddress(Request $request)
    {
        // This method is deprecated: deposit addresses are now fetched from NOWPayments in createNowPaymentsDeposit.
        // You may redirect users to the new deposit flow or show a message.
        return redirect()->route('user.deposit');
    }

    public function history()
    {
        return view('deposit-history');
    }

    public function createNowPaymentsDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'network' => 'required|in:trc20,bep20',
        ]);
        $user = $request->user();
        $amount = $request->input('amount');
        $network = $request->input('network');
        $orderId = 'user_' . $user->id . '_' . time();
        // 1. Create pending deposit record
        $deposit = Deposit::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'order_id' => $orderId,
            'status' => 'pending',
        ]);
        // 2. Create NOWPayments invoice
        $apiKey = config('services.nowpayments.api_key');
        $baseUrl = config('services.nowpayments.base_url');
        $paymentData = [
            'price_amount' => $amount,
            'price_currency' => 'usd',
            'pay_currency' => 'usdt',
            'network' => $network,
            'ipn_callback_url' => route('nowpayments.ipn'),
            'order_id' => $orderId,
            'order_description' => 'Deposit to TradeX',
        ];
        $response = \Http::withHeaders([
            'x-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post($baseUrl . '/payment', $paymentData);
        if ($response->successful()) {
            $payment = $response->json();
            // 3. Save payment_id to deposit
            $deposit->pay_id = $payment['payment_id'] ?? null;
            $deposit->pay_address = $payment['pay_address'] ?? null;
            $deposit->save();
            // 4. Redirect user to invoice
            return redirect($payment['invoice_url'] ?? $payment['pay_address']);
        } else {
            $deposit->status = 'failed';
            $deposit->save();
            return back()->withErrors(['deposit' => 'Failed to create deposit. Please try again.']);
        }
    }

    // Webhook endpoint for NOWPayments
    public function nowpaymentsIpn(Request $request)
    {
        $ipnSecret = config('services.nowpayments.ipn_secret');
        $headers = $request->headers->all();
        $hmac = $headers['x-nowpayments-sig'][0] ?? '';
        $body = $request->getContent();
        $calculated = hash_hmac('sha512', $body, $ipnSecret);
        if (!hash_equals($hmac, $calculated)) {
            return response('Invalid signature', 401);
        }
        $data = $request->all();
        $deposit = Deposit::where('pay_id', $data['payment_id'] ?? null)->first();
        if (!$deposit || $deposit->status !== 'pending') {
            return response('Ignored', 200);
        }
        if (in_array($data['payment_status'], ['finished', 'confirmed'])) {
            DB::transaction(function () use ($deposit, $data) {
                $deposit->status = 'completed';
                $deposit->save();
                $user = $deposit->user;
                $user->balance += $deposit->amount;
                $user->save();
            });
        }
        return response('OK', 200);
    }
}
