@extends('layouts.app')

@section('title', __('Students'))

@push('styles')
<style>
  #student-table td, #student-table th { padding: .5rem !important; font-size: .8rem !important; }
</style>
@endpush

@section('body')
<div class="card">
  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
    <h6 class="mb-0">{{ __('Students') }}</h6>
    <a href="{{ route('student.create') }}" class="btn btn-sm bg-gradient-primary mb-0"><i class="fa-solid fa-plus me-1"></i>{{ __('Add Student') }}</a>
  </div>
  <div class="card-body">
    <table id="student-table" class="table table-striped align-middle">
      <thead>
        <tr>
          <th>{{ __('Name') }}</th>
          <th>{{ __('Chinese Name') }}</th>
          <th>{{ __('School') }}</th>
          <th>{{ __('Level') }}</th>
          <th>{{ __('Class') }}</th>
          <th>{{ __('Parent') }}</th>
          <th>{{ __('Parent Contact') }}</th>
          <th class="text-center" title="{{ __('Daycare / Bath & lunch / Transport') }}">{{ __('Services') }}</th>
          <th>{{ __('Status') }}</th>
          <th class="no-sort"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($student as $s)
          <tr>
            <td>{{ $s->name }}</td>
            <td>{{ $s->c_name }}</td>
            <td>{{ $s->school->name ?? '' }}</td>
            <td>{{ $s->level }}</td>
            <td>{{ $s->class }}</td>
            <td>{{ $s->parent_name }}</td>
            <td>{{ $s->parent_contact }}</td>
            <td class="text-center text-nowrap">
              <i class="fa-solid fa-child-reaching {{ $s->daycare ? 'tb-yes' : 'tb-no' }}" title="{{ __('Daycare') }}"></i>
              <i class="fa-solid fa-utensils ms-2 {{ $s->bath_lunch ? 'tb-yes' : 'tb-no' }}" title="{{ __('Bath & lunch') }}"></i>
              <i class="fa-solid fa-van-shuttle ms-2 {{ $s->transport ? 'tb-yes' : 'tb-no' }}" title="{{ __('Transport') }}"></i>
            </td>
            <td data-order="{{ $s->is_active ? 0 : 1 }}">{!! $s->is_active ? '<span class="tb-yes">'.e(__('Active')).'</span>' : '<span class="text-danger">'.e(__('Inactive')).'</span>' !!}</td>
            <td class="text-end"><a href="{{ route('student.edit', $s) }}" class="text-body" title="{{ __('Edit') }}"><i class="fas fa-pencil-alt"></i></a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@include('layouts.partials.datatables', ['table' => '#student-table', 'options' => ['order' => [], 'columnDefs' => [['orderable' => false, 'targets' => 'no-sort']]]])
@endsection
