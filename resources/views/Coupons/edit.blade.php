@extends('layout.master')

@section('title') Edit  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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
                <h4 class="mb-sm-0 font-size-18">Edit Coupon</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('coupon.update' ,$coupon->id) }}" id="form-edit-coupon" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <h4 class="card-title mb-4">Edit Coupon</h4>
                            </div>
                            <div class="col-sm-3 text-end">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-3">
                                <div class="img-div text-center btn-logo" id="btn-select-logo" data-column="logo">  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                                    <span id="btn-select-icon" data-column="logo">
                                        <img id="img-logo" src="{{ asset('assets/images/avatar.webp')}}" title="Choose logo" class="logo-display mx-auto img-fluid">
                                    </span>
                                    <input type="hidden" name="logo" id="logo" value="{{ $coupon->logo }}">
                                    <button type="button" id="btn-remove-logo" data-column="logo" class="btn btn-sm btn-default pull-right" title="Clear" style="display: none;"><i class="ri-close-fill fs-16"></i>
                                    </button>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Coupon Name <small class="text-danger">*</small></label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" value="{{ $coupon->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" >
                                @error('name')
                                    <span class="invalid-feedback" >
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>	
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Promo Code <small class="text-danger">*</small></label>
                            <div class="col-sm-8">
                                <input type="text" id="promo_code" name="promo_code" value="{{ $coupon->promocode }}" class="form-control @error('promo_code') is-invalid @enderror" maxlength="8" placeholder="Promo Code" >
                                @error('promo_code')
                                    <span class="invalid-feedback" >
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-info btn-block" id="btnGenerate">Generate</button>
                            </div>
                        </div>	
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Discount <small class="text-danger">*</small></label>
                            <div class="col-sm-8">
                                <input type="text" name="discount" id="discount" value="{{ $coupon->discount }}" class="form-control @error('discount') is-invalid @enderror" placeholder="discount"  >
                                @error('discount')
                                <span class="invalid-feedback" >
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                    <option {{ $coupon->type == 'percentage'  ? 'selected' : ''}} value="percentage">Percentage</option>
                                    <option {{ $coupon->type == 'fixed'  ? 'selected' : ''}} value="fixed">Flat</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" >
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>	
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Min. Value to Redeem Promo <small class="text-danger">*</small></label>
                            <div class="col-sm-10">
                                <input type="text" name="min_order_value" value="{{ $coupon->minimum_amount }}" class="form-control @error('min_order_value') is-invalid @enderror" placeholder="Minimum Price to Redeem Promo Code" >
                                @error('min_order_value')
                                <span class="invalid-feedback" >
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        	
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Duration <small class="text-danger">*</small></label>
                            <div class="col-sm-10">
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
                                    <input type="text" class="form-control @error('start_date') is-invalid @enderror" value="{{ $coupon->start_date}}" name="start_date" id="start_date" placeholder="Start Date" >
                                    @error('start_date')
                                    <span class="invalid-feedback" >
                                        {{ $message }}
                                    </span>
                                    @enderror
                                    <input type="text" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ $coupon->end_date}}"  id="end_date" placeholder="End Date" >
                                    @error('end_date')
                                    <span class="invalid-feedback" >
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>	
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">No. of Redemption / User <small class="text-danger">*</small></label>
                            <div class="col-sm-10">
                                <input type="text" name="redeem_per_user" value="{{ $coupon->max_uses_per_user}}" class="form-control @error('redeem_per_user') is-invalid @enderror" placeholder="No. of Redemption Per User" maxlength="2" >
                                @error('redeem_per_user')
                                <span class="invalid-feedback" >
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>	
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" class="form-control summernote @error('description') is-invalid @enderror" placeholder="Description">
                                    {{ $coupon->description }}
                                </textarea>
                                @error('description')
                                <span class="invalid-feedback" >
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div> 
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Terms &amp; Conditions <small class="text-danger">*</small></label>
                            <div class="col-sm-10">
                                <textarea class="form-control summernote @error('terms') is-invalid @enderror" id="terms" name="terms" placeholder="Terms &amp; Conditions">
                                    {{ $coupon->terms_and_conditions }}
                                </textarea>
                                @error('terms')
                                <span class="invalid-feedback" >
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>	
                        <div class="form-group row mb-3">
                            <label class="col-sm-2 col-form-label">Status <small class="text-danger">*</small></label>
                            <div class="col-sm-10">
                            <select name="status" id="coupon_status" class="form-select" style="width: 100%;" required="required"  tabindex="-1" aria-hidden="true">
                                <option {{ $coupon->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                <option {{ $coupon->status == 0 ? 'selected' : '' }} value="0">In-Active</option>
                            </select>
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
        </div>
    </div>

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
$(document).ready(function () {
    $('#coupon_status').select2();
    $('#type').select2();
    $('.summernote').summernote();
    $('#start_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true
    });
    $('#end_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true
    });
    function generatePromoCode(length) {
			var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    var result = '';
		    for (var i = length; i > 0; --i) 
		    	result += chars[Math.floor(Math.random() * chars.length)];
		    return result;
		}
		
		$("#btnGenerate").click(function() {
			var promoCode = generatePromoCode(8);
			$("#promo_code").val(promoCode);
		})

    $('#form-edit-coupon').on('submit', function () {
         // Disable the submit button
         $('#btn-save').prop('disabled', true);
            // Show spinner and change button text
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
    });
});
</script>
@endsection