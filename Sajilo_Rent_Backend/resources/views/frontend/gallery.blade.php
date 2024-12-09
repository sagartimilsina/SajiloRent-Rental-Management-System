@extends('frontend.layouts.main')
@section('title', 'Gallery')
@section('content')
    <main>
        <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="index.html">Home</a>
                    <a href="#" class="active-nav" aria-current="page">Gallery </a>
                </nav>
            </div>
            <hr>
        </section>
        <!-- Gallery Section Starts -->
        <section class="container gallery-section">
            <div class="">
                <h1 class="gallery-header">
                    Photo Gallery
                </h1>
                <div class="row justify-content-center">
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#imageModal"
                            data-bs-image="https://storage.googleapis.com/a1aa/image/7tyf0XT79ATfBko3RNjzNmqEh1tIXTzChapvSMpJoYWLht2TA.jpg"
                            data-bs-title="A person working on the roof of a house">
                            <img alt="A person working on the roof of a house" height="300"
                                src="https://storage.googleapis.com/a1aa/image/7tyf0XT79ATfBko3RNjzNmqEh1tIXTzChapvSMpJoYWLht2TA.jpg"
                                width="300" />
                            <div class="overlay">A person working on the roof of a house</div>
                        </div>
                    </div>
                    <!-- Repeat for other images -->
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#imageModal"
                            data-bs-image="https://storage.googleapis.com/a1aa/image/Q5XodgPXqq4CFJLZlchYLhbSudfac7zoaWh3DixyZkpdwW7JA.jpg"
                            data-bs-title="A large house in the snow">
                            <img alt="A large house in the snow" height="300"
                                src="https://storage.googleapis.com/a1aa/image/Q5XodgPXqq4CFJLZlchYLhbSudfac7zoaWh3DixyZkpdwW7JA.jpg"
                                width="300" />
                            <div class="overlay">A large house in the snow</div>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <button class="btn btn-primary">Load More</button>
                    </div>


                    <!-- Add more images as needed -->
                </div>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Image Preview" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <section class="Video-section container">
            <h1 class="gallery-header">
                Video Gallery
            </h1>
            <div class="row g-3 justify-content-center">
                <!-- Example Video -->
                <div class="col-md-3 col-sm-6">
                    <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal"
                        data-src="/assets/videos/video1.mp4" data-type="video"
                        data-title="A person working on the roof of a house">
                        <video muted>
                            <source src="/assets/videos/video1.mp4" type="video/mp4">
                        </video>
                        <div class="overlay">A person working on the roof of a house</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal"
                        data-src="/assets/videos/video1.mp4" data-type="video"
                        data-title="A person working on the roof of a house">
                        <video muted>
                            <source src="/assets/videos/video1.mp4" type="video/mp4">
                        </video>
                        <div class="overlay">A person working on the roof of a house</div>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <button class="btn btn-primary">Load More</button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="galleryModalLabel"> </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div id="modalContent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Image Preview" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

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
@endsection
