@extends('layout.master')

@section('title') Edit  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">Edit City</h4>
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('city.update' ,$city->id )}}" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit City</h4> 
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">State <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <select name="state_id" id="state_id" class="form-select" style="width: 100%;" required="required" >
                            <option value="">Select State</option>
                           @foreach ($states as $state)
                           <option {{($city->state_id == $state->id ? 'selected' : '')}} value="{{ $state->id}}">{{ $state->name }}</option>
                           @endforeach
                        </select>
                        </div>
                    </div> 
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{ $city->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" >
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
                        <select name="status" id="city_status" class="form-select" style="width: 100%;" required="required">
                            <option {{($city->status == 1 ? 'selected' : '')}} value="1">Active</option>
                            <option {{($city->status == 0 ? 'selected' : '')}}  value="0">In-Active</option>
                        </select>
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

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('#state_id').select2();
    $('#city_status').select2();
});
</script>
@endsection