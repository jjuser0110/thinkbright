@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Category</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
                  
                <form enctype="multipart/form-data"
                    @if (isset($category))
                        method="post" action="{{ route('category.update', $category) }}"
                    @else
                        method="post" action="{{ route('category.store') }}"
                    @endif>

                    @csrf
                    @if(isset($category))
                        @method('POST')
                    @endif

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Category Name</label>
                            <input type="text"
                                class="form-control"
                                name="name"
                                placeholder="Category Name..."
                                value="{{ $category->name ?? '' }}"
                                required
                                autocomplete="off">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 text-end">
                        <a href="{{ route('category.index') }}"
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
