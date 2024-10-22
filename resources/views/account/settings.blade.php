@extends('front.layouts.master')

@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

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

    #update-profile input,
    #update-profile .select2-container .select2-selection--single {
        height: 50px !important;
        display: flex;
        align-items: center;
    }
    #update-profile input[type="file"] {
    height: 50px !important; /* Apply your desired height */
    display: block; /* Ensure it's displayed as block for consistent alignment */
    padding: 0 10px; /* Add padding to make it look better */
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    cursor: pointer;
    line-height: 50px; /* Vertically center the text */
}

   
</style>
@endsection
@section('content')
@include('layout.session')
<section class="section-box shop-template mt-30 p-5">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-3 me-3 border-end border-black">
                @include('account.sidebar')
            </div>
            <div class="col-md-8 p-3">
                <form action="{{ route('update.settings')}}" id="update-profile" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="customer" value="{{ $customer->id }}">
                    <div class="container-fluid">
                        <div class="row mb-3 text-black">
                            <h3>Profile</h3>
                        </div>
                        <div class="row">
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Name <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ $customer->name }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Email <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-10">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ $customer->email }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Contact No.
                                </label>
                                <div class="col-sm-10">
                                    <input type="number" name="contact"
                                        class="form-control @error('contact') is-invalid @enderror"
                                        placeholder="Contact No." value="{{ $customer->contact }}">
                                    @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Password
                                </label>
                                <div class="col-sm-10">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <small class="text-danger">Leave blank if you don't want to change the
                                        password.</small>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Re Password
                                </label>
                                <div class="col-sm-10">
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Confirm Password">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">Avatar
                                </label>
                                <div class="col-sm-10">
                                    <input type="file" name="avatar"
                                        class="form-control @error('avatar') is-invalid @enderror"
                                        placeholder="Confirm Password">
                                    @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-sm-2 col-form-label">
                                </label>
                                <div class="col-md-2">
                                    <img src="{{ $customer->avatar }}" class="rounded float-right" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 text-center">
                            <button type="submit" id="btn-save" class="btn btn-dark">
                                <span class="spinner-border spinner-border-sm" id="btn-spinner"
                                    style="display: none;"></span>
                                <span id="btn-text">Save</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>

    $(document).ready(function () {
        $('#update-profile').on('submit', function () {
            $('#btn-save').prop('disabled', true);
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });
    });



</script>
@endsection