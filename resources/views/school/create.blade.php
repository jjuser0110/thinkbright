@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit School</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
                  
                <form enctype="multipart/form-data"
                    @if (isset($school))
                        method="post" action="{{ route('school.update',$school) }}"
                    @else
                        method="post" action="{{ route('school.store') }}"
                    @endif>

                    @csrf
                    @if(isset($school))
                        @method('PUT')
                    @endif

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label">School Name</label>
                            <input type="text"
                                class="form-control"
                                name="name"
                                placeholder="School Name..."
                                value="{{ $school->name ?? '' }}"
                                required>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 text-end">
                        <a href="{{ route('school.index') }}"
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
