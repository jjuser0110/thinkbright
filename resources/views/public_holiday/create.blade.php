@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Public Holiday</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
                  
                <form enctype="multipart/form-data"
                    @if (isset($public_holiday))
                        method="post" action="{{ route('public_holiday.update', $public_holiday) }}"
                    @else
                        method="post" action="{{ route('public_holiday.store') }}"
                    @endif>

                    @csrf
                    @if(isset($public_holiday))
                        @method('POST')
                    @endif

                    <div class="row g-4">
    
                        <div class="col-md-6">
                            <label class="form-label">Public Holiday Name</label>
                            <input type="text"
                                class="form-control"
                                name="name"
                                placeholder="Name..."
                                value="{{ $public_holiday->name ?? '' }}"
                                required
                                autocomplete="off">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Public Holiday Date</label>
                            <input type="date"
                                class="form-control"
                                name="date"
                                value="{{ $public_holiday->date ?? '' }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Public Holiday Status</label>
                            <select class="form-control" name="is_active" required>
                                <option value="1" {{ (isset($public_holiday) && $public_holiday->is_active == 1) ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ (isset($public_holiday) && $public_holiday->is_active == 0) ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 text-end">
                        <a href="{{ route('public_holiday.index') }}"
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
