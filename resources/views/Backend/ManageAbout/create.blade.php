@extends('backend.layouts.main')

@section('title', isset($about) ? 'Edit about' : 'Create about')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($about) ? 'Edit about' : 'Create about' }}</h5>
                        <div class="d-flex align-items-center">
                            <small class="text-muted">Fill in about details</small>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success mb-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form id="about-form"
                            action="{{ isset($about) ? route('abouts.update', ['about' => $about->id]) : route('abouts.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($about))
                                @method('PUT')
                            @endif

                            <!-- Name Input -->
                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="head" class="form-label">Head Title
                                        <span class="text-danger">(About, Terms and Conditions, Privacy Policy, etc.)</span>
                                    </label>
                                    <select id="head" name="head"
                                        class="form-control @error('head') is-invalid @enderror" required autofocus>
                                        <option value="">-- Select Head Title --</option>
                                        <option value="About Us"
                                            {{ old('head', isset($about) ? $about->head : '') == 'About Us' ? 'selected' : '' }}>
                                            About Us</option>
                                        <option value="Terms and Conditions"
                                            {{ old('head', isset($about) ? $about->head : '') == 'Terms and Conditions' ? 'selected' : '' }}>
                                            Terms and Conditions</option>
                                        <option value="Privacy Policy"
                                            {{ old('head', isset($about) ? $about->head : '') == 'Privacy Policy' ? 'selected' : '' }}>
                                            Privacy Policy</option>
                                        <option value="Other"
                                            {{ old('head', isset($about) ? $about->head : '') == 'Other' ? 'selected' : '' }}>
                                            Other</option>
                                    </select>
                                    @error('head')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3 col-md-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" id="title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', isset($about) ? $about->title : '') }}" required autofocus
                                        placeholder="Enter title">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Thumbnail Input and Preview -->
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail</label>
                                    <input type="file" id="thumbnail" name="thumbnail"
                                        class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <img id="imagePreview"
                                        src="{{ isset($about) && $about->image ? asset('storage/' . $about->image) : '' }}"
                                        alt="Image Preview"
                                        style="display: {{ isset($about->image) ? 'block' : 'none' }}; margin-top: 10px; max-width: 200px; max-height: 150px; object-fit: cover;" />
                                </div>
                            </div>

                            <!-- Description Textarea -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', isset($about) ? $about->description : '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ isset($about) ? 'Update about' : 'Create about' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for cropping image -->
    <div class="modal fade" id="cropper-modal" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropperModalLabel">Crop Image</h5>
                    <button type="button" class="btn btn-secondary" id="close-modal">Cancel</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="img-container">
                                <img id="cropper-image" src=""
                                    style="width: 100%; max-height: 600px; object-fit: contain;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="preview-container mt-3">
                                <h6>Live Preview:</h6>
                                <div class="preview" style="width: 150px; height: 150px; overflow: hidden;">
                                    <img id="preview-image" style="max-width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="crop-button">Crop</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Cropper.js scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js"></script>
    <script>
        $(document).ready(function() {
            var $modal = $('#cropper-modal');
            var image = document.getElementById('cropper-image');
            var cropper;

            $('#thumbnail').change(function(e) {
                var files = e.target.files;
                if (files && files.length > 0) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        image.src = event.target.result;
                        $modal.modal('show');
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1.5,
                    viewMode: 3,
                    preview: '.preview',
                    autoCropArea: 1,
                    responsive: true,
                });
            }).on('hidden.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            });

            $('#crop-button').click(function() {
                if (!cropper) return;

                var canvas = cropper.getCroppedCanvas({
                    width: 1024,
                    height: 1024
                });

                canvas.toBlob(function(blob) {
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;
                        $('#imagePreview').attr('src', base64data).show();
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'cropped_image',
                            value: base64data
                        }).appendTo('#about-form');
                        $modal.modal('hide');
                    };
                });
            });

            $('#close-modal').click(function() {
                $modal.modal('hide');
            });
            $('#description').summernote({
                placeholder: 'Enter a detailed description...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });


        });
    </script>
@endsection
