@extends('frontend.layouts.main')
@section('title', 'Home')
@section('content')
    <main>
        <!-- Slider Section Start -->
        <section class="slider-section">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('frontend/assets/images/slider1.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <p>Good Service is our passion</p>
                            <h1 class="text-white">Awesome Apartment Villa</h1>
                            <p>No matter what the weather, no matter what the situation, life will always be beautiful!
                            </p>
                            <a class="btn btn-lg" href="#">Special Offer</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('frontend/assets/images/slider2.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <p>Good Service is our passion</p>
                            <h1 class="text-white">Awesome Apartment Villa</h1>
                            <p>No matter what the weather, no matter what the situation, life will always be beautiful!
                            </p>
                            <a class="btn btn-lg" href="#">Special Offer</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('frontend/assets/images/slider3.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <p>Good Service is our passion</p>
                            <h1 class="text-white">Awesome Apartment Villa</h1>
                            <p>No matter what the weather, no matter what the situation, life will always be beautiful!
                            </p>
                            <a class="btn btn-lg" href="#">Special Offer</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- Slider Section End -->
        <!-- We Provide Section Start -->
        <section class="we-provide-section">
            <div class="text-center">
                <h5 class="we-provide text-dark  ">We Provide</h5>
            </div>
            <div class="owl-carousel owl-theme" id="provide-carousel">
                <div class="item">
                    <div class="provide-icon">
                        <i class="fas fa-warehouse icon"></i>
                        <p>Hall Room</p>
                    </div>
                </div>
                <div class="item">
                    <div class="provide-icon">
                        <i class="fas fa-home icon"></i>
                        <p>Warehouse</p>
                    </div>
                </div>
                <div class="item">
                    <div class="provide-icon">
                        <i class="fas fa-church icon"></i>
                        <p>Female Mess</p>
                    </div>
                </div>
                <div class="item">
                    <div class="provide-icon">
                        <i class="fas fa-car icon"></i>
                        <p>Garage</p>
                    </div>
                </div>
                <div class="item">
                    <div class="provide-icon">
                        <i class="fas fa-building icon"></i>
                        <p>Office</p>
                    </div>
                </div>
                <div class="item">
                    <div class="provide-icon">
                        <i class="fas fa-user-tie icon"></i>
                        <p>Sublet</p>
                    </div>
                </div>
                <div class="item">
                    <div class="provide-icon">
                        <i class="fas fa-city icon"></i>
                        <p>Family House</p>
                    </div>
                </div>
                <div class="item">
                    <div class="provide-icon">
                        <i class="fas fa-building icon"></i>
                        <p>Apartment</p>
                    </div>
                </div>
                <div class="item">
                    <div class="provide-icon">
                        <i class="fas fa-tools icon"></i>
                        <p>Bachelor Mess</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- We Provide Section End -->
        <!-- Availability Section Start -->
        <section class=" availibility-section">
            <div class="container py-5">
                <h1>For rates & Availability</h1>
                <h2>Search for Rent property</h2>
                <form class="row g-3 justify-content-center">
                    <div class="col-md-3">
                        <label for="livingArea" class="form-label"> AREA</label>
                        <input type="text" class="form-control" id="livingArea"
                            placeholder="Where do you want to live?">
                    </div>
                    <div class="col-md-3">
                        <label for="type" class="form-label">TYPE</label>
                        <select id="type" class="form-select">
                            <option selected>Apartments</option>
                            <option>Rooms</option>
                            <option>House</option>
                            <option>Office</option>
                            <option>Sublet</option>
                            <option>Garage</option>
                            <option>Warehouse</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="priceMin" class="form-label">PRICE</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="priceMin" placeholder="min">
                            <span class="input-group-text">-</span>
                            <input type="text" class="form-control" id="priceMax" placeholder="max">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="for" class="form-label">FOR</label>
                        <select id="for" class="form-select">
                            <option selected>Family</option>
                            <option>Bachelor</option>
                            <option>Friend of Four</option>
                            <option>Couple</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-4">
                        <button type="submit" class="btn btn-primary">Check Availability</button>
                    </div>
                </form>
            </div>
        </section>
        <!-- Availability Section End -->
        <!-- About Section Start -->
        <section class="about-section">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h1 class="title text-dark">About Us</h1>
                    <p class="text-secondary fs-5">WELCOME TO Sajilo rent</p>
                </div>

                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-3 mb-4 position-relative">
                        <ul class="nav about-nav-responsive flex-column">
                            <li class="nav-item mb-3 me-3 active " onclick="showContent('about-company', this)">
                                <h6 class="fw-bold text-left ">
                                    About Company
                                </h6>
                            </li>
                            <li class="nav-item mb-3 " onclick="showContent('terms-condition', this)">
                                <h6 class="fw-bold text-left ">
                                    Terms & Condition
                                </h6>
                            </li>
                            <li class="nav-item mb-3 " onclick="showContent('our-specialty', this)">
                                <h6 class="fw-bold text-left ">
                                    Our specialty
                                </h6>
                            </li>
                            <li class="nav-item mb-3 " onclick="showContent('our-specialty-2', this)">
                                <h6 class="fw-bold text-left ">
                                    Our specialty 2
                                </h6>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xl-10 col-lg-9 col-md-9" id="content">
                        <div class="content-section" id="about-company">
                            <div class="row">
                                <div class="col-lg-7 col-md-12">
                                    <p class="fs-5 mb-4 text-start">
                                        Sajilo Rent is an innovative rental management system designed to address
                                        inefficiencies in traditional renting methods.
                                        It serves as a centralized platform where individuals can find and manage rental
                                        properties, including rooms, apartments, commercial spaces, tools, and vehicles,
                                        with ease.
                                        Sajilo Rent simplifies the rental experience, promotes trust, and supports
                                        cultural and social integration.
                                    </p>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            Amorem ipsum dolor sit amet, consectetur
                                        </li>
                                        <li class="mb-2">
                                            Cras etitikis mauris egeth lorem ultricies
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-5 col-md-12">
                                    <img alt="A beautiful house with a red roof surrounded by trees and greenery"
                                        class="img-fluid rounded shadow"
                                        src="https://storage.googleapis.com/a1aa/image/jR8EVe5c5VS1EavtbJOQSChAT4DGOyXAT9NgeirfcTiGipgnA.jpg"
                                        width="400" />
                                </div>
                            </div>
                        </div>

                        <div class="content-section d-none" id="terms-condition">
                            <div class="row">
                                <div class="col-lg-7">
                                    <p class="fs-5 mb-4 text-start">
                                        Terms and conditions content goes here. Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit.
                                    </p>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            For Property Owners:
                                            Term 1: Provide accurate and up-to-date property details; false information
                                            may result in removal.
                                            Term 2:Ensure your property complies with all local and national laws.
                                            Term 3:You are responsible for drafting and managing rental agreements with
                                            tenants.
                                            Term 4:Address tenant maintenance requests promptly.
                                            Term 5:Prohibited activities include spam listings, discrimination, and
                                            promoting illegal activities.

                                        </li>
                                        <li class="mb-2">
                                            For Property Seekers
                                            Term 1: rovide truthful information and verify property details before
                                            renting.
                                            Term 2:Respect property owners during communication; harassment is
                                            prohibited.
                                            Term 3:Payments made through Sajilo Rent must follow platform guidelines.
                                            Term 4:Ensure you inspect properties physically or online before finalizing
                                            agreements.
                                            Term 5:Use the platform only for rental-related purposes; fraudulent
                                            activities are forbidden.
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-5">
                                    <img alt="A beautiful house with a red roof surrounded by trees and greenery"
                                        class="img-fluid rounded shadow"
                                        src="https://storage.googleapis.com/a1aa/image/6RmFXAl0oVrODFGPqph0T38LvLQ2R5NgWTfgFkNjI446LK4JA.jpg"
                                        width="400" />
                                </div>
                            </div>
                        </div>

                        <div class="content-section d-none" id="our-specialty">
                            <div class="row">
                                <div class="col-lg-7">
                                    <p class="fs-5 mb-4 text-start">
                                        Our specialty content goes here. Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit.
                                    </p>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            Specialty 1: Lorem ipsum dolor sit amet
                                        </li>
                                        <li class="mb-2">
                                            Specialty 2: Cras etitikis mauris egeth lorem ultricies
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-5">
                                    <img alt="A beautiful house with a red roof surrounded by trees and greenery"
                                        class="img-fluid rounded shadow"
                                        src="https://storage.googleapis.com/a1aa/image/jR8EVe5c5VS1EavtbJOQSChAT4DGOyXAT9NgeirfcTiGipgnA.jpg"
                                        width="400" />
                                </div>
                            </div>
                        </div>

                        <div class="content-section d-none" id="our-specialty-2">
                            <div class="row">
                                <div class="col-lg-7 col-md-12">
                                    <p class="fs-5 mb-4 text-start">
                                        Our second specialty content goes here. Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit.
                                    </p>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            Specialty 1: Lorem ipsum dolor sit amet
                                        </li>
                                        <li class="mb-2">
                                            Specialty 2: Cras etitikis mauris egeth lorem ultricies
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-5">
                                    <img alt="A beautiful house with a red roof surrounded by trees and greenery"
                                        class="img-fluid rounded shadow"
                                        src="https://storage.googleapis.com/a1aa/image/6RmFXAl0oVrODFGPqph0T38LvLQ2R5NgWTfgFkNjI446LK4JA.jpg"
                                        width="400" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Section End -->
        <!-- Rooms and property Section Start -->

        <section class="rent-property">
            <div class="container">

                <div class="header mb-5">
                    <h1>
                        Rooms &amp; Apartments
                    </h1>
                    <p class="text-secondary fs-5">
                        FIND YOUR ROOMS, FOR YOUR ABALITY
                    </p>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">

                        <div class="card">
                            <img alt="Family Apartment 1" class="img-fluid"
                                src="https://storage.googleapis.com/a1aa/image/8fE5PXpZO23UZq4bAj6EX0HOCLXrDNmfPmntllU17aEhdvxTA.jpg" />
                            <a href="#" class="text-decoration-none">
                                <div class="card-body">
                                    <h5 class="card-title ">
                                        Family Apartment
                                    </h5>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt">
                                        </i>
                                        Bagar, Pokhara
                                    </p>
                                    <div class="row ">

                                        <div class="col-6 services-icon">
                                            <p class="card-text">
                                                <i class="fas fa-bed">
                                                </i>
                                                3 Bedrooms
                                            </p>
                                        </div>
                                        <div class="col-6 services-icon">
                                            <p class="card-text">
                                                <i class="fas fa-bath">
                                                </i>
                                                2 Bathroom
                                            </p>
                                        </div>
                                    </div>
                                    <div class="price">
                                        <p class="text-center">
                                            Rs. 200
                                        </p>
                                    </div>

                                </div>
                            </a>
                            <div class="card-footer d-flex justify-content-between  ">

                                <a class="text-muted" href="#">
                                    <i class="fas fa-share-alt">
                                    </i>
                                </a>
                                <a class="text-muted" href="#">
                                    <i class="far fa-star">
                                    </i>
                                </a>

                            </div>
                        </div>

                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card">
                            <img alt="Family Apartment 2" class="img-fluid"
                                src="https://storage.googleapis.com/a1aa/image/3jmEupGczybwCNOIT8goQyJXVaC0Oedj6EIHXLqG5CLwu34JA.jpg" />
                            <a href="#" class="text-decoration-none">
                                <div class="card-body">
                                    <h5 class="card-title ">
                                        Family Apartment
                                    </h5>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt">
                                        </i>
                                        Lakeside, Pokhara
                                    </p>
                                    <div class="row ">

                                        <div class="col-6 services-icon">
                                            <p class="card-text">
                                                <i class="fas fa-bed">
                                                </i>
                                                3 Bedrooms
                                            </p>
                                        </div>
                                        <div class="col-6 services-icon">
                                            <p class="card-text">
                                                <i class="fas fa-bath">
                                                </i>
                                                2 Bathroom
                                            </p>
                                        </div>
                                    </div>
                                    <div class="price">
                                        <p class="text-center">
                                            Rs. 200
                                        </p>
                                    </div>

                                </div>
                            </a>
                            <div class="card-footer d-flex justify-content-between  ">

                                <a class="text-muted" href="#">
                                    <i class="fas fa-share-alt">
                                    </i>
                                </a>
                                <a class="text-muted" href="#">
                                    <i class="far fa-star">
                                    </i>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card">
                            <img alt="Family Apartment 3" class="img-fluid"
                                src="https://storage.googleapis.com/a1aa/image/lri1ak82XjJtA5VJh1P0TIwX8jebgANyaOyDQp3Ydhsuu34JA.jpg" />
                            <a href="#" class="text-decoration-none">
                                <div class="card-body">
                                    <h5 class="card-title ">
                                        Family Apartment
                                    </h5>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt">
                                        </i>
                                        Newroad, Kathmandu
                                    </p>
                                    <div class="row ">

                                        <div class="col-6 services-icon">
                                            <p class="card-text">
                                                <i class="fas fa-bed">
                                                </i>
                                                3 Bedrooms
                                            </p>
                                        </div>
                                        <div class="col-6 services-icon">
                                            <p class="card-text">
                                                <i class="fas fa-bath">
                                                </i>
                                                2 Bathroom
                                            </p>
                                        </div>
                                    </div>
                                    <div class="price">
                                        <p class="text-center">
                                            Rs. 200
                                        </p>
                                    </div>

                                </div>
                            </a>
                            <div class="card-footer d-flex justify-content-between  ">

                                <a class="text-muted" href="#">
                                    <i class="fas fa-share-alt">
                                    </i>
                                </a>
                                <a class="text-muted" href="#">
                                    <i class="far fa-star">
                                    </i>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card">
                            <img alt="Family Apartment 4" class="img-fluid"
                                src="https://storage.googleapis.com/a1aa/image/B9T5aE0c0ZKzB5yeNXfiHATCuW2CBaEAe5TPVWxOkqE46eGPB.jpg" />
                            <a href="#" class="text-decoration-none">
                                <div class="card-body">
                                    <h5 class="card-title ">
                                        Family Apartment
                                    </h5>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt">
                                        </i>
                                        Rupandehi, Lumbini
                                    </p>
                                    <div class="row ">

                                        <div class="col-6 services-icon">
                                            <p class="card-text">
                                                <i class="fas fa-bed">
                                                </i>
                                                3 Bedrooms
                                            </p>
                                        </div>
                                        <div class="col-6 services-icon">
                                            <p class="card-text">
                                                <i class="fas fa-bath">
                                                </i>
                                                2 Bathroom
                                            </p>
                                        </div>
                                    </div>
                                    <div class="price">
                                        <p class="text-center">
                                            Rs. 200
                                        </p>
                                    </div>

                                </div>
                            </a>
                            <div class="card-footer d-flex justify-content-between  ">

                                <a class="text-muted" href="#">
                                    <i class="fas fa-share-alt">
                                    </i>
                                </a>
                                <a class="text-muted" href="#">
                                    <i class="far fa-star">
                                    </i>
                                </a>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-center mb-4">
                    <button class="btn btn-primary">
                        View All
                    </button>
                </div>
            </div>
        </section>
        <!-- Room and Apartments Section End -->


        <section class="achievement-section">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-3 col-md-6">
                        <h1>1000+</h1>
                        <h2>Happy Customers</h2>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h1>500+</h1>
                        <h2>Projects Completed</h2>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h1>200+</h1>
                        <h2>Team Members</h2>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h1>50+</h1>
                        <h2>Awards Won</h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- Achievement Section End -->
        <!-- Gallery Section Start -->
        <section class="gallery">
            <div class="container mt-5">
                <div class="row">
                    <div class=" col-xl-6 col-lg-8 col-md-12">
                        <div class="row">
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-bs-image="https://storage.googleapis.com/a1aa/image/fMHbWxhR3YwtTyYt9ywo0nm8ofweMuKgNvgxXnGPTBI1hljnA.jpg">
                                    <img alt="A person jumping with a blueprint in hand in front of a house under construction"
                                        class="img-fluid gallery-image"
                                        src="https://storage.googleapis.com/a1aa/image/fMHbWxhR3YwtTyYt9ywo0nm8ofweMuKgNvgxXnGPTBI1hljnA.jpg" />
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-bs-image="https://storage.googleapis.com/a1aa/image/enjxPA0lVvQDaqOge7TucTxC9MpfhMv4gHcvDkceyR0jDLHPB.jpg">
                                    <img alt="A vintage car parked in front of a house" class="img-fluid gallery-image"
                                        src="https://storage.googleapis.com/a1aa/image/enjxPA0lVvQDaqOge7TucTxC9MpfhMv4gHcvDkceyR0jDLHPB.jpg" />
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-bs-image="https://storage.googleapis.com/a1aa/image/y1DhPkigC250O5ekCGZBR3g0k1ndpiDLBJdGe9qonC11wyxTA.jpg">
                                    <img alt="A large house covered in snow" class="img-fluid gallery-image"
                                        src="https://storage.googleapis.com/a1aa/image/y1DhPkigC250O5ekCGZBR3g0k1ndpiDLBJdGe9qonC11wyxTA.jpg" />
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-bs-image="https://storage.googleapis.com/a1aa/image/fMHbWxhR3YwtTyYt9ywo0nm8ofweMuKgNvgxXnGPTBI1hljnA.jpg">
                                    <img alt="A person jumping with a blueprint in hand in front of a house under construction"
                                        class="img-fluid gallery-image"
                                        src="https://storage.googleapis.com/a1aa/image/fMHbWxhR3YwtTyYt9ywo0nm8ofweMuKgNvgxXnGPTBI1hljnA.jpg" />
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-bs-image="https://storage.googleapis.com/a1aa/image/enjxPA0lVvQDaqOge7TucTxC9MpfhMv4gHcvDkceyR0jDLHPB.jpg">
                                    <img alt="A vintage car parked in front of a house" class="img-fluid gallery-image"
                                        src="https://storage.googleapis.com/a1aa/image/enjxPA0lVvQDaqOge7TucTxC9MpfhMv4gHcvDkceyR0jDLHPB.jpg" />
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-bs-image="https://storage.googleapis.com/a1aa/image/y1DhPkigC250O5ekCGZBR3g0k1ndpiDLBJdGe9qonC11wyxTA.jpg">
                                    <img alt="A large house covered in snow" class="img-fluid gallery-image"
                                        src="https://storage.googleapis.com/a1aa/image/y1DhPkigC250O5ekCGZBR3g0k1ndpiDLBJdGe9qonC11wyxTA.jpg" />
                                </a>
                            </div>
                            <!-- Add more images similarly -->
                        </div>
                    </div>

                    <div class=" col-xl-6 col-md-12 col-lg-4 ">
                        <h1 class="gallery-title">
                            Our Photo Gallery
                        </h1>
                        <h2 class="gallery-subtitle">
                            Best of our Event portfolio Photos
                        </h2>
                        <p class="gallery-description">
                            Amorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae nibh nisl. Cras ettikis
                            mauris
                            eget lorem ultricies ferme ntum a inti diam. Morbi mollis pellen tesque offs aiug ueia nec
                            rhoncus.
                            Nam ute ultricies.
                        </p>
                        <button class="btn  btn-primary btn-lg">
                            ALL PHOTOS &amp; VIDEO
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalImage" src="" alt="Image Preview" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- Gallery Section End -->
        <!-- list your property contact  starts-->

        <section class="list-your-section">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-6">
                        <h1 class="fw-bold text-white">Do you want to rent your property?</h1>
                        <h6 class=" " style="color:#f39c12">Call us and list your property here.</h6>
                    </div>
                    <div class="col-md-6">
                        <h6>+977 9819113548</h6>
                        <h6>info.sajilorent@gmail.com</h6>
                        <a href="contact.html" class="btn btn-primary "> Contact Us</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- list your property contact  ends -->
        <!-- Testimonial Section Start -->
        <section class="container">
            <div class="testimonial-section">
                <h1>What Our Clients Say</h1>
                <h2>
                    <p><i class="fas fa-quote-right"></i></p>
                    Real feedback from our satisfied customers about their experiences.
                </h2>
                <div class="testimonial-container">
                    <div id="testimonial-carousel" class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="testimonial-card">
                                <img src="https://storage.googleapis.com/a1aa/image/D32lJ6Gz1up8K1Wlu1NNtfggfdYbVhfWMRa4OTPhc9ifwXIPB.jpg"
                                    alt="Single Rakib">
                                <h3>Single Rakib</h3>
                                <h4>Softhopper Manager</h4>
                                <p>Amorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae nibh nisl.</p>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Add more testimonial items below -->
                        <div class="item">
                            <div class="testimonial-card">
                                <img src="https://storage.googleapis.com/a1aa/image/D32lJ6Gz1up8K1Wlu1NNtfggfdYbVhfWMRa4OTPhc9ifwXIPB.jpg"
                                    alt="Single Rakib">
                                <h3>Single Rakib</h3>
                                <h4>Softhopper Manager</h4>
                                <p>Amorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae nibh nisl.</p>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-card">
                                <img src="https://storage.googleapis.com/a1aa/image/D32lJ6Gz1up8K1Wlu1NNtfggfdYbVhfWMRa4OTPhc9ifwXIPB.jpg"
                                    alt="Single Rakib">
                                <h3>Single Rakib</h3>
                                <h4>Softhopper Manager</h4>
                                <p>Amorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae nibh nisl.</p>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-card">
                                <img src="https://storage.googleapis.com/a1aa/image/D32lJ6Gz1up8K1Wlu1NNtfggfdYbVhfWMRa4OTPhc9ifwXIPB.jpg"
                                    alt="Single Rakib">
                                <h3>Single Rakib</h3>
                                <h4>Softhopper Manager</h4>
                                <p>Amorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae nibh nisl.</p>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-card">
                                <img src="https://storage.googleapis.com/a1aa/image/D32lJ6Gz1up8K1Wlu1NNtfggfdYbVhfWMRa4OTPhc9ifwXIPB.jpg"
                                    alt="Single Rakib">
                                <h3>Single Rakib</h3>
                                <h4>Softhopper Manager</h4>
                                <p>Amorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae nibh nisl.</p>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- Testimonial Section End -->
        <!-- Available section start -->
        <section class="container">
            <div class="contact-section">
                <h1>We Are Available <br> For You 24/7</h1>
                <p>OUR ONLINE SUPPORT SERVICE IS ALWAYS 24 HOURS</p>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537353153167!3d-37.8172099797517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d1b1f4b0b1b!2sStone%20%26%20Chalk%20Melbourne%20Startup%20Hub!5e0!3m2!1sen!2sau!4v1633072871234!5m2!1sen!2sau"
                                width="600" height="450" style="border:0;" allowfullscreen=""
                                loading="lazy"></iframe>
                        </div>
                    </div>
                    <div class="col-md-6">
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
        </section>
        <!-- Available section end -->
        <!-- Blogs Section Start -->
        <section class="blog-section container">
            <div class="container text-center">
                <h1 class="blog-title">
                    Our Blogs
                </h1>
                <p class="blog-subtitle">
                    Discover the Latest Trends & Insights in Rental Living
                </p>
            </div>
            <div class="row">
                <div class="  col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card blog-card">
                        <img alt="Aerial view of a small town with houses and trees" class="card-img-top img-fluid"
                            src="https://storage.googleapis.com/a1aa/image/lRe0UTQVo80NFCxe7ETkyNqHCdzVJ9MHPdUe8VDOub5pbknnA.jpg"
                            width="600" />
                        <div class="card-body blog-card-body">
                            <p class="blog-card-text">
                                July 25, 2016 | Rooms &amp; Suites
                            </p>
                            <h5 class="blog-card-title">
                                <a href="blog_details.html"> Finding best places to visit in California </a>
                            </h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class=" col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card blog-card">
                        <img alt="A church with a tall steeple in a small town" class="card-img-top img-fluid"
                            src="https://storage.googleapis.com/a1aa/image/w7YI5MZPHGJkBthc1yfoa2gLmR7y68FPmJIy1nAxjsI7G55JA.jpg"
                            width="600" />
                        <div class="card-body blog-card-body">
                            <p class="blog-card-text">
                                July 25, 2016 | Rooms &amp; Suites
                            </p>
                            <h5 class="blog-card-title">
                                <a href="blog_details.html"> Finding best places to visit in California </a>
                            </h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class=" col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card blog-card">
                        <img alt="A house on a cliff overlooking the ocean" class="card-img-top img-fluid"
                            src="https://storage.googleapis.com/a1aa/image/HEZU1atlN0ZoOV6nfe3IIy9Dkqf5c8BW3xyeeCeiOYQwcj88E.jpg"
                            width="600" />
                        <div class="card-body blog-card-body">
                            <p class="blog-card-text">
                                July 25, 2016 | Rooms &amp; Suites
                            </p>
                            <h5 class="blog-card-title">
                                <a href="blog_details.html"> Finding best places to visit in California </a>
                            </h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
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
                                <a href="blog_details.html"> Finding best places to visit in California </a>
                            </h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center my-4">
                <button class="btn btn-primary">
                    Show All
                </button>
            </div>
        </section>
        <!-- Blogs Section End -->
    </main>
   
   

@endsection
