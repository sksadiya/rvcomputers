@extends('layout.master-without-nav')
@section('title')
Admin Login
@endsection
@section('css')
@endsection
@section('body')
    <body class="auth-body-bg">
@endsection
      @section('content')  
      @include('layout.session')
      <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary-subtle">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p> $companySettings['organization_name'] </p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div class="auth-logo">
                                    <a href="index.html" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ asset('assets/images/logo-light.svg') }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="index.html" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ asset('assets/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                <form action="{{ route('admin.processLogin') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Email</label>
                                                    <input type="text" class="form-control  @error('email') is-invalid @enderror" id="username" name="email" placeholder="Enter username">
                                                    @error('email')
                                                    <div class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                            </div>
                                                        @enderror
                                                </div>
                        
                                                <div class="mb-3">
                                                    
                                                    <label class="form-label">Password</label>
                                                    <div class="input-group auth-pass-inputgroup">
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" name="password" aria-label="Password" aria-describedby="password-addon">
                                                        @error('password')
                                                        <div class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                            </div>
                                                        @enderror
                                                        <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                    </div>
                                                </div>
                                                <div class="mt-3 d-grid">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                                </div>
                                            </form>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <div>
                                <p>© {{ date('Y') }}</span>  {!! $companySettings['copyright'] !!}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
@section('script')
      @endsection