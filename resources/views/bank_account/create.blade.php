@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Bank Account</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
                  
                <form enctype="multipart/form-data"
                    @if (isset($bankAccount))
                        method="post" action="{{ route('bank_account.update', $bankAccount) }}"
                    @else
                        method="post" action="{{ route('bank_account.store') }}"
                    @endif>

                    @csrf
                    @if(isset($bankAccount))
                        @method('PUT')
                    @endif

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label">Bank</label>
                            <select name="bank_id" class="form-control" required>
                                <option value="">-- Select Bank --</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}"
                                        {{ isset($bankAccount) && $bankAccount->bank_id == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Account Name</label>
                            <input type="text"
                                class="form-control"
                                name="account_name"
                                placeholder="Account Name..."
                                value="{{ $bankAccount->account_name ?? '' }}"
                                required
                                autocomplete="off">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Account Number</label>
                            <input type="number"
                                class="form-control"
                                name="account_no"
                                placeholder="Account Number..."
                                value="{{ $bankAccount->account_no ?? '' }}"
                                required
                                autocomplete="off">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Capital</label>
                            <input type="number"
                                class="form-control"
                                name="capital"
                                placeholder="Capital..."
                                value="{{ $bankAccount->capital ?? '' }}"
                                required
                                autocomplete="off"
                                @if(isset($bankAccount)) readonly @endif>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 text-end">
                        <a href="{{ route('bank_account.index') }}"
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
