@extends('front.layouts.master')
@section('css')
<style>
  .btn.btn-buy {
    background-color: #000;
    border: 1px solid #000;
  }

  .btn.btn-buy:hover {
    color: #000;
    border: 1px solid #000;
  }
</style>
@endsection
@section('content')
<section>
  <div class="container p-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-3">
          <h3 class="text-black fw-bold">Reset Password</h3>
          <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}" id="set-password-link">
              @csrf
              <div class="form-register mt-30 mb-20">
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                  <label class="mb-2 font-sm text-black">Email*</label>
                  <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email"
                    placeholder="stevenjob@gmail.com" required>
                  @error('email')
            <span class="invalid-feedback" role="alert">
            {{ $message }}
            </span>
          @enderror
                </div>
                <div class="form-group">
                  <label class="mb-2 font-sm text-black">Password *</label>
                  <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                    id="password" placeholder="******************" required>
                  @error('password')
            <span class="invalid-feedback" role="alert">
            {{ $message }}
            </span>
          @enderror
                </div>
                <div class="form-group">
                  <label class="mb-2 font-sm text-black">Re-Password *</label>
                  <input class="form-control @error('password') is-invalid @enderror" type="password"
                    name="password_confirmation" id="password_confirmation" placeholder="******************" required>
                  @error('password')
            <span class="invalid-feedback" role="alert">
            {{ $message }}
            </span>
          @enderror
                </div>
              </div>
              <div class="form-group">
                <button type="submit" id="btn-save" class="font-md-bold btn btn-buy">
                  <span class="spinner-border spinner-border-sm" id="btn-spinner" style="display: none;"></span>
                  <span id="btn-text">Update Password</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@include('layout.session')
@endsection
@section('script')
<script>
  $(document).ready(function () {
    $('#set-password-link').on('submit', function () {
      $('#btn-save').prop('disabled', true);
      $('#btn-spinner').show();
      $('#btn-text').text('updating...');
    });
  });
</script>
@endsection