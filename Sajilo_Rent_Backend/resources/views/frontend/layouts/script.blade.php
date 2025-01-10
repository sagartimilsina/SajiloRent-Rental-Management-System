<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    $(document).ready(function() {

        // Second Carousel Configuration
        $("#provide-carousel").owlCarousel({
            responsive: {
                0: {
                    items: 2
                }, // Corrected Configuration
                600: {
                    items: 5
                },
                1000: {
                    items: 8
                },
            },
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>',
            ],
            navContainer: ".owl-carousel", // Ensure correct selector
        });

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
    document.addEventListener("DOMContentLoaded", function() {
        // Trigger showContent for the default active content
        showContent('about-company', document.querySelector('.nav-item.active'));
    });

    function showContent(sectionId, element) {
        // Hide all content sections
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => {
            section.classList.add('d-none');
        });

        // Show the clicked section
        document.getElementById(sectionId).classList.remove('d-none');

        // Remove 'active' class from all navigation items
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.classList.remove('active-about-nav');
        });

        // Add 'active' class to the clicked nav item
        element.classList.add('active-about-nav');
    }
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
<script>
    // Create references for the scroll button
    const scrollToTopBtn = document.getElementById("scrollToTopBtn");

    // Add event listeners
    document.addEventListener("scroll", () => {
        // Check if the scroll position is more than 100vh
        if (window.scrollY > window.innerHeight) {
            scrollToTopBtn.classList.add("show"); // Show the button
        } else {
            scrollToTopBtn.classList.remove("show"); // Hide the button
        }
    });

    // On clicking the button, scroll smoothly to the top
    scrollToTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0, // Scroll to the top
            behavior: "smooth", // Smooth scrolling animation
        });
    });
</script>

<script src="{{ asset('/sneat_backend/assets/js/ui-toasts.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        // General toast function
        function showToast(type, message, title = 'Notification') {
            const toast = $('#toastMessage'); // Get the toast container

            // Reset previous classes and add the correct type class
            toast.removeClass('bg-success bg-danger').addClass(`bg-${type}`);


            // Set message and title
            $('#toastBody').text(message);

            // Display the toast
            toast.fadeIn().show();

            // Hide the toast after 10 seconds
            setTimeout(function() {
                toast.fadeOut();
            }, 5000);
        }

        // Show success toast
        function showSuccessToast(message) {
            showToast('success', message, 'Success');
        }

        // Show error toast
        function showErrorToast(message) {
            showToast('danger', message, 'Error');
        }

        // Example usage (from session flash messages)
        @if (Session::has('success'))
            showSuccessToast('{{ Session::get('success') }}');
        @endif

        @if (Session::has('error'))
            showErrorToast('{{ Session::get('error') }}');
        @endif
    });
</script>



</body>

</html>
