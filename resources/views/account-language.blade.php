@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="/css/account.css">
@endpush

@section('content')

<div class="lang-page">

    <!-- Header -->
    <div class="lang-header">
        <a href="{{ route('account') }}" class="back-btn">
            <img src="/icons/arrow-left.svg" alt="Back">
        </a>
        <h1>Choose Language</h1>
        <p>Select your preferred language for the platform</p>
    </div>

    <!-- Language Card -->
    <div class="lang-card">
        <form action="{{ route('account.language.set') }}" method="POST" class="language-list">
            @csrf
            @php
            $languages = [
            ['ar', 'Arabic (العربية)', '🇸🇦'],
            ['id', 'Bahasa Indonesia', '🇮🇩'],
            ['zh', 'Chinese (中文)', '🇨🇳'],
            ['en', 'English', '🇬🇧'],
            ['es', 'Spanish (Español)', '🇪🇸'],
            ['fil', 'Filipino', '🇵🇭'],
            ['fr', 'French (Français)', '🇫🇷'],
            ['it', 'Italiano', '🇮🇹'],
            ['ko', 'Korean (한국어)', '🇰🇷'],
            ['pt', 'Português', '🇵🇹'],
            ['ru', 'Русский', '🇷🇺'],
            ['tr', 'Türkçe', '🇹🇷'],
            ['vi', 'Tiếng Việt', '🇻🇳'],
            ];
            $current = app()->getLocale();
            @endphp

            @foreach($languages as [$code, $label, $flag])
            <button type="submit" name="language" value="{{ $code }}"
                class="language-btn {{ $current == $code ? 'selected' : '' }}">
                <div class="lang-left">
                    <span class="flag">{{ $flag }}</span>
                    <span>{{ $label }}</span>
                </div>
                @if($current == $code)
                <span class="checkmark">✓</span>
                @endif
            </button>
            @endforeach
        </form>
    </div>
</div>


<style>
    .lang-page {
        background: linear-gradient(180deg, #f1f5f9, #e2e8f0);
        min-height: 100vh;
        padding: 20px 14px 40px;
    }

    /* Header */
    .lang-header {
        text-align: center;
        margin-bottom: 20px;
        position: relative;
    }

    .lang-header h1 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f172a;
    }

    .lang-header p {
        font-size: 0.95rem;
        color: #64748b;
    }

    .back-btn {
        position: absolute;
        left: 0;
        top: 5px;
    }

    .back-btn img {
        width: 22px;
    }

    /* Card */
    .lang-card {
        background: #fff;
        border-radius: 16px;
        padding: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    /* List */
    .language-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Button */
    .language-btn {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
        padding: 14px 16px;
        border-radius: 12px;
        background: #f8fafc;
        font-size: 1rem;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .language-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(37, 99, 235, 0.15);
    }

    /* Selected */
    .language-btn.selected {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff;
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
    }

    /* Left section */
    .lang-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .flag {
        font-size: 1.4rem;
    }

    /* Checkmark */
    .checkmark {
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Mobile */
    @media (max-width:600px) {
        .lang-header h1 {
            font-size: 1.4rem;
        }

        .language-btn {
            padding: 13px 12px;
        }
    }
</style>

@endsection