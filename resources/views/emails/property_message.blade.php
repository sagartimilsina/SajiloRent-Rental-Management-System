<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Message Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            color: #333333;
        }

        .content h2 {
            color: #007bff;
            font-size: 20px;
            margin-top: 0;
        }

        .content p {
            font-size: 16px;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            padding: 15px 20px;
            background-color: #f4f4f4;
            color: #555555;
            font-size: 14px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        a {
            text-decoration: none;
            color: #f4f4f4;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>New Message about your Property</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user_name }},</p>
            <p>You have received a new message regarding your property titled "<strong>{{ $property_name }}</strong>".
            </p>
            <p><strong>Subject:</strong> {{ $subject }}</p>
            <p><strong>Message:</strong></p>
            <p>{{ $message_content }}</p>
            <p>To view and manage this message, please log in to your account:</p>
            <p><a href="{{ $loginRoute }}" class="button" style="color: #fff!important">Login to your Account</a></p>
        </div>
        <div class="footer">
            <p>Sajilo Rent Organization, Nepal</p>
            <p>If you have any queries, please feel free to contact us.</p>
            <p>
                <a href="tel:+9779819113548">📞+977 9819113548</a> |
                <a href="mailto:support_rent@gmail.com">✉️ support_rent@gmail.com</a>
            </p>
        </div>
    </div>
</body>

</html>
