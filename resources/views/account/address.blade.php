@extends('front.layouts.master')

@section('css')
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
    select {
        height: 50px !important;
    }
</style>
@endsection
@section('content')
<section class="section-box shop-template mt-30 p-5">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-3 me-3 border-end border-black">
                @include('account.sidebar')
            </div>
            <div class="col-md-8 p-3">
                <form action="" id="update-addresses" method="post">
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
                                            placeholder="Billing Address"></textarea>
                                        @error('billing_address')
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
                                            class="form-control @error('billing_country') is-invalid @enderror">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id}}">{{ $country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">State *</label>
                                        <select name="billing_state" id="billing_state"
                                            class="form-control @error('billing_state') is-invalid @enderror">
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
                                            class="form-control @error('billing_city') is-invalid @enderror">
                                            <option value="">Select city</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Postal Code *</label>
                                        <input type="text" name="billing_postal" id="billing_postal"
                                            class="form-control @error('billing_postal') is-invalid @enderror"
                                            placeholder="Postal Code">
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
                                            placeholder="Shipping Address"></textarea>
                                        @error('shipping_address')
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
                                            class="form-control @error('shipping_country') is-invalid @enderror">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id}}">{{ $country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">State *</label>
                                        <select name="shipping_state" id="shipping_state"
                                            class="form-control @error('shipping_state') is-invalid @enderror">
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
                                            class="form-control @error('shipping_city') is-invalid @enderror">
                                            <option value="">Select city</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Postal Code *</label>
                                        <input type="text" name="shipping_postal" id="shipping_postal"
                                            class="form-control @error('shipping_postal') is-invalid @enderror"
                                            placeholder="Postal Code">
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
@endsection