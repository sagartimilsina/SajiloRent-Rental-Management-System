@extends('frontend.layouts.main')
@section('title', 'Blogs')
@section('content')

    <main>
       
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
                @if (@$blogs->count() > 0)
                    @foreach ($blogs as $blog)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card blog-card">
                            <img alt="{{ $blog->alt_text ?? 'Blog Image' }}" class="card-img-top img-fluid"
                                src="{{ asset('storage/' . $blog->blog_image) }}" />
                            <div class="card-body blog-card-body">
                                <p class="blog-card-text">
                                    {{ $blog->created_at->format('F d, Y') }}
                                </p>
                                <h5 class="blog-card-title" style="height: 50px; overflow:hidden;">
                                    <a href="{{ route('blog.details', $blog->id) }}"
                                        class="text-wrap">{{ $blog->blog_title }}</a>
                                </h5>
                                <p class="text-wrap" style="height: 50px; overflow:hidden;">{!! substr(strip_tags($blog->blog_description), 0, 100) !!}...
                                </p>


                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <h3>No Blogs Found</h3>
                    </div>
                @endif

            </div>
        </section>

    </main>
@endsection
