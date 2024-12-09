@extends('frontend.layouts.main')
@section('title', 'Product Details')
@section('content')
    <style>
        .thumbnail {
            width: 100px;
            height: auto;
            margin-right: 10px;
        }

        .price-details,
        .property-details,
        .apartment-overview {
            margin-top: 20px;
        }

        .price-details h5,
        .property-details h5,
        .apartment-overview h5 {
            color: #28a745;
        }

        .booking-form {
            border: 2px solid #28a745;
            padding: 20px;
            border-radius: 5px;
        }

        .booking-form h5 {
            color: #28a745;
        }

        .btn-request {
            background-color: #28a745;
            color: white;
        }

        .ad-unit {
            border: 2px solid #28a745;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }

        .ad-unit img {
            width: 100%;
            height: auto;
        }

        .ad-unit a {
            display: block;
            margin-top: 10px;
            color: white;
            background-color: #28a745;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .container-left {
            position: relative;
            text-align: left;
        }

        .booking-form {
            position: sticky;
            top: 30px;
        }

        .container-left .img-lists {
            display: flex;
            flex-wrap: wrap;
            row-gap: 20px;
            column-gap: 20px;
        }
    </style>
    <main>
        <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="index.html">Home</a>
                    <a class="" href="product.html">Product</a>

                    <a href="#" class="active-nav" aria-current="page">Product Name </a>
                </nav>
            </div>
            <hr>
        </section>

        <section class="container container-left  mt-4">
            <div class="row">
                <div class="col-xl-8 col-lg-7 col-md-7  col-sm-12">
                    <div class="image-pic">
                        <!-- Main Image -->
                        <img id="mainImage" alt="Main image of the family apartment" class="img-fluid" height="auto"
                            src="https://storage.googleapis.com/a1aa/image/i51jgJIoiUJJP1F3b11UJ8RkwYZRo7t2rEV1hqtCBG0O9e5JA.jpg" />

                        <!-- Thumbnails Carousel -->
                        <div class="img-lists owl-carousel owl-theme mt-2">
                            <div class="item">
                                <img alt="Thumbnail image 1" class="thumbnail img-fluid" height="100"
                                    src="https://storage.googleapis.com/a1aa/image/jwGALZI8GqI4JxeWiw8yTffKqbrUqfoqxevVMMEn7mTvnee5JA.jpg"
                                    width="100" onclick="changeMainImage(this)" />
                            </div>
                            <div class="item">
                                <img alt="Thumbnail image 2" class="thumbnail img-fluid" height="100"
                                    src="https://storage.googleapis.com/a1aa/image/xqnG5IUwZgI8C5w70owNIqdH9nn9cxouxr2XkVhFF0TN9e5JA.jpg"
                                    width="100" onclick="changeMainImage(this)" />
                            </div>
                            <div class="item">
                                <img alt="Thumbnail image 3" class="thumbnail img-fluid" height="100"
                                    src="https://storage.googleapis.com/a1aa/image/YUMOhQeCFBW8GKllUYUEm6QzlKS7lkrkBrUySkFH2c4f07zTA.jpg"
                                    width="100" onclick="changeMainImage(this)" />
                            </div>
                            <div class="item">
                                <img alt="Thumbnail image 4" class="thumbnail img-fluid" height="100"
                                    src="https://storage.googleapis.com/a1aa/image/zzCSvHZOoWbOIRQCdbfTGHvvroPlbbj9QGplEGk9Q7hb695JA.jpg"
                                    width="100" onclick="changeMainImage(this)" />
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-3">
                        Family Apartment
                    </h3>
                    <p>
                        Rent/Month: $550
                    </p>
                    <p>
                        3000 sq-ft., 3 Bedroom, Semi-furnished, Luxurious, South facing Apartment for Rent in Rangas
                        Malancha, Melbourne.
                    </p>
                    <div class="price-details">
                        <h5>
                            Price Details-
                        </h5>
                        <p>
                            <strong>
                                Rent/Month:
                            </strong>
                            $550 (negotiable)
                        </p>
                        <p>
                            <strong>
                                Service Charge:
                            </strong>
                            8,000/- Tk per month, subject to change
                        </p>
                        <p>
                            <strong>
                                Security Deposit:
                            </strong>
                            3 month's rent
                        </p>
                        <p>
                            <strong>
                                Flat Release Policy:
                            </strong>
                            3 months earlier notice required
                        </p>
                    </div>
                    <div class="property-details">
                        <h5>
                            Property Details-
                        </h5>
                        <p>
                            <strong>
                                Address &amp; Area:
                            </strong>
                            Rangas Malancha, House-68, Road-6A (Dead End Road), Dhanmondi Residential Area.
                        </p>
                        <p>
                            <strong>
                                Flat Size:
                            </strong>
                            3000 Sq Feet.
                        </p>
                        <p>
                            <strong>
                                Floor:
                            </strong>
                            A5 (5th Floor) (6 storied Building ) (South Facing Unit)
                        </p>
                        <p>
                            <strong>
                                Room Category:
                            </strong>
                            3 Large Bed Rooms with 3 Verandas, Spacious Drawing, Dining &amp; Family Living Room,
                            Highly
                            Decorated Kitchen with Store Room and Servant room with attached Toilet.
                        </p>
                        <p>
                            <strong>
                                Facilities:
                            </strong>
                            1 Modern Lift, All Modern Amenities &amp; Semi Furnished.
                        </p>
                        <p>
                            <strong>
                                Additional Facilities:
                            </strong>
                            a. Electricity with full generator load, b. Central Gas Geyser, c. 2 Car Parking with
                            Driver's
                            Accommodation, d. Community Conference Hall, e. Roof Top Beautified Garden and Grassy
                            Ground, f.
                            Cloth Hanging facility with CC camera
                        </p>
                    </div>
                    <div class="apartment-overview">
                        <h5>
                            Apartment Overview
                        </h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        Deposit / Bond
                                    </th>
                                    <th>
                                        Computer
                                    </th>
                                    <th>
                                        Q3
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        $220000.00
                                    </td>
                                    <td>
                                        Computer
                                    </td>
                                    <td>
                                        Q3
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Total Area (sq. ft.)
                                    </th>
                                    <th>
                                        Total Floors
                                    </th>
                                    <th>
                                        Q8
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        300
                                    </td>
                                    <td>
                                        8
                                    </td>
                                    <td>
                                        Q8
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Car Parking Per Space
                                    </th>
                                    <th>
                                        Air Condition
                                    </th>
                                    <th>
                                        Yes
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        02
                                    </td>
                                    <td>
                                        Yes
                                    </td>
                                    <td>
                                        Yes
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5 col-xl-4 col-lg-5 col-sm-12">
                    <div class="booking-form">
                        <h5>BOOK THIS APARTMENT</h5>
                        <form>
                            <div class="mb-3">
                                <label class="form-label" for="fullName">Full Name</label>
                                <input class="form-control" id="fullName" placeholder="Full name" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                <input class="form-control" id="phoneNumber" placeholder="+(00)0-9999-9999"
                                    type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="emailAddress">Email Address</label>
                                <input class="form-control" id="emailAddress" placeholder="example@domain.com"
                                    type="email" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="familyMember">Family Member</label>
                                <input class="form-control" id="familyMember" placeholder="Family member" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="children">Children</label>
                                <input class="form-control" id="children" placeholder="1" type="number" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="yourMessage">Your Message</label>
                                <textarea class="form-control" id="yourMessage" placeholder="Message" rows="3"></textarea>
                            </div>
                            <button class="btn btn-request w-100" type="submit">
                                Request Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <section class="rent-property mt-5">
            <div class="container">
                <!-- Header -->
                <div class="header mb-5 text-center">
                    <h1> Related &amp; Apartments</h1>
                </div>

                <!-- Navigation Tabs -->
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card">
                                <img alt="Family Apartment 6" class="img-fluid"
                                    src="https://storage.googleapis.com/a1aa/image/PWGDLPshtN5iDdQkZkydACT8bgzmHSq1JMpdN7wlXCuX3b8E.jpg" />
                                <a href="#" class="text-decoration-none">
                                    <div class="card-body">
                                        <h5 class="card-title ">
                                            Family Apartment 1
                                        </h5>
                                        <p class="card-text">
                                            <i class="fas fa-map-marker-alt">
                                            </i>
                                            Dhanmondi, Dhaka
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
                                                $200
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
                                <img alt="Family Apartment 6" class="img-fluid"
                                    src="https://storage.googleapis.com/a1aa/image/PWGDLPshtN5iDdQkZkydACT8bgzmHSq1JMpdN7wlXCuX3b8E.jpg" />
                                <a href="#" class="text-decoration-none">
                                    <div class="card-body">
                                        <h5 class="card-title ">
                                            Family Apartment 1
                                        </h5>
                                        <p class="card-text">
                                            <i class="fas fa-map-marker-alt">
                                            </i>
                                            Dhanmondi, Dhaka
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
                                                $200
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
                                <img alt="Family Apartment 6" class="img-fluid"
                                    src="https://storage.googleapis.com/a1aa/image/PWGDLPshtN5iDdQkZkydACT8bgzmHSq1JMpdN7wlXCuX3b8E.jpg" />
                                <a href="#" class="text-decoration-none">
                                    <div class="card-body">
                                        <h5 class="card-title ">
                                            Family Apartment 1
                                        </h5>
                                        <p class="card-text">
                                            <i class="fas fa-map-marker-alt">
                                            </i>
                                            Dhanmondi, Dhaka
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
                                                $200
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
                                <img alt="Family Apartment 6" class="img-fluid"
                                    src="https://storage.googleapis.com/a1aa/image/PWGDLPshtN5iDdQkZkydACT8bgzmHSq1JMpdN7wlXCuX3b8E.jpg" />
                                <a href="#" class="text-decoration-none">
                                    <div class="card-body">
                                        <h5 class="card-title ">
                                            Family Apartment 1
                                        </h5>
                                        <p class="card-text">
                                            <i class="fas fa-map-marker-alt">
                                            </i>
                                            Dhanmondi, Dhaka
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
                                                $200
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

                        <div class="text-center mb-4">
                            <button class="btn btn-primary">Load More</button>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </main>


    <script>
        // Initialize Owl Carousel
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: true, // Enable infinite looping
                margin: 10, // Spacing between items
                nav: false, // Show navigation arrows
                dots: false, // Hide dots
                responsive: {
                    0: {
                        items: 2
                    }, // Show 2 items on small screens
                    600: {
                        items: 4
                    }, // Show 3 items on medium screens
                    1000: {
                        items: 5
                    } // Show 4 items on large screens
                }
            });
        });

        // Function to change the main image
        function changeMainImage(thumbnail) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = thumbnail.src;

            // Optional: Add highlight effect to the active thumbnail
            document.querySelectorAll('.thumbnail').forEach(img => img.classList.remove('selected-thumbnail'));
            thumbnail.classList.add('selected-thumbnail');
        }
    </script>



    <script>
        // JavaScript to dynamically adjust dropdown alignment
        document.querySelectorAll('.dropdown-submenu').forEach(function(submenu) {
            submenu.addEventListener('mouseenter', function() {
                const submenuElement = submenu.querySelector('.dropdown-menu');
                const rect = submenuElement.getBoundingClientRect();

                // Check if submenu overflows the viewport
                if (rect.right > window.innerWidth) {
                    submenuElement.classList.add('left-align');
                } else {
                    submenuElement.classList.remove('left-align');
                }
            });
        });
    </script>
@endsection
