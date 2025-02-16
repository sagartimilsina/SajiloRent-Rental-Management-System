@extends('frontend.layouts.main')
@section('title', 'Properties')
@section('content')
    <main>
        <section class="rent-property mt-5">
            <div class="container">
                <!-- Header -->
                <div class="header mb-5 text-center">
                    <h1>Property and Product Rentals</h1>
                    <p class="text-secondary fs-5">
                        FIND YOUR Property and Product, FOR YOUR ABILITY
                    </p>
                </div>

                <!-- Navigation Tabs -->
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <!-- Category Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="categoryDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Categories
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                @foreach ($categories as $category)
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#">{{ $category->category_name }}</a>
                                        <ul class="dropdown-menu">
                                            @foreach ($category->subcategories as $subcategory)
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        data-category-id="{{ $category->id }}"
                                                        data-sub-category-id="{{ $subcategory->id }}">
                                                        {{ $subcategory->sub_category_name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Filter Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle shadow" type="button" id="filterDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Filters
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                <li><button class="dropdown-item" data-filter="all">All</button></li>
                                <li><button class="dropdown-item" data-filter="popular">Popular</button></li>
                                <li><button class="dropdown-item" data-filter="date-new">Date: Newest to Oldest</button>
                                </li>
                                <li><button class="dropdown-item" data-filter="date-old">Date: Oldest to Newest</button>
                                </li>
                                <li><button class="dropdown-item" data-filter="price-low">Price: Low to High</button></li>
                                <li><button class="dropdown-item" data-filter="price-high">Price: High to Low</button></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Property Listing -->
                    <div id="property-list">
                        @include('frontend.property.partials.property_list', ['properties' => $properties])
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle category and subcategory filter
            $('.dropdown-submenu .dropdown-item').on('click', function(e) {
                e.preventDefault();
                const categoryId = $(this).data('category-id');
                const subCategoryId = $(this).data('sub-category-id');

                $.ajax({
                    url: '{{ route('properties.filter') }}',
                    method: 'GET',
                    data: {
                        category_id: categoryId,
                        sub_category_id: subCategoryId
                    },
                    success: function(response) {
                        $('#property-list').html(response.properties);
                        $('.pagination-container').html(response.pagination);
                    },
                    error: function(xhr) {
                        console.error('Error filtering properties:', xhr);
                    }
                });
            });

            // Handle other filters (e.g., price, date)
            $('[data-filter]').on('click', function() {
                const filter = $(this).data('filter');

                $.ajax({
                    url: '{{ route('properties.filter') }}',
                    method: 'GET',
                    data: {
                        filter: filter
                    },
                    success: function(response) {
                        $('#property-list').html(response.properties);
                        $('.pagination-container').html(response.pagination);
                    },
                    error: function(xhr) {
                        console.error('Error applying filter:', xhr);
                    }
                });
            });
        });
    </script>
@endsection
