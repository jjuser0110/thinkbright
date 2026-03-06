@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Student</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
                  
                <form enctype="multipart/form-data"
                  @if (isset($student))
                      method="post" action="{{ route('student.update',$student) }}"
                  @else
                      method="post" action="{{ route('student.store') }}"
                  @endif>

                  @csrf

                  <div class="row g-4">

                      <!-- Student Basic Info -->
                      <div class="col-md-6">
                          <label class="form-label">Student Name</label>
                          <input type="text" class="form-control"
                              name="name"
                              placeholder="Student Name..."
                              value="{{ $student->name ?? '' }}">
                      </div>

                      <div class="col-md-6">
                          <label class="form-label">Student Chinese Name</label>
                          <input type="text" class="form-control"
                              name="c_name"
                              placeholder="Student Chinese Name..."
                              value="{{ $student->c_name ?? '' }}">
                      </div>

                      <div class="col-md-6">
                          <label class="form-label">Student DOB</label>
                          <input type="date" class="form-control"
                              name="dob"
                              value="{{ $student->dob ?? date('Y-m-d') }}">
                      </div>

                      <div class="col-md-6">
                          <label class="form-label">Student IC</label>
                          <input type="text" class="form-control"
                              name="ic"
                              placeholder="Student IC..."
                              value="{{ $student->ic ?? '' }}">
                      </div>

                      <div class="col-md-6">
                          <label class="form-label">Deposit</label>
                          <input type="text" class="form-control"
                              name="deposit"
                              placeholder="Deposit"
                              value="{{ $student->deposit ?? '' }}">
                      </div>

                      <!-- School & Level -->
                      <div class="col-md-6">
                          <label class="form-label">School</label>
                          <select name="school_id" class="form-control">
                              @foreach($school as $s)
                                  <option value="{{$s->id}}"
                                  {{ (isset($student) && $student->school_id == $s->id) ? 'selected' : '' }}>
                                      {{$s->name}}
                                  </option>
                              @endforeach
                          </select>
                      </div>

                      <div class="col-md-4">
                          <label class="form-label">Category</label>
                          <select name="category_id" class="form-control">
                              @foreach($category as $s)
                                  <option value="{{$s->id}}"
                                  {{ (isset($student) && $student->category_id == $s->id) ? 'selected' : '' }}>
                                      {{$s->name}}
                                  </option>
                              @endforeach
                          </select>
                      </div>

                      <div class="col-md-4">
                          <label class="form-label">Student Level</label>
                          <input type="number" class="form-control"
                              name="level"
                              placeholder="1-6"
                              value="{{ $student->level ?? '' }}">
                      </div>

                      <div class="col-md-4">
                          <label class="form-label">Student Class</label>
                          <input type="text" class="form-control"
                              name="class"
                              placeholder="Student Class..."
                              value="{{ $student->class ?? '' }}">
                      </div>

                      <!-- Parent 1 -->
                      <div class="col-md-4">
                          <label class="form-label">Parent Name</label>
                          <input type="text" class="form-control"
                              name="parent_name"
                              value="{{ $student->parent_name ?? '' }}">
                      </div>

                      <div class="col-md-4">
                          <label class="form-label">Relationship</label>
                          <input type="text" class="form-control"
                              name="parent_relation"
                              value="{{ $student->parent_relation ?? '' }}">
                      </div>

                      <div class="col-md-4">
                          <label class="form-label">Contact No</label>
                          <input type="text" class="form-control"
                              name="parent_contact"
                              value="{{ $student->parent_contact ?? '' }}">
                      </div>

                      <!-- Parent 2 -->
                      <div class="col-md-4">
                          <label class="form-label">Parent Name 2</label>
                          <input type="text" class="form-control"
                              name="parent_name_2"
                              value="{{ $student->parent_name_2 ?? '' }}">
                      </div>

                      <div class="col-md-4">
                          <label class="form-label">Relationship 2</label>
                          <input type="text" class="form-control"
                              name="parent_relation_2"
                              value="{{ $student->parent_relation_2 ?? '' }}">
                      </div>

                      <div class="col-md-4">
                          <label class="form-label">Contact No 2</label>
                          <input type="text" class="form-control"
                              name="parent_contact_2"
                              value="{{ $student->parent_contact_2 ?? '' }}">
                      </div>

                      <!-- Active -->
                      <div class="col-md-4">
                          <label class="form-label">Is Active</label>
                          <select class="form-control" name="is_active">
                              <option value="1" {{ (isset($student) && $student->is_active == 1) ? 'selected' : '' }}>Yes</option>
                              <option value="0" {{ (isset($student) && $student->is_active == 0) ? 'selected' : '' }}>No</option>
                          </select>
                      </div>

                  </div>

                  <!-- Buttons -->
                  <div class="mt-5 text-end">
                      <a class="btn btn-light me-2"
                          href="{{ route('student.index') }}">
                          Back
                      </a>

                      <button type="submit" class="btn btn-success">
                          Submit
                      </button>
                  </div>

                  </form>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@section('scripts')
@endsection
