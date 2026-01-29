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
        /* opacity: .6 */
    }

    /* LEADERBOARD BTN */
    .leader-btn {
        display: inline-block;
        color: #000000;
        margin-top: 10px;
        padding: 6px 14px;
        border-radius: 20px;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .2);
        font-size: .8rem;
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

    /* SHAKE */
    .box.shake {
        animation: shake .4s linear infinite
    }

    @keyframes shake {
        0% {
            transform: translateX(-2px)
        }

        50% {
            transform: translateX(2px)
        }

        100% {
            transform: translateX(-2px)
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
        font-weight: 700;
    }

    /* FRONT */
    .box-front {
        background: rgba(255, 255, 255, .05);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, .15);
        box-shadow: 0 0 18px #22d3ee55, inset 0 0 14px #a78bfa33;
        font-size: 1.6rem;
    }

    /* BACK */
    .box-back {
        transform: rotateY(180deg);
        font-size: 1rem;
        padding: 8px;
        text-align: center;
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
    <div class="game-title">⚡ Neon Lucky Box</div>
    <div class="game-sub">Tap ONE box — unlock your digital reward</div>
    <div class="leader-btn">🏆 Leaderboard</div>
</div>

<div class="box-grid">
    @for($i=0;$i<9;$i++)
        <div class="box" data-index="{{ $i }}">
        <div class="box-inner box-front">?</div>
        <div class="box-inner box-back"></div>
</div>
@endfor
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

            document.getElementById('clickSound').play();
            box.classList.add('shake');

            setTimeout(() => {
                box.classList.remove('shake');
                box.innerHTML += '<div class="scan-line"></div>';
                document.getElementById('revealSound').play();

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

                        document.getElementById('winSound').play();
                        confetti({
                            particleCount: 160,
                            spread: 100,
                            origin: {
                                y: .6
                            }
                        });

                        setTimeout(() => {
                            Swal.fire({
                                title: 'Reward Unlocked!',
                                text: reward,
                                icon: 'success',
                                confirmButtonColor: '#8b5cf6'
                            }).then(() => location.reload());
                        }, 900);

                    });
            }, 700);

        });
    });
</script>

@endsection