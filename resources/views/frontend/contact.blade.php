@extends('frontend.layouts.main')
@section('title', 'Contact')
@section('content')
    <main>
        {{-- <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="index.html">Home</a>
                    <a href="#" class="active-nav" aria-current="page">Contact Us </a>
                </nav>
            </div>
            <hr>
        </section> --}}
        <section class="container mt-5">
            <div class="contact-section">
                <h1>We Are Available For You 24/7</h1>
                <p>OUR ONLINE SUPPORT SERVICE IS ALWAYS 24 HOURS</p>
                <div class="row align-items-center">
                    <div class="col-lg-6  card ">
                        <h1 class="text-start p-4 pb-0">Get In <span style="color: #f39c12;">Touch</span> with Us</h1>
                        <div class="contact-info p-4 pt-0">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="post">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="mb-2 form-group col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required
                                            placeholder="Enter your name" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2 form-group col-md-6">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" required
                                            placeholder="Enter your email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2 form-group col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input id="phone" type="tel" name="phone" class="form-control w-100"
                                            required placeholder="Enter your phone number" value="{{ old('phone') }}" />
                                        @error('phone')
                                            <div class="text-danger">Invalid Phone Number.</br>Phone number should contain only
                                                numbers.</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2 form-group col-md-6">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control" id="subject" name="subject" required
                                            placeholder="Enter your subject" value="{{ old('subject') }}">
                                        @error('subject')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" name="message" rows="4" required placeholder="Write a message">{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary rounded-full">Send</button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-lg-6 p-3 p-md-5 ">
                        <div class="contact-info">
                            <div class="row justify-content-between ">
                                <div class="mb-5 col-md-6 ">
                                    <h5> <i class="fas fa-map-marker-alt me-2"></i>Address</h5>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($contactInfo->address) }}"
                                        class="text-decoration-none p" target="_blank">
                                        {{ $contactInfo->address }}
                                    </a>

                                </div>
                                <div class="mb-5 col-md-6">
                                    <h5> <i class="fas fa-envelope me-2"></i>Mail</h5>
                                    <a href="mailto:{{ $contactInfo->email }}"
                                        class="text-decoration-none ">{{ $contactInfo->email }}</a> <br> <a
                                        href="mailto:{{ $contactInfo->email_2 }}"
                                        class="text-decoration-none ">{{ $contactInfo->email_2 }}</a>
                                </div>
                            </div>
                            <div class="row justify-content-between ">
                                <div class="mb-5 col-md-6">
                                    <h5> <i class="fas fa-phone-alt me-2"></i>Call</h5>
                                    <a href="tel:{{ $contactInfo->phone }}"
                                        class="text-decoration-none ">{{ $contactInfo->phone }}</a><br> <a
                                        href="tel:{{ $contactInfo->phone_2 }}"
                                        class="text-decoration-none ">{{ $contactInfo->phone_2 }}</a>
                                </div>
                                <div class="mb-5 col-md-6">
                                    <h5> <i class="fas fa-user me-2"></i>Social account</h5>
                                    <div class="social-icons">
                                        @php
                                            $socialLinks = is_array($contactInfo->social_links)
                                                ? $contactInfo->social_links
                                                : json_decode($contactInfo->social_links, true);
                                        @endphp
                                        @foreach ($socialLinks as $link)
                                            <a href="{{ $link['link'] }}"
                                                style="margin-left: 5px; color: #fff; text-decoration: none;">
                                                <i class="{{ $link['icon'] }}"></i>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="map-container mt-5">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537353153167!3d-37.8172099797517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d1b1f4b0b1b!2sStone%20%26%20Chalk%20Melbourne%20Startup%20Hub!5e0!3m2!1sen!2sau!4v1633072871234!5m2!1sen!2sau"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>
@endsection
