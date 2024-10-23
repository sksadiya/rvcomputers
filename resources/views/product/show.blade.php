@extends('front.layouts.master')
@section('css')
<style>
  #tab-specification .card ,#tab-additional .card{
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
    border-radius:0.25rem;
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
    padding-top: 15px ;
    padding-bottom: 15px ;
}
.btn.btn-buy:hover {
    color : #000 !important;
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
            <div class="box-product-price">
              @if($product->colors->isNotEmpty())
              <div class="box-product-color">
                <p class="font-sm text-black fw-bold">Color</p>
                <div class="d-inline-flex ">
                  @foreach ($product->colors as $color)
                  <h2><span class="badge bg-white text-bg-transparent text-black fw-bold px-3 py-2 me-2" title="{{ $color->name }}">{{ $color->name }}</span></h2>
                @endforeach
                </div>
              </div>
              @endif
              <div class="box-product-color mt-20">
                <div class="row">
                  @foreach ($groupedAttributes as $attributeName => $attributeValues)
            <div class="col-lg-12 mb-20">
            <p class="font-sm text-black fw-bold">{{ ucfirst($attributeName) }}
            </p>

            <div class="d-inline-flex list-{{$attributeName}}"> <!-- Using list-colors for all attributes -->
              @foreach (array_unique($attributeValues) as $value)
              <h2><span class="badge bg-white text-bg-transparent text-black fw-bold px-3 py-2 me-2" title="{{ $value }}">{{ $value }}</span></h2>
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
              <div class="btn-buy mt-5"><a class="btn btn-buy mb-15 fs-4" href="shop-cart.html">Add to cart</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<section class="section-box d-block border-0 m-0">
  <div class="container py-3" style="max-width: 1400px;"> 
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
            <img src="{{ asset('assets/front/assets/imgs/1-Year-Warranty.webp') }}" alt="1 Year Warranty" class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">1 Year Warranty</h5>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-box shop-template">
        <div class="container p-4" style="max-width: 1430px;">
          <div class="pt-30 mb-10 p-5">
            <ul class="nav nav-tabs nav-tabs-product" role="tablist">
            @if(!empty($product->description))
                    <li class="text-black">
                        <a href="#tab-specification" data-bs-toggle="tab" role="tab" aria-controls="tab-specification" aria-selected="true">Specification</a>
                    </li>
                @endif

                @if($product->colors->isNotEmpty() || !empty($groupedAttributes))
                    <li class="text-black">
                        <a href="#tab-additional" data-bs-toggle="tab" role="tab" aria-controls="tab-additional" aria-selected="true">Additional Information</a>
                    </li>
                @endif
            </ul>
            <div class="tab-content">
            @if(!empty($product->description))
              <div class="tab-pane p-5 fade {{ empty($product->description) ? '' : 'active show' }}" id="tab-specification" role="tabpanel" aria-labelledby="tab-specification">
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
              <div class="tab-pane p-5 fade {{ empty($product->description) ? 'active show' : '' }}" id="tab-additional" role="tabpanel" aria-labelledby="tab-additional">
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
    <div class="row px-5">
      @foreach ($products as $product)
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
      <div class="card-grid-style-1 bg-white p-4 card" style="border-radius: 20px; overflow: hidden;">
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
    @endforeach
    </div>
  </div>
</section>
@endsection
@section('script')
<script>
  $(document).ready(function(){
    const quantityInput = document.querySelector('.product-quantity');
    const minusButton = document.querySelector('.minus');
    const plusButton = document.querySelector('.plus');
    minusButton.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1; // Decrease value
        }
    });
    plusButton.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue < 100) { 
            quantityInput.value = currentValue + 1; 
        }
    });
    var table = document.querySelector('.product-description table');
    if (table) {
        table.classList.add('table', 'table-striped');
    }
  });
</script>
@endsection