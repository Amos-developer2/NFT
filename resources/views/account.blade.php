@extends('layouts.app', ['hideHeader' => true])

@section('title', 'Account Settings')

@push('styles')
<link rel="stylesheet" href="/css/account.css">
<style>
    .account-profile {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 40px 15px 15px;
    }

    .account-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        color: white;
        position: relative;
        flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(42, 108, 246, 0.25);
    }

    .verified-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 22px;
        height: 22px;
        background: #22c55e;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: 2px solid #f8fafc;
        box-shadow: 0 2px 6px rgba(34, 197, 94, 0.3);
    }

    .account-info {
        flex: 1;
        min-width: 0;
    }

    .account-name {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .account-email {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .account-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #64748b;
    }

    .meta-item svg {
        color: #94a3b8;
    }

    .meta-divider {
        color: #cbd5e1;
        font-size: 10px;
    }

    .meta-item.status-verified {
        color: #22c55e;
    }

    .meta-item.status-verified svg {
        color: #22c55e;
    }

    .meta-item.status-pending {
        color: #f59e0b;
    }

    .meta-item.status-pending svg {
        color: #f59e0b;
    }

    .colored-toast {
        background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%) !important;
        color: #fff !important;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.18);
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
@include('partials.header', ['title' => 'Account'])

<!-- Account Profile Section -->
<div class="account-profile">
    <div class="account-avatar">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        @if(Auth::user()->hasVerifiedEmail())
        <span class="verified-badge">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <polyline points="20 6 9 17 4 12" />
            </svg>
        </span>
        @endif
    </div>

    <div class="account-info">
        <h2 class="account-name">{{ Auth::user()->name }}</h2>
        <p class="account-email">{{ Auth::user()->email }}</p>
        <div class="account-meta">
            <span class="meta-item">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                {{ Auth::user()->account_id }}
            </span>
            <span class="meta-divider">•</span>
            <span class="meta-item status-{{ Auth::user()->hasVerifiedEmail() ? 'verified' : 'pending' }}">
                @if(Auth::user()->hasVerifiedEmail())
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Verified
                @else
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4M12 16h.01" />
                </svg>
                Unverified
                @endif
            </span>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        nativeAlert(@json(session('success')), {
            type: 'success',
            title: 'Success'
        });
    });
</script>
@endif
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        nativeAlert(@json(implode("\n", $errors->all())), {
            type: 'error',
            title: 'Error'
        });
    });
</script>
@endif

<!-- Settings Sections -->
<div class="settings-container">
    <!-- Account Settings -->
    <div id="account-settings" class="settings-section">
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
            <a href="{{ route('account.withdrawal-address.edit') }}" class="action-item">
                <div class="action-icon wallet">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                        <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                        <path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z" />
                    </svg>
                </div>
                <div class="action-text">
                    <span class="action-title">Withdrawal Address
                        @if(Auth::user()->withdrawal_address)
                        <span class="badge" style="background:#22c55e;color:#fff;font-size:0.8em;padding:2px 8px;border-radius:8px;margin-left:8px;">Bound</span>
                        @else
                        <span class="badge" style="background:#f59e0b;color:#fff;font-size:0.8em;padding:2px 8px;border-radius:8px;margin-left:8px;">Not Set</span>
                        @endif
                    </span>
                    <span class="action-desc">Bind your withdrawal wallet</span>
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
            <a href="{{ route('account.language') }}" class="action-item">
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

<div class="pb-20"></div>
@endsection