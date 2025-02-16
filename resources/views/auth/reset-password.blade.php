@extends('frontend.layouts.main')
@section('content')
@section('title', 'Reset Password')
<div class="container d-flex justify-content-center align-items-center ">
    <div class="card-container w-100">
        <div class="card shadow m-5 mx-auto col-12 col-sm-8 col-md-6 col-lg-6 ">
            <h2 class="text-center text-primary mb-4">Reset Your Password</h2>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            

            <form method="POST" action="{{ route('reset-password.post') }}">
                @csrf

                <input type="hidden" name="email" value="{{ session('email') }}">
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center position-relative">
                        <i class="fas fa-lock fa-2x me-2"></i>
                        <input type="password" id="new_password" name="new_password" class="form-control rounded-full"
                            placeholder="Password">
                        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                            onclick="togglePasswordVisibility('new_password', 'toggleEye1')">
                            <i class="fas fa-eye" id="toggleEye1"></i>
                        </span>
                    </div>
                    @error('new_password')
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
                    class="btn btn-primary w-100 text-dark rounded-full mb-4 p-2" style="font-size: 18px;">Change
                    Password</button>
            </form>
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
