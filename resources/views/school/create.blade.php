@extends('layouts.app')

@section('title', isset($school) ? __('Edit School') : __('Add School'))

@section('body')
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ isset($school) ? route('school.update', $school) : route('school.store') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="name">{{ __('School Name') }} *</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $school->name ?? '') }}" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label class="form-label" for="transport_fee">{{ __('Transport fee (RM / month)') }}</label>
            <input type="number" step="0.01" min="0" class="form-control" id="transport_fee" name="transport_fee" value="{{ old('transport_fee', $school->transport_fee ?? '') }}" placeholder="{{ __('e.g. 80') }}">
            <div class="form-text">{{ __('Charged to students from this school who take transport.') }}</div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn bg-gradient-primary mb-0">{{ __('Save') }}</button>
            <a href="{{ route('school.index') }}" class="btn btn-outline-secondary mb-0">{{ __('Back') }}</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
