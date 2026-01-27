<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt {{ $receipt->receipt_number }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2A6CF6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2A6CF6;
            margin: 0 0 5px;
        }
        .header p {
            color: #666;
            margin: 0;
            font-family: monospace;
            font-size: 14px;
            font-weight: 600;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 8px 0;
        }
        .row-label {
            color: #666;
            font-size: 14px;
        }
        .row-value {
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
        }
        .nft-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .nft-name {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }
        .nft-meta {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
        }
        .nft-rarity {
            display: inline-block;
            padding: 4px 10px;
            background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
            color: #fff;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .amount-box {
            background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .amount-label {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 8px;
        }
        .amount-value {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -1px;
        }
        .amount-currency {
            font-size: 14px;
            opacity: 0.9;
            margin-left: 8px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
        .timestamp {
            color: #999;
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Purchase Receipt ✓</h1>
            <p>{{ $receipt->receipt_number }}</p>
        </div>

        <!-- NFT Section -->
        <div class="section">
            <div class="section-title">🎨 NFT Details</div>
            <div class="nft-info">
                <div class="nft-name">{{ $receipt->nft->name }}</div>
                <div class="nft-meta">#{{ $receipt->nft->id }} · Rarity: <span class="nft-rarity">{{ $receipt->nft->rarity }}</span></div>
            </div>
        </div>

        <!-- Amount Section -->
        <div class="amount-box">
            <div class="amount-label">Total Amount Paid</div>
            <div class="amount-value">
                {{ number_format($receipt->amount, 2) }}
                <span class="amount-currency">USDT</span>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="section">
            <div class="section-title">📋 Transaction Details</div>
            <div class="row">
                <span class="row-label">Status</span>
                <span class="row-value">{{ ucfirst($receipt->status) }}</span>
            </div>
            <div class="row">
                <span class="row-label">Payment Method</span>
                <span class="row-value">{{ $receipt->payment_method }}</span>
            </div>
            <div class="row">
                <span class="row-label">Purchase Date</span>
                <span class="row-value">{{ $receipt->created_at->format('M d, Y H:i A') }}</span>
            </div>
        </div>

        <!-- Buyer Information -->
        <div class="section">
            <div class="section-title">👤 Buyer Information</div>
            <div class="row">
                <span class="row-label">Name</span>
                <span class="row-value">{{ $receipt->user->name }}</span>
            </div>
            <div class="row">
                <span class="row-label">Email</span>
                <span class="row-value">{{ $receipt->user->email }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>📌 This is your official purchase receipt. Please keep this for your records.</p>
            <p>Generated on {{ now()->format('M d, Y H:i A') }}</p>
        </div>
    </div>
</body>
</html>
