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
            <h4 class="mb-sm-0 font-size-18">Edit Slider</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('slider.update' ,$slider->id )}}" id="form-edit-slider" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Slider</h4>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Slider Type <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" style="width: 100%;" required>
                            <option value="">Select</option>
                            <option {{ $slider->slider_type == 'default' ? 'selected' : '' }} value="default">Default</option>
                            <option {{ $slider->slider_type == 'category' ? 'selected' : '' }} value="category">Category</option>
                            <option {{ $slider->slider_type == 'product' ? 'selected' : '' }} value="product">Product</option>
                        </select>
                        @error('type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    @if($slider->slider_type == 'product')
                        <div class="form-group row mb-3 slider-type-product" >
                            <label class="col-sm-2 col-form-label">Product <small class="text-danger">*</small></label>
                            <div class="col-sm-10">
                                <select name="product" id="product" class="form-control @error('product') is-invalid @enderror" style="width: 100%;">
                                    <option value="">Select</option>
                                    @foreach ($products as $product)
                                        <option {{ $slider->type_id == $product->id ? 'selected' : '' }} value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endif
                    @if($slider->slider_type == 'category')
                        <div class="form-group row mb-3 slider-type-category" >
                            <label class="col-sm-2 col-form-label">Category <small class="text-danger">*</small></label>
                            <div class="col-sm-10">
                                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" style="width: 100%;">
                                    <option value="">Select</option>
                                    @foreach ($categories as $category)
                                        <option {{ $slider->type_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Image <span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <div class="img-div text-center btn-logo" id="btn-select-logo" data-column="logo">  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                                <span id="btn-select-icon" data-column="logo">
                                    <img id="img-logo" src="{{ $slider->image }}" title="Choose logo" class="logo-display mx-auto img-fluid">
                                </span>
                                <input type="hidden" name="logo" id="logo" value="{{ $slider->image }}">
                                <button type="button" id="btn-remove-logo" data-column="logo" class="btn btn-sm btn-default pull-right" title="Clear" style="display: none;"><i class="ri-close-fill fs-16"></i>
                                </button>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Link </label>
                        <div class="col-sm-10">
                            <input type="text" name="link" value="{{ $slider->link }}" class="form-control @error('link') is-invalid @enderror" placeholder="Link" >
                            @error('link')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Status <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <select name="status" id="slider-status" class="form-control @error('status') is-invalid @enderror" style="width: 100%;" >
                            <option {{ $slider->status == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $slider->status == 0 ? 'selected' : '' }} value="0">In-Active</option>
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
        $('#slider-status').select2();
        $('#type').select2({
            placeholder: "Select",
        });
        $('#product').select2({
            placeholder: "Select",
        });
        $('#category').select2({
            placeholder: "Select",
        });

        $('#form-edit-slider').on('submit', function() {
            // Disable the submit button
            $('#btn-save').prop('disabled', true);
            
            // Show spinner and change button text
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });

        $("#type").change(function() {
        let slider_type = $(this).val();
        
        // Hide all sections initially
        $(".slider-type-default").hide();
        $(".slider-type-category").hide();
        $(".slider-type-product").hide();
        
        // Reset required attributes
        $("#product").removeAttr('required').val(''); // Clear product selection and remove required
        $("#category").removeAttr('required').val(''); // Clear category selection and remove required

        if (slider_type == "default") {
            $(".slider-type-default").show();
            // No need to set required for default
        } else if (slider_type == "category") {
            $(".slider-type-category").show();
            $("#category").attr('required', 'required'); // Set category as required
        } else if (slider_type == "product") {
            $(".slider-type-product").show();
            $("#product").attr('required', 'required'); // Set product as required
        }
    });
    });
</script>
@endsection