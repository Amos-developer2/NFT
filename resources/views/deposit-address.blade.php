<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Address</title>

    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/deposit-address.css">
</head>

<body>
    <div class="mobile-container">

        {{-- Page Header --}}
        @include('partials.header', ['title' => 'Deposit Address'])

        {{-- Amount & Asset Card --}}
        <div class="address-card">
            <div class="address-card-header">
                <span class="currency-badge">
                    <img src="/icons/{{ strtolower($currency ?? 'usdt') }}.svg"
                        alt="{{ $currency ?? 'USDT' }}"
                        class="badge-icon">
                    {{ strtoupper($currency ?? 'USDT') }}
                </span>

                <span class="network-badge">
                    <img src="/icons/{{ strtolower($network ?? 'trc20') }}.svg"
                        alt="{{ $network ?? 'TRC20' }}"
                        class="badge-icon">
                    {{ strtoupper($network ?? 'TRC20') }}
                </span>
            </div>

            <div class="address-card-amount">
                <span class="amount-label">Amount to Send</span>
                <span class="amount-value">${{ number_format($amount ?? 100, 2) }}</span>
            </div>
        </div>

        {{-- QR Code --}}
        <div class="qr-section">
            <div class="qr-container">
                <div class="qr-code">
                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($address ?? 'TXyz1234567890ABCDEFGHIJKLMNOPqrstuv') }}"
                        alt="Deposit QR Code">
                </div>

                <p class="qr-instruction">
                    Scan this QR code using your wallet app to send funds
                </p>
            </div>
        </div>

        {{-- Address --}}
        <div class="address-section">
            <label class="address-label">Wallet Address</label>

            <div class="address-box">
                <span class="address-text" id="depositAddress">
                    {{ $address ?? 'TXyz1234567890ABCDEFGHIJKLMNOPqrstuv' }}
                </span>

                <button type="button"
                    class="copy-btn"
                    onclick="copyAddress()"
                    aria-label="Copy address">
                    <img src="/icons/copy.svg" alt="Copy">
                </button>
            </div>

            <div class="copy-feedback" id="copyFeedback">
                <img src="/icons/check.svg" class="feedback-icon" alt="">
                Address copied successfully
            </div>
        </div>

        {{-- Important Notice --}}
        <div class="deposit-info">
            <h3>
                <img src="/icons/warning.svg" class="warning-icon" alt="">
                Important Information
            </h3>

            <ul>
                <li>
                    Send only <strong>{{ strtoupper($currency ?? 'USDT') }}</strong>
                </li>
                <li>
                    Use <strong>{{ strtoupper($network ?? 'TRC20') }}</strong> network only
                </li>
                <li>
                    Minimum deposit: <strong>$10</strong>
                </li>
                <li>
                    Funds will be credited after network confirmation
                </li>
                <li>
                    Sending wrong tokens may cause permanent loss
                </li>
            </ul>
        </div>

        {{-- Footer --}}
        @include('partials.footer')
        <div class="pb-20"></div>
    </div>

    <script>
        function copyAddress() {
            const address = document.getElementById('depositAddress').textContent.trim();

            navigator.clipboard.writeText(address).then(() => {
                const feedback = document.getElementById('copyFeedback');
                feedback.classList.add('show');

                setTimeout(() => {
                    feedback.classList.remove('show');
                }, 2000);
            });
        }
    </script>
</body>

</html>