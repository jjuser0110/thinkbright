@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Food</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              
            <form enctype="multipart/form-data"
                @if (isset($food))
                    method="post" action="{{ route('food.update',$food) }}"
                @else
                    method="post" action="{{ route('food.store') }}"
                @endif>

              @csrf
              @if(isset($food))
                  @method('PUT')
              @endif

              <div class="row g-4">

                  <div class="col-md-6">
                      <label class="form-label">Date</label>
                      <input type="date"
                            class="form-control"
                            name="date_of_food"
                            value="{{ $food->date_of_food ?? date('Y-m-d') }}"
                            required
                            autocomplete="off">
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">Food Type</label>
                      <select name="food_type_id" class="form-control" required>
                          @foreach($food_type as $f)
                              <option value="{{ $f->id }}"
                                  {{ isset($food) && $food->food_type_id == $f->id ? 'selected' : '' }}>
                                  {{ $f->name }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">QTY</label>
                      <input type="number"
                            step="1"
                            min="0"
                            class="form-control"
                            name="quantity"
                            value="{{ $food->quantity ?? '' }}"
                            required
                            autocomplete="off">
                  </div>

              </div>

              <!-- Buttons -->
              <div class="mt-4 text-end">
                  <a href="{{ route('food.index') }}"
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