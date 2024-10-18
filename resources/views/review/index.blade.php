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
            <h4 class="mb-sm-0 font-size-18">Manage Google Reviews</h4>
        </div>
    </div>
</div>
<form action="{{ route('review.update')}}" class="form-horizontal" method="post" autocomplete="off" >
    @csrf
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-9">
                <h4 class="card-title mb-4">Google Reviews</h4>
            </div>
            <div class="col-sm-3 text-end">
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Google API Key <small class="text-danger">*</small>
            </label>
            <div class="col-sm-10">
                <input type="text" name="google_api_key" class="form-control @error('google_api_key') is-invalid @enderror" placeholder="Google API Key" value="{{ isset($settings['google_api_key']) ? $settings['google_api_key'] : '' }}" required="">
                @error('google_api_key')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Google Account ID <small class="text-danger">*</small>
            </label>
            <div class="col-sm-10">
                <input type="text" name="google_account_id" class="form-control @error('google_account_id') is-invalid @enderror" placeholder="Google Account ID" value="{{ isset($settings['google_account_id']) ? $settings['google_account_id'] : '' }}" required="">
                @error('google_account_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Google Location ID <small class="text-danger">*</small>
            </label>
            <div class="col-sm-10">
                <input type="text" name="google_location_id" class="form-control @error('google_location_id') is-invalid @enderror" placeholder="Google Location ID" value="{{ isset($settings['google_location_id']) ? $settings['google_location_id'] : '' }}" required="">
                @error('google_location_id')
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