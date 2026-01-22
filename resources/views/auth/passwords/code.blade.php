@extends('layouts.blank')

@push('styles')
<style>
    :root {
        --bg: #f9fafb;
        --card: #ffffff;
        --text: #111827;
        --muted: #6b7280;
        --primary: #2563eb;
        --border: #e5e7eb;
        --shadow: rgba(0, 0, 0, .08);
    }

    @media (prefers-color-scheme: dark) {
        :root {
            --bg: #0b1220;
            --card: #0f172a;
            --text: #f9fafb;
            --muted: #9ca3af;
            --primary: #3b82f6;
            --border: #1e293b;
            --shadow: rgba(0, 0, 0, .5);
        }
    }

    .reset-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: linear-gradient(180deg, var(--bg), #eef2ff);
    }

    .reset-card {
        width: 100%;
        max-width: 420px;
        background: var(--card);
        border-radius: 22px;
        padding: 28px 22px;
        box-shadow: 0 10px 30px var(--shadow);
        text-align: center;
    }

    .reset-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        margin: 0 auto 14px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 20px rgba(37, 99, 235, .45);
    }

    .reset-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text);
    }

    .reset-subtitle {
        font-size: 14px;
        color: var(--muted);
        margin: 8px 0 18px;
    }

    .otp-group {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .otp-box {
        width: 48px;
        height: 56px;
        border-radius: 14px;
        border: 1.5px solid var(--border);
        background: var(--bg);
        font-size: 20px;
        font-weight: 600;
        text-align: center;
        color: var(--text);
        outline: none;
    }

    .otp-box:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .2);
        background: var(--card);
    }

    .verify-btn {
        margin-top: 16px;
        padding: 14px;
        border-radius: 16px;
        border: none;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        box-shadow: 0 8px 20px rgba(37, 99, 235, .35);
        cursor: pointer;
    }

    .timer {
        font-size: 13px;
        color: var(--muted);
        margin-top: 10px;
    }

    .footer {
        margin-top: 16px;
        font-size: 13px;
        color: var(--muted);
    }

    .footer button {
        background: none;
        border: none;
        color: var(--primary);
        font-weight: 600;
        cursor: pointer;
    }

    @media (max-width: 420px) {
        .otp-box {
            width: 40px;
            height: 48px;
        }
    }
</style>
@endpush

@section('content')
@php
// Mask email like exa*********@gmail.com
[$name, $domain] = explode('@', $email);
$maskedName = substr($name, 0, 3) . str_repeat('*', max(strlen($name) - 3, 5));
$maskedEmail = $maskedName . '@' . $domain;
@endphp

<div class="reset-page">
    <div class="reset-card">

        <div class="reset-icon">
            <img src="/icons/lock.svg" width="26">
        </div>

        <div class="reset-title">Verify Code</div>
        <div class="reset-subtitle">
            Code sent to <strong>{{ $maskedEmail }}</strong>
        </div>


        @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function showColoredError() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: @json($errors - > all()).join('<br>'),
                        background: '#fef2f2',
                        color: '#991b1b',
                        confirmButtonColor: '#ef4444',
                        iconColor: '#ef4444',
                    });
                }
                if (typeof Swal === 'undefined') {
                    const swalScript = document.createElement('script');
                    swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                    swalScript.onload = showColoredError;
                    document.head.appendChild(swalScript);
                } else {
                    showColoredError();
                }
            });
        </script>
        @endif

        <form method="POST" action="{{ route('password.code.verify') }}" id="otpForm">
            @csrf

            <div class="otp-group">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1" class="otp-box" inputmode="numeric">
                    @endfor
            </div>

            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="code" id="finalCode">

            <button class="verify-btn">Verify</button>
        </form>

        <div class="timer">
            Code expires in <strong id="countdown">10:00</strong>
        </div>

        <div class="footer">
            Didn’t get it?
            <button id="resendBtn" disabled>Resend (60s)</button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const boxes = [...document.querySelectorAll('.otp-box')];
    const hidden = document.getElementById('finalCode');
    const resendBtn = document.getElementById('resendBtn');

    /* OTP INPUT */
    boxes.forEach((box, i) => {
        box.addEventListener('input', () => {
            if (box.value && boxes[i + 1]) boxes[i + 1].focus();
            hidden.value = boxes.map(b => b.value).join('');
        });
    });

    /* PASTE SUPPORT */
    document.addEventListener('paste', e => {
        const data = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
        data.split('').forEach((v, i) => boxes[i].value = v);
        hidden.value = data;
    });

    /* 10-MIN COUNTDOWN */
    let time = 600; // 10 minutes
    const cd = document.getElementById('countdown');

    setInterval(() => {
        if (time <= 0) {
            cd.textContent = 'Expired';
            return;
        }
        time--;
        cd.textContent =
            String(Math.floor(time / 60)).padStart(2, '0') + ':' +
            String(time % 60).padStart(2, '0');
    }, 1000);

    /* RESEND COOLDOWN */
    let resend = 60;
    const rTimer = setInterval(() => {
        resend--;
        resendBtn.textContent = resend > 0 ? `Resend (${resend}s)` : 'Resend Code';
        resendBtn.disabled = resend > 0;
        if (resend <= 0) clearInterval(rTimer);
    }, 1000);
</script>
@endpush