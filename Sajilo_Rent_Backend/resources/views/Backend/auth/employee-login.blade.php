@extends('backend.auth.layouts.main')
@section('title', 'Employee Login')
@section('content')
    <div class="wrapper">
        <div class="title"><span>Employee Login</span></div>
        <form action="{{ route('employee-login-post') }}" method="POST">
            @csrf <!-- CSRF Token for security -->
            <div class="row">
                <input type="text" name="email" placeholder="Email" required value="{{ old('email') }}" />
            </div>
            <div class="row">
                <div class="field input-field">
                    <input type="password" name="password" placeholder="Password" required class="password" />
                    <i class='bx bx-hide eye-icon'></i> <!-- Eye icon for toggling password visibility -->
                </div>
            </div>

            <div class="form-link">
                <a href="{{ route('employee.email.verification.page') }}">Forgot password?</a>
                <!-- Link to forgot password -->
            </div>

            <div class="row button">
                <input type="submit" value="Login" />
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
        </form>
    </div>

@endsection
