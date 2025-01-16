@extends('frontend.layouts.main')
@section('content')
@section('title', 'Register')
<div class="container-fluid d-flex justify-content-center align-items-center p-5">
    <div class="card-container w-100">
        <div class="card shadow p-4 mx-auto col-12 col-sm-8 col-md-6 col-lg-6 col-xl-4">
            <h2 class="text-center text-primary mb-4">Register Your Account</h2>
            @if ($errors->has('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user fa-2x me-2"></i>
                        <input type="text" name="name" class="form-control rounded-full" placeholder="Name"
                            value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <div class="text-danger m-1 mx-5">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope fa-2x me-2"></i>
                        <input type="text" name="email_or_phone" class="form-control rounded-full"
                            placeholder="Email or Phone Number" value="{{ old('email_or_phone') }}">
                    </div>
                    @error('email_or_phone')
                        <div class="text-danger m-1 mx-5">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center position-relative">
                        <i class="fas fa-lock fa-2x me-2"></i>
                        <input type="password" id="password" name="password" class="form-control rounded-full"
                            placeholder="Password">
                        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                            onclick="togglePasswordVisibility('password', 'toggleEye1')">
                            <i class="fas fa-eye" id="toggleEye1"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="text-danger m-1 mx-5">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center position-relative">
                        <i class="fas fa-lock fa-2x me-2"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control rounded-full" placeholder="Confirm Password">
                        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                            onclick="togglePasswordVisibility('password_confirmation', 'toggleEye2')">
                            <i class="fas fa-eye" id="toggleEye2"></i>
                        </span>
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger m-1 mx-5">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div id="recaptcha-container" class="mb-4 d-flex justify-content-center"></div>
                <button type="submit" disabled id="submit"
                    class="btn btn-primary w-100 text-dark rounded-full mb-4 p-2"
                    style="font-size: 18px;">Register</button>
            </form>

            <div class="or-divider mb-4">
                <hr>
                <span>OR</span>
            </div>
            <a href="{{ route('google.login') }}"
                class="btn btn-light rounded-full border w-100 mb-3 d-flex align-items-center justify-content-center p-2 ">
                <i class="fab fa-google fa-2x px-3"></i>
                Login with Google
            </a>
            <div class="text-center">
                <p class="text-muted">Already have an account? <a href="{{ route('login') }}"
                        class="text-primary register-hover text-decoration-none">Login here</a></p>
            </div>
        </div>
    </div>
</div>
<script>
    function togglePasswordVisibility(fieldId, iconId) {
        var passwordField = document.getElementById(fieldId);
        var toggleIcon = document.getElementById(iconId);

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="module">
    import {
        initializeRecaptcha
    } from "{{ asset('firebase.js') }}";

    window.onload = function() {
        initializeRecaptcha();
    };
</script>
@endsection
