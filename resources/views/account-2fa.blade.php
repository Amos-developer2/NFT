@extends('layouts.app')

@section('content')

@push('styles')
<link rel="stylesheet" href="/css/account.css">

<style>
    /* ============================= */
    /* 2FA Page Container            */
    /* ============================= */

    .twofa-wrapper {
        max-width: 460px;
        margin: 24px auto 60px;
        padding: 0 14px;
    }

    /* ============================= */
    /* Card                          */
    /* ============================= */

    .twofa-card {
        margin: -60px 0 0 0;
        /* border: 2px solid red; */
        background: #ffffff;
        border-radius: 20px;
        padding: 26px 18px 22px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
    }

    /* ============================= */
    /* Header                        */
    /* ============================= */

    .twofa-header {
        text-align: center;
        margin-bottom: 22px;
    }

    .twofa-header-icon {
        width: 54px;
        height: 54px;
        margin: 0 auto 10px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .twofa-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #1e3a8a;
        margin-bottom: 6px;
    }

    .twofa-desc {
        font-size: .98rem;
        color: #475569;
        line-height: 1.6;
    }

    /* ============================= */
    /* QR + Secret                   */
    /* ============================= */

    .twofa-qr {
        display: flex;
        justify-content: center;
        margin: 22px 0 16px;
    }

    .twofa-secret {
        background: #f1f5f9;
        border-radius: 12px;
        padding: 10px 12px;
        text-align: center;
        font-family: monospace;
        font-size: .95rem;
        color: #0f172a;
        word-break: break-all;
        margin-bottom: 18px;
    }

    /* ============================= */
    /* Status                        */
    /* ============================= */

    .twofa-status {
        text-align: center;
        font-size: .95rem;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .twofa-status.enabled {
        color: #16a34a;
    }

    .twofa-status.disabled {
        color: #dc2626;
    }

    /* ============================= */
    /* Form                          */
    /* ============================= */

    .twofa-form {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .twofa-input {
        padding: 14px;
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        font-size: 1.15rem;
        text-align: center;
        letter-spacing: .25em;
        background: #f8fafc;
        outline: none;
        transition: border .2s, box-shadow .2s;
    }

    .twofa-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
    }

    /* ============================= */
    /* Buttons                       */
    /* ============================= */

    .twofa-btn {
        padding: 14px;
        border-radius: 14px;
        font-size: 1.05rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: transform .12s ease, box-shadow .12s ease;
    }

    .twofa-btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        box-shadow: 0 8px 18px rgba(37, 99, 235, .25);
    }

    .twofa-btn-danger {
        background: #ef4444;
        color: #fff;
        box-shadow: 0 8px 18px rgba(239, 68, 68, .25);
    }

    .twofa-btn:active {
        transform: scale(.98);
    }

    /* ============================= */
    /* Footer Info                   */
    /* ============================= */

    .twofa-footer {
        margin-top: 18px;
        font-size: .9rem;
        color: #64748b;
        text-align: center;
        line-height: 1.5;
    }

    /* ============================= */
    /* Responsive                    */
    /* ============================= */

    @media (min-width: 640px) {
        .twofa-card {
            padding: 30px 26px 26px;
        }

        .twofa-title {
            font-size: 1.65rem;
        }
    }
</style>
@endpush

@include('partials.header', ['title' => 'Two-Factor Authentication'])

<div class="twofa-wrapper">
    <div class="twofa-card">

        <!-- Header -->
        <div class="twofa-header">
            <div class="twofa-header-icon">🔐</div>
            <div class="twofa-title">Two-Factor Authentication</div>
            <div class="twofa-desc">
                Protect your account with an extra layer of security.<br>
                Scan the QR code using any authenticator app.
            </div>
        </div>

        <!-- QR -->
        <div class="twofa-qr">
            {!! $qrImage !!}
        </div>

        <!-- Secret -->
        <div class="twofa-secret">
            <strong>Secret Key</strong><br>{{ $secret }}
        </div>

        @if($enabled)
        <div class="twofa-status enabled">
            ✅ 2FA is enabled on your account
        </div>

        <form method="POST" action="{{ route('account.2fa.disable') }}">
            @csrf
            <button type="submit" class="twofa-btn twofa-btn-danger" style="padding: 10px 100px;">
                Disable 2FA
            </button>
        </form>
        @else
        <div class="twofa-status disabled">
            ⚠️ 2FA is not enabled
        </div>

        <form method="POST" action="{{ route('account.2fa.enable') }}" class="twofa-form">
            @csrf
            <input
                type="text"
                name="otp"
                maxlength="6"
                pattern="[0-9]{6}"
                inputmode="numeric"
                placeholder="Enter 6-digit code"
                class="twofa-input"
                required
                autofocus>

            <button type="submit" class="twofa-btn twofa-btn-primary">
                Enable 2FA
            </button>
        </form>
        @endif

        <div class="twofa-footer">
            <strong>Important:</strong> Keep your secret key safe.<br>
            If you lose access, contact support for recovery.
        </div>

    </div>
</div>

@endsection