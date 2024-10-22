@extends('layout.master')

@section('title') Create  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .img-div {
    max-height: 90px;
    border: 1px dashed #ddd;
    border-radius: 4px;
    padding: 10px;
}
.logo-display {
    max-height: 70px;
    display: inline-block;
}
</style>
@endsection
@section('content')
<div class="row">
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">Add New Customer</h4>
    </div>
</div>
</div>
<div class="row" data-select2-id="select2-data-13-677b">
    <div class="col-lg-12" data-select2-id="select2-data-12-59d4">
        <form action="{{ route('customer.store')}}" id="form-add-customer" method="post" autocomplete="off" enctype="multipart/form-data" data-select2-id="select2-data-form-add-seller">
        @csrf    
        <div class="card" data-select2-id="select2-data-11-rdej">
                <div class="card-body" data-select2-id="select2-data-10-kw70">
                    <div class="row">
                        <div class="col-sm-9">
                            <h4 class="card-title mb-4">Customer Details</h4>
                        </div>
                        <div class="col-sm-3 text-end">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Name <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" >
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Email <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" >
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Mobile No.
                                </label>
                                <div class="col-sm-10">
                                    <input type="number" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" placeholder="Mobile No."  >
                                    @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Password <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" >
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Confirm Password <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-10">
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" >
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Avatar</label>
                                <div class="col-sm-3">
                                    <div class="img-div text-center btn-logo" id="btn-select-logo" data-column="logo">  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                                        <span id="btn-select-icon" data-column="logo">
                                            <img id="img-logo" src="{{ asset('assets/images/avatar.webp') }}" title="Choose logo" class="logo-display mx-auto img-fluid">
                                        </span>
                                        <input type="hidden" name="avatar" id="logo" value="{{ asset('assets/images/avatar.webp') }}">
                                        <button type="button" id="btn-remove-logo" data-column="logo" class="btn btn-sm btn-default pull-right" title="Clear" style="display: none;"><i class="ri-close-fill fs-16"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> 

                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Status <small class="text-danger">*</small></label>
                                <div class="col-sm-10">
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" style="width: 100%;" required="">
                                    <option value="1">Active</option>
                                    <option value="0" >In-Active</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                </div>
                            </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <h4 class="card-title mb-4">Billing Address</h4>
                        </div>
                        <div class="col-sm-3 text-end">
                        </div>
                    </div>
                          
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <textarea name="billing_address" id="billing_address" class="form-control @error('billing_address') is-invalid @enderror" placeholder="billing address" ></textarea>
                                    @error('billing_address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Phone
                                </label>
                                <div class="col-sm-10">
                                    <input type="number" name="billing_phone" id="billing_phone" class="form-control @error('billing_phone') is-invalid @enderror" placeholder="Mobile No."  >
                                    @error('billing_phone')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Country</label>
                                <div class="col-sm-4">
                                <select name="billing_country" id="billing_country" class="form-select country_id" style="width: 100%;"  >
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                <label class="col-sm-2 col-form-label">State</label>
                                <div class="col-sm-4 state-dropdown">
                                <select name="billing_state" id="billing_state" class="form-select state_id" style="width: 100%;" >
                                <option value="" >Select State</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-4 city-dropdown">
                                <select name="billing_city" id="billing_city" class="form-select city_id" style="width: 100%;" >
                                <option value="" >Select City</option>
                                </select>
                                </div>
                                <label class="col-sm-2 col-form-label">postal</label>
                                <div class="col-sm-4">
                                     <input type="text" name="billing_postal" id="billing_postal" class="form-control @error('billing_postal') is-invalid @enderror" placeholder="postal" value="" >
                                     @error('billing_postal')
                                     <div class="invalid-feedback">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <h4 class="card-title mb-4">Shipping Address</h4>
                        </div>
                        <div class="col-sm-3 text-end">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="checkbox" id="same_as_billing" name="same_as_billing">
                                    <label for="same_as_billing">Same as Billing Address</label>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <textarea name="shipping_address" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" placeholder="shipping address" ></textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Phone
                                </label>
                                <div class="col-sm-10">
                                    <input type="number" name="shipping_phone" id="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror" placeholder="Mobile No."  >
                                    @error('shipping_phone')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Country</label>
                                <div class="col-sm-4">
                                <select name="shipping_country" id="shipping_country" class="form-select country_id" style="width: 100%;"  >
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                <label class="col-sm-2 col-form-label">State</label>
                                <div class="col-sm-4 state-dropdown">
                                <select name="shipping_state" id="shipping_state" class="form-select state_id" style="width: 100%;" >
                                <option value="" >Select State</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-4 city-dropdown">
                                <select name="shipping_city" id="shipping_city" class="form-select city_id" style="width: 100%;" >
                                <option value="" >Select City</option>
                                </select>
                                </div>
                                <label class="col-sm-2 col-form-label">postal</label>
                                <div class="col-sm-4">
                                     <input type="text" name="shipping_postal" id="shipping_postal" class="form-control @error('shipping_postal') is-invalid @enderror" placeholder="postal" value="" >
                                     @error('shipping_postal')
                                     <div class="invalid-feedback">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                </div>
            </div>
                    <div class="form-group text-center mb-3">
                        <div class="col-sm-12">
                        <button type="submit" id="btn-save" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm" id="btn-spinner" style="display: none;"></span>
                            <span id="btn-text">Save</span>
                        </button>
                        </div>
                    </div> 
        </form>
    </div>
</div>

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('.state_id').select2();
    $('.country_id').select2();
    $('.city_id').select2();
    $('#status').select2();

    $('#form-add-customer').on('submit', function() {
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
                    },
                    error: function (xhr) {
                        console.error('AJAX Error:', xhr.responseText); // Debugging statement
                    }
                });
            }
        });

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
});
</script>
@endsection