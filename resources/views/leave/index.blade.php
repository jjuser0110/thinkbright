@extends('layouts.app')

@section('title', __('Leave Applications'))

@section('body')
<div class="card">
  <div class="card-header pb-0 d-flex flex-wrap gap-2 justify-content-between align-items-center">
    <h6 class="mb-0">{{ __('Leave Applications') }}</h6>
    <div class="btn-group" role="group" aria-label="{{ __('Status') }}">
      @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'cancelled' => 'Cancelled', 'all' => 'All'] as $key => $label)
        <a href="{{ route('leave.index', ['status' => $key]) }}" class="btn btn-sm mb-0 {{ $status === $key ? 'bg-gradient-primary text-white' : 'btn-outline-secondary' }}">
          {{ __($label) }}@if ($key !== 'all' && ($counts[$key] ?? 0)) ({{ $counts[$key] }})@endif
        </a>
      @endforeach
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>{{ __('Teacher') }}</th>
            <th>{{ __('Type') }}</th>
            <th>{{ __('Dates') }}</th>
            <th class="text-center">{{ __('Days') }}</th>
            <th class="text-center">{{ __('Balance') }}</th>
            <th>{{ __('Reason') }}</th>
            <th>{{ __('Status') }}</th>
            <th style="min-width:230px"></th>
          </tr>
        </thead>
        <tbody>
          @forelse ($applications as $a)
            <tr>
              <td class="text-sm">{{ $a->user->name }}</td>
              <td class="text-sm">{{ $a->typeLabel() }}</td>
              <td class="text-sm text-nowrap">{{ $a->dateRange() }}</td>
              <td class="text-sm text-center">{{ rtrim(rtrim((string) $a->days, '0'), '.') }}</td>
              <td class="text-sm text-center" title="{{ __('Days left this year before this application') }}">
                {{ rtrim(rtrim(number_format($a->user->leaveBalance($a->type, $a->start_date->year), 1), '0'), '.') }} / {{ (int) $a->user->leaveEntitlement($a->type) }}
              </td>
              <td class="text-sm" style="max-width:220px;white-space:normal">{{ $a->reason }}</td>
              <td class="text-sm">
                <span class="tb-pill tb-pill-{{ $a->status }}">{{ __(ucfirst($a->status)) }}</span>
                @if ($a->approver)<br><span class="text-xs text-secondary">{{ $a->approver->name }}, {{ $a->approved_at?->format('d M') }}</span>@endif
                @if ($a->admin_remarks)<br><span class="text-xs text-secondary">{{ $a->admin_remarks }}</span>@endif
              </td>
              <td>
                @if ($a->status === 'pending')
                  <form method="POST" class="d-flex gap-1 align-items-center">
                    @csrf
                    <input type="text" name="admin_remarks" class="form-control form-control-sm" placeholder="{{ __('Remark (optional)') }}" aria-label="{{ __('Remark') }}">
                    <button type="submit" formaction="{{ route('leave.approve', $a) }}" class="btn btn-sm bg-gradient-success mb-0" title="{{ __('Approve') }}"><i class="fa-solid fa-check"></i></button>
                    <button type="submit" formaction="{{ route('leave.reject', $a) }}" class="btn btn-sm bg-gradient-danger mb-0" title="{{ __('Reject') }}"><i class="fa-solid fa-xmark"></i></button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="text-sm text-secondary">{{ __('No applications.') }}</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
