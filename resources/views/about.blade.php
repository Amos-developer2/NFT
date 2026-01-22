@extends('layouts.app')

@section('content')
@push('styles')
<style>
    /* ===============================
   THEME VARIABLES
================================ */
    :root {
        --bg: #f8fafc;
        --card: #ffffff;
        --primary: #2563eb;
        --primary-dark: #1e40af;
        --text: #0f172a;
        --muted: #64748b;
        --border: #e5e7eb;
        --shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }

    [data-theme="dark"] {
        --bg: #0b1220;
        --card: #111827;
        --text: #f8fafc;
        --muted: #9ca3af;
        --border: #1f2937;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
    }

    /* ===============================
   PAGE WRAPPER
================================ */
    .about-page {
        margin: -40px 0 0 0;
        padding: 24px 16px 64px;
        background: linear-gradient(180deg, var(--bg), rgba(37, 99, 235, 0.06));
        transition: background 0.3s ease;
    }

    /* ===============================
   HERO
================================ */
    .about-hero {
        max-width: 760px;
        margin: 0 auto 30px;
        text-align: center;
        animation: fadeUp 0.6s ease forwards;
    }

    .about-hero h1 {
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--text);
    }

    .about-hero p {
        margin-top: 8px;
        font-size: 1.05rem;
        color: var(--muted);
    }

    /* ===============================
   DARK MODE TOGGLE
================================ */
    .theme-toggle {
        position: absolute;
        top: 14px;
        right: 16px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        cursor: pointer;
        color: var(--text);
    }

    /* ===============================
   CARD
================================ */
    .about-card {
        max-width: 880px;
        margin: 0 auto;
        background: var(--card);
        border-radius: 22px;
        box-shadow: var(--shadow);
        padding: 28px 22px;
        display: flex;
        flex-direction: column;
        gap: 32px;
        animation: fadeUp 0.7s ease forwards;
    }

    /* ===============================
   SECTION
================================ */
    .about-section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 6px;
    }

    .about-text {
        color: var(--text);
        line-height: 1.7;
    }

    /* ===============================
   STATS
================================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .stat-box {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffff;
        border-radius: 16px;
        padding: 18px;
        text-align: center;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #ffff;
    }

    .stat-label {
        font-size: 0.85rem;
        opacity: 0.9;
        color: #ffff;
    }

    /* ===============================
   FEATURES
================================ */
    .features-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .feature {
        background: rgba(37, 99, 235, 0.06);
        border-radius: 16px;
        padding: 16px;
    }

    .feature h4 {
        font-size: 1rem;
        margin-bottom: 4px;
        color: var(--text);
    }

    .feature p {
        font-size: 0.95rem;
        color: var(--muted);
    }

    /* ===============================
   TEAM
================================ */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .team-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 16px;
        text-align: center;
        box-shadow: var(--shadow);
    }

    .team-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        margin-bottom: 8px;
        object-fit: cover;
    }

    .team-name {
        font-weight: 700;
        color: var(--text);
    }

    .team-role {
        font-size: 0.9rem;
        color: var(--muted);
    }

    /* ===============================
   CONTACT
================================ */
    .about-contact {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 18px;
        padding: 22px;
        color: #fff;
        text-align: center;
    }

    .about-contact a {
        color: #fff;
        font-weight: 600;
        text-decoration: underline;
    }

    /* ===============================
   ANIMATIONS
================================ */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===============================
   RESPONSIVE
================================ */
    @media (min-width: 640px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .features-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .team-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .about-hero h1 {
            font-size: 2.6rem;
        }

        .about-card {
            padding: 40px;
        }
    }
</style>
@endpush

@include('partials.header', ['title' => 'About Us'])

<button class="theme-toggle" onclick="toggleTheme()">🌙 Theme</button>

<div class="about-page" id="aboutPage">

    <!-- HERO -->
    <div class="about-hero">
        <h1>About TradeX</h1>
        <p>Secure. Transparent. Next-Gen NFT Trading.</p>
    </div>

    <!-- MAIN CARD -->
    <div class="about-card">

        <!-- MISSION -->
        <div>
            <div class="about-section-title">🎯 Our Mission</div>
            <div class="about-text">
                TradeX exists to make NFT trading accessible, secure,
                and rewarding through cutting-edge blockchain technology.
            </div>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-value">50K+</div>
                <div class="stat-label">NFTs Traded</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">12K+</div>
                <div class="stat-label">Users</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">99.9%</div>
                <div class="stat-label">Uptime</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">24/7</div>
                <div class="stat-label">Support</div>
            </div>
        </div>

        <!-- FEATURES -->
        <div>
            <div class="about-section-title">🚀 What We Offer</div>
            <div class="features-grid">
                <div class="feature">
                    <h4>Advanced Security</h4>
                    <p>2FA, encrypted wallets, and safe transactions.</p>
                </div>
                <div class="feature">
                    <h4>Live Auctions</h4>
                    <p>Real-time bidding with countdown timers.</p>
                </div>
                <div class="feature">
                    <h4>Fast Marketplace</h4>
                    <p>Instant listings and smooth UX.</p>
                </div>
                <div class="feature">
                    <h4>Full Transparency</h4>
                    <p>Clear pricing and ownership tracking.</p>
                </div>
            </div>
        </div>

        <!-- TEAM -->
        <div>
            <div class="about-section-title">👥 Our Team</div>
            <div class="team-grid">
                <div class="team-card">
                    <img src="/images/3333.avif" class="team-avatar">
                    <div class="team-name">Alex Morgan</div>
                    <div class="team-role">Manager</div>
                </div>
                <div class="team-card">
                    <img src="/images/doodle4.png" class="team-avatar">
                    <div class="team-name">Sara Lee</div>
                    <div class="team-role">Recruiting Manager</div>
                </div>
                <div class="team-card">
                    <img src="/images/coolcat3.png" class="team-avatar">
                    <div class="team-name">James Kim</div>
                    <div class="team-role">Recruiting Manager</div>
                </div>
                <div class="team-card">
                    <img src="/images/boredape2.png" class="team-avatar">
                    <div class="team-name">Emma Stone</div>
                    <div class="team-role">Product Manager</div>
                </div>
            </div>
        </div>

        <!-- CONTACT -->
        <div class="about-contact">
            Have questions? Contact us at<br>
            <a href="mailto:support@tradex.com">support@tradex.com</a>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function toggleTheme() {
        const page = document.getElementById('aboutPage');
        const isDark = page.getAttribute('data-theme') === 'dark';
        page.setAttribute('data-theme', isDark ? 'light' : 'dark');
    }
</script>
@endpush

@endsection