@extends('layouts.app')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('styles')
<style>
    .checkin-summary-bar {
        width: 100%;
        max-width: 420px;
        margin: 0 auto 1.2rem auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: transparent;
    }

    .summary-flex {
        width: 92%;
        /* border: 2px solid red; */
        margin: -45px 0 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(90deg, #3a8dde 0%, #4f8cff 100%);
        border-radius: 16px;
        box-shadow: 0 2px 8px 0 #e6e6e6;
        padding: 1.2rem 1rem;
        color: #fff;
    }

    .summary-item {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        min-width: 80px;
    }

    .summary-label {
        font-size: 0.92rem;
        color: #e0eaff;
        margin-bottom: 0.2rem;
    }

    .summary-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #fff;
    }

    .summary-value.reward {
        color: #aaffb0;
    }

    .summary-value.streak {
        color: #ffe082;
    }

    .summary-divider {
        width: 1px;
        height: 2.2rem;
        background: rgba(255, 255, 255, 0.25);
        margin: 0 1.2rem;
    }

    .checkin-container {
        max-width: 420px;
        margin: 16px auto 0 auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 12px 0 #e6e6e6;
        padding: 1.2rem 0.7rem 2rem 0.7rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .checkin-header {
        width: 100%;
        text-align: center;
        margin-bottom: 0.7rem;
    }

    .streak {
        font-size: 1rem;
        color: #888;
        margin-top: 0.5rem;
    }

    .spin-section {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1.5rem;
        margin-top: 0.5rem;
    }

    .wheel-wrapper {
        position: relative;
        width: 280px;
        height: 280px;
        max-width: 90vw;
        max-height: 90vw;
        margin: 0 auto 1.2rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #spin-wheel {
        width: 100%;
        height: auto;
        border-radius: 50%;
        box-shadow: 0 2px 8px 0 #e6e6e6;
        background: #f9f9f9;
        display: block;
    }

    .spin-btn {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        background: linear-gradient(90deg, #ffb347 0%, #ffcc33 100%);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        font-size: 1.2rem;
        font-weight: bold;
        box-shadow: 0 2px 8px 0 #e6e6e6;
        cursor: pointer;
        z-index: 2;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .spin-btn:active {
        background: linear-gradient(90deg, #ffcc33 0%, #ffb347 100%);
    }

    .spin-result {
        min-height: 2rem;
        font-size: 1.1rem;
        color: #2e7d32;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .checkin-history {
        width: 100%;
        margin-bottom: 1rem;
    }

    .checkin-history ul {
        padding-left: 1.2rem;
        font-size: 0.98rem;
    }

    .checkin-info {
        width: 100%;
        text-align: center;
        color: #888;
        font-size: 0.95rem;
    }

    @media (max-width: 500px) {
        .checkin-summary-bar {
            padding: 0;
            max-width: 100vw;
        }

        .summary-flex {
            padding: 0.7rem 0.5rem;
        }

        .summary-item {
            min-width: 60px;
            font-size: 0.98rem;
        }

        .summary-divider {
            margin: 0 0.5rem;
            height: 1.6rem;
        }

        .checkin-container {
            padding: 0.7rem 0.1rem 1.2rem 0.1rem;
            max-width: 100vw;
        }

        .wheel-wrapper {
            width: 90vw;
            height: 90vw;
            max-width: 320px;
            max-height: 320px;
        }

        #spin-wheel {
            width: 100%;
            height: auto;
        }

        .spin-btn {
            width: 60px;
            height: 60px;
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
@include('partials.header', ['title' => 'Daily Check-in'])
<div class="market-header-spacer"></div>

<div class="checkin-summary-bar">
    <div class="summary-flex">
        <div class="summary-item">
            <div class="summary-label">Total Check-Ins</div>
            <div class="summary-value">{{ $totalCheckins ?? 0 }}</div>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-item">
            <div class="summary-label">Total Rewards</div>
            <div class="summary-value reward">{{ $totalRewards ?? '+0' }}</div>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-item">
            <div class="summary-label">Streak</div>
            <div class="summary-value streak">{{ $streak ?? 0 }}</div>
        </div>
    </div>
</div>

<div class="checkin-container">
    <div class="checkin-header">
        <h2>Daily Luck Spin</h2>
        <div class="streak">Streak: <span id="streak-count">{{ $streak ?? 0 }}</span> days</div>
    </div>

    <div class="spin-section">
        <div class="wheel-wrapper">
            <canvas id="spin-wheel" width="400" height="400"></canvas>
            <button id="spin-btn" class="spin-btn">SPIN</button>
        </div>
        <div class="spin-result" id="spin-result"></div>
    </div>

    <div class="checkin-rules-box">
        <h4>How Daily Check-in Works</h4>
        <ul>
            <li>Spin the wheel once every day for a chance to win exciting rewards.</li>
            <li>Each spin is <b>free</b> and resets at midnight (server time).</li>
            <li>Possible rewards include Germs, Coins, NFTs, Mystery Boxes, and more!</li>
            <li>Keep your streak going by checking in every day—longer streaks may unlock special bonuses in the future.</li>
            <li>Rewards are credited instantly to your account after each spin.</li>
            <li>You can view your recent check-ins and rewards in the history above.</li>
            <li>Abuse or attempts to bypass the daily limit may result in account restrictions.</li>
        </ul>
    </div>
    <style>
        .checkin-rules-box {
            background: linear-gradient(90deg, #e3f0ff 0%, #f8fbff 100%);
            border-radius: 14px;
            box-shadow: 0 2px 8px 0 #e6e6e6;
            padding: 1.1rem 1.2rem 1.1rem 1.2rem;
            margin: -2.0rem 10px 0 10px;
            max-width: 420px;
            color: #2a3b4c;
            font-size: 0.9rem;
        }

        .checkin-rules-box h4 {
            margin-top: 0;
            text-decoration: underline;
            margin-bottom: 0.7rem;
            color: #3a8dde;
            font-size: 1.13rem;
            font-weight: 700;
        }

        .checkin-rules-box ul {
            padding-left: 1.2rem;
            margin: 0;
        }

        .checkin-rules-box li {
            margin-bottom: 0.35rem;
            line-height: 1.5;
        }
    </style>
</div>

@include('partials.footer')
<div class="pb-20"></div>

<script>
    const rewards = [{
            label: '+1 NFT',
            color: '#FFD700'
        },
        {
            label: '+10 Coins',
            color: '#FF8C00'
        },
        {
            label: '+5 Coins',
            color: '#4CAF50'
        },
        {
            label: 'Try Again',
            color: '#B0BEC5'
        },
        {
            label: '+2 Coins',
            color: '#2196F3'
        },
        {
            label: '+3 Coins',
            color: '#E91E63'
        },
        {
            label: '+1 Coin',
            color: '#9C27B0'
        },
        {
            label: 'Mystery Box',
            color: '#00BCD4'
        }
    ];

    const wheelCanvas = document.getElementById('spin-wheel');
    const ctx = wheelCanvas.getContext('2d');
    const spinBtn = document.getElementById('spin-btn');
    const resultDiv = document.getElementById('spin-result');
    let spinning = false;
    let currentAngle = 0;

    function drawWheel(angle = 0) {
        const size = wheelCanvas.width;
        const center = size / 2;
        const segAngle = 2 * Math.PI / rewards.length;
        ctx.clearRect(0, 0, size, size);

        for (let i = 0; i < rewards.length; i++) {
            ctx.beginPath();
            ctx.moveTo(center, center);
            ctx.arc(center, center, center - 8, angle + i * segAngle, angle + (i + 1) * segAngle);
            ctx.fillStyle = rewards[i].color;
            ctx.fill();

            ctx.save();
            ctx.translate(center, center);
            ctx.rotate(angle + (i + 0.5) * segAngle);
            ctx.textAlign = 'right';
            ctx.font = 'bold 16px Arial';
            ctx.fillStyle = '#fff';
            ctx.fillText(rewards[i].label, center - 24, 8);
            ctx.restore();
        }

        ctx.beginPath();
        ctx.moveTo(center, 8);
        ctx.lineTo(center - 16, 32);
        ctx.lineTo(center + 16, 32);
        ctx.fillStyle = '#ff5252';
        ctx.fill();
    }

    drawWheel(currentAngle);

    let alreadySpun = false;
    spinBtn.addEventListener('click', function() {
        if (spinning || alreadySpun) return;
        // Pick a random index for the reward
        let idx = Math.floor(Math.random() * rewards.length);
        // Call backend to check/record spin
        spinning = true;
        resultDiv.textContent = '';
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfMeta) {
            spinning = false;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'CSRF token missing. Please refresh the page.',
                confirmButtonColor: '#4f8cff'
            });
            return;
        }
        fetch('/daily-checkin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfMeta.getAttribute('content')
                },
                body: JSON.stringify({
                    index: idx
                })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alreadySpun = true;
                    spinning = false;
                    // Show error popup
                    Swal.fire({
                        icon: 'error',
                        title: 'Already Spun!',
                        text: data.message || 'You have already spun today.',
                        confirmButtonColor: '#4f8cff'
                    });
                    return;
                }
                // Animate wheel to the selected reward
                let spinAngle = (360 * 4) + (360 / rewards.length) * idx + (Math.random() * (360 / rewards.length));
                let start = null;
                let duration = 3200 + Math.random() * 600;
                let lastAngle = currentAngle;

                function animateWheel(ts) {
                    if (!start) start = ts;
                    let progress = Math.min((ts - start) / duration, 1);
                    let ease = 1 - Math.pow(1 - progress, 3);
                    let angle = lastAngle + ease * (spinAngle * Math.PI / 180);
                    drawWheel(angle);
                    if (progress < 1) {
                        requestAnimationFrame(animateWheel);
                    } else {
                        currentAngle = angle % (2 * Math.PI);
                        resultDiv.textContent = 'You won: ' + rewards[idx].label + '!';
                        spinning = false;
                        alreadySpun = true;
                        if (rewards[idx].label !== 'Try Again') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Congratulations!',
                                html: '🎉 You won <b>' + rewards[idx].label + '</b>!',
                                confirmButtonColor: '#4f8cff'
                            });
                        }
                    }
                }
                requestAnimationFrame(animateWheel);
            })
            .catch(() => {
                spinning = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Could not spin. Please try again.',
                    confirmButtonColor: '#4f8cff'
                });
            });
    });
</script>
@endsection