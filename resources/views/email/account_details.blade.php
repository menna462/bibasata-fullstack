<!DOCTYPE html>
<html>
<head>
    <title>Your Subscription Account Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
        }
        .details p {
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Your Subscription Account Details</h2>
        </div>
        <div class="content">
            <p>Dear {{ $userName }},</p>
            <p>Thank you for your purchase! Your order #{{ $order->id }} has been successfully processed.</p>
            <p>Here are the details for your {{ $productName }} subscription:</p>

            <div class="details">
                <p><strong>Service:</strong> {{ $productName }}</p>
                <p><strong>Duration:</strong> {{ $durationInDays }} Days</p>
                <p><strong>Start Date:</strong> {{ $startDate }}</p>
                <p><strong>End Date:</strong> {{ $endDate }}</p>
                <p><strong>Account Email:</strong> <code>{{ $accountEmail }}</code></p>
                <p><strong>Account Password:</strong> <code>{{ $accountPassword }}</code></p>
            </div>

            <p>Please keep these details safe. If you have any questions, feel free to contact our support team.</p>
            <p>Best regards,</p>
            <p>Your Company Name</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
