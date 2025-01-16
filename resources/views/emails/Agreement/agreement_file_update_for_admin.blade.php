<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Agreement Updated</title>
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
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>User Agreement Updated</h1>
        </div>
        <div class="content">
            <p>Dear Admin,</p>
            <p>User <strong>{{ $user_name }}</strong> (Email: {{ $user_email }}) has updated their agreement file.</p>
            
            <p>Please review the updated agreement in the admin panel.</p>
        </div>
        <div class="footer">
            <p>Thank you,</p>
            <p>Sajilo Rent Organization</p>
        </div>
    </div>
</body>
</html>
