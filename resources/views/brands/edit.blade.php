@extends('layout.master')

@section('title') Edit  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
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
            <h4 class="mb-sm-0 font-size-18">Edit Brand</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('brand.update', $brand->id )}}" id="form-edit-brand" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Brand</h4>
                    
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Logo</label>
                        <div class="col-sm-3">
                            <div class="img-div text-center btn-logo" id="btn-select-logo" data-column="logo">  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                                <span id="btn-select-icon" data-column="logo">
                                    <img id="img-logo" src="{{ asset('assets/images/avatar.webp') }}" title="Choose logo" class="logo-display mx-auto img-fluid">
                                </span>
                                <input type="hidden" name="logo" id="logo" value="{{ $brand->logo }}">
                                <button type="button" id="btn-remove-logo" data-column="logo" class="btn btn-sm btn-default pull-right" title="Clear" style="display: none;"><i class="ri-close-fill fs-16"></i>
                                </button>
                            </div>
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{ $brand->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   

                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Meta Title</label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ $brand->meta_title }}" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" placeholder="Meta Title">
                            @error('meta_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Meta Description</label>
                        <div class="col-sm-10">
                            <textarea type="text"  class="form-control @error('meta_description') is-invalid @enderror" name="meta_description" placeholder="Meta Description">
                            {{ $brand->meta_description }}
                        </textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Status <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <select name="status" id="brand-status" class="form-control @error('status') is-invalid @enderror" style="width: 100%;" >
                            <option {{ $brand->status == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $brand->status == 0 ? 'selected' : '' }} value="0">In-Active</option>
                        </select>
                        @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
    </div>
</div>
@include('layout.session')
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#brand-status').select2();

        $('#form-edit-brand').on('submit', function() {
            // Disable the submit button
            $('#btn-save').prop('disabled', true);
            
            // Show spinner and change button text
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });
    });
</script>
@endsection