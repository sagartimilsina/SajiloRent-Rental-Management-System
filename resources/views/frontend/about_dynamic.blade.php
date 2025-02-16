@extends('frontend.layouts.main')
@section('title', 'About')
@section('content')

    <main>
        <section class="breadcrumb-hero">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>
                    <a href="{{ route('about') }}" class="active-nav" aria-current="page">About</a>
                    <a href="#" class="active-nav" aria-current="page">{{ @$about->head }}</a>
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
                        <p class="text-start">
                            {!! @$about->description !!}
                        </p>
                    </div>

                    @if (@$about->image)
                        <div class="col-lg-6 col-md-12">
                            <img alt="About Image" src="{{ asset('storage/' . @$about->image) }}"
                                class="img-fluid rounded shadow" />
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

@endsection
