@extends('layouts.app')

@section('title', __('Profile'))

@section('body')
<div class="row">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">{{ __('Username') }}</label>
              <input type="text" class="form-control" value="{{ $user->username }}" disabled>
            </div>
            <div class="col-md-6">
              <label class="form-label">{{ __('Role') }}</label>
              <input type="text" class="form-control" value="{{ __(ucfirst($user->role ?? '')) }}" disabled>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="name">{{ __('Name') }} *</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="email">{{ __('Email') }}</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="contact">{{ __('Contact') }}</label>
              <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact', $user->contact) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="ic">{{ __('IC') }}</label>
              <input type="text" class="form-control" id="ic" name="ic" value="{{ old('ic', $user->ic) }}">
            </div>
          </div>
          <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn bg-gradient-primary mb-0">{{ __('Save') }}</button>
            <a href="{{ route('user.change_password') }}" class="btn btn-outline-secondary mb-0">{{ __('Change Password') }}</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
