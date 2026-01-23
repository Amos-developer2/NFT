<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW DEPOSIT PAGE
    |--------------------------------------------------------------------------
    */
    public function show()
    {
        return view('deposit');
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE DEPOSIT ADDRESS (MAIN FLOW)
    |--------------------------------------------------------------------------
    */
    public function showAddress(Request $request)
    {
        $request->validate([
            'currency' => 'required|in:usdt,usdc',
            'network'  => 'required|in:trc20,bep20',
            'amount'   => 'required|numeric|min:25', // Minimum deposit is 25 USD
        ]);

        $user     = $request->user();
        $currency = $request->currency;
        $network  = $request->network;
        $amount   = $request->amount;

        // Map network to NOWPayments format
        $networkMap = [
            'trc20' => 'tron',
            'bep20' => 'bsc',
        ];

        $npNetwork = $networkMap[$network];

        /*
        |--------------------------------------------------------------------------
        | CHECK EXISTING PENDING DEPOSIT
        |--------------------------------------------------------------------------
        */
        $deposit = Deposit::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('amount', $amount)
            ->whereNotNull('pay_address')
            ->latest()
            ->first();

        if (!$deposit) {

            $orderId = $currency . '_' . $network . '_user_' . $user->id . '_' . time();

            $paymentData = [
                'price_amount'       => $amount,
                'price_currency'     => 'usd',
                'pay_currency'       => $currency,
                'network'            => $npNetwork, // ✅ FIXED
                'ipn_callback_url'   => route('nowpayments.ipn'),
                'order_id'           => $orderId,
                'order_description'  => 'Deposit to TradeX',
            ];

            $response = Http::withHeaders([
                'x-api-key'    => config('services.nowpayments.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.nowpayments.base_url') . '/payment', $paymentData);

            // Log NOWPayments response for debugging
            logger()->info('NOWPayments response', [
                'body' => $response->body(),
                'json' => $response->json(),
                'status' => $response->status(),
            ]);

            if (!$response->successful()) {
                return back()->withErrors([
                    'deposit' => 'Payment gateway error. Try again.'
                ]);
            }

            $json = $response->json();

            $deposit = Deposit::create([
                'user_id'     => $user->id,
                'amount'      => $amount,
                'order_id'    => $orderId,
                'status'      => 'pending',
                'pay_id'      => $json['payment_id'] ?? null,
                'pay_address' => $json['pay_address'] ?? null,
                'pay_currency' => $json['pay_currency'] ?? null,
                'pay_amount'  => $json['pay_amount'] ?? null,
            ]);
        }

        return view('deposit-address', [
            'address'  => $deposit->pay_address,
            'amount'   => $deposit->amount,
            'currency' => strtoupper($currency),
            'network'  => strtoupper($network),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | NOWPAYMENTS WEBHOOK (IPN)
    |--------------------------------------------------------------------------
    */
    public function nowpaymentsIpn(Request $request)
    {
        $ipnSecret = config('services.nowpayments.ipn_secret');
        $hmacHeader = $request->header('x-nowpayments-sig');

        $calculated = hash_hmac('sha512', $request->getContent(), $ipnSecret);

        // Security check
        if (!hash_equals($hmacHeader, $calculated)) {
            return response('Invalid signature', 401);
        }

        $data = $request->all();

        $deposit = Deposit::where('pay_id', $data['payment_id'] ?? null)->first();

        if (!$deposit || $deposit->status !== 'pending') {
            return response('Ignored', 200);
        }

        // Acceptable success statuses
        if (in_array($data['payment_status'], ['finished', 'confirmed'])) {

            DB::transaction(function () use ($deposit) {

                $deposit->update(['status' => 'completed']);

                $user = $deposit->user;
                $user->increment('balance', $deposit->amount);
            });
        }

        return response('OK', 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DEPOSIT HISTORY PAGE
    |--------------------------------------------------------------------------
    */
    public function history()
    {
        $deposits = Deposit::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('deposit-history', compact('deposits'));
    }
}
