<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your verification code</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .otp-box { background: #f0f4f8; border: 2px dashed #5e72e4; border-radius: 12px; padding: 24px; text-align: center; margin: 24px 0; }
        .otp-code { font-size: 28px; font-weight: 700; letter-spacing: 8px; color: #5e72e4; }
        .footer { margin-top: 32px; font-size: 12px; color: #8898aa; }
    </style>
</head>
<body>
    <p>Hello,</p>
    <p>Use this one-time code to {{ $purpose === 'register' ? 'complete your registration' : 'sign in to your account' }}:</p>
    <div class="otp-box">
        <span class="otp-code">{{ $otp }}</span>
    </div>
    <p>This code expires in <strong>10 minutes</strong>. Do not share it with anyone.</p>
    <p>If you didn't request this code, you can safely ignore this email.</p>
    <div class="footer">
        <p>— HeartWay</p>
    </div>
</body>
</html>
