@extends('layouts.app')

@section('title', __('Dashboard'))

@section('body')
<div class="row g-3 mb-4">
  @foreach ($stats as [$icon, $label, $value, $link])
    <div class="col-6 col-md-4 col-xl-2">
      <a href="{{ $link }}" class="card h-100 text-decoration-none">
        <div class="card-body p-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-xs mb-0 text-secondary text-uppercase font-weight-bold">{{ $label }}</p>
              <h4 class="font-weight-bolder mb-0">{{ $value }}</h4>
            </div>
            <div class="icon icon-shape icon-sm bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-center">
              <i class="fa-solid {{ $icon }} text-white"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  @endforeach
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">{{ __('Billing') }} @if ($billing)<span class="text-sm text-secondary font-weight-normal">· {{ $billing['label'] }}</span>@endif</h6>
        @if ($billing)<a href="{{ route('account_month.edit', $billing['month']) }}" class="text-sm">{{ __('Open') }}</a>@endif
      </div>
      <div class="card-body">
        @if ($billing)
          @php $pct = $billing['billed'] > 0 ? round($billing['paid'] / $billing['billed'] * 100) : 0; @endphp
          <div class="d-flex justify-content-between text-sm"><span>{{ __('Billed') }}</span><strong>RM {{ number_format($billing['billed'], 2) }}</strong></div>
          <div class="d-flex justify-content-between text-sm"><span>{{ __('Paid') }}</span><strong class="text-success">RM {{ number_format($billing['paid'], 2) }}</strong></div>
          <div class="d-flex justify-content-between text-sm"><span>{{ __('Outstanding') }}</span><strong class="text-danger">RM {{ number_format($billing['billed'] - $billing['paid'], 2) }}</strong></div>
          <div class="progress mt-3" style="height:8px"><div class="progress-bar bg-gradient-success" style="width: {{ $pct }}%"></div></div>
          <p class="text-xs text-secondary mt-2 mb-0">{{ __(':pct% collected · :count unpaid bill(s)', ['pct' => $pct, 'count' => $billing['unpaid_count']]) }}</p>
        @else
          <p class="text-sm text-secondary mb-0">{{ __('No billing month yet.') }}</p>
        @endif
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">{{ __('Pending leave') }}</h6>
        <a href="{{ route('leave.index') }}" class="text-sm">{{ __('View all') }}</a>
      </div>
      <div class="card-body">
        @forelse ($pendingLeave as $l)
          <div class="d-flex justify-content-between align-items-start text-sm mb-2">
            <div>
              <strong>{{ $l->user->name }}</strong> · {{ $l->typeLabel() }}<br>
              <span class="text-xs text-secondary">{{ $l->dateRange() }} ({{ rtrim(rtrim((string) $l->days, '0'), '.') }} {{ __('day(s)') }})</span>
            </div>
            <a href="{{ route('leave.index') }}" class="btn btn-sm btn-outline-primary mb-0 py-1 px-2">{{ __('Review') }}</a>
          </div>
        @empty
          <p class="text-sm text-secondary mb-0">{{ __('No pending applications.') }}</p>
        @endforelse
        @if ($onLeaveToday->isNotEmpty())
          <hr class="horizontal dark my-2">
          <p class="text-xs text-uppercase text-secondary font-weight-bold mb-1">{{ __('On leave today') }}</p>
          @foreach ($onLeaveToday as $l)
            <span class="badge bg-gradient-info me-1">{{ $l->user->name }}</span>
          @endforeach
        @endif
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">{{ __('Upcoming 1-to-1 classes') }}</h6>
        <a href="{{ route('one_to_one.index') }}" class="text-sm">{{ __('All classes') }}</a>
      </div>
      <div class="card-body" style="max-height:340px;overflow-y:auto">
        @include('my_classes._upcoming', ['sessions' => $sessions, 'showTeacher' => true])
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-6">
    @include('dashboard._today_timetable')
  </div>
</div>
@endsection
