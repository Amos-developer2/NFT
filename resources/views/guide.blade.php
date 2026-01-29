@extends('layouts.app')

@section('title', 'Platform Guide & FAQ')

@push('styles')
<style>
    :root {
        --bg: #f8fafc;
        --card: #ffffff;
        --text: #0f172a;
        --sub: #475569;
        --accent: #22d3ee;
        --accent2: #a78bfa;
        --border: #e2e8f0;
    }

    @media (prefers-color-scheme: dark) {
        :root {
            --bg: #020617;
            --card: #0f172a;
            --text: #f1f5f9;
            --sub: #94a3b8;
            --border: #1e293b;
        }
    }

    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: radial-gradient(circle at 50% -20%, #1e293b, var(--bg) 70%);
        color: var(--text);
    }

    .guide-container {
        max-width: 760px;
        margin: 40px auto;
        padding: 32px 22px 50px;
        border-radius: 22px;
        background: var(--card);
        border: 1px solid var(--border);
        box-shadow: 0 10px 40px rgba(0, 0, 0, .08);
        animation: fadeIn .6s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(16px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    .guide-title {
        text-align: center;
        font-size: 2.2rem;
        font-weight: 800;
        background: linear-gradient(90deg, var(--accent), var(--accent2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .guide-sub {
        text-align: center;
        font-size: 1rem;
        color: var(--sub);
        margin-bottom: 36px;
    }

    .guide-section {
        margin-bottom: 24px;
        padding: 20px;
        border-radius: 18px;
        background: var(--card);
        border: 1px solid var(--border);
        transition: .25s;
    }

    .guide-section:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, .08);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 12px;
    }

    .section-icon {
        font-size: 1.4rem;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .guide-section ul {
        padding-left: 18px;
        margin: 0;
        color: var(--sub);
        line-height: 1.7;
    }

    /* FAQ */
    .faq-item {
        border-top: 1px solid var(--border);
        padding: 14px 0;
        cursor: pointer;
    }

    .faq-question {
        font-weight: 700;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height .3s ease;
        color: var(--sub);
        padding-top: 6px;
    }

    .faq-item.active .faq-answer {
        max-height: 120px;
    }

    @media(max-width:480px) {
        .guide-container {
            margin: 20px 12px;
            padding: 24px 16px
        }

        .guide-title {
            font-size: 1.8rem
        }
    }
</style>
@endpush

@section('content')
<div class="guide-container">

    <div class="guide-title">VortexNFT Platform Guide</div>
    <div class="guide-sub">Everything you need to register, earn, and manage your digital assets.</div>

    <div class="guide-section">
        <div class="section-title"><span class="section-icon">📝</span> Registration & Onboarding</div>
        <ul>
            <li>Register for a VortexNFT account using your email and a secure password.</li>
            <li>Verify your email address to activate your account.</li>
            <li>Complete your profile for a personalized experience.</li>
            <li>Enable Two-Factor Authentication for extra security.</li>
        </ul>
    </div>

    <div class="guide-section">
        <div class="section-title"><span class="section-icon">📊</span> Dashboard & Account</div>
        <ul>
            <li>After logging in, access your dashboard to view your digital assets, rewards, and recent activity.</li>
            <li>Track your owned NFTs, coins, and transaction history from your account panel.</li>
            <li>Update your profile and security settings anytime in the Account section.</li>
        </ul>
    </div>

    <div class="guide-section">
        <div class="section-title"><span class="section-icon">🎁</span> Lucky Box Rewards</div>
        <ul>
            <li>Open one Lucky Box daily to receive digital rewards (NFTs, coins, or other assets).</li>
            <li>Rewards may include NFTs, coins, multipliers, or rare digital items.</li>
            <li>All rewards are automatically credited to your account after reveal.</li>
            <li>Each box contains a reward — rarity varies.</li>
        </ul>
    </div>

    <div class="guide-section">
        <div class="section-title"><span class="section-icon">🖼</span> NFT Marketplace</div>
        <ul>
            <li>Buy and sell NFTs securely within the VortexNFT platform.</li>
            <li>Set your own price when listing NFTs for sale.</li>
            <li>Use earned coins and rewards to expand your collection.</li>
            <li>Rare NFTs may have higher value in the marketplace.</li>
        </ul>
    </div>

    <div class="guide-section">
        <div class="section-title"><span class="section-icon">📜</span> Platform Rules</div>
        <ul>
            <li>One Lucky Box claim per account per day.</li>
            <li>Marketplace abuse or duplicate accounts may result in restrictions.</li>
            <li>All digital reward results are final after reveal.</li>
            <li>Users are responsible for managing their digital assets.</li>
        </ul>
    </div>

    <div class="guide-section">
        <div class="section-title"><span class="section-icon">❓</span> Frequently Asked Questions</div>

        <div class="faq-item">
            <div class="faq-question">Where do rewards go? <span>+</span></div>
            <div class="faq-answer">Rewards are instantly credited to your VortexNFT account.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Can I sell NFT rewards? <span>+</span></div>
            <div class="faq-answer">Yes. NFT rewards can be traded like any other NFT on the platform.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Is Lucky Box free? <span>+</span></div>
            <div class="faq-answer">Yes. Every user can open one box per day.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">How do I contact support? <span>+</span></div>
            <div class="faq-answer">Use the Support link in your account menu.</div>
        </div>

    </div>

</div>

<script>
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
</script>
@endsection