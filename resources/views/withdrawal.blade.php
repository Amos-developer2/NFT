<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw Funds</title>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/withdrawal.css">
    <style>
        .bound-address-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid #bbf7d0;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 20px;
        }
        .bound-address-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .bound-icon {
            width: 36px;
            height: 36px;
            background: #22c55e;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .bound-label {
            font-size: 14px;
            font-weight: 600;
            color: #166534;
        }
        .bound-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(34, 197, 94, 0.2);
        }
        .bound-info-row:last-child {
            border-bottom: none;
        }
        .bound-info-label {
            font-size: 12px;
            color: #64748b;
        }
        .bound-info-value {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .bound-info-value img {
            width: 18px;
            height: 18px;
        }
        .address-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
        .address-display {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
        .address-text {
            flex: 1;
            font-size: 11px;
            font-family: 'SF Mono', Monaco, monospace;
            color: #1e293b;
            word-break: break-all;
        }
        .copy-btn {
            padding: 6px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            color: #64748b;
            cursor: pointer;
        }
        .no-address-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #fcd34d;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .no-address-icon {
            width: 48px;
            height: 48px;
            background: rgba(245, 158, 11, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            color: #d97706;
        }
        .no-address-title {
            font-size: 16px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 6px;
        }
        .no-address-text {
            font-size: 13px;
            color: #a16207;
            margin-bottom: 16px;
        }
        .bind-address-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
        }
    </style>
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

        @if(Auth::user()->withdrawal_address)
        <!-- Bound Address Card -->
        <div class="bound-address-card">
            <div class="bound-address-header">
                <div class="bound-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <span class="bound-label">Withdrawal Address Bound</span>
            </div>
            <div class="bound-info-row">
                <span class="bound-info-label">Currency</span>
                <span class="bound-info-value">
                    <img src="/icons/{{ strtolower(Auth::user()->withdrawal_currency) }}.svg" alt="{{ Auth::user()->withdrawal_currency }}">
                    {{ Auth::user()->withdrawal_currency }}
                </span>
            </div>
            <div class="bound-info-row">
                <span class="bound-info-label">Network</span>
                <span class="bound-info-value">{{ Auth::user()->withdrawal_network }}</span>
            </div>
            <div class="bound-info-row address-row">
                <span class="bound-info-label">Wallet Address</span>
                <div class="address-display">
                    <span class="address-text" id="boundAddress">{{ Auth::user()->withdrawal_address }}</span>
                    <button type="button" class="copy-btn" onclick="copyAddress()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Withdrawal Form -->
        <form class="withdraw-form" action="{{ route('user.withdrawal.process') }}" method="POST" id="withdrawalForm">
            @csrf
            
            <!-- Hidden fields for bound address -->
            <input type="hidden" name="network" value="{{ strtolower(Auth::user()->withdrawal_network) }}">
            <input type="hidden" name="wallet_address" value="{{ Auth::user()->withdrawal_address }}">

            <!-- Amount -->
            <div class="form-group">
                <div class="label-row">
                    <label for="amount" class="form-label">Amount ({{ Auth::user()->withdrawal_currency }})</label>
                    <button type="button" class="max-link" onclick="setMaxAmount()">MAX</button>
                </div>
                <input type="number" id="amount" name="amount" class="form-input" placeholder="Enter amount (min. 12)" min="12" step="0.01" required>
                <div class="input-footer">
                    <span class="hint-text">Min: 12 {{ Auth::user()->withdrawal_currency }}</span>
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
                    <span>Fee ({{ Auth::user()->withdrawal_network }})</span>
                    <span id="summaryFee">-${{ Auth::user()->withdrawal_network === 'TRC20' ? '1.00' : '0.50' }}</span>
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
        @else
        <!-- No Address Bound -->
        <div class="no-address-card">
            <div class="no-address-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div class="no-address-title">No Withdrawal Address</div>
            <p class="no-address-text">You need to bind a withdrawal address before you can withdraw funds.</p>
            <a href="{{ route('account.withdrawal-address.edit') }}" class="bind-address-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                </svg>
                Bind Withdrawal Address
            </a>
        </div>
        @endif

        <!-- Info Section -->
        <div class="deposit-info">
            <h3>How to Withdraw</h3>
            <ul>
                @if(Auth::user()->withdrawal_address)
                <li>Your bound address: {{ Auth::user()->withdrawal_network }}</li>
                <li>Enter the amount you want to withdraw</li>
                <li>Confirm with your 4-digit PIN</li>
                <li>Wait 10-30 minutes for processing</li>
                @else
                <li>First, bind your withdrawal address</li>
                <li>Address can only be bound once</li>
                <li>Then enter amount and confirm with PIN</li>
                <li>Processing takes 10-30 minutes</li>
                @endif
            </ul>
        </div>

        <!-- Footer -->
        @include('partials.footer')
        <div class="pb-20"></div>
    </div>

    <script>
        @if(Auth::user()->withdrawal_address)
        const networkFee = {{ Auth::user()->withdrawal_network === 'TRC20' ? 1 : 0.5 }};
        const availableBalance = 1092.87;
        const minWithdrawal = 12;

        function updateCalculations() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const receive = Math.max(0, amount - networkFee);

            document.getElementById('receiveAmount').textContent = `Receive: $${receive.toFixed(2)}`;
            document.getElementById('summaryAmount').textContent = `$${amount.toFixed(2)}`;
            document.getElementById('summaryFee').textContent = `-$${networkFee.toFixed(2)}`;
            document.getElementById('summaryTotal').textContent = `$${receive.toFixed(2)}`;
            validateForm();
        }

        function setMaxAmount() {
            document.getElementById('amount').value = availableBalance.toFixed(2);
            updateCalculations();
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
            const pin = document.getElementById('withdrawal_pin').value;
            const isValid = amount >= minWithdrawal && amount <= availableBalance && pin.length === 4;
            document.getElementById('submitBtn').disabled = !isValid;
        }

        // Event listeners
        document.getElementById('amount').addEventListener('input', updateCalculations);

        document.getElementById('withdrawalForm').addEventListener('submit', function(e) {
            if (parseFloat(document.getElementById('amount').value) < minWithdrawal) {
                e.preventDefault();
                if (typeof nativeAlert === 'function') {
                    nativeAlert('Minimum withdrawal is 12 USDT', { type: 'warning', title: 'Invalid Amount' });
                }
            }
        });

        updateCalculations();
        @endif

        function copyAddress() {
            const address = document.getElementById('boundAddress').textContent.trim();
            navigator.clipboard.writeText(address).then(() => {
                if (typeof nativeAlert === 'function') {
                    nativeAlert('Address copied to clipboard!', { type: 'success', title: 'Copied' });
                }
            });
        }
    </script>
    
    @include('partials.native-alert')
</body>

</html>