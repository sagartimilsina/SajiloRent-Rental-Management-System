@include('backend.auth.layouts.header')
@section('title', 'Set New Password')
    <div class="wrapper">
        <div class="title"><span>Set New Password</span></div>
        <p>Please enter your new password below.</p>

        <form action="{{ route('employee.change-credentials-post') }}" method="POST">
            @csrf <!-- CSRF Token for security -->
            @php
                if (session()->has('email')) {
                    $email = session()->get('email');
                }
            @endphp
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="row">
                <div class="field input-field">
                    <input type="password" name="password" placeholder="New Password" required class="password" />
                    <i class='bx bx-hide eye-icon'></i> <!-- Eye icon for toggling password visibility -->
                </div>
            </div>

            <div class="row">
                <div class="field input-field">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required
                        class="password" />
                    <i class='bx bx-hide eye-icon'></i> <!-- Eye icon for toggling password visibility -->
                </div>
            </div>

            <div class="row button">
                <input type="submit" value="Update Password" />
            </div>

            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>

    {{-- <style>
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

        .row {
            margin-top: 20px;
        }

        .row input[type="password"],
        .row input[type="submit"] {
            width: 100%;
            height: 50px;
            padding: 0 15px;
            border-radius: 12px;
            border: 1px solid #ddd;
            font-size: 16px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .row input[type="password"]:focus {
            border-color: #1AB189;
            box-shadow: 0 0 8px rgba(26, 177, 137, 0.4);
            outline: none;
        }

        .row input[type="submit"] {
            background: #1AB189;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .row input[type="submit"]:hover {
            background: #17a589;
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
    </style> --}}

    {{-- <script>
        // JavaScript for toggling password visibility
        const pwShowHide = document.querySelectorAll(".eye-icon");
        pwShowHide.forEach(eyeIcon => {
            eyeIcon.addEventListener("click", () => {
                let pwFields = eyeIcon.parentElement.querySelectorAll(".password");
                pwFields.forEach(password => {
                    if (password.type === "password") {
                        password.type = "text"; // Show the password
                        eyeIcon.classList.replace("bx-hide", "bx-show"); // Change icon to show
                    } else {
                        password.type = "password"; // Hide the password
                        eyeIcon.classList.replace("bx-show", "bx-hide"); // Change icon to hide
                    }
                });
            });
        });
    </script> --}}
@include('backend.auth.layouts.footer')