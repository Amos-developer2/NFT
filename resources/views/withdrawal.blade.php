<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw Funds</title>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/withdrawal.css">
</head>

<body>
    <div class="mobile-container">
        <!-- Page Header -->
        @include('partials.header', ['title' => 'Withdraw'])

        <!-- Withdrawal Card -->
        <div class="total-card">
            <div class="top">
                <div class="info">Withdraw Funds <img src="/icons/info.svg" alt="Info" class="icon-sm icon-white"></div>
            </div>
            <div class="main">Withdraw</div>
            <div class="sub">Minimum: <strong>12 USDT</strong> • Processing: 10-30 min</div>
        </div>

        <!-- Withdrawal Form -->
        <form class="withdraw-form" action="{{ route('user.withdrawal.process') }}" method="POST" id="withdrawalForm">
            @csrf

            <!-- Network Selection -->
            <div class="form-group">
                <label class="form-label">Network</label>
                <div class="network-select">
                    <label class="network-item">
                        <input type="radio" name="network" value="trc20" checked>
                        <div class="network-btn">
                            <span class="net-name">TRC20</span>
                            <span class="net-fee">Fee: 1 USDT</span>
                        </div>
                    </label>
                    <label class="network-item">
                        <input type="radio" name="network" value="bep20">
                        <div class="network-btn">
                            <span class="net-name">BEP20</span>
                            <span class="net-fee">Fee: 0.5 USDT</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Wallet Address -->
            <div class="form-group">
                <label for="wallet_address" class="form-label">Wallet Address</label>
                <div class="input-with-btn">
                    <input type="text" id="wallet_address" name="wallet_address" class="form-input" placeholder="Enter wallet address" required autocomplete="off">
                    <button type="button" class="input-btn" onclick="pasteFromClipboard()">Paste</button>
                </div>
            </div>

            <!-- Amount -->
            <div class="form-group">
                <div class="label-row">
                    <label for="amount" class="form-label">Amount (USDT)</label>
                    <button type="button" class="max-link" onclick="setMaxAmount()">MAX</button>
                </div>
                <input type="number" id="amount" name="amount" class="form-input" placeholder="Enter amount (min. 12)" min="12" step="0.01" required>
                <div class="input-footer">
                    <span class="hint-text">Min: 12 USDT</span>
                    <span class="receive-text" id="receiveAmount">Receive: $0.00</span>
                </div>
            </div>

            <!-- Withdrawal PIN - 4 digits -->
            <div class="form-group">
                <label class="form-label">Withdrawal PIN</label>
                <div class="pin-container">
                    <input type="password" class="pin-box" maxlength="1" data-index="0" inputmode="numeric" pattern="[0-9]*" required>
                    <input type="password" class="pin-box" maxlength="1" data-index="1" inputmode="numeric" pattern="[0-9]*" required>
                    <input type="password" class="pin-box" maxlength="1" data-index="2" inputmode="numeric" pattern="[0-9]*" required>
                    <input type="password" class="pin-box" maxlength="1" data-index="3" inputmode="numeric" pattern="[0-9]*" required>
                    <input type="hidden" name="withdrawal_pin" id="withdrawal_pin">
                </div>
            </div>

            <!-- Summary -->
            <div class="summary-box">
                <div class="sum-row">
                    <span>Amount</span>
                    <span id="summaryAmount">$0.00</span>
                </div>
                <div class="sum-row">
                    <span>Fee</span>
                    <span id="summaryFee">-$1.00</span>
                </div>
                <div class="sum-row total">
                    <span>You Receive</span>
                    <span id="summaryTotal">$0.00</span>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>
                Confirm Withdrawal
            </button>
        </form>

        <!-- Info Section -->
        <div class="deposit-info">
            <h3>How to Withdraw</h3>
            <ul>
                <li>Select network (TRC20 or BEP20)</li>
                <li>Enter your external wallet address</li>
                <li>Enter amount (minimum 12 USDT)</li>
                <li>Confirm with your 4-digit PIN</li>
                <li>Wait 10-30 minutes for processing</li>
            </ul>
        </div>

        <!-- Footer -->
        @include('partials.footer')
        <div class="pb-20"></div>
    </div>

    <script>
        const networkFees = {
            'trc20': 1,
            'bep20': 0.5
        };
        const availableBalance = 1092.87;
        const minWithdrawal = 12;

        function getSelectedNetworkFee() {
            const selected = document.querySelector('input[name="network"]:checked');
            return networkFees[selected.value] || 1;
        }

        function updateCalculations() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const fee = getSelectedNetworkFee();
            const receive = Math.max(0, amount - fee);

            document.getElementById('receiveAmount').textContent = `Receive: $${receive.toFixed(2)}`;
            document.getElementById('summaryAmount').textContent = `$${amount.toFixed(2)}`;
            document.getElementById('summaryFee').textContent = `-$${fee.toFixed(2)}`;
            document.getElementById('summaryTotal').textContent = `$${receive.toFixed(2)}`;
            validateForm();
        }

        function setMaxAmount() {
            document.getElementById('amount').value = availableBalance.toFixed(2);
            updateCalculations();
        }

        async function pasteFromClipboard() {
            try {
                const text = await navigator.clipboard.readText();
                document.getElementById('wallet_address').value = text.trim();
                validateForm();
            } catch (err) {
                console.log('Clipboard access denied');
            }
        }

        // PIN handling - 4 digits
        const pinInputs = document.querySelectorAll('.pin-box');
        pinInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value && index < pinInputs.length - 1) {
                    pinInputs[index + 1].focus();
                }
                updatePinValue();
                validateForm();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    pinInputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').slice(0, 4);
                pastedData.split('').forEach((char, i) => {
                    if (pinInputs[i] && /^\d$/.test(char)) {
                        pinInputs[i].value = char;
                    }
                });
                updatePinValue();
                validateForm();
            });
        });

        function updatePinValue() {
            document.getElementById('withdrawal_pin').value = Array.from(pinInputs).map(i => i.value).join('');
        }

        function validateForm() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const address = document.getElementById('wallet_address').value.trim();
            const pin = document.getElementById('withdrawal_pin').value;
            const isValid = amount >= minWithdrawal && amount <= availableBalance && address.length > 10 && pin.length === 4;
            document.getElementById('submitBtn').disabled = !isValid;
        }

        // Event listeners
        document.getElementById('amount').addEventListener('input', updateCalculations);
        document.getElementById('wallet_address').addEventListener('input', validateForm);
        document.querySelectorAll('input[name="network"]').forEach(r => r.addEventListener('change', updateCalculations));

        document.getElementById('withdrawalForm').addEventListener('submit', function(e) {
            if (parseFloat(document.getElementById('amount').value) < minWithdrawal) {
                e.preventDefault();
                alert('Minimum withdrawal is 12 USDT');
            }
        });

        updateCalculations();
    </script>
</body>

</html>