@extends('front.layouts.master')

@section('css')
<style>
  .btn-sidebar {
    border: 1px solid #000 !important;
    background-color: transparent !important;
    color: #000 !important;
  }
  .btn-sidebar:hover {
    background-color: #000 !important;
    color: #fff !important;
  }
  .btn-sidebar.active {
    background-color: #000 !important;
    color: #fff !important;
  }
  footer {
    overflow-x: hidden !important;
  }
</style>
@endsection
@section('content')
<section class="section-box shop-template mt-30 p-lg-5 p-2">
      <div class="container-fluid p-lg-5 p-2">
        <div class="row">
          <div class="col-lg-3 col-12 me-3 border-end border-black">
            @include('account.sidebar')
          </div>
          <div class="col-lg-8 col-12 p-3">
            <h4 class="fs-lg-3">Hello <span class="text__secondary">{{ $customer->email }}</span> (not <span class="text__secondary">{{ $customer->email }}</span>? <a href="{{ route('customer.logout')}}" class="text__secondary">Log out </a>)</h4>
          </div>
        </div>
      </div>
</section>
@endsection
@section('script')
@endsection