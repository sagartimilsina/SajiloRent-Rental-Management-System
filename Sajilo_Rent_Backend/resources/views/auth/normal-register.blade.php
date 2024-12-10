@include('frontend.layouts.header')
@include('frontend.layouts.navbar')
<div class="container-fluid d-flex justify-content-center align-items-center p-5">
    <div class="card-container w-100">
        <div class="card shadow p-4 mx-auto col-12 col-sm-8 col-md-6 col-lg-6 col-xl-4">
            <h2 class="text-center text-primary mb-4">Register Your Account</h2>
            <form method="POST" action="{{ route('normal_register_store') }}">
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

                {{-- <div class="form-group mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope fa-2x me-2"></i>
                        <input type="email" name="email" class="form-control rounded-full" placeholder="Email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger m-1 mx-5">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-phone-alt fa-2x me-2"></i>
                        <input type="text" name="phone" class="form-control rounded-full" placeholder="Phone" value="{{ old('phone') }}">
                    </div>
                    @error('phone')
                        <div class="text-danger m-1 mx-5">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div> --}}
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-lock fa-2x me-2"></i>
                        <input type="password" name="password" class="form-control rounded-full" placeholder="Password">
                    </div>
                    @error('password')
                        <div class="text-danger m-1 mx-5">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-lock fa-2x me-2"></i>
                        <input type="password" name="password_confirmation" class="form-control rounded-full"
                            placeholder="Confirm Password">
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger m-1 mx-5">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 text-dark rounded-full mb-4 p-2"
                    style="font-size: 18px;">Register</button>
            </form>

            <div class="or-divider mb-4">
                <hr>
                <span>OR</span>
            </div>
            <a href="{{ route('google_login') }}"
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
@include('frontend.layouts.footer')
