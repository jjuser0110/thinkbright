@extends('layouts.app')

@section('title', __('My 1-to-1 Classes'))

@section('body')
<div class="row g-4">
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h6 class="mb-0">{{ __('Upcoming classes (next 14 days)') }}</h6>
      </div>
      <div class="card-body">
        @include('my_classes._upcoming', ['sessions' => $sessions])
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header pb-0 d-flex justify-content-between align-items-start">
        <h6 class="mb-0">{{ __('My weekly classes') }}</h6>
        <div class="text-end">
          <p class="text-xs text-secondary mb-0">{{ __('Commission this month') }}</p>
          <h6 class="mb-0">RM {{ number_format($commission, 2) }}</h6>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>{{ __('Day & time') }}</th>
                <th>{{ __('Student') }}</th>
                <th>{{ __('Subject') }}</th>
                <th class="text-end">{{ __('Commission') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($classes as $c)
                <tr>
                  <td class="text-sm text-nowrap">{{ $c->dayName() }}<br><span class="text-secondary">{{ $c->timeRange() }}</span></td>
                  <td class="text-sm">{{ $c->student?->displayName() }}<br><span class="text-xs text-secondary">{{ $c->student?->school?->name }}</span></td>
                  <td class="text-sm">{{ $c->subject }}</td>
                  <td class="text-sm text-end">RM {{ number_format($c->commissionAmount(), 2) }}</td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-sm text-secondary">{{ __('You have no 1-to-1 classes yet.') }}</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
