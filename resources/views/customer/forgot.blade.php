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
          <h3 class="text-black fw-bold">Forgot Password</h3>
          <div class="card-body">
            <form method="POST" action="{{ route('customer.password.email') }}" id="send-forgot-link">
              @csrf
              <div class="form-register mt-30 mb-20">
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
              </div>
              <div class="form-group">
                <button type="submit" id="btn-save-reset-link" class="font-md-bold btn btn-buy">
                  <span class="spinner-border spinner-border-sm" id="btn-reset-link-spinner"
                    style="display: none;"></span>
                  <span id="btn-reset-link-text">Send Reset Link</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('script')
<script>
  $(document).ready(function () {
    $('#send-forgot-link').on('submit', function () {
      $('#btn-save-reset-link').prop('disabled', true);
      $('#btn-reset-link-spinner').show();
      $('#btn-reset-link-text').text('sending...');
    });
  });
</script>
@endsection