@extends('front.layouts.master')
@section('css')
<style>
.btn.btn-border.active { 
  background-color: #b2c2e1 !important;
}
  .border-brand-2::before {
    background-color: #000;
  }

  .list-color li a {
    display: inline-block;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    margin-bottom: 5px;
  }

  /* .cb-container .checkmark:after  {
        background: #000;
    } */
  .list-nav-arrow li a {
    background: none;
    padding: 0;
  }

  .list-nav-arrow li:hover .number {
    color: #fff !important;
    background-color: #000;
  }

  footer {
    overflow-x: hidden !important;
  }

  .container {
    max-width: 1400px !important;
  }

  .card-grid-style-3:hover .card-grid-inner {
    border-color: #000 !important;
  }

  .btn.btn-cart {
    color: #000;
    border-color: #000;
  }

  .btn.btn-cart:hover {
    background-color: #000;
  }

  .btn.btn-wishlist,
  .btn.btn-quickview {
    border-color: #000;
  }
</style>
@endsection
@section('content')
<div class="section-box shop-template mt-30 p-lg-0 p-3">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 order-first order-lg-last">
        <div class="box-filters mt-0 pb-5 border-bottom">
          <div class="row">
            <div class="col-xl-12 col-lg-9 mb-10 text-lg-end text-center">
              <form action="{{ route('product.shop') }}" method="get" class="d-inline">
                <div class="d-inline-block mb-3"><span class="font-sm text-black me-2 font-medium">Sort by</span>
                  <div class="dropdown dropdown-sort border-1-right">
                    <select name="sort_order" class="form-select font-sm color-gray-900 font-medium"
                      onchange="this.form.submit()">
                      <option value="latest" {{ request('sort_order', 'latest') == 'latest' ? 'selected' : '' }}>Latest
                        products</option>
                      <option value="oldest" {{ request('sort_order') == 'oldest' ? 'selected' : '' }}>Oldest products
                      </option>
                    </select>
                  </div>
                </div>
                <div class="d-inline-block"><span class="font-sm text-black font-medium me-2">Show</span>
                  <div class="dropdown dropdown-sort border-1-right">
                    <div class="dropdown dropdown-sort border-1-right">
                      <select name="per_page" id="per_page" class="form-select font-sm color-gray-900 font-medium"
                        onchange="this.form.submit()">
                        <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8 items</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 items</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 items</option>
                      </select>
                    </div>
                  </div>
              </form>
            </div>
            <div class="d-inline-block">
              <button id="grid-view-btn" class="border-0 view-type-grid mr-5 p-2 "
                style="background: none !important;"><i
                  class="bx bx-grid-alt fs-3 text-black align-middle"></i></button>
              <button id="list-view-btn" class="border-0 view-type-grid mr-5 p-2 "
                style="background: none !important;"><i class="bx bx-list-ul fs-2 text-black align-middle"></i></button>
              <a href="{{ route('product.shop')}}" class="border-0 view-type-grid mr-5 p-2 "
                style="background: none !important;"><i class="bx bx-reset fs-2 text-black align-middle"></i></a>
            </div>
          </div>
        </div>
      </div>
      <!-- Grid View -->
      <div id="grid-view" class="row mt-20">
        @foreach ($shopProducts as $product)
      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 border-black">
        <div class="card-grid-style-3">
        <div class="card-grid-inner">
          <div class="tools">
          <a class="btn btn-wishlist border-black p-1 btn-tooltip mb-10" href="" aria-label="Add To Cart"
            style="background: none; border :1px solid #000 !important;">
            <i class="fas fa-shopping-cart text-black"></i>
          </a>
          <a class="btn btn-quickview border-black p-1 btn-tooltip" aria-label="Quick view" href="#ModalQuickview"
            data-bs-toggle="modal" style="background: none; border :1px solid #000 !important;">
            <i class="fas fa-eye text-black"></i>
          </a>
          </div>
          <div class="image-box">
          <a href="{{ route('product.show', $product->slug)}}">
            <img src="{{ $product->image }}" alt="Ecom">
          </a>
          </div>
          <div class="info-right">
          <a class="font-xs text-black" href="">{{ $product->brand->name }}</a><br>
          <a class="text-black font-sm-bold"
            href="{{ route('product.show', $product->slug)}}">{{ $product->name }}</a>
          <div class="price-info">
            <strong class="font-lg-bold text-black price-main">₹ {{ $product->unit_price }}</strong>
            @if(!empty($product->old_price))
        <span class="text-black price-line">₹ {{ $product->old_price}}</span>
      @endif
          </div>
          <div class="mt-20 box-btn-cart">
            <a class="btn btn-cart" href="{{ route('product.show' ,$product->slug)}}">Select Options</a>
          </div>
          </div>
        </div>
        </div>
      </div>
    @endforeach
      </div>

      <!-- List View -->
      <div id="list-view" class="row p-lg-3" style="display: none;">
        @foreach ($shopProducts as $product)
      <div class="col-lg-12">
        <div class="card-grid-style-3">
        <div class="card-grid-inner d-inline-flex w-100">
          <div class="tools">
          <a class="btn btn-wishlist border-black p-1 btn-tooltip mb-10" href="" aria-label="Add To Cart"
            style="background: none; border :1px solid #000 !important;">
            <i class="fas fa-shopping-cart text-black"></i>
          </a>
          <a class="btn btn-quickview border-black p-1 btn-tooltip" aria-label="Quick view" href="#ModalQuickview"
            data-bs-toggle="modal" style="background: none; border :1px solid #000 !important;">
            <i class="fas fa-eye text-black"></i>
          </a>
          </div>
          <div class="image-box w-25">
          <a href="{{ route('product.show', $product->slug)}}">
            <img src="{{ $product->image }}" alt="Ecom">
          </a>
          </div>
          <div class="info-right">
          <a class="font-xs text-black" href="shop-vendor-single.html">{{ $product->brand->name }}</a><br>
          <a class="text-black font-sm-bold"
            href="{{ route('product.show', $product->slug)}}">{{ $product->name }}</a>
          <div class="price-info">
            <strong class="font-lg-bold text-black price-main">₹ {{ $product->unit_price }}</strong>
            @if(!empty($product->old_price))
        <span class="text-black price-line">₹ {{ $product->old_price}}</span>
      @endif
          </div>
          <div class="mt-20 box-btn-cart">
            <a class="btn btn-cart" href="">Add To Cart</a>
          </div>
          </div>
        </div>
        </div>
      </div>
    @endforeach
      </div>

      <nav>
        <div class="pagination">
          {{ $shopProducts->links('vendor.pagination.custom') }}
        </div>
      </nav>
    </div>
    <div class="col-lg-3 order-last order-lg-first">
      <div class="sidebar-border mb-0">
        <div class="sidebar-head">
          <h6 class="text-black fw-bold fs-3">Product Categories</h6>
        </div>
        <div class="sidebar-content">
          <ul class="list-nav-arrow">
            @foreach ($categories as $category)
              <li>
                <a class="text-black" href="{{ route('product.shop', array_merge(request()->query(), ['category' => $category->slug])) }}">
                  <i class="bx bx-chevron-right me-2"></i>{{ $category->name }}
                  <span class="number text-black">{{ $category->products->count() }}</span>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="sidebar-border mb-40">
        <div class="sidebar-head">
          <h6 class="text-black fw-bold fs-3">Products Filter</h6>
        </div>
        <div class="sidebar-content">
          <h6 class="text-black fw-bold fs-3 mt-10 mb-10">Price</h6>
          <form id="priceFilterForm" method="get" action="{{ route('product.shop') }}">
    <ul class="list-checkbox">
        <li>
            <label>
                <input type="checkbox" class="me-2" name="price[]" value="1000-2000" >
                <span class="text-small">₹1000 - ₹2000</span>
            </label>
        </li>
        <li>
            <label>
                <input type="checkbox" class="me-2" name="price[]" value="3000-4000" >
                <span class="text-small">₹3000 - ₹4000</span>
            </label>
        </li>
        <li>
            <label>
                <input type="checkbox" class="me-2" name="price[]" value="5000-6000" >
                <span class="text-small">₹5000 - ₹6000</span>
            </label>
        </li>
        <li>
            <label>
                <input type="checkbox" class="me-2" name="price[]" value="6000-7000" >
                <span class="text-small">₹6000 - ₹7000</span>
            </label>
        </li>
        <li>
            <label>
                <input type="checkbox" class="me-2" name="price[]" value="7000-8000" >
                <span class="text-small">₹7000 - ₹8000</span>
            </label>
        </li>
    </ul>
    <div class="text-end">
          <button type="submit" class="btn btn-dark">Apply Filters</button>
      </div>
</form>
          <form action="{{ route('product.shop') }}" method="GET" id="filter-form">
              <h6 class="text-black fw-bold fs-3 mt-20 mb-10">Brands</h6>
              <ul class="list-checkbox">
              @php
                  $selectedBrands = explode(',', request('brand', ''));
              @endphp
                  @foreach ($brands as $brand)
                      <li>
                          <label class="">
                              <input type="checkbox" class="brand-checkbox me-2" data-brand-slug="{{ $brand->slug }}"
                                    name="brands[]" value="{{ $brand->id }}"
                                    {{ in_array($brand->slug, $selectedBrands) ? 'checked' : '' }}>
                              <span class="text-small text-black">{{ $brand->name }}</span>
                          </label>
                          <span class="number-item">{{ $brand->products_count }}</span>
                      </li>
                  @endforeach
              </ul>
              <div class="text-end">
                  <button type="submit" class="btn btn-dark">Apply Filters</button>
              </div>
          </form>
          <h6 class="text-black fw-bold fs-3 mt-20 mb-10">Color</h6>
          <ul class="list-color">
              @foreach ($colors as $color)
                  <li>
                      <a class="color-{{ $color->name }} {{ request()->get('color') == $color->id ? 'active' : '' }}" 
                      onclick="event.preventDefault(); window.filterByColor('{{ $color->id }}')">
                      </a>
                      <span>{{ $color->name }}</span>
                  </li>
                  <style>
                      .color-{{ $color->name }} {
                          background-color: {{ $color->code }};
                          width: 30px; /* Adjust the width as needed */
                          height: 30px; /* Adjust the height as needed */
                          display: inline-block; /* Make it display as a block */
                          border-radius: 50%; /* Optional: Make it circular */
                          border: 2px solid #fff; /* Optional: Add a border for better visibility */
                      }
                  </style>
              @endforeach
          </ul>
        </div>
      </div>
      <div class="box-slider-item mb-30">
        <div class="head pb-15 border-brand-2">
          <h5 class="text-black fw-bold fs-3">Popular products</h5>
        </div>
        <div class="content-slider">
          <div class="box-swiper slide-shop">
            <div class="swiper-container swiper-best-seller">
              <div class="swiper-wrapper pt-5">
                @foreach($products->chunk(4) as $group)
          <div class="swiper-slide">
            @foreach($group as $product)
        <div class="card-grid-style-2 card-grid-none-border border-bottom mb-10">
        <div class="image-box"><a href="{{ route('product.show', $product['slug']) }}"><img
          src="{{ $product['image'] }}" alt="Ecom"></a>
        </div>
        <div class="info-right"><a class="text-black font-xs-bold"
          href="{{ route('product.show', $product['slug']) }}">{{ $product['name'] }}</a>
          <div class="price-info"><strong class="font-md-bold text-black price-main">₹
          {{ $product['unit_price'] }}</strong>
          @if(!empty($product['old_price']))
        <span class="text-black font-sm price-line">₹ {{ $product['old_price'] }}</span>
      @endif
          </div>
        </div>
        </div>
      @endforeach
          </div>
        @endforeach

              </div>
            </div>
            <div class="swiper-button-next swiper-button-next-style-2 swiper-button-next-bestseller"></div>
            <div class="swiper-button-prev swiper-button-prev-style-2 swiper-button-prev-bestseller"></div>
          </div>
        </div>
      </div>
      <div class="box-slider-item">
        <div class="head pb-15 border-brand-2">
          <h5 class="text-black fw-bold fs-3">Product Tags</h5>
        </div>
        <div class="content-slider mb-50">
          @foreach ($tags as $tag)
        <a class="btn btn-border text-black mr-5 border-black {{ request()->get('tag') === $tag->slug ? 'active' : '' }}" 
        href="{{ route('product.shop', array_merge(request()->query(), ['tag' => $tag->slug])) }}">{{ $tag->name }}</a>
      @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
  $(document).ready(function () {
    window.filterByColor = function(colorId) {
        const url = new URL(window.location.href);
        url.searchParams.set('color', colorId);
        window.location.href = url;  // Navigate to the updated URL
    }
    document.getElementById('filter-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    // Get all checked checkboxes
    const checkedBrands = Array.from(document.querySelectorAll('.brand-checkbox:checked'))
        .map(checkbox => checkbox.getAttribute('data-brand-slug'));

    // Construct the new URL with selected brand slugs
    const url = new URL(this.action);
    if (checkedBrands.length) {
        url.searchParams.set('brand', checkedBrands.join(','));
    } else {
        url.searchParams.delete('brand');
    }

    // Redirect to the new decoded URL for readability
    window.location.href = decodeURIComponent(url.toString());
});

    $('#grid-view').show();
    $('#list-view').hide();
    // Grid View button click event
    $('#grid-view-btn').click(function () {
      $('#grid-view').show(); // Show grid view
      $('#list-view').hide(); // Hide list view
      $(this).addClass('btn-primary');
      $('#list-view-btn').removeClass('btn-primary');
    });

    // List View button click event
    $('#list-view-btn').click(function () {
      $('#list-view').show(); // Show list view
      $('#grid-view').hide(); // Hide grid view
      $(this).addClass('btn-primary');
      $('#grid-view-btn').removeClass('btn-primary');
    });
   
    });
</script>
@endsection