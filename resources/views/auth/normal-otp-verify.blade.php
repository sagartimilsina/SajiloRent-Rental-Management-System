@include('frontend.layouts.header')
@include('frontend.layouts.navbar')


@section('title', 'OTP Verification')


<div class="container-fluid d-flex justify-content-center align-items-center py-5">
    <div class="card-container w-100">

        <div class="card shadow mx-auto col-12 col-sm-8 col-md-6 col-lg-6 col-xl-4">
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

            <form id="otp-form" method="POST" action="{{ route('verify.otp') }}">
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
                    <a href="{{ route('resend.otp', ['user_id' => $id]) }}" id="resend-button" class="text-primary">
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
