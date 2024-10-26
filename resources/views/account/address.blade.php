@extends('front.layouts.master')

@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

<style>
    .btn-sidebar {
        border: 1px solid #000 !important;
        background-color: transparent !important;
        color: #000 !important;
    }

    .btn-sidebar:hover {
        background-color: #000 !important;
        color: #fff !important;
    }

    .btn-sidebar.active {
        background-color: #000 !important;
        color: #fff !important;
    }

    #update-addresses input,
#update-addresses .select2-container .select2-selection--single {
    height: 50px !important;
    display: flex;
    align-items: center;
}

#update-addresses .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 50px !important; /* Ensure text is vertically aligned */
}

#update-addresses .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 50px !important;
}

</style>
@endsection
@section('content')
@include('layout.session')
<section class="section-box shop-template mt-30 p-lg-5 p-2">
    <div class="container-fluid px-lg-5 p-2">
        <div class="row">
            <div class="col-lg-3 col-12 me-3 border-end border-black">
                @include('account.sidebar')
            </div>
            <div class="col-lg-8 col-12 p-3">
                <form action="{{ route('update.address')}}" id="update-addresses" method="post">
                    @csrf
                    <input type="hidden" name="customer" value="{{ $customer->id }}">
                    <div class="container-fluid">
                        <div class="row mb-3 text-black">
                            <h3>Billing Address</h3>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="">Address *</label>
                                        <textarea rows="3" name="billing_address" id="billing_address"
                                            class="form-control @error('billing_address') is-invalid @enderror"
                                            placeholder="Billing Address">
                                           {{ ($customer->billingAddress->address_line_1 ?? '') }}
                                        </textarea>
                                        @error('billing_address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="">Phone </label>
                                        <input type="number" name="billing_phone" id="billing_phone"
                                            class="form-control @error('billing_phone') is-invalid @enderror"
                                            placeholder="Contact"
                                           value="{{ ($customer->billingAddress->contact ?? '') }}">
                                        @error('billing_phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Country *</label>
                                        <select name="billing_country" id="billing_country"
                                            class="form-control country_id @error('billing_country') is-invalid @enderror">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option {{ isset($customer->billingAddress) && $customer->billingAddress->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id}}">{{ $country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">State *</label>
                                        <select name="billing_state" id="billing_state"
                                            class="form-control state_id @error('billing_state') is-invalid @enderror">
                                            <option value="">Select state</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">City *</label>
                                        <select name="billing_city" id="billing_city"
                                            class="form-control city_id @error('billing_city') is-invalid @enderror">
                                            <option value="">Select city</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Postal Code *</label>
                                        <input type="text" name="billing_postal" id="billing_postal"
                                            class="form-control @error('billing_postal') is-invalid @enderror"
                                            placeholder="Postal Code" value="{{ ($customer->billingAddress->postal_code ?? '') }}">
                                        @error('billing_postal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="container-fluid">
                        <div class="row mb-3 text-black">
                            <h3>Shipping Address</h3>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="">Address *</label>
                                        <textarea rows="3" name="shipping_address" id="shipping_address"
                                            class="form-control @error('shipping_address') is-invalid @enderror"
                                            placeholder="Shipping Address">
                                            {{ ($customer->shippingAddress->address_line_1 ?? '') }}</textarea>
                                        @error('shipping_address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="">Phone </label>
                                        <input  type="number"  name="shipping_phone" id="shipping_phone"
                                            class="form-control @error('shipping_phone') is-invalid @enderror"
                                            placeholder="Contact"
                                           value="{{ ($customer->shippingAddress->contact ?? '') }}">
                                        @error('shipping_phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Country *</label>
                                        <select name="shipping_country" id="shipping_country"
                                            class="form-control country_id @error('shipping_country') is-invalid @enderror">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option {{ isset($customer->shippingAddress) && $customer->shippingAddress->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id}}">{{ $country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">State *</label>
                                        <select name="shipping_state" id="shipping_state"
                                            class="form-control state_id @error('shipping_state') is-invalid @enderror">
                                            <option value="">Select state</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">City *</label>
                                        <select name="shipping_city" id="shipping_city"
                                            class="form-control city_id @error('shipping_city') is-invalid @enderror">
                                            <option value="">Select city</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Postal Code *</label>
                                        <input type="text" name="shipping_postal" id="shipping_postal"
                                            class="form-control @error('shipping_postal') is-invalid @enderror"
                                            placeholder="Postal Code" value="{{ ($customer->shippingAddress->postal_code ?? '') }}">
                                        @error('shipping_postal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 text-center">
                            <button type="submit" id="btn-save" class="btn btn-dark">
                                <span class="spinner-border spinner-border-sm" id="btn-spinner"
                                    style="display: none;"></span>
                                <span id="btn-text">Save</span>
                            </button>
                        </div>
                    </div>
                </form>
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
   
    $('#update-addresses').on('submit', function() {
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

        $('#same_as_billing').change(function() {
        if($(this).is(':checked')) {
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
@endsection