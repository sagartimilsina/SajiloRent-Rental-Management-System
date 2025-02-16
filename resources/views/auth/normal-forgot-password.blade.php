@extends('frontend.layouts.main')
@section('title', 'Forgot Password')
@section('content')
    <style>
        /* Root Variables */
        :root {
            --primary: #008dd2 !important;
            --body-color: #e9f5fb !important;
            --secondary: #FF8000 !important;
            --color-purple: #b69cfc !important;
            --color-light-pink: #f7c6c7 !important;
            --main-primary: #1a2b4c !important;
        }



        .forgot-password-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            margin: 0 auto;
            display: block;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background-color: var(--primary);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }

        .card-body p {
            color: var(--main-primary);
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            color: var(--main-primary);
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: var(--primary);
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
        }

        .login-link {
            display: block;
            text-align: center;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .login-link:hover {
            color: var(--secondary);
        }





        .fa-exclamation-circle {
            margin-right: 5px;
        }
    </style>
    <div class="forgot-password-container">
        <div class="card">
            <div class="card-header">
                <span>Email Verification</span>
            </div>
            <div class="card-body">
                <p>Please enter your email address to receive a verification code.</p>

                <!-- Display General Errors (e.g., Rate Limiting) -->
                @if ($errors->has('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first('error') }}
                    </div>
                @endif


                <form action="{{ route('forgot-password.post') }}" method="POST">
                    @csrf <!-- CSRF Token for security -->
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Enter your email" required
                            value="{{ old('email') }}" class="form-control" />

                        @error('email')
                            <div class="text-danger m-1 mx-5">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-primary">Send Verification Code</button>
                    </div>
                </form>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="login-link">Go to Login</a>
                </div>
            </div>
        </div>
    </div>

@endsection
