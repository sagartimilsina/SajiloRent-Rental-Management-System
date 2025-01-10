@extends('backend.auth.layouts.main')
@section('title', 'Customer Login')
@section('content')
    <div class="wrapper">
        <div class="title"><span>Customer Login</span></div>
        <form action="{{ route('customer-login-post') }}" method="POST">
            @csrf <!-- CSRF Token for security -->

            <div class="row">
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}" />
            </div>

            <div class="row">
                <div class="field input-field">
                    <input type="password" name="password" placeholder="Password" required class="password" />
                    <i class='bx bx-hide eye-icon'></i> <!-- Eye icon for toggling password visibility -->
                </div>
            </div>

            <div class="form-link">
                <a href="{{ route('customer.email.verification') }}">Forgot password?</a> <!-- Link to forgot password -->
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
