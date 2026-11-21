@extends('layouts.app')

@section('title', __('Daycare Timetable'))

@section('body')
<div class="card">
  <div class="card-header pb-0 d-flex flex-wrap gap-2 justify-content-between align-items-center">
    <div>
      <h6 class="mb-0">{{ __('Weekly timetable (Monday – Friday)') }}</h6>
      <p class="text-sm text-secondary mb-0">{{ __('Teachers see this timetable read-only.') }}</p>
    </div>
    <div class="d-flex gap-2 no-print">
      <button type="button" class="btn btn-sm btn-outline-secondary mb-0" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>{{ __('Print') }}</button>
      <a href="{{ route('timetable.create') }}" class="btn btn-sm bg-gradient-primary mb-0"><i class="fa-solid fa-plus me-1"></i>{{ __('Add slot') }}</a>
    </div>
  </div>
  <div class="card-body">
    @include('timetable._grid')
  </div>
</div>
@endsection
