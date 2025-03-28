@extends('layouts.app')

@section('body')
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<h4 class="font-weight-bolder mb-0">Add/Edit Bank Account</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">

            <form enctype="multipart/form-data" @if (isset($bankAccount)) method="post" action="{{ route('bank_account.update', $bankAccount) }}" @else method="post" action="{{ route('bank_account.store') }}" @endif>
              @csrf
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                    <label for="bank_id">Bank</label>
                    <select name="bank_id" class="form-control" required>
                        <option value="">-- Select Bank --</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}" {{ isset($bankAccount) && $bankAccount->bank_id == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 margin_top">
                    <label for="account_name">Account Name</label>
                    <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name...." @if(isset($bankAccount)) value="{{ $bankAccount->account_name }}" @endif required autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                    <label for="account_no">Account Number</label>
                    <input type="number" class="form-control" id="account_no" name="account_no" placeholder="Account Number...." @if(isset($bankAccount)) value="{{ $bankAccount->account_no }}" @endif required autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                    <label for="capital">Capital</label>
                    <input type="number" class="form-control" id="capital" name="capital" placeholder="Capital...." @if(isset($bankAccount)) value="{{ $bankAccount->capital }}" readonly @endif required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                  <a class="btn btn-light float-right margin-right" onclick="window.location.href='{{ route('bank_account.index') }}'">Back</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>

@endsection
