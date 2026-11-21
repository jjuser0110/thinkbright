@extends('layouts.app')

@section('title', isset($student) ? __('Edit Student') : __('Add Student'))

@section('body')
@php $s = $student ?? null; @endphp
<form method="POST" action="{{ $s ? route('student.update', $s) : route('student.store') }}">
  @csrf
  <div class="row g-4">
    <div class="col-xl-7">
      <div class="card mb-4">
        <div class="card-header pb-0"><h6 class="mb-0">{{ __('Student details') }}</h6></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="name">{{ __('Student Name') }} *</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $s->name ?? '') }}" required autocomplete="off">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="c_name">{{ __('Chinese Name') }}</label>
              <input type="text" class="form-control" id="c_name" name="c_name" value="{{ old('c_name', $s->c_name ?? '') }}" autocomplete="off">
            </div>
            <div class="col-md-4">
              <label class="form-label" for="dob">{{ __('Date of birth') }}</label>
              <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', $s->dob ?? '') }}">
            </div>
            <div class="col-md-4">
              <label class="form-label" for="ic">{{ __('IC') }}</label>
              <input type="text" class="form-control" id="ic" name="ic" value="{{ old('ic', $s->ic ?? '') }}" autocomplete="off">
            </div>
            <div class="col-md-4">
              <label class="form-label" for="deposit">{{ __('Deposit (RM)') }}</label>
              <input type="number" step="0.01" min="0" class="form-control" id="deposit" name="deposit" value="{{ old('deposit', $s->deposit ?? '') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="school_id">{{ __('School') }}</label>
              <select id="school_id" name="school_id" class="form-select">
                <option value="">{{ __('-- Select School --') }}</option>
                @foreach ($school as $sc)
                  <option value="{{ $sc->id }}" data-transport="{{ $sc->transport_fee }}" @selected(old('school_id', $s->school_id ?? null) == $sc->id)>{{ $sc->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label" for="level">{{ __('Level') }}</label>
              <input type="number" min="0" class="form-control" id="level" name="level" value="{{ old('level', $s->level ?? '') }}" placeholder="1-6">
            </div>
            <div class="col-md-3">
              <label class="form-label" for="class">{{ __('Class') }}</label>
              <input type="text" class="form-control" id="class" name="class" value="{{ old('class', $s->class ?? '') }}" autocomplete="off">
            </div>
            <div class="col-md-4">
              <label class="form-label" for="is_active">{{ __('Status') }}</label>
              <select class="form-select" id="is_active" name="is_active">
                <option value="1" @selected(old('is_active', $s->is_active ?? 1) == 1)>{{ __('Active') }}</option>
                <option value="0" @selected(old('is_active', $s->is_active ?? 1) == 0)>{{ __('Inactive') }}</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header pb-0"><h6 class="mb-0">{{ __('Parents') }}</h6></div>
        <div class="card-body">
          @foreach (['' => __('Parent 1'), '_2' => __('Parent 2')] as $sfx => $title)
            <p class="text-sm font-weight-bold mb-2 {{ $sfx ? 'mt-3' : '' }}">{{ $title }}</p>
            <div class="row g-3">
              <div class="col-md-5">
                <label class="form-label" for="parent_name{{ $sfx }}">{{ __('Name') }}</label>
                <input type="text" class="form-control" id="parent_name{{ $sfx }}" name="parent_name{{ $sfx }}" value="{{ old('parent_name'.$sfx, $s?->{'parent_name'.$sfx}) }}" autocomplete="off">
              </div>
              <div class="col-md-3">
                <label class="form-label" for="parent_relation{{ $sfx }}">{{ __('Relationship') }}</label>
                <input type="text" class="form-control" id="parent_relation{{ $sfx }}" name="parent_relation{{ $sfx }}" value="{{ old('parent_relation'.$sfx, $s?->{'parent_relation'.$sfx}) }}" autocomplete="off">
              </div>
              <div class="col-md-4">
                <label class="form-label" for="parent_contact{{ $sfx }}">{{ __('Contact No') }}</label>
                <input type="text" class="form-control" id="parent_contact{{ $sfx }}" name="parent_contact{{ $sfx }}" value="{{ old('parent_contact'.$sfx, $s?->{'parent_contact'.$sfx}) }}" autocomplete="off">
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="col-xl-5">
      <div class="card">
        <div class="card-header pb-0">
          <h6 class="mb-0">{{ __('Daycare services') }}</h6>
          <p class="text-sm text-secondary mb-0">{{ __('Ticked services are charged every month. Leave the amount empty to use the default.') }}</p>
        </div>
        <div class="card-body">
          @php
            $services = [
              'daycare' => [__('Daycare class (Mon–Fri)'), __('Default RM:fee', ['fee' => number_format($defaultDaycareFee, 2)])],
              'bath_lunch' => [__('Bath & lunch'), __('Default RM:fee', ['fee' => number_format($defaultBathLunchFee, 2)])],
              'transport' => [__('Transport'), __("Default: school's transport fee")],
            ];
          @endphp
          @foreach ($services as $key => [$label, $hint])
            <div class="border rounded-3 p-3 mb-3">
              <div class="form-check form-switch ps-0 d-flex align-items-center">
                <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" id="{{ $key }}" name="{{ $key }}" value="1" @checked(old($key, $s->{$key} ?? false))>
                <label class="form-check-label mb-0 font-weight-bold" for="{{ $key }}">{{ $label }}</label>
              </div>
              <div class="mt-2">
                <label class="form-label text-xs mb-1" for="{{ $key }}_fee">{{ __('Custom amount (RM / month)') }}</label>
                <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="{{ $key }}_fee" name="{{ $key }}_fee" value="{{ old($key.'_fee', $s->{$key.'_fee'} ?? '') }}" placeholder="{{ $hint }}" @if ($key === 'transport') data-transport-input @endif>
              </div>
            </div>
          @endforeach
          @if ($s)
            @php $c = $s->monthlyCharges(); @endphp
            <div class="d-flex justify-content-between text-sm border-top pt-3">
              <span>{{ __('Current monthly total') }}</span>
              <strong>RM {{ number_format($c['total'], 2) }}</strong>
            </div>
            @if ($s->transportFeeMissing())
              <p class="text-xs text-warning mb-0 mt-2"><i class="fa-solid fa-triangle-exclamation me-1"></i>{{ __('Transport is ticked but this school has no transport fee set.') }}</p>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn bg-gradient-primary mb-0">{{ __('Save') }}</button>
    <a href="{{ route('student.index') }}" class="btn btn-outline-secondary mb-0">{{ __('Back') }}</a>
  </div>
</form>

@push('scripts')
<script>
  // Show the selected school's transport fee as the placeholder for the transport amount.
  (function () {
    var school = document.getElementById('school_id');
    var input = document.querySelector('[data-transport-input]');
    function update() {
      var fee = school.selectedOptions[0] && school.selectedOptions[0].dataset.transport;
      input.placeholder = fee ? @json(__('Default RM')) + parseFloat(fee).toFixed(2) + ' (' + school.selectedOptions[0].text + ')' : @json(__('School has no transport fee set'));
    }
    school.addEventListener('change', update);
    update();
  })();
</script>
@endpush
@endsection
