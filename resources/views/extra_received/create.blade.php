@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Extra Received</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              
            <form enctype="multipart/form-data"
                @if (isset($extra_received))
                    method="post" action="{{ route('extra_received.update',$extra_received) }}"
                @else
                    method="post" action="{{ route('extra_received.store') }}"
                @endif>

              @csrf
              @if(isset($extra_received))
                  @method('PUT')
              @endif

              <div class="row g-4">

                  <div class="col-md-6">
                      <label class="form-label">Month</label>
                      <input type="month"
                            class="form-control"
                            name="month_year"
                            value="{{ $extra_received->month_year ?? '' }}"
                            autocomplete="off">
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">Title</label>
                      <input type="text"
                            class="form-control"
                            name="title"
                            value="{{ $extra_received->title ?? '' }}"
                            autocomplete="off">
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">Description</label>
                      <textarea class="form-control"
                                name="description"
                                rows="5"
                                autocomplete="off">{{ $extra_received->description ?? '' }}</textarea>
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">Amount</label>
                      <input type="number"
                            class="form-control"
                            name="amount"
                            step="0.01"
                            value="{{ $extra_received->amount ?? '' }}"
                            autocomplete="off">
                  </div>

              </div>

              <!-- Buttons -->
              <div class="mt-4 text-end">
                  <a href="{{ route('extra_received.index') }}"
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
<!-- / Content -->
@endsection

@section('scripts')
@endsection