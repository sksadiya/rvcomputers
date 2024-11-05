@extends('front.layouts.master')
@section('css')
<style>
      .btn.btn-buy {
    background-color: #000 !important;
    border: 1px solid #000 !important;
  }
  .btn.btn-buy:hover {
    color: #fff !important;
  }
    .input-step {
        border: 1px solid #000;
        display: inline-flex;
        overflow: visible;
        height: 37.5px;
        border-radius: 0.25rem;
        background: #fff;
        padding: 4px;
    }

    .input-step button {
        width: 1.4em;
        font-weight: 300;
        height: 100%;
        line-height: .1em;
        font-size: 1.4em;
        padding: .2em !important;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 5px;
    }

    .input-step input {
        width: 4em;
        height: 100%;
        text-align: center;
        border: 0;
        background: 0 0;
        color: #000;
        border-radius: 5px;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection
@section('content')
<section class="section-box shop-template p-5">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-9">
                @if(count($cartProducts) > 0)
                    <div class="box-carts">
                        <div class="head-wishlist">
                            <div class="item-wishlist">
                                <div class="wishlist-product"><span class="font-md-bold text-black">Product</span></div>
                                <div class="wishlist-price"><span class="font-md-bold text-black">Unit Price</span></div>
                                <div class="wishlist-status"><span class="font-md-bold text-black">Quantity</span></div>
                                <div class="wishlist-action"><span class="font-md-bold text-black">Subtotal</span></div>
                                <div class="wishlist-remove"><span class="font-md-bold text-black">Remove</span></div>
                            </div>
                        </div>
                        <div class="content-wishlist mb-20">
                            @foreach($cartProducts as $item)
                                <div class="item-wishlist border-black cart-item-{{ $item['variant_id'] }}">
                                    <div class="wishlist-product">
                                        <div class="product-wishlist">
                                            <div class="product-image">
                                                <a href="{{ route('product.show', $item['product']->slug) }}"><img
                                                        src="{{ $item['product']->image }}" alt="Ecom"></a>
                                            </div>
                                            <div class="product-info d-block">
                                                <a href="{{ route('product.show', $item['product']->slug) }}">
                                                    <h6 class="text-black fs-4">{{ $item['product']->name }}</h6>
                                                </a>
                                                <div class="attributes">
                                                    @if($item['attributes'])
                                                        @foreach($item['attributes'] as $attribute => $value)
                                                            <p class="text-black mb-2">{{ ucfirst($attribute) }}: {{ $value }}</p>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wishlist-price">
                                        <h4 class="text-black">₹ {{ number_format($item['price'], 0) }}</h4>
                                    </div>
                                    <div class="wishlist-status">
                                        <div class="box-quantity">
                                            <div class="box-quantity text-black">
                                                <div class="input-step">
                                                    <button type="button" class="minus material-shadow"
                                                        data-id="{{ $item['product']->id }}">–</button>
                                                    <input type="number" class="product-quantity" data-variant-id="{{ $item['variant_id'] }}"
                                                        value="{{ $item['quantity'] }}" min="1" max="100">
                                                    <button type="button" class="plus material-shadow"
                                                        data-id="{{ $item['product']->id }}">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wishlist-action">
                                        <h4 class="item-subtotal">Total: ₹
                                        {{ $item['price'] * $item['quantity'] }}</h4>
                                    </div>
                                    <div class="wishlist-remove ">
                                    <a class="text-danger remove-from-cart" href="#" data-variant-id="{{ $item['variant_id']}}">
                                        <i class="bx bx-trash-alt fs-4"></i>
                                    </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row mb-40">
                            <div class="col-lg-6 col-md-6 col-sm-6-col-6"><a class="btn btn-buy w-auto text-white mb-10"
                                    href="{{ route('product.shop') }}"><i class="bx bx-left-arrow-alt  align-middle fs-4 me-2"></i>Continue shopping</a></div>
                        </div>
                    </div>
                    @else
                    <div class="container d-flex flex-column justify-content-center align-items-center p-lg-5 p-3">
                        <h4 class="text-center text-black mb-3">Your cart is currently empty.</h4>
                        <img src="{{ asset('assets/images/empty-cart.png') }}" alt="Cart Empty" class="img-fluid mb-4" style="width: 100px; height: 100px; object-fit: contain;">
                        <a class="btn btn-buy w-auto text-white mb-10"
                        href="{{ route('product.shop') }}"><i class="bx bx-left-arrow-alt  align-middle fs-4 me-2"></i>Continue shopping</a>
                    </div>

                @endif
            </div>
            <div class="col-lg-3">
                <div class="summary-cart">
                @if(count($cartProducts) > 0)
                <div class="row mb-50">
                    <div class="col">
                        <div class="box-cart-right p-20">
                            <h5 class="font-md-bold mb-10">Apply Coupon</h5><span
                                class="font-sm-bold mb-5 d-inline-block text-black">Using A Promo Code?</span>
                            <div class="form-group d-flex">
                                <input class="form-control mr-15" placeholder="Enter Your Coupon">
                                <button class="btn btn-buy w-auto">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                    <div class="border-bottom mb-10">
                        <div class="row">
                            <div class="col-6"><span class="font-md-bold text-black">Subtotal</span></div>
                            <div class="col-6 text-end">
                                <h4 class="cart-total-amount">₹ {{ number_format($totalPrice, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom mb-10">
                        <div class="row">
                            <div class="col-6"><span class="font-md-bold text-black">Shipping</span></div>
                            <div class="col-6 text-end">
                                <h4> Free</h4>
                            </div>
                        </div>
                    </div>
                    <div class="mb-10">
                        <div class="row">
                            <div class="col-6"><span class="font-md-bold text-black">Total</span></div>
                            <div class="col-6 text-end">
                            <h4 class="cart-total-amount">₹ {{ number_format($totalPrice, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="box-button"><a class="btn btn-buy" href="shop-checkout.html">Proceed To CheckOut</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $(document).on('click', '.minus', function () {
        const quantityInput = $(this).siblings('.product-quantity'); // Find the associated quantity input
        let currentValue = parseInt(quantityInput.val());
        if (currentValue > 1) {
            quantityInput.val(currentValue - 1); // Decrease value
            updateQuantity(quantityInput);
        }
    });

    $(document).on('click', '.plus', function () {
        const quantityInput = $(this).siblings('.product-quantity'); // Find the associated quantity input
        let currentValue = parseInt(quantityInput.val());
        if (currentValue < 6) {
            quantityInput.val(currentValue + 1); // Increase value
            updateQuantity(quantityInput);
        }
    });

    // Function to update the quantity via AJAX
    function updateQuantity(quantityInput) {
        const newQuantity = quantityInput.val(); // Get the updated quantity
        const variantId = quantityInput.data('variant-id'); // Get the variant ID

        $.ajax({
            url: "{{ route('cart.updateQuantity') }}",
            method: "POST",
            data: {
                variant_id: variantId,
                quantity: newQuantity,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.success) {
                    // Update the item subtotal
                    $(`.cart-item-${variantId} .item-subtotal`).text(`₹ ${response.itemSubtotal}`);
                    // Update the cart total
                    $('.cart-total-amount').text(`₹ ${response.cartTotal}`);
                }
            },
            error: function () {
                alert("Failed to update quantity.");
            }
        });
    }
        

        $(document).on('click', '.remove-from-cart', function (event) {
    event.preventDefault();

    const variantId = $(this).data('variant-id');
    
    // Show a confirmation prompt
    if (!confirm("Are you sure you want to remove this item from the cart?")) {
        return; // If not confirmed, exit the function
    }
    
    $.ajax({
        url: "{{ route('cart.remove') }}",
        method: "POST",
        data: {
            variant_id: variantId,
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
            if (response.success) {
                $(`.cart-item-${variantId}`).fadeOut(300, function() {
                    $(this).remove();
                });
                $('.cart-total-amount').text(`₹ ${response.cartTotal}`);
                alert("Item removed from cart!");
            } else {
                alert("Failed to remove item from cart.");
            }
        },
        error: function () {
            alert("Error removing item from cart.");
        }
    });
});


    });
</script>
@endsection