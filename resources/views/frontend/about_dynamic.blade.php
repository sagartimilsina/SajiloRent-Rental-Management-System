@extends('frontend.layouts.main')
@section('title', 'About')
@section('content')

    <main>


        <!-- About Section Start -->
        <section class="container mt-3">
            <div class="about-section">
                <div class="row">
                    <div class="{{ @$about->image ? 'col-lg-6 col-md-12' : 'col-12' }}">
                        <h1 class="title text-dark text-start">{{ @$about->head }}</h1>
                        <h4 class="text-secondary fs-5 text-start">{{ @$about->title }}</h4>
                        <p class="text-start" style="text-align: justify">
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
