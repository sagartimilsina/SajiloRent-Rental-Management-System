
@extends('backend.auth.layouts.main')
@section('title', 'Admin Login')
@section('content')
<div class="wrapper">
    <div id="toastMessage" class="bs-toast toast fade show " role="alert" aria-live="assertive" aria-atomic="true"
        style="display: none">
        <div class="toast-header">
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastBody">
        </div>
    </div>
    <div class="title"><span>Admin Login</span></div>
    <form action="{{ route('admin-login-post') }}" method="POST">
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
