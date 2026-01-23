@extends('layouts.app')

@section('content')
<div class="daily-checkin-wrapper">
    <h2 class="checkin-title">🎁 Daily Check-In</h2>
    <p class="checkin-desc">Pick a card and win a reward! You get one chance every day.</p>
    <div class="checkin-cards">
        @foreach($rewards as $i => $reward)
        <div class="checkin-card" data-reward="{{ $reward }}" data-index="{{ $i }}">
            <div class="card-front">?</div>
            <div class="card-back">{{ $reward }}</div>
        </div>
        @endforeach
    </div>
    <div class="checkin-message"></div>
    <a href="{{ route('home') }}" class="back-home">Back to Home</a>
</div>

<style>
    .daily-checkin-wrapper {
        max-width: 420px;
        margin: 40px auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(42, 108, 246, 0.08);
        padding: 32px 20px 24px 20px;
        text-align: center;
    }

    .checkin-title {
        font-size: 2rem;
        font-weight: 800;
        color: #2A6CF6;
        margin-bottom: 8px;
    }

    .checkin-desc {
        color: #64748b;
        margin-bottom: 24px;
    }

    .checkin-cards {
        display: flex;
        justify-content: center;
        gap: 14px;
        margin-bottom: 24px;
    }

    .checkin-card {
        width: 56px;
        height: 80px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(42, 108, 246, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: #2A6CF6;
        cursor: pointer;
        position: relative;
        transition: transform 0.2s;
        perspective: 400px;
    }

    .checkin-card.flipped .card-front {
        display: none;
    }

    .checkin-card.flipped .card-back {
        display: flex;
    }

    .card-front {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
        color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(42, 108, 246, 0.10);
    }

    .card-back {
        width: 100%;
        height: 100%;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #22c55e;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(42, 108, 246, 0.10);
    }

    .checkin-card:active {
        transform: scale(0.97);
    }

    .checkin-message {
        font-size: 1.1rem;
        color: #2A6CF6;
        font-weight: 700;
        margin-bottom: 18px;
        min-height: 24px;
    }

    .back-home {
        display: inline-block;
        margin-top: 10px;
        color: #64748b;
        text-decoration: underline;
        font-size: 1rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let picked = false;
        document.querySelectorAll('.checkin-card').forEach(card => {
            card.addEventListener('click', function() {
                if (picked) return;
                picked = true;
                this.classList.add('flipped');
                const reward = this.dataset.reward;
                document.querySelector('.checkin-message').textContent = 'You won: ' + reward + '!';
                // Optionally, send to backend
                fetch("{{ route('daily.checkin.submit') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        reward: reward
                    })
                });
                // Disable all cards
                document.querySelectorAll('.checkin-card').forEach(c => c.style.pointerEvents = 'none');
            });
        });
    });
</script>
@endsection