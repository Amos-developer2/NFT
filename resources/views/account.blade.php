<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/account.css">
</head>

<body>
    <div class="mobile-container">
        <!-- Page Header -->
        @include('partials.header', ['title' => 'Account'])

        <!-- Account Card -->
        <div class="total-card account-main-card">
            <div class="account-card-content">
                <div class="account-card-avatar">
                    <img src="/icons/user.svg" alt="Profile">
                </div>
                <div class="account-card-info">
                    <div class="account-card-name">{{ Auth::user()->name }}</div>
                    <div class="account-card-email">{{ Auth::user()->email }}</div>
                    <div class="account-card-status">
                        @if(Auth::user()->hasVerifiedEmail())
                        <span class="verified-badge" style="text-align: left; display: inline-flex; align-items: flex-start; gap: 6px; justify-content: flex-start;">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:inline-block;vertical-align:middle;">
                                <circle cx="9" cy="9" r="7" fill="#22c55e" stroke="#fff" stroke-width="1.2" />
                                <path d="M5.2 9.5L8 12.3L12.8 7.5" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span style="font-weight: bold;">Verified</span>
                        </span>
                        @else
                        <span class="unverified-badge">Unverified</span>
                        @endif
                    </div>
                </div>
                <div class="account-card-id">ID: {{ Auth::user()->account_id }}</div>
            </div>
        </div>

        <!-- SweetAlert2 Toast for Success/Error Messages -->
        @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'center',
                    icon: 'success',
                    title: @json(session('success')),
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            });
        </script>
        @endif
        @if($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'center',
                    icon: 'error',
                    title: @json(implode("\n", $errors -> all())),
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
            });
        </script>
        @endif
        <style>
            .colored-toast {
                background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%) !important;
                color: #fff !important;
                font-weight: 700;
                font-size: 1rem;
                border-radius: 12px;
                box-shadow: 0 4px 16px rgba(37, 99, 235, 0.18);
            }
        </style>

        <!-- Settings Sections -->
        <div class="settings-container">
            <!-- Account Settings -->
            <div class="settings-section">
                <div class="settings-title">
                    <img src="/icons/settings.svg" alt="Settings">
                    <span>Account Settings</span>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('account.password.edit') }}" class="action-item">
                        <div class="action-icon security">
                            <img src="/icons/settings.svg" alt="Password">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Change Password</span>
                            <span class="action-desc">Update your password</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                    <a href="{{ route('account.pin.edit') }}" class="action-item">
                        <div class="action-icon pin">
                            <img src="/icons/settings.svg" alt="PIN">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Withdrawal PIN</span>
                            <span class="action-desc">Set or change your PIN</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                    <a href="{{ route('account.2fa') }}" class="action-item">
                        <div class="action-icon twofa">
                            <img src="/icons/settings.svg" alt="2FA">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Two-Factor Authentication
                                @if(Auth::user()->two_factor_enabled)
                                <span class="badge" style="background:#22c55e;color:#fff;font-size:0.8em;padding:2px 8px;border-radius:8px;margin-left:8px;">Enabled</span>
                                @else
                                <span class="badge" style="background:#ef4444;color:#fff;font-size:0.8em;padding:2px 8px;border-radius:8px;margin-left:8px;">Disabled</span>
                                @endif
                            </span>
                            <span class="action-desc">Add extra security to your account</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="settings-section">
                <div class="settings-title">
                    <img src="/icons/star.svg" alt="Actions" class="icon-yellow">
                    <span>Quick Actions</span>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('user.deposit') }}" class="action-item">
                        <div class="action-icon deposit">
                            <img src="/icons/plus.svg" alt="Deposit">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Deposit Funds</span>
                            <span class="action-desc">Add money to your wallet</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                    <a href="{{ route('user.withdrawal') }}" class="action-item">
                        <div class="action-icon withdraw">
                            <img src="/icons/minus.svg" alt="Withdraw">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Withdraw Funds</span>
                            <span class="action-desc">Transfer to external wallet</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                </div>
            </div>

            <!-- Referral Section -->
            <div class="settings-section">
                <div class="settings-title">
                    <img src="/icons/users.svg" alt="Referral" class="icon-green">
                    <span>Invite Friends</span>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('team') }}" class="action-item">
                        <div class="action-icon referral">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <span class="action-title">My Team</span>
                            <span class="action-desc">View referrals & invite friends</span>
                        </div>
                        <div class="referral-badge">{{ Auth::user()->referral_count }}</div>
                    </a>
                </div>
            </div>

            <!-- History Section -->
            <div class="settings-section">
                <div class="settings-title">
                    <img src="/icons/coin.svg" alt="History">
                    <span>Transaction History</span>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('user.deposit.history') }}" class="action-item">
                        <div class="action-icon deposit">
                            <img src="/icons/plus.svg" alt="Deposit History">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Deposit History</span>
                            <span class="action-desc">View all deposit transactions</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                    <a href="{{ route('user.withdrawal.history') }}" class="action-item">
                        <div class="action-icon withdraw">
                            <img src="/icons/minus.svg" alt="Withdrawal History">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Withdrawal History</span>
                            <span class="action-desc">View all withdrawal transactions</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                </div>
            </div>

            <!-- Preferences Section -->
            <div class="settings-section">
                <div class="settings-title">
                    <img src="/icons/settings.svg" alt="Preferences">
                    <span>Preferences</span>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('about') }}" class="action-item">
                        <div class="action-icon language">
                            <img src="/icons/coin.svg" alt="Language">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Language</span>
                            <span class="action-desc">English</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                    <a href="#" class="action-item">
                        <div class="action-icon mode">
                            <img src="/icons/star.svg" alt="Mode">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Account Mode</span>
                            <span class="action-desc">Light Mode</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                    <a href="#" class="action-item">
                        <div class="action-icon support">
                            <img src="/icons/info.svg" alt="Support">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Support</span>
                            <span class="action-desc">Get help from our team</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                </div>
            </div>

            <!-- More Section -->
            <div class="settings-section">
                <div class="settings-title">
                    <img src="/icons/star.svg" alt="More">
                    <span>More</span>
                </div>
                <div class="quick-actions">
                    <a href="#" class="action-item">
                        <div class="action-icon download">
                            <img src="/icons/plus.svg" alt="Download">
                        </div>
                        <div class="action-text">
                            <span class="action-title">Download App</span>
                            <span class="action-desc">Get our mobile app</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                    <a href="{{ route('about') }}" class="action-item">
                        <div class="action-icon about">
                            <img src="/icons/user.svg" alt="About">
                        </div>
                        <div class="action-text">
                            <span class="action-title">About Us</span>
                            <span class="action-desc">Learn more about VortexNFT</span>
                        </div>
                        <img src="/icons/arrow-left.svg" alt="Go" class="action-arrow">
                    </a>
                </div>
            </div>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="logout-section">
                @csrf
                <button type="submit" class="btn-logout">
                    <img src="/icons/minus.svg" alt="Logout">
                    <span>Logout</span>
                </button>
            </form>
        </div>

        <!-- Footer -->
        @include('partials.footer')
        <div class="pb-20"></div>
    </div>
</body>

</html>