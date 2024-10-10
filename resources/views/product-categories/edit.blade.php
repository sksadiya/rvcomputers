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
            <h4 class="mb-sm-0 font-size-18">Edit Category</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('category.update' ,$category->id )}}" id="form-edit-category" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Category</h4>
                    
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Logo</label>
                        <div class="col-sm-3">
                            <div class="img-div text-center btn-logo" id="btn-select-logo" data-column="logo">  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                                <span id="btn-select-icon" data-column="logo">
                                    <img id="img-logo" src="{{ $category->logo }}" title="Choose logo" class="logo-display mx-auto img-fluid">
                                </span>
                                <input type="hidden" name="logo" id="logo" value="{{ $category->logo }}">
                                <button type="button" id="btn-remove-logo" data-column="logo" class="btn btn-sm btn-default pull-right" title="Clear" style="display: none;"><i class="ri-close-fill fs-16"></i>
                                </button>
                            </div>
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" value="{{ $category->name }}" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Parent Category <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror" >
                                <option value="">None</option>
                                @foreach ($formattedCategories as $cat)
                                    <option {{ $category->parent_category_id == $cat['id'] ? 'selected' : '' }} value="{{ $cat['id'] }}">
                                        {{ $cat['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   
                    

                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Meta Title</label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control @error('meta_title') is-invalid @enderror" value="{{ $category->meta_title }}" name="meta_title" placeholder="Meta Title">
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
                            <textarea type="text" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description" placeholder="Meta Description">
                                {{ $category->meta_description }}
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
                        <select name="status" id="category_status" class="form-control @error('status') is-invalid @enderror" style="width: 100%;" >
                            <option {{ $category->status == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $category->status == 0 ? 'selected' : '' }} value="0">In-Active</option>
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
        $('#parent_id').select2();
        $('#category_status').select2();
        $('#form-edit-category').on('submit', function() {
            // Disable the submit button
            $('#btn-save').prop('disabled', true);
            
            // Show spinner and change button text
            $('#btn-spinner').show();
            $('#btn-text').text('Updating...');
        });
    });
</script>
@endsection