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
                <h4 class="card-title mb-0 flex-grow-1">Product Videos</h4>
            </div>
            <hr>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">Video Provider</label>
                    <div class="col-md-8">
                        <select name="video_provider" id="video_provider" class="form-control select2 @error('video_provider') is-invalid @enderror" >
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
                            <option value="{{ $color->id }}" data-color-name="{{ $color->name }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="attribute" value="Attributes" disabled="">
                    </div>
                    <div class="col-md-8">
                        <select name="attributes[]" id="attributes" multiple class="form-control select2 @error('attributes') is-invalid @enderror">
                            @foreach($attributes as $attribute)
                            <option value="{{ $attribute->id }}" data-attribute-name="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="customer_choice_options_container">
            <!-- Dynamic customer choice options will be added here -->
        </div>
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
                        <input type="number" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" >
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
                        <input type="number" class="form-control @error('discount') is-invalid @enderror" name="discount">
                        @error('discount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <select name="discount_type" id="discount_type" class="form-control select2  @error('discount_type') is-invalid @enderror" >
                            <option value="fixed">Flat</option>
                            <option value="percentage">Percentage</option>
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
                        <input type="number" class="form-control" name="current_stock">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="col-form-label">SKU</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="sku">
                    </div>
                </div>
                <div class="row mb-3">
                    <div id="sku_combination_container" class="d-none">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Variant</th>
                                    <th>Variant Price</th>
                                    <th>SKU</th>
                                    <th>Quantity</th>
                                    <th>Photo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamically populated rows will go here -->
                            </tbody>
                        </table>
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
                    <textarea name="short_description" id="short_description" rows="4" class="form-control summernote ">{{ old('short_description') }}</textarea>
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
                            <input type="number" class="form-control  @error('low_stock_quantity') is-invalid @enderror" name="low_stock_quantity">
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
                        <img id="img-logo" src="https://webcipher.store/rentalse/assets/images/avatar.png" title="Choose logo" class="logo-display mx-auto img-fluid">
                        </span>
                        <input type="hidden" name="image_url" id="logo">
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
                        <div class="row mt-3" id="previews"></div>
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
    // Disable save button and show spinner on form submission
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

    // Show variant table
    function showVariantTable() {
        $('#sku_combination_container').removeClass('d-none');
    }

    // Hide variant table
    function hideVariantTable() {
        $('#sku_combination_container').addClass('d-none');
    }

    // Append variant row
    function appendVariantRow(name, id, type) {
    // Generate a unique identifier for the variant image
    const uniqueId = `${type}_${id}_${new Date().getTime()}`;

    return `
        <tr class="variant" id="sku_combination_${type}_${id}" data-id="${id}" data-type="${type}">
            <td>
                <label class="control-label">${name}</label>
                <input type="hidden" name="variant_name[]" value="${name}">
            </td>
            <td>
                <input type="number" lang="en" name="variant_price[]" value="" min="0" step="0.01" class="form-control">
            </td>
            <td>
                <input type="text" name="variant_sku[]" value="" class="form-control">
            </td>
            <td>
                <input type="number" lang="en" name="variant_qty[]" value="10" min="0" step="1" class="form-control">
            </td>
            <td>
               <div class="img-div text-center btn-variantimage btn-select-variantimage" id="btn-select-variantimage-${uniqueId}" data-column="variantimage${uniqueId}">
                    <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                    <span id="btn-select-variantimage-${uniqueId}" data-column="variantimage${uniqueId}">
                        <img id="img-variantimage${uniqueId}" src="{{ asset('assets/images/avatar.webp') }}" title="Choose logo" class="logo-display mx-auto img-fluid">
                    </span>
                    <input type="hidden" name="variant_image_url[]" id="variantimage${uniqueId}">
                    <button type="button" id="btn-remove-variantimage${uniqueId}" data-column="variantimage${uniqueId}" class="btn btn-sm btn-danger btn-rounded pull-right btn-remove-variantimage" title="Clear" style="display: none;"><i class="bx bx-trash-alt"></i></button>
                </div>
            </td>
        </tr>`;
}


    // Handle color changes
    $('#colors').on('change', function() {
        const selectedColors = $(this).find('option:selected');
        const variantTableBody = $('#sku_combination_container tbody');

        // Track current color IDs
        const currentColorIds = selectedColors.map(function() {
            return $(this).val();
        }).get();

        // Remove rows for unselected colors
        variantTableBody.find('.variant[data-type="color"]').each(function() {
            const colorId = $(this).data('id');
            if (!currentColorIds.includes(colorId.toString())) {
                $(this).remove();
            }
        });

        // Add new rows for newly selected colors
        selectedColors.each(function() {
            const colorName = $(this).data('color-name');
            const colorId = $(this).val();
            if (!$(`#sku_combination_color_${colorId}`).length) {
                variantTableBody.append(appendVariantRow(colorName, colorId, 'color'));
            }
        });

        // Show or hide the table based on the presence of variant rows
        if (variantTableBody.find('.variant').length > 0) {
            showVariantTable();
        } else {
            hideVariantTable();
        }
    });

    // Handle attribute changes
    $('#attributes').on('change', function() {
        const selectedAttributes = $(this).find('option:selected');
        const customerChoiceContainer = $('#customer_choice_options_container');

        // Clear the container for attributes
        customerChoiceContainer.empty();

        selectedAttributes.each(function() {
            const attributeName = $(this).data('attribute-name');
            const attributeId = $(this).val();
            const url = '{{ route("getAttributeValues", ":id") }}'.replace(':id', attributeId);

            // Fetch attribute values via AJAX
            $.ajax({
                url: url,
                type: 'GET',
                success: function(attributeValues) {
                    let optionsHtml = '';
                    attributeValues.forEach(function(val) {
                        optionsHtml += `<option value="${val.id}" data-value-name="${val.value}">${val.value}</option>`;
                    });

                    // Add the attribute input with fetched values
                    const attributeHtml = `
                        <div class="customer_choice_options" id="customer_choice_options_${attributeId}">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <input type="hidden" name="choice_no[]" value="${attributeId}">
                                    <input type="text" class="form-control" name="choice[]" value="${attributeName}" readonly>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control select2 attribute_choice" name="choice_options_${attributeId}[]" multiple>
                                        ${optionsHtml}
                                    </select>
                                </div>
                            </div>
                        </div>`;

                    customerChoiceContainer.append(attributeHtml);
                    $('.select2').select2();

                    // Handle changes in attribute value
                    $(`.attribute_choice`).on('change', function() {
                        const selectedValues = $(this).find('option:selected');
                        const variantTable = $('#sku_combination_container tbody');

                        // Remove rows for unselected attribute values
                        variantTable.find('.variant[data-type="attribute"]').each(function() {
                            const attrId = $(this).data('id');
                            if (!selectedValues.map(function() { return $(this).val(); }).get().includes(attrId.toString())) {
                                $(this).remove();
                            }
                        });

                        // Add rows for newly selected attribute values
                        selectedValues.each(function() {
                            const valueName = $(this).data('value-name');
                            const valueId = $(this).val();
                            if (!$(`#sku_combination_attribute_${valueId}`).length) {
                                variantTable.append(appendVariantRow(valueName, valueId, 'attribute'));
                            }
                        });

                        // Show or hide the table based on the presence of variant rows
                        if (variantTable.find('.variant').length > 0) {
                            showVariantTable();
                        } else {
                            hideVariantTable();
                        }
                    });
                },
                error: function(xhr) {
                    console.log("Error fetching attribute values.");
                }
            });
        });
    });
});
</script>
@endsection