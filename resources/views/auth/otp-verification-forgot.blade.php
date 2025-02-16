@include('frontend.layouts.header')
@include('frontend.layouts.navbar')


@section('title', 'OTP Verification')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #008dd2 !important;
        --body-color: #e9f5fb !important;
        --secondary: #FF8000 !important;
        --color-purple: #b69cfc !important;
        --color-light-pink: #f7c6c7 !important;
        --main-primary: #1a2b4c !important;
    }



    body {
        background-color: var(--body-color);

    }




    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        padding: 2rem;
        background-color: #ffffff;
    }

    /* .rounded-full {
    border-radius: 10rem !important;
} */

    .btn-gradient {
        background: linear-gradient(to right, #4299e1, #9f7aea);
        border: none;
    }

    .or-divider {
        position: relative;
        text-align: center;
        margin-top: 0.5rem;
    }

    .or-divider hr {
        border-top: 5px solid;
        border-image: linear-gradient(to right, #4299e1, #9f7aea) 1;
    }

    .or-divider span {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 0 0.5rem;
        color: #4299e1;
        font-weight: bold;
    }

    .text-primary {
        color: var(--main-primary) !important;
    }

    .form-label {
        font-size: 1rem;
        font-weight: bold;
        color: var(--main-primary)
    }

    .form-control,
    .form-select {
        font-size: 1.1rem;
        color: var(--main-primary);
    }

    .form-control:focus {
        border-color: var(--secondary);
        box-shadow: 0 0 0 0.01rem var(--secondary);
    }

    .form-select:focus {
        border-color: var(--secondary);
        box-shadow: 0 0 0 0.01rem var(--secondary);
    }

    /* Button Primary Default State */
    .btn-primary {
        background-color: var(--secondary) !important;
        border: none;
        color: #fff;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease, opacity 0.3s ease, transform 0.1s ease;
    }

    /* Hover State */
    .btn-primary:hover {
        background-color: var(--primary) !important;
        color: #fff !important;
    }

    /* Active State (When clicked) */
    .btn-primary:active {
        background-color: var(--color-light-pink);
        /* A lighter color for pressed state */
        transform: scale(0.96);
        /* Shrink slightly for a "pressed" effect */
    }

    /* Focus State (Keyboard Navigation or Click) */
    .btn-primary:focus {
        outline: none;
        /* Remove default browser outline */
        box-shadow: 0 0 0 4px var(--body-color);
        /* Custom focus indicator */
    }

    .fa-google {
        background: conic-gradient(from -45deg, #ea4335 110deg, #4285f4 90deg 180deg, #34a853 180deg 270deg, #fbbc05 270deg) 73% 55%/150% 150% no-repeat;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        -webkit-text-fill-color: transparent;
    }

    .position-relative {
        position: relative;
    }

    .position-absolute {
        position: absolute;
    }

    .end-0 {
        right: 0;
    }

    .top-50 {
        top: 50%;
    }

    .translate-middle-y {
        transform: translateY(-50%);
    }

    .register-hover:hover {
        color: var(--primary) !important;
        text-decoration: underline !important;
    }

    .fa-2x {
        font-size: 1.5rem !important;
    }


    .otp-input {
        width: 48px;
        height: 48px;
        text-align: center;
        font-size: 24px;
        margin: 0 8px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background-color: #e5e7eb;
    }

    .otp-input:focus {
        background-color: #ffffff;
        border-color: var(--secondary);
        outline: none;
    }

    .btn-gradient {
        background: linear-gradient(to right, #4299e1, #9f7aea);
        color: #fff;
        border-radius: 8px;
        padding: 0.75rem;
        border: none;
    }

    .btn-gradient:hover {
        background: linear-gradient(to right, #9f7aea, #4299e1);
    }

    .timer {
        color: #555;
        font-size: 18px;
        text-align: center;
        margin-bottom: 10px;
    }

    .resend-button {
        cursor: not-allowed;
        opacity: 0.6;
        text-decoration: none;
    }

    .resend-button.enabled {
        cursor: pointer;
        opacity: 1;
        color: var(--primary);
        text-decoration: none;
    }

    .text-danger {
        color: red;
    }

    .text-center p {
        color: #333;
    }

    @media screen and (max-width: 420px) {
        .otp-input-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* .rounded-full {
        width: 100% !important;
    } */

    }

    .navbar {
        background-color: var(--main-primary);
        color: white;
    }

    .navbar-brand {
        color: var(--secondary);
        font-size: 35px;
        font-weight: bold;
    }

    .navbar-nav .nav-link {
        color: #fff;
        font-size: 18px;
        margin-right: 20px;
    }

    .navbar-nav .nav-link:hover {
        color: var(--primary);
        transform: scale(1.1);
        transition: all 0.3s ease-in-out;
    }

    .navbar-nav .dropdown-menu {
        background-color: var(--main-primary);
        border: none;
    }

    .navbar-nav .dropdown-item {
        color: #fff;
    }

    .navbar-nav .dropdown-item:hover {
        color: var(--primary);
    }

    .navbar-nav .nav-link.booking {
        color: var(--secondary);
    }

    .navbar .login-no-hover {
        color: #fff;
    }

    a.btn.btn-outline-warning.login-no-hover:hover {
        background-color: var(--primary) !important;

    }

    a.btn.btn-outline-warning.register-button:hover {
        background-color: var(--primary) !important;
        color: #fff;
    }


    .navbar-search {
        position: absolute;
        right: 0;
        background: var(--main-primary);
        max-width: 100%;
        padding: 10px;
        z-index: 1050;
    }

    .navbar-search input {
        max-width: 600px;
        margin: 0 auto;
        display: block;
    }

    .search-icon:hover {
        background-color: var(--secondary) !important;
    }


    .active-nav {
        color: var(--secondary) !important;
        font-weight: 600;
    }

    @media screen and (max-width: 992px) {
        .navbar .navbar-search-mobile {
            width: 100%;
            display: flex !important;
            justify-content: center;
            margin-top: 10px;
        }

        .search-icon {
            display: none !important;
        }
    }

    /* footer section */
    .footer-section {
        background-color: var(--main-primary);
        color: #fff;
        padding: 40px 0;
    }

    .footer {
        text-align: center;
        margin-top: 20px;
        color: var(--secondary);
    }

    .section-title {
        color: var(--secondary);
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .about-house-rent {
        display: flex;
        align-items: center;

    }

    .about-house-rent img {
        margin-right: 10px;

    }

    .about-house-rent h2 {
        color: var(--secondary);
        font-size: 32px;
        font-weight: bold;
    }

    .place-category ul {
        list-style: none;
        padding: 0;
    }

    .place-category ul li {
        margin-bottom: 10px;
    }


    .place-category ul li a {
        color: #333;
        text-decoration: none;
    }

    .place-category ul li a:hover {
        color: var(--primary) !important;
        transition: all 0.3s ease-in-out;
    }

    /* Scroll-to-Top Button Styles */
    .scroll-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        background-color: var(--secondary);
        /* Blue color */
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
        font-size: 20px;
        z-index: 1000;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
    }

    .scroll-to-top.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .scroll-to-top:hover {
        background-color: var(--primary);
        /* Darker blue on hover */
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        display: none;
        background-color: var(--primary);
        min-width: 200px;
        z-index: 1050;
    }

    .dropdown-menu .dropdown-item {
        padding: 8px 16px;
        white-space: nowrap;
        /* Prevent wrapping */
        text-decoration: none;

    }

    .dropdown-item:hover {
        background-color: #e9ecef;
    }

    .dropdown:hover>.dropdown-menu {
        display: block;
        /* Show menu on hover */
    }

    .dropdown-menu>.dropdown-submenu {
        position: relative;
    }

    .dropdown-menu>.dropdown-submenu>.dropdown-menu {
        position: absolute;
        top: 0;
        left: 100%;
        margin-left: -1px;
        display: none;
    }

    .dropdown-submenu:hover>.dropdown-menu {
        display: block;
    }

    /* Left-aligned dropdown */
    .dropdown-menu.left-align {
        left: auto;
        right: 100%;
    }

    /* product details */

    /* Base styles for dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        display: none;
        background-color: var(--primary);
        min-width: 200px;
        z-index: 1050;
    }

    .dropdown-menu .dropdown-item {
        padding: 8px 16px;
        white-space: nowrap;
        /* Prevent wrapping */
        text-decoration: none;

    }

    .dropdown-item:hover {
        background-color: #e9ecef;
    }

    .dropdown:hover>.dropdown-menu {
        display: block;
        /* Show menu on hover */
    }

    .dropdown-menu>.dropdown-submenu {
        position: relative;
    }

    .dropdown-menu>.dropdown-submenu>.dropdown-menu {
        position: absolute;
        top: 0;
        left: 100%;
        margin-left: -1px;
        display: none;
    }

    .dropdown-submenu:hover>.dropdown-menu {
        display: block;
    }

    /* Left-aligned dropdown */
    .dropdown-menu.left-align {
        left: auto;
        right: 100%;
    }
</style>

<div class="container-fluid d-flex justify-content-center align-items-center py-5">
    <div class="card-container w-100" style="padding: 20px">

        <div class="card shadow mx-auto col-12 col-sm-8 col-md-6 col-lg-6 col-xl-4 ">
            @if (session('error'))
                <div class="alert alert-danger" id="session-alert">
                    {{ session('error') }}
                </div>
            @elseif (session('success'))
                <div class="alert alert-success" id="session-alert">
                    {{ session('success') }}
                </div>
            @endif
            <h2 class="text-center text-primary mb-4">OTP Verification</h2>

            <div id="timer" class="timer text-center text-danger mb-3">02:00</div>

            <form id="otp-form" method="POST" action="{{ route('verify.otp_forgot.post') }}">
                @csrf
                <div class="d-flex justify-content-center mb-3 otp-input-container">
                    <div class="d-flex justify-content-center mb-3 otp-input-container ">
                        <input type="text" maxlength="1" class="otp-input" name="otp_code[]" id="otp-1">
                        <input type="text" maxlength="1" class="otp-input" name="otp_code[]" id="otp-2">
                        <input type="text" maxlength="1" class="otp-input" name="otp_code[]" id="otp-3">
                        <input type="text" maxlength="1" class="otp-input" name="otp_code[]" id="otp-4">
                        <input type="text" maxlength="1" class="otp-input" name="otp_code[]" id="otp-5">
                        <input type="text" maxlength="1" class="otp-input" name="otp_code[]" id="otp-6">
                    </div>

                    <input type="hidden" id="hidden-otp" name="otp_code" />
                </div>

                {{-- Error Messages --}}
                <div id="error-message" class="text-danger text-center mb-3">
                    @if ($errors->has('otp_code'))
                        {{ $errors->first('otp_code') }}
                    @endif


                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-50 rounded-pill">Verify OTP</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <p>Didn't receive the OTP?
                    <a href="{{ route('resend-otp-forgot') }}" id="resend-button" class="text-primary"
                        @disabled(true)>
                        Resend OTP
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Set OTP expiry time
    const expiryTime = new Date('{{ $formattedOtpExpire }}').getTime();

    function updateTimer() {
        const now = new Date().getTime();
        const distance = expiryTime - now;

        if (distance < 0) {
            document.getElementById('timer').innerHTML = "EXPIRED";
            document.getElementById('otp-form').querySelector('button').disabled = true; // Disable the submit button
            document.getElementById('resend-button').classList.add('enabled');
            return;
        }

        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('timer').innerHTML = `${pad(minutes)}:${pad(seconds)}`;
    }

    function pad(number) {
        return number < 10 ? `0${number}` : number;
    }

    setInterval(updateTimer, 1000);

    // Handle OTP input navigation and merge inputs into a single field
    const inputs = document.querySelectorAll('.otp-input');
    const hiddenOtpInput = document.getElementById('hidden-otp'); // Hidden input to hold merged value

    function updateHiddenOtp() {
        const otpValue = Array.from(inputs).map(input => input.value).join('');
        hiddenOtpInput.value = otpValue;
    }

    inputs.forEach((input, index) => {
        input.addEventListener('keyup', (e) => {
            updateHiddenOtp();
            if (e.key === "Backspace" && index > 0) {
                inputs[index - 1].focus();
            } else if (e.key !== "Backspace" && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('input', updateHiddenOtp); // Update on any input change
    });

    // Auto-hide session messages
    setTimeout(() => {
        const alert = document.getElementById('session-alert');
        if (alert) alert.style.display = 'none';
    }, 5000);
</script>

@include('frontend.layouts.footer');
@include('frontend.layouts.script');
