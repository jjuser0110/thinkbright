@extends('layouts.app')

@section('title', $slot->exists ? __('Edit timetable slot') : __('Add timetable slot'))

@section('body')
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ $slot->exists ? route('timetable.update', $slot) : route('timetable.store') }}">
          @csrf
          @if ($slot->exists) @method('PUT') @endif
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label" for="day">{{ __('Day') }} *</label>
              <select class="form-select" id="day" name="day" required>
                @foreach (\App\Models\DaycareTimetable::DAYS as $num => $name)
                  <option value="{{ $num }}" @selected(old('day', $slot->day) == $num)>{{ __($name) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label" for="start_time">{{ __('Start') }} *</label>
              <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', substr((string) $slot->start_time, 0, 5)) }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label" for="end_time">{{ __('End') }} *</label>
              <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', substr((string) $slot->end_time, 0, 5)) }}" required>
            </div>
            <div class="col-md-12">
              <label class="form-label" for="activity">{{ __('Activity') }} *</label>
              <input type="text" class="form-control" id="activity" name="activity" value="{{ old('activity', $slot->activity) }}" placeholder="{{ __('e.g. Lunch, Homework, Nap, Bath') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="teacher_id">{{ __('Teacher in charge') }}</label>
              <select class="form-select" id="teacher_id" name="teacher_id">
                <option value="">{{ __('-- None --') }}</option>
                @foreach ($teachers as $t)
                  <option value="{{ $t->id }}" @selected(old('teacher_id', $slot->teacher_id) == $t->id)>{{ $t->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="remarks">{{ __('Remarks') }}</label>
              <input type="text" class="form-control" id="remarks" name="remarks" value="{{ old('remarks', $slot->remarks) }}">
            </div>
          </div>
          <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn bg-gradient-primary mb-0">{{ __('Save') }}</button>
            <a href="{{ route('timetable.index') }}" class="btn btn-outline-secondary mb-0">{{ __('Back') }}</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
