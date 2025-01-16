<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Owner Request</title>
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
            background-color: #28a745;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            color: #333333;
        }

        .content h2 {
            color: #28a745;
        }

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f4f4f4;
            color: #777777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>New Request to Become an Owner</h1>
        </div>
        <div class="content">
            <h2>Details</h2>
            <p><strong>Name:</strong> {{ $data['full_name'] }}</p>
            <p><strong>Email:</strong> {{ $data['email_address'] }}</p>
            <p><strong>Phone:</strong> {{ $data['phone_number'] }}</p>
            <p><strong>Address:</strong> {{ $data['residential_address'] }}</p>
            <p><strong>National ID:</strong> {{ $data['national_id'] }}</p>
            @if (!empty($data['business_name']))
                <p><strong>Business Name:</strong> {{ $data['business_name'] }}</p>
            @endif

        </div>
        <div class="footer">
            <p>Sajilo Rent Team</p>
        </div>
    </div>
</body>

</html>
