@extends('layout.master')

@section('title') View  @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">View</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
      
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">View</h4>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Name </label>
                        <div class="col-sm-10">
                            <input type="text" name="link" readonly value="{{ $review->name}}" class="form-control" placeholder="Link" >
                        </div>
                    </div>   
                    <div class="form-group row mb-3">
                          <label class="col-sm-2 col-form-label">Email </label>
                          <div class="col-sm-10">
                              <input type="text" name="link" readonly value="{{ $review->email }}" class="form-control" placeholder="Link" >
                          </div>
                    </div>
                    <div class="form-group row mb-3">
                          <label class="col-sm-2 col-form-label">Product </label>
                          <div class="col-sm-10">
                              <input type="text" name="link" readonly value="{{ $review->product->name }}" class="form-control" placeholder="Link" >
                          </div>
                    </div>
                    <div class="form-group row mb-3">
                      <label class="col-sm-2 col-form-label">Comment </label>
                          <div class="col-sm-10">
                              <textarea  readonly value="{{ $review->comment }}" class="form-control" >
                                </textarea>
                          </div>
                      </div>
                    <div class="row">
                      <div class="col-sm-2"></div>
                      <div class="col-sm-2">
                        {!! $review->status == 1 
                          ? '<span class="badge rounded-pill badge-soft-primary font-size-12">Approved</span>' 
                          : '<span class="badge rounded-pill badge-soft-danger font-size-12">Disapproved</span>' !!}
                      </div>
                   </div>
            </div>
    </div>
</div>
@include('layout.session')
@endsection
