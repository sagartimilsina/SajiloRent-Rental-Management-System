@extends('frontend.layouts.main')
@section('title', 'Blogs')
@section('content')

    <main>
        <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="index.html">Home</a>

                    <a href="#" class="active-nav" aria-current="page">Blogs </a>
                </nav>
            </div>
            <hr>
        </section>
        <!-- Blogs Section Start -->
        <section class="blog-section container">
            <div class="container text-center">
                <h1 class="blog-title">
                    Discover the Latest Trends & Insights in Rental Living
                </h1>
                <p class="blog-subtitle">
                    Stay updated with our latest articles on property rentals, tips, and travel destinations.
                </p>
                </p>
            </div>
            <div class="row justify-content-center">
                <div class=" col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card blog-card">
                        <img alt="A house on a cliff overlooking the ocean" class="img-fluid"
                            src="https://storage.googleapis.com/a1aa/image/HEZU1atlN0ZoOV6nfe3IIy9Dkqf5c8BW3xyeeCeiOYQwcj88E.jpg"
                            width="600" />
                        <div class="card-body blog-card-body">
                            <p class="blog-card-text">
                                July 25, 2016 | Rooms &amp; Suites
                            </p>

                            <h5 class="blog-card-title">
                                <a href="{{ route('blog_details', ['id' => '1']) }}"> Finding best places to visit in
                                    California </a>
                            </h5>

                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
                <div class=" col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card blog-card">
                        <img alt="A house on a cliff overlooking the ocean" class="img-fluid"
                            src="https://storage.googleapis.com/a1aa/image/HEZU1atlN0ZoOV6nfe3IIy9Dkqf5c8BW3xyeeCeiOYQwcj88E.jpg"
                            width="600" />
                        <div class="card-body blog-card-body">
                            <p class="blog-card-text">
                                July 25, 2016 | Rooms &amp; Suites
                            </p>

                            <h5 class="blog-card-title">
                                <a href="{{ route('blog_details', ['id' => '1']) }}"> Finding best places to visit in
                                    California </a>
                            </h5>

                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
                <div class=" col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card blog-card">
                        <img alt="A house on a cliff overlooking the ocean" class="img-fluid"
                            src="https://storage.googleapis.com/a1aa/image/HEZU1atlN0ZoOV6nfe3IIy9Dkqf5c8BW3xyeeCeiOYQwcj88E.jpg"
                            width="600" />
                        <div class="card-body blog-card-body">
                            <p class="blog-card-text">
                                July 25, 2016 | Rooms &amp; Suites
                            </p>

                            <h5 class="blog-card-title">
                                <a href="{{ route('blog_details', ['id' => '1']) }}"> Finding best places to visit in
                                    California </a>
                            </h5>

                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
                <div class=" col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card blog-card">
                        <img alt="A house on a cliff overlooking the ocean" class="img-fluid"
                            src="https://storage.googleapis.com/a1aa/image/HEZU1atlN0ZoOV6nfe3IIy9Dkqf5c8BW3xyeeCeiOYQwcj88E.jpg"
                            width="600" />
                        <div class="card-body blog-card-body">
                            <p class="blog-card-text">
                                July 25, 2016 | Rooms &amp; Suites
                            </p>

                            <h5 class="blog-card-title">
                                <a href="{{ route('blog_details', ['id' => '1']) }}"> Finding best places to visit in
                                    California </a>
                            </h5>

                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
                <div class=" col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card blog-card">
                        <img alt="A house on a cliff overlooking the ocean" class="img-fluid"
                            src="https://storage.googleapis.com/a1aa/image/HEZU1atlN0ZoOV6nfe3IIy9Dkqf5c8BW3xyeeCeiOYQwcj88E.jpg"
                            width="600" />
                        <div class="card-body blog-card-body">
                            <p class="blog-card-text">
                                July 25, 2016 | Rooms &amp; Suites
                            </p>

                            <h5 class="blog-card-title">
                                <a href="{{ route('blog_details', ['id' => '1']) }}"> Finding best places to visit in
                                    California </a>
                            </h5>

                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
