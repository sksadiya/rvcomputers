@extends('layout.master')

@section('title') Profile @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .img-div {
    max-height: 90px;
    border: 1px dashed #ddd;
    border-radius: 4px;
    padding: 10px;
}
.logo-display {
    max-height: 70px;
    display: inline-block;
}
</style>
@endsection
@section('content')
@include('layout.session')
<div class="row">
    <div class="col-xxl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Personal Information</h4>
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <tbody class="text-center">
                            <tr>
                                <div class="mt-4 mt-md-0 text-center">
                                    @if(Auth::user()->avatar)
                                    <img class="rounded-circle avatar-xl" alt="200x200"
                                        src="{{ Auth::user()->avatar }}"
                                        data-holder-rendered="true">
                                    @endif
                                </div>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile</th>
                                <td>{{ Auth::user()->contact }}</td>
                            </tr>
                            <tr>
                                <th scope="row">E-mail </th>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col-xxl-8">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Profile Settings</h4>
                <form action="{{ route('update.profile',Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <small class="text-danger">*</small></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ Auth::user()->name}}" placeholder="FUll Name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <small class="text-danger">*</small></label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ Auth::user()->email}}" placeholder="Email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact <small class="text-danger">*</small></label>
                                <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ Auth::user()->contact}}" placeholder="Contact">
                                @error('contact')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Profile Image</label>
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                                @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="mb-3">
                            <div class="img-div text-center btn-logo btn-select-logo" id="btn-select-logo" data-column="logo">
                                  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                                <span id="btn-select-icon" data-column="logo">
                                <img id="img-logo" src="{{ Auth::user()->avatar }}" title="Choose logo" class="logo-display mx-auto img-fluid">
                                </span>
                                <input type="hidden" name="avatar" id="logo" value="">
                                <button type="button" id="btn-remove-logo" data-column="logo" class="btn btn-sm btn-danger btn-rounded pull-right" title="Clear" style="display: none;"><i class="bx bx-trash-alt"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
                <hr class="mt-4">
                <form action="{{ route('updatePassword',Auth::user()->id)}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="currentPassword">Current Password <small class="text-danger">*</small></label>
                                <input class="form-control @error('current_password')  is-invalid @enderror"
                                    type="password" id="currentPassword" name="current_password" placeholder="Current Password">
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="newPassword">New Password <small class="text-danger">*</small></label>
                                <input class="form-control @error('password')  is-invalid @enderror" type="password"
                                    id="newPassword" name="password" placeholder="New Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="password_confirmation">Confirm Password <small class="text-danger">*</small></label>
                                <input class="form-control @error('password')  is-invalid @enderror" type="password"
                                    id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
@endsection