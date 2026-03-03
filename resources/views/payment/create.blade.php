@extends('layouts.app')

@section('body')
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<h4 class="font-weight-bolder mb-0">Add/Edit Payment</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
              
            <form enctype="multipart/form-data" @if (isset($payment)) method="post" action="{{ route('payment.update',$payment) }}" @else method="post" action="{{ route('payment.store') }}" @endif>
              @csrf
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                <label for="name">Month</label>
                <input type="month" class="form-control" id="month_year" name="month_year"  @if(isset($payment)) value="{{$payment->month_year}}" @endif autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Title</label>
                <input type="text" class="form-control" id="title" name="title"  @if(isset($payment)) value="{{$payment->title}}" @endif autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Description</label>
                <textarea class="form-control" id="description" name="description"  autocomplete="off" rows="5">{{$payment->description??''}}</textarea>
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount"  step="0.01"  @if(isset($payment)) value="{{$payment->amount}}" @endif autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                  <a class="btn btn-light float-right margin-right" onclick="window.location.href='{{ route('payment.index') }}'">Back</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>

@endsection