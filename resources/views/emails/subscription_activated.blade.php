<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Subscription Activated</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 40px;">
    <div style="max-width: 600px; background: white; padding: 30px; border-radius: 10px; margin: auto;">
        <h2 style="color: #16a34a;">🎉 Your Premium Membership is Now Active!</h2>

        <p>Hi {{ $user->name }},</p>

        <p>Thank you for subscribing to our Premium plan! Your membership is now active.</p>

        <ul>
            <li><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($user->membership_start)->format('F j, Y') }}</li>
            <li><strong>End Date:</strong> {{ \Carbon\Carbon::parse($user->membership_end)->format('F j, Y') }}</li>
        </ul>

        <p>You can now enjoy full access to all premium features and content.</p>

        <p>— The Team</p>
    </div>
</body>
</html>
