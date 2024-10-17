@extends('layout.master')

@section('title') Edit  @endsection
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
            <h4 class="mb-sm-0 font-size-18">Edit Product</h4>
        </div>
    </div>
</div>
<form action="{{ route('product.update' ,$product->id)}}" id="form-add-product" method="post" enctype="multipart/form-data">
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
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $product->name}}" name="name" placeholder="Product Name"  >
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
                    <select class="form-control select2 @error('category') is-invalid @enderror" multiple name="category[]" id="category">
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
                    <select class="form-control select2 @error('brand') is-invalid @enderror" name="brand" id="brand">
                        <option value="">Select a Brand</option>
                        @foreach($brands as $brand)
                            <option {{ $product->brand_id == $brand->id ? 'selected' :'' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                        <input type="text" class="form-control @error('unit') is-invalid @enderror" value="{{ $product->unit}}" name="unit" placeholder="Unit (e.g. Ouns)">
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
                        <input type="number" class="form-control @error('weight') is-invalid @enderror" name="weight" step="0.01" value="{{ $product->weight }}" placeholder="0.00">
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
                        <input type="number" lang="en" class="form-control @error('min_qty') is-invalid @enderror" name="min_qty" value="{{ $product->min_qty }}" min="1" >
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
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label">Status <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-8">
                    <select name="status" id="product_status" class="form-select select2" style="width: 100%;" required="required"  tabindex="-1" aria-hidden="true">
                            <option {{ $product->status == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $product->status == 0 ? 'selected' : '' }}  value="0">In-Active</option>
                    </select>
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
                        <select name="video_provider" id="video_provider" class="form-control select2 @error('video_provider') is-invalid @enderror" >
                            <option value="">Select</option>
                            <option {{ $product->video_provider == 'youtube'? 'selected' : '' }} value="youtube">Youtube</option>
                            <option {{ $product->video_provider == 'dailymotion'? 'selected' : '' }} value="dailymotion">Dailymotion</option>
                            <option {{ $product->video_provider == 'vimeo'? 'selected' : '' }} value="vimeo">Vimeo</option>
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
                        <input type="text" class="form-control @error('video_link') is-invalid @enderror" name="video_link" value="{{ $product->video_link }}">	
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
                <h4 class="card-title mb-0 flex-grow-1">Product Variation</h4>
            </div>
            <hr>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="color" value="Colors" disabled="">
                    </div>
                    <div class="col-md-8">
                        <select name="colors[]" id="colors" multiple class="form-control select2 @error('colors') is-invalid @enderror">
                            @foreach($colors as $color)
                            <option  {{ $product->colors->contains('id', $color->id) ? 'selected' : '' }} value="{{ $color->id }}" data-color-name="{{ $color->name }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="attribute" value="Attributes" disabled="">
                    </div>
                    <div class="col-md-8">
                        <select name="choice_attributes[]" id="choice_attributes" multiple class="form-control select2 @error('choice_attributes') is-invalid @enderror">
                            @foreach($attributes as $attribute)
                            <option {{ $product->attributes->contains('attribute_id', $attribute->id) ? 'selected' : '' }} value="{{ $attribute->id }}" data-attribute-name="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="customer_choice_options" id="customer_choice_options"></div>
                <div class="sku_combination" id="sku_combination"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="card-title mb-0 flex-grow-1">Product Price + Stock</h4>
            </div>
            <hr>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label">Unit Price <span class="text-danger">*</span>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input type="number" class="form-control @error('unit_price') is-invalid @enderror" value="{{ $product->unit_price }}" name="unit_price" >
                        @error('unit_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label">Discount <span class="text-danger">*</span>
                        </label>
                    </div>
                    <div class="col-md-5">
                        <input type="number" class="form-control @error('discount') is-invalid @enderror" value="{{ $product->discount }}" name="discount">
                        @error('discount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <select name="discount_type" id="discount_type" class="form-control select2  @error('discount_type') is-invalid @enderror" >
                            <option {{ $product->discount_type == 'fixed' ? 'selected' : '' }} value="fixed">Flat</option>
                            <option {{ $product->discount_type == 'percentage' ? 'selected' : '' }} value="percentage">Percentage</option>
                        </select>
                        @error('discount_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label">Quantity <span class="text-danger">*</span>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input type="number" class="form-control @error('current_stock') is-invalid @enderror" name="current_stock" value="{{$product->current_stock}}">
                        @error('current_stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label">SKU</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('sku') is-invalid @enderror" value="{{ $product->sku }}" name="sku">
                        @error('sku')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
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
                        <label class="col-form-label">Short Description</label>
                    </div>
                    <div class="col-md-9">
                    <textarea name="short_description" id="short_description" rows="4" class="form-control summernote ">{{ $product->short_description }}</textarea>
                        @error('short_description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label">Description</label>
                    </div>
                    <div class="col-md-9">
                    <textarea name="description" id="description" rows="10" class="form-control ckeditor-classic">{{ $product->description }}</textarea>
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
    <div class="col-sm-4">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="card-title mb-0 flex-grow-1">Low Stock Quantity Warning</h4>
            </div>
            <hr>
                <div class="card-body p-9">
                    <div class="row mb-3">
                        <div class="col-xl-6">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Quantity</div>
                        </div>
                        <div class="col-xl-6 fv-row">
                            <input type="number" class="form-control  @error('low_stock_quantity') is-invalid @enderror" value="{{ $product->low_stock_quantity}}" name="low_stock_quantity">
                            @error('low_stock_quantity')
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
                        <h4 class="card-title mb-4">Product Image</h4>
                    </div>
                    <div class="col-sm-3 text-end">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <div class="img-div text-center btn-logo" id="btn-select-logo" data-column="logo"> 
                            <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                        <span id="btn-select-icon" data-column="logo">
                        <img id="img-logo" src="{{ $product->image }}" title="Choose logo" class="logo-display mx-auto img-fluid">
                        </span>
                        <input type="hidden" name="image_url" id="logo" value="{{ $product->image }}">
                        <button type="button" id="btn-remove-logo" data-column="logo" class="btn btn-sm btn-danger btn-rounded pull-right" title="Clear" style="display: none;"><i class="bx bx-trash-alt"></i></button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-9">
                        <h4 class="card-title mb-4">Product Gallery</h4>
                    </div>
                    <div class="col-sm-3 text-end">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <div class="img-div text-center btn-galleryimage" id="btn-select-gallery-image" data-column="galleryimage">
                        <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                        <span class="text-blue cursor-pointer img-galleryimage">Choose images</span>
                        </div>
                        <div class="row mt-3" id="previews">
                        @foreach ($product->images as $index => $gallery)
                                    <div id="galleryimage{{ $index }}" class="col-sm-6 mb-2 text-center">
                                        <div class="img-div position-relative">
                                            <img src="{{ $gallery->image_url }}" alt="image" class="logo-display mx-auto img-fluid" style="height: 48px;">
                                            <input type="hidden" value="{{ $gallery->image_url }}" name="gallery_image_url[]">
                                            <button type="button" onClick="removeImage({{ $index }})" style="position: absolute; top: 0; right: 0;" class="btn btn-sm btn-danger btn-rounded">
                                                <i class="bx bx-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            
                        </div>
                        <small class="text-muted">These images are visible in product details page gallery. Use 600x600 sizes images.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" id="btn-save" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm" id="btn-spinner" style="display: none;"></span>
                        <span id="btn-text">Save</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@include('layout.session')
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="{{ URL::asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
<script type='text/javascript' src={{ URL::asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}></script>
<script>
$(document).ready(function() {
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Wrap the token in quotes
        }
    });
    $('#form-add-product').on('submit', function() {
        $('#btn-save').prop('disabled', true);
        $('#btn-spinner').show();
        $('#btn-text').text('Saving...');
    });

    // Initialize product tags
    const choicesTags = new Choices('#product-tags', {
        removeItemButton: true,
        delimiter: ',',
        editItems: true,
        maxItemCount: 10,
        duplicateItemsAllowed: false,
        placeholderValue: 'Add tags',
        addItemText: value => `Press Enter to add <b>"${value}"</b>`
    });

    // Initialize Select2 for dropdowns
    $('.select2').select2();
    $('.summernote').summernote();

    // Initialize CKEditor for product description
    ClassicEditor.create(document.querySelector("#description"))
        .then(editor => {
            editor.ui.view.editable.element.style.height = "200px"; 
        })
        .catch(error => console.error(error));

        $('#choice_attributes').on('change', function() {
        $('#customer_choice_options').html(null);
        $.each($("#choice_attributes option:selected"), function(){
            add_more_customer_choice_option($(this).val(), $(this).text());
        });
        update_sku();
    });
    $('#colors').on('change', function() {
    update_sku();
});
$('body').on("change", ".attribute_choice", function() {
    update_sku();
});
$(document).on('click', '.btn-delete-variant', function() {
        var variantIndex = $(this).data('id');
        var confirmation = confirm("Are you sure you want to delete this variant?");
        if (confirmation) {
            $('.variant' + variantIndex).remove();
        }
    });
function update_sku() {
    $.ajax({
        type: "POST",
        url: '{{ route('product.combination') }}',
        data: $('#form-add-product').serialize(),
        success: function(data) {
            $('#sku_combination').html(data.html);
            if (data.length > 1) {
                $('#show-hide-div').hide();
            } else {
                $('#show-hide-div').show();
            }
        }
    });
}


    function add_more_customer_choice_option(i, name) {
    $.post('{{ route('product.add_more_choice_option') }}', { attribute_id: i }, function(result) {
        var obj = result; // The HTML string returned from the server
        $('#customer_choice_options').append(`
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="hidden" name="choice_no[]" value="${i}">
                    <input type="text" class="form-control" name="choice[]" value="${name}" placeholder="Choice Title" readonly>
                </div>
                <div class="col-md-8">
                    <select class="form-control my-select2 attribute_choice" name="choice_options_${i}[]" multiple="multiple">
                        ${obj} <!-- Append the options HTML here -->
                    </select>
                </div>
            </div>
        `);
        $(".my-select2").select2(); // Reinitialize select2 for new elements
    });
}

    
});
</script>
@endsection