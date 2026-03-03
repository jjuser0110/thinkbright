@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <a class="text-muted fw-light" href="{{ route('expense.index') }}">Expense /</a>
        @if (isset($expense)) Edit @else Create @endif
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Expense Details</h5>
                <div class="card-body">
                    <form enctype="multipart/form-data" @if (isset($expense)) method="post" action="{{ route('expense.update',$expense) }}" @else method="post" action="{{ route('expense.store') }}" @endif onsubmit="showLoading()" >
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Title</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="title"
                                    value="{{ $expense->title ?? '' }}"
                                    placeholder="Enter title"
                                    required
                                />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Issue Date</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="isseued_date"
                                    value="{{ $expense->isseued_date ?? date('Y-m-d') }}"
                                    required
                                />
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Amount (RM)</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    class="form-control"
                                    name="amount"
                                    value="{{ $expense->amount ?? '' }}"
                                    placeholder="Enter amount collected"
                                    required
                                />
                            </div>

                            <!-- Customer Info -->
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea
                                    class="form-control"
                                    name="description"
                                    rows="2"
                                    placeholder="Enter description"
                                >{{ $expense->description ?? '' }}</textarea>
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
