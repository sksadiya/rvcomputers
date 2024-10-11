@extends('layout.master')

@section('title') Create  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Edit Attribute Value</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('attributeValue.update' ,$val->id )}}" id="form-edit-value" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-sm-6">
                        <h4 class="card-title mb-4">Edit Attribute Value</h4>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('attributeValue.index', $val->attribute->id) }}" class="btn btn-success">Back</a>
                    </div>
                </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="name"  value="{{ $val->attribute->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" disabled>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Value <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="value"  value="{{ $val->value }}" class="form-control @error('value') is-invalid @enderror" placeholder="value" >
                            @error('value')
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
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#form-edit-value').on('submit', function() {
            // Disable the submit button
            $('#btn-save').prop('disabled', true);
            
            // Show spinner and change button text
            $('#btn-spinner').show();
            $('#btn-text').text('Saving...');
        });
    });
</script>
@endsection