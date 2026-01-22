<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Code - VortexNFT</title>
</head>

<body style="margin:0;padding:0;font-family:Segoe UI,Arial,sans-serif;background:#f3f4f6;">
    <table role="presentation" style="width:100%;border-collapse:collapse;">
        <tr>
            <td align="center" style="padding:40px 0;">
                <table role="presentation" style="width:100%;max-width:480px;border-collapse:collapse;background:#fff;border-radius:24px;box-shadow:0 4px 24px rgba(0,0,0,0.08);">
                    <tr>
                        <td align="center" style="padding:32px 24px 0 24px;">
                            <img src="https://vortexnft.com/images/vortex.png" alt="VortexNFT" style="width:56px;height:56px;border-radius:12px;box-shadow:0 2px 8px #60a5fa33;">
                            <h1 style="margin:16px 0 0;font-size:26px;font-weight:800;color:#2563eb;">VortexNFT</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 24px;text-align:center;">
                            <div style="margin-bottom:18px;font-size:16px;color:#374151;">
                                Hello <strong>{{ $userName }}</strong>,<br>
                                Your email is being used to register on VortexNFT.
                            </div>
                            <div style="background:linear-gradient(135deg,#eff6ff 0%,#dbeafe 100%);border-radius:16px;padding:20px 0;margin-bottom:18px;">
                                <div style="font-size:13px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:1px;">Verification Code</div>
                                <div style="font-size:38px;font-weight:800;color:#2563eb;letter-spacing:8px;font-family:'Courier New',monospace;">{{ $code }}</div>
                            </div>
                            <div style="font-size:14px;color:#9ca3af;margin-bottom:18px;">
                                This code will expire in <strong style="color:#f59e0b;">15 minutes</strong>.<br>
                                Please do not share this code with anyone.
                            </div>
                            <hr style="border:none;border-top:1px solid #e5e7eb;margin:24px 0;">
                            <div style="font-size:13px;color:#9ca3af;line-height:1.6;">
                                If you did not request this code, you can safely ignore this email.<br>
                                Someone may have entered your email address by mistake.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:24px 20px;">
                            <p style="margin:0 0 8px;font-size:14px;color:#6b7280;">© {{ date('Y') }} VortexNFT. All rights reserved.</p>
                            <p style="margin:0;font-size:13px;color:#9ca3af;">Your trusted NFT trading platform</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>