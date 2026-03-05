@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Payment</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              
            <form enctype="multipart/form-data"
                @if (isset($payment))
                    method="post" action="{{ route('payment.update',$payment) }}"
                @else
                    method="post" action="{{ route('payment.store') }}"
                @endif>

              @csrf
              @if(isset($payment))
                  @method('PUT')
              @endif

              <div class="row g-4">

                  <div class="col-md-6">
                      <label class="form-label">Month</label>
                      <input type="month"
                            class="form-control"
                            name="month_year"
                            value="{{ $payment->month_year ?? '' }}"
                            autocomplete="off">
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">Title</label>
                      <input type="text"
                            class="form-control"
                            name="title"
                            value="{{ $payment->title ?? '' }}"
                            autocomplete="off">
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">Description</label>
                      <textarea class="form-control"
                                name="description"
                                rows="5"
                                autocomplete="off">{{ $payment->description ?? '' }}</textarea>
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">Amount</label>
                      <input type="number"
                            class="form-control"
                            name="amount"
                            step="0.01"
                            value="{{ $payment->amount ?? '' }}"
                            autocomplete="off">
                  </div>

              </div>

              <!-- Buttons -->
              <div class="mt-4 text-end">
                  <a href="{{ route('payment.index') }}"
                    class="btn btn-light me-2">
                      Back
                  </a>

                  <button type="submit"
                          class="btn btn-success">
                      Submit
                  </button>
              </div>

          </form>
            </div>
          </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection