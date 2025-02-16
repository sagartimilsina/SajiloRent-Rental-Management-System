@php
    $categories = App\Models\Categories::where('publish_status', 1)
        ->distinct('category_name') // Assuming 'name' is the column that represents the category name
        ->get();

@endphp

<nav class="navbar navbar-expand-lg navbar-dark position-relative ">
    <div class="container-fluid">

        <a class="navbar-brand mx-5" href="{{ route('index') }}">
            <img alt="House Rent Logo" height="75" src="{{ asset('frontend/assets/images/logo.png') }}" width="75"
                class="img-fluid rounded-circle">
        </a>
        <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
            data-bs-toggle="collapse" data-bs-target="#navbarNav" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <form class="navbar-search-mobile d-none ">
            <input class="form-control me-2 search" type="search" placeholder="Search" aria-label="Search">
        </form>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('index') ? 'active-nav' : '' }}"
                        href="{{ route('index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('product_or_property') ? 'active-nav' : '' }}" href="{{ route('product_or_property') }}">Our
                        Product</a>
                </li>
                <li class="nav-item"><a class="nav-link {{ Route::is('about') ? 'active-nav' : '' }}"
                        href="{{ route('about') }}">About</a></li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog') ? 'active-nav' : '' }}"
                        href="{{ route('blog') }}">Blogs</a>
                </li>


                <li class="nav-item"><a class="nav-link {{ Route::is('gallery') ? 'active-nav' : '' }}"
                        href="{{ route('gallery') }}">Gallery</a></li>

                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPages" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Product Category
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownPages">
                        @foreach ($categories as $category)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('product', ['categoryId' => $category->id]) }}">
                                    {{ $category->category_name }}
                                    <!-- or use another field like $category->slug if needed -->
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li> --}}

                <li class="nav-item"><a class="nav-link {{ Route::is('contact') ? 'active-nav' : '' }}"
                        href="{{ route('contact') }}">Contact</a></li>

                @php
                    // Fetch the latest application status for the authenticated user
                    $application = DB::table('request_owner_lists')
                        ->where('user_id', @Auth::user()->id)
                        ->orderBy('created_at', 'desc') // Get the latest entry by date
                        ->first();
                @endphp

                @if (is_null($application) || in_array($application->status, ['rejected', 'expired']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('list-property') }}">
                            List your Property
                        </a>
                    </li>
                @endif

            </ul>
            @if (Auth::check())
                <ul class="navbar-nav flex-row align-items-center">
                    <li class="nav-item dropdown me-0">
                        <a class="nav-link">
                            <div class="avatar avatar-online">
                                <!-- Check if avatar is a URL -->
                                <img src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('frontend/assets/images/profile.avif') }}"
                                    alt class="rounded-circle" style="width:40px; height:40px;" />
                                <span class="text-white ms-1 " title="{{ Auth::user()->name }}">
                                    {{ strtok(Auth::user()->name, ' ') }}
                                </span>

                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-start dropdown-menu-dark ">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <div class="avatar avatar-online">
                                                <!-- Same check for avatar here -->
                                                <img src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('frontend/assets/images/profile.avif') }}"
                                                    alt class="rounded-circle" style="width:40px; height:40px;" />
                                            </div>
                                        </div>
                                        <div class="">
                                            <span class="fw-medium d-block text-wrap">
                                                {{ Auth::user()->name ?? 'User' }}
                                            </span>
                                            <span class="fw-medium d-block">
                                                @if (Auth::user()->role->role_name == 'Admin')
                                                    Owner
                                                @elseif (Auth::user()->role->role_name == 'User')
                                                    Client
                                                @else
                                                    {{ Auth::user()->role->role_name ?? 'Role' }}
                                                @endif
                                            </span>

                                        </div>
                                    </div>
                                </a>
                            </li>


                            <li>
                                @if (Auth::user()->role->role_name == 'Admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fa fa-home me-2"></i>
                                        <span class="align-middle text-wrap"> Dashboard</span>
                                    </a>
                                @elseif(Auth::user()->role->role_name == 'User')
                                    <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="fa fa-user me-2"></i>
                                        <span class="align-middle text-wrap"> My Profile</span>
                                    </a>
                                @elseif(Auth::user()->role->role_name == 'Super Admin')
                                    <a class="dropdown-item" href="{{ route('super.admin.dashboard') }}">
                                        <i class="fa fa-home me-2"></i>
                                        <span class="align-middle text-wrap"> Dashboard</span>
                                    </a>
                                @else
                                @endif

                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('change.password') }}">
                                    <i class="fa fa-cog me-2"></i>
                                    <span class="align-middle">Change Password</span>
                                </a>
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item" tabindex="0">
                                        <i class="fa fa-power-off me-2"></i>
                                        <span class="align-middle">Log Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div>
                    <div class="login-register">
                        <i class="fa fa-search fa-2x btn btn-outline-warning search-icon text-white me-2"
                            aria-hidden="true"></i>
                    </div>
                </div>
            @else
                <div class="login-register">
                    <a href="{{ route('login') }}" class="btn btn-outline-warning login-no-hover">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-warning"
                        style="background-color: #f39c12;">Register</a>

                </div>
            @endif
        </div>
    </div>




</nav>



<!-- Search Form -->
<form class="navbar-search d-none position-absolute">
    <input class="form-control me-2 search" type="search" placeholder="Search" aria-label="Search">
</form>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchIcon = document.querySelector(".search-icon");
        const searchForm = document.querySelector(".navbar-search");

        searchIcon.addEventListener("click", () => {
            searchForm.classList.toggle("d-none");
        });
    });
</script>
