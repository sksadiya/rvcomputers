@extends('layout.master')

@section('title') Create  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">Add New State</h4>
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('state.store' )}}" method="post" id="form-add-state" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add New State</h4> 
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Country <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <select name="country_id" id="country_id" class="form-select" style="width: 100%;" required="required" >
                            <option value="">Select Country</option>
                           @foreach ($countries as $country)
                           <option value="{{ $country->id}}">{{ $country->name }}</option>
                           @endforeach
                        </select>
                        </div>
                    </div> 
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Status <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <select name="status" id="state_status" class="form-select" style="width: 100%;" required="required">
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
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

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('#country_id').select2();
    $('#state_status').select2();

    $('#form-add-state').on('submit', function () {
         // Disable the submit button
         $('#btn-save').prop('disabled', true);
            
            // Show spinner and change button text
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
    });
});
</script>
@endsection