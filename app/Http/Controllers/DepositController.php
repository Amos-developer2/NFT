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
            'currency_network' => 'required|in:usdt_bep20,usdc_bep20,usdt_trc20,bnb_bsc',
            'amount'   => 'required|numeric|min:25', // Minimum deposit is 25 USD
        ]);

        $user     = $request->user();
        
        // Parse currency and network from combined field
        [$currency, $network] = explode('_', $request->currency_network);
        $amount   = $request->amount;

        // Map to NowPayments pay_currency format (combined currency+network codes)
        $currencyMap = [
            'usdt_trc20' => 'usdttrc20',
            'usdt_bep20' => 'usdtbsc',
            'usdc_bep20' => 'usdcbsc',
            'bnb_bsc'    => 'bnbbsc',
        ];

        $npCurrency = $currencyMap[$request->currency_network] ?? $currency;

        /*
        |--------------------------------------------------------------------------
        | CHECK EXISTING PENDING DEPOSIT
        |--------------------------------------------------------------------------
        */
        $deposit = Deposit::where('user_id', $user->id)
            ->whereIn('status', ['waiting', 'confirming', 'confirmed', 'sending', 'partially_paid'])
            ->where('amount', $amount)
            ->whereNotNull('pay_address')
            ->latest()
            ->first();

        if (!$deposit) {

            $orderId = $currency . '_' . $network . '_user_' . $user->id . '_' . time();

            $paymentData = [
                'price_amount'       => $amount,
                'price_currency'     => 'usd',
                'pay_currency'       => $npCurrency,
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
                'request' => $paymentData,
                'body' => $response->body(),
                'json' => $response->json(),
                'status' => $response->status(),
            ]);

            if (!$response->successful()) {
                $errorMessage = $response->json()['message'] ?? 'Payment gateway error. Please try again.';
                return back()->withErrors([
                    'deposit' => $errorMessage
                ])->withInput();
            }

            $json = $response->json();
            
            // Check if we got a valid response with pay_address
            if (empty($json['pay_address'])) {
                return back()->withErrors([
                    'deposit' => 'Failed to generate deposit address. Please try again.'
                ])->withInput();
            }

            $deposit = Deposit::create([
                'user_id'     => $user->id,
                'amount'      => $amount,
                'currency'    => strtoupper($currency),
                'network'     => strtoupper($network),
                'order_id'    => $orderId,
                'status'      => $json['payment_status'] ?? 'waiting',
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

        if (!$deposit || in_array($deposit->status, ['finished', 'failed', 'refunded', 'expired'])) {
            return response('Ignored', 200);
        }

        // Update deposit status from NowPayments
        $deposit->update(['status' => $data['payment_status']]);
        
        // Credit balance only on finished status
        if ($data['payment_status'] === 'finished') {
            DB::transaction(function () use ($deposit) {
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
