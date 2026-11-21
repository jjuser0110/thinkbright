@extends('layouts.app')

@section('title', __('Teachers'))

@section('body')
<div class="card">
  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
    <h6 class="mb-0">{{ __('Teachers') }}</h6>
    <a href="{{ route('user.create') }}" class="btn btn-sm bg-gradient-primary mb-0"><i class="fa-solid fa-plus me-1"></i>{{ __('Add Teacher') }}</a>
  </div>
  <div class="card-body">
    <table id="teacher-table" class="table table-striped align-middle">
      <thead>
        <tr>
          <th>{{ __('Name') }}</th>
          <th>{{ __('Username') }}</th>
          <th>{{ __('Contact') }}</th>
          <th class="text-end">{{ __('Basic salary') }}</th>
          <th class="text-center">{{ __('Annual leave') }}</th>
          <th class="text-center">{{ __('Sick leave') }}</th>
          <th>{{ __('Status') }}</th>
          <th class="no-sort"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($user as $c)
          <tr>
            <td>{{ $c->name }} @if ($c->role === 'admin')<span class="badge bg-gradient-secondary ms-1">{{ __('Admin') }}</span>@endif</td>
            <td>{{ $c->username }}</td>
            <td>{{ $c->contact }}</td>
            <td class="text-end">{{ is_null($c->basic_salary) ? '' : number_format($c->basic_salary, 2) }}</td>
            <td class="text-center">
              @if (method_exists($c, 'leaveBalance'))
                {{ $c->leaveBalance('annual') }} / {{ (int) $c->no_of_annual_leave }}
              @else
                {{ $c->no_of_annual_leave }}
              @endif
            </td>
            <td class="text-center">
              @if (method_exists($c, 'leaveBalance'))
                {{ $c->leaveBalance('sick') }} / {{ (int) $c->no_of_sick_leave }}
              @else
                {{ $c->no_of_sick_leave }}
              @endif
            </td>
            <td>{!! $c->is_active ? '<span class="tb-yes">'.e(__('Active')).'</span>' : '<span class="text-danger">'.e(__('Inactive')).'</span>' !!}</td>
            <td class="text-end text-nowrap">
              <a href="{{ route('user.edit', $c) }}" class="text-body me-3" title="{{ __('Edit') }}"><i class="fas fa-pencil-alt"></i></a>
              @unless ($c->is(auth()->user()))
                <a href="{{ route('user.destroy', $c) }}" class="text-danger" title="{{ __('Delete') }}" data-confirm="{{ __('Are you sure you want to delete?') }}"><i class="fas fa-trash-alt"></i></a>
              @endunless
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@include('layouts.partials.datatables', ['table' => '#teacher-table', 'options' => ['columnDefs' => [['orderable' => false, 'targets' => 'no-sort']]]])
@endsection
