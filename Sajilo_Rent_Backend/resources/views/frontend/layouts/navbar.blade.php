<nav class="navbar navbar-expand-lg navbar-dark position-relative">
    <div class="container-fluid">
        {{-- <a class="navbar-brand" href="{{ route('index') }}">
            <img alt="House Rent Logo" height="60"
                src="https://storage.googleapis.com/a1aa/image/enphJxBPaMWWaiVGW65XhTEEsArCFfIRkcZfzUFhSKginlnnA.jpg"
                width="60" />
        </a> --}}
        <a class="navbar-brand" href="{{ route('index') }}">
            <img alt="House Rent Logo" height="60"
                src="https://storage.googleapis.com/a1aa/image/enphJxBPaMWWaiVGW65XhTEEsArCFfIRkcZfzUFhSKginlnnA.jpg"
                width="60" class="img-fluid rounded-circle">
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
                <li class="nav-item"><a class="nav-link {{ Route::is('about') ? 'active-nav' : '' }}" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link {{ Route::is('blog') ? 'active-nav' : '' }}"  href="{{ route('blog') }}">Blogs</a></li>
                <li class="nav-item"><a class="nav-link {{ Route::is('gallery') ? 'active-nav' : '' }}" href="{{ route('gallery') }}">Gallery</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownPages" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Product
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownPages">
                        <li><a class="dropdown-item  "
                                href="{{ route('product', ['categoryId' => '1', 'subcategoryId' => '1']) }}">Product
                                Category 1</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('product', ['categoryId' => '1', 'subcategoryId' => '1']) }}">Product
                                Category 2</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link {{ Route::is('contact') ? 'active-nav' : '' }}" href="{{ route('contact') }}">Contact</a></li>

                <li class="nav-item">
                    <a class="nav-link " href="#" data-bs-toggle="modal" data-bs-target="#listPropertyModal">
                        List your Property
                    </a>
                </li>
            </ul>
            @if (Auth::check())
                <ul class="navbar-nav flex-row align-items-center">
                    <li class="nav-item dropdown me-0">
                        <a class="nav-link">
                            <div class="avatar avatar-online">
                                <!-- Check if avatar is a URL -->
                                <img src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('storage/default-avatar.png') }}"
                                    alt class="rounded-circle" style="width:40px; height:40px;" />
                                    <span 
                                    class="text-white ms-1 " 
                                    title="{{ Auth::user()->name }}">
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
                                                <img src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('storage/default-avatar.png') }}"
                                                    alt class="rounded-circle" style="width: 40px; height: 40px;" />
                                            </div>
                                        </div>
                                        <div class="">
                                            <span class="fw-medium d-block text-wrap" >{{ Auth::user()->name ?? 'User' }}</span>
                                            <span
                                                class="fw-medium d-block">{{ Auth::user()->role->role_name ?? 'Role' }}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-user me-2"></i>
                                    <span class="align-middle">Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-home me-2"></i>
                                    <span class="align-middle">Go to Dashboard</span>
                                </a>
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
    <!-- Modal for Submitting Request -->
    <div class="modal fade" id="listPropertyModal" tabindex="-1" aria-labelledby="listPropertyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <style>
                        .modal {
                            visibility: visible !important;
                            opacity: 1 !important;
                        }

                        .btn-close {
                            display: inline-block !important;
                            visibility: visible !important;
                        }
                    </style>
                    <h5 class="modal-title" id="submitRequestModalLabel">Request to List Your Property</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close "
                        style="color: #f39c12;"></button>
                </div>
                <div class="modal-body">
                    <form id="requestForm" enctype="multipart/form-data">
                        <div class="accordion" id="userTypeAccordion">
                            <!-- Normal User Section -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingNormalUser">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseNormalUser" aria-expanded="true"
                                        aria-controls="collapseNormalUser">
                                        Normal User
                                    </button>
                                </h2>
                                <div id="collapseNormalUser" class="accordion-collapse collapse show"
                                    aria-labelledby="headingNormalUser" data-bs-parent="#userTypeAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6 col-12 ">
                                                <label for="fullName" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="fullName"
                                                    placeholder="Enter your full name" required>
                                            </div>
                                            <div class="mb-3 col-md-6 col-12">
                                                <label for="contactNumber" class="form-label">Contact
                                                    Number</label>
                                                <input type="text" class="form-control" id="contactNumber"
                                                    placeholder="+(00)0-9999-9999" required>
                                            </div>
                                            <div class="mb-3 col-md-6 col-12">
                                                <label for="emailAddress" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="emailAddress"
                                                    placeholder="example@domain.com" required>
                                            </div>
                                            <div class="mb-3 col-md-6 col-12">
                                                <label for="govtId" class="form-label">Government-Issued
                                                    ID</label>
                                                <input type="file" class="form-control" id="govtId"
                                                    accept=".pdf,.jpg,.jpeg,.png" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Company Section -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCompany">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseCompany"
                                        aria-expanded="false" aria-controls="collapseCompany">
                                        Company
                                    </button>
                                </h2>
                                <div id="collapseCompany" class="accordion-collapse collapse"
                                    aria-labelledby="headingCompany" data-bs-parent="#userTypeAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="mb-3 col-12 col-md-6">
                                                <label for="businessName" class="form-label">Business/Company
                                                    Name</label>
                                                <input type="text" class="form-control" id="businessName"
                                                    placeholder="Enter business or company name" required>
                                            </div>
                                            <div class="mb-3 col-12 col-md-6">
                                                <label for="ownershipProof" class="form-label">Proof of
                                                    Ownership/Business Registration</label>
                                                <input type="file" class="form-control" id="ownershipProof"
                                                    accept=".pdf,.jpg,.jpeg,.png" required>
                                            </div>
                                            <div class="mb-3 col-12 col-md-6">
                                                <label for="addressProof" class="form-label">Proof of
                                                    Address</label>
                                                <input type="file" class="form-control" id="addressProof"
                                                    accept=".pdf,.jpg,.jpeg,.png" required>
                                            </div>
                                            <div class="mb-3 col-12 col-md-6">
                                                <label for="govtIdCompany" class="form-label">Government-Issued
                                                    ID</label>
                                                <input type="file" class="form-control" id="govtIdCompany"
                                                    accept=".pdf,.jpg,.jpeg,.png" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agreement Checkbox -->
                        <div class="mb-3 mt-3">
                            <input type="checkbox" id="agreeTerms" required>
                            <label for="agreeTerms" class="form-label">I agree to the terms and conditions of the
                                system.</label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </form>
                </div>
            </div>
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
