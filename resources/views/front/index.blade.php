@extends('front.layouts.master')

@section('css')
<style>
  .swiper-pagination .swiper-pagination-bullet-active {
    background: #000;
  }

  .swiper-pagination-bullet {
    background: grey;
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
        <div class="banner-slide" style="background: url('{{ $slider->image }}') no-repeat top center;">
          <!-- <div class="banner-desc">
        <label class="lbl-newarrival">Slide {{ $loop->index + 1 }}</label> 
        <h1 class="color-gray-1000 mb-10">{{ $slider->title }}</h1>
        <a class="btn btn-gray-1000 btn-shop-now">Shop Now</a>
        </div> -->
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
  <div class="container p-5">
    <div class="row justify-content-center align-items-center mb-3">
      @foreach ($categories as $category)
      <div class="col-md-2">
      <div class="card p-4 bg-white border-0">
        <div class="card-img">
        <img src="{{ $category->logo }}" alt="{{ $category->name }}">
        </div>
      </div>
      <h5 class="text-center m-3 fw-bold text-dark">{{ $category->name }}</h5>
      </div>
    @endforeach

    </div>
  </div>
</section>
<section class="section-box d-block border-0 m-0 bg-dark">
  <div class="container-fluid p-3">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-3 p-3 justify-content-center align-items-center text-white">
        <h3 class="mb-3">Don't Wait , Shop Now</h3>
        <ul class="list-nav-arrow ms-2">
          <li><i class="bx bxs-right-arrow me-2"></i>Best Sellers</li>
          <li><i class="bx bxs-right-arrow me-2"></i>New Arrivals</li>
        </ul>
      </div>
      <div class="col-md-8 p-3 justify-content-center align-items-center ">
        <div class="container">
          <div class="head-main border-0">
            <div class="box-button-slider text-white">
              <div class="swiper-button-next swiper-button-next-group-2"></div>
              <div class="swiper-button-prev swiper-button-prev-group-2"></div>
            </div>
          </div>
        </div>
        <div class="container mt-10">
          <div class="box-swiper">
            <div class="swiper-container swiper-group-rv">
              <div class="swiper-wrapper pt-5">
                @foreach ($products as $product)
                <div class="swiper-slide">
                  <div class="card-grid-style-1 bg-white p-4 card rounded">
                    <div class="image-box"><img src="{{ $product->image }}" alt="Ecom"></div>
                    <div class="mb-2">
                    <span class="badge badge-soft-success">In Stock</span>
                    </div>
                    <h5 class="text-dark">{{ $product->name }}</h5></a>
                    <div class="mt-20"><span class="color-gray-500 font-xs mr-30">September 02, 2022</span><span
                        class="color-gray-500 font-xs">4<span> Mins read</span></span></div>
                  </div>
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
  });
</script>
@endsection