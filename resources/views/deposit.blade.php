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
                <div class="info" style="font-size: 15px; font-weight: 700;">Deposit Funds <img src="/icons/info.svg" alt="Info" class="icon-sm icon-white"></div>
            </div>
            <!-- <div class="main">Deposit</div> -->
            <div class="sub">Choose your currency, network, and amount</div>
        </div>

        <!-- Deposit Form -->
        <form class="deposit-form" action="{{ route('user.deposit.address') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="deposit-label">Select Network</label>
                <div class="network-list" style="display: flex; flex-direction: column; gap: 16px;">
                    <label class="network-card" style="display: flex; align-items: center; background: #fff; border-radius: 12px; padding: 16px; cursor: pointer; border: 2px solid #e5e7eb; transition: border 0.2s; color: #18181b; position:relative;">
                        <input type="radio" name="currency_network" value="usdt_bep20" style="display:none;" required>
                        <img src="/icons/usdt.svg" alt="USDT" style="width:40px;height:40px;margin-right:16px;">
                        <div style="flex:1;">
                            <div style="font-weight:700; color:#18181b;">USDT</div>
                            <div style="font-size:13px; color:#71717a;">BEP20 (BSC)</div>
                        </div>
                        <span class="selected-check" style="display:none;position:absolute;top:10px;right:10px;background:#2563eb;color:#fff;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:16px;">&#10003;</span>
                    </label>
                    <label class="network-card" style="display: flex; align-items: center; background: #fff; border-radius: 12px; padding: 16px; cursor: pointer; border: 2px solid #e5e7eb; transition: border 0.2s; color: #18181b; position:relative;">
                        <input type="radio" name="currency_network" value="usdc_bep20" style="display:none;">
                        <img src="/icons/usdc.svg" alt="USDC" style="width:40px;height:40px;margin-right:16px;">
                        <div style="flex:1;">
                            <div style="font-weight:700; color:#18181b;">USDC</div>
                            <div style="font-size:13px; color:#71717a;">BEP20 (BSC)</div>
                        </div>
                        <span class="selected-check" style="display:none;position:absolute;top:10px;right:10px;background:#2563eb;color:#fff;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:16px;">&#10003;</span>
                    </label>
                    <label class="network-card" style="display: flex; align-items: center; background: #fff; border-radius: 12px; padding: 16px; cursor: pointer; border: 2px solid #e5e7eb; transition: border 0.2s; color: #18181b; position:relative;">
                        <input type="radio" name="currency_network" value="usdt_trc20" style="display:none;">
                        <img src="/icons/usdt.svg" alt="USDT" style="width:40px;height:40px;margin-right:16px;">
                        <div style="flex:1;">
                            <div style="font-weight:700; color:#18181b;">USDT</div>
                            <div style="font-size:13px; color:#71717a;">TRC20</div>
                        </div>
                        <span class="selected-check" style="display:none;position:absolute;top:10px;right:10px;background:#2563eb;color:#fff;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:16px;">&#10003;</span>
                    </label>
                    <label class="network-card" style="display: flex; align-items: center; background: #fff; border-radius: 12px; padding: 16px; cursor: pointer; border: 2px solid #e5e7eb; transition: border 0.2s; color: #18181b; position:relative;">
                        <input type="radio" name="currency_network" value="bnb_bsc" style="display:none;">
                        <img src="/icons/bnb.svg" alt="BNB" style="width:40px;height:40px;margin-right:16px;">
                        <div style="flex:1;">
                            <div style="font-weight:700; color:#18181b;">BNB</div>
                            <div style="font-size:13px; color:#71717a;">BSC</div>
                        </div>
                        <span class="selected-check" style="display:none;position:absolute;top:10px;right:10px;background:#2563eb;color:#fff;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:16px;">&#10003;</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="amount" class="deposit-label">Amount (Minimum 25 USDT)</label>
                <div class="deposit-amount-wrapper" style="display: flex; align-items: center; gap: 10px;">
                    <input type="number" id="amount" name="amount" class="deposit-input" placeholder="Enter amount" min="25" step="any" style="flex:2;" required>
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

            <script>
                // Highlight selected card and show checkmark
                function updateCardSelection() {
                    document.querySelectorAll('.network-card').forEach(function(card) {
                        card.style.border = '2px solid #e5e7eb';
                        card.querySelector('.selected-check').style.display = 'none';
                    });
                    var selected = document.querySelector('input[name="currency_network"]:checked');
                    if (selected) {
                        var card = selected.parentElement;
                        card.style.border = '2px solid #2563eb';
                        card.querySelector('.selected-check').style.display = 'flex';
                    }
                }
                document.querySelectorAll('.network-card input[type="radio"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        updateCardSelection();
                        // No summary text
                    });
                });
                // No button change
                // Only allow one card to be selected
                document.querySelectorAll('.network-card').forEach(function(card) {
                    card.addEventListener('click', function() {
                        var radio = this.querySelector('input[type="radio"]');
                        radio.checked = true;
                        radio.dispatchEvent(new Event('change'));
                    });
                });
                // On page load, update selection if any
                updateCardSelection();
                // Require amount to be filled or selected
                document.querySelector('form.deposit-form').addEventListener('submit', function(e) {
                    var amount = document.getElementById('amount').value;
                    if (!amount || parseFloat(amount) < 25) {
                        e.preventDefault();
                        alert('Please enter a valid amount (minimum 25) or select a quick amount.');
                    }
                    var selected = document.querySelector('input[name="currency_network"]:checked');
                    if (!selected) {
                        e.preventDefault();
                        alert('Please select a currency and network.');
                    }
                });

                // Quick amount buttons (moved here to ensure DOM is ready)
                document.querySelectorAll('.quick-amount-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const amount = this.getAttribute('data-amount');
                        var input = document.getElementById('amount');
                        input.value = amount;
                        input.focus();
                        // Remove active class from all buttons
                        document.querySelectorAll('.quick-amount-btn').forEach(function(b) {
                            b.classList.remove('active');
                        });
                        // Add active class to clicked button
                        this.classList.add('active');
                    });
                });
            </script>
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
        // Enforce minimum deposit
        document.getElementById('amount').addEventListener('input', function() {
            if (this.value && parseFloat(this.value) < 25) {
                this.value = 25;
            }
        });
    </script>
</body>

</html>