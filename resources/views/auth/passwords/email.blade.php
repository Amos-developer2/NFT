@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <span>🔑</span>
        </div>
        <h1 class="auth-title">Reset Password</h1>
        <p class="auth-subtitle">Enter your email to receive a reset link</p>
    </div>

    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            {{ __('Send Reset Link') }}
        </button>
    </form>

    <div class="auth-footer">
        Remember your password? <a href="{{ route('login') }}">Sign In</a>
    </div>
</div>
@endsection