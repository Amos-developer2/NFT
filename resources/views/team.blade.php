@extends('layouts.app')

@section('title', 'My Team')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: linear-gradient(180deg, #0a1628 0%, #1a1a2e 50%, #0f0f1a 100%);
        min-height: 100vh;
        color: #ffffff;
        padding-bottom: 100px;
    }

    .team-container {
        max-width: 430px;
        margin: 0 auto;
        padding: 0 16px;
    }

    /* Header Section */
    .team-header {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 50%, #6366f1 100%);
        border-radius: 0 0 32px 32px;
        padding: 20px 20px 28px;
        margin: 0 -16px 24px;
        position: relative;
        overflow: hidden;
    }

    .team-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .team-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -20%;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .header-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .back-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    .back-btn svg {
        color: white;
    }

    .header-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
    }

    .header-action {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .header-action:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Referral Code Card */
    .referral-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 20px;
        position: relative;
        z-index: 1;
    }

    .referral-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .referral-icon svg {
        width: 28px;
        height: 28px;
        color: white;
    }

    .referral-title {
        text-align: center;
        font-size: 16px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 8px;
    }

    .referral-code {
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        color: white;
        letter-spacing: 3px;
        margin-bottom: 16px;
    }

    .referral-link-box {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .referral-link-box input {
        flex: 1;
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.9);
        font-size: 13px;
        outline: none;
    }

    .copy-btn {
        background: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #2A6CF6;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .copy-btn:hover {
        transform: scale(1.05);
    }

    .copy-btn:active {
        transform: scale(0.95);
    }

    /* Share Buttons */
    .share-buttons {
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .share-btn {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .share-btn:hover {
        transform: translateY(-3px);
    }

    .share-btn:active {
        transform: scale(0.95);
    }

    .share-btn.whatsapp {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    }

    .share-btn.telegram {
        background: linear-gradient(135deg, #0088cc 0%, #229ED9 100%);
    }

    .share-btn.twitter {
        background: linear-gradient(135deg, #1DA1F2 0%, #0d8bd9 100%);
    }

    .share-btn svg {
        width: 24px;
        height: 24px;
        color: white;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 20px 16px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: rgba(42, 108, 246, 0.3);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }

    .stat-icon.team {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0.1) 100%);
        color: #818cf8;
    }

    .stat-icon.active {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2) 0%, rgba(34, 197, 94, 0.1) 100%);
        color: #22c55e;
    }

    .stat-icon.deposits {
        background: linear-gradient(135deg, rgba(59, 140, 255, 0.2) 0%, rgba(59, 140, 255, 0.1) 100%);
        color: #3B8CFF;
    }

    .stat-icon.commission {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.2) 0%, rgba(251, 191, 36, 0.1) 100%);
        color: #fbbf24;
    }

    .stat-icon svg {
        width: 24px;
        height: 24px;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 700;
        color: white;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Commission Rates Card */
    .commission-card {
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.15) 0%, rgba(99, 102, 241, 0.1) 100%);
        border: 1px solid rgba(42, 108, 246, 0.2);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .commission-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .commission-header-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .commission-header-icon svg {
        width: 20px;
        height: 20px;
        color: white;
    }

    .commission-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: white;
    }

    .commission-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .commission-item {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 12px 8px;
        text-align: center;
    }

    .commission-level {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .commission-rate {
        font-size: 18px;
        font-weight: 700;
        background: linear-gradient(135deg, #3B8CFF 0%, #818cf8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Section Title */
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: linear-gradient(180deg, #2A6CF6 0%, #3B8CFF 100%);
        border-radius: 2px;
    }

    /* Level Tabs */
    .level-tabs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 8px;
        margin-bottom: 20px;
        -webkit-overflow-scrolling: touch;
    }

    .level-tabs::-webkit-scrollbar {
        display: none;
    }

    .level-tab {
        flex: 0 0 auto;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.6);
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .level-tab:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .level-tab.active {
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 15px rgba(42, 108, 246, 0.4);
    }

    .level-tab-count {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 12px;
        margin-left: 6px;
    }

    .level-tab.active .level-tab-count {
        background: rgba(255, 255, 255, 0.25);
    }

    /* Level Panel */
    .level-panel {
        display: none;
    }

    .level-panel.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Level Stats */
    .level-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    .level-stat-item {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .level-stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .level-stat-icon.members {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0.1) 100%);
        color: #818cf8;
    }

    .level-stat-icon.active-members {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2) 0%, rgba(34, 197, 94, 0.1) 100%);
        color: #22c55e;
    }

    .level-stat-icon.level-deposits {
        background: linear-gradient(135deg, rgba(59, 140, 255, 0.2) 0%, rgba(59, 140, 255, 0.1) 100%);
        color: #3B8CFF;
    }

    .level-stat-icon.level-commission {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.2) 0%, rgba(251, 191, 36, 0.1) 100%);
        color: #fbbf24;
    }

    .level-stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .level-stat-info {
        display: flex;
        flex-direction: column;
    }

    .level-stat-value {
        font-size: 18px;
        font-weight: 700;
        color: white;
    }

    .level-stat-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
    }

    /* Members List */
    .members-list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .members-list-title {
        font-size: 14px;
        font-weight: 600;
        color: white;
    }

    .members-list-count {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        background: rgba(255, 255, 255, 0.08);
        padding: 4px 10px;
        border-radius: 8px;
    }

    /* Member Card */
    .member-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.3s ease;
    }

    .member-card:hover {
        border-color: rgba(42, 108, 246, 0.3);
        transform: translateX(4px);
    }

    .member-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2A6CF6 0%, #6366f1 100%);
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
        font-size: 15px;
        font-weight: 600;
        color: white;
        display: block;
        margin-bottom: 4px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .member-meta-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .member-date {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
    }

    .member-referrer {
        font-size: 11px;
        color: rgba(99, 102, 241, 0.8);
        background: rgba(99, 102, 241, 0.15);
        padding: 2px 8px;
        border-radius: 6px;
    }

    .member-stats {
        text-align: right;
        flex-shrink: 0;
    }

    .member-deposit {
        font-size: 15px;
        font-weight: 600;
        color: #3B8CFF;
        display: block;
        margin-bottom: 4px;
    }

    .member-status {
        font-size: 11px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .member-status.active {
        background: rgba(34, 197, 94, 0.15);
        color: #22c55e;
    }

    .member-status.inactive {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }

    /* Empty State */
    .empty-state {
        background: linear-gradient(135deg, rgba(255,255,255,0.04) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px dashed rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        padding: 40px 24px;
        text-align: center;
    }

    .empty-state-icon {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, rgba(42, 108, 246, 0.15) 0%, rgba(99, 102, 241, 0.1) 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .empty-state-icon svg {
        width: 36px;
        height: 36px;
        color: #3B8CFF;
    }

    .empty-state h4 {
        font-size: 16px;
        font-weight: 600;
        color: white;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.5;
    }

    /* Floating Invite Button */
    .floating-invite-btn {
        position: fixed;
        bottom: 90px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
        border: none;
        border-radius: 16px;
        padding: 16px 32px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 600;
        color: white;
        cursor: pointer;
        box-shadow: 0 8px 30px rgba(42, 108, 246, 0.5);
        transition: all 0.3s ease;
        z-index: 100;
    }

    .floating-invite-btn:hover {
        transform: translateX(-50%) translateY(-3px);
        box-shadow: 0 12px 40px rgba(42, 108, 246, 0.6);
    }

    .floating-invite-btn:active {
        transform: translateX(-50%) scale(0.95);
    }

    .floating-invite-btn svg {
        width: 20px;
        height: 20px;
    }

    .pb-safe {
        padding-bottom: 160px;
    }
</style>

<div class="team-container">
    <!-- Header Section -->
    <div class="team-header">
        <div class="header-nav">
            <a href="{{ route('dashboard') }}" class="back-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <span class="header-title">My Team</span>
            <button class="header-action" onclick="location.reload()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M23 4v6h-6M1 20v-6h6"/>
                    <path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
                </svg>
            </button>
        </div>

        <!-- Referral Card -->
        <div class="referral-card">
            <div class="referral-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="referral-title">Your Referral Code</div>
            <div class="referral-code">{{ Auth::user()->referral_code }}</div>
            
            <div class="referral-link-box">
                <input type="text" id="referralLink" value="{{ Auth::user()->referral_link }}" readonly>
                <button class="copy-btn" onclick="copyReferralLink()">
                    <span>Copy</span>
                </button>
            </div>

            <div class="share-buttons">
                <button class="share-btn whatsapp" onclick="shareWhatsApp()" title="Share on WhatsApp">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </button>
                <button class="share-btn telegram" onclick="shareTelegram()" title="Share on Telegram">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                    </svg>
                </button>
                <button class="share-btn twitter" onclick="shareTwitter()" title="Share on Twitter">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon team">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-value">{{ $totalTeam }}</div>
            <div class="stat-label">Total Team</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-value">{{ $totalActive }}</div>
            <div class="stat-label">Active</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon deposits">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <div class="stat-value">${{ number_format($totalDeposits, 0) }}</div>
            <div class="stat-label">Deposits</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon commission">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/>
                    <path d="M12 18V6"/>
                </svg>
            </div>
            <div class="stat-value">${{ number_format($totalCommission, 2) }}</div>
            <div class="stat-label">Commission</div>
        </div>
    </div>

    <!-- Commission Rates Card -->
    <div class="commission-card">
        <div class="commission-header">
            <div class="commission-header-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <h3>Commission Rates</h3>
        </div>
        <div class="commission-grid">
            <div class="commission-item">
                <div class="commission-level">Level 1</div>
                <div class="commission-rate">16%</div>
            </div>
            <div class="commission-item">
                <div class="commission-level">Level 2</div>
                <div class="commission-rate">8%</div>
            </div>
            <div class="commission-item">
                <div class="commission-level">Level 3</div>
                <div class="commission-rate">4%</div>
            </div>
            <div class="commission-item">
                <div class="commission-level">Level 4</div>
                <div class="commission-rate">2%</div>
            </div>
            <div class="commission-item">
                <div class="commission-level">Level 5</div>
                <div class="commission-rate">1%</div>
            </div>
            <div class="commission-item">
                <div class="commission-level">Level 6</div>
                <div class="commission-rate">0.5%</div>
            </div>
        </div>
    </div>

    <!-- Team Members Section -->
    <div class="section-title">Team Members</div>

    <!-- Level Tabs -->
    <div class="level-tabs">
        @for($i = 1; $i <= 6; $i++)
        <div class="level-tab {{ $i === 1 ? 'active' : '' }}" data-level="{{ $i }}">
            L{{ $i }}
            <span class="level-tab-count">{{ $levels[$i]['total'] }}</span>
        </div>
        @endfor
    </div>

    <!-- Level Panels -->
    @for($i = 1; $i <= 6; $i++)
    <div class="level-panel {{ $i === 1 ? 'active' : '' }}" id="level-{{ $i }}-panel">
        <!-- Level Stats -->
        <div class="level-stats">
            <div class="level-stat-item">
                <div class="level-stat-icon members">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="level-stat-info">
                    <span class="level-stat-value">{{ $levels[$i]['total'] }}</span>
                    <span class="level-stat-label">Members</span>
                </div>
            </div>
            <div class="level-stat-item">
                <div class="level-stat-icon active-members">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="level-stat-info">
                    <span class="level-stat-value">{{ $levels[$i]['active'] }}</span>
                    <span class="level-stat-label">Active</span>
                </div>
            </div>
            <div class="level-stat-item">
                <div class="level-stat-icon level-deposits">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <div class="level-stat-info">
                    <span class="level-stat-value">${{ number_format($levels[$i]['deposits'], 0) }}</span>
                    <span class="level-stat-label">Deposits</span>
                </div>
            </div>
            <div class="level-stat-item">
                <div class="level-stat-icon level-commission">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/>
                        <path d="M12 18V6"/>
                    </svg>
                </div>
                <div class="level-stat-info">
                    <span class="level-stat-value">${{ number_format($levels[$i]['commission'], 2) }}</span>
                    <span class="level-stat-label">Commission</span>
                </div>
            </div>
        </div>

        <!-- Members List -->
        <div class="members-list-header">
            <span class="members-list-title">Level {{ $i }} Members</span>
            <span class="members-list-count">{{ $levels[$i]['total'] }} members</span>
        </div>

        @forelse($levels[$i]['users'] as $user)
        <div class="member-card">
            <div class="member-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="member-info">
                <span class="member-name">{{ $user->name }}</span>
                <div class="member-meta-row">
                    <span class="member-date">{{ $user->created_at->format('M d, Y') }}</span>
                    @if($i > 1 && $user->referrer)
                    <span class="member-referrer">Via: {{ $user->referrer->name }}</span>
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
            <div class="empty-state-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <h4>No Level {{ $i }} Members Yet</h4>
            <p>{{ $i === 1 ? 'Share your referral code to start building your team!' : 'Members will appear here as your team grows.' }}</p>
        </div>
        @endforelse
    </div>
    @endfor

    <div class="pb-safe"></div>
</div>

<!-- Floating Invite Button -->
<button class="floating-invite-btn" onclick="scrollToTop()">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <line x1="19" y1="8" x2="19" y2="14"/>
        <line x1="22" y1="11" x2="16" y2="11"/>
    </svg>
    Invite Friends
</button>

@include('partials.footer')

<script>
    // Level tab switching
    document.querySelectorAll('.level-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const level = this.dataset.level;

            // Update active tab
            document.querySelectorAll('.level-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Show corresponding panel
            document.querySelectorAll('.level-panel').forEach(panel => panel.classList.remove('active'));
            document.getElementById('level-' + level + '-panel').classList.add('active');
        });
    });

    // Copy referral link
    function copyReferralLink() {
        const input = document.getElementById('referralLink');
        input.select();
        input.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(input.value);

        const btn = document.querySelector('.copy-btn span');
        if (btn) {
            const originalText = btn.textContent;
            btn.textContent = 'Copied!';
            setTimeout(() => {
                btn.textContent = originalText;
            }, 2000);
        }
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

    // Scroll to top for invite
    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        // Focus on referral link after scroll
        setTimeout(() => {
            document.getElementById('referralLink').select();
        }, 500);
    }
</script>
@endsection
