@extends('layouts.app')

@section('title', $class->exists ? __('Edit 1-to-1 class') : __('Add 1-to-1 class'))

@section('body')
<form method="POST" action="{{ $class->exists ? route('one_to_one.update', $class) : route('one_to_one.store') }}">
  @csrf
  @if ($class->exists) @method('PUT') @endif
  <div class="row g-4">
    <div class="col-lg-7">
      <div class="card h-100">
        <div class="card-header pb-0"><h6 class="mb-0">{{ __('Class') }}</h6></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="student_id">{{ __('Student') }} *</label>
              <select class="form-select tb-select2" id="student_id" name="student_id" required>
                <option value="">{{ __('-- Select Student --') }}</option>
                @foreach ($students as $s)
                  <option value="{{ $s->id }}" @selected(old('student_id', $class->student_id) == $s->id)>{{ $s->displayName() }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="teacher_id">{{ __('Teacher') }} *</label>
              <select class="form-select" id="teacher_id" name="teacher_id" required>
                <option value="">{{ __('-- Select Teacher --') }}</option>
                @foreach ($teachers as $t)
                  <option value="{{ $t->id }}" @selected(old('teacher_id', $class->teacher_id) == $t->id)>{{ $t->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label" for="subject">{{ __('Subject') }} *</label>
              <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject', $class->subject) }}" placeholder="{{ __('e.g. Mathematics') }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label" for="day">{{ __('Day') }} *</label>
              <select class="form-select" id="day" name="day" required>
                @foreach (\App\Models\OneToOneClass::DAYS as $num => $name)
                  <option value="{{ $num }}" @selected(old('day', $class->day) == $num)>{{ __($name) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label" for="start_time">{{ __('Start') }} *</label>
              <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', substr((string) $class->start_time, 0, 5)) }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label" for="end_time">{{ __('End') }} *</label>
              <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', substr((string) $class->end_time, 0, 5)) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="start_date">{{ __('Start date') }} *</label>
              <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $class->start_date?->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="end_date">{{ __('End date') }}</label>
              <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $class->end_date?->format('Y-m-d')) }}">
              <div class="form-text">{{ __('Leave empty if ongoing.') }}</div>
            </div>
            <div class="col-md-12">
              <label class="form-label" for="remarks">{{ __('Remarks') }}</label>
              <input type="text" class="form-control" id="remarks" name="remarks" value="{{ old('remarks', $class->remarks) }}">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card h-100">
        <div class="card-header pb-0"><h6 class="mb-0">{{ __('Fee & commission') }}</h6></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label" for="monthly_fee">{{ __('Fee (RM / month)') }} *</label>
            <input type="number" step="0.01" min="0" class="form-control" id="monthly_fee" name="monthly_fee" value="{{ old('monthly_fee', $class->monthly_fee) }}" required>
            <div class="form-text">{{ __("Added to the student's monthly bill (1-to-1 column).") }}</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="commission_percent">{{ __('Teacher commission (%)') }} *</label>
            <input type="number" step="0.01" min="0" max="100" class="form-control" id="commission_percent" name="commission_percent" value="{{ old('commission_percent', $class->commission_percent ?? 0) }}" required>
          </div>
          <div class="d-flex justify-content-between border-top pt-3 text-sm">
            <span>{{ __('Commission per month') }}</span>
            <strong>RM <span id="commission-preview">0.00</span></strong>
          </div>
          <div class="form-check form-switch ps-0 d-flex align-items-center mt-4">
            <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" id="is_active" name="is_active" value="1" @checked(old('is_active', $class->is_active ?? true))>
            <label class="form-check-label mb-0" for="is_active">{{ __('Active') }}</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn bg-gradient-primary mb-0">{{ __('Save') }}</button>
    <a href="{{ route('one_to_one.index') }}" class="btn btn-outline-secondary mb-0">{{ __('Back') }}</a>
  </div>
</form>

@push('scripts')
<script>
  (function () {
    var fee = document.getElementById('monthly_fee'), pct = document.getElementById('commission_percent'), out = document.getElementById('commission-preview');
    function update() { out.textContent = ((parseFloat(fee.value) || 0) * (parseFloat(pct.value) || 0) / 100).toFixed(2); }
    fee.addEventListener('input', update); pct.addEventListener('input', update); update();
    if (window.jQuery && jQuery.fn.select2) { jQuery('.tb-select2').select2({ width: '100%' }); }
  })();
</script>
@endpush
@endsection
