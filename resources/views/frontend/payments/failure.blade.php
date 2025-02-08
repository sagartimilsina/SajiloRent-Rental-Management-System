@extends('frontend.layouts.main')

@section('title', 'Payment Failed')

@section('content')
    <div class="container mt-5 mb-5 d-flex justify-content-center">
        <div class="card shadow p-5 text-center" style="max-width: 500px;">
            <div>
                <img src="{{ asset('frontend/assets/images/Payment_Failed.png') }}" alt="Payment Failed" class="img-fluid mb-3"
                    style="max-height: 200px;">
            </div>
            <div class="text-center  p-3" >
                <h1 class="text-danger">Payment Failed</h1>
                <p class="text-muted">Oops! The payment was unsuccessful. Please try again later.</p>
                <a href="{{ route('index') }}" class="btn btn-primary mt-3">Go to Home</a>
            </div>
            
        </div>
    </div>
@endsection
