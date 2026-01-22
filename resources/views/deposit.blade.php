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
        <div class="total-card">
            <div class="top">
                <div class="info"style="font-size: 15px; font-weight: 700;">Deposit Funds  <img src="/icons/info.svg" alt="Info" class="icon-sm icon-white"></div>
            </div>
            <!-- <div class="main">Deposit</div> -->
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
                <label for="amount" class="deposit-label">Amount (Minimum 25 USDT)</label>
                <div class="deposit-amount-wrapper" style="display: flex; align-items: center; gap: 10px;">
                    <input type="number" id="amount" name="amount" class="deposit-input" placeholder="Enter amount" min="25" step="any" style="flex:2;">
                    <!-- <span style="background:linear-gradient(135deg,#60a5fa,#2563eb);color:#fff;padding:7px 14px;border-radius:8px;font-weight:700;font-size:13px;">USDT</span> -->
                </div>
                <div class="quick-amounts" style="margin-top:8px;">
                    <button type="button" class="quick-amount-btn" data-amount="25">$25</button>
                    <button type="button" class="quick-amount-btn" data-amount="50">$50</button>
                    <button type="button" class="quick-amount-btn" data-amount="100">$100</button>
                    <button type="button" class="quick-amount-btn" data-amount="200">$200</button>
                </div>
                <div class="min-deposit-note" style="font-size:12px;color:#ef4444;margin-top:6px;">
                    <!-- <svg width="14" height="14" style="vertical-align:middle;margin-right:3px;" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg> -->
                    <!-- Minimum deposit is 25 USDT -->
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
                <li>Minimum deposit: $25</li>
                <li>Ensure you select the correct network to avoid loss of funds.</li>
                <li>Deposits is automatic.</li>
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
        // Enforce minimum deposit
        document.getElementById('amount').addEventListener('input', function() {
            if (this.value && parseFloat(this.value) < 25) {
                this.value = 25;
            }
        });
    </script>
</body>

</html>