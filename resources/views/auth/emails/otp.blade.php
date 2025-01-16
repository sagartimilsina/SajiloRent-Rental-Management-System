<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .otp {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Your OTP Code</h1>
        <p>Hi, {{ $name }}</p>
        <p>Thank you for registering. Here is your OTP code:</p>
        <p class="otp">{{ $otp_code }}</p>
        <p>Please use this code to verify your account.</p>
        <p>Best regards,<br>Sajilo Rent</p>
    </div>
</body>

</html>
