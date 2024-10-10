@extends('layout.master')

@section('title') Edit  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">Edit Tax</h4>
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('tax.update' ,$tax->id)}}" id="form-edit-tax" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Tax Group</h4>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tax Group <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="group" value="{{ $tax->group }}" class="form-control @error('group') is-invalid @enderror" placeholder="Tax Group" >
                            @error('group')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tax Name <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{ $tax->name }}" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Tax Name" >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>  
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Tax <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control @error('value') is-invalid @enderror" name="value" id="value" value="{{ $tax->value }}" placeholder="Tax" min="0" step="0.01" >
                            @error('value')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>  
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Status <small class="text-danger">*</small></label>
                        <div class="col-sm-10">
                        <select name="status" id="tax-status" class="form-select" style="width: 100%;" >
                            <option {{ $tax->status == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $tax->status == 0 ? 'selected' : '' }} value="0">In-Active</option>
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
            </div>
        </form>
    </div>
</div>

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('#tax-status').select2();

    $('#form-edit-tax').on('submit', function () {
        $('#btn-save').prop('disabled', true);

        $('#btn-spinner').show();
        $('#btn-text').text('Saving...');
    });
});
</script>
@endsection