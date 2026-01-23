@extends('layouts.auth')

@section('content')
<div class="auth-header-bar">
    <a href="{{ url('/') }}" class="back-btn">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
    </a>
    <h1 class="header-title">Two-Factor Authentication</h1>
    <div class="header-spacer"></div>
</div>
<div class="auth-card-new">
    <div class="card-header">
        <h3 class="card-title">2FA Verification</h3>
        <p class="card-subtitle">Enter the 6-digit code from your authenticator app</p>
    </div>
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('2fa.verify') }}" class="auth-form-new">
        @csrf
        <div class="input-group">
            <label for="otp" class="input-label">Authenticator Code</label>
            <div class="input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 6v6l4 2" />
                </svg>
                <input id="otp" type="text" class="input-field @error('otp') is-invalid @enderror" name="otp" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required autofocus placeholder="Enter 6-digit code">
            </div>
            @error('otp')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="submit-btn">
            <span>Verify</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>
    </form>
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