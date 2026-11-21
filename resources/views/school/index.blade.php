@extends('layouts.app')

@section('title', __('School Setting'))

@section('body')
<div class="card">
  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
    <h6 class="mb-0">{{ __('Schools') }}</h6>
    <a href="{{ route('school.create') }}" class="btn btn-sm bg-gradient-primary mb-0"><i class="fa-solid fa-plus me-1"></i>{{ __('Add School') }}</a>
  </div>
  <div class="card-body">
    <table id="school-table" class="table table-striped align-middle">
      <thead>
        <tr>
          <th>{{ __('Name') }}</th>
          <th class="text-end">{{ __('Transport fee (RM)') }}</th>
          <th class="text-end">{{ __('Students') }}</th>
          <th class="no-sort"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($school as $c)
          <tr>
            <td>{{ $c->name }}</td>
            <td class="text-end">{!! is_null($c->transport_fee) ? '<span class="text-warning">'.e(__('Not set')).'</span>' : number_format($c->transport_fee, 2) !!}</td>
            <td class="text-end">{{ $c->students()->where('is_active', 1)->count() }}</td>
            <td class="text-end text-nowrap">
              <a href="{{ route('school.edit', $c) }}" class="text-body me-3" title="{{ __('Edit') }}"><i class="fas fa-pencil-alt"></i></a>
              @if (Auth::user()->role === 'superadmin')
                <a href="{{ route('school.destroy', $c) }}" class="text-danger" title="{{ __('Delete') }}" data-confirm="{{ __('Are you sure you want to delete?') }}"><i class="fas fa-trash-alt"></i></a>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@include('layouts.partials.datatables', ['table' => '#school-table', 'options' => ['columnDefs' => [['orderable' => false, 'targets' => 'no-sort']]]])
@endsection
