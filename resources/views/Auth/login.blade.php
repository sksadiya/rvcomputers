@extends('front.layouts.master')
@section('css')
<style>
.btn.btn-buy {
    background-color: #000;
    border: 1px solid #000;
}
.btn.btn-buy:hover {
    color : #000;
    border: 1px solid #000;
}
</style>
@endsection
@section('content')
@include('layout.session')
<section class="section-box shop-template mt-60">
        <div class="container">
          <div class="row mb-100 justify-content-center align-items-center">
            <div class="col-lg-6">
            <section class="section-box shop-template mt-60">
                <div class="container">
                <div class="row mb-100">
                    <h3>Customer Login</h3>
                    <p class="font-md text-black">Welcome back!</p>
                    <form action="{{ route('customer.processLogin') }}" method="POST" id="login-customer">
                          @csrf
                        <div class="form-register mt-30 mb-20">
                            <div class="form-group">
                            <label class="mb-2 font-sm text-black">Email*</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" placeholder="stevenjob@gmail.com" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                            </div>
                            <div class="form-group">
                            <label class="mb-2 font-sm text-black">Password *</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="******************" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                            </div>
                            <div class="row">
                            <div class="col-lg-6">
                                
                            </div>
                            <div class="col-lg-6 text-end">
                                <div class="form-group"><a class="font-xs color-gray-500" href="{{ route('customer.password.request')}}">Forgot your password?</a></div>
                            </div>
                            </div>
                            <div class="form-group">
                            <button type="submit" id="btn-save-login" class="font-md-bold btn btn-buy">
                            <span class="spinner-border spinner-border-sm" id="btn-login-spinner" style="display: none;"></span>
                            <span id="btn-login-text">Login</span>
                            </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </section>
            </div>
          </div>
        </div>
      </section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#login-customer').on('submit', function() {
            $('#btn-save-login').prop('disabled', true);
            $('#btn-login-spinner').show();
            $('#btn-login-text').text('login...');
        });
    });
</script>
@endsection