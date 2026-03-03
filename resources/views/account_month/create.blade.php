@extends('layouts.app')

@section('body')
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<h4 class="font-weight-bolder mb-0">Add Account Month</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
              
            <form enctype="multipart/form-data" method="post" action="{{ route('account_month.store') }}">
              @csrf
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                <label for="month">Account Month</label>
                <input type="month" class="form-control" id="month" name="month" >
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                <label for="month">Duplicate From</label>
                  <select name="duplicate_from" class="form-control">
                    <option value=""></option>
                    @foreach($account_month as $a)
                    <option value="{{$a->id}}">{{$a->month}}/{{$a->year}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                  <a class="btn btn-light float-right margin-right" onclick="window.location.href='{{ route('account_month.index') }}'">Back</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>

@endsection