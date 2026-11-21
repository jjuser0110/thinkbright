@extends('layouts.app')

@section('title', __('Fee Setting'))

@section('body')
<div class="row g-4">
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h6 class="mb-0">{{ __('Default monthly fees') }}</h6>
        <p class="text-sm text-secondary mb-0">{{ __('Used for every enrolled student unless a custom amount is set on the student.') }}</p>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('fee_setting.update') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="daycare_fee">{{ __('Daycare fee (RM / month)') }}</label>
            <input type="number" step="0.01" min="0" class="form-control" id="daycare_fee" name="daycare_fee" value="{{ old('daycare_fee', $daycareFee) }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="bath_lunch_fee">{{ __('Bath & lunch fee (RM / month)') }}</label>
            <input type="number" step="0.01" min="0" class="form-control" id="bath_lunch_fee" name="bath_lunch_fee" value="{{ old('bath_lunch_fee', $bathLunchFee) }}" required>
          </div>
          <button type="submit" class="btn bg-gradient-primary mb-0">{{ __('Save') }}</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header pb-0 d-flex justify-content-between align-items-start">
        <div>
          <h6 class="mb-0">{{ __('Transport fee by school') }}</h6>
          <p class="text-sm text-secondary mb-0">{{ __('Set on each school in School Setting.') }}</p>
        </div>
        <a href="{{ route('school.index') }}" class="btn btn-sm btn-outline-secondary mb-0">{{ __('School Setting') }}</a>
      </div>
      <div class="card-body pt-2" style="max-height:420px;overflow-y:auto">
        <table class="table table-sm align-middle mb-0">
          <thead><tr><th>{{ __('School') }}</th><th class="text-end">{{ __('Transport (RM)') }}</th></tr></thead>
          <tbody>
            @foreach ($schools as $s)
              <tr>
                <td class="text-sm">{{ $s->name }}</td>
                <td class="text-sm text-end">
                  @if (! is_null($s->transport_fee))
                    {{ number_format($s->transport_fee, 2) }}
                  @else
                    <a href="{{ route('school.edit', $s) }}" class="text-warning">{{ __('Not set') }}</a>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
