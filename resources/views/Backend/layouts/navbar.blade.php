<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme position-sticky top-0 z-index-3 shadow-none"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..."
                    aria-label="Search..." />
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Role-Based Navbar Items -->
            @if (Auth::check())
                @php
                    $userRole = Auth::user()->role->role_name;
                @endphp
                @if ($userRole == 'Super Admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('super.admin.dashboard') }}">Super Admin Dashboard</a>
                    </li>
                @elseif($userRole == 'Admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">House /Company Owner Dashboard</a>
                    </li>
                @elseif($userRole == 'user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">User Dashboard</a>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
            @endif
            <!-- User Profile Section -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('frontend/assets/images/profile.avif') }}"
                            alt class="rounded-circle" style="width:40px; height:40px;" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="fw-medium d-block">{{ @Auth::user()->name }}</span>

                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index') }}">
                            <div class="dropdown-divider">Go to Frontend</div>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Change Password</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>

                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </button>

                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if (Auth::check() && Auth::user()->role->role_name == 'Super Admin')
                <form action="{{ route('superadmin.change_password.store') }}" method="POST">
                @elseif(Auth::check() && Auth::user()->role->role_name == 'Admin')
                    <form action="{{ route('admin.change_password.store') }}" method="POST">
            @endif

            @csrf
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var myModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                            myModal.show();
                        });
                    </script>
                @endif
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Current Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="currentPassword" name="current_password"
                            required>
                        <button class="btn btn-outline-secondary toggle-password" type="button"
                            data-target="currentPassword">
                            <i class="bx bx-show"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button"
                            data-target="newPassword">
                            <i class="bx bx-show"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmPassword"
                            name="password_confirmation" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button"
                            data-target="confirmPassword">
                            <i class="bx bx-show"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".toggle-password").forEach(function(button) {
            button.addEventListener("click", function() {
                var targetId = this.getAttribute("data-target");
                var input = document.getElementById(targetId);
                if (input.type === "password") {
                    input.type = "text";
                    this.innerHTML = '<i class="bx bx-hide"></i>';
                } else {
                    input.type = "password";
                    this.innerHTML = '<i class="bx bx-show"></i>';
                }
            });
        });
    });
</script>
