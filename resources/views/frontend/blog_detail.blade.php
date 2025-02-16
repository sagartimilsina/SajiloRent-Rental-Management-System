@extends('frontend.layouts.main')
@section('title', 'Blog Details')
@section('content')
    <style>
        .container-left {
            position: relative;
            text-align: left;
        }
    </style>
    <main>
     

        <section class="container container-left mt-4">
            <div class="row">
                <h3 style="color: #f39c12;"> {{ $blog->blog_title }}</h3>

                <div class="col-lg-6">
                    <p class="text-justify">{!! $blog->blog_description !!}</p>
                </div>
                <div class="col-lg-6">
                    <div class="image-pic">
                        <img id="mainImage" alt="{{ $blog->blog_title }}" class="img-fluid"
                            src="{{ asset('storage/' . $blog->blog_image) }}" />
                    </div>
                </div>

            </div>
        </section>
        @if (@$similar_blogs->count() > 0)
            <section class="blog-section container">
                <div class="container text-center">
                    <h1 class="blog-title">
                        Our Related Blogs
                    </h1>
                    <p class="blog-subtitle">
                        Stay updated with our latest articles on property rentals, tips, and travel destinations.
                    </p>
                    </p>
                </div>
                <div class="row justify-content-center">
                    @foreach ($similar_blogs as $blog)
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
                </div>
            </section>
        @endif
    </main>
@endsection
