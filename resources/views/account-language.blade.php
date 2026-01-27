@extends('layouts.app')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('styles')
<link rel="stylesheet" href="/css/account.css">
<style>
    .settings-container {
        background: #f8fafc;
        min-height: 100vh;
        padding: 16px 12px 40px;
    }

    /* Header */
    .language-hero {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        border-radius: 18px;
        padding: 22px 18px;
        text-align: center;
        margin-bottom: 18px;
        box-shadow: 0 8px 20px rgba(37, 99, 235, .25);
    }

    .language-list {
        display: flex;
        flex-direction: column;
        gap: 12px
    }

    /* Button */
    .language-btn {
        width: 100%;
        padding: 16px 18px;
        font-size: 1.05rem;
        border: none;
        border-radius: 14px;
        background: #fff;
        color: #111827;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        transition: .25s;
        cursor: pointer;
    }

    .language-btn:hover {
        transform: translateY(-2px)
    }

    .language-btn.selected {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        font-weight: 600;
        transform: scale(1.02);
        box-shadow: 0 8px 18px rgba(37, 99, 235, .3);
    }

    .flag {
        width: 28px;
        height: 20px;
        border-radius: 4px;
        object-fit: cover;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
        margin-right: 12px;
    }

    .check-icon {
        font-size: 1.2rem
    }
</style>
@endpush

@section('content')
@include('partials.header', ['title' => 'Choose Language'])

<div class="settings-container">

    <div class="language-hero">
        <h2>Select Your Language</h2>
        <p>Switch instantly without page reload</p>
    </div>

    @php
    $languages = [
    ['ar','Arabic (العربية)'],
    ['id','Bahasa Indonesia'],
    ['zh','Chinese (中文)'],
    ['en','English'],
    ['es','Spanish (Español)'],
    ['fr','French (Français)'],
    ['it','Italian (Italiano)'],
    ['ko','Korean (한국어)'],
    ['pt','Portuguese (Português)'],
    ['ru','Russian (Русский)'],
    ['tr','Turkish (Türkçe)'],
    ['vi','Vietnamese (Tiếng Việt)'],
    ];
    $current = app()->getLocale();
    @endphp

    <div class="language-list">
        @foreach($languages as [$code,$label])
        <button class="language-btn {{ $current==$code?'selected':'' }}"
            data-lang="{{ $code }}">
            <span style="display:flex;align-items:center;">
                <img src="/icons/flags/{{ $code }}.svg" class="flag">
                {{ $label }}
            </span>
            <span class="check-icon">{{ $current==$code?'✓':'' }}</span>
        </button>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const buttons = document.querySelectorAll('.language-btn');
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        buttons.forEach(btn => {
            btn.addEventListener('click', function() {

                // UI switch
                buttons.forEach(b => {
                    b.classList.remove('selected');
                    b.querySelector('.check-icon').textContent = '';
                });

                this.classList.add('selected');
                this.querySelector('.check-icon').textContent = '✓';

                const lang = this.dataset.lang;

                fetch("{{ route('account.language.set') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            language: lang
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            setTimeout(() => location.reload(), 300);
                        }
                    });
            });
        });

    });
</script>

@include('partials.footer')
@endsection