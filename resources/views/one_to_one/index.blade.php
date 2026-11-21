@extends('layouts.app')

@section('title', __('1-to-1 Classes'))

@section('body')
<div class="card">
  <div class="card-header pb-0 d-flex flex-wrap gap-2 justify-content-between align-items-center">
    <h6 class="mb-0">{{ __('1-to-1 Classes') }}</h6>
    <div class="d-flex flex-wrap gap-2 align-items-center">
      <form method="GET" class="d-flex gap-2">
        <select name="teacher_id" class="form-select form-select-sm" onchange="this.form.submit()" aria-label="{{ __('Teacher') }}">
          <option value="">{{ __('All teachers') }}</option>
          @foreach ($teachers as $t)
            <option value="{{ $t->id }}" @selected($teacherId == $t->id)>{{ $t->name }}</option>
          @endforeach
        </select>
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" aria-label="{{ __('Status') }}">
          <option value="active" @selected($status === 'active')>{{ __('Running now') }}</option>
          <option value="ended" @selected($status === 'ended')>{{ __('Ended / inactive') }}</option>
          <option value="all" @selected($status === 'all')>{{ __('All') }}</option>
        </select>
      </form>
      <a href="{{ route('one_to_one.create') }}" class="btn btn-sm bg-gradient-primary mb-0"><i class="fa-solid fa-plus me-1"></i>{{ __('Add class') }}</a>
    </div>
  </div>
  <div class="card-body">
    <table id="o2o-table" class="table table-striped align-middle">
      <thead>
        <tr>
          <th>{{ __('Student') }}</th>
          <th>{{ __('Teacher') }}</th>
          <th>{{ __('Subject') }}</th>
          <th>{{ __('Weekly slot') }}</th>
          <th class="text-end">{{ __('Fee / month') }}</th>
          <th class="text-end">{{ __('Commission') }}</th>
          <th>{{ __('Period') }}</th>
          <th class="no-sort"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($classes as $c)
          <tr>
            <td>{{ $c->student?->displayName() }}</td>
            <td>{{ $c->teacher?->name }}</td>
            <td>{{ $c->subject }}</td>
            <td data-order="{{ $c->day }}{{ $c->start_time }}">{{ $c->dayName() }} {{ $c->timeRange() }}</td>
            <td class="text-end">{{ number_format($c->monthly_fee, 2) }}</td>
            <td class="text-end">{{ number_format($c->commissionAmount(), 2) }} <span class="text-xs text-secondary">({{ rtrim(rtrim(number_format($c->commission_percent, 2), '0'), '.') }}%)</span></td>
            <td class="text-sm">
              {{ $c->start_date->format('d M Y') }} – {{ $c->end_date?->format('d M Y') ?? __('ongoing') }}
              @unless ($c->is_active)<span class="tb-pill tb-pill-cancelled ms-1">{{ __('Inactive') }}</span>@endunless
            </td>
            <td class="text-end text-nowrap">
              <a href="{{ route('one_to_one.edit', $c) }}" class="text-body me-3" title="{{ __('Edit') }}"><i class="fas fa-pencil-alt"></i></a>
              <form method="POST" action="{{ route('one_to_one.destroy', $c) }}" class="d-inline" data-confirm="{{ __('Delete this class?') }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-link text-danger p-0 m-0" title="{{ __('Delete') }}"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
      @if ($classes->isNotEmpty())
        <tfoot>
          <tr>
            <th colspan="4" class="text-end">{{ __('Total') }}</th>
            <th class="text-end">{{ number_format($classes->sum('monthly_fee'), 2) }}</th>
            <th class="text-end">{{ number_format($classes->sum(fn ($c) => $c->commissionAmount()), 2) }}</th>
            <th colspan="2"></th>
          </tr>
        </tfoot>
      @endif
    </table>
  </div>
</div>
@include('layouts.partials.datatables', ['table' => '#o2o-table', 'options' => ['order' => [[3, 'asc']], 'columnDefs' => [['orderable' => false, 'targets' => 'no-sort']], 'language' => ['emptyTable' => __('No 1-to-1 classes yet.')]]])
@endsection
