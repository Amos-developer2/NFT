@extends('layouts.app')

@section('title', 'My Team')

@section('content')
<div class="team-wrapper">
    <!-- Header Card -->
    <div class="team-header-card">
        <div class="header-bg"></div>
        <div class="header-content">
            <div class="header-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <h1 class="header-title">My Team</h1>
            <p class="header-subtitle">Invite friends and earn rewards</p>
        </div>
        
        <!-- Stats Display -->
        <div class="header-stats">
            <div class="stat-item">
                <span class="stat-label">Total Team</span>
                <span class="stat-value">{{ $totalTeam }}</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-label">Active</span>
                <span class="stat-value">{{ $totalActive }}</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-label">Commission</span>
                <span class="stat-value">${{ number_format($totalCommission, 0) }}</span>
            </div>
        </div>
    </div>

    <!-- Referral Code Card -->
    <div class="referral-card">
        <div class="referral-card-header">
            <div class="referral-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                </svg>
            </div>
            <span class="referral-title">Your Referral Code</span>
        </div>
        
        <div class="code-display">
            <span class="code-text">{{ Auth::user()->referral_code }}</span>
            <button type="button" class="copy-code-btn" onclick="copyCode()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="copy-icon">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                </svg>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="check-icon" style="display: none;">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </button>
        </div>

        <div class="link-section">
            <span class="link-label">Referral Link</span>
            <div class="link-input-wrapper">
                <input type="text" id="referralLink" value="{{ Auth::user()->referral_link }}" readonly>
                <button type="button" class="copy-link-btn" onclick="copyLink()">Copy</button>
            </div>
        </div>

        <div class="share-section">
            <span class="share-label">Share via</span>
            <div class="share-buttons">
                <button class="share-btn whatsapp" onclick="shareWhatsApp()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </button>
                <button class="share-btn telegram" onclick="shareTelegram()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                    </svg>
                </button>
                <button class="share-btn twitter" onclick="shareTwitter()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon team">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-value">{{ $totalTeam }}</span>
                <span class="stat-card-label">Total Team</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon active">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-value">{{ $totalActive }}</span>
                <span class="stat-card-label">Active</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon deposits">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-value">${{ number_format($totalDeposits, 0) }}</span>
                <span class="stat-card-label">Deposits</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon commission">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/>
                    <path d="M12 18V6"/>
                </svg>
            </div>
            <div class="stat-card-info">
                <span class="stat-card-value">${{ number_format($totalCommission, 2) }}</span>
                <span class="stat-card-label">Commission</span>
            </div>
        </div>
    </div>

    <!-- Commission Rates Card -->
    <div class="commission-card">
        <div class="commission-card-header">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
            <span>Commission Rates</span>
        </div>
        <div class="commission-grid">
            <div class="commission-item">
                <span class="commission-level">Level 1</span>
                <span class="commission-rate">16%</span>
            </div>
            <div class="commission-item">
                <span class="commission-level">Level 2</span>
                <span class="commission-rate">8%</span>
            </div>
            <div class="commission-item">
                <span class="commission-level">Level 3</span>
                <span class="commission-rate">4%</span>
            </div>
            <div class="commission-item">
                <span class="commission-level">Level 4</span>
                <span class="commission-rate">2%</span>
            </div>
            <div class="commission-item">
                <span class="commission-level">Level 5</span>
                <span class="commission-rate">1%</span>
            </div>
            <div class="commission-item">
                <span class="commission-level">Level 6</span>
                <span class="commission-rate">0.5%</span>
            </div>
        </div>
    </div>

    <!-- Team Members Section -->
    <div class="members-section">
        <div class="section-header">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
            </svg>
            <span>Team Members</span>
        </div>

        <!-- Level Tabs -->
        <div class="level-tabs">
            @for($i = 1; $i <= 6; $i++)
            <button class="level-tab {{ $i === 1 ? 'active' : '' }}" data-level="{{ $i }}">
                L{{ $i }}
                <span class="tab-count">{{ $levels[$i]['total'] }}</span>
            </button>
            @endfor
        </div>

        <!-- Level Panels -->
        @for($i = 1; $i <= 6; $i++)
        <div class="level-panel {{ $i === 1 ? 'active' : '' }}" id="level-{{ $i }}-panel">
            <!-- Level Stats -->
            <div class="level-stats">
                <div class="level-stat-item">
                    <span class="level-stat-value">{{ $levels[$i]['total'] }}</span>
                    <span class="level-stat-label">Members</span>
                </div>
                <div class="level-stat-item">
                    <span class="level-stat-value">{{ $levels[$i]['active'] }}</span>
                    <span class="level-stat-label">Active</span>
                </div>
                <div class="level-stat-item">
                    <span class="level-stat-value">${{ number_format($levels[$i]['deposits'], 0) }}</span>
                    <span class="level-stat-label">Deposits</span>
                </div>
                <div class="level-stat-item">
                    <span class="level-stat-value">${{ number_format($levels[$i]['commission'], 0) }}</span>
                    <span class="level-stat-label">Earned</span>
                </div>
            </div>

            <!-- Members List -->
            @forelse($levels[$i]['users'] as $user)
            <div class="member-card">
                <div class="member-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="member-info">
                    <span class="member-name">{{ $user->name }}</span>
                    <div class="member-meta">
                        <span class="member-date">{{ $user->created_at->format('M d, Y') }}</span>
                        @if($i > 1 && $user->referrer)
                        <span class="member-referrer">via {{ $user->referrer->name }}</span>
                        @endif
                    </div>
                </div>
                <div class="member-stats">
                    <span class="member-deposit">${{ number_format($user->total_deposits ?? 0, 0) }}</span>
                    <span class="member-status {{ $user->isActive() ? 'active' : 'inactive' }}">
                        {{ $user->isActive() ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h4>No Members Yet</h4>
                <p>{{ $i === 1 ? 'Share your referral code to start building your team!' : 'Members will appear here as your team grows.' }}</p>
            </div>
            @endforelse
        </div>
        @endfor
    </div>

    <!-- Info Card -->
    <div class="info-card">
        <div class="info-header">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 16v-4"/>
                <path d="M12 8h.01"/>
            </svg>
            <span>How It Works</span>
        </div>
        <ul class="info-list">
            <li>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>Share your referral code with friends</span>
            </li>
            <li>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>Earn commission on their deposits (up to 6 levels)</span>
            </li>
            <li>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>Commissions are credited instantly to your balance</span>
            </li>
        </ul>
    </div>
</div>

<style>
    .team-wrapper {
        padding: 0 16px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        max-width: 430px;
        margin: 0 auto;
    }

    .team-wrapper * {
        box-sizing: border-box;
    }

    /* Header Card */
    .team-header-card {
        position: relative;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 20px;
        padding: 28px 20px 20px;
    }

    .header-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #60a5fa 100%);
    }

    .header-bg::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    }

    .header-content {
        position: relative;
        text-align: center;
        color: #fff;
        margin-bottom: 20px;
    }

    .header-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        backdrop-filter: blur(10px);
    }

    .header-title {
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .header-subtitle {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }

    .header-stats {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 16px 20px;
    }

    .stat-item {
        text-align: center;
        flex: 1;
    }

    .stat-label {
        display: block;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        display: block;
        font-size: 18px;
        font-weight: 700;
        color: #fff;
    }

    .stat-divider {
        width: 1px;
        height: 36px;
        background: rgba(255, 255, 255, 0.3);
    }

    /* Referral Card */
    .referral-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .referral-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .referral-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .referral-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }

    .code-display {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 10px;
        margin-bottom: 16px;
    }

    .code-text {
        font-size: 24px;
        font-weight: 800;
        letter-spacing: 3px;
        color: #2A6CF6;
    }

    .copy-code-btn {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .copy-code-btn:active {
        transform: scale(0.95);
    }

    .link-section {
        margin-bottom: 16px;
    }

    .link-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
        margin-bottom: 8px;
    }

    .link-input-wrapper {
        display: flex;
        gap: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 4px;
    }

    .link-input-wrapper input {
        flex: 1;
        background: transparent;
        border: none;
        padding: 12px;
        font-size: 13px;
        color: #475569;
        outline: none;
        min-width: 0;
    }

    .copy-link-btn {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 20px;
        color: white;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .copy-link-btn:active {
        transform: scale(0.95);
    }

    .share-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .share-label {
        font-size: 13px;
        color: #64748b;
    }

    .share-buttons {
        display: flex;
        gap: 10px;
    }

    .share-btn {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .share-btn:active {
        transform: scale(0.95);
    }

    .share-btn.whatsapp {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: white;
    }

    .share-btn.telegram {
        background: linear-gradient(135deg, #229ED9 0%, #0088cc 100%);
        color: white;
    }

    .share-btn.twitter {
        background: linear-gradient(135deg, #1DA1F2 0%, #0d8bd9 100%);
        color: white;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-card-icon.team {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.05) 100%);
        color: #6366f1;
    }

    .stat-card-icon.active {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.05) 100%);
        color: #22c55e;
    }

    .stat-card-icon.deposits {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
        color: #3b82f6;
    }

    .stat-card-icon.commission {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, rgba(251, 191, 36, 0.05) 100%);
        color: #f59e0b;
    }

    .stat-card-info {
        display: flex;
        flex-direction: column;
    }

    .stat-card-value {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
    }

    .stat-card-label {
        font-size: 12px;
        color: #64748b;
    }

    /* Commission Card */
    .commission-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .commission-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }

    .commission-card-header svg {
        color: #f59e0b;
    }

    .commission-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .commission-item {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 12px;
        padding: 14px 10px;
        text-align: center;
    }

    .commission-level {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .commission-rate {
        display: block;
        font-size: 18px;
        font-weight: 700;
        color: #2A6CF6;
    }

    /* Members Section */
    .members-section {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }

    .section-header svg {
        color: #2A6CF6;
    }

    /* Level Tabs */
    .level-tabs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .level-tabs::-webkit-scrollbar {
        display: none;
    }

    .level-tab {
        flex: 0 0 auto;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 500;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .level-tab:hover {
        background: #f1f5f9;
    }

    .level-tab.active {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border-color: transparent;
        color: white;
    }

    .tab-count {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 12px;
    }

    .level-tab.active .tab-count {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Level Panel */
    .level-panel {
        display: none;
    }

    .level-panel.active {
        display: block;
    }

    /* Level Stats */
    .level-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 16px;
    }

    .level-stat-item {
        background: #f8fafc;
        border-radius: 10px;
        padding: 12px 8px;
        text-align: center;
    }

    .level-stat-value {
        display: block;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }

    .level-stat-label {
        display: block;
        font-size: 10px;
        color: #64748b;
        text-transform: uppercase;
    }

    /* Member Card */
    .member-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        background: #f8fafc;
        border-radius: 14px;
        margin-bottom: 10px;
    }

    .member-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .member-info {
        flex: 1;
        min-width: 0;
    }

    .member-name {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .member-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .member-date {
        font-size: 12px;
        color: #64748b;
    }

    .member-referrer {
        font-size: 11px;
        color: #6366f1;
        background: rgba(99, 102, 241, 0.1);
        padding: 2px 8px;
        border-radius: 6px;
    }

    .member-stats {
        text-align: right;
        flex-shrink: 0;
    }

    .member-deposit {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #3b82f6;
        margin-bottom: 4px;
    }

    .member-status {
        font-size: 11px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .member-status.active {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .member-status.inactive {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-icon {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.1) 0%, rgba(59, 140, 255, 0.05) 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: #2A6CF6;
    }

    .empty-state h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
        line-height: 1.5;
    }

    /* Info Card */
    .info-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }

    .info-header svg {
        color: #2A6CF6;
    }

    .info-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .info-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-list li:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-list li svg {
        flex-shrink: 0;
        margin-top: 2px;
        color: #22c55e;
    }

    .info-list li span {
        font-size: 14px;
        color: #475569;
        line-height: 1.4;
    }
</style>

@include('partials.footer')

<script>
    // Level tab switching
    document.querySelectorAll('.level-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const level = this.dataset.level;

            document.querySelectorAll('.level-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            document.querySelectorAll('.level-panel').forEach(panel => panel.classList.remove('active'));
            document.getElementById('level-' + level + '-panel').classList.add('active');
        });
    });

    // Copy code
    function copyCode() {
        const code = '{{ Auth::user()->referral_code }}';
        navigator.clipboard.writeText(code);
        
        const copyIcon = document.querySelector('.copy-icon');
        const checkIcon = document.querySelector('.check-icon');
        copyIcon.style.display = 'none';
        checkIcon.style.display = 'block';
        
        setTimeout(() => {
            copyIcon.style.display = 'block';
            checkIcon.style.display = 'none';
        }, 2000);
    }

    // Copy link
    function copyLink() {
        const input = document.getElementById('referralLink');
        navigator.clipboard.writeText(input.value);
        
        const btn = document.querySelector('.copy-link-btn');
        btn.textContent = 'Copied!';
        setTimeout(() => btn.textContent = 'Copy', 2000);
    }

    // Share functions
    function shareWhatsApp() {
        const text = "Join VortexNFT - The best NFT trading platform! Use my referral code: {{ Auth::user()->referral_code }}\n" + document.getElementById('referralLink').value;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    }

    function shareTelegram() {
        const text = "Join VortexNFT - The best NFT trading platform! Use my referral code: {{ Auth::user()->referral_code }}";
        const url = document.getElementById('referralLink').value;
        window.open('https://t.me/share/url?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text), '_blank');
    }

    function shareTwitter() {
        const text = "Join VortexNFT - The best NFT trading platform! Use my referral code: {{ Auth::user()->referral_code }}";
        const url = document.getElementById('referralLink').value;
        window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text) + '&url=' + encodeURIComponent(url), '_blank');
    }
</script>
@endsection
