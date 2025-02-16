<div id="editProfile" class="content-section ">
    <style>
        .edit-profile-card .form-label {
            margin-bottom: 0px !important;
        }

        .icon {
            position: absolute;
            bottom: 10px;
            right: 10px;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.2s ease-in-out;
        }

        .icon:hover {
            background-color: #f0f0f0;
        }
    </style>

    <div class="card shadow border p-3">
        <div class="p-3">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Profile Image Section -->
                <div class="position-relative d-inline-block">


                    <!-- Profile Image Preview -->
                    <img id="profileImagePreview"
                        src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('frontend/assets/images/profile.avif') }}"
                        class="rounded-circle mb-3 border" alt="Profile Picture"
                        style="width: 150px; height: 150px; object-fit: cover; background-color: #ddd;">


                    <!-- Edit Icon -->
                    <label for="profileImageInput" class="icon" aria-label="Edit Profile Picture">
                        <i class="fas fa-pencil-alt" style="color: #0064A7;"></i>
                    </label>

                    <!-- Hidden File Input -->
                    <input type="file" id="profileImageInput" name="profile_image" accept="image/*" class="d-none">
                </div>

                <!-- JavaScript for Image Preview -->
                <script>
                    document.getElementById('profileImageInput').addEventListener('change', function(event) {
                        let reader = new FileReader();
                        reader.onload = function() {
                            document.getElementById('profileImagePreview').src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    });
                </script>

                <!-- Full Name -->
                <div class="mb-3">
                    <label for="name" class="form-label text-left">Full Name</label>
                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                        id="name" name="name" value="{{ old('name', Auth::user()->name) }}" />
                    @if ($errors->has('name'))
                        <div class="invalid-feedback" style="display: block;">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                        @if (Auth::user()->email) readonly @endif />
                    @if ($errors->has('email'))
                        <div class="invalid-feedback" style="display: block;">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>




                <div class="mb-3">
                    <label for="editProfilePhone" class="form-label">Phone Number</label>
                    <input type="tel" name="phone" id="editProfilePhone"
                        class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Your Phone"
                        inputmode="numeric" pattern="[0-9]+" title="Enter a valid phone number" autocomplete="off"
                        value="{{ old('phone', Auth::user()->phone) ?? '' }}"
                        @if (Auth::user()->phone) @readonly(true) @endif />

                    @error('phone')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email Address (Readonly if already set) -->


                <!-- Address Fields -->
                <div class="mb-3">
                    <label for="current_location" class="form-label">Current Address</label>
                    <input type="text"
                        class="form-control {{ $errors->has('current_location') ? 'is-invalid' : '' }}"
                        id="current_location" name="current_location"
                        value="{{ old('current_location', Auth::user()->current_location) }}" />
                    @if ($errors->has('current_location'))
                        <div class="invalid-feedback" style="display: block;">
                            {{ $errors->first('current_location') }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="permanent_location" class="form-label">Permanent Address</label>
                    <input type="text"
                        class="form-control {{ $errors->has('permanent_location') ? 'is-invalid' : '' }}"
                        id="permanent_location" name="permanent_location"
                        value="{{ old('permanent_location', Auth::user()->permanent_location) }}" />
                    @if ($errors->has('permanent_location'))
                        <div class="invalid-feedback" style="display: block;">
                            {{ $errors->first('permanent_location') }}
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">
                        Upload your Document <span>(Citizenship, Driving License, Passport, etc.)</span>
                    </label>

                    <!-- Show Existing Uploaded Document -->
                    @if (Auth::user()->documents)
                        <div class="mb-2">
                            @php
                                $fileExtension = pathinfo(Auth::user()->documents, PATHINFO_EXTENSION);
                            @endphp

                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                <img id="existingFilePreview" src="{{ asset('storage/' . Auth::user()->documents) }}"
                                    class="img-fluid rounded border" style="max-width: 200px; max-height: 200px;"
                                    alt="Uploaded Document">
                            @else
                                <a href="{{ asset('storage/' . Auth::user()->documents) }}" target="_blank"
                                    class="btn btn-sm btn-primary">
                                    View Document ({{ strtoupper($fileExtension) }})
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- File Input -->
                    <input type="file" class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}"
                        id="file" name="file" accept="image/*,.pdf" />

                    <!-- Error Handling -->
                    @if ($errors->has('file'))
                        <div class="invalid-feedback" style="display: block;">
                            {{ $errors->first('file') }}
                        </div>
                    @endif

                    <!-- New File Preview -->
                    <div class="mt-2">
                        <img id="newFilePreview" class="img-fluid rounded border d-none"
                            style="max-width: 200px; max-height: 200px;" alt="New Upload Preview">
                    </div>
                </div>

                <!-- JavaScript for File Preview -->
                <script>
                    document.getElementById('file').addEventListener('change', function(event) {
                        let file = event.target.files[0];
                        let preview = document.getElementById('newFilePreview');

                        if (file) {
                            let reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.classList.remove('d-none'); // Show the preview
                            };
                            reader.readAsDataURL(file);
                        } else {
                            preview.classList.add('d-none'); // Hide the preview if no file is selected
                        }
                    });
                </script>

                <!-- Save Button -->
                <div class="save-btn">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
