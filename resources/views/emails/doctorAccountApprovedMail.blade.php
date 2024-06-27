<!-- resources/views/emails/doctorAccountApprovedMail.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header {
            background-color: #f8f8f8;
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .content {
            padding: 20px;
        }
        .button {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Approval Notification</h1>
        </div>
        <div class="content">
            <p>Hello Dr. {{ $mailData['first_name'] }} {{ $mailData['last_name'] }},</p>
            <p>We are pleased to inform you that your request to join our platform has been approved.</p>
            <p>You can now log in to your account and start accessing the features available to you.</p>
            <a href="{{ $mailData['url'] }}" class="button">Log In to Your Account</a>
        </div>
        <div class="footer">
            <p>If you have any questions or need assistance, please contact us at <a href="mailto:support@yourwebsite.com">support@koyl.com</a> or call us at (123) 456-7890.</p>
        </div>
    </div>
</body>
</html>
