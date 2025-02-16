@extends('frontend.layouts.main')
@section('title', 'My Profile')
@section('content')
    <div class="container-left container mt-4 py-3">
        <div class="card border" style="border-radius: 0px">
            <h3 class="text-start m-2">Your Profile</h3>
        </div>

        <div class="row g-2">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group border-0">
                    <a href="#" data-section="editProfile"
                        class="list-group-item list-group-item-action profile-link text-start border-0">Edit Profile</a>
                    <a href="#" data-section="myCart"
                        class="list-group-item list-group-item-action profile-link text-start border-0">My Cart</a>
                    <a href="#" data-section="paymentHistory"
                        class="list-group-item list-group-item-action profile-link text-start border-0">Payment History</a>
                    <a href="#" data-section="yourFavorites"
                        class="list-group-item list-group-item-action profile-link text-start border-0">Your Favorites</a>
                    <a href="#" data-section="myChats"
                        class="list-group-item list-group-item-action profile-link text-start border-0">My Chats</a>
                    {{-- <a href="#" data-section="helpSupport"
                        class="list-group-item list-group-item-action profile-link text-start border-0">Help & Support</a> --}}
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-9 p-3">
                <div id="profileContent" class="content-section">
                    <!-- Content will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Add this before closing body tag -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to get the base URL of your application
            function getBaseUrl() {
                return window.location.protocol + "//" + window.location.host;
            }

            // Function to get section route
            function getSectionRoute(section) {
                const baseUrl = getBaseUrl();
                const routeMap = {
                    'myCart': '/profile/my-cart',
                    'paymentHistory': '/profile/payment-history',
                    'yourFavorites': '/profile/your-favorites',
                    'myChats': '/profile/my-chats',
                    'helpSupport': '/profile/help-support',
                    'editProfile': '/profile/edit-profile',
                    'changePassword': '/profile/change-password',
                };
                return baseUrl + routeMap[section];
            }

            // Function to load content
            function loadContent(section) {
                console.log('Loading section:', section);
                $.ajax({
                    url: getSectionRoute(section),
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#profileContent').html(
                            '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>'
                        );
                    },
                    success: function(response) {
                        $('#profileContent').html(response).show();
                        console.log('Response:', response);

                        // Initialize event listeners for dynamically loaded content
                        if (section === 'myCart') {
                            initializeCartEvents();
                        } else if (section === 'yourFavorites') {


                        }

                        // Update active link
                        $('.profile-link').removeClass('active-profile');
                        $(`[data-section="${section}"]`).addClass('active-profile');

                        // Save the active section
                        localStorage.setItem('activeProfileSection', section);
                    },
                    error: function(xhr, status, error) {
                        console.error('Ajax error:', error);
                        if (xhr.status === 401) {
                            window.location.href = getBaseUrl() + '/login';
                        } else {
                            $('#profileContent').html(
                                '<div class="alert alert-danger">Error loading content. Please try again later.</div>'
                            );
                        }
                    }
                });
            }

            // Handle link clicks
            $('.profile-link').click(function(e) {
                e.preventDefault();
                const section = $(this).data('section');
                loadContent(section);
            });

            // Load saved section or default to editProfile
            const savedSection = localStorage.getItem('activeProfileSection') || 'editProfile';
            loadContent(savedSection);
        });

        // Initialize cart events
        function initializeCartEvents() {
            const cartContainer = document.querySelector('.cart-container');

            if (!cartContainer) return; // Exit if cart container is not found

            // Function to calculate totals and update selected items
            function calculateTotals() {
                const cartItems = document.querySelectorAll('.cart-item');
                const subtotalElement = document.querySelector('.subtotal');
                const taxElement = document.querySelector('.tax');
                const totalAmountElement = document.querySelector('.total-amount');
                const selectedItemsInput = document.querySelector('#selected-items');

                let subtotal = 0;
                let selectedItems = []; // Array to store selected items with quantities

                cartItems.forEach(item => {
                    const checkbox = item.querySelector('.item-checkbox');
                    const price = parseFloat(checkbox.dataset.price);
                    const quantity = parseInt(item.querySelector('.quantity').innerText);
                    const itemId = item.dataset.id;

                    const itemTotal = price * quantity;
                    item.querySelector('.cart-item-total').innerText = `Rs ${itemTotal.toFixed(2)}`;

                    if (checkbox.checked) {
                        subtotal += itemTotal;
                        // Add the item details to selected items array
                        selectedItems.push({
                            id: itemId,
                            quantity: quantity,
                            price: price
                        });
                    }
                });

                const tax = subtotal * 0.13; // Example: 13% tax
                const total = subtotal + tax;

                subtotalElement.innerText = `Rs ${subtotal.toFixed(2)}`;
                taxElement.innerText = `Rs ${tax.toFixed(2)}`;
                totalAmountElement.innerText = `Rs ${total.toFixed(2)}`;

                // Update the hidden input with selected items
                selectedItemsInput.value = JSON.stringify(selectedItems);
            }

            // Function to update button states and alert visibility
            function updateButtonStates(container) {
                const quantitySpan = container.querySelector('.quantity');
                const incrementBtn = container.querySelector('.increment');
                const decrementBtn = container.querySelector('.decrement');
                const quantityAlert = container.querySelector('.quantity-alert');
                const maxQuantity = parseInt(container.getAttribute('data-max'), 10);
                let currentQuantity = parseInt(quantitySpan.innerText, 10);

                // Disable increment button if quantity reaches max
                if (currentQuantity >= maxQuantity) {
                    incrementBtn.disabled = true;
                    quantityAlert.style.display = 'block'; // Show alert
                } else {
                    incrementBtn.disabled = false;
                    quantityAlert.style.display = 'none'; // Hide alert
                }

                // Disable decrement button if quantity is 1
                if (currentQuantity <= 1) {
                    decrementBtn.disabled = true;
                } else {
                    decrementBtn.disabled = false;
                }
            }

            // Event delegation for cart interactions
            cartContainer.addEventListener('click', (e) => {
                const target = e.target;

                // Handle increment button
                if (target.classList.contains('increment')) {
                    const quantitySpan = target.closest('.cart-item-quantity').querySelector('.quantity');
                    const maxQuantity = parseInt(target.closest('.cart-item-quantity').getAttribute('data-max'),
                        10);
                    let quantity = parseInt(quantitySpan.innerText);

                    if (quantity < maxQuantity) {
                        quantity++;
                        quantitySpan.innerText = quantity;
                        updateButtonStates(target.closest('.cart-item-quantity'));
                        calculateTotals();
                    }
                }

                // Handle decrement button
                if (target.classList.contains('decrement')) {
                    const quantitySpan = target.closest('.cart-item-quantity').querySelector('.quantity');
                    let quantity = parseInt(quantitySpan.innerText);

                    if (quantity > 1) {
                        quantity--;
                        quantitySpan.innerText = quantity;
                        updateButtonStates(target.closest('.cart-item-quantity'));
                        calculateTotals();
                    }
                }

                // Handle delete button
                if (target.classList.contains('delete-btn')) {
                    const item = target.closest('.cart-item');
                    const itemId = item.dataset.id;

                    if (confirm('Are you sure you want to remove this item?')) {
                        const deleteUrl = `{{ route('cart.destroy', ':property_id') }}`.replace(':property_id',
                            itemId);

                        fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    item.remove(); // Remove the item from the DOM
                                    calculateTotals(); // Update totals
                                    alert(data.message);
                                } else {
                                    alert('Failed to delete item.');
                                }
                            })
                            .catch(() => {
                                alert('An error occurred. Please try again.');
                            });
                    }
                }

                // Handle checkbox change
                if (target.classList.contains('item-checkbox')) {
                    calculateTotals();
                }
            });

            // Handle select all checkbox
            const selectAllCheckbox = document.querySelector('#select-all');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', () => {
                    const isChecked = selectAllCheckbox.checked;
                    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                    calculateTotals();
                });
            }

            // Initial totals calculation
            calculateTotals();
        }



        // Function to toggle favorite
        // function toggleFavorite(userId, propertyId) {
        //     $.ajax({
        //         url: "{{ route('favorites.toggle') }}",
        //         method: "POST",
        //         data: {
        //             user_id: userId,
        //             property_id: propertyId,
        //             _token: "{{ csrf_token() }}"
        //         },
        //         success: function(response) {
        //             if (response.isFavorite === false) {
        //                 // Remove the item from the list instantly
        //                 $("#apartment-" + propertyId).fadeOut(300, function() {
        //                     $(this).remove();
        //                     console.log('Removed from favorites');

        //                     // If no favorites are left, show the "No favorites found" message
        //                     if ($("#favorite-list tr").length === 1) { // Only the header row remains
        //                         $("#favorite-list").html(
        //                             '<tr><td colspan="4" class="text-center">No favorites found.</td></tr>'
        //                         );
        //                     }
        //                 });
        //             } else if (response.isFavorite === true) {
        //                 // Reload the list if the item is added back to favorites
        //                 reloadFavorites();
        //             }
        //         },
        //         error: function(xhr) {
        //             console.log(xhr.responseText);
        //         }
        //     });
        // }

        // // Function to reload favorite items dynamically without refreshing the page
        // function reloadFavorites() {
        //     console.log('Reloading favorites...');
        //     $.ajax({
        //         url: "{{ route('profile.myFavourites') }}",
        //         method: "GET",
        //         success: function(response) {
        //             if (response.html) {
        //                 $("#favorite-list").html(response.html);
        //             }
        //         },
        //         error: function(xhr) {
        //             console.log(xhr.responseText);
        //         }
        //     });
        // }
    </script>

@endsection
