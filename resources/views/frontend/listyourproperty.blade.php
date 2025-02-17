@extends('frontend.layouts.main')
@section('title', 'List Your Property')
@section('content')
    <main class="py-5">
        <div class="container-left">
            <div class="row justify-content-center p-5 py-0 ">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header bg-white py-3">
                            <h3 class="text-center" style="color: #f39c12;">Application Form to List Your Property</h3>
                        </div>

                        <div class="card-body">
                            <form id="requestForm" enctype="multipart/form-data" action="{{ route('request_submit') }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ @Auth::user()->id }}">

                                <!-- Personal Information Section -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Personal Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fullName" class="form-label text-left">Full Name</label>
                                            <input type="text" class="form-control" id="fullName" name="full_name"
                                                placeholder="Enter your full name"
                                                value="{{ old('full_name', @Auth::user()->name) }}">
                                            @error('full_name')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="contactNumber" class="form-label text-left">Phone Number</label>
                                            <input type="tel" class="form-control" id="contactNumber"
                                                name="phone_number" placeholder="Enter your phone number"
                                                value="{{ old('phone_number', @Auth::user()->phone) }}">
                                            @error('phone_number')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="emailAddress" class="form-label text-left">Email Address</label>
                                            <input type="email" class="form-control" id="emailAddress"
                                                name="email_address" placeholder="Enter your email address"
                                                value="{{ old('email_address', @Auth::user()->email) }}">
                                            @error('email_address')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="residentialAddress" class="form-label text-left">Residential
                                                Address</label>
                                            <input type="text" class="form-control" id="residentialAddress"
                                                name="residential_address" placeholder="Enter your residential address"
                                                value="{{ old('residential_address') }}">
                                            @error('residential_address')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="nationalId" class="form-label text-left">National Identification
                                                Number</label>
                                            <input type="text" class="form-control" id="nationalId" name="national_id"
                                                placeholder="Enter your Citizenship ID or National Identification Number"
                                                value="{{ old('national_id') }}">
                                            @error('national_id')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="govtIdProof" class="form-label text-left">Government-Issued
                                                ID</label>
                                            <input type="file" class="form-control" id="govtIdProof" name="govt_id_proof"
                                                accept=".jpg,.jpeg,.png">
                                            <div id="govtIdProofFileList"></div>
                                            @error('govt_id_proof')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Information Section -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Business Information (if applicable)</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="businessName" class="form-label text-left">Business/Company
                                                Name</label>
                                            <input type="text" class="form-control" id="businessName"
                                                name="business_name" placeholder="Enter business or company name"
                                                value="{{ old('business_name') }}">
                                            @error('business_name')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="panId" class="form-label text-left">PAN Registration ID</label>
                                            <input type="text" class="form-control" id="panId"
                                                name="pan_registration_id" placeholder="Enter PAN registration ID"
                                                value="{{ old('pan_registration_id') }}">
                                            @error('pan_registration_id')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="businessType" class="form-label text-left">Type of
                                                Business</label>
                                            <input type="text" class="form-control" id="businessType"
                                                name="business_type" placeholder="e.g., Sole Proprietor, Partnership"
                                                value="{{ old('business_type') }}">
                                            @error('business_type')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="businessProof" class="form-label text-left">Proof of Business
                                                Registration</label>
                                            <input type="file" class="form-control" id="businessProof"
                                                name="business_proof" accept=".jpg,.jpeg,.png">
                                            <div id="businessProofFileList"></div>
                                            @error('business_proof')
                                                <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <style>
                                    .form-check-input[type=checkbox] {
                                        border-radius: .25em;
                                        border-color: #f39c12
                                    }
                                </style>
                                <!-- Terms and Submit -->
                                <div class="mb-4">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input text-dark" id="agreeTerms"
                                            name="agree_terms">
                                        <label class="form-check-label" for="agreeTerms">
                                            I agree to the <a href="{{ url('/about-dynamic/2') }}" class="text-decoration-none " target="_blank">terms and conditions
                                            </a> of the system.
                                        </label>
                                        @error('agree_terms')
                                            <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary px-4">Submit Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('.form-control[type="file"]').forEach(input => {
            input.addEventListener('change', (e) => {
                const inputId = e.target.id;
                let fileList = document.getElementById(`${inputId}FileList`);

                if (!fileList) {
                    fileList = document.createElement('div');
                    fileList.id = `${inputId}FileList`;
                    fileList.style.display = 'flex';
                    fileList.style.flexWrap = 'wrap';
                    fileList.style.gap = '10px';
                    fileList.style.marginTop = '10px';
                    e.target.closest('.mb-3').appendChild(fileList);
                }

                fileList.innerHTML = '';

                Array.from(e.target.files).forEach(file => {
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
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.style.width = '100%';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '5px';
                        img.style.marginBottom = '5px';
                        img.onload = () => URL.revokeObjectURL(img.src);
                        fileContainer.appendChild(img);
                    } else {
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
@endsection
