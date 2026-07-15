<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 0; -webkit-text-size-adjust: none; height: 100%; width: 100%; }
    .wrapper { background-color: #f8fafc; padding: 40px 20px; width: 100%; box-sizing: border-box; }
    .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01); border: 1px solid #f1f5f9; }
    .header { text-align: center; margin-bottom: 30px; }
    .logo { width: 64px; height: 64px; background: linear-gradient(135deg, #14b8a6 0%, #059669 100%); border-radius: 18px; display: inline-block; margin-bottom: 24px; line-height: 64px; color: #ffffff; font-size: 28px; font-weight: bold; box-shadow: 0 10px 15px -3px rgba(20, 184, 166, 0.3); text-align: center; }
    h1 { color: #0f172a; font-size: 26px; font-weight: 800; margin: 0 0 20px; text-align: center; letter-spacing: -0.025em; }
    p { font-size: 16px; line-height: 1.6; color: #475569; margin: 0 0 24px; text-align: center; }
    .button-container { text-align: center; margin: 36px 0; }
    .button { display: inline-block; padding: 16px 36px; background: linear-gradient(to right, #14b8a6, #10b981); color: #ffffff !important; text-decoration: none; border-radius: 14px; font-weight: 700; font-size: 16px; box-shadow: 0 10px 15px -3px rgba(20, 184, 166, 0.3); transition: all 0.2s; }
    .footer { text-align: center; font-size: 14px; color: #94a3b8; margin-top: 40px; border-top: 1px solid #f1f5f9; padding-top: 30px; }
    @media only screen and (max-width: 600px) {
        .container { padding: 30px 20px; border-radius: 20px; }
        .wrapper { padding: 20px 10px; }
        h1 { font-size: 22px; }
    }
</style>
</head>
<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="container" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td align="center">
                            <div class="header">
                                <div class="logo">
                                    <span style="font-family: Arial, sans-serif;">🛡️</span>
                                </div>
                            </div>
                            
                            <h1>Verify Your Email Address</h1>
                            
                            <p>Welcome to <strong>{{ config('app.name') }}</strong>! Please verify your email address to get full access to your account and the portal.</p>
                            
                            <div class="button-container">
                                <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
                            </div>
                            
                            <p style="font-size: 14px; color: #64748b;">If you did not create an account, no further action is required.</p>
                            
                            <div class="footer">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>