@extends('frontend.layouts.main')
@section('title', 'Cart')
@section('content')

    <section class="mt-3 mb-5">
        <section class="breadcrumb-hero ">
            <hr>
            <div class="container text-start breadcrumb-overlay" style="padding: 0;">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="{{ route('index') }}">Home</a>

                    <a href="#" class="active-nav" aria-current="page">Cart </a>
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
                <span>Your Cart (4 items)</span>
            </div>
            <!-- Cart Items -->
            <div class="cart-item">
                <input type="checkbox">
                <div class="cart-item-image">
                    <img src="https://via.placeholder.com/80" alt="Pi Pizza Oven">
                </div>
                <div class="cart-item-details">
                    <div class="cart-item-title">Product Name</div>
                    <div class="cart-item-subtitle">Category </div>
                    <div class="cart-item-extra">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta
                        necessitatibus dolorum quibusdam odit neque rerum at aliquam delectus ea vel!</div>
                </div>

                <div class="cart-item-price">$469.99</div>
                <div class="cart-item-quantity">
                    <button>-</button>
                    <span>1</span>
                    <button>+</button>
                </div>
                <div class="cart-item-total">$469.99</div>
                <button class="delete-btn">✕</button>
            </div>

            <!-- Repeat for other items -->
            <div class="cart-item">
                <input type="checkbox">
                <div class="cart-item-image">
                    <img src="https://via.placeholder.com/80" alt="Grill Ultimate Bundle">
                </div>
                <div class="cart-item-details">
                    <div class="cart-item-title">Product Name</div>
                    <div class="cart-item-subtitle">Category </div>
                    <div class="cart-item-extra">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta
                        necessitatibus dolorum quibusdam odit neque rerum at aliquam delectus ea vel!</div>
                </div>
                <div class="cart-item-price">$549.99</div>
                <div class="cart-item-quantity">
                    <button>-</button>
                    <span>1</span>
                    <button>+</button>
                </div>
                <div class="cart-item-total">$549.99</div>
                <button class="delete-btn">✕</button>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>$1,019.98</span>
                </div>
                <div class="summary-row">
                    <span> Tax:</span>
                    <span>$102.00</span>
                </div>
                <div class="summary-row">
                    <span> Discount:</span>
                    <span>$102.00</span>
                </div>

                <div class="summary-row total-row">
                    <span>Grand Total:</span>
                    <span class="total-amount">$1,121.98</span>
                </div>

                <button class=" btn-primary btn-sm">Check Out</button>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cartItems = document.querySelectorAll('.cart-item');
            const subtotalElement = document.querySelector('.cart-summary .subtotal');
            const taxElement = document.querySelector('.cart-summary .tax');
            const discountPrice = document.querySelector('.discount');
            const totalElement = document.querySelector('.cart-summary .total');
            const selectAllCheckbox = document.querySelector('#select-all');

            // Helper function to recalculate totals
            function calculateTotals() {
                let subtotal = 0;
                cartItems.forEach((item) => {
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox.checked) {
                        const price = parseFloat(item.querySelector('.cart-item-price').innerText.replace(
                            '$', ''));
                        const quantity = parseInt(item.querySelector('.cart-item-quantity span').innerText);
                        subtotal += price * quantity;
                    }
                });

                const tax = subtotal * 0.1; // 10% tax
                const discount = subtotal - discountPrice;
                const total = subtotal + tax;
                subtotalElement.innerText = `$${subtotal.toFixed(2)}`;
                taxElement.innerText = `$${tax.toFixed(2)}`;
                totalElement.innerText = `$${total.toFixed(2)}`;
            }

            // Event listener for quantity changes
            cartItems.forEach((item) => {
                const decrementButton = item.querySelector('.cart-item-quantity button:first-child');
                const incrementButton = item.querySelector('.cart-item-quantity button:last-child');
                const quantitySpan = item.querySelector('.cart-item-quantity span');

                decrementButton.addEventListener('click', () => {
                    let quantity = parseInt(quantitySpan.innerText);
                    if (quantity > 1) {
                        quantity--;
                        quantitySpan.innerText = quantity;
                        calculateTotals();
                    }
                });

                incrementButton.addEventListener('click', () => {
                    let quantity = parseInt(quantitySpan.innerText);
                    quantity++;
                    quantitySpan.innerText = quantity;
                    calculateTotals();
                });

                // Event listener for individual checkbox
                const checkbox = item.querySelector('input[type="checkbox"]');
                checkbox.addEventListener('change', calculateTotals);
            });

            // Event listener for "select all" checkbox
            selectAllCheckbox.addEventListener('change', () => {
                const isChecked = selectAllCheckbox.checked;
                cartItems.forEach((item) => {
                    item.querySelector('input[type="checkbox"]').checked = isChecked;
                });
                calculateTotals();
            });

            // Delete functionality
            cartItems.forEach((item) => {
                const deleteButton = item.querySelector('.delete-btn');
                deleteButton.addEventListener('click', () => {
                    item.remove();
                    calculateTotals();
                });
            });

            // Initial calculation
            calculateTotals();
        });
    </script>
@endsection
