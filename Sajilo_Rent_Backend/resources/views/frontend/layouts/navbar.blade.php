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
                <li class="nav-item"><a class="nav-link {{ Route::is('about') ? 'active-nav' : '' }}"
                        href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link {{ Route::is('blog') ? 'active-nav' : '' }}"
                        href="{{ route('blog') }}">Blogs</a></li>
                <li class="nav-item"><a class="nav-link {{ Route::is('gallery') ? 'active-nav' : '' }}"
                        href="{{ route('gallery') }}">Gallery</a></li>
                <li class="nav-item"><a class="nav-link {{ Route::is('about') ? 'active-nav' : '' }}"
                        href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link {{ Route::is('blog') ? 'active-nav' : '' }}"
                        href="{{ route('blog') }}">Blogs</a></li>
                <li class="nav-item"><a class="nav-link {{ Route::is('gallery') ? 'active-nav' : '' }}"
                        href="{{ route('gallery') }}">Gallery</a></li>
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
                <li class="nav-item"><a class="nav-link {{ Route::is('contact') ? 'active-nav' : '' }}"
                        href="{{ route('contact') }}">Contact</a></li>
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
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#listPropertyModal">
                            List your Property
                        </a>
                    </li>
                @endif

                @php
                    // Fetch the latest application status for the authenticated user
                    $application = DB::table('request_owner_lists')
                        ->where('user_id', @Auth::user()->id)
                        ->orderBy('created_at', 'desc') // Get the latest entry by date
                        ->first();
                @endphp

                @if (is_null($application) || in_array($application->status, ['rejected', 'expired']))
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#listPropertyModal">
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
                                <img src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('storage/default-avatar.png') }}"
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
                                                <img src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('storage/default-avatar.png') }}"
                                                    alt class="rounded-circle" style="width: 40px; height: 40px;" />
                                            </div>
                                        </div>
                                        <div class="">
                                            <span
                                                class="fw-medium d-block text-wrap">{{ Auth::user()->name ?? 'User' }}</span>
                                            <span
                                                class="fw-medium d-block text-wrap">{{ Auth::user()->name ?? 'User' }}</span>
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
                                @if (Auth::user()->role->role_name == 'Admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fa fa-home me-2"></i>
                                        <span class="align-middle text-wrap">Go to Admin Dashboard</span>
                                    </a>
                                @elseif(Auth::user()->role->role_name == 'User')
                                    <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="fa fa-home me-2"></i>
                                        <span class="align-middle text-wrap">Go to User Dashboard</span>
                                    </a>
                                @elseif(Auth::user()->role->role_name == 'Super Admin')
                                    <a class="dropdown-item" href="{{ route('super.admin.dashboard') }}">
                                        <i class="fa fa-home me-2"></i>
                                        <span class="align-middle text-wrap">Go to Super Admin Dashboard</span>
                                    </a>
                                @else
                                @endif

                                @if (Auth::user()->role->role_name == 'Admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fa fa-home me-2"></i>
                                        <span class="align-middle text-wrap">Go to Admin Dashboard</span>
                                    </a>
                                @elseif(Auth::user()->role->role_name == 'User')
                                    <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="fa fa-home me-2"></i>
                                        <span class="align-middle text-wrap">Go to User Dashboard</span>
                                    </a>
                                @elseif(Auth::user()->role->role_name == 'Super Admin')
                                    <a class="dropdown-item" href="{{ route('super.admin.dashboard') }}">
                                        <i class="fa fa-home me-2"></i>
                                        <span class="align-middle text-wrap">Go to Super Admin Dashboard</span>
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
    <!-- Modal for Submitting Request -->
    <div class="modal fade" id="listPropertyModal" tabindex="-1" aria-labelledby="listPropertyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" style="color: #f39c12;">Application Form to List Your Property
                    </h3>
                    <h3 class="modal-title text-center" style="color: #f39c12;">Application Form to List Your Property
                    </h3>
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
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #f39c12;"></button>
                </div>
                <div class="modal-body">
                    <form id="requestForm" enctype="multipart/form-data" action="{{ route('request_submit') }}"
                        method="POST">
                        @csrf
                        @if ($errors->any())
                            <script>
                                var myModal = new bootstrap.Modal(document.getElementById('listPropertyModal'), {
                                    backdrop: 'static',
                                    keyboard: false
                                });
                                myModal.show();
                            </script>
                        @endif
                    <form id="requestForm" enctype="multipart/form-data" action="{{ route('request_submit') }}"
                        method="POST">
                        @csrf
                        @if ($errors->any())
                            <script>
                                var myModal = new bootstrap.Modal(document.getElementById('listPropertyModal'), {
                                    backdrop: 'static',
                                    keyboard: false
                                });
                                myModal.show();
                            </script>
                        @endif
                        <div class="accordion" id="userTypeAccordion">

                            <!-- Personal Information Section -->

                            <!-- Personal Information Section -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingPersonalInfo">
                                <h2 class="accordion-header" id="headingPersonalInfo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsePersonalInfo" aria-expanded="true"
                                        aria-controls="collapsePersonalInfo">
                                        1. Personal Information
                                        data-bs-target="#collapsePersonalInfo" aria-expanded="true"
                                        aria-controls="collapsePersonalInfo">
                                        1. Personal Information
                                    </button>
                                </h2>
                                <div id="collapsePersonalInfo" class="accordion-collapse collapse show"
                                    aria-labelledby="headingPersonalInfo" data-bs-parent="#userTypeAccordion">
                                <div id="collapsePersonalInfo" class="accordion-collapse collapse show"
                                    aria-labelledby="headingPersonalInfo" data-bs-parent="#userTypeAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <input type="hidden" name="user_id" value="{{ @Auth::user()->id }}">
                                            <div class="mb-3 col-md-6">
                                            <input type="hidden" name="user_id" value="{{ @Auth::user()->id }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="fullName" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="fullName"
                                                    name="full_name" placeholder="Enter your full name"
                                                    value="{{ old('full_name', @Auth::user()->name) }}">

                                                @error('full_name')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror

                                                    name="full_name" placeholder="Enter your full name"
                                                    value="{{ old('full_name', @Auth::user()->name) }}">

                                                @error('full_name')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="contactNumber" class="form-label">Phone Number</label>
                                                <input type="tel" class="form-control" id="contactNumber"
                                                    name="phone_number" placeholder="Enter your phone number"
                                                    value="{{ old('phone_number', @Auth::user()->phone) }}">

                                                @error('phone_number')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="mb-3 col-md-6">
                                            <div class="mb-3 col-md-6">
                                                <label for="emailAddress" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="emailAddress"
                                                    name="email_address" placeholder="Enter your email address"
                                                    value="{{ old('email_address', @Auth::user()->email) }}">

                                                @error('email_address')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="residentialAddress" class="form-label">Residential
                                                    Address</label>
                                                <input type="text" class="form-control" id="residentialAddress"
                                                    name="residential_address"
                                                    placeholder="Enter your residential address"
                                                    value="{{ old('residential_address') }}">

                                                @error('residential_address')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="nationalId" class="form-label">National Identification
                                                    Number</label>
                                                <input type="text" class="form-control" id="nationalId"
                                                    name="national_id"
                                                    placeholder="Enter your Citizenship ID or National Identification Number"
                                                    value="{{ old('national_id') }}">

                                                @error('national_id')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror

                                                    name="email_address" placeholder="Enter your email address"
                                                    value="{{ old('email_address', @Auth::user()->email) }}">

                                                @error('email_address')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="residentialAddress" class="form-label">Residential
                                                    Address</label>
                                                <input type="text" class="form-control" id="residentialAddress"
                                                    name="residential_address"
                                                    placeholder="Enter your residential address"
                                                    value="{{ old('residential_address') }}">

                                                @error('residential_address')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="nationalId" class="form-label">National Identification
                                                    Number</label>
                                                <input type="text" class="form-control" id="nationalId"
                                                    name="national_id"
                                                    placeholder="Enter your Citizenship ID or National Identification Number"
                                                    value="{{ old('national_id') }}">

                                                @error('national_id')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="govtIdProof" class="form-label">Government-Issued
                                            <div class="mb-3 col-md-6">
                                                <label for="govtIdProof" class="form-label">Government-Issued
                                                    ID</label>
                                                <input type="file" class="form-control" id="govtIdProof"
                                                    name="govt_id_proof" accept=".jpg,.jpeg,.png"
                                                    value="{{ old('govt_id_proof') }}">

                                                @error('govt_id_proof')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Business Information Section -->
                            <!-- Business Information Section -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingBusinessInfo">
                                <h2 class="accordion-header" id="headingBusinessInfo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseBusinessInfo"
                                        aria-expanded="false" aria-controls="collapseBusinessInfo">
                                        2. Business Information (if applicable)
                                        data-bs-toggle="collapse" data-bs-target="#collapseBusinessInfo"
                                        aria-expanded="false" aria-controls="collapseBusinessInfo">
                                        2. Business Information (if applicable)
                                    </button>
                                </h2>
                                <div id="collapseBusinessInfo" class="accordion-collapse collapse"
                                    aria-labelledby="headingBusinessInfo" data-bs-parent="#userTypeAccordion">
                                <div id="collapseBusinessInfo" class="accordion-collapse collapse"
                                    aria-labelledby="headingBusinessInfo" data-bs-parent="#userTypeAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                            <div class="mb-3 col-md-6">
                                                <label for="businessName" class="form-label">Business/Company
                                                    Name</label>
                                                <input type="text" class="form-control" id="businessName"
                                                    name="business_name" placeholder="Enter business or company name"
                                                    value="{{ old('business_name') }}">

                                                @error('business_name')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror
                                                    name="business_name" placeholder="Enter business or company name"
                                                    value="{{ old('business_name') }}">

                                                @error('business_name')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="panId" class="form-label">PAN Registration ID</label>
                                                <input type="text" class="form-control" id="panId"
                                                    name="pan_registration_id" placeholder="Enter PAN registration ID"
                                                    value="{{ old('pan_registration_id') }}">

                                                @error('pan_registration_id')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror
                                            <div class="mb-3 col-md-6">
                                                <label for="panId" class="form-label">PAN Registration ID</label>
                                                <input type="text" class="form-control" id="panId"
                                                    name="pan_registration_id" placeholder="Enter PAN registration ID"
                                                    value="{{ old('pan_registration_id') }}">

                                                @error('pan_registration_id')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="businessType" class="form-label">Type of Business</label>
                                                <input type="text" class="form-control" id="businessType"
                                                    name="business_type"
                                                    placeholder="e.g., Sole Proprietor, Partnership"
                                                    value="{{ old('business_type') }}">

                                                @error('business_type')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror
                                            <div class="mb-3 col-md-6">
                                                <label for="businessType" class="form-label">Type of Business</label>
                                                <input type="text" class="form-control" id="businessType"
                                                    name="business_type"
                                                    placeholder="e.g., Sole Proprietor, Partnership"
                                                    value="{{ old('business_type') }}">

                                                @error('business_type')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="businessProof" class="form-label">Proof of Business
                                                    Registration</label>
                                                <input type="file" class="form-control" id="businessProof"
                                                    name="business_proof" accept=".jpg,.jpeg,.png"
                                                    value="{{ old('business_proof') }}">

                                                @error('business_proof')
                                                    <span class="text-danger mt-2">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agreement Checkbox -->
                        <div class="mb-3 mt-3">
                            <input type="checkbox" id="agreeTerms" name="agree_terms">
                            <input type="checkbox" id="agreeTerms" name="agree_terms">
                            <label for="agreeTerms" class="form-label">I agree to the terms and conditions of the
                                system.</label>
                            <div>
                                @error('agree_terms')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                @error('agree_terms')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
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
<script>
    document.querySelectorAll('.form-control[type="file"]').forEach(input => {
        input.addEventListener('change', (e) => {
            const inputId = e.target.id; // Get the ID of the current input
            let fileList = document.getElementById(`${inputId}FileList`);

            // If fileList doesn't exist for the current input, create it
            if (!fileList) {
                fileList = document.createElement('div');
                fileList.id = `${inputId}FileList`;
                fileList.style.display = 'flex';
                fileList.style.flexWrap = 'wrap';
                fileList.style.gap = '10px';
                fileList.style.marginTop = '10px';
                e.target.closest('.mb-3').appendChild(fileList);
            }

            fileList.innerHTML = ''; // Clear previous previews for the current input

            const files = Array.from(e.target.files); // Get selected files

            files.forEach(file => {
                const fileContainer = document.createElement('div');
                fileContainer.style.display = 'flex';
                fileContainer.style.flexDirection = 'column';
                fileContainer.style.alignItems = 'center';
                fileContainer.style.width = '120px';
                fileContainer.style.margin = '10px';
                fileContainer.style.border = '1px solid #ddd';
                fileContainer.style.borderRadius = '5px';
                fileContainer.style.padding = '5px';
                fileContainer.style.textAlign = 'center';
                fileContainer.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';

                if (file.type.startsWith('image/')) {
                    // Handle image files
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.width = '100%';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '5px';
                    img.style.marginBottom = '5px';
                    img.onload = () => URL.revokeObjectURL(img.src); // Free memory
                    fileContainer.appendChild(img);
                } else if (file.type === 'application/pdf') {
                    // Handle PDF files
                    const pdfLink = document.createElement('a');
                    pdfLink.href = URL.createObjectURL(file);
                    pdfLink.textContent = file.name;
                    pdfLink.target = '_blank';
                    pdfLink.style.color = '#007bff';
                    pdfLink.style.textDecoration = 'none';
                    fileContainer.appendChild(pdfLink);
                } else {
                    // Handle other files
                    const fileName = document.createElement('span');
                    fileName.textContent = file.name;
                    fileName.style.fontSize = '12px';
                    fileName.style.color = '#555';
                    fileContainer.appendChild(fileName);
                }

                fileList.appendChild(fileContainer);
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check for validation errors
        @if ($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('listPropertyModal'), {
                backdrop: 'static',
                keyboard: false
            });
            myModal.show();
        @endif

    });
</script>
<script>
    document.querySelectorAll('.form-control[type="file"]').forEach(input => {
        input.addEventListener('change', (e) => {
            const inputId = e.target.id; // Get the ID of the current input
            let fileList = document.getElementById(`${inputId}FileList`);

            // If fileList doesn't exist for the current input, create it
            if (!fileList) {
                fileList = document.createElement('div');
                fileList.id = `${inputId}FileList`;
                fileList.style.display = 'flex';
                fileList.style.flexWrap = 'wrap';
                fileList.style.gap = '10px';
                fileList.style.marginTop = '10px';
                e.target.closest('.mb-3').appendChild(fileList);
            }

            fileList.innerHTML = ''; // Clear previous previews for the current input

            const files = Array.from(e.target.files); // Get selected files

            files.forEach(file => {
                const fileContainer = document.createElement('div');
                fileContainer.style.display = 'flex';
                fileContainer.style.flexDirection = 'column';
                fileContainer.style.alignItems = 'center';
                fileContainer.style.width = '120px';
                fileContainer.style.margin = '10px';
                fileContainer.style.border = '1px solid #ddd';
                fileContainer.style.borderRadius = '5px';
                fileContainer.style.padding = '5px';
                fileContainer.style.textAlign = 'center';
                fileContainer.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';

                if (file.type.startsWith('image/')) {
                    // Handle image files
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.width = '100%';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '5px';
                    img.style.marginBottom = '5px';
                    img.onload = () => URL.revokeObjectURL(img.src); // Free memory
                    fileContainer.appendChild(img);
                } else if (file.type === 'application/pdf') {
                    // Handle PDF files
                    const pdfLink = document.createElement('a');
                    pdfLink.href = URL.createObjectURL(file);
                    pdfLink.textContent = file.name;
                    pdfLink.target = '_blank';
                    pdfLink.style.color = '#007bff';
                    pdfLink.style.textDecoration = 'none';
                    fileContainer.appendChild(pdfLink);
                } else {
                    // Handle other files
                    const fileName = document.createElement('span');
                    fileName.textContent = file.name;
                    fileName.style.fontSize = '12px';
                    fileName.style.color = '#555';
                    fileContainer.appendChild(fileName);
                }

                fileList.appendChild(fileContainer);
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check for validation errors
        @if ($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('listPropertyModal'), {
                backdrop: 'static',
                keyboard: false
            });
            myModal.show();
        @endif

    });
</script>
