{{-- Upcoming 1-to-1 sessions. Expects $sessions from OneToOneClass::upcomingSessions(); optional $showTeacher. --}}
@php $showTeacher = $showTeacher ?? false; @endphp
@forelse ($sessions->groupBy(fn ($s) => $s['date']->format('Y-m-d')) as $date => $daySessions)
  @php $d = \Carbon\Carbon::parse($date); @endphp
  <p class="text-xs text-uppercase font-weight-bolder mb-2 {{ $loop->first ? '' : 'mt-3' }} {{ $d->isToday() ? 'text-primary' : 'text-secondary' }}">
    {{ $d->isToday() ? __('Today') : ($d->isTomorrow() ? __('Tomorrow') : __($d->format('l'))) }} · {{ $d->format('d M') }}
  </p>
  @foreach ($daySessions as $s)
    <div class="tb-slot {{ $d->isToday() ? 'tb-today' : '' }}">
      <span class="tb-slot-time">{{ $s['class']->timeRange() }}</span>
      {{ $s['class']->student?->displayName() }} · {{ $s['class']->subject }}
      @if ($showTeacher)<span class="d-block text-xs text-secondary"><i class="fa-solid fa-user me-1"></i>{{ $s['class']->teacher?->name }}</span>@endif
    </div>
  @endforeach
@empty
  <p class="text-sm text-secondary mb-0">{{ __('No upcoming classes.') }}</p>
@endforelse
