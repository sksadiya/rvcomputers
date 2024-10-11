@extends('layout.master')

@section('title') Create  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" />
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
            <h4 class="mb-sm-0 font-size-18">Add New Product</h4>
        </div>
    </div>
</div>
<form action="{{ route('product.store')}}" id="form-add-product" method="post" enctype="multipart/form-data">
    @csrf
<div class="row">
    <div class="col-sm-8">
        <div class="card" >
            <div class="card-header bg-white">
                <h4 class="card-title mb-0 flex-grow-1">Product Information</h4>
            </div>
            <hr>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Product Name <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Product Name"  >
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3" id="" >
                    <label class="col-md-3 col-form-label">Category <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                    <select class="form-control @error('category') is-invalid @enderror" multiple name="category[]" id="category">
                        <option value="">Select a Category</option>
                        @foreach($categoryOptions as $option)
                            <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    </div>
                </div>
                <div class="row mb-3" id="" >
                    <label class="col-md-3 col-form-label">Brand</label>
                    <div class="col-md-8">
                    <select class="form-control @error('brand') is-invalid @enderror" name="brand[]" id="brand">
                        <option value="">Select a Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Unit</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" placeholder="Unit (e.g. Ouns)">
                        @error('unit')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Weight <small>(In Kg)</small>
                    </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control @error('weight') is-invalid @enderror" name="weight" step="0.01" value="" placeholder="0.00">
                        @error('weight')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Minimum Purchase Qty <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <input type="number" lang="en" class="form-control @error('min_qty') is-invalid @enderror" name="min_qty" value="1" min="1" >
                        @error('min_qty')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Tags <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('tags') is-invalid @enderror" name="tags" id="product-tags" placeholder="Add tags" value="{{ old('tags') }}" >
                        @error('tags')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="card-title mb-0 flex-grow-1">Product Images</h4>
            </div>
            <hr>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">Feature Image <small>(300x300)</small>
                    </label>
                    <div class="col-md-8">
                        <div class="img-div text-center btn-logo" id="btn-select-logo" data-column="logo">  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                            <span id="btn-select-icon" data-column="logo">
                            <img id="img-logo" src="https://webcipher.store/rentalse/assets/images/avatar.png" title="Choose logo" class="logo-display mx-auto img-fluid">
                            </span>
                            <input type="hidden" name="image_url" id="logo">
                            <button type="button" id="btn-remove-logo" data-column="logo" class="btn btn-sm btn-danger btn-rounded pull-right" title="Clear" style="display: none;"><i class="bx bx-trash-alt"></i></button>
                        </div>
                        <small class="text-muted">This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">Gallery <small>(600x600)</small>
                    </label>
                    <div class="col-md-8">
                        <div class="img-div text-center btn-galleryimage" id="btn-select-gallery-image" data-column="galleryimage">  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                        <span class="text-blue cursor-pointer img-galleryimage">Choose images</span>
                        </div>
                        <div class="row mt-3" id="previews"></div>
                        <small class="text-muted">These images are visible in product details page gallery. Use 600x600 sizes images.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="card-title mb-0 flex-grow-1">Product Videos</h4>
            </div>
            <hr>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">Video Provider</label>
                    <div class="col-md-8">
                        <select name="video_provider" id="video_provider" class="form-control @error('video_provider') is-invalid @enderror" >
                            <option value="">Select</option>
                            <option value="youtube">Youtube</option>
                            <option value="dailymotion">Dailymotion</option>
                            <option value="vimeo">Vimeo</option>
                        </select>
                        @error('video_provider')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">Video Link</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('video_link') is-invalid @enderror" name="video_link" value="">	
                        @error('video_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">Use proper link without extra parameter. Don't use short share link/embeded iframe code.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="card-title mb-0 flex-grow-1">Product Description</h4>
            </div>
            <hr>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label">Description</label>
                    </div>
                    <div class="col-md-9">
                    <textarea name="description" id="description" rows="10" class="form-control ckeditor-classic">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="mb-3">
        <button type="submit" id="btn-save" class="btn btn-primary">
            <span class="spinner-border spinner-border-sm" id="btn-spinner" style="display: none;"></span>
            <span id="btn-text">Save</span>
        </button>
    </div>
</div>
</form>
@include('layout.session')
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
<script type='text/javascript' src={{ URL::asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}></script>
<script>
    $(document).ready(function() {
        $('#form-add-product').on('submit', function() {
            $('#btn-save').prop('disabled', true);
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });
        const choicesTags = new Choices('#product-tags', {
            removeItemButton: true,
            delimiter: ',',
            editItems: true,
            maxItemCount: 10,
            duplicateItemsAllowed: false,
            placeholderValue: 'Add tags',
            addItemText: (value) => {
                return `Press Enter to add <b>"${value}"</b>`;
            }
        });
        $('#category').select2();
        $('#brand').select2();
        $('#video_provider').select2();
        ClassicEditor.create(document.querySelector("#description"))
            .then(function(editor) {
                editor.ui.view.editable.element.style.height = "200px"; 
            })
            .catch(function(error) {
                console.error(error);
            });
    });
</script>

@endsection