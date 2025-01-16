@extends('backend.layouts.main')
@section('title', 'Customer Change Password')
@section('content')

    <div class="container py-3">
        <div class="main-card mb-3 card col-12">
            <div class="card-header bg-color">
                <h5 class="mb-0 text-white">Change Password</h5>
            </div>
            <div class="card-body py-3">

                {{-- Form for changing password --}}
                <form action="{{ route('customer-change-password-update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3 form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control placeholder-small" name="current_password"
                                id="current_password" placeholder="Enter your current password" required
                                value="{{ old('current_password') }}" />
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="text-danger m-2">
                            @error('current_password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control placeholder-small" name="new_password"
                                id="new_password" placeholder="Enter your new password" required />
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="text-danger m-2">
                            @error('new_password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control placeholder-small" name="confirm_password"
                                id="confirm_password" placeholder="Confirm your new password" required />
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="text-danger m-2">
                            @error('confirm_password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Update Password</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $(".toggle-password").click(function() {
                let input = $(this).parent().find("input");
                let icon = $(this).find("i");

                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    input.attr("type", "password");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });
        });
    </script>
    <style>
        /* Style for smaller placeholder text */
        .placeholder-small::placeholder {
            font-size: 0.8rem !important;
            color: #6c757d;
        }
    </style>
@endsection
