<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for requesting for a become owner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
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
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Thank You for requesting for a become owner</h1>
        </div>
        <div class="content">
            <h2></h2>
            <p>Dear {{ $data['full_name'] }},</p>
            <p>"Thank you for your interest in becoming an owner with us. We have received your request and our team is currently reviewing your application. Upon successful verification, your application will be approved. You will be notified of the outcome via email or phone shortly. We appreciate your patience and look forward to partnering with you."</p>

        </div>
        <div class="footer">
            <p>Sajilo Rent Organization, Nepal </p>
            <p>If you have any queries, please feel free to contact us.</p>
            <p>
                <a href="tel:+9779819113548">📞+977 9819113548</a> |
                <a href="mailto:support_rent@gmail.com">✉️ support_rent@gmail.com</a>
            </p>
        </div>
    </div>
</body>

</html>
