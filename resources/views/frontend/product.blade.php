@extends('frontend.layouts.main')
@section('title', 'Product')
@section('content')
    <main>
        <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>


                    <a href="#" class="active-nav" aria-current="page">Products </a>
                </nav>
            </div>
            <hr>
        </section>
        <!-- Rooms and property Section Start -->


        <section class="rent-property mt-5">
            <div class="container">
                <!-- Header -->
                <div class="header mb-5 text-center">
                    <h1>Rooms &amp; Apartments</h1>
                    <p class="text-secondary fs-5">
                        FIND YOUR ROOMS, FOR YOUR ABILITY
                    </p>
                </div>

                <!-- Navigation Tabs -->
                <div class="container">
                    <div class="d-flex  justify-content-between align-items-center mb-4">

                        <div class="dropdown ">
                            <button class="btn btn-secondary dropdown-toggle" type="button">
                                Categories
                            </button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">Sub Category 1</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Child Category 1</a></li>
                                        <li><a class="dropdown-item" href="#">Child Category 2</a></li>
                                        <li><a class="dropdown-item" href="#">Child Category 3</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">Sub Category 2</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Child Category 4</a></li>
                                        <li><a class="dropdown-item" href="#">Child Category 5</a></li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="#">Category 3</a></li>
                            </ul>
                        </div>

                        <!-- <div class="col-lg-11">

                                    <ul class="nav nav-tabs row justify-content-end" id="propertyTabs" role="tablist">

                                        <li class="nav-item card me-3 shadow  col-lg-1" role="presentation">
                                            <button class="nav-link text-dark active-nav active" id="all-tab"
                                                data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab"
                                                aria-controls="all" aria-selected="true">
                                                All
                                            </button>
                                        </li>
                                        <li class="nav-item card me-3 shadow col-lg-2" role="presentation">
                                            <button class="nav-link text-dark " id="popular-tab" data-bs-toggle="tab"
                                                data-bs-target="#popular" type="button" role="tab" aria-controls="popular"
                                                aria-selected="false">
                                                Popular
                                            </button>
                                        </li>
                                        <li class="nav-item card me-3 shadow col-lg-2" role="presentation">
                                            <button class="nav-link text-dark " id="date-new-tab" data-bs-toggle="tab"
                                                data-bs-target="#date-new" type="button" role="tab" aria-controls="date-new"
                                                aria-selected="false">
                                                Date: Newest to Oldest
                                            </button>
                                        </li>
                                        <li class="nav-item card me-3 shadow col-lg-2" role="presentation">
                                            <button class="nav-link text-dark " id="date-old-tab" data-bs-toggle="tab"
                                                data-bs-target="#date-old" type="button" role="tab" aria-controls="date-old"
                                                aria-selected="false">
                                                Date: Oldest to Newest
                                            </button>
                                        </li>
                                        <li class="nav-item card me-3 shadow col-lg-2" role="presentation">
                                            <button class="nav-link text-dark " id="price-low-tab" data-bs-toggle="tab"
                                                data-bs-target="#price-low" type="button" role="tab" aria-controls="price-low"
                                                aria-selected="false">
                                                Price: Low to High
                                            </button>
                                        </li>
                                        <li class="nav-item card me-3 shadow col-lg-2" role="presentation">
                                            <button class="nav-link text-dark " id="price-high-tab" data-bs-toggle="tab"
                                                data-bs-target="#price-high" type="button" role="tab" aria-controls="price-high"
                                                aria-selected="false">
                                                Price: High to Low
                                            </button>
                                        </li>

                                    </ul>
                                </div> -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle shadow" type="button" id="filterDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Filters
                            </button>
                            <!-- Dropdown Menu -->
                            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                <li>
                                    <button class="dropdown-item active" id="all-tab" data-bs-toggle="tab"
                                        data-bs-target="#all" type="button" role="tab" aria-controls="all"
                                        aria-selected="true">
                                        All
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" id="popular-tab" data-bs-toggle="tab"
                                        data-bs-target="#popular" type="button" role="tab" aria-controls="popular"
                                        aria-selected="false">
                                        Popular
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" id="date-new-tab" data-bs-toggle="tab"
                                        data-bs-target="#date-new" type="button" role="tab"
                                        aria-controls="date-new" aria-selected="false">
                                        Date: Newest to Oldest
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" id="date-old-tab" data-bs-toggle="tab"
                                        data-bs-target="#date-old" type="button" role="tab"
                                        aria-controls="date-old" aria-selected="false">
                                        Date: Oldest to Newest
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" id="price-low-tab" data-bs-toggle="tab"
                                        data-bs-target="#price-low" type="button" role="tab"
                                        aria-controls="price-low" aria-selected="false">
                                        Price: Low to High
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" id="price-high-tab" data-bs-toggle="tab"
                                        data-bs-target="#price-high" type="button" role="tab"
                                        aria-controls="price-high" aria-selected="false">
                                        Price: High to Low
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Tab Content -->
                    <div class="tab-content" id="propertyTabsContent">
                        <!-- All Tab -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
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

                                <div class="text-center mb-4">
                                    <button class="btn btn-primary">Load More</button>
                                </div>
                            </div>
                        </div>
                        <!-- Popular Tab -->
                        <div class="tab-pane fade" id="popular" role="tabpanel" aria-labelledby="popular-tab">
                            <div class="row justify-content-center">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card">
                                        <img alt="Family Apartment 6" class="img-fluid"
                                            src="https://storage.googleapis.com/a1aa/image/PWGDLPshtN5iDdQkZkydACT8bgzmHSq1JMpdN7wlXCuX3b8E.jpg" />
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-body">
                                                <h5 class="card-title ">
                                                    Family Apartment 2
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

                            </div>
                        </div>
                        <!-- Date Newest to Oldest -->
                        <div class="tab-pane fade" id="date-new" role="tabpanel" aria-labelledby="date-new-tab">
                            <div class="row justify-content-center">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card">
                                        <img alt="Family Apartment 6" class="img-fluid"
                                            src="https://storage.googleapis.com/a1aa/image/PWGDLPshtN5iDdQkZkydACT8bgzmHSq1JMpdN7wlXCuX3b8E.jpg" />
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-body">
                                                <h5 class="card-title ">
                                                    Family Apartment 3
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

                            </div>
                        </div>
                        <!-- Date Oldest to Newest -->
                        <div class="tab-pane fade" id="date-old" role="tabpanel" aria-labelledby="date-old-tab">
                            <div class="row justify-content-center">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card">
                                        <img alt="Family Apartment 6" class="img-fluid"
                                            src="https://storage.googleapis.com/a1aa/image/PWGDLPshtN5iDdQkZkydACT8bgzmHSq1JMpdN7wlXCuX3b8E.jpg" />
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-body">
                                                <h5 class="card-title ">
                                                    Family Apartment 5
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
                            </div>
                        </div>
                        <!-- Price Low to High -->
                        <div class="tab-pane fade" id="price-low" role="tabpanel" aria-labelledby="price-low-tab">
                            <div class="row justify-content-center">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card">
                                        <img alt="Family Apartment 6" class="img-fluid"
                                            src="https://storage.googleapis.com/a1aa/image/PWGDLPshtN5iDdQkZkydACT8bgzmHSq1JMpdN7wlXCuX3b8E.jpg" />
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-body">
                                                <h5 class="card-title ">
                                                    Family Apartment 6
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
                            </div>
                        </div>
                        <!-- Price High to Low -->
                        <div class="tab-pane fade" id="price-high" role="tabpanel" aria-labelledby="price-high-tab">
                            <div class="row justify-content-center">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card">
                                        <img alt="Family Apartment 6" class="img-fluid"
                                            src="https://storage.googleapis.com/a1aa/image/PWGDLPshtN5iDdQkZkydACT8bgzmHSq1JMpdN7wlXCuX3b8E.jpg" />
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-body">
                                                <h5 class="card-title ">
                                                    Family Apartment
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Room and Apartments Section End -->
    </main>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll(".nav-link");

            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    // Remove 'active' class from all tabs
                    tabs.forEach(t => t.classList.remove("active", "active-nav"));

                    // Add 'active' class to the clicked tab
                    this.classList.add("active", "active-nav");
                });
            });
        });
    </script>

@endsection
