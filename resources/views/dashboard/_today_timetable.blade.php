{{-- Today's daycare timetable. Expects $todayTimetable. --}}
<div class="card h-100">
  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
    <h6 class="mb-0">{{ __('Daycare today') }} <span class="text-sm text-secondary font-weight-normal">· {{ __(now()->format('l')) }}</span></h6>
    <a href="{{ route(auth()->user()->isAdmin() ? 'timetable.index' : 'timetable.view') }}" class="text-sm">{{ __('Full week') }}</a>
  </div>
  <div class="card-body">
    @if (now()->isWeekend())
      <p class="text-sm text-secondary mb-0">{{ __('No daycare on weekends.') }}</p>
    @else
      @forelse ($todayTimetable as $slot)
        @php $now = now()->format('H:i:s'); $current = $slot->start_time <= $now && $slot->end_time > $now; @endphp
        <div class="tb-slot {{ $current ? 'tb-today' : '' }}">
          <span class="tb-slot-time">{{ $slot->timeRange() }} @if ($current)<span class="badge bg-gradient-primary ms-1">{{ __('Now') }}</span>@endif</span>
          {{ $slot->activity }}
          @if ($slot->teacher)<span class="d-block text-xs text-secondary"><i class="fa-solid fa-user me-1"></i>{{ $slot->teacher->name }}</span>@endif
        </div>
      @empty
        <p class="text-sm text-secondary mb-0">{{ __('No activities set for today.') }}</p>
      @endforelse
    @endif
  </div>
</div>
