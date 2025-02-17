@extends('frontend.layouts.main')
@section('title', 'Gallery')
@section('content')
    <main>

        <!-- Image Gallery Section -->
        <section class="container gallery-section">
            <h1 class="gallery-header">Photo Gallery</h1>
            <div class="row justify-content-center" id="imageGallery">
                @foreach ($gallery_images as $images)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="gallery-item" data-bs-toggle="modal{{ $images->id }}" data-bs-target="#imageModal"
                            data-bs-image="{{ asset('storage/' . $images->gallery_file) }}"
                            data-bs-title="{{ $images->gallery_name }}">
                            <img alt="{{ $images->gallery_name }}" height="300"
                                src="{{ asset('storage/' . $images->gallery_file) }}" width="300" />
                            <div class="overlay">{{ $images->gallery_name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Load More Button for Images -->
            @if ($gallery_images->hasMorePages())
                <div class="text-center mb-4">
                    <button id="loadMoreImages" class="btn btn-primary"
                        data-next-page="{{ $gallery_images->currentPage() + 1 }}">
                        Load More Images
                    </button>
                </div>
            @endif
        </section>

        <!-- Video Gallery Section -->
        <section class="Video-section container">
            <h1 class="gallery-header">Video Gallery</h1>
            <div class="row g-3 justify-content-center" id="videoGallery">
                @foreach ($gallery_videos as $videos)
                    <div class="col-md-3 col-sm-6">
                        <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal"
                            data-src="{{ asset('storage/' . $videos->gallery_file) }}" data-type="video"
                            data-title="{{ $videos->gallery_name }}">
                            <video muted>
                                <source src="{{ asset('storage/' . $videos->gallery_file) }}" type="video/mp4">
                            </video>
                            <div class="overlay">{{ $videos->gallery_name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Load More Button for Videos -->
            @if ($gallery_videos->hasMorePages())
                <div class="text-center mb-4">
                    <button id="loadMoreVideos" class="btn btn-primary"
                        data-next-page="{{ $gallery_videos->currentPage() + 1 }}">
                        Load More Videos
                    </button>
                </div>
            @endif
        </section>

        <!-- Gallery Section Ends -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript to update modal content dynamically
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', function() {
                const image = this.getAttribute('data-bs-image');
                const title = this.getAttribute('data-bs-title');
                document.getElementById('modalImage').src = image;
                document.getElementById('imageModalLabel').textContent = title;
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById('galleryModal');
            const modalContent = document.getElementById('modalContent');
            const modalTitle = document.getElementById('galleryModalLabel');

            modal.addEventListener('show.bs.modal', function(event) {
                const trigger = event.relatedTarget;
                const src = trigger.getAttribute('data-src');
                const type = trigger.getAttribute('data-type');
                const title = trigger.getAttribute('data-title');

                modalTitle.textContent = title;
                modalContent.innerHTML = type === 'video' ?
                    `<video controls autoplay width="100%"><source src="${src}" type="video/mp4">Your browser does not support the video tag.</video>` :
                    `<img src="${src}" alt="${title}" class="img-fluid">`;
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load More Images
            $('#loadMoreImages').on('click', function() {
                const nextPage = $(this).data('next-page');
                loadMore('image', nextPage, '#imageGallery', '#loadMoreImages');
            });

            // Load More Videos
            $('#loadMoreVideos').on('click', function() {
                const nextPage = $(this).data('next-page');
                loadMore('video', nextPage, '#videoGallery', '#loadMoreVideos');
            });

            function loadMore(type, nextPage, targetElement, loadMoreButton) {
                $.ajax({
                    url: "{{ route('load.more.gallery') }}",
                    type: 'GET',
                    data: {
                        type: type,
                        page: nextPage
                    },
                    success: function(response) {
                        if (response.html) {
                            $(targetElement).append(response.html); // Append new items
                            $(loadMoreButton).data('next-page', response.nextPage); // Update next page

                            // Hide the "Load More" button if there are no more pages
                            if (!response.hasMorePages) {
                                $(loadMoreButton).hide();
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading more items:', xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection
