@include('backend.auth.layouts.header')
@section('title', 'Customer OTP Verification')
    <div class="wrapper">
        <div class="title"><span>OTP Verification</span></div>
        <p>Please enter the 6-digit OTP sent to your email address.</p>

        <form id="otpForm" action="{{ route('customer.otp.verification.post') }}" method="POST">
            @csrf <!-- CSRF Token for security -->

            <div class="otp-inputs">
                <input type="text" id="otp1" maxlength="1" required class="otp-input" />
                <input type="text" id="otp2" maxlength="1" required class="otp-input" />
                <input type="text" id="otp3" maxlength="1" required class="otp-input" />
                <input type="text" id="otp4" maxlength="1" required class="otp-input" />
                <input type="text" id="otp5" maxlength="1" required class="otp-input" />
                <input type="text" id="otp6" maxlength="1" required class="otp-input" />
            </div>

            <!-- Hidden input field to store the full OTP code -->
            <input type="hidden" id="otp_code" name="otp_code">

            <div class="row button">
                <input type="submit" value="Verify OTP" />
            </div>

            <div class="row">
                <p>Didn't receive the OTP? <a href="{{ route('customer.resend.otp') }}" class="resend-link">Resend</a>
                </p>
            </div>
        </form>
        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <style>
        /* Your existing CSS */
    </style>

    <script>
        // Auto-focus on the next input field
        document.querySelectorAll('.otp-input').forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < 5) {
                    document.querySelectorAll('.otp-input')[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && index > 0 && input.value === '') {
                    document.querySelectorAll('.otp-input')[index - 1].focus();
                }
            });
        });

        // Concatenate OTP values into the hidden input field before submitting the form
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            const otp1 = document.getElementById('otp1').value;
            const otp2 = document.getElementById('otp2').value;
            const otp3 = document.getElementById('otp3').value;
            const otp4 = document.getElementById('otp4').value;
            const otp5 = document.getElementById('otp5').value;
            const otp6 = document.getElementById('otp6').value;

            // Merge OTP inputs into one string and assign it to the hidden input
            document.getElementById('otp_code').value = otp1 + otp2 + otp3 + otp4 + otp5 + otp6;
        });
    </script>
@include('backend.auth.layouts.footer');
