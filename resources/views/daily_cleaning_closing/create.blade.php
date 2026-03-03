@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{ route('daily_cleaning_closing.index') }}">Daily Cleaning Closing /</a>
        @if (isset($daily_cleaning_closing)) Edit @else Create @endif
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Daily Cleaning Closing Details</h5>
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" action="{{ route('daily_cleaning_closing.store') }}" onsubmit="showLoading()" >
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Date From</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="date_from"
                                    value="{{ date('Y-m-d') }}"
                                    required
                                />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date To</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="date_to"
                                    value="{{ date('Y-m-d') }}"
                                    required
                                />
                            </div>

                            
                            <hr>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
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
