@include('backend.auth.layouts.header')
@section('title', 'Set New Password')
<div class="wrapper">
    <div class="title"><span>Set New Password</span></div>
    <p>Please enter your new password below.</p>

    <form action="{{ route('customer.change-credentials-post') }}" method="POST">
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

@include('backend.auth.layouts.footer')
