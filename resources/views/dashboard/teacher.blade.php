@extends('layouts.app')

@section('title', __('Dashboard'))

@section('body')
<div class="row g-3 mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-3 d-flex flex-wrap gap-3 justify-content-between align-items-center">
        <div>
          <p class="text-sm text-secondary mb-0">{{ __('Welcome back') }}</p>
          <h5 class="font-weight-bolder mb-0">{{ auth()->user()->name }}</h5>
        </div>
        <div class="d-flex gap-4 text-center">
          <div><p class="text-xs text-secondary mb-0">{{ __('My 1-to-1 classes') }}</p><h5 class="mb-0">{{ $classCount }}</h5></div>
          <div><p class="text-xs text-secondary mb-0">{{ __('Commission this month') }}</p><h5 class="mb-0">RM {{ number_format($commission, 2) }}</h5></div>
          <div><p class="text-xs text-secondary mb-0">{{ __('Pending leave') }}</p><h5 class="mb-0">{{ $pendingLeave }}</h5></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">{{ __('Upcoming 1-to-1 classes') }}</h6>
        <a href="{{ route('my_classes.index') }}" class="text-sm">{{ __('My classes') }}</a>
      </div>
      <div class="card-body">
        @include('my_classes._upcoming', ['sessions' => $sessions])
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="mb-0">{{ __('My leave') }}</h6>
      <a href="{{ route('my_leave.index') }}" class="btn btn-sm bg-gradient-primary mb-0"><i class="fa-solid fa-plus me-1"></i>{{ __('Apply leave') }}</a>
    </div>
    @include('my_leave._balances')
    <div class="mt-4">
      @include('dashboard._today_timetable')
    </div>
  </div>
</div>
@endsection
