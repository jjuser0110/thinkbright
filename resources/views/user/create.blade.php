@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Teacher</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
                  
                <form enctype="multipart/form-data"
                @if (isset($user))
                    method="post" action="{{ route('user.update',$user) }}"
                @else
                    method="post" action="{{ route('user.store') }}"
                @endif>
                @csrf

                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control"
                            name="name"
                            placeholder="Name..."
                            value="{{ $user->name ?? '' }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control"
                            name="username"
                            placeholder="Username..."
                            value="{{ $user->username ?? '' }}"
                            required
                            {{ isset($user) ? 'readonly' : '' }}>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Shortname</label>
                        <input type="text" class="form-control"
                            name="shortname"
                            placeholder="Shortname..."
                            value="{{ $user->shortname ?? '' }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">IC</label>
                        <input type="text" class="form-control"
                            name="ic"
                            placeholder="IC..."
                            value="{{ $user->ic ?? '' }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Contact</label>
                        <input type="text" class="form-control"
                            name="contact"
                            placeholder="Contact..."
                            value="{{ $user->contact ?? '' }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control"
                            name="email"
                            placeholder="Email..."
                            value="{{ $user->email ?? '' }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Number of Annual Leave</label>
                        <input type="number" class="form-control"
                            name="no_of_annual_leave"
                            placeholder="Number of annual leave..."
                            value="{{ $user->no_of_annual_leave ?? '' }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bank</label>
                        <select name="bank_id" class="form-control">
                            <option value="">-- Select Bank --</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}"
                                    {{ (isset($user) && $user->bank_id == $bank->id) ? 'selected' : '' }}>
                                    {{ $bank->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bank Account</label>
                        <input type="number" class="form-control"
                            name="bank_account"
                            placeholder="Bank account..."
                            value="{{ $user->bank_account ?? '' }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Is Active</label>
                        <select class="form-control" name="is_active">
                            <option value="1"
                                {{ (isset($user) && $user->is_active == 1) ? 'selected' : '' }}>
                                Yes
                            </option>
                            <option value="0"
                                {{ (isset($user) && $user->is_active == 0) ? 'selected' : '' }}>
                                No
                            </option>
                        </select>
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-5 text-end">
                    <a class="btn btn-light me-2"
                        href="{{ route('user.index') }}">
                        Back
                    </a>

                    <button type="submit" class="btn btn-success">
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
