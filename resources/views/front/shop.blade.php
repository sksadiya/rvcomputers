@extends('front.layouts.master')
@section('css')
<style>

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
            <div class="col-xl-2 col-lg-3 mb-10 text-lg-start text-center">
              <a class="btn btn-filter font-sm text-black font-medium" href="#ModalFiltersForm" data-bs-toggle="modal"
                style="background: none;"><i class="bx bx-slider-alt fs-3 me-2 align-middle"></i>All Fillters</a>
            </div>
            <div class="col-xl-10 col-lg-9 mb-10 text-lg-end text-center">
              <div class="d-inline-block"><span class="font-sm text-black font-medium">Sort by:</span>
                <div class="dropdown dropdown-sort border-1-right">
                  <button class="btn dropdown-toggle font-sm color-gray-900 font-medium" id="dropdownSort" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">Latest products</button>
                  <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdownSort" style="margin: 0px;">
                    <li><a class="dropdown-item active" href="#">Latest products</a></li>
                    <li><a class="dropdown-item" href="#">Oldest products</a></li>
                    <li><a class="dropdown-item" href="#">Comments products</a></li>
                  </ul>
                </div>
              </div>
              <div class="d-inline-block"><span class="font-sm text-black font-medium">Show</span>
                <div class="dropdown dropdown-sort border-1-right">
                  <button class="btn dropdown-toggle font-sm color-gray-900 font-medium" id="dropdownSort2"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"><span>30
                      items</span></button>
                  <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdownSort2">
                    <li><a class="dropdown-item active" href="#">30 items</a></li>
                    <li><a class="dropdown-item" href="#">50 items</a></li>
                    <li><a class="dropdown-item" href="#">100 items</a></li>
                  </ul>
                </div>
              </div>
              <div class="d-inline-block">
                <button id="grid-view-btn" class="border-0 view-type-grid mr-5 p-2 "
                  style="background: none !important;"><i
                    class="bx bx-grid-alt fs-3 text-black align-middle"></i></button>
                <button id="list-view-btn" class="border-0 view-type-grid mr-5 p-2 "
                  style="background: none !important;"><i
                    class="bx bx-list-ul fs-2 text-black align-middle"></i></button>
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
            <a class="btn btn-wishlist border-black p-1 btn-tooltip mb-10" href=""
            aria-label="Add To Cart" style="background: none; border :1px solid #000 !important;">
            <i class="fas fa-shopping-cart text-black"></i>
            </a>
            <a class="btn btn-quickview border-black p-1 btn-tooltip" aria-label="Quick view"
            href="#ModalQuickview" data-bs-toggle="modal"
            style="background: none; border :1px solid #000 !important;">
            <i class="fas fa-eye text-black"></i>
            </a>
          </div>
          <div class="image-box">
            <a href="{{ route('product.show' ,$product->slug)}}">
            <img src="{{ $product->image }}" alt="Ecom">
            </a>
          </div>
          <div class="info-right">
            <a class="font-xs text-black" href="">{{ $product->brand->name }}</a><br>
            <a class="text-black font-sm-bold" href="{{ route('product.show' ,$product->slug)}}">{{ $product->name }}</a>
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

        <!-- List View -->
        <div id="list-view" class="row p-lg-3" style="display: none;">
          @foreach ($shopProducts as $product)
        <div class="col-lg-12">
        <div class="card-grid-style-3">
          <div class="card-grid-inner d-inline-flex w-100">
          <div class="tools">
            <a class="btn btn-wishlist border-black p-1 btn-tooltip mb-10" href=""
            aria-label="Add To Cart" style="background: none; border :1px solid #000 !important;">
            <i class="fas fa-shopping-cart text-black"></i>
            </a>
            <a class="btn btn-quickview border-black p-1 btn-tooltip" aria-label="Quick view"
            href="#ModalQuickview" data-bs-toggle="modal"
            style="background: none; border :1px solid #000 !important;">
            <i class="fas fa-eye text-black"></i>
            </a>
          </div>
          <div class="image-box w-25">
            <a href="{{ route('product.show' ,$product->slug)}}">
            <img src="{{ $product->image }}" alt="Ecom">
            </a>
          </div>
          <div class="info-right">
            <a class="font-xs text-black" href="shop-vendor-single.html">{{ $product->brand->name }}</a><br>
            <a class="text-black font-sm-bold" href="{{ route('product.show' ,$product->slug)}}">{{ $product->name }}</a>
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
          <li><a class="text-black" href="#"><i class="bx bx-chevron-right me-2"></i>{{ $category->name }}<span
            class="number text-black">{{ $category->products->count() }}</span></a></li>
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
            <div class="box-slider-range mt-20 mb-15">
              <div class="row mb-20">
                <div class="col-sm-12">
                  <div id="slider-range"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <label class="lb-slider font-sm color-gray-500">Price Range:</label><span
                    class="min-value-money font-sm color-gray-1000"></span>
                  <label class="lb-slider font-sm font-medium color-gray-1000"></label>-
                  <span class="max-value-money font-sm font-medium color-gray-1000"></span>
                </div>
                <div class="col-lg-12">
                  <input class="form-control min-value" type="hidden" name="min-value" value="">
                  <input class="form-control max-value" type="hidden" name="max-value" value="">
                </div>
              </div>
            </div>
            <ul class="list-checkbox">
              <li>
                <label class="">
                  <input type="checkbox" class="me-2"><span class="text-small">$600 - $800</span>
                </label><span class="number-item">65</span>
              </li>
            </ul>
            <h6 class="text-black fw-bold fs-3 mt-20 mb-10">Brands</h6>
            <ul class="list-checkbox">
              @foreach ($brands as $brand)
          <li>
          <label class="">
            <input type="checkbox" class=" me-2"><span class="text-small text-black">{{ $brand->name }}</span>
          </label><span class="number-item">{{ $brand->products_count }}</span>
          </li>
        @endforeach
            </ul>
            <h6 class="text-black fw-bold fs-3 mt-20 mb-10">Color</h6>
            <ul class="list-color">
              @foreach ($colors as $color)
          <li><a class="color-{{ $color->name }}" href="#"></a><span>{{ $color->name }}</span></li>
          <style>
          .color-{{ $color->name }} {
            background-color:
            {{ $color->code }}
            ;
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
        <a class="btn btn-border text-black mr-5 border-black" href="#">{{ $tag->name }}</a>
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
      // Initially show the grid view and hide the list view
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