@extends('layout.master')

@section('title') Create  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
<style>
        .sp-add-on {
            width: 36.125px;
            border-radius: 4px !important;
            border: 0.8px solid rgb(206, 212, 218) !important;
        }
</style>
@endsection
@section('content')
<div class="container-fluid">
              

<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('color.store')}}" id="form-add-color"  class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add New Color</h4>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" >
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Color <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control colorpicker spectrum with-add-on @error('code') is-invalid @enderror" name="code" id="code" placeholder="Color Code">
                            @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>  
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Status <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <select name="status" id="color-status" class="form-select" style="width: 100%;" required="required"  tabindex="-1" aria-hidden="true">
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
@include('layout.session')
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#color-status').select2();
        $(".colorpicker").spectrum();
        $('#form-add-color').on('submit', function() {
            // Disable the submit button
            $('#btn-save').prop('disabled', true);
            
            // Show spinner and change button text
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });
    });
</script>
@endsection