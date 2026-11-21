{{-- Weekly grid. Expects $week (day => slots) and $editable (bool). --}}
@php $today = now()->dayOfWeekIso; @endphp
<div class="table-responsive">
  <table class="table table-bordered tb-timetable mb-0">
    <thead>
      <tr>
        @foreach (\App\Models\DaycareTimetable::DAYS as $day => $name)
          <th class="text-center {{ $day === $today ? 'tb-today' : '' }}">
            {{ __($name) }}
            @if ($editable)
              <a href="{{ route('timetable.create', ['day' => $day]) }}" class="ms-1 text-primary no-print" title="{{ __('Add slot') }}"><i class="fa-solid fa-circle-plus"></i></a>
            @endif
          </th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      <tr>
        @foreach ($week as $day => $slots)
          <td class="{{ $day === $today ? 'tb-today' : '' }}">
            @forelse ($slots as $slot)
              <div class="tb-slot">
                <span class="tb-slot-time">{{ $slot->timeRange() }}</span>
                <span>{{ $slot->activity }}</span>
                @if ($slot->teacher)<span class="d-block text-xs text-secondary"><i class="fa-solid fa-user me-1"></i>{{ $slot->teacher->name }}</span>@endif
                @if ($slot->remarks)<span class="d-block text-xs text-secondary">{{ $slot->remarks }}</span>@endif
                @if ($editable)
                  <div class="mt-1 no-print">
                    <a href="{{ route('timetable.edit', $slot) }}" class="text-body text-xs me-2"><i class="fas fa-pencil-alt"></i> {{ __('Edit') }}</a>
                    <form method="POST" action="{{ route('timetable.destroy', $slot) }}" class="d-inline" data-confirm="{{ __('Delete this slot?') }}">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-link text-danger text-xs p-0 m-0"><i class="fas fa-trash-alt"></i> {{ __('Delete') }}</button>
                    </form>
                  </div>
                @endif
              </div>
            @empty
              <span class="text-xs text-secondary">{{ __('No activities') }}</span>
            @endforelse
          </td>
        @endforeach
      </tr>
    </tbody>
  </table>
</div>
