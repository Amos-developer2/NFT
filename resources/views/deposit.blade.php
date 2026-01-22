<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Funds</title>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/deposit.css">
</head>

<body>
    <div class="mobile-container">
        <!-- Page Header -->
        @include('partials.header', ['title' => 'Deposit'])

        <!-- Deposit Card -->
        <div class="total-card" style="padding: 25px 16px;">
            <div class="top">
                <div class="info">Deposit Funds <img src="/icons/info.svg" alt="Info" class="icon-sm icon-white"></div>
            </div>
            <div class="main">Deposit</div>
            <div class="sub">Choose your currency, network, and amount</div>
        </div>

        <!-- Deposit Form -->
        <form class="deposit-form" action="{{ route('user.deposit.address') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="currency" class="deposit-label">Currency</label>
                <div class="custom-select-wrapper">
                    <select id="currency" name="currency" class="deposit-input">
                        <option value="usdt" data-icon="/icons/usdt.svg">USDT - Tether USD</option>
                        <option value="usdc" data-icon="/icons/usdc.svg">USDC - USD Coin</option>
                    </select>
                    <img src="/icons/usdt.svg" alt="" class="select-icon" id="currency-icon">
                </div>
            </div>

            <div class="form-group">
                <label for="network" class="deposit-label">Network</label>
                <div class="custom-select-wrapper">
                    <select id="network" name="network" class="deposit-input">
                        <option value="trc20" data-icon="/icons/trc20.svg">TRC20 - Tron Network</option>
                        <option value="bep20" data-icon="/icons/bep20.svg">BEP20 - Binance Smart Chain</option>
                    </select>
                    <img src="/icons/trc20.svg" alt="" class="select-icon" id="network-icon">
                </div>
            </div>

            <div class="form-group">
                <label for="amount" class="deposit-label">Amount</label>
                <input type="number" id="amount" name="amount" class="deposit-input" placeholder="Enter amount" min="1" step="any">
                <div class="quick-amounts">
                    <button type="button" class="quick-amount-btn" data-amount="50">$50</button>
                    <button type="button" class="quick-amount-btn" data-amount="100">$100</button>
                    <button type="button" class="quick-amount-btn" data-amount="200">$200</button>
                    <button type="button" class="quick-amount-btn" data-amount="400">$400</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Deposit
            </button>
        </form>

        <!-- Deposit Information -->
        <div class="deposit-info">
            <h3>Important Information</h3>
            <ul>
                <li>Minimum deposit: $10</li>
                <li>Ensure you select the correct network to avoid loss of funds.</li>
                <li>Deposits may take up to 20 minutes to reflect in your account.</li>
            </ul>
        </div>

        <!-- Footer -->
        @include('partials.footer')
        <div class="pb-20"></div>
    </div>

    <script>
        // Update currency icon when selection changes
        document.getElementById('currency').addEventListener('change', function() {
            const icon = this.options[this.selectedIndex].getAttribute('data-icon');
            document.getElementById('currency-icon').src = icon;
        });

        // Update network icon when selection changes
        document.getElementById('network').addEventListener('change', function() {
            const icon = this.options[this.selectedIndex].getAttribute('data-icon');
            document.getElementById('network-icon').src = icon;
        });

        // Quick amount buttons
        document.querySelectorAll('.quick-amount-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const amount = this.getAttribute('data-amount');
                document.getElementById('amount').value = amount;
                // Remove active class from all buttons
                document.querySelectorAll('.quick-amount-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                // Add active class to clicked button
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>