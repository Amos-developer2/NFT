@extends('layouts.app')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
@endpush

@section('content')

<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: radial-gradient(circle at top, #0f172a, #020617 70%);
        color: #fff;
    }

    /* HEADER */
    .game-header {
        text-align: center;
        padding: 28px 12px 10px
    }

    .game-title {
        font-size: 1.9rem;
        font-weight: 800;
        background: linear-gradient(90deg, #22d3ee, #a78bfa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 25px #22d3ee66;
    }

    .game-sub {
        font-size: .9rem;
        color: #000000;
    }

    /* GRID */
    .box-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        padding: 22px;
        max-width: 480px;
        margin: auto;
        perspective: 1200px;
    }

    /* BOX */
    .box {
        height: 110px;
        border-radius: 20px;
        position: relative;
        transform-style: preserve-3d;
        transition: transform .8s cubic-bezier(.2, .8, .2, 1);
        cursor: pointer;
        animation: float 3s ease-in-out infinite;
        box-shadow:
            0 0 20px rgba(34, 211, 238, .15),
            0 10px 30px rgba(0, 0, 0, .4);
    }

    .box:hover {
        transform: translateY(-6px) scale(1.03);
    }

    .box:nth-child(odd) {
        animation-delay: .6s
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0)
        }

        50% {
            transform: translateY(-8px)
        }
    }

    .box-inner {
        position: absolute;
        inset: 0;
        border-radius: 20px;
        backface-visibility: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* FRONT */
    .box-front {
        background: rgba(255, 255, 255, .05);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, .15);
        box-shadow: 0 0 18px #22d3ee55, inset 0 0 14px #a78bfa33;
        background: radial-gradient(circle at 50% 40%, rgba(34, 211, 238, .25), rgba(0, 0, 0, .2));
    }

    .box-front img {

        width: 100%;
        height: 70%;
        object-fit: cover;
        filter: drop-shadow(0 0 12px #22d3ee);
        transition: transform .3s ease;
    }

    /* Animated Lucky Icon */
    .lucky-animated-icon {
        font-size: 2.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: bounce 1.2s infinite alternate;
        filter: drop-shadow(0 0 8px #22d3ee);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    @keyframes bounce {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-10px) scale(1.08);
            box-shadow: 0 8px 18px #22d3ee44;
        }
    }

    .box:hover .box-front img {
        transform: scale(1.1) rotate(-3deg);
    }



    /* BACK */
    .box-back {
        transform: rotateY(180deg);
        font-size: 1rem;
        padding: 8px;
        text-align: center;
        font-weight: 700;
    }

    /* RARITY */
    .common {
        background: linear-gradient(135deg, #38bdf8, #0ea5e9)
    }

    .rare {
        background: linear-gradient(135deg, #8b5cf6, #6366f1)
    }

    .epic {
        background: linear-gradient(135deg, #ec4899, #a855f7)
    }

    .legendary {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        box-shadow: 0 0 25px #fbbf24, 0 0 45px #f59e0b;
    }

    /* REVEAL */
    .box.reveal {
        transform: rotateY(180deg) scale(1.08)
    }

    .box.disabled {
        opacity: .25;
        pointer-events: none
    }

    /* SCAN */
    .scan-line {
        position: absolute;
        inset: 0;
        border-radius: 20px;
        background: linear-gradient(transparent, rgba(255, 255, 255, .25), transparent);
        animation: scan 1.2s linear infinite;
    }

    @keyframes scan {
        0% {
            transform: translateY(-100%)
        }

        100% {
            transform: translateY(100%)
        }
    }

    @media(max-width:420px) {
        .box {
            height: 95px
        }
    }
</style>

<div class="game-header">
    <div class="game-title">⚡Lucky Box</div>
    <div class="game-sub">Tap ONE box — unlock your digital reward</div>
</div>

<div class="box-grid">
    @for($i=1;$i<=9;$i++)
        <div class="box" data-index="{{ $i-1 }}">
        <div class="box-inner box-front">
            @if($i <= 9)
                <span class="lucky-animated-icon">🎁</span>
                @endif
        </div>
        <div class="box-inner box-back"></div>
</div>
@endfor
</div>

<!-- Lucky Box Instructions -->
<div class="luckybox-instructions" style="max-width:420px;margin:32px auto 0;padding:22px 18px 18px;background:rgba(34,211,238,0.10);border-radius:18px;box-shadow:0 4px 18px rgba(34,211,238,0.08);text-align:center;">
    <div style="font-size:1.25rem;font-weight:800;color:#22d3ee;margin-bottom:8px;letter-spacing:0.5px;">
        How to Play Lucky Box
    </div>
    <ul style="list-style:none;padding:0;margin:0 0 8px 0;font-size:1.05rem;color:#64748b;line-height:1.7;">
        <li style="margin-bottom:8px;display:flex;align-items:center;gap:8px;justify-content:center;">
            <span style="font-size:1.3em;">🎁</span>
            <span>Tap any box to reveal your reward instantly.</span>
        </li>
        <li style="margin-bottom:8px;display:flex;align-items:center;gap:8px;justify-content:center;">
            <span style="font-size:1.3em;">✨</span>
            <span>Each box contains a unique digital prize—NFTs, coins, and more!</span>
        </li>
        <li style="margin-bottom:8px;display:flex;align-items:center;gap:8px;justify-content:center;">
            <span style="font-size:1.3em;">📱</span>
            <span>Mobile-friendly: Play anywhere, anytime.</span>
        </li>
        <li style="display:flex;align-items:center;gap:8px;justify-content:center;">
            <span style="font-size:1.3em;">🚫</span>
            <span>One play per day—choose wisely!</span>
        </li>
    </ul>
    <div style="margin-top:10px;font-size:1.08rem;color:#0ea5e9;font-weight:600;">
        Good luck! May fortune favor your tap.
    </div>
</div>

<!-- SOUNDS -->
<audio id="clickSound" src="/sounds/click.mp3"></audio>
<audio id="revealSound" src="/sounds/reveal.mp3"></audio>
<audio id="winSound" src="/sounds/win.mp3"></audio>

<script>
    const boxes = document.querySelectorAll('.box');
    let played = false;

    function getRarityClass(r) {
        r = r.toLowerCase();
        if (r.includes('nft') || r.includes('legend')) return 'legendary';
        if (r.includes('epic') || r.includes('x5')) return 'epic';
        if (r.includes('rare') || r.includes('x3')) return 'rare';
        return 'common';
    }

    boxes.forEach(box => {
        box.addEventListener('click', () => {
            if (played) return;
            played = true;

            clickSound.play();
            box.innerHTML += '<div class="scan-line"></div>';
            revealSound.play();

            fetch('/daily-checkin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        index: box.dataset.index
                    })
                })
                .then(r => r.json())
                .then(data => {
                    const reward = data.reward;

                    box.querySelector('.box-back').textContent = reward;
                    box.querySelector('.box-back').classList.add(getRarityClass(reward));
                    box.classList.add('reveal');

                    boxes.forEach(b => {
                        if (b !== box) b.classList.add('disabled')
                    });

                    winSound.play();
                    confetti({
                        particleCount: 160,
                        spread: 100,
                        origin: {
                            y: .6
                        }
                    });

                    let reloaded = false;
                    nativeAlert('Reward Unlocked!\n' + reward, {
                        type: 'success',
                        title: 'Success',
                        callback: function() {
                            reloaded = true;
                            location.reload();
                        }
                    });
                    setTimeout(function() {
                        if (!reloaded) location.reload();
                    }, 3000);
                });
        });
    });
</script>

@endsection