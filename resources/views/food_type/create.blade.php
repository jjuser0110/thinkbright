@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Bank</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              
            <form enctype="multipart/form-data"
                @if (isset($food_type))
                    method="post" action="{{ route('food_type.update',$food_type) }}"
                @else
                    method="post" action="{{ route('food_type.store') }}"
                @endif>

              @csrf
              @if(isset($food_type))
                  @method('PUT')
              @endif

              <div class="row g-4">

                  <div class="col-md-6">
                      <label class="form-label">Food Type Name</label>
                      <input type="text"
                            class="form-control"
                            name="name"
                            placeholder="Food Type Name..."
                            value="{{ $food_type->name ?? '' }}"
                            required
                            autocomplete="off">
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">Food Type Price</label>
                      <input type="number"
                            min="0"
                            step="0.01"
                            class="form-control"
                            name="price"
                            placeholder="Food Type Price..."
                            value="{{ $food_type->price ?? '' }}"
                            required
                            autocomplete="off">
                  </div>

              </div>

              <!-- Buttons -->
              <div class="mt-4 text-end">
                  <a href="{{ route('food_type.index') }}"
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