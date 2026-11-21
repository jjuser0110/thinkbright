@extends('layouts.app')

@section('title', __('Daycare Enrolments'))

@section('body')
<div class="row g-3 mb-4">
  @foreach ([
    ['fa-child-reaching', __('Daycare'), $totals['daycare']],
    ['fa-utensils', __('Bath & lunch'), $totals['bath_lunch']],
    ['fa-van-shuttle', __('Transport'), $totals['transport']],
    ['fa-sack-dollar', __('Monthly total'), 'RM '.number_format($totals['amount'], 2)],
  ] as [$icon, $label, $value])
    <div class="col-6 col-xl-3">
      <div class="card">
        <div class="card-body p-3 d-flex align-items-center">
          <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3 d-flex align-items-center justify-content-center">
            <i class="fa-solid {{ $icon }} text-white"></i>
          </div>
          <div>
            <p class="text-sm mb-0 text-secondary">{{ $label }}</p>
            <h5 class="font-weight-bolder mb-0">{{ $value }}</h5>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>

<div class="card">
  <div class="card-header pb-0 d-flex flex-wrap gap-2 justify-content-between align-items-center">
    <h6 class="mb-0">{{ __('Enrolled students') }}</h6>
    <form method="GET" class="d-flex gap-2 align-items-center">
      <select name="school_id" class="form-select form-select-sm" onchange="this.form.submit()" aria-label="{{ __('Filter by school') }}">
        <option value="">{{ __('All schools') }}</option>
        @foreach ($schools as $sc)
          <option value="{{ $sc->id }}" @selected($schoolId == $sc->id)>{{ $sc->name }}</option>
        @endforeach
      </select>
    </form>
  </div>
  <div class="card-body">
    <p class="text-sm text-secondary">{{ __('To enrol a student, edit the student and tick the services under "Daycare services".') }}</p>
    <table id="enrolment-table" class="table table-striped align-middle">
      <thead>
        <tr>
          <th>{{ __('Student') }}</th>
          <th>{{ __('School') }}</th>
          <th class="text-end">{{ __('Daycare') }}</th>
          <th class="text-end">{{ __('Bath & lunch') }}</th>
          <th class="text-end">{{ __('Transport') }}</th>
          <th class="text-end">{{ __('1-to-1') }}</th>
          <th class="text-end">{{ __('Total / month') }}</th>
          <th class="no-sort"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($students as $s)
          <tr>
            <td>{{ $s->displayName() }}</td>
            <td>{{ $s->school->name ?? '' }}</td>
            @foreach (['daycare', 'bath_lunch', 'transport'] as $svc)
              <td class="text-end">
                @if ($s->{$svc})
                  {{ number_format($s->charges[$svc], 2) }}
                  @if (! is_null($s->{$svc.'_fee'}))<span class="badge bg-light text-dark ms-1" title="{{ __('Custom amount') }}">{{ __('custom') }}</span>@endif
                  @if ($svc === 'transport' && $s->transportFeeMissing())<i class="fa-solid fa-triangle-exclamation text-warning ms-1" title="{{ __('School has no transport fee set') }}"></i>@endif
                @else
                  <span class="tb-no">—</span>
                @endif
              </td>
            @endforeach
            <td class="text-end">{{ $s->charges['one_to_one'] ? number_format($s->charges['one_to_one'], 2) : '' }}</td>
            <td class="text-end font-weight-bold">{{ number_format($s->charges['total'], 2) }}</td>
            <td class="text-end"><a href="{{ route('student.edit', $s) }}" class="text-body" title="{{ __('Edit') }}"><i class="fas fa-pencil-alt"></i></a></td>
          </tr>
        @empty
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@include('layouts.partials.datatables', ['table' => '#enrolment-table', 'options' => ['columnDefs' => [['orderable' => false, 'targets' => 'no-sort']], 'language' => ['emptyTable' => __('No students enrolled yet.')]]])
@endsection
