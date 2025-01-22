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
        $authRoutes = ['login', 'register', 'forgot-password', 'otp', 'change.password'];
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
        .toast {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            min-width: 250px;
            max-width: 350px;
            z-index: 9999;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

        }

        .toast-body {
            padding: 20px;
            background-color: {{ session('success') ? '#28a745' : '#dc3545' }};
            color: {{ session('success') ? '#fff' : '#fff' }};
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
        }

        .toast.show {
            display: block;
            opacity: 1;
            transition: opacity 0.3s ease-in-out;

        }

        .toast.hide {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .loader-wrapper {

            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
      
    </style>


</head>

<body >
    <div id="toastMessage" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true"
        style="display: none;">
        <div class="toast-body" id="toastBody">
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button id="scrollToTopBtn" class="scroll-to-top" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>


    {{-- <div class="loader-wrapper" id="loader-wrapper" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div> --}}



   