<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#0E0E0E">
    <meta name="template-color" content="#0E0E0E">
    <meta name="description" content="Index page">
    <meta name="keywords" content="index, page">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front/assets/imgs/template/favicon.svg') }}">
    <link href="{{ asset('assets/front/assets/css/style.css?v=3.0.0') }}" rel="stylesheet">
    <title>Home 5 - Ecom Marketplace Template</title>
    <meta name="_token" content="{{ csrf_token() }}">
    @include('front.layouts.head-css')
  </head>
  <body>
    <!-- <div id="preloader-active">
      <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
          <div class="text-center"><img class="mb-10" src="assets/imgs/template/favicon.svg" alt="Ecom">
            <div class="preloader-dots"></div>
          </div>
        </div>
      </div>
    </div> -->
    @include('front.layouts.header')
    <main class="main">
    <div class="container-fluid p-0">
      @yield('content')
    </div>
    </main>
    @include('front.layouts.footer')
    @include('front.layouts.vendor-scripts')
    </body>

</html>