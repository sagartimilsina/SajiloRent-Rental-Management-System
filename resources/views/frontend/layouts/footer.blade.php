<section class="footer-section">
    @php
        $categories = App\Models\Categories::where('publish_status', 1)->orderBy('created_at', 'desc')->get();
        $about = App\Models\Abouts::where('about_publish_status', 1)->where('head', 'About Us')->first();
        $about = App\Models\Abouts::where('about_publish_status', 1)->where('head', 'About Us')->first();

    @endphp
    <div class="container-fluid">
        <div class="row">
            <!-- About Section -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h2 class="section-title">About Sajilo Rent</h2>
                <div class="about-house-rent">
                    <img alt="House Rent Logo" height="150" src="{{ asset('frontend/assets/images/logo.png') }}"
                        width="150" />
                </div>
                <p class=" mt-2 text-start">
                    {!! \Illuminate\Support\Str::limit(strip_tags(@$about->description), 300, '...') !!}
                </p>




            </div>

            <!-- Place Categories -->
            <div class="col-lg-2 col-md-6 mb-4 place-category">
                <h2 class="section-title">Categories</h2>
                <ul class="list-unstyled">
                    @foreach ($categories as $category)
                        <li>
                            <a href="#" style="color: #fff; text-decoration: none;">
                                {{ $category->category_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4 place-category">
                <h2 class="section-title">Quick Links</h2>
                <ul class="list-unstyled">
                    <li><a href="{{ route('index') }}" style="color: #fff; text-decoration: none;">Home</a></li>
                    <li><a href="{{ route('about') }}" style="color: #fff; text-decoration: none;">About Us</a></li>
                    <li><a href="{{ route('gallery') }}" style="color: #fff; text-decoration: none;">Gallery</a></li>
                    <li><a href="{{ route('contact') }}" style="color: #fff; text-decoration: none;">Contact</a></li>
                    <li><a href="{{ route('blog') }}" style="color: #fff; text-decoration: none;">Blogs</a></li>
                    @php
                        // Fetch the latest application status for the authenticated user
                        $application = DB::table('request_owner_lists')
                            ->where('user_id', @Auth::user()->id)
                            ->orderBy('created_at', 'desc') // Get the latest entry by date
                            ->first();
                    @endphp

                    @if (is_null($application) || in_array($application->status, ['rejected', 'expired']))
                        <li>
                            <a style="color: #fff; text-decoration: none;" href="#" data-bs-toggle="modal"
                                data-bs-target="#listPropertyModal">
                                List your Property
                            </a>
                        </li>
                    @endif

                </ul>
            </div>

            <!-- Contact Section -->
            <div class="col-lg-2 col-md-6 mb-4 place-category">
                <h2 class="section-title">Contact Us</h2>
                <ul class="list-unstyled">
                    <li><strong>Phone:</strong><a href="tel:+977-9819113548"
                            style="color: #fff; text-decoration: none;">
                            +977-9819113548
                        </a></li>
                    <li><strong>Email:</strong>
                        <a href="mailto:support@sajiorent.com" style="color: #fff; text-decoration: none;">
                            support@sajiorent.com
                        </a>
                    </li>
                    <li><strong>Address:</strong>Pokhara, Kaski, Nepal </li>
                    <li><strong>Follow Us:</strong>
                        <a href="#" style="margin-left: 10px; color: #fff; text-decoration: none; ">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" style="margin-left: 10px; color: #fff; text-decoration: none;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" style="margin-left: 10px; color: #fff; text-decoration: none;">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Payment Support -->
            <div class="col-lg-2 col-md-6 mb-4 place-category">
                <h2 class="section-title">Payment Support</h2>
                <ul class="list-unstyled">
                    <li><strong>Accepted Payments:</strong></li>
                    <li>
                        <img src="https://cdn.esewa.com.np/ui/images/esewa_og.png?111" alt="eSewa"
                            style="margin-right: 10px; object-fit: cover;" width="50" height="30" />
                        <img src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/082018/untitled-1_110.png?NUSEVyMKG.6mmq9Jwutfm3zYrezAp4gA&itok=nwwsDR-M"
                            alt="Khalti" style="margin-right: 10px; object-fit: cover;" width="50"
                            height="30" />
                        <img src="https://w7.pngwing.com/pngs/903/316/png-transparent-stripe-payment-gateway-payment-processor-authorize-net-colored-stripes-thumbnail.png"
                            alt="Stripe" style="margin-right: 10px; object-fit: cover;" width="50"
                            height="30" />
                    </li>
                    {{-- <li><strong>Support Line:</strong><a href="tel:+977-9819113548"
                            style="color: #fff; text-decoration: none;">
                            +977-9819113548
                        </a></li>
                    <li><strong>Refunds:</strong>
                        <a href="mailto:support@sajilorent.com" style="color: #fff; text-decoration: none;">
                            support@sajilorent.com
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="row text-center mt-2 ">
            <div class="col-12">
                <p class="text-white">Copyright © @php
                    echo date('Y');
                @endphp <span style="color: #f39c12;">Sajilo Rent
                        Group.</span> All
                    rights reserved.</p>
            </div>
        </div>
    </div>
</section>
