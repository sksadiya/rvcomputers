@extends('front.layouts.master')
@section('css')
<link href="{{ asset('assets/libs/bootstrap-rating/bootstrap-rating.css') }}" rel="stylesheet" type="text/css" />
<style>
  .star {
    cursor: pointer;
    color: #ccc;
    /* Default color */
  }

  .star:hover,
  .star:hover~.star {
    color: #ffcc00;
    /* Color on hover */
  }

  .star.selected {
    color: #ffcc00;
    /* Color for selected stars */
  }

  .progress {
    display: flex;
    height: 1rem;
    overflow: hidden;
    font-size: .75rem;
    background-color: #e9ecef;
    border-radius: .25rem;
  }

  .progress-bar {
    background-color: #000 !important;
  }

  .progress span {
    background: none;
  }

  footer {
    overflow-x: hidden !important;
  }

  #tab-specification .card,
  #tab-additional .card,
  #tab-reviews .card {
    border-radius: 30px;
  }

  .nav-tabs li a.active {
    color: #000;
    font-weight: bold;
  }

  .nav-tabs li a:hover {
    color: #000;
    font-weight: 400;
  }

  .input-step {
    border: 1px solid #000;
    display: inline-flex;
    overflow: visible;
    height: 37.5px;
    border-radius: 0.25rem;
    background: #fff;
    padding: 4px;
  }

  .input-step button {
    width: 1.4em;
    font-weight: 300;
    height: 100%;
    line-height: .1em;
    font-size: 1.4em;
    padding: .2em !important;
    background: #000;
    color: #fff;
    border: none;
    border-radius: 5px;
  }

  .input-step input {
    width: 4em;
    height: 100%;
    text-align: center;
    border: 0;
    background: 0 0;
    color: #000;
    border-radius: 5px;
  }

  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .image-box img {
    transition: transform 0.3s ease;
  }

  .image-box:hover img {
    transform: scale(1.1);
  }

  .item-thumb,
  .item-thumb:hover {
    border-color: #fff !important;
    background-color: #fff !important;
    border-radius: 10px !important;
    height: auto !important;
  }

  .detail-gallery {
    width: 100%;
    border: 4px solid #fff;
    border-radius: 4px;
    background-color: #fff !important;
    border-radius: 20px !important;
  }

  .btn.btn-buy {
    background-color: #000 !important;
    border: 1px solid #000 !important;
    padding-top: 15px;
    padding-bottom: 15px;
  }

  .btn.btn-buy:hover {
    color: #000 !important;
    border: 1px solid #000 !important;
    background-color: transparent !important;
  }
</style>
@endsection
@section('content')
<section class="section-box shop-template">
  <div class="container-fluid p-5">
    <div class="row">
      <div class="col-lg-7">
        <div class="gallery-image">
          <div class="galleries">
            <div class="detail-gallery">
              <div class="product-image-slider">
                @if(collect($allImages)->isNotEmpty())
          @foreach($allImages as $image)
        <figure class="border-radius-10"><img src="{{ asset($image) }}" alt="{{ $product->image }}"></figure>
      @endforeach
        @elseif($product->image)
      <figure class="border-radius-10"><img src="{{ asset($product->image) }}" alt="{{ $product->image }}">
      </figure>
    @else
    <figure class="border-radius-10"><img src="{{ asset('assets/images/product-placeholder.png') }}"
      alt="{{ $product->image }}"></figure>
  @endif
              </div>
            </div>
            <div class="slider-nav-thumbnails">
              @if(collect($allImages)->isNotEmpty())
          @foreach($allImages as $image)
        <div>
        <div class=" item-thumb"><img src="{{ asset($image) }}" width='200px' height="200px"
        alt="{{ $product->image }}"></div>
        </div>
      @endforeach
        @elseif($product->image)
        <div>
        <div class=" item-thumb"><img src="{{ asset($product->image) }}" width='200px' height="200px"
          alt="{{ $product->image }}"></div>
        </div>
      @else
      <div>
      <div class=" item-thumb"><img src="{{ asset('assets/images/product-placeholder.png') }}" width='200px'
        height="200px" alt="{{ $product->image }}"></div>
      </div>
    @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 p-5">
        <h3 class="text-black fw-bolder mb-25">
          {{ $product->name }}
        </h3>
        <p>{!! $product->short_description !!} </p>
        <div class="row">
          <div class="container">
            <div class="box-product-price mb-3">
              <h3 class="color-brand-3 text-black fw-bolder d-inline-block mr-10">₹ {{ $product->unit_price }}</h3>
              @if($product->old_price)
          <span class="color-gray-500 text-black fw-bolder font-xl line-througt">₹ {{ $product->old_price }}</span>
        @endif
            </div>
            <div class="container">
              <div class="row mb-3">
                <label for="">Color</label>
                <select name="color" id="color" class="form-control">
                  <option value="">Choose Option</option>
                  @foreach ($product->colors as $color)
            <option value="{{ $color->id }}">{{ $color->name }}</option>
          @endforeach
                </select>
              </div>
              @foreach ($groupedAttributes as $attributeName => $attributeValues)
              <div class="row mb-3">
                  <label for="">{{ ucfirst($attributeName) }}</label>
                  <select name="{{ strtolower($attributeName) }}" 
                          id="{{ strtolower($attributeName) }}" 
                          class="form-control attribute-select" 
                          data-attribute-name="{{ strtolower($attributeName) }}">
                      <option value="">Choose Option</option>
                      @foreach (array_unique($attributeValues) as $value)
                          <option value="{{ $value }}">{{ $value }}</option>
                      @endforeach
                  </select>
              </div>
        @endforeach
            </div>
            <div class="box-product-price">
              @if($product->colors->isNotEmpty())
          <div class="box-product-color">
          <p class="font-sm text-black fw-bold">Color</p>
          <div class="d-inline-flex ">
            @foreach ($product->colors as $color)
        <h2><span class="badge bg-white text-bg-transparent text-black fw-bold px-3 py-2 me-2"
          title="{{ $color->name }}">{{ $color->name }}</span></h2>
      @endforeach
          </div>
          </div>
        @endif
        <input type="hidden" id="product-id" name="product-id" value="{{ $product->id }}" >
              <div class="box-product-color mt-20">
                <div class="row">
                  @foreach ($groupedAttributes as $attributeName => $attributeValues)
            <div class="col-lg-12 mb-20">
            <p class="font-sm text-black fw-bold">{{ ucfirst($attributeName) }}
            </p>

            <div class="d-inline-flex list-{{$attributeName}}"> <!-- Using list-colors for all attributes -->
              @foreach (array_unique($attributeValues) as $value)
          <h2><span class="badge bg-white text-bg-transparent text-black fw-bold px-3 py-2 me-2"
          title="{{ $value }}">{{ $value }}</span></h2>
        @endforeach
            </div>
            </div>
          @endforeach
                </div>
              </div>

              <div class="buy-product mt-10 d-flex">
                <div class="fs-3 text-quantity me-3 text-black">Quantity</div>
                <div class="box-quantity text-black">
                  <div class="input-step">
                    <button type="button" class="minus material-shadow">–</button>
                    <input type="number" class="product-quantity" value="1" min="1" max="100">
                    <button type="button" class="plus material-shadow">+</button>
                  </div>
                </div>
              </div>
              <div class="btn-buy mt-5"><button id="addToCartButton" class="btn btn-buy mb-15 fs-4">Add to cart</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<section class="section-box d-block border-0 m-0">
  <div class="container p-3" style="max-width: 1400px;">
    <div class="row justify-content-center align-items-stretch">
      <div class="col-lg-2 col-md-4 col-6 mb-4">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/front/assets/imgs/scratchless.webp') }}" alt="Scratchless" class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">Scratchless</h5>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6 mb-4">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/front/assets/imgs/lowest-price.webp') }}" alt="Lowest Price" class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">Lowest Price</h5>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6 mb-4">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/front/assets/imgs/buyback.webp') }}" alt="Buy Back" class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">Lifetime Buyback</h5>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6 mb-4">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/front/assets/imgs/bag.webp') }}" alt="Bag" class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">With 4 Accessories</h5>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6 mb-4">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/front/assets/imgs/1-Year-Warranty.webp') }}" alt="1 Year Warranty"
              class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">1 Year Warranty</h5>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-box shop-template">
  <div class="container" style="max-width: 1430px;">
    <div class="pt-30 mb-10">
      <ul class="nav nav-tabs px-2 nav-tabs-product" role="tablist">
        @if(!empty($product->description))
      <li class="text-black">
        <a href="#tab-specification" data-bs-toggle="tab" role="tab" aria-controls="tab-specification"
        aria-selected="true">Specification</a>
      </li>
    @endif
        @if($product->colors->isNotEmpty() || !empty($groupedAttributes))
      <li class="text-black">
        <a href="#tab-additional" data-bs-toggle="tab" role="tab" aria-controls="tab-additional"
        aria-selected="true">Additional Information</a>
      </li>
    @endif
        <li class="text-black">
          <a href="#tab-reviews" data-bs-toggle="tab" role="tab" aria-controls="tab-reviews" aria-selected="true">Reviews({{ $product->reviews->count() }})</a>
        </li>
      </ul>
      <div class="tab-content px-2">
        @if(!empty($product->description))
      <div class="tab-pane px-2  fade {{ empty($product->description) ? '' : 'active show' }}" id="tab-specification"
        role="tabpanel" aria-labelledby="tab-specification">
        <div class="card p-5">
        <div class="justify-content-center align-items-center">
          <h3 class="mb-25 fs-1 fw-bolder text-black text-center">Product Specification</h3>
        </div>
        <div class="product-description mb-4">
          {!! $product->description !!}
        </div>
        </div>

      </div>
    @endif
        @if($product->colors->isNotEmpty() || !empty($groupedAttributes))
        <div class="tab-pane  fade {{ empty($product->description) ? 'active show' : '' }} " id="tab-additional"
          role="tabpanel" aria-labelledby="tab-additional">
          <div class="card p-5">
          <div class="justify-content-center align-items-center">
            <h3 class="mb-25 fs-1 fw-bolder text-black text-center">Additional Information</h3>
          </div>
          <div class="table-responsive mt-4">
            <table class="table table-striped">

            <tbody>
              @if($product->colors->isNotEmpty())
          <tr>
          <td class="fs-5 fw-bold">Color</td>
          <td>
          @foreach ($product->colors as $color)
        {{ $color->name }}@if(!$loop->last), @endif
      @endforeach
          </td>
          </tr>
        @endif
              @if(!empty($groupedAttributes) && count($groupedAttributes) > 0)
            @foreach ($groupedAttributes as $attributeName => $attributeValues)
          <tr>
          <td class="fs-5 fw-bold">{{ ucfirst($attributeName) }}</td>
          <td>
          @php
      // Exploding attribute value if it's comma-separated and removing duplicates
      $valuesArray = array_unique(explode(',', implode(',', $attributeValues)));
    @endphp

          <!-- Output comma-separated values -->
          {{ implode(', ', $valuesArray) }}
          </td>
          </tr>
      @endforeach
        @endif
            </tbody>
            </table>
          </div>
          </div>
        </div>
    @endif
        <div class="tab-pane fade active show" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews">
          <div class="card p-5">
            <div class="card-body">
              <div class="comments-area">
                <form action="{{ route('review.add') }}" method="post" id="add-review-form">
                  @csrf
                <div class="row">
                  <div class="col-lg-8">
                    <div class="row mb-4">
                      <input type="hidden" name="product" value="{{ $product->id }}">
                      @if(Auth::guard('customer')->check())
                        <input type="hidden" name="customer" value="{{ Auth::guard('customer')->user()->id }}">
                      @else
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="review">Name</label>
                    <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror" placeholder="Your Name">
                    @error('name')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
              @enderror
                  </div>
                  </div>
          <div class="col-md-6">
          <div class="form-group">
            <label for="review">Email</label>
            <input type="text" name="email" id="email"
            class="form-control @error('email') is-invalid @enderror" placeholder="Your Email">
            @error('email')
        <div class="invalid-feedback">
        {{ $message }}
        </div>
      @enderror
          </div>
          </div>
        @endif
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="review">Rating</label>
                          <div class="rating-star" style="font-size: 1.5rem;">
                            <input type="hidden" name="rating" id="rating" value="0" />
                            <span class="star" data-value="1">&#9733;</span>
                            <span class="star" data-value="2">&#9733;</span>
                            <span class="star" data-value="3">&#9733;</span>
                            <span class="star" data-value="4">&#9733;</span>
                            <span class="star" data-value="5">&#9733;</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="review">Review</label>
                          <textarea name="comment" id="comment" rows="5"
                            class="form-control @error('comment') is-invalid @enderror"
                            placeholder="Your Review"></textarea>
                          @error('comment')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
              @enderror
                        </div>
                      </div>
                      <div class="form-group mt-3">
                        <button type="submit" id="btn-save" class="btn btn-dark">
                          <span class="spinner-border spinner-border-sm" id="btn-spinner" style="display: none;"></span>
                          <span id="btn-text">Submit</span>
                        </button>
                      </div>
                    </div>
                    <div class="comment-list">
                      @foreach ($product->reviews as $review)
              <div class="single-comment justify-content-between d-flex mb-30 border-black">
              <div class="user justify-content-between d-flex">
                <div class="thumb text-center">
                <img src="{{  asset('assets/images/users/user-dummy-img.jpg') }}" alt="{{ $review->name }}">
                <a class="font-heading text-black" href="#">{{ $review->name }}</a>
                </div>
                <div class="desc">
                <div class="d-flex justify-content-between mb-10">
                  <div class="d-flex align-items-center">
                  <span
                    class="font-xs text-muted me-5">{{ \Carbon\Carbon::parse($review->created_at)->format('F j, Y \a\t h:i A') }}</span>
                  </div>
                  <div class="product-rate d-inline-block">
                  <div class="product-rating" style="width: {{ ($review->rating / 5) * 100 }}%"></div>
                  </div>
                </div>
                <p class="mb-10 font-sm text-black">
                  {{ $review->comment }}
                </p>
                </div>
              </div>
              </div>

            @endforeach

                    </div>
                  </div>
                  <div class="col-lg-4">
                    <h4 class="mb-30 title-question text-black ">Customer reviews</h4>
                    <div class="d-flex mb-30">
                      <div class="product-rate d-inline-block mr-15">
                        <div class="product-rating " style="width: {{ ($averageRating / 5) * 100 }}%"></div>
                      </div>
                      <h6 class="text-black">{{ number_format($averageRating, 1) }} out of 5</h6>
                    </div>
                    @foreach ($ratingSummary as $stars => $percentage)
            <div class="progress">
              <span>{{ $stars }} star</span>
              <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%"
              aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
              {{ number_format($percentage, 0) }}%
              </div>
            </div>
          @endforeach
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="border-bottom pt-30 mb-50"></div>
      </div>
    </div>
  </div>
</section>

<section class="section-box d-block border-0 m-0">
  <div class="container-fluid p-5">
    <div class="row mb-5 px-5">
      <div class="col text-center d-flex fw-bolder fs-1 text-black">
        You may also like
      </div>
    </div>
    <div class="row px-lg-5">
      @foreach ($products as $product)
      <div class="col-12 col-md-6 col-lg-3 mb-4">
      <div class="card-grid-style-3 bg-white p-4 card" style="border-radius: 20px; overflow: hidden;">
        <div class="card-grid-inner border-0">
        <div class="tools">
          <a class="btn btn-wishlist btn-tooltip mb-10" href="shop-wishlist.html" aria-label="Add To Cart"></a>
        </div>
        <div class="image-box card-img-top">
          <img src="{{ $product->image }}" alt="Ecom" class="img-fluid">
        </div>
        <div class="mb-2">
          @if ($product->current_stock > 1)
        <span class="badge badge-soft-success">In Stock ({{ $product->current_stock }} Units)</span>
      @else
      <span class="badge badge-soft-danger">Out of Stock</span>
    @endif
        </div>
        <h4 class="text-dark fw-bold">{{ $product->name }}</h4>
        <div class="mt-20">
          <span class="color-black-500 mr-30">₹ {{ $product->unit_price }}</span>
          <span class="color-black-500">
          @if ($product->old_price)
        <span class="text-decoration-line-through">₹ {{ $product->old_price }}</span>
      @endif
          </span>
        </div>
        </div>
      </div>
      </div>
    @endforeach
    </div>
  </div>
</section>
@endsection
@section('script')
<script>
  $(document).ready(function () {
    const quantityInput = document.querySelector('.product-quantity');
    const minusButton = document.querySelector('.minus');
    const plusButton = document.querySelector('.plus');
    minusButton.addEventListener('click', function () {
      let currentValue = parseInt(quantityInput.value);
      if (currentValue > 1) {
        quantityInput.value = currentValue - 1; // Decrease value
      }
    });
    plusButton.addEventListener('click', function () {
      let currentValue = parseInt(quantityInput.value);
      if (currentValue < 100) {
        quantityInput.value = currentValue + 1;
      }
    });
    var table = document.querySelector('.product-description table');
    if (table) {
      table.classList.add('table', 'table-striped');
    }
    const stars = $('.star');
    const ratingInput = $('#rating');

    stars.on('click', function () {
      const value = $(this).data('value');

      // Update hidden input
      ratingInput.val(value);

      // Clear previous selections
      stars.removeClass('selected');

      // Set selected stars
      stars.each(function (index) {
        if (index < value) {
          $(this).addClass('selected');
        }
      });
    });
    $('#add-review-form').on('submit', function() {
            $('#btn-save').prop('disabled', true);
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });
  });
</script>
<script>
$(document).ready(function () {
    const colorSelect = $('#color');
    const attributeSelects = $('.attribute-select');
    const addToCartButton = $('#addToCartButton');

    function getSelectedAttributes() {
        let attributes = {};
        if (colorSelect.val()) {
            attributes['color'] = colorSelect.find('option:selected').text().trim();
        }

        attributeSelects.each(function () {
            if ($(this).val()) {
                const attributeName = $(this).data('attribute-name');
                attributes[attributeName] = $(this).find('option:selected').text().trim();
            }
        });

        return attributes;
    }

    function checkVariantAvailability() {
        const attributes = getSelectedAttributes();
        productId = $('#product-id').val();
        if (Object.keys(attributes).length === 0) {
            addToCartButton.prop('disabled', true);
            return;
        }

        $.ajax({
            url: "{{ route('product.checkVariant') }}",
            method: "POST",
            data: {
                product_id: productId,
                attributes: attributes,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.status === 'available') {
                    addToCartButton.prop('disabled', false);
                } else {
                    addToCartButton.prop('disabled', true);
                    alert("Selected variation is not available or out of stock.");
                }
            },
            error: function () {
                alert("Error checking variant availability.");
            }
        });
    }

    colorSelect.change(checkVariantAvailability);
    attributeSelects.change(checkVariantAvailability);
    addToCartButton.on('click', function (event) {
        const attributes = getSelectedAttributes();
        if (Object.keys(attributes).length === 0) {
            event.preventDefault(); // Prevent default action
            alert("Please select options before adding to cart."); // Alert user
        } else {
            // Proceed with add to cart functionality
            // Here you can add any additional logic needed for adding the item to the cart
            alert("Item added to cart!"); // Placeholder for the success message
        }
    });
});
</script>


@endsection