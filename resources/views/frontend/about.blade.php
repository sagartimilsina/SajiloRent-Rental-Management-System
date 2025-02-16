@extends('frontend.layouts.main')
@section('title', 'About')
@section('content')

    <main class=" ">
        <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>
                    <a href="#" class="active-nav" aria-current="page">About</a>
                </nav>
            </div>
            <hr>
        </section>


        <!-- About Section Start -->
        <section class="container mt-3">
            <div class="about-section">
                <div class="row">
                    <div class="{{ @$about->image ? 'col-lg-6 col-md-12' : 'col-12' }}">
                        <h1 class="title text-dark text-start">{{ @$about->head }}</h1>
                        <h4 class="text-secondary fs-5 text-start">{{ @$about->title }}</h4>
                        <p class="text-start"> {!! @$about->description !!} </p>
                    </div>

                    @if (@$about->image)
                        <div class="col-lg-6 col-md-12">
                            <img class="img-fluid rounded shadow" src="{{ asset('storage/' . $about->image) }}"
                                alt="About Image" />
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- About Section End -->
        <!-- Rooms and property Section Start -->

        <section class="container">
            <div class="rent-property">
                <div class="header text-center mb-5">
                    <h1>Meet the Team Behind Your Rental Experience</h1>
                    <p class="text-secondary fs-5">Dedicated professionals ensuring seamless and hassle-free rental
                        solutions for
                        you.</p>
                </div>
                <div class="row justify-content-center">
                    <!-- Team Member 1 -->

                    @foreach ($teams as $team)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                            <div class="card">
                                <img alt="{{ $team->name }}" class="img-fluid" height="200px"
                                    src="{{ asset('storage/' . $team->image) }}" />
                                <a href="#" class="text-decoration-none">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $team->name }}</h5>
                                        <p class="card-text">{{ $team->position }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- Testimonial Section Start -->
        <section class="container">
            <div class="testimonial-section">
                <div class="header text-center ">
                    <h1>What Our Clients Say</h1>
                    <h2>
                        <p><i class="fas fa-quote-right"></i></p>
                        Real feedback from our satisfied customers about their experiences.
                    </h2>
                </div>
                <div id="testimonial-carousel" class="owl-carousel owl-theme">
                    @if ($testimonials->count() > 0)
                        @foreach ($testimonials as $item)
                            <div class="item">
                                <div class="testimonial-card text-center">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                        class="rounded-circle mb-3" width="100" height="100">
                                    <h3>{{ $item->name }}</h3>
                                    <h4 class="text-secondary">{{ $item->position }}</h4>
                                    <p>{!! $item->description !!}</p>
                                    <div class="stars text-warning">
                                        @for ($i = 0; $i < $item->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @for ($i = $item->rating; $i < 5; $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No testimonials available.</p>
                    @endif
                </div>
            </div>
        </section>


        <!-- Testimonial Section End -->

        <!-- FAQ Section Start -->
        <section class="container">
            <div class="faq-section">
                <div class="faq-header">
                    <h1>Frequently Asked Questions</h1>
                    <p>Find answers to some of the most commonly asked questions about our rental system.</p>
                </div>
                @if ($faqs->count() > 0)
                    @foreach ($faqs as $faq)
                        <div class="faq-item">
                            <div class="faq-question">
                                <h5>{{ $faq->question }}</h5>
                                <span class="toggle-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
                            </div>
                            <div class="faq-answer" style="display: none;">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No FAQs available.</p>
                @endif

                <script>
                    document.querySelectorAll('.faq-question').forEach(item => {
                        item.addEventListener('click', () => {
                            const answer = item.nextElementSibling;
                            const icon = item.querySelector('.toggle-icon i');

                            // Toggle visibility of the answer
                            if (answer.style.display === 'block') {
                                answer.style.display = 'none';
                                icon.className = 'fa fa-plus';
                            } else {
                                answer.style.display = 'block';
                                icon.className = 'fa fa-minus';
                            }
                        });
                    });
                </script>
            </div>
        </section>
        <!-- FAQ Section End -->


    </main>

    {{-- <script>
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', () => {
                const answer = item.nextElementSibling;
                const icon = item.querySelector('.toggle-icon i');

                // Toggle visibility of the answer
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                    icon.className = 'fa fa-plus';
                } else {
                    answer.style.display = 'block';
                    icon.className = 'fa fa-minus';
                }
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $("#testimonial-carousel").owlCarousel({
                loop: true, // Enables looping of the carousel
                nav: false, // Disables navigation arrows
                dots: true, // Enables pagination dots
                autoplay: true, // Enables auto-rotation of the carousel
                autoplayTimeout: 3000, // Time between each slide
                autoplayHoverPause: true, // Pause autoplay on hover
                rewind: true, // Enables the looping behavior, ensuring that the last item loops back to the first
                responsive: {
                    0: {
                        items: 1
                    }, // Displays 1 item for small screens
                    600: {
                        items: 1
                    }, // Displays 1 item for medium screens
                    992: {
                        items: 2
                    }, // Displays 2 items for larger screens
                    1400: {
                        items: 3
                    } // Displays 3 items for extra-large screens
                }
            });

        });
    </script>
    <script>
        // JavaScript to handle image click and modal image update
        document.querySelectorAll('[data-bs-image]').forEach(imgLink => {
            imgLink.addEventListener('click', function() {
                const imgSrc = this.getAttribute('data-bs-image');
                const modalImg = document.getElementById('modalImage');
                modalImg.setAttribute('src', imgSrc);
            });
        });
    </script>

@endsection
