<!-- Page Header (Fixed, Mobile-First) -->
<style>
    .page-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 100;
        background: #fff;
        display: flex;
        align-items: center;
        height: 48px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        padding: 10px 12px;
    }

    .page-header .back-btn {
        display: flex;
        align-items: center;
        margin-right: 8px;
        height: 32px;
        width: 32px;
    }

    .page-header .back-icon {
        width: 22px;
        height: 22px;
    }

    .page-header .page-title {
        flex: 1;
        text-align: center;
        font-size: 17px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .page-header .header-spacer {
        width: 32px;
        height: 32px;
    }

    .page-header-spacer {
        height: 48px;
    }

    @media (max-width: 400px) {
        .page-header {
            height: 44px;
        }

        .page-header-spacer {
            height: 44px;
        }

        .page-header .page-title {
            font-size: 15px;
        }

        .page-header .back-icon {
            width: 18px;
            height: 18px;
        }
    }
</style>
<div class="page-header">
    <a href="{{ url()->previous() }}" class="back-btn" aria-label="Go back">
        <img src="/icons/arrow-left.svg" alt="Back" class="back-icon">
    </a>
    <h1 class="page-title">{{ $title ?? 'Page' }}</h1>
    <div class="header-spacer"></div>
</div>
<div class="page-header-spacer"></div>