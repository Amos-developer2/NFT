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

    /* Header Card */
    .language-hero {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        border-radius: 18px;
        padding: 22px 18px;
        text-align: center;
        margin-bottom: 18px;
        box-shadow: 0 8px 20px rgba(37, 99, 235, .25);
    }

    .language-hero h2 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .language-hero p {
        font-size: .95rem;
        opacity: .9;
    }

    /* List */
    .language-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
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
        text-align: left;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        transition: all .25s ease;
        position: relative;
        overflow: hidden;
    }

    /* Hover */
    .language-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, .08);
    }

    /* Selected */
    .language-btn.selected {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        font-weight: 600;
        transform: scale(1.02);
        box-shadow: 0 8px 18px rgba(37, 99, 235, .3);
    }

    /* Check icon */
    .check-icon {
        font-size: 1.2rem;
        opacity: .9;
    }

    /* Loading indicator */
    .loading-dot {
        width: 6px;
        height: 6px;
        background: #fff;
        border-radius: 50%;
        margin-left: 6px;
        animation: blink 1s infinite alternate;
    }

    @keyframes blink {
        from {
            opacity: .3
        }

        to {
            opacity: 1
        }
    }

    @media(max-width:600px) {
        .language-btn {
            font-size: 1rem;
            padding: 14px
        }
    }
</style>
@endpush

@section('content')
@include('partials.header', ['title' => 'Choose Language'])

<div class="settings-container">

    <div class="language-hero">
        <h2>Select Your Language</h2>
        <p>Your app experience updates instantly</p>
    </div>

    @php
    $languages = [
    ['ar','Arabic (العربية)'],
    ['id','Bahasa Indonesia'],
    ['zh','Chinese (中文)'],
    ['en','English (United Kingdom)'],
    ['es','Spanish (Español)'],
    ['fil','Filipino (Pilipino)'],
    ['fr','French (Français)'],
    ['it','Italian (Italiano)'],
    ['ko','Korean (한국어)'],
    ['pt','Portuguese (Português)'],
    ['ro','Romanian (Română)'],
    ['ru','Russian (Русский)'],
    ['sk','Slovak (Slovenčina)'],
    ['tr','Turkish (Türkçe)'],
    ['uz','Uzbek (O‘zbekcha)'],
    ['vi','Vietnamese (Tiếng Việt)'],
    ];
    $current = app()->getLocale();
    @endphp

    <div class="language-list">
        @foreach($languages as [$code,$label])
        <button class="language-btn {{ $current==$code?'selected':'' }}"
            data-lang="{{ $code }}">
            <span>{{ $label }}</span>
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
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                // UI instant switch
                buttons.forEach(b => {
                    b.classList.remove('selected');
                    b.querySelector('.check-icon').textContent = '';
                });

                this.classList.add('selected');
                this.querySelector('.check-icon').textContent = '✓';

                const lang = this.dataset.lang;

                // AJAX save
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
                            // Soft reload translations
                            setTimeout(() => location.reload(), 400);
                        }
                    });
            });
        });
    });
</script>

@include('partials.footer')
@endsection