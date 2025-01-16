@extends('frontend.layouts.main')
@section('title', 'About')
@section('content')

    <main class=" ">
        <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="index.html">Home</a>
                    <a href="#" class="active-nav" aria-current="page">About</a>
                </nav>
            </div>
            <hr>
        </section>


        <!-- About Section Start -->
        <section class="container mt-3">
            <div class="about-section">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <h1 class="title text-dark text-start">About Us</h1>
                        <h4 class="text-secondary fs-5 text-start">WELCOME TO OUR <span style="color: #f39c12;">SAJIO
                                RENT</span>
                            COMPANY </h4>
                        <p class="text-start"> Amorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae nibh
                            nisl.
                            Cras etitikis mauris egeth lorem ultricies ferme is ntum a inti diam. Morbi
                            mollis pellden tesque offs aiug ueia nec rhoncus. Nam ute ultricies.Amorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vitae nibh nisl.
                            Cras etitikis mauris egeth lorem ultricies ferme is ntum a inti diam. Morbi
                            mollis pellden tesque offs aiug ueia nec rhoncus. Nam ute ultricies.Amorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vitae nibh nisl.
                            Cras etitikis mauris egeth lorem ultricies ferme is ntum a inti diam. Morbi
                            mollis pellden tesque offs aiug ueia nec rhoncus. Nam ute ultricies.Amorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vitae nibh nisl.
                            Cras etitikis mauris egeth lorem ultricies ferme is ntum a inti diam. Morbi
                            mollis pellden tesque offs aiug ueia nec rhoncus. Nam ute ultricies.Amorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vitae nibh nisl.
                            Cras etitikis mauris egeth lorem ultricies ferme is ntum a inti diam. Morbi
                            mollis pellden tesque offs aiug ueia nec rhoncus. Nam ute ultricies.Amorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vitae nibh nisl.
                            Cras etitikis mauris egeth lorem ultricies ferme is ntum a inti diam. Morbi
                            mollis pellden tesque offs aiug ueia nec rhoncus. Nam ute ultricies.Amorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vitae nibh nisl.
                            Cras etitikis mauris egeth lorem ultricies ferme is ntum a inti diam. Morbi
                            mollis pellden tesque offs aiug ueia nec rhoncus. Nam ute ultricies.
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <img alt="A beautiful house with a red roof surrounded by trees and greenery"
                            class="img-fluid rounded shadow"
                            src="https://storage.googleapis.com/a1aa/image/jR8EVe5c5VS1EavtbJOQSChAT4DGOyXAT9NgeirfcTiGipgnA.jpg" />
                    </div>
                </div>
            </div>

        </section>
        <!-- About Section End -->
        <!-- Rooms and property Section Start -->

        <section class="container">
            <div class="rent-property">
                <div class="header text-center mb-5">
                    <h1>Meet the Team Behind Your Rental Experience</h1>
                    <p class="text-secondary fs-5">Dedicated professionals ensuring seamless and hassle-free rental
                        solutions for
                        you.</p>
                </div>
                <div class="row justify-content-center">
                    <!-- Team Member 1 -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                        <div class="card">
                            <img alt="Sagar Timilsina" class="img-fluid" height="200px"
                                src="{{ asset('frontend//assets/images/team2.jpeg') }}" />
                            <a href="#" class="text-decoration-none">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Sagar Timilsina</h5>
                                    <p class="card-text">Rental Property Manager</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                        <div class="card">
                            <img alt="Prakriti Timilsina" class="img-fluid"
                                src="{{ asset('frontend//assets/images/team2.jpeg') }}" />
                            <a href="#" class="text-decoration-none">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Prakriti Timilsina</h5>
                                    <p class="card-text">Customer Relations Manager</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                        <div class="card">
                            <img alt="Aashish Paudel" class="img-fluid"
                                src="{{ asset('frontend//assets/images/team2.jpeg') }}" />
                            <a href="#" class="text-decoration-none">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Aashish Paudel</h5>
                                    <p class="card-text">Marketing Specialist</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Team Member 4 -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                        <div class="card">
                            <img alt="Pramila Timilsina" class="img-fluid"
                                src="{{ asset('frontend//assets/images/team2.jpeg') }}" />
                            <a href="#" class="text-decoration-none">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Pramila Timilsina</h5>
                                    <p class="card-text">Operations Manager</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial Section Start -->
        <section class="container">
            <div class="testimonial-section">
                <div class="header text-center ">
                    <h1>What Our Clients Say</h1>
                    <h2>
                        <p><i class="fas fa-quote-right"></i></p>
                        Real feedback from our satisfied customers about their experiences.
                    </h2>
                </div>
                <div id="testimonial-carousel" class="owl-carousel owl-theme">
                    <!-- Testimonial 1 -->
                    <div class="item">
                        <div class="testimonial-card text-center">
                            <img src="https://storage.googleapis.com/a1aa/image/D32lJ6Gz1up8K1Wlu1NNtfggfdYbVhfWMRa4OTPhc9ifwXIPB.jpg"
                                alt="Single Rakib" class="rounded-circle mb-3" width="100" height="100">
                            <h3>Single Rakib</h3>
                            <h4 class="text-secondary">Softhopper Manager</h4>
                            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae nibh nisl."</p>
                            <div class="stars text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Add more testimonials below -->
                    <div class="item">
                        <div class="testimonial-card text-center">
                            <img src="https://storage.googleapis.com/a1aa/image/D32lJ6Gz1up8K1Wlu1NNtfggfdYbVhfWMRa4OTPhc9ifwXIPB.jpg"
                                alt="Sophia Johnson" class="rounded-circle mb-3" width="100" height="100">
                            <h3>Sophia Johnson</h3>
                            <h4 class="text-secondary">Product Manager</h4>
                            <p>"Amazing service! The process was smooth and hassle-free. Highly recommend."</p>
                            <div class="stars text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-card text-center">
                            <img src="https://storage.googleapis.com/a1aa/image/D32lJ6Gz1up8K1Wlu1NNtfggfdYbVhfWMRa4OTPhc9ifwXIPB.jpg"
                                alt="Michael Lee" class="rounded-circle mb-3" width="100" height="100">
                            <h3>Michael Lee</h3>
                            <h4 class="text-secondary">Entrepreneur</h4>
                            <p>"The team is professional and attentive. My rental needs were handled perfectly."</p>
                            <div class="stars text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Testimonial Section End -->

        <!-- FAQ Section Start -->
        <section class="container">
            <div class="faq-section">
                <div class="faq-header">
                    <h1>Frequently Asked Questions</h1>
                    <p>Find answers to some of the most commonly asked questions about our rental system.</p>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h5>How does the rental system work?</h5>
                        <span class="toggle-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>Our rental system allows you to browse available items, select your preferred rental period, and
                            complete
                            your booking online. You can also manage your rentals through your account.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h5>What items can I rent?</h5>
                        <span class="toggle-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>You can rent a wide variety of items, including:</p>
                        <ul>
                            <li>Electronics (e.g., laptops, cameras)</li>
                            <li>Furniture</li>
                            <li>Event supplies</li>
                            <li>Vehicles</li>
                        </ul>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h5>What is the payment process?</h5>
                        <span class="toggle-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>You can pay securely through our platform using credit/debit cards, online wallets, or bank
                            transfers.
                            Payments must be completed before the rental period begins.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h5>Can I extend my rental period?</h5>
                        <span class="toggle-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, you can extend your rental period by logging into your account and modifying your booking.
                            Additional charges may apply.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <h5>What is the cancellation policy?</h5>
                        <span class="toggle-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>You can cancel your booking up to 24 hours before the rental period starts for a full refund.
                            Cancellations made within 24 hours may incur a fee.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQ Section End -->


    </main>

    <script>
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', () => {
                const answer = item.nextElementSibling;
                const icon = item.querySelector('.toggle-icon i');

                // Toggle visibility of the answer
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                    icon.className = 'fa fa-plus';
                } else {
                    answer.style.display = 'block';
                    icon.className = 'fa fa-minus';
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#testimonial-carousel").owlCarousel({
                loop: true, // Enables looping of the carousel
                nav: false, // Disables navigation arrows
                dots: true, // Enables pagination dots
                autoplay: true, // Enables auto-rotation of the carousel
                autoplayTimeout: 3000, // Time between each slide
                autoplayHoverPause: true, // Pause autoplay on hover
                rewind: true, // Enables the looping behavior, ensuring that the last item loops back to the first
                responsive: {
                    0: {
                        items: 1
                    }, // Displays 1 item for small screens
                    600: {
                        items: 1
                    }, // Displays 1 item for medium screens
                    992: {
                        items: 2
                    }, // Displays 2 items for larger screens
                    1400: {
                        items: 3
                    } // Displays 3 items for extra-large screens
                }
            });

        });
    </script>
    <script>
        // JavaScript to handle image click and modal image update
        document.querySelectorAll('[data-bs-image]').forEach(imgLink => {
            imgLink.addEventListener('click', function() {
                const imgSrc = this.getAttribute('data-bs-image');
                const modalImg = document.getElementById('modalImage');
                modalImg.setAttribute('src', imgSrc);
            });
        });
    </script>

@endsection
