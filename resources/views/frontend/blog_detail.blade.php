@extends('frontend.layouts.main')
@section('title', 'Blog Details')
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

        .other_blogs {
            position: sticky;
            top: 30px;
        }

        .container-left .img-lists {
            display: flex;
            flex-wrap: wrap;
            row-gap: 20px;
            column-gap: 20px;
        }

        @media screen and (max-width: 992px) {
            .others_blogs_details {
                margin-top: 100px;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    </style>
    <main>
        <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>
                    <a class="" href="{{ route('blog') }}">Blogs</a>
                    <a href="#" class="active-nav" aria-current="page">Blogs Name</a>
                </nav>
            </div>
            <hr>
        </section>

        <section class="container container-left mt-4">
            <div class="row">
                <div class="col-6">
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
                <div class=" col-6">
                    <div class="image-pic">
                        <!-- Main Image -->
                        <img id="mainImage" alt="Main image of the family apartment" class="img-fluid"
                            src="https://storage.googleapis.com/a1aa/image/i51jgJIoiUJJP1F3b11UJ8RkwYZRo7t2rEV1hqtCBG0O9e5JA.jpg" />
                    </div>
                </div>

            </div>


        </section>
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
                                <a href="#"> Finding best places to visit in California </a>
                            </h5>

                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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
                                <a href="#"> Finding best places to visit in California </a>
                            </h5>

                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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
                                <a href="#"> Finding best places to visit in California </a>
                            </h5>

                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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
                                <a href="#"> Finding best places to visit in California </a>
                            </h5>

                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
            </div>


        </section>
    </main>
@endsection
