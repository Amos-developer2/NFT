<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code - TradeX</title>
</head>

<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="width: 100%; max-width: 480px; border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding-bottom: 32px;">
                            <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%); border-radius: 16px; display: inline-flex; align-items: center; justify-content: center;">
                                <span style="font-size: 32px;">💎</span>
                            </div>
                            <h1 style="margin: 16px 0 0; font-size: 28px; font-weight: 800; color: #1f2937;">TradeX</h1>
                        </td>
                    </tr>

                    <!-- Main Card -->
                    <tr>
                        <td style="background: #ffffff; border-radius: 24px; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);">
                            <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 40px 32px; text-align: center;">
                                        <!-- Icon -->
                                        <div style="width: 72px; height: 72px; margin: 0 auto 24px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                            <span style="font-size: 36px;">📧</span>
                                        </div>

                                        <!-- Title -->
                                        <h2 style="margin: 0 0 8px; font-size: 24px; font-weight: 700; color: #1f2937;">
                                            Verify Your Email
                                        </h2>
                                        <p style="margin: 0 0 32px; font-size: 15px; color: #6b7280; line-height: 1.5;">
                                            Hi {{ $userName }}, use the code below to complete your registration on TradeX.
                                        </p>

                                        <!-- Verification Code -->
                                        <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 16px; padding: 24px 32px; margin-bottom: 24px;">
                                            <p style="margin: 0 0 8px; font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 1px;">
                                                Verification Code
                                            </p>
                                            <p style="margin: 0; font-size: 40px; font-weight: 800; color: #2563eb; letter-spacing: 8px; font-family: 'Courier New', monospace;">
                                                {{ $code }}
                                            </p>
                                        </div>

                                        <!-- Expiry Notice -->
                                        <p style="margin: 0 0 24px; font-size: 14px; color: #9ca3af;">
                                            This code will expire in <strong style="color: #f59e0b;">15 minutes</strong>
                                        </p>

                                        <!-- Divider -->
                                        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 24px 0;">

                                        <!-- Security Notice -->
                                        <p style="margin: 0; font-size: 13px; color: #9ca3af; line-height: 1.6;">
                                            If you didn't request this code, you can safely ignore this email.
                                            Someone may have entered your email address by mistake.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 32px 20px;">
                            <p style="margin: 0 0 8px; font-size: 14px; color: #6b7280;">
                                © {{ date('Y') }} TradeX. All rights reserved.
                            </p>
                            <p style="margin: 0; font-size: 13px; color: #9ca3af;">
                                Your trusted NFT trading platform
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>