@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-3">
        <a class="text-muted fw-light" href="{{route('account_month.index')}}">Account Month /</a> 
         Create
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">Add Account Month</h5>
            <div class="card-body">
                <form enctype="multipart/form-data" method="post" action="{{ route('account_month.store') }}">
              @csrf
              <div class="form-group row mt-3">
                <div class="col-sm-6 margin_top">
                <label for="month">Account Month</label>
                <input type="month" class="form-control" id="month" name="month" >
                </div>
              </div>
              <div class="form-group row mt-3">
                <div class="col-sm-6">
                <label for="month">Duplicate From</label>
                  <select name="duplicate_from" class="form-control">
                    <option value=""></option>
                    @foreach($account_month as $a)
                    <option value="{{$a->id}}">{{$a->month}}/{{$a->year}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row mt-4">
                  <div class="col-sm-12 text-end">
                      <a class="btn btn-light me-2"
                        onclick="window.location.href='{{ route('account_month.index') }}'">
                        Back
                      </a>
                      <button type="submit" class="btn btn-success">
                          Submit
                      </button>
                  </div>
              </div>
            </form>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@section('scripts')
@endsection
