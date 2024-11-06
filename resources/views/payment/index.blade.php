@extends('layout.master')

@section('title') Payment  @endsection
@section('css')
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
            <h4 class="mb-sm-0 font-size-18">Manage Payment Methods</h4>
        </div>
    </div>
</div>
<form action="{{ route('payment.update')}}" class="form-horizontal" method="post" autocomplete="off" >
    @csrf
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-9">
                <h4 class="card-title mb-4">Razorpay Payments</h4>
            </div>
            <div class="col-sm-3 text-end">
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Razorpay Payments <small class="text-danger">*</small>
            </label>
            <div class="col-sm-10">
                <input type="checkbox" name="razorpay_payment" 
                    data-bootstrap-switch="" data-off-color="danger" data-on-color="success"
                    class="@error('razorpay_payment') is-invalid @enderror"
                    {{ isset($settings['razorpay_payment']) && $settings['razorpay_payment'] == 1 ? 'checked' : '' }}>
                    @error('razorpay_payment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Razorpay Key ID <small class="text-danger">*</small>
            </label>
            <div class="col-sm-10">
                <input type="text" name="razorpay_key_id" class="form-control @error('razorpay_key_id') is-invalid @enderror" placeholder="Key ID" value="{{ isset($settings['razorpay_key_id']) ? $settings['razorpay_key_id'] : '' }}" required="">
                @error('razorpay_key_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Razorpay Secret ID <small class="text-danger">*</small>
            </label>
            <div class="col-sm-10">
                <input type="text" name="razorpay_secret_id" class="form-control @error('razorpay_secret_id') is-invalid @enderror" placeholder="Secret ID" value="{{ isset($settings['razorpay_secret_id']) ? $settings['razorpay_secret_id'] : '' }}" required="">
                @error('razorpay_secret_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Razorpay Customer Identifier <small class="text-danger">*</small>
            </label>
            <div class="col-sm-10">
                <input type="text" name="razorpay_customer_identifier" class="form-control @error('razorpay_customer_identifier') is-invalid @enderror" placeholder="Customer Identifier" value="{{ isset($settings['razorpay_customer_identifier']) ? $settings['razorpay_customer_identifier'] : '' }}" required="">
                @error('razorpay_customer_identifier')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Webhoook Secret ID 
            </label>
            <div class="col-sm-10">
                <input type="text" name="razorpay_webhook_id" class="form-control @error('razorpay_webhook_id') is-invalid @enderror" placeholder="Webhoook Secret ID" value="{{ isset($settings['razorpay_webhook_id']) ? $settings['razorpay_webhook_id'] : '' }}">
                @error('razorpay_webhook_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
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
                <h4 class="card-title mb-4">Cash On Delivery</h4>
            </div>
            <div class="col-sm-3 text-end">
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">COD  <small class="text-danger">*</small>
            </label>
            <div class="col-sm-10">
                <input type="checkbox" name="cod_payment" data-bootstrap-switch="" data-off-color="danger" data-on-color="success"
                    class="@error('cod_payment') is-invalid @enderror"
                    {{ isset($settings['cod_payment']) && $settings['cod_payment'] == 1 ? 'checked' : '' }}>
                @error('cod_payment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Shipping Charges (₹)<small class="text-danger">*</small>
            </label>
            <div class="col-sm-10">
                <input type="number" name="shipping_charges" min="0" class="form-control @error('shipping_charges') is-invalid @enderror" placeholder="Charges" value="{{ isset($settings['shipping_charges']) ? $settings['shipping_charges'] : '' }}" >
                @error('shipping_charges')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">&nbsp;</label>
            <div class="col-sm-10">
            <button type="submit" id="btn-save" class="btn btn-primary">
                <span class="spinner-border spinner-border-sm" id="btn-spinner" style="display: none;"></span>
                <span id="btn-text">Save</span>
            </button>
            </div>
        </div> 
    </div>
</div>
</form>
@include('layout.session')
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch();
        });

        $('form').on('submit', function() {
            $('#btn-save').prop('disabled', true);
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });
    });
</script>
@endsection