@extends('layout.master')

@section('title') Company Settings  @endsection
@section('css')
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
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Manage Company Details</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('company.update')}}" id="form-update-company" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Manage Company</h4>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Logo <small class="text-danger">*</small></label>
                        <div class="col-sm-2">
                            <div class="img-div text-center btn-logo btn-select-logo" id="btn-select-logo" data-column="logo">
                                  <span class="text-blue cursor-pointer img-logo" style="display: none;">Choose logo</span>
                                <span id="btn-select-icon" data-column="logo">
                                <img id="img-logo" src="{{$settings['company_logo'] }}" title="Choose logo" class="logo-display mx-auto img-fluid">
                                </span>
                                <input type="hidden" name="company_logo" id="logo" value="{{$settings['company_logo'] }}">
                                <button type="button" id="btn-remove-logo" data-column="logo" class="btn btn-sm btn-danger btn-rounded pull-right" title="Clear" style="display: none;"><i class="bx bx-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Fevicon <small class="text-danger">*</small></label>
                        <div class="col-sm-2">
                            <div class="img-div text-center btn-logo btn-select-banner" id="btn-select-banner" data-column="banner">  
                                <span class="text-blue cursor-pointer img-banner" style="display: none;">Choose logo</span>
                                <span id="btn-select-icon" data-column="banner">
                                <img id="img-banner" src="{{ $settings['app_fevicon'] }}" title="Choose logo" class="logo-display mx-auto img-fluid">
                                </span>
                                <input type="hidden" name="app_fevicon" id="banner" value="{{$settings['app_fevicon'] }}">
                                <button type="button" id="btn-remove-banner" data-column="banner" class="btn btn-sm btn-danger btn-rounded pull-right" title="Clear" style="display: none;"><i class="bx bx-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="Company Name" value="{{ $settings['company_name']}}" >
                            @error('company_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Organization Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="organization_name" class="form-control @error('organization_name') is-invalid @enderror" placeholder="Organization Name" value="{{ $settings['organization_name']}}" >
                            @error('organization_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Organization Address <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <textarea name="organization_address" class="form-control @error('organization_address') is-invalid @enderror" placeholder="Address">{{ $settings['organization_address']}}</textarea>
                            @error('organization_address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Mobile No. <small class="text-danger">*</small></label>
                        <div class="col-sm-4">
                            <input type="text" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" placeholder="Mobile No." maxlength="13" value="{{ $settings['mobile_number']}}">
                            @error('mobile_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <label class="col-sm-2 col-form-label">Phone No. <small class="text-danger">*</small></label>
                        <div class="col-sm-4">
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Mobile No." maxlength="13" value="{{ $settings['phone_number']}}">
                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Email <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="email" name="company_email" class="form-control @error('company_email') is-invalid @enderror" placeholder="demo@example.com" value="{{ $settings['company_email']}}">
                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>      
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="text" name="website"  class="form-control @error('website') is-invalid @enderror" placeholder="Website" value="{{ $settings['website']}}">
                            @error('website')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div> 
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Google Map</label>
                        <div class="col-sm-10">
                            <input type="text" name="google_map"  class="form-control @error('google_map') is-invalid @enderror" placeholder="Google Map" value="{{ $settings['google_map']}}">
                            @error('google_map')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div> 
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Copyright</label>
                        <div class="col-sm-10">
                            <input type="text" name="copyright"  class="form-control @error('copyright') is-invalid @enderror" placeholder="copyright" value="{{ $settings['copyright']}}">
                            @error('copyright')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div> 
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Facebook</label>
                        <div class="col-sm-4">
                            <input type="text" name="facebook_url" value="{{ $settings['facebook_url']}}" class="form-control  @error('facebook_url') is-invalid @enderror" placeholder="Facebook URL">
                            @error('facebook_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <label class="col-sm-2 col-form-label">Twitter</label>
                        <div class="col-sm-4">
                            <input type="text" name="twitter_url" value="{{ $settings['twitter_url']}}" class="form-control  @error('twitter_url') is-invalid @enderror" placeholder="Twitter URL">
                            @error('twitter_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">LinkedIn</label>
                        <div class="col-sm-4">
                            <input type="text" name="linkedin_url" value="{{ $settings['linkedin_url']}}" class="form-control @error('linkedin_url') is-invalid @enderror" placeholder="LinkedIn URL">
                            @error('linkedin_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <label class="col-sm-2 col-form-label">Instagram</label>
                        <div class="col-sm-4">
                            <input type="text" name="instagram_url" value="{{ $settings['instagram_url']}}" class="form-control @error('instagram_url') is-invalid @enderror" placeholder="Instagram URL">
                            @error('instagram_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>       
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">YouTube</label>
                        <div class="col-sm-4">
                            <input type="text" name="youtube_url" value="{{ $settings['youtube_url']}}" class="form-control  @error('youtube_url') is-invalid @enderror" placeholder="YouTube URL">
                            @error('youtube_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>  
                </div>
                <div class="card-footer">
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-10">
                        <button type="submit" id="btn-save" class="btn btn-primary">
                            <span class="spinner-border spinner-border-sm" id="btn-spinner" style="display: none;"></span>
                            <span id="btn-text">Save</span>
                        </button>
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
<script>
     $(document).ready(function() {
        $('#form-update-company').on('submit', function() {
            // Disable the submit button
            $('#btn-save').prop('disabled', true);
            
            // Show spinner and change button text
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });
    });
</script>
@endsection