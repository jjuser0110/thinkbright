@extends('layouts.app')

@section('title', __('My Leave'))

@section('body')
<div class="row g-4">
  <div class="col-lg-5">
    @include('my_leave._balances')

    <div class="card mt-4">
      <div class="card-header pb-0"><h6 class="mb-0">{{ __('Apply for leave') }}</h6></div>
      <div class="card-body">
        <form method="POST" action="{{ route('my_leave.store') }}">
          @csrf
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label" for="type">{{ __('Leave type') }} *</label>
              <select class="form-select" id="type" name="type" required>
                @foreach (\App\Models\LeaveApplication::TYPES as $key => $label)
                  <option value="{{ $key }}" @selected(old('type') === $key)>{{ __($label) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-6">
              <label class="form-label" for="start_date">{{ __('From') }} *</label>
              <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
            </div>
            <div class="col-6">
              <label class="form-label" for="end_date">{{ __('To') }} *</label>
              <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="half_day" name="half_day" value="1" @checked(old('half_day'))>
                <label class="form-check-label" for="half_day">{{ __('Half day (single date only)') }}</label>
              </div>
              <p class="text-xs text-secondary mb-0" id="days-preview"></p>
            </div>
            <div class="col-12">
              <label class="form-label" for="reason">{{ __('Reason') }}</label>
              <textarea class="form-control" id="reason" name="reason" rows="3">{{ old('reason') }}</textarea>
            </div>
          </div>
          <button type="submit" class="btn bg-gradient-primary mt-3 mb-0">{{ __('Submit application') }}</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header pb-0"><h6 class="mb-0">{{ __('My applications') }}</h6></div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Dates') }}</th>
                <th class="text-center">{{ __('Days') }}</th>
                <th>{{ __('Status') }}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($applications as $a)
                <tr>
                  <td class="text-sm">{{ $a->typeLabel() }}</td>
                  <td class="text-sm">{{ $a->dateRange() }}@if ($a->reason)<br><span class="text-xs text-secondary">{{ \Illuminate\Support\Str::limit($a->reason, 60) }}</span>@endif</td>
                  <td class="text-sm text-center">{{ rtrim(rtrim((string) $a->days, '0'), '.') }}</td>
                  <td class="text-sm">
                    <span class="tb-pill tb-pill-{{ $a->status }}">{{ __(ucfirst($a->status)) }}</span>
                    @if ($a->admin_remarks)<br><span class="text-xs text-secondary">{{ $a->admin_remarks }}</span>@endif
                  </td>
                  <td class="text-end">
                    @if ($a->status === 'pending')
                      <form method="POST" action="{{ route('my_leave.cancel', $a) }}" data-confirm="{{ __('Cancel this application?') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger text-xs p-0 m-0">{{ __('Cancel') }}</button>
                      </form>
                    @endif
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" class="text-sm text-secondary">{{ __('No leave applications yet.') }}</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Preview the number of working days (Mon–Fri) the application will use.
  (function () {
    var s = document.getElementById('start_date'), e = document.getElementById('end_date'), h = document.getElementById('half_day'), out = document.getElementById('days-preview');
    function update() {
      if (s.value && !e.value) e.value = s.value;
      if (!s.value || !e.value) { out.textContent = ''; return; }
      var d = new Date(s.value + 'T00:00:00'), end = new Date(e.value + 'T00:00:00'), n = 0;
      while (d <= end) { var w = d.getDay(); if (w !== 0 && w !== 6) n++; d.setDate(d.getDate() + 1); }
      if (h.checked && s.value === e.value && n === 1) n = 0.5;
      out.textContent = @json(__('Working days (Mon–Fri):')) + ' ' + n;
    }
    [s, e, h].forEach(function (el) { el.addEventListener('change', update); });
    update();
  })();
</script>
@endpush
@endsection
