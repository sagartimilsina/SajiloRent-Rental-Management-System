<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Rejection Notice</title>
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
            background-color: #d9534f;
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
            color: #d9534f;
            font-size: 20px;
            margin-top: 0;
        }

        .content p {
            font-size: 16px;
            line-height: 1.5;
        }

        .content strong {
            color: #333333;
        }

        .footer {
            text-align: center;
            padding: 15px 20px;
            background-color: #f4f4f4;
            color: #555555;
            font-size: 14px;
        }

        .footer a {
            color: #d9534f;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Application Rejection Notice</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            <p>We regret to inform you that your application to become an owner has been rejected. Please find the
                details below:</p>
            <p><strong>Reason for Rejection:</strong></p>
            <p>{!! $request_status->reason !!}</p>
            <p>If you have any questions or need further clarification, please feel free to contact us. We value your
                interest and encourage you to address the provided reason and reapply in the future if applicable.</p>
            <p>Thank you for understanding.</p>
        </div>
        <div class="footer">
            <p>Sajilo Rent Organization, Nepal</p>
            <p>If you have any queries, please feel free to contact us.</p>
            <p>
                <a href="tel:+9779819113548">📞 +977 9819113548</a> |
                <a href="mailto:support_rent@gmail.com">✉️ support_rent@gmail.com</a>
            </p>
        </div>
    </div>
</body>

</html>
