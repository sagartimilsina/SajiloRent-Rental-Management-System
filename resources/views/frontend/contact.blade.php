@extends('frontend.layouts.main')
@section('title', 'Contact')
@section('content')
    <main>
        <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="index.html">Home</a>
                    <a href="#" class="active-nav" aria-current="page">Contact Us </a>
                </nav>
            </div>
            <hr>
        </section>
        <section class="container mt-5">
            <div class="contact-section">
                <h1>We Are Available For You 24/7</h1>
                <p>OUR ONLINE SUPPORT SERVICE IS ALWAYS 24 HOURS</p>
                <div class="row align-items-center">
                    <div class="col-lg-6 card">
                        <h1 class="text-start p-4 pb-0">Get In <span style="color: #f39c12;">Touch</span> with Us</h1>
                        <div class="contact-info p-4 pt-0">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="post">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="mb-2 form-group col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name">
                                    </div>
                                    <div class="mb-2 form-group col-md-6">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                                    </div>
                                    <div class="mb-2 form-group col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input id="phone" type="tel" name="phone" class="form-control w-100" required placeholder="Enter your phone number" />
                                    </div>
                                    <div class="mb-2 form-group col-md-6">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control" id="subject" name="subject" required placeholder="Enter your subject">
                                    </div>
                                    <div class="mb-2">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" name="message" rows="4" required placeholder="Write a message"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary rounded-full">Send</button>
                            </form>
                        </div>

                    <!-- Contact Information -->
                    <div class="col-lg-6 p-3 p-md-5 ">
                        <div class="contact-info">
                            <div class="row justify-content-between ">
                                <div class="mb-5 col-md-6 ">
                                    <h5> <i class="fas fa-map-marker-alt me-2"></i>Address</h5>
                                    <a href="#" class="text-decoration-none p">112/B - Road 121, King/St Melbourne
                                        Australia</a>
                                </div>
                                <div class="mb-5 col-md-6">
                                    <h5> <i class="fas fa-envelope me-2"></i>Mail</h5>
                                    <a href="mailto:yourmail@domain.com"
                                        class="text-decoration-none ">yourmail@domain.com</a> <br> <a
                                        href="mailto:houserent@domain.com"
                                        class="text-decoration-none ">houserent@domain.com</a>
                                </div>
                            </div>
                            <div class="row justify-content-between ">
                                <div class="mb-5 col-md-6">
                                    <h5> <i class="fas fa-phone-alt me-2"></i>Call</h5>
                                    <a href="tel:+99 0215469875" class="text-decoration-none ">+99 0215469875<br> <a
                                            href="tel:+88 0215469875" class="text-decoration-none "> +88 0215469875</a>
                                </div>
                                <div class="mb-5 col-md-6">
                                    <h5> <i class="fas fa-user me-2"></i>Social account</h5>
                                    <div class="social-icons">
                                        <a href="#"><i class="fab fa-facebook "></i></a>
                                        <a href="#"><i class="fab fa-twitter "></i></a>
                                        <a href="#"><i class="fab fa-instagram "></i></a>
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
