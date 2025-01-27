@extends('backend.layouts.main')

@section('title', isset($gallery) ? 'Edit gallery' : 'Create gallery')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($gallery) ? 'Edit gallery' : 'Create gallery' }}</h5>
                        <div class="d-flex align-items-center">
                            <small class="text-muted">Fill in gallery details</small>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success mb-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form id="gallery-form"
                            action="{{ isset($gallery) ? route('galleries.update', ['gallery' => $gallery->id]) : route('galleries.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($gallery))
                                @method('PUT')
                            @endif

                            <!-- Name Input -->
                            <div class="row">
                                <div class="form-group mb-3 col-md-12">
                                    <label for="gallery_type" class="form-label">Gallery Type or Category</label>
                                    <select id="gallery_type" name="gallery_type"
                                        class="form-control @error('gallery_type') is-invalid @enderror" required>
                                        <option value="">-- Select Gallery Type --</option>
                                        <option value="Image"
                                            {{ old('gallery_type', isset($gallery) ? $gallery->gallery_type : '') == 'Image' ? 'selected' : '' }}>
                                            Image</option>
                                        <option value="Video"
                                            {{ old('gallery_type', isset($gallery) ? $gallery->gallery_type : '') == 'Video' ? 'selected' : '' }}>
                                            Video</option>
                                    </select>
                                    @error('gallery_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3 col-md-12">
                                    <label for="gallery_name" class="form-label">Gallery Name</label>
                                    <input type="text" id="gallery_name" name="gallery_name"
                                        class="form-control @error('gallery_name') is-invalid @enderror"
                                        value="{{ old('gallery_name', isset($gallery) ? $gallery->gallery_name : '') }}"
                                        required autofocus placeholder="Enter gallery_name">
                                    @error('gallery_name')
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
                                        src="{{ isset($gallery) && $gallery->gallery_image ? asset('storage/' . $gallery->gallery_image) : '' }}"
                                        alt="Image Preview"
                                        style="display: {{ isset($gallery->gallery_image) ? 'block' : 'none' }}; margin-top: 10px; max-width: 200px; max-height: 150px; object-fit: cover;" />
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ isset($gallery) ? 'Update gallery' : 'Create gallery' }}
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
                        }).appendTo('#gallery-form');
                        $modal.modal('hide');
                    };
                });
            });

            $('#close-modal').click(function() {
                $modal.modal('hide');
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const galleryTypeSelect = document.getElementById('gallery_type');
            const thumbnailInput = document.getElementById('thumbnail');
            const videoInput = document.getElementById('video');
            const previewContainer = document.getElementById('preview-container');

            // Create preview container if it doesn't exist
            if (!previewContainer) {
                const container = document.createElement('div');
                container.id = 'preview-container';
                thumbnailInput.parentNode.appendChild(container);
            }

            // Function to clear previous preview
            function clearPreview() {
                document.getElementById('preview-container').innerHTML = '';
            }

            // Image preview with cropping
            function previewImage(file) {
                clearPreview();
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '300px';
                    img.style.maxHeight = '300px';
                    img.style.objectFit = 'contain';
                    document.getElementById('preview-container').appendChild(img);
                };
                reader.readAsDataURL(file);
            }

            // Video preview
            function previewVideo(file) {
                clearPreview();
                const video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.style.maxWidth = '300px';
                video.style.maxHeight = '300px';
                video.controls = true;
                document.getElementById('preview-container').appendChild(video);
            }

            // Dynamically show/hide inputs based on gallery type
            galleryTypeSelect.addEventListener('change', function() {
                const isImage = this.value === 'Image';

                // Toggle visibility of inputs
                thumbnailInput.closest('.mb-3').style.display = isImage ? 'block' : 'none';

                // Create video input if it doesn't exist for Video type
                if (!videoInput && !isImage) {
                    const videoInputWrapper = document.createElement('div');
                    videoInputWrapper.classList.add('mb-3');
                    videoInputWrapper.innerHTML = `
                <label for="video" class="form-label">Video File</label>
                <input type="file" id="video" name="video" 
                    class="form-control" 
                    accept="video/mp4,video/mpeg,video/quicktime">
            `;
                    thumbnailInput.closest('.mb-3').parentNode.insertBefore(videoInputWrapper,
                        thumbnailInput.closest('.mb-3').nextSibling);
                }
            });

            // Preview handling for image
            thumbnailInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    previewImage(this.files[0]);
                }
            });

            // Preview handling for video (if video input exists)
            document.addEventListener('change', function(e) {
                if (e.target && e.target.id === 'video') {
                    if (e.target.files && e.target.files[0]) {
                        previewVideo(e.target.files[0]);
                    }
                }
            });
        });
    </script>
@endsection
