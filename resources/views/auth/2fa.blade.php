</div>
<style>
    .nft-header-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(34, 197, 94, 0.1);
        border-radius: 20px;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    @media (max-width: 600px) {
        div[style*="max-width:410px"] {
            max-width: 100vw !important;
            padding: 1.2rem 0.3rem 0 0.3rem !important;
            border-radius: 0 !important;
        }

        div[style*="background:#fff"] {
            padding: 1.2rem 0.5rem 1rem 0.5rem !important;
            border-radius: 12px !important;
        }

        .empty-state img,
        .empty-icon {
            width: 54px !important;
            height: 54px !important;
        }

        .category-tabs {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        .auction-card {
            flex-direction: column !important;
            padding: 0.7rem 0.5rem !important;
        }

        button[type="submit"] {
            font-size: 1rem !important;
            padding: 0.8rem 0 !important;
        }

        .browse-btn {
            font-size: 1rem !important;
            padding: 0.8rem 1.2rem !important;
        }

        .auth-header-bar,
        .auth-card-new,
        .track-auctions-container {
            max-width: 100vw !important;
            box-sizing: border-box !important;
        }
    }
</style>
@extends('layouts.auth')

@section('content')
<div style="width:100%;font-family:'Inter','Segoe UI',Arial,sans-serif;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.2rem;">
        <a href="{{ url('/') }}" style="background:#f3f4f6;border-radius:50%;width:38px;height:38px;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
        </a>
        <!-- <span class="nft-header-badge"
            style="margin-left:auto;background:#fff0e5;color:#f97316;font-weight:600;padding:0.38rem 1.1rem;border-radius:18px;font-size:1.01rem;box-shadow:0 1px 4px rgba(0,0,0,0.04);display:inline-block;">
            2FA Verification
        </span> -->
    </div>
    <style>
        @keyframes badgeFadeColor {
            0% {
                opacity: 0;
                color: #f97316;
            }

            30% {
                opacity: 1;
                color: #0ea5e9;
            }

            60% {
                color: #22c55e;
            }

            100% {
                color: #f97316;
            }
        }

        .badge-2fa-animated {
            animation: badgeFadeColor 2.2s cubic-bezier(.4, 2, .6, 1) 0.2s 1 both;
        }
    </style>
</div>

<div style="text-align:center;margin-bottom:1.2rem;">
    <img src="/images/vortex.png" alt="VortexNFT" style="height:54px;margin-bottom:0.5rem;">
    <div style="margin:0.7rem 0 0.2rem 0;color:#0ea5e9;font-size:1.08rem;font-weight:500;display:flex;align-items:center;justify-content:center;gap:0.4rem;">
        <span>🔑</span> Secure 2FA Verification <span>🔑</span>
    </div>
</div>
<div style="padding: 10px 10px;background:#fff;border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin:1.0rem;">
    <h3 style="font-size:1.35rem;font-weight:700;margin-bottom:0.7rem;text-align:center;">Enter 2FA Code</h3>
    <p style="color:#666;font-size:1.07rem;margin-bottom:1.2rem;text-align:center;">Enter the 6-digit code from your authenticator app to continue</p>
    @if(session('error'))
    <div style="background:#fee2e2;color:#b91c1c;padding:0.7rem 1rem;border-radius:8px;margin-bottom:1rem;text-align:center;font-weight:500;">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('2fa.verify') }}" autocomplete="off">
        @csrf
        <div style="margin-bottom:1.2rem;">
            <label for="otp" style="display:block;font-weight:600;margin-bottom:0.4rem;color:#222;font-size:1.07rem;text-align:left;">Authenticator Code</label>
            <div style="display:flex;align-items:center;gap:0.6rem;background:#f3f4f6;border-radius:8px;padding:0.7rem 1rem;box-shadow:0 1px 4px rgba(0,0,0,0.04);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 6v6l4 2" />
                </svg>
                <input id="otp" type="text" name="otp" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required autofocus placeholder="Enter 6-digit code" style="border:none;background:transparent;outline:none;font-size:1.15rem;font-weight:500;flex:1;" value="{{ old('otp') }}">
            </div>
            @error('otp')
            <span style="color:#ef4444;font-size:0.98rem;font-weight:500;display:block;margin-top:0.4rem;">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" style="width:100%;padding:1rem 0;font-size:1.13rem;font-weight:700;border-radius:8px;background:linear-gradient(90deg,#22c55e 0%,#0ea5e9 100%);color:#fff;border:none;box-shadow:0 2px 8px rgba(34,197,94,0.10);cursor:pointer;transition:transform 0.18s cubic-bezier(.4,2,.6,1),box-shadow 0.18s;display:flex;align-items:center;justify-content:center;gap:0.7rem;">
            <span>Verify</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>
    </form>
</div>
<div style="display:flex;align-items:center;justify-content:center;gap:2.2rem;margin-top:2.2rem;">
    <div style="text-align:center;">
        <div style="font-size:1.18rem;font-weight:700;color:#0ea5e9;">50K+</div>
        <div style="font-size:0.97rem;color:#888;">USERS</div>
    </div>
    <div style="text-align:center;">
        <div style="font-size:1.18rem;font-weight:700;color:#0ea5e9;">$2.5M</div>
        <div style="font-size:0.97rem;color:#888;">VOLUME</div>
    </div>
    <div style="text-align:center;">
        <div style="font-size:1.18rem;font-weight:700;color:#0ea5e9;">10K+</div>
        <div style="font-size:0.97rem;color:#888;">NFTS</div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Authentication Failed',
        text: '{{ session('
        error ') }}',
        confirmButtonColor: '#ef4444',
    });
    @endif
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('
        success ') }}',
        confirmButtonColor: '#2563eb',
    });
    @endif
    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ $errors->first() }}',
        confirmButtonColor: '#ef4444',
    });
    @endif
</script>
@endpush