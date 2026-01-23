<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
    <link rel="stylesheet" href="/css/team.css">
    <link rel="stylesheet" href="/css/custom.css">
</head>

<body>
    @include('partials.header', ['title' => 'Team'])
    <div class="mobile-container">
        <!-- Referral Card -->
        <div class="referral-hero-card">
            <div class="referral-hero-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <h2 class="referral-hero-title">Invite Friends & Earn</h2>
            <p class="referral-hero-desc">Share your referral code and earn up to 6 levels of commission</p>

            <div class="referral-code-display">
                <span class="code-label">Your Referral Code</span>
                <span class="code-value">{{ Auth::user()->referral_code }}</span>
            </div>

            <div class="referral-link-container">
                <input type="text" readonly class="referral-link-input" value="{{ Auth::user()->referral_link }}" id="referralLink">
                <button type="button" class="copy-link-btn" onclick="copyReferralLink()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                    </svg>
                    <span>Copy</span>
                </button>
            </div>

            <div class="share-buttons">
                <button type="button" class="share-btn whatsapp" onclick="shareWhatsApp()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                </button>
                <button type="button" class="share-btn telegram" onclick="shareTelegram()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                    </svg>
                </button>
                <button type="button" class="share-btn twitter" onclick="shareTwitter()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                    </svg>
                </button>
                <button type="button" class="share-btn copy" onclick="copyReferralLink()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="summary-stats">
            <div class="summary-item">
                <span class="summary-value">{{ $totalTeam }}</span>
                <span class="summary-label">Total Team</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-item">
                <span class="summary-value">{{ $totalActive }}</span>
                <span class="summary-label">Active</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-item">
                <span class="summary-value">${{ number_format($totalDeposits, 0) }}</span>
                <span class="summary-label">Deposits</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-item">
                <span class="summary-value">${{ number_format($totalCommission, 2) }}</span>
                <span class="summary-label">Commission</span>
            </div>
        </div>

        <!-- Commission Rates Info -->
        <div class="commission-info">
            <div class="commission-header">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 16v-4" />
                    <path d="M12 8h.01" />
                </svg>
                <span>Commission Rates</span>
            </div>
            <div class="commission-rates">
                <span class="rate">L1: 16%</span>
                <span class="rate">L2: 8%</span>
                <span class="rate">L3: 4%</span>
                <span class="rate">L4: 2%</span>
                <span class="rate">L5: 1%</span>
                <span class="rate">L6: 0.5%</span>
            </div>
        </div>

        <!-- Level Tabs (2 columns per row) -->
        <div class="level-tabs-container">
            <div class="level-tabs">
                @for($i = 1; $i <= 6; $i+=2)
                    <div style="display: contents;">
                    <button class="level-tab {{ $i === 1 ? 'active' : '' }}" data-level="{{ $i }}">
                        <span class="level-num">L{{ $i }}</span>
                        <span class="level-count">{{ $levels[$i]['total'] }}</span>
                    </button>
                    @if($i+1 <= 6)
                        <button class="level-tab" data-level="{{ $i+1 }}">
                        <span class="level-num">L{{ $i+1 }}</span>
                        <span class="level-count">{{ $levels[$i+1]['total'] }}</span>
                        </button>
                        @endif
            </div>
            @endfor
        </div>
    </div>

    <!-- Level Content Panels -->
    @for($i = 1; $i <= 6; $i++)
        <div class="level-panel {{ $i === 1 ? '' : 'hidden' }}" id="level-{{ $i }}-panel">
        <!-- Level Stats -->
        <div class="level-stats-grid">
            <div class="level-stat-card">
                <div class="level-stat-icon members">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="level-stat-info">
                    <span class="level-stat-value">{{ $levels[$i]['total'] }}</span>
                    <span class="level-stat-label">Members</span>
                </div>
            </div>
            <div class="level-stat-card">
                <div class="level-stat-icon active">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="level-stat-info">
                    <span class="level-stat-value">{{ $levels[$i]['active'] }}</span>
                    <span class="level-stat-label">Active</span>
                </div>
            </div>
            <div class="level-stat-card">
                <div class="level-stat-icon deposits">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </div>
                <div class="level-stat-info">
                    <span class="level-stat-value">${{ number_format($levels[$i]['deposits'], 0) }}</span>
                    <span class="level-stat-label">Deposits</span>
                </div>
            </div>
            <div class="level-stat-card">
                <div class="level-stat-icon commission">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </div>
                <div class="level-stat-info">
                    <span class="level-stat-value">${{ number_format($levels[$i]['commission'], 2) }}</span>
                    <span class="level-stat-label">Commission</span>
                </div>
            </div>
        </div>

        <!-- Members List -->
        <div class="members-list">
            <div class="list-header">
                <h3>Level {{ $i }} Members</h3>
                <span class="list-count">{{ $levels[$i]['total'] }} members</span>
            </div>

            @forelse($levels[$i]['users'] as $user)
            <div class="member-card">
                <div class="member-avatar">
                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                <div class="member-info">
                    <span class="member-name">{{ $user->name }}</span>
                    <span class="member-date">Joined {{ $user->created_at->format('M d, Y') }}</span>
                    @if($i > 1 && $user->referrer)
                    <span class="member-referrer">Via: {{ $user->referrer->name }}</span>
                    @endif
                </div>
                <div class="member-meta">
                    <span class="member-deposit">${{ number_format($user->total_deposits ?? 0, 0) }}</span>
                    <span class="member-status {{ $user->isActive() ? 'active' : 'inactive' }}">
                        {{ $user->isActive() ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <p>No Level {{ $i }} members yet</p>
                <span>{{ $i === 1 ? 'Share your code to invite friends!' : 'Members will appear as your team grows' }}</span>
            </div>
            @endforelse
        </div>
        </div>
        @endfor

        <div class="pb-20"></div>
        </div>

        @include('partials.footer')

        <script>
            // Level tab switching
            document.querySelectorAll('.level-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    const level = this.dataset.level;

                    // Update active tab
                    document.querySelectorAll('.level-tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Show corresponding panel
                    document.querySelectorAll('.level-panel').forEach(panel => panel.classList.add('hidden'));
                    document.getElementById('level-' + level + '-panel').classList.remove('hidden');
                });
            });

            // Copy referral link
            function copyReferralLink() {
                const input = document.getElementById('referralLink');
                input.select();
                input.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(input.value);

                const btn = document.querySelector('.copy-link-btn span');
                if (btn) {
                    const originalText = btn.textContent;
                    btn.textContent = 'Copied!';
                    setTimeout(() => {
                        btn.textContent = originalText;
                    }, 2000);
                }
            }

            // Share functions
            function shareWhatsApp() {
                const text = "Join VortexNFT - The best NFT trading platform! Use my referral code: {{ Auth::user()->referral_code }}\n" + document.getElementById('referralLink').value;
                window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
            }

            function shareTelegram() {
                const text = "Join VortexNFT - The best NFT trading platform! Use my referral code: {{ Auth::user()->referral_code }}";
                const url = document.getElementById('referralLink').value;
                window.open('https://t.me/share/url?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text), '_blank');
            }

            function shareTwitter() {
                const text = "Join VortexNFT - The best NFT trading platform! Use my referral code: {{ Auth::user()->referral_code }}";
                const url = document.getElementById('referralLink').value;
                window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text) + '&url=' + encodeURIComponent(url), '_blank');
            }
        </script>
</body>

</html>