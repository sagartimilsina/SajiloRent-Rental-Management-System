<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Sajio Rent - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    @php
        // List of routes for authentication-related pages
        $authRoutes = ['login', 'register', 'forgot-password', 'otp'];
    @endphp

    @if (Request::routeIs($authRoutes))
        {{-- Load CSS for authentication pages --}}
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css') }}">
    @else
        {{-- Load CSS for other pages --}}
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <style>
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


        .bs-toast {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            width: auto;
            color:transparent;

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
