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
        $request->validate([
            'currency' => 'required|in:usdt,usdc',
            'network' => 'required|in:trc20,bep20',
            'amount' => 'required|numeric|min:10',
        ]);
        $user = $request->user(); // Fetch the authenticated user
        $currency = $request->input('currency');
        $network = $request->input('network');
        $amount = $request->input('amount');

        // Try to find an existing pending deposit for this user with same params
        $deposit = Deposit::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('amount', $amount)
            ->where('pay_address', '!=', null)
            ->where('order_id', 'like', "%{$currency}_{$network}%")
            ->latest()->first();

        if (!$deposit) {
            // Create new order id with currency and network for uniqueness
            $orderId = $currency . '_' . $network . '_user_' . $user->id . '_' . time();
            $apiKey = config('services.nowpayments.api_key');
            $baseUrl = config('services.nowpayments.base_url');
            $paymentData = [
                'price_amount' => $amount,
                'price_currency' => 'usd',
                'pay_currency' => $currency,
                'ipn_callback_url' => route('nowpayments.ipn'),
                'order_id' => $orderId,
                'order_description' => 'Deposit to TradeX',
            ];
            // Only add network if valid for currency
            $validNetworks = [
                'usdt' => ['trc20', 'bep20'],
                'usdc' => ['trc20', 'bep20'],
            ];
            if (isset($validNetworks[$currency]) && in_array($network, $validNetworks[$currency])) {
                $paymentData['network'] = $network;
            }
            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post($baseUrl . '/payment', $paymentData);
            $status = $response->status();
            $json = $response->json();
            if ($status >= 200 && $status < 300 && is_array($json)) {
                $deposit = Deposit::create([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'order_id' => $orderId,
                    'status' => 'pending',
                    'pay_id' => $json['payment_id'] ?? null,
                    'pay_address' => $json['pay_address'] ?? null,
                ]);
            } else {
                // Debug: Show NOWPayments API response
                dd(['status' => $status, 'body' => $response->body(), 'json' => $json]);
                // return back()->withErrors(['deposit' => 'Failed to create deposit address. Please try again.']);
            }
        }

        return view('deposit-address', [
            'address' => $deposit->pay_address,
            'amount' => $deposit->amount,
            'currency' => $currency,
            'network' => $network,
        ]);
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
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post($baseUrl . '/payment', $paymentData);
        $status = $response->status();
        $json = $response->json();
        if ($status >= 200 && $status < 300 && is_array($json)) {
            // 3. Save payment_id to deposit
            $deposit->pay_id = $json['payment_id'] ?? null;
            $deposit->pay_address = $json['pay_address'] ?? null;
            $deposit->save();
            // 4. Redirect user to invoice
            return redirect($json['invoice_url'] ?? $json['pay_address']);
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

    /**
     * STEP 1: Select network and create/reuse deposit
     */
    public function store(Request $request, \App\Services\NowPaymentsService $nowPayments)
    {
        $request->validate([
            'currency' => 'required|in:usdttrc20,usdtbsc,usdcbsc,bnbbsc',
        ]);

        // Reuse active deposit per user + network
        $deposit = \App\Models\Deposit::where('user_id', auth()->id())
            ->where('currency', $request->currency)
            ->whereIn('status', ['pending', 'confirming'])
            ->first();

        if ($deposit) {
            return redirect()->route('deposit.qr', $deposit->id);
        }

        // Create new deposit
        $deposit = \App\Models\Deposit::create([
            'user_id'  => auth()->id(),
            'amount'   => 10000, // minimum USD
            'currency' => $request->currency,
            'status'   => 'pending',
        ]);

        // Create NOWPayments payment
        $payment = $nowPayments->createPayment(
            $request->currency,
            $deposit->id
        );

        if (empty($payment['payment_id'])) {
            logger()->error('NOWPayments create failed', $payment);
            abort(500, 'Payment provider error');
        }

        $deposit->update([
            'payment_id' => $payment['payment_id'],
        ]);

        return redirect()->route('deposit.qr', $deposit->id);
    }

    /**
     * STEP 2: QR page
     * Fetch address ONLY if missing
     */
    public function showQrCode(\App\Models\Deposit $deposit, \App\Services\NowPaymentsService $nowPayments)
    {
        abort_if($deposit->user_id !== auth()->id(), 403);

        // Only active deposits
        abort_if(!in_array($deposit->status, ['pending', 'confirming']), 404);

        // Fetch address if missing
        if (!$deposit->pay_address && $deposit->payment_id) {
            $status = $nowPayments->getPaymentStatus($deposit->payment_id);

            if (!empty($status['pay_address'])) {
                $deposit->update([
                    'pay_address'  => $status['pay_address'],
                    'pay_currency' => $status['pay_currency'] ?? null,
                    'pay_amount'   => $status['pay_amount'] ?? null,
                ]);
            }
        }

        return view('qr-code', compact('deposit'));
    }
}
