@include('backend.auth.layouts.header')
@section('title', 'Email Verification')
    <div class="wrapper">
        <div class="title"><span>Email Verification</span></div>
        <p>Please enter your email address to receive a verification code.</p>

        <form action="{{ route('employee.email.verification.post') }}" method="POST">
            @csrf <!-- CSRF Token for security -->
            <div class="row">
                <input type="email" name="email" placeholder="Enter your email" required
                    value="{{ old('email') }}" />
            </div>

            <div class="row button">
                <input type="submit" value="Send Verification Code" />
            </div>
        </form>

        <div class="row button">
            <a href="{{ route('employee-login') }}" class="login-button">Go to Login</a>
        </div>

    
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

    @include('backend.auth.layouts.footer')
