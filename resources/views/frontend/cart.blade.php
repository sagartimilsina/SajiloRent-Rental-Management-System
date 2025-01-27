@extends('frontend.layouts.main')
@section('title', 'Cart')
@section('content')

    <section class="mt-3 mb-5">
        <section class="breadcrumb-hero">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>
                    <a href="#" class="active-nav" aria-current="page">Cart</a>
                </nav>
            </div>
            <hr>
        </section>

        <div class="cart-container container">
            <div class="cart-title">
                <div class="align-items-start">
                    <input type="checkbox" id="select-all">
                    <label for="select-all" style="font-size: 16px;">Select All</label>
                </div>
                <span>Your Cart ({{ $cartCount }} items)</span>
            </div>

            <!-- Cart Items -->
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
                            <div class="cart-item-title">{{ $item->property->property_name }}</div>
                            <div class="cart-item-subtitle">{{ $item->property->category->category_name }}</div>
                            <div class="cart-item-extra">
                                {!! \Illuminate\Support\Str::limit(strip_tags($item->property->property_description), 200, '...') !!}
                            </div>
                        </div>

                        <div class="cart-item-price">Rs {{ $item->property->property_sell_price }}</div>
                        <div class="cart-item-quantity">
                            <button class="decrement">-</button>
                            <span class="quantity">1</span>
                            <button class="increment">+</button>
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

                const tax = subtotal * 0.1; // Example: 10% tax
                const total = subtotal + tax;

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
                decrementButton.addEventListener('click', () => {
                    let quantity = parseInt(quantitySpan.innerText);
                    if (quantity > 1) {
                        quantity--;
                        quantitySpan.innerText = quantity;
                        calculateTotals();
                    }
                });

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
  


@endsection
