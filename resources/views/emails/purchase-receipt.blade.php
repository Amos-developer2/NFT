<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #2A6CF6;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2A6CF6;
            margin: 0 0 5px;
            font-size: 28px;
        }
        .header p {
            color: #666;
            margin: 0;
            font-size: 14px;
        }
        .receipt-number {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 4px;
            font-family: monospace;
            font-weight: 600;
            color: #2A6CF6;
            text-align: center;
            margin: 15px 0;
        }
        .section {
            margin: 20px 0;
            padding: 20px;
            background: #f8fafc;
            border-radius: 6px;
        }
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }
        .nft-info {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .nft-image {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
        }
        .nft-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .nft-details {
            flex: 1;
        }
        .nft-name {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }
        .nft-rarity {
            display: inline-block;
            padding: 3px 8px;
            background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
            color: #fff;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .nft-id {
            font-size: 12px;
            color: #64748b;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }
        .info-value {
            color: #1e293b;
            font-size: 13px;
            font-weight: 600;
        }
        .price-section {
            background: linear-gradient(135deg, #2A6CF6 0%, #3B8CFF 100%);
            color: #fff;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
        }
        .price-label {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        .price-amount {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
        }
        .price-currency {
            font-size: 14px;
            opacity: 0.9;
            margin-left: 8px;
        }
        .buyer-info {
            margin: 15px 0;
        }
        .buyer-name {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 3px;
        }
        .buyer-email {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #2A6CF6, #3B8CFF);
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>✅ Purchase Confirmed</h1>
            <p>Your NFT purchase has been completed successfully</p>
        </div>

        <!-- Receipt Number -->
        <div class="receipt-number">
            Receipt #{{ $receipt->receipt_number }}
        </div>

        <!-- NFT Details -->
        <div class="section">
            <div class="section-title">🎨 NFT Details</div>
            <div class="nft-info">
                <div class="nft-image">
                    <img src="{{ $nft->image }}" alt="{{ $nft->name }}">
                </div>
                <div class="nft-details">
                    <div class="nft-name">{{ $nft->name }}</div>
                    <span class="nft-rarity">{{ $nft->rarity }}</span>
                    <div class="nft-id">#{{ $nft->id }}</div>
                </div>
            </div>
        </div>

        <!-- Purchase Details -->
        <div class="section">
            <div class="section-title">📋 Purchase Details</div>
            <div class="info-row">
                <span class="info-label">Purchase Date</span>
                <span class="info-value">{{ $receipt->created_at->format('M d, Y H:i A') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="status-badge">{{ strtoupper($receipt->status) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Method</span>
                <span class="info-value">{{ $receipt->payment_method }}</span>
            </div>
        </div>

        <!-- Price Section -->
        <div class="price-section">
            <div class="price-label">Total Amount Paid</div>
            <div>
                <span class="price-amount">{{ number_format($receipt->amount, 2) }}</span>
                <span class="price-currency">USDT</span>
            </div>
        </div>

        <!-- Buyer Info -->
        <div class="section">
            <div class="section-title">👤 Buyer Information</div>
            <div class="buyer-info">
                <div class="buyer-name">Name:</div>
                <div class="buyer-email">{{ $user->name }}</div>
            </div>
            <div class="buyer-info">
                <div class="buyer-name">Email:</div>
                <div class="buyer-email">{{ $user->email }}</div>
            </div>
        </div>

        <!-- Action Button -->
        <div style="text-align: center;">
            <a href="{{ route('collection') }}" class="button">View Your NFTs</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>📌 Keep this email for your records. This receipt serves as proof of your NFT purchase.</p>
            <p style="margin-top: 10px; color: #94a3b8;">
                If you have any questions, please contact our support team.
            </p>
        </div>
    </div>
</body>
</html>
