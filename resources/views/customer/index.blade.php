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
</style>
@endsection
@section('content')
<section class="section-box shop-template mt-30 p-5">
      <div class="container-fluid px-5">
        <div class="row">
          <div class="col-md-3 me-3 border-end border-black">
            @include('account.sidebar')
          </div>
          <div class="col-md-8 p-3">
            <h3 class="">Hello <span class="text__secondary">{{ $customer->email }}</span> (not <span class="text__secondary">{{ $customer->email }}</span>? <a href="{{ route('customer.logout')}}" class="text__secondary">Log out </a>)<h2>
          </div>
        </div>
      </div>
</section>
@endsection
@section('script')
@endsection