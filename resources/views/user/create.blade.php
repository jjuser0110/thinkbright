@extends('layouts.app')

@section('title', isset($user) ? __('Edit Teacher') : __('Add Teacher'))

@section('body')
<form method="POST" action="{{ isset($user) ? route('user.update', $user) : route('user.store') }}">
  @csrf
  <div class="row g-4">
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header pb-0"><h6 class="mb-0">{{ __('Personal details') }}</h6></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="name">{{ __('Name') }} *</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required autocomplete="off">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="username">{{ __('Username') }} *</label>
              <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username ?? '') }}" {{ isset($user) ? 'readonly' : 'required' }} autocomplete="off">
              @unless (isset($user))
                <div class="form-text">{{ __('Used to log in. Default password is :password.', ['password' => \App\Http\Controllers\UserController::DEFAULT_PASSWORD]) }}</div>
              @endunless
            </div>
            <div class="col-md-6">
              <label class="form-label" for="shortname">{{ __('Shortname') }}</label>
              <input type="text" class="form-control" id="shortname" name="shortname" value="{{ old('shortname', $user->shortname ?? '') }}" autocomplete="off">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="ic">{{ __('IC') }}</label>
              <input type="text" class="form-control" id="ic" name="ic" value="{{ old('ic', $user->ic ?? '') }}" autocomplete="off">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="contact">{{ __('Contact') }}</label>
              <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact', $user->contact ?? '') }}" autocomplete="off">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="is_active">{{ __('Status') }}</label>
              <select class="form-select" id="is_active" name="is_active">
                <option value="1" @selected(old('is_active', $user->is_active ?? 1) == 1)>{{ __('Active') }}</option>
                <option value="0" @selected(old('is_active', $user->is_active ?? 1) == 0)>{{ __('Inactive') }}</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header pb-0"><h6 class="mb-0">{{ __('Salary & leave') }}</h6></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label" for="basic_salary">{{ __('Basic salary (RM / month)') }}</label>
              <input type="number" step="0.01" min="0" class="form-control" id="basic_salary" name="basic_salary" value="{{ old('basic_salary', $user->basic_salary ?? '') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="no_of_annual_leave">{{ __('Annual leave (days / year)') }}</label>
              <input type="number" min="0" class="form-control" id="no_of_annual_leave" name="no_of_annual_leave" value="{{ old('no_of_annual_leave', $user->no_of_annual_leave ?? '') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="no_of_sick_leave">{{ __('Sick leave (days / year)') }}</label>
              <input type="number" min="0" class="form-control" id="no_of_sick_leave" name="no_of_sick_leave" value="{{ old('no_of_sick_leave', $user->no_of_sick_leave ?? '') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="bank_id">{{ __('Bank') }}</label>
              <select class="form-select" id="bank_id" name="bank_id">
                <option value="">{{ __('-- Select Bank --') }}</option>
                @foreach ($banks as $bank)
                  <option value="{{ $bank->id }}" @selected(old('bank_id', $user->bank_id ?? null) == $bank->id)>{{ $bank->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="bank_account">{{ __('Bank account no.') }}</label>
              <input type="text" class="form-control" id="bank_account" name="bank_account" value="{{ old('bank_account', $user->bank_account ?? '') }}" autocomplete="off">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn bg-gradient-primary mb-0">{{ __('Save') }}</button>
    <a href="{{ route('user.index') }}" class="btn btn-outline-secondary mb-0">{{ __('Back') }}</a>
  </div>
</form>
@endsection
