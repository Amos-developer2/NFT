<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NowPaymentsService
{
    /**
     * Create a payment on NOWPayments
     * @param string $currencyNetwork e.g. 'usdttrc20'
     * @param int $orderId
     * @return array
     */
    public function createPayment($currencyNetwork, $orderId)
    {
        [$currency, $network] = $this->parseCurrencyNetwork($currencyNetwork);
        $networkMap = [
            'trc20' => 'tron',
            'bep20' => 'bsc',
            'erc20' => 'ethereum',
        ];
        $paymentData = [
            'price_amount' => 10000, // minimum USD
            'price_currency' => 'usd',
            'pay_currency' => $currency,
            'order_id' => $orderId,
            'order_description' => 'Deposit to TradeX',
            'ipn_callback_url' => route('nowpayments.ipn'),
        ];
        if ($network && isset($networkMap[$network])) {
            $paymentData['network'] = $networkMap[$network];
        }
        $response = Http::withHeaders([
            'x-api-key' => config('services.nowpayments.api_key'),
            'Content-Type' => 'application/json',
        ])->post(config('services.nowpayments.base_url') . '/payment', $paymentData);
        return $response->json();
    }

    /**
     * Get payment status from NOWPayments
     * @param string $paymentId
     * @return array
     */
    public function getPaymentStatus($paymentId)
    {
        $response = Http::withHeaders([
            'x-api-key' => config('services.nowpayments.api_key'),
        ])->get(config('services.nowpayments.base_url') . "/payment/$paymentId");
        return $response->json();
    }

    /**
     * Parse combined currency+network string
     * @param string $currencyNetwork
     * @return array [currency, network]
     */
    public function parseCurrencyNetwork($currencyNetwork)
    {
        // e.g. usdttrc20 => ['usdt', 'trc20']
        if (preg_match('/^(usdt|usdc|bnb)(trc20|bsc|erc20)$/', $currencyNetwork, $m)) {
            return [$m[1], $m[2]];
        }
        return [$currencyNetwork, null];
    }
}
