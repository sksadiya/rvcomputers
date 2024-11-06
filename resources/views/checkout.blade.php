@extends('front.layouts.master')
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .btn.btn-buy {
        background-color: #000 !important;
        border: 1px solid #000 !important;
    }

    .btn.btn-buy:hover {
        color: #fff !important;
    }

    .select2-container .select2-selection--single {
        align-content: center !important;
        height: 35px !important;
    }
</style>
@endsection
@section('content')
<section class="section-box shop-template">
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-lg-7">
                <div class="box-border">
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="font-md-bold text-black mt-15 mb-20">Billing address</h5>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input name="name" id="name" value="{{ $customer->name }}"
                                            class="form-control font-sm @error('name') is-invalid @enderror" type="text"
                                            placeholder="Full Name*">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="billing_address" id="billing_address"
                                        class="form-control @error('billing_address') is-invalid @enderror"
                                        placeholder="billing address">{{ old('billing_address', $customer->billingAddress->address_line_1 ?? '') }}
                                        </textarea>
                                    @error('billing_address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select name="billing_country" id="billing_country" class="form-select country_id"
                                        style="width: 100%;">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select name="billing_state" id="billing_state" class="form-select state_id"
                                        style="width: 100%;">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select name="billing_city" id="billing_city" class="form-select city_id"
                                        style="width: 100%;">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="billing_postal"
                                        value="{{ old('billing_postal', $customer->billingAddress->postal_code ?? '') }}"
                                        id="billing_postal"
                                        class="form-control @error('billing_postal') is-invalid @enderror"
                                        placeholder="Postal">
                                    @error('billing_postal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="number" name="billing_phone"
                                        value="{{ old('billing_phone', $customer->billingAddress->contact ?? '') }}"
                                        id="billing_phone"
                                        class="form-control @error('billing_phone') is-invalid @enderror"
                                        placeholder="Mobile No.">
                                    @error('billing_phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="font-md-bold text-black mt-15 mb-20">Shipping address</h5>
                            </div>
                            <div class="col-12">
                                <div class="form-group row mb-3">
                                    <div class="col-sm-10 ">
                                        <input type="checkbox" id="same_as_billing" name="same_as_billing">
                                        <label for="same_as_billing">Same as Billing Address</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="shipping_address" id="shipping_address"
                                        class="form-control @error('shipping_address') is-invalid @enderror"
                                        placeholder="shipping address">{{ old('shipping_address', $customer->shippingAddress->address_line_1 ?? '') }}
                                        </textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select name="shipping_country" id="shipping_country" class="form-select country_id"
                                        style="width: 100%;">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select name="shipping_state" id="shipping_state" class="form-select state_id"
                                        style="width: 100%;">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select name="shipping_city" id="shipping_city" class="form-select city_id"
                                        style="width: 100%;">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="shipping_postal"
                                        value="{{ old('shipping_postal', $customer->shippingAddress->postal_code ?? '') }}"
                                        id="shipping_postal"
                                        class="form-control @error('shipping_postal') is-invalid @enderror"
                                        placeholder="Postal">
                                    @error('shipping_postal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="number" name="shipping_phone"
                                        value="{{ old('shipping_phone', $customer->shippingAddress->contact ?? '') }}"
                                        id="shipping_phone"
                                        class="form-control @error('shipping_phone') is-invalid @enderror"
                                        placeholder="Mobile No.">
                                    @error('shipping_phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-0">
                                <textarea class="form-control font-sm" placeholder="Additional Information"
                                    rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-20 justify-content-between">
                    <a class="btn btn-buy w-auto text-white mb-10" href="{{ route('cart.index') }}"><i
                            class="bx bx-left-arrow-alt  align-middle fs-4 me-2"></i>Return to Cart</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="box-border">
                    <h5 class="font-md-bold mb-20">Your Order</h5>
                    <div class="listCheckout">
                        @foreach ($cart as $item)
                            <div class="item-wishlist">
                                <div class="wishlist-product">
                                    <div class="product-wishlist">
                                        <div class="product-image">
                                            <a target="_blank" href="{{ route('product.show', $item['product_slug']) }}">
                                                <img src="{{ asset($item['product_image']) }}"
                                                    alt="{{ $item['product_name'] }}">
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a target="_blank" href="{{ route('product.show', $item['product_slug']) }}">
                                                <h6 class="text-black">{{ $item['product_name'] }} <span
                                                        class="fw-bolder text-black">({{ $item['quantity'] }})</span></h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="wishlist-price">
                                    <h4 class="text-black font-lg-bold">₹{{ number_format($item['product_price'], 2) }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group d-flex mt-15">
                        <input id="coupon-code" class="form-control mr-15" placeholder="Enter Your Coupon">
                        <button id="apply-coupon" class="btn btn-buy w-auto">Apply</button>
                    </div>
                    <div id="coupon_message" class="text-success"></div>
                    <div class="form-group mb-0">
                        @php
                            $shippingCharges = $paymentSettings['shipping_charges'] ?? 0;
                            $total = $cartTotal + $shippingCharges;
                        @endphp

                        <div class="row mb-10">
                            <div class="col-lg-6 col-6"><span class="font-md-bold text-black">Subtotal</span></div>
                            <div class="col-lg-6 col-6 text-end">
                                <span class="font-lg-bold text-black" id="cart-total"
                                    data-total="{{ $cartTotal }}">₹{{ number_format($cartTotal, 2) }}</span>
                            </div>
                        </div>
                        <div class="row mb-10">
                            <div class="col-lg-6 col-6"><span class="font-md-bold text-black">Discount</span></div>
                            <div class="col-lg-6 col-6 text-end">
                            <span class="font-lg-bold text-black" data-discount-total="0" id="discount-total">₹ 0.00</span>
                            </div>
                        </div>
                        
                        <div class="border-bottom mb-10 pb-5">
                            <div class="row">
                                <div class="col-lg-6 col-6"><span class="font-md-bold text-black">Shipping</span></div>
                                <div class="col-lg-6 col-6 text-end">
                                    <span
                                        class="font-lg-bold text-black" data-shipping-total="{{ $shippingCharges }}" id="shipping-total">₹{{ number_format($shippingCharges, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6 col-6"><span class="font-md-bold text-black">Total</span></div>
                            <div class="col-lg-6 col-6 text-end">
                                <span class="font-lg-bold text-black" id="final-amount">₹{{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <a class="btn btn-buy w-auto text-white mb-10" href="#"><i
                                class="bx bx-right-arrow-alt align-middle fs-4 me-2"></i>Place Order</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.state_id').select2();
        $('.country_id').select2();
        $('.city_id').select2();
        $('#status').select2();
        $('#billing_country').trigger('change');
        $('#shipping_country').trigger('change');

        $('#form-edit-customer').on('submit', function () {
            $('#btn-save').prop('disabled', true);
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });

        $('#billing_country').change(function () {
            var countryId = $(this).val();
            console.log('Selected Country ID:', countryId); // Debugging statement
            $('#billing_state').empty().append('<option value="">Select State</option>');
            $('#billing_city').empty().append('<option value="">Select City</option>');

            if (countryId) {
                $.ajax({
                    url: '{{ route('states.fetch', ':id') }}'.replace(':id', countryId),
                    type: 'GET',
                    success: function (data) {
                        console.log('States Data:', data); // Debugging statement
                        $('#billing_state').empty().append('<option value="">Select State</option>');
                        $.each(data.states, function (key, state) {
                            $('#billing_state').append('<option value="' + key + '">' + state + '</option>');
                        });
                        @if(isset($customer->billingAddress) && isset($customer->billingAddress->state_id))
                            $('#billing_state').val({{ $customer->billingAddress->state_id }}).trigger('change');
                        @endif
                    },
                    error: function (xhr) {
                        console.error('AJAX Error:', xhr.responseText); // Debugging statement
                    }
                });
            }
        });

        $('#billing_state').change(function () {
            var stateId = $(this).val();
            console.log('Selected State ID:', stateId); // Debugging statement
            $('#billing_city').empty().append('<option value="">Select City</option>');

            if (stateId) {
                $.ajax({
                    url: '{{ route('cities.fetch', ':id') }}'.replace(':id', stateId),
                    type: 'GET',
                    success: function (data) {
                        console.log('Cities Data:', data); // Debugging statement
                        $('#billing_city').empty().append('<option value="">Select City</option>');
                        $.each(data.cities, function (key, city) {
                            $('#billing_city').append('<option value="' + key + '">' + city + '</option>');
                        });
                        @if(isset($customer->billingAddress) && isset($customer->billingAddress->city_id))
                            $('#billing_city').val({{ $customer->billingAddress->city_id }});
                        @endif

                    },
                    error: function (xhr) {
                        console.error('AJAX Error:', xhr.responseText); // Debugging statement
                    }
                });
            }
        });

        @if(isset($customer->billingAddress) && isset($customer->billingAddress->country_id))
            $('#billing_country').val({{ $customer->billingAddress->country_id }}).trigger('change');
        @endif
        $('#shipping_country').change(function () {
            var countryId = $(this).val();
            console.log('Selected Country ID:', countryId); // Debugging statement
            $('#shipping_state').empty().append('<option value="">Select State</option>');
            $('#shipping_city').empty().append('<option value="">Select City</option>');

            if (countryId) {
                $.ajax({
                    url: '{{ route('states.fetch', ':id') }}'.replace(':id', countryId),
                    type: 'GET',
                    success: function (data) {
                        console.log('States Data:', data); // Debugging statement
                        $('#shipping_state').empty().append('<option value="">Select State</option>');
                        $.each(data.states, function (key, state) {
                            $('#shipping_state').append('<option value="' + key + '">' + state + '</option>');
                        });
                        @if(isset($customer->shippingAddress) && isset($customer->shippingAddress->state_id))
                            $('#shipping_state').val({{ $customer->shippingAddress->state_id }}).trigger('change');
                        @endif

                    },
                    error: function (xhr) {
                        console.error('AJAX Error:', xhr.responseText); // Debugging statement
                    }
                });
            }
        });

        $('#shipping_state').change(function () {
            var stateId = $(this).val();
            console.log('Selected State ID:', stateId); // Debugging statement
            $('#shipping_city').empty().append('<option value="">Select City</option>');

            if (stateId) {
                $.ajax({
                    url: '{{ route('cities.fetch', ':id') }}'.replace(':id', stateId),
                    type: 'GET',
                    success: function (data) {
                        console.log('Cities Data:', data); // Debugging statement
                        $('#shipping_city').empty().append('<option value="">Select City</option>');
                        $.each(data.cities, function (key, city) {
                            $('#shipping_city').append('<option value="' + key + '">' + city + '</option>');
                        });
                        @if(isset($customer->shippingAddress) && isset($customer->shippingAddress->city_id))
                            $('#shipping_city').val({{ $customer->shippingAddress->city_id }});
                        @endif

                    },
                    error: function (xhr) {
                        console.error('AJAX Error:', xhr.responseText); // Debugging statement
                    }
                });
            }
        });

        $('#same_as_billing').change(function () {
            if ($(this).is(':checked')) {
                // Copy billing fields to shipping fields
                $('#shipping_address').val($('#billing_address').val());
                $('#shipping_phone').val($('#billing_phone').val());
                $('#shipping_country').val($('#billing_country').val()).trigger('change');

                setTimeout(function () {
                    $('#shipping_state').val($('#billing_state').val()).trigger('change');
                }, 500);

                setTimeout(function () {
                    $('#shipping_city').val($('#billing_city').val()).trigger('change');
                }, 1000);

                $('#shipping_postal').val($('#billing_postal').val());
            } else {
                $('#shipping_address').val('');
                $('#shipping_phone').val('');
                $('#shipping_country').val('').trigger('change');
                $('#shipping_state').val('').trigger('change');
                $('#shipping_city').val('').trigger('change');
                $('#shipping_postal').val('');
            }
        });
        @if(isset($customer->shippingAddress) && isset($customer->shippingAddress->country_id))
            $('#shipping_country').val({{ $customer->shippingAddress->country_id }}).trigger('change');
        @endif
    });
</script>
<script>
   $(document).ready(function () {
    updateTotal(); 

    $('#apply-coupon').on('click', function (e) {
        e.preventDefault();

        let couponCode = $('#coupon-code').val();
        let cartTotal = parseFloat($('#cart-total').data('total')) || 0;  // Ensure cartTotal is a number

        if (couponCode.trim() === "") {
            $('#coupon_message').removeClass('text-success').addClass('text-danger');
            $('#coupon_message').text('Please enter a coupon code.');
            return;
        }

        $.ajax({
            url: "{{ route('apply.coupon') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                coupon_code: couponCode,
                cart_total: cartTotal
            },
            success: function (response) {
                if (response.success) {
                    $('#coupon_message').removeClass('text-danger').addClass('text-success');
                    $('#coupon_message').text(response.message);
                    $('#discount-total').data('discount-total', response.discount); 
                    $('#discount-total').text('₹' + response.discount.toFixed(2));  // Update the discount
                    updateTotal();  // Recalculate total after coupon applied
                } else {
                    $('#coupon_message').removeClass('text-success').addClass('text-danger');
                    $('#coupon_message').text(response.message);
                }
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON.errors?.coupon_code
                    ? xhr.responseJSON.errors.coupon_code[0]
                    : 'Something went wrong. Please try again.';
                $('#coupon_message').removeClass('text-success').addClass('text-danger');
                $('#coupon_message').text(errorMessage);
            }
        });
    });

    function updateTotal() {
        // Retrieve the values from data-* attributes
        let subtotal = parseFloat($('#cart-total').data('total')) || 0;
        let shipping = parseFloat($('#shipping-total').data('shipping-total')) || 0;
        let discount = parseFloat($('#discount-total').data('discount-total')) || 0;

        // Check if values are parsed correctly
        console.log('Subtotal:', subtotal, 'Shipping:', shipping, 'Discount:', discount);

        // Calculate total
        let total = subtotal + shipping - discount;
        $('#final-amount').text('₹' + total.toFixed(2));  // Set the final amount
    }
});


</script>
@endsection