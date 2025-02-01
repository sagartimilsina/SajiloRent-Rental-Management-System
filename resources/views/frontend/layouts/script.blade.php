<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    // function toggleFavorite(userId, propertyId) {
    //     if (!userId) {
    //         window.location.href = "{{ route('login') }}"; // Redirect to login if user isn't authenticated
    //         return;
    //     }

    //     fetch("{{ route('favorites.toggle') }}", {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //                 'X-Requested-With': 'XMLHttpRequest'
    //             },
    //             body: JSON.stringify({
    //                 user_id: userId,
    //                 property_id: propertyId,
    //             }),
    //         })

    //         .then((response) => response.json())
    //         .then((data) => {
    //             if (data.success) {
    //                 // Dynamically update the favorite link style and icon
    //                 const favoriteLink = document.querySelector(
    //                     `a[onclick="toggleFavorite(${userId}, ${propertyId})"]`
    //                 );
    //                 if (data.isFavorite) {
    //                     favoriteLink.classList.remove('text-muted');
    //                     favoriteLink.classList.add('text-warning');
    //                     favoriteLink.querySelector('i').classList.remove('far', 'fa-heart');
    //                     favoriteLink.querySelector('i').classList.add('fas', 'fa-heart');
    //                 } else {
    //                     favoriteLink.classList.remove('text-primary');
    //                     favoriteLink.classList.add('text-muted');
    //                     favoriteLink.querySelector('i').classList.remove('fas', 'fa-heart');
    //                     favoriteLink.querySelector('i').classList.add('far', 'fa-heart');
    //                 }
    //             } else {
    //                 alert('Failed to update favorite status. Please try again.');
    //             }
    //         })
    //         .catch((error) => {
    //             console.error('Error:', error);
    //             alert('An error occurred. Please try again later.');
    //         });
    // }

    function toggleFavorite(userId, propertyId) {
        if (!userId) {
            window.location.href = @json(route('login')); // Redirect to login if user isn't authenticated
            return;
        }

        fetch("{{ route('favorites.toggle') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    user_id: userId,
                    property_id: propertyId,
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const favoriteLink = document.querySelector(
                        `a[onclick="toggleFavorite(${userId}, ${propertyId})"]`
                    );
                    if (data.isFavorite) {
                        favoriteLink.classList.remove('text-muted');
                        favoriteLink.classList.add('text-warning');
                        favoriteLink.querySelector('i').classList.remove('far', 'fa-heart');
                        favoriteLink.querySelector('i').classList.add('fas', 'fa-heart');
                    } else {
                        favoriteLink.classList.remove('text-primary');
                        favoriteLink.classList.add('text-muted');
                        favoriteLink.querySelector('i').classList.remove('fas', 'fa-heart');
                        favoriteLink.querySelector('i').classList.add('far', 'fa-heart');
                    }
                } else {
                    alert('Failed to update favorite status. Please try again.');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            });
    }

    function shareProperty(propertyLink) {
        // Use the Clipboard API to copy the link
        navigator.clipboard.writeText(propertyLink)
            .then(() => {
                // Create and show the custom tooltip
                const tooltip = document.createElement('div');
                tooltip.innerText = 'Copied to clipboard!';
                tooltip.style.position = 'absolute';
                tooltip.style.backgroundColor = '#333';
                tooltip.style.color = '#fff';
                tooltip.style.padding = '5px 10px';
                tooltip.style.borderRadius = '5px';
                tooltip.style.fontSize = '14px';
                tooltip.style.zIndex = 1000;
                tooltip.style.boxShadow = '0px 2px 8px rgba(0, 0, 0, 0.2)';

                // Get the button's position
                const button = document.activeElement;
                const rect = button.getBoundingClientRect();

                // Position the tooltip near the button
                tooltip.style.top = `${rect.top + window.scrollY - 30}px`;
                tooltip.style.left = `${rect.left + window.scrollX}px`;

                // Append the tooltip to the body
                document.body.appendChild(tooltip);

                // Remove the tooltip after 2 seconds
                setTimeout(() => {
                    tooltip.remove();
                }, 2000);
            })
            .catch((err) => {
                console.error('Error copying to clipboard:', err);
                alert('Failed to copy the link. Please try again.');
            });
    }
</script>
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
{{-- <script>
{{-- <script>
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
</script> --}}
</script> --}}
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
<script>
    $(document).ready(function() {
        function showSuccessToast(message) {
            console.log('Toast Message:', message); // Check if the message is passed
            const toast = `<div class="toast toast-success">${message}</div>`;
            $('body').append(toast); // Check if the element is appended

            setTimeout(() => {
                $('.toast-success').fadeOut(500, function() {
                    $(this).remove();
                });
            }, 3000);
        }


        function showErrorToast(message) {
            const toast = `<div class="toast toast-error">${message}</div>`;
            $('body').append(toast);

            setTimeout(() => {
                $('.toast-error').fadeOut(500, function() {
                    $(this).remove();
                });
            }, 3000);
        }

        // Delete button click event
        $('.delete-btn').on('click', function() {
            const item = $(this).closest('.cart-item');
            const propertyId = item.find('.item-checkbox').data('property-id');

            if (confirm('Are you sure you want to remove this item?')) {
                const deleteUrl = `{{ route('cart.destroy', ':property_id') }}`
                    .replace(':property_id', propertyId);

                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        console.log('Response:', response); // Verify the response object
                        if (response.success) {
                            showSuccessToast(response
                                .message); // Ensure this function is called
                            item.remove();
                            calculateTotals();
                        } else {
                            showErrorToast(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error); // Verify if this block is triggered
                        showErrorToast('An error occurred. Please try again.');
                    },
                });

            }
        });

        // Function to recalculate totals
        function calculateTotals() {
            let subtotal = 0;
            $('.item-checkbox:checked').each(function() {
                const price = parseFloat($(this).data('price'));
                const quantity = parseInt($(this).closest('.cart-item').find('.quantity').text());
                subtotal += price * quantity;
            });

            const tax = subtotal * 0.1; // 10% tax
            const total = subtotal + tax;

            $('.subtotal').text(`$${subtotal.toFixed(2)}`);
            $('.tax').text(`$${tax.toFixed(2)}`);
            $('.total-amount').text(`$${total.toFixed(2)}`);
        }



    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const loaderWrapper = document.getElementById("loader-wrapper");
        const mainContent = document.getElementById("main-content");

        // Show the loader on page load for reloads
        loaderWrapper.style.display = "flex";
        mainContent.style.display = "none";
        window.addEventListener("load", function() {
            loaderWrapper.style.display = "none";
            mainContent.style.display = "block";
        });

        // Show loader on form submission
        document.querySelectorAll("form").forEach(form => {
            form.addEventListener("submit", function() {
                loaderWrapper.style.display = "flex";
                mainContent.style.display = "none";
            });
        });

        // Show loader on page refresh/navigation
        window.addEventListener("beforeunload", function() {
            loaderWrapper.style.display = "flex";
            mainContent.style.display = "none";
        });
    });
</script>





</body>

</html>
