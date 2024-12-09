@include('frontend.layouts.header')
@include('frontend.layouts.navbar')
<div class="container-fluid d-flex justify-content-center align-items-center p-5">
    <div class="card-container w-100">
        <div class="card shadow p-4 mx-auto col-12 col-sm-8 col-md-6 col-lg-6 col-xl-4">
            <h2 class="text-center text-primary mb-4">Login to Your Account</h2>
            <form>
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope fa-2x me-2"></i>
                        <input type="text" class="form-control rounded-full" placeholder="Email">
                    </div>
                    <div class="text-danger m-1 mx-5">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Error message</span>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="d-flex align-items-center position-relative">
                        <i class="fas fa-lock fa-2x me-2"></i>
                        <input type="password" id="password" class="form-control rounded-full" placeholder="Password"
                            style="padding-right: 2.5rem;">
                        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                            onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye" id="toggleEye"></i>
                        </span>
                    </div>
                    <div class="text-danger m-1 mx-5">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Error message</span>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input ms-2 me-2" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>
                    <a href="forgot-password.html" class="text-primary me-1 register-hover text-decoration-none">Forgot
                        Password</a>
                </div>
                <a href="#" class="btn btn-primary w-100 text-dark rounded-full mb-4 p-2"
                    style="font-size: 18px;">Login</a>
            </form>
            <div class="or-divider mb-4">
                <hr>
                <span>OR</span>
            </div>
            <a href="#"
                class="btn btn-light rounded-full border w-100 mb-4 d-flex align-items-center justify-content-center p-2">
                <i class="fab fa-google fa-2x px-3"></i>
                Sign in with Google
            </a>
            <div class="text-center">
                <p class="text-muted">Don’t have an account? <a href="register.html"
                        class="text-primary register-hover text-decoration-none">Register here</a></p>
            </div>
        </div>
    </div>
</div>
<script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        var toggleIcon = document.getElementById("toggleEye");

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
