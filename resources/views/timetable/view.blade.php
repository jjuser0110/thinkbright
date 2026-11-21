@extends('layouts.app')

@section('title', __('Daycare Timetable'))

@section('body')
<div class="card">
  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
    <h6 class="mb-0">{{ __('Weekly timetable (Monday – Friday)') }}</h6>
    <button type="button" class="btn btn-sm btn-outline-secondary mb-0 no-print" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>{{ __('Print') }}</button>
  </div>
  <div class="card-body">
    @include('timetable._grid')
  </div>
</div>
@endsection
