@extends('frontend.layouts.main')
@section('title', '404')
@section('content')
    <main>
        <div class="container">
            <div class="row mt-3">
                <div class="text col-lg-6 col-12 mt-3">
                    <h1>404 Not Found</h1>
                    <p>Oops! The page you're looking for doesn't exist. It might have been removed or never existed in
                        the
                        first place.</p>
                    <a href="{{ route('index') }}" class=" btn btn-primary">Go to Home</a>
                </div>
                <div class="image-container col-lg-6 col-12 mt-3">
                    <img src="https://via.placeholder.com/400x250?text=Rental+404+Image" alt="404 Not Found" class="img-fluid">
                </div>
            </div>
        </div>
    </main>
@endsection
