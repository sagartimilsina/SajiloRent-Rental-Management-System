@extends('frontend.layouts.main')
@section('title', 'Cart')
@section('content')

    <section class="mt-5 mb-5">
        {{-- <section class="breadcrumb-hero">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>
                    <a href="#" class="active-nav" aria-current="page">Cart</a>
                    <a href="#" class="active-nav" aria-current="page">Cart</a>
                </nav>
            </div>
            <hr>
        </section> --}}

        <div class="cart-container container ">
            <div class="cart-title">
                <div class="align-items-start">
                    <input type="checkbox" id="select-all">
                    <label for="select-all" style="font-size: 16px;">Select All</label>
                </div>
                <span>Your Cart ({{ $cartCount }} items)</span>
               
            </div>

            <div class="item" style="max-height: 400px; overflow-y: scroll;">
                @foreach ($cartItems as $item)
                    <div class="cart-item" data-id="{{ $item->id }}">
                        <input type="checkbox" class="item-checkbox" data-price="{{ $item->property->property_sell_price }}"
                            data-id="{{ $item->id }}">

                        <div class="cart-item-image">
                            <img src="{{ asset('storage/' . $item->property->property_image) }}"
                                alt="{{ $item->property->property_name }}">
                        </div>

                        <div class="cart-item-details">
                            <div class="cart-item-title" title="{{ $item->property->property_name }}">
                                {{ $item->property->property_name }}
                            </div>
                            <div class="cart-item-subtitle">{{ $item->property->category->category_name }}</div>
                            <div class="cart-item-extra">
                                {!! \Illuminate\Support\Str::limit(strip_tags($item->property->property_description), 200, '...') !!}
                            </div>
                        </div>

                        <div class="cart-item-price">Rs {{ $item->property->property_sell_price }}</div>
                        <style>
                            .quantity-alert {
                                color: red;
                                font-size: 12px;
                                display: none;
                                /* Hidden by default */
                            }
                        </style>

                        <div class="cart-item-quantity" data-max="{{ $item->property->property_quantity }}">
                            <button class="decrement">-</button>
                            <span class="quantity">1</span>
                            <button class="increment">+</button>
                            <div class="quantity-alert" style="color: red; font-size: 12px; display: none;">Maximum quantity
                                reached</div>
                        </div>



                        <div class="cart-item-total">Rs {{ $item->property->property_sell_price }}</div>
                        <button class="delete-btn">✕</button>
                    </div>
                @endforeach
            </div>


            <!-- Cart Summary -->
            <div class="cart-summary">
                <div class="summary-row">
                    <strong>Subtotal:</strong>
                    <span class="subtotal mx-2">Rs 0.00</span>
                   
                </div>
                <div class="summary-row">
                    <strong>Tax:</strong>
                    <span class="tax mx-2">Rs 0.00</span>
                    
                </div>
                <div class="summary-row">
                    <strong>Discount:</strong>
                    <span class="discount mx-2">Rs 0.00</span>
                   
                </div>

                <div class="summary-row total-row">
                    <strong>Grand Total:</strong>
                    <span class="total-amount mx-2">Rs 0.00</span>
                   
                </div>

                <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="selected_items" id="selected-items">
                    <button type="submit" class="btn-primary btn-sm">Check Out</button>
                </form>
               
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cartItems = document.querySelectorAll('.cart-item');
            const subtotalElement = document.querySelector('.subtotal');
            const taxElement = document.querySelector('.tax');
            const totalAmountElement = document.querySelector('.total-amount');
            const selectAllCheckbox = document.querySelector('#select-all');
            const checkoutForm = document.querySelector('#checkout-form');
            const selectedItemsInput = document.querySelector('#selected-items');

            // Function to calculate totals and update selected items
            function calculateTotals() {
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

            // Attach event listeners to cart items
            cartItems.forEach(item => {
                const decrementButton = item.querySelector('.decrement');
                const incrementButton = item.querySelector('.increment');
                const quantitySpan = item.querySelector('.quantity');
                const checkbox = item.querySelector('.item-checkbox');
                const deleteButton = item.querySelector('.delete-btn');
                const quantityAlert = item.querySelector('.quantity-alert');
                const maxQuantity = parseInt(item.querySelector('.cart-item-quantity').getAttribute(
                    'data-max'), 10);

                console.log('Initial quantity:', quantitySpan.innerText); // Debug initial value

                // Decrease quantity
                decrementButton.addEventListener('click', () => {
                    let quantity = parseInt(quantitySpan.innerText);
                    if (quantity > 1) {
                        quantity--;
                        quantitySpan.innerText = quantity;
                        updateButtonStates(item.querySelector('.cart-item-quantity'));
                        calculateTotals();
                    }
                });

                // Increase quantity
                incrementButton.addEventListener('click', () => {
                    let quantity = parseInt(quantitySpan.innerText);
                    if (quantity < maxQuantity) {
                        quantity++;
                        quantitySpan.innerText = quantity;
                        updateButtonStates(item.querySelector('.cart-item-quantity'));
                        calculateTotals();
                    }
                });

                // Checkbox change event
                checkbox.addEventListener('change', () => {
                    calculateTotals();
                });

                // Delete button event
                deleteButton.addEventListener('click', () => {
                    const itemId = item.dataset.id;

                    if (confirm('Are you sure you want to remove this item?')) {
                        const deleteUrl = `{{ route('cart.destroy', ':property_id') }}`.replace(
                            ':property_id', itemId);

                        fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
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
                });

                // Initialize button states on page load
                updateButtonStates(item.querySelector('.cart-item-quantity'));
            });

            // Select all checkbox event
            selectAllCheckbox.addEventListener('change', () => {
                const isChecked = selectAllCheckbox.checked;
                cartItems.forEach(item => {
                    const checkbox = item.querySelector('.item-checkbox');
                    checkbox.checked = isChecked;
                });
                calculateTotals();
            });

            // Modify checkout form submission to ensure selected items are passed
            checkoutForm.addEventListener('submit', (e) => {
                const selectedItems = JSON.parse(selectedItemsInput.value);

                if (selectedItems.length === 0) {
                    e.preventDefault(); // Prevent form submission
                    alert('Please select at least one item to checkout.');
                }
            });

            // Initial totals calculation
            calculateTotals();
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cartItems = document.querySelectorAll('.cart-item');
            const subtotalElement = document.querySelector('.subtotal');
            const taxElement = document.querySelector('.tax');
            const totalAmountElement = document.querySelector('.total-amount');
            const selectAllCheckbox = document.querySelector('#select-all');
            const checkoutForm = document.querySelector('#checkout-form');
            const selectedItemsInput = document.querySelector('#selected-items');
            const checkoutForm = document.querySelector('#checkout-form');
            const selectedItemsInput = document.querySelector('#selected-items');

            // Function to calculate totals and update selected items
            // Function to calculate totals and update selected items
            function calculateTotals() {
                let subtotal = 0;
                let selectedItems = []; // Array to store selected items with quantities

                cartItems.forEach(item => {
                    const checkbox = item.querySelector('.item-checkbox');
                    const price = parseFloat(checkbox.dataset.price);
                    const quantity = parseInt(item.querySelector('.quantity').innerText);
                    const itemId = item.dataset.id;

                    const itemTotal = price * quantity;
                    item.querySelector('.cart-item-total').innerText = `Rs ${itemTotal.toFixed(2)}`;

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
                        subtotal += itemTotal;
                        // Add the item details to selected items array
                        selectedItems.push({
                            id: itemId,
                            quantity: quantity,
                            price: price
                        });
                    }
                });

                const tax = subtotal * 0.1; // Example: 10% tax
                const tax = subtotal * 0.1; // Example: 10% tax
                const total = subtotal + tax;

                subtotalElement.innerText = `Rs ${subtotal.toFixed(2)}`;
                taxElement.innerText = `Rs ${tax.toFixed(2)}`;
                totalAmountElement.innerText = `Rs ${total.toFixed(2)}`;

                // Update the hidden input with selected items
                selectedItemsInput.value = JSON.stringify(selectedItems);

                subtotalElement.innerText = `Rs ${subtotal.toFixed(2)}`;
                taxElement.innerText = `Rs ${tax.toFixed(2)}`;
                totalAmountElement.innerText = `Rs ${total.toFixed(2)}`;

                // Update the hidden input with selected items
                selectedItemsInput.value = JSON.stringify(selectedItems);
            }

            // Attach event listeners to cart items
            cartItems.forEach(item => {
                const decrementButton = item.querySelector('.decrement');
                const incrementButton = item.querySelector('.increment');
                const quantitySpan = item.querySelector('.quantity');
                const checkbox = item.querySelector('.item-checkbox');
                const deleteButton = item.querySelector('.delete-btn');

                // Decrease quantity
            // Attach event listeners to cart items
            cartItems.forEach(item => {
                const decrementButton = item.querySelector('.decrement');
                const incrementButton = item.querySelector('.increment');
                const quantitySpan = item.querySelector('.quantity');
                const checkbox = item.querySelector('.item-checkbox');
                const deleteButton = item.querySelector('.delete-btn');

                // Decrease quantity
                decrementButton.addEventListener('click', () => {
                    let quantity = parseInt(quantitySpan.innerText);
                    if (quantity > 1) {
                        quantity--;
                        quantitySpan.innerText = quantity;
                        calculateTotals();
                    }
                });

                // Increase quantity
                // Increase quantity
                incrementButton.addEventListener('click', () => {
                    let quantity = parseInt(quantitySpan.innerText);
                    quantity++;
                    quantitySpan.innerText = quantity;
                    calculateTotals();
                });

                // Checkbox change event
                checkbox.addEventListener('change', () => {
                    calculateTotals();
                });

                // Delete button event
                deleteButton.addEventListener('click', () => {
                    const itemId = item.dataset.id;

                    if (confirm('Are you sure you want to remove this item?')) {
                        const deleteUrl = `{{ route('cart.destroy', ':property_id') }}`.replace(
                            ':property_id', itemId);

                        fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
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
                });
            });

            // Select all checkbox event
                // Checkbox change event
                checkbox.addEventListener('change', () => {
                    calculateTotals();
                });

                // Delete button event
                deleteButton.addEventListener('click', () => {
                    const itemId = item.dataset.id;

                    if (confirm('Are you sure you want to remove this item?')) {
                        const deleteUrl = `{{ route('cart.destroy', ':property_id') }}`.replace(
                            ':property_id', itemId);

                        fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
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
                });
            });

            // Select all checkbox event
            selectAllCheckbox.addEventListener('change', () => {
                const isChecked = selectAllCheckbox.checked;
                cartItems.forEach(item => {
                    const checkbox = item.querySelector('.item-checkbox');
                    checkbox.checked = isChecked;
                cartItems.forEach(item => {
                    const checkbox = item.querySelector('.item-checkbox');
                    checkbox.checked = isChecked;
                });
                calculateTotals();
            });

            // Modify checkout form submission to ensure selected items are passed
            checkoutForm.addEventListener('submit', (e) => {
                const selectedItems = JSON.parse(selectedItemsInput.value);

                if (selectedItems.length === 0) {
                    e.preventDefault(); // Prevent form submission
                    alert('Please select at least one item to checkout.');
                }
            // Modify checkout form submission to ensure selected items are passed
            checkoutForm.addEventListener('submit', (e) => {
                const selectedItems = JSON.parse(selectedItemsInput.value);

                if (selectedItems.length === 0) {
                    e.preventDefault(); // Prevent form submission
                    alert('Please select at least one item to checkout.');
                }
            });

            // Initial totals calculation
            // Initial totals calculation
            calculateTotals();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".cart-item-quantity").forEach(function(container) {
                const decrementBtn = container.querySelector(".decrement");
                const incrementBtn = container.querySelector(".increment");
                const quantitySpan = container.querySelector(".quantity");
                const quantityAlert = container.querySelector(".quantity-alert");
                const maxQuantity = parseInt(container.getAttribute("data-max"), 10);

                console.log("Initial quantity:", quantitySpan.innerText); // Debug initial value

                // Function to update button states and alert visibility
                function updateButtonStates() {
                    let currentQuantity = parseInt(quantitySpan.innerText, 10);

                    // Disable increment button if quantity reaches max
                    if (currentQuantity >= maxQuantity) {
                        incrementBtn.disabled = true;
                        quantityAlert.style.display = "block"; // Show alert
                    } else {
                        incrementBtn.disabled = false;
                        quantityAlert.style.display = "none"; // Hide alert
                    }

                    // Disable decrement button if quantity is 1
                    if (currentQuantity <= 1) {
                        decrementBtn.disabled = true;
                    } else {
                        decrementBtn.disabled = false;
                    }
                }

                // Increment button click event
                incrementBtn.addEventListener("click", function() {
                    let currentQuantity = parseInt(quantitySpan.innerText, 10);
                    if (currentQuantity < maxQuantity) {
                        quantitySpan.innerText = currentQuantity + 1;
                        updateButtonStates(); // Update button states
                        calculateTotals(); // Update totals
                    }
                });

                // Decrement button click event
                decrementBtn.addEventListener("click", function() {
                    let currentQuantity = parseInt(quantitySpan.innerText, 10);
                    if (currentQuantity > 1) {
                        quantitySpan.innerText = currentQuantity - 1;
                        updateButtonStates(); // Update button states
                        calculateTotals(); // Update totals
                    }
                });

                // Initialize button states on page load
                updateButtonStates();
            });
        });
    </script> --}}




@endsection
