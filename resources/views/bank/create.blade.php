@extends('layouts.app')

@section('body')
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<h4 class="font-weight-bolder mb-0">Add/Edit Bank</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">

            <form enctype="multipart/form-data" @if (isset($bank)) method="post" action="{{ route('bank.update', $bank) }}" @else method="post" action="{{ route('bank.store') }}" @endif>
              @csrf
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                <label for="name">Bank Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Bank Name...." @if(isset($bank)) value="{{$bank->name}}" @endif required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                  <a class="btn btn-light float-right margin-right" onclick="window.location.href='{{ route('bank.index') }}'">Back</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>

@endsection
