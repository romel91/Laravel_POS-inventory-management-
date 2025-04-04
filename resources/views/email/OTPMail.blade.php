<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7ff; text-align: center; padding: 20px; }
        .container { max-width: 480px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        .otp { font-size: 32px; font-weight: bold; color: #ba3d4f; letter-spacing: 5px; }
        .footer { margin-top: 20px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <h2>OSTAD OTP Verification</h2>
        <p>Use the OTP below to verify your email. It is valid for 5 minutes.</p>
        <p class="otp">{{ $otp }}</p>
        <p>Please do not share this code with anyone.</p>
        <p class="footer">Need help? Contact <a href="mailto:support@ostad.com">support@ostad.com</a></p>
        <p class="footer">&copy; {{ date('Y') }} OSTAD. All rights reserved.</p>
    </div>
</body>
</html>