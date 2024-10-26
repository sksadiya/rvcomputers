@extends('front.layouts.master')

@section('css')
<style>
  .swiper-pagination .swiper-pagination-bullet-active {
    background: #000;
  }
 
.container {
  max-width: 100%; /* Ensures container fits screen width */
}

 body, html {
  overflow-x: hidden;
} 
  @media (min-width: 766px) and (max-width: 1024px) {
    .banner-slide {
      min-height: 290px !important;
    }
  }

  @media (max-width: 500px) {
    .banner-slide {
      min-height: 150px !important;
    }

    .swiper-pagination-bullet {
      display: none !important;
    }
  }

  .swiper-pagination-bullet {
    background: grey;
  }

  .image-box img {
    transition: transform 0.3s ease;
    /* Smooth transition for zoom */
  }

  .image-box:hover img {
    transform: scale(1.1);
    /* Zoom in (scale up) the image on hover */
  }

  .card-grid-style-1,
  .card-category {
    transition: transform 0.3s ease;
    /* Smooth transition for zoom */
  }

  .card-grid-style-1:hover,
  .card-category:hover {
    transform: scale(1.05);
    /* Zoom in (scale up) the entire card on hover */
  }
</style>
@endsection
@section('content')
<section class="section-box d-block">
  <div class="banner-hero banner-home5 pt-0 pb-0">
    <div class="box-swiper">
      <div class="swiper-container swiper-group-1">
        <div class="swiper-wrapper">
          @foreach ($sliders as $slider)
        <div class="swiper-slide">
        <div class="banner-slide" style="background: url('{{ $slider->image }}'); ">
        </div>
        </div>
      @endforeach
        </div>
        <div class="swiper-pagination swiper-pagination-1"></div>
      </div>
    </div>
  </div>
</section>

<section class="section-box d-block border-0 m-0">
  <div class="container-fluid bg-primary p-3">
    <div class="text-center">
      <h4 class="text-white">SHOP BY CATEGORY</h4>
    </div>
  </div>
</section>

<section class="section-box d-block border-0 m-0 ">
  <div class="container p-lg-5 p-4">
    <div class="row justify-content-center align-items-center mb-3">
      @foreach ($categories as $category)
      <div class="col-lg-2 col-md-4 col-6">
      <a href="{{ route('product.shop', ['category' => $category->slug])}}">
        <div class="card card-category p-3 bg-white border-0">
        <div class="card-img image-box">
          <img src="{{ $category->logo }}" alt="{{ $category->name }}" class="img-fluid">
        </div>
        </div>
      </a>
      <h5 class="text-center m-2 fw-bold text-dark"><a class="text-black"
        href="{{ route('product.shop', ['category' => $category->slug])}}">{{ $category->name }}</a></h5>
      </div>
    @endforeach
    </div>
  </div>
</section>

<section class="section-box d-block border-0 m-0 bg-black">
  <div class="container-fluid p-3">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-4  col-12 p-3 justify-content-center align-items-center text-white">
        <h2 class="mb-3 fw-bold">Don't Wait , Shop Now</h2>
        <ul class="list-nav-arrow ms-2">
          <li class="fs-4"><i class="bx bxs-right-arrow me-2 "></i>Best Sellers</li>
          <li class="fs-4"><i class="bx bxs-right-arrow me-2"></i>New Arrivals</li>
        </ul>
      </div>
      <div class="col-lg-8 p-3 justify-content-center align-items-center ">
        <!-- <div class="container">
          <div class="head-main border-0">
            <div class="box-button-slider text-white">
              <div class="swiper-button-next swiper-button-next-group-2"></div>
              <div class="swiper-button-prev swiper-button-prev-group-2"></div>
            </div>
          </div>
        </div> -->
        <div class="container mt-10">
          <div class="box-swiper">
            <div class="swiper-container swiper-group-rv">
              <div class="swiper-wrapper pt-5">
                @foreach ($products as $product)
            <div class="swiper-slide">
              <a href="{{ route('product.show', $product->slug)}}">
              <div class="card-grid-style-1 bg-white p-4 card" style="border-radius: 20px;">
                <div class="image-box card-img-top"><img src="{{ $product->image }}" alt="Ecom"></div>
                <div class="mb-2">
                @if ($product->current_stock > 1)
          <span class="badge badge-soft-success">In Stock ({{ $product->current_stock }} Units)</span>
        @else
      <span class="badge badge-soft-danger">Out of Stock</span>
    @endif
                </div>
                <h4 class="text-dark fw-bold">{{ $product->name }}</h4>
              </a>
              <div class="mt-20"><span class="color-black-500  mr-30">₹ {{ $product->unit_price}}</span><span
                class="color-black-500"><span class="text-decoration-line-through">₹
                {{ $product->old_price }}</span></span>
              </div>
            </div>
            </a>
            </div>
          @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

</section>

<section class="section-box d-block border-0 m-0 ">
  <div class="container p-lg-5 p-4">
    <div class="row justify-content-center align-items-center mb-3">
      @foreach ($brands as $brand)
      <div class="col-lg-2 col-md-4 col-6">
      <a href="{{ route('product.shop', ['brand' => $brand->slug])}}">
        <div class="card card-category p-3 bg-white border-0">
        <div class="card-img image-box">
          <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" class="img-fluid">
        </div>
        </div>
      </a>
      </div>
    @endforeach
    </div>
  </div>
</section>

<section class="container-fluid d-flex align-items-center" style="background: url('{{ asset('assets/front/assets/imgs/RV-down-banners.png')}}') no-repeat center center; 
                background-size: cover; 
                background-attachment: fixed; 
                height: 70vh; /* Adjust height as per your design */
                min-height: 400px;"> <!-- Ensure it doesn't get too small -->
  <div class="row w-100 px-lg-5 px-3">
    <div class="col-md-6 mb-lg-5 mb-2 d-flex flex-column justify-content-center align-items-start">
      <h1 class="text-black fw-bold mb-5">Budget Buy</h1>
      <div class="bg-primary p-2 w-100 fw-bold fs-3 text-center text-white rounded-pill">Shop By Price</div>
    </div>

    <div class="col-md-6 mb-lg-5 mb-2 d-flex flex-column justify-content-center align-items-start">
      <h1 class="mb-5" style="color: transparent;">1</h1>
      <select class="form-select p-2 mt-2 fs-4 rounded-pill ms-2" aria-label="Default select example">
        <option class="text-muted px-2" selected>Select Price Range</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
    </div>
  </div>
</section>

<section class="section-box d-block border-0 m-0">
  <div class="container p-lg-5 p-4">
    <div class="row mb-3 text-center ">
      <h2 class="fw-bolder text-black fs-1 ">Reasons, You can’t Say No to RV</h2>
    </div>
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-2 col-md-4 col-6">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{  asset('assets/front/assets/imgs/scratchless.webp') }}" alt="Scratchless" class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">Scratchless</h5>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{  asset('assets/front/assets/imgs/lowest-price.webp') }}" alt="Lowest Price" class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">Lowest Price</h5>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{  asset('assets/front/assets/imgs/buyback.webp') }}" alt="Buy Back" class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">Lifetime Buyback</h5>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{  asset('assets/front/assets/imgs/bag.webp') }}" alt="Bag" class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">With 4 Accesories</h5>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6 p-3">
        <div class="card card-category p-3 bg-white border-0">
          <div class="card-img-top image-box d-flex justify-content-center align-items-center">
            <img src="{{  asset('assets/front/assets/imgs/1-Year-Warranty.webp') }}" alt="1 Year Warranty"
              class="img-fluid">
          </div>
          <h5 class="text-center m-2 fw-bold text-dark">1 Year Warranty</h5>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-box d-block border-0 m-0" style="background-color: #74228f;">
  <div class="container p-5">
    <div class="row">
      <div class="col text-center d-flex justify-content-center align-items-center fw-bolder fs-3 text-white">
        SAVE 50% OF Your Hard Earned Money Even Buying a New
      </div>
    </div>
  </div>
</section>

<section class="section-box d-block border-0 m-0">
  <div class="container p-5">
    <div class="row mb-5">
      <div class="col text-center d-flex justify-content-center align-items-center fw-bolder fs-1 text-black">
        Most Popular Products
      </div>
    </div>
    <div class="row justify-content-center align-items-center">
      @foreach ($products as $product)
      <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4">
      <a href="{{ route('product.show', $product->slug)}}">
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
          <span class="text-decoration-line-through">₹ {{ $product->old_price }}</span>
          </span>
        </div>
        </div>
      </a>
      </div>
    @endforeach
    </div>
  </div>
</section>

<section class="section-box d-block border-0 m-0">
  <div class="container p-5">
    <div class="row">
      <div class="col text-center d-flex justify-content-center align-items-center fw-bolder fs-3 text-black">
        The Insiders Story <br>
        11 Steps that Makes Our Products Epic!
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <img src="{{ asset('assets/front/assets/imgs/lower-rv-banner.png')}}" alt="">
    </div>
  </div>
</section>
@endsection
@section('script')
<script>
  var swiper = new Swiper('.swiper-group-rv', {
    slidesPerView: 3,  // Adjust how many slides you want to display at once
    spaceBetween: 30,  // Space between slides
    loop: true,        // Enables infinite looping
    navigation: {
      nextEl: '.swiper-button-next-group-2',  // Custom navigation buttons
      prevEl: '.swiper-button-prev-group-2',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    breakpoints: {
      // When the screen is >= 1024px (laptop)
      1024: {
        slidesPerView: 3,  // Show 3 slides on large screens (default)
      },
      // When the screen is >= 768px (tablet)
      768: {
        slidesPerView: 2,  // Show 2 slides on tablet
      },
      // When the screen is < 768px (mobile)
      0: {
        slidesPerView: 1,  // Show 1 slide on mobile
      },
    }
  });
</script>
@endsection