@extends('layout.master')

@section('title') Mail Settings  @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Mail Settings</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('mail.update')}}" class="form-horizontal" method="post" autocomplete="off">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <h4 class="card-title mb-4">Manage Mail Settings</h4>
                        </div>
                        <div class="col-sm-3 text-end">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mail Mailer <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('mail_mailer') is-invalid @enderror" id="mail_mailer" name="mail_mailer" value="{{ $settings['mail_mailer'] ?? '' }}" placeholder="smtp">
                            @error('mail_mailer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mail Host <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="mail_host" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" placeholder="smtp.yourmailprovider.com">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mail Port <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <input type="number" class="form-control" id="mail_port" name="mail_port" value="{{ $settings['mail_port'] ?? '' }}" placeholder="587">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mail Username <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="mail_username" name="mail_username" 
                        value="{{ old('mail_username', $settings['mail_username'] ?? '') }}" placeholder="your-email@example.com">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mail Password <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <input type="password" class="form-control" id="mail_password" name="mail_password" 
                        value="{{ old('mail_password', $settings['mail_password'] ?? '') }}" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mail Encryption</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="mail_encryption" name="mail_encryption" 
                        value="{{ old('mail_encryption', $settings['mail_encryption'] ?? '') }}" placeholder="tls">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mail From Address <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <input type="email" class="form-control" id="mail_from_address" name="mail_from_address" 
                   value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}" placeholder="your-email@example.com">
                    </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mail From Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="mail_from_name" name="mail_from_name" 
                   value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}" placeholder="Laravel">
                    </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-10">
                            <button type="submit" id="btn-save" class="btn btn-primary">Save</button>
                        </div>
                    </div> 
                </div>
            </div>
        </form>
    </div>
</div>

@include('layout.session')

@endsection
@section('script')

@endsection