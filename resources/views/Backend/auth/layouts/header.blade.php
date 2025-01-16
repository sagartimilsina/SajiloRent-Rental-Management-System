
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tuki Soft | @yield('title') </title>
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}" />
    <link rel="icon" href="{{ asset('backend/images/favicon.ico') }}" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('sneat_backend/assets/css/demo.css') }}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Include Boxicons for the eye icon -->

    <!-- Include Boxicons for the eye icon -->

    <style>
        .field {
            position: relative;
            height: 50px;
            width: 100%;
            margin-top: 0px;
            /* Reduced margin-top for input fields */
        }

        .field input {
            height: 100%;
            width: 100%;
            padding: 0 16px;
            /* Add some padding for aesthetics */
            border: 1px solid #CACACA;
            border-radius: 6px;
            outline: none;
        }

        .eye-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            /* Adjust for better positioning */
            transform: translateY(-50%);
            font-size: 18px;
            color: #8b8b8b;
            cursor: pointer;
        }

        .form-link {
            text-align: center;
            margin-top: 10px;
        }

        .form-link a {
            color: #0171d3;
            text-decoration: none;
            font-size: 14px;
        }

        .form-link a:hover {
            text-decoration: underline;
            /* Add underline on hover */
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 400px;
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 50px auto;
            /* Center the wrapper with more margin */
            text-align: center;
            transition: transform 0.3s ease;
        }

        .wrapper:hover {
            transform: scale(1.02);
            /* Slight hover effect */
        }

        .title {
            margin-bottom: 30px;
        }

        .title span {
            font-size: 32px;
            font-weight: 700;
            color: #1AB189;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .row {
            margin-top: 20px;
            position: relative;
        }

        .row input[type="email"],
        .row input[type="submit"] {
            width: 100%;
            height: 50px;
            padding: 0 15px;
            border-radius: 12px;
            border: 1px solid #ddd;
            font-size: 16px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .row input[type="email"]:focus {
            border-color: #1AB189;
            box-shadow: 0 0 8px rgba(26, 177, 137, 0.4);
            outline: none;
        }

        .row input[type="submit"] {
            background: #1AB189;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s ease;
        }

        .row input[type="submit"]:hover {
            background: #17a589;
            transform: translateY(-2px);
            /* Slight lift on hover */
        }

        .row input[type="submit"]:active {
            transform: translateY(0);
            /* Reset lift on click */
        }

        .login-button {
            display: inline-block;
            width: 100%;
            height: 50px;
            background: #ffffff;
            border: 1px solid #1AB189;
            color: #1AB189;
            text-align: center;
            padding-top: 14px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 20px;
            transition: background 0.3s, color 0.3s;
        }

        .login-button:hover {
            background: #1AB189;
            color: #fff;
        }

        .success-message,
        .error-messages {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            font-size: 15px;
        }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .error-messages {
            background: #fdd;
            border: 1px solid red;
            color: red;
        }

        .error-messages ul {
            list-style: none;
            padding: 0;
        }

        .error-messages li {
            margin-bottom: 5px;
        }

        .resend-link {
            color: #1AB189;
            text-decoration: underline;
            cursor: pointer;
        }

        .wrapper {
            max-width: 400px;
            width: 100%;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin: 20px auto;
            /* Center the wrapper */
            text-align: center;
        }

        .title {
            margin-bottom: 20px;
        }

        .title span {
            font-size: 28px;
            font-weight: 600;
            color: #1AB189;
        }

        .otp-inputs {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .otp-input {
            width: 40px;
            /* Adjust width as needed */
            height: 40px;
            /* Adjust height as needed */
            font-size: 24px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: border-color 0.3s;
        }

        .otp-input:focus {
            border-color: #1AB189;
            outline: none;
        }

        .row {
            margin-top: 20px;
        }

        .row input[type="submit"] {
            background: #1AB189;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }

        .row input[type="submit"]:hover {
            background: #17a589;
        }

        .success-message {
            margin-top: 15px;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 8px;
        }

        .error-messages {
            margin-top: 15px;
            background: #fdd;
            border: 1px solid red;
            border-radius: 12px;
            padding: 10px;
            color: red;
            font-size: 14px;
        }

        .error-messages ul {
            list-style: none;
            padding: 0;
        }

        .error-messages li {
            margin-bottom: 5px;
        }

        .resend-link {
            color: #1AB189;
            text-decoration: underline;
            cursor: pointer;
        }

        .bs-toast {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            width: auto;

        }

        .toast {
            position: fixed;
            top: 20px;
            /* Distance from the top of the viewport */
            right: 20px;
            /* Distance from the right of the viewport */
            min-width: 250px;
            /* Minimum width of the toast */
            max-width: 350px;
            /* Maximum width of the toast */
            z-index: 1050;
            /* Ensure it's above other elements */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Shadow effect */
        }

        .toast-header {
            background-color: #007bff;
            /* Blue header background */
            color: white;
            /* White text color */
            padding: 10px;
            /* Padding inside the header */
            border-top-left-radius: 8px;
            /* Round top left corner */
            border-top-right-radius: 8px;
            /* Round top right corner */
        }

        .btn-close {
            background: none;
            /* Remove default button styles */
            border: none;
            /* Remove default button border */
            color: white;
            /* Close button color */
            cursor: pointer;
            /* Pointer cursor on hover */
            font-size: 1.2rem;
            /* Font size for the close button */
        }

        .toast-body {
            padding: 15px;
            /* Padding inside the body */
            background-color: white;
            /* Body background color */
            color: #333;
            /* Text color */
            border-bottom-left-radius: 8px;
            /* Round bottom left corner */
            border-bottom-right-radius: 8px;
            /* Round bottom right corner */
        }

        .toast.show {
            display: block;
            /* Show toast when active */
            opacity: 1;
            /* Fully visible */
            transition: opacity 0.3s ease-in-out;
            /* Smooth transition */
        }

        .toast.hide {
            opacity: 0;
            /* Fade out effect */
            transition: opacity 0.3s ease-in-out;
            /* Smooth transition */
        }
    </style>
</head>

<body>
    <div id="toastMessage" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true"
        style="display: none;">
        
        <div class="toast-body" id="toastBody">

        </div>
    </div>
