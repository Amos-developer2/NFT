<!-- Native App Alert System -->
<style>
    /* Native App Alert Overlay */
    .native-alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease-out;
        padding: 20px;
    }
    .native-alert-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    /* Alert Container */
    .native-alert {
        background: #fff;
        border-radius: 14px;
        width: 100%;
        max-width: 270px;
        overflow: hidden;
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    .native-alert-overlay.active .native-alert {
        transform: scale(1);
        opacity: 1;
    }
    
    /* Alert Content */
    .native-alert-content {
        padding: 20px 16px 16px;
        text-align: center;
    }
    
    /* Alert Icon */
    .native-alert-icon {
        width: 44px;
        height: 44px;
        margin: 0 auto 12px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .native-alert-icon.info {
        background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
    }
    .native-alert-icon.success {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
    }
    .native-alert-icon.error {
        background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
    }
    .native-alert-icon.warning {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    }
    .native-alert-icon svg {
        width: 22px;
        height: 22px;
        color: #fff;
        stroke: #fff;
        fill: none;
    }
    
    /* Alert Title */
    .native-alert-title {
        font-size: 17px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 6px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    
    /* Alert Message */
    .native-alert-message {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.4;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    
    /* Alert Actions */
    .native-alert-actions {
        display: flex;
        border-top: 1px solid #e5e7eb;
    }
    .native-alert-btn {
        flex: 1;
        padding: 12px 8px;
        font-size: 17px;
        font-weight: 400;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: background 0.15s;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .native-alert-btn:active {
        background: #f3f4f6;
    }
    .native-alert-btn.primary {
        color: #3b82f6;
        font-weight: 600;
    }
    .native-alert-btn.cancel {
        color: #6b7280;
        border-right: 1px solid #e5e7eb;
    }
    .native-alert-btn.danger {
        color: #ef4444;
        font-weight: 600;
    }
    
    /* Confirm Dialog with two buttons */
    .native-alert-actions.confirm {
        display: flex;
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .native-alert {
            background: #1f2937;
        }
        .native-alert-title {
            color: #f9fafb;
        }
        .native-alert-message {
            color: #9ca3af;
        }
        .native-alert-actions {
            border-top-color: #374151;
        }
        .native-alert-btn:active {
            background: #374151;
        }
        .native-alert-btn.cancel {
            color: #9ca3af;
            border-right-color: #374151;
        }
    }
</style>

<!-- Alert Container -->
<div class="native-alert-overlay" id="nativeAlertOverlay">
    <div class="native-alert" id="nativeAlert">
        <div class="native-alert-content">
            <div class="native-alert-icon info" id="nativeAlertIcon">
                <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
            </div>
            <div class="native-alert-title" id="nativeAlertTitle">Alert</div>
            <div class="native-alert-message" id="nativeAlertMessage"></div>
        </div>
        <div class="native-alert-actions" id="nativeAlertActions">
            <button class="native-alert-btn primary" id="nativeAlertOk">OK</button>
        </div>
    </div>
</div>

<script>
    // Native App Alert System
    (function() {
        // Check if already initialized
        if (window.nativeAlertInitialized) return;
        window.nativeAlertInitialized = true;
        
        const overlay = document.getElementById('nativeAlertOverlay');
        const alertBox = document.getElementById('nativeAlert');
        const icon = document.getElementById('nativeAlertIcon');
        const title = document.getElementById('nativeAlertTitle');
        const message = document.getElementById('nativeAlertMessage');
        const actions = document.getElementById('nativeAlertActions');
        
        let resolvePromise = null;
        
        const icons = {
            info: `<svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>`,
            success: `<svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>`,
            error: `<svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>`,
            warning: `<svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>`
        };
        
        function closeAlert(result = true) {
            overlay.classList.remove('active');
            if (resolvePromise) {
                resolvePromise(result);
                resolvePromise = null;
            }
        }
        
        // Close on overlay click
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeAlert(false);
            }
        });
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay.classList.contains('active')) {
                closeAlert(false);
            }
        });
        
        // Show alert function
        window.nativeAlert = function(msg, options = {}) {
            return new Promise((resolve) => {
                resolvePromise = resolve;
                
                const type = options.type || 'info';
                const alertTitle = options.title || 'Notice';
                const confirmText = options.confirmText || 'OK';
                const showCancel = options.showCancel || false;
                const cancelText = options.cancelText || 'Cancel';
                const isDanger = options.danger || false;
                const isHtml = options.html || false;
                
                // Set icon
                icon.className = 'native-alert-icon ' + type;
                icon.innerHTML = icons[type] || icons.info;
                
                // Set content
                title.textContent = alertTitle;
                if (isHtml) {
                    message.innerHTML = msg;
                } else {
                    message.textContent = msg;
                }
                
                // Set actions
                if (showCancel) {
                    actions.innerHTML = `
                        <button class="native-alert-btn cancel" onclick="window.closeNativeAlert(false)">${cancelText}</button>
                        <button class="native-alert-btn ${isDanger ? 'danger' : 'primary'}" onclick="window.closeNativeAlert(true)">${confirmText}</button>
                    `;
                    actions.classList.add('confirm');
                } else {
                    actions.innerHTML = `
                        <button class="native-alert-btn primary" onclick="window.closeNativeAlert(true)">${confirmText}</button>
                    `;
                    actions.classList.remove('confirm');
                }
                
                // Show alert
                overlay.classList.add('active');
                
                // Focus the primary button
                setTimeout(() => {
                    const primaryBtn = actions.querySelector('.primary, .danger');
                    if (primaryBtn) primaryBtn.focus();
                }, 100);
            });
        };
        
        window.closeNativeAlert = closeAlert;
        
        // Override native alert
        const originalAlert = window.alert;
        window.alert = function(msg) {
            return nativeAlert(msg, { type: 'info', title: 'Notice' });
        };
        
        // Override native confirm
        const originalConfirm = window.confirm;
        window.confirm = function(msg) {
            return nativeAlert(msg, {
                type: 'warning',
                title: 'Confirm',
                showCancel: true,
                confirmText: 'OK',
                cancelText: 'Cancel'
            });
        };
        
        // Convenience methods
        window.nativeSuccess = function(msg, title = 'Success') {
            return nativeAlert(msg, { type: 'success', title: title });
        };
        
        window.nativeError = function(msg, title = 'Error') {
            return nativeAlert(msg, { type: 'error', title: title });
        };
        
        window.nativeWarning = function(msg, title = 'Warning') {
            return nativeAlert(msg, { type: 'warning', title: title });
        };
        
        window.nativeConfirm = function(msg, options = {}) {
            return nativeAlert(msg, {
                type: options.type || 'warning',
                title: options.title || 'Confirm',
                showCancel: true,
                confirmText: options.confirmText || 'Yes',
                cancelText: options.cancelText || 'Cancel',
                danger: options.danger || false
            });
        };
    })();
</script>
