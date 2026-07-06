<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Customfly trial ends in 3 days</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f8fafc; margin: 0; padding: 40px 20px;">
    <div style="max-width: 520px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.07);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #6366f1, #8b5cf6); padding: 32px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 1.4rem; font-weight: 800;">&#9203; Trial Ending Soon</h1>
        </div>

        <!-- Body -->
        <div style="padding: 32px;">
            <p style="margin: 0 0 16px; color: #374151; font-size: 1rem;">
                Hi <strong>{{ $client->name }}</strong>,
            </p>
            <p style="margin: 0 0 16px; color: #374151; line-height: 1.6;">
                Your Customfly free trial will end in <strong>3 days</strong> &mdash; on
                <strong>{{ $client->trial_ends_at->format('d F Y') }}</strong>.
            </p>
            <p style="margin: 0 0 24px; color: #374151; line-height: 1.6;">
                To continue using all features without interruption, please approve your billing before the trial ends.
            </p>

            <!-- CTA Button -->
            <div style="text-align: center; margin-bottom: 32px;">
                <a
                    href="{{ env('SHOPIFY_APP_URL', 'https://custom.local') }}/app/plans"
                    style="display: inline-block; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 1rem;"
                >
                    Manage My Plan &rarr;
                </a>
            </div>

            <p style="margin: 0; color: #9ca3af; font-size: 0.85rem; line-height: 1.5;">
                If you have questions, reply to this email or visit our support center.
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #f8fafc; padding: 20px 32px; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0; color: #9ca3af; font-size: 0.75rem; text-align: center;">
                &copy; {{ date('Y') }} Customfly. You're receiving this because you started a free trial.
            </p>
        </div>
    </div>
</body>
</html>
