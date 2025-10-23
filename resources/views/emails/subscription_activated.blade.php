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

        <p>Thank you for subscribing to our <strong>Premium Plan</strong>! Your membership is now active.</p>

        <div style="background: #f0fdf4; padding: 15px 20px; border-left: 5px solid #16a34a; margin: 20px 0;">
            <p><strong>Membership Start Date:</strong> {{ $startDate }}</p>
            <p><strong>Membership End Date:</strong> {{ $endDate }}</p>
        </div>

        <p>You now have full access to all <strong>premium lectures, courses, and content</strong>.</p>

        <p>May Allah bless your learning journey 🌙</p>

        <p style="margin-top: 30px;">— The Learn Islam Team</p>
    </div>
</body>
</html>
