@extends('layouts.app')

@section('body')
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<h4 class="font-weight-bolder mb-0">Add/Edit Food Type</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
              
            <form enctype="multipart/form-data" @if (isset($food_type)) method="post" action="{{ route('food_type.update',$food_type) }}" @else method="post" action="{{ route('food_type.store') }}" @endif>
              @csrf
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                <label for="name">Food Type Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Food Type Name...." @if(isset($food_type)) value="{{$food_type->name}}" @endif required autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Food Type Price</label>
                <input type="number" min="0" step="0.01" class="form-control" id="price" name="price" placeholder="Food Type Name...." @if(isset($food_type)) value="{{$food_type->price}}" @endif required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                  <a class="btn btn-light float-right margin-right" onclick="window.location.href='{{ route('food_type.index') }}'">Back</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>

@endsection