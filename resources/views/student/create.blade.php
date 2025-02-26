@extends('layouts.app')

@section('body')
<style>
  /* .dateformat {
    position: relative;
}

.dateformat:before {
    content: attr(data-date);
}

.dateformat::-webkit-datetime-edit, .dateformat::-webkit-inner-spin-button, .dateformat::-webkit-clear-button {
    display: none;
}

.dateformat::-webkit-calendar-picker-indicator {
    position: absolute;
    top: 10px;
    right: 10px;
    opacity: 1;
} */
  </style>
<h4 class="font-weight-bolder mb-0">Add/Edit Student</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
              
            <form enctype="multipart/form-data" @if (isset($student)) method="post" action="{{ route('student.update',$student) }}" @else method="post" action="{{ route('student.store') }}" @endif>
              @csrf
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                <label for="name">Student Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Student Name...." @if(isset($student)) value="{{$student->name}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Student Chinese Name</label>
                <input type="text" class="form-control" id="c_name" name="c_name" placeholder="Student Chinese Name...." @if(isset($student)) value="{{$student->c_name}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Student DOB</label>
                <input type="date" class="form-control dateformat" id="dob" name="dob" data-date="" data-date-format="DD MMMM YYYY" @if(isset($student)) value="{{$student->dob??''}}" @else value="{{date('Y-m-d')}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Student IC</label>
                <input type="text" class="form-control" id="ic" name="ic" placeholder="Student IC...." @if(isset($student)) value="{{$student->ic}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Deposit</label>
                <input type="text" class="form-control" id="deposit" name="deposit" placeholder="Deposit" @if(isset($student)) value="{{$student->deposit}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="role">School</label>
                <select id="school_id" name="school_id" class="form-control">
                  @foreach($school as $s)
                      <option value="{{$s->id}}" <?php echo isset($student->school_id)&&$student->school_id == $s->id?'selected':''?>>{{$s->name}}</option>
                  @endforeach
                </select>
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Student Level (1,2,3,4,5,6)</label>
                <input type="number" class="form-control" id="level" name="level" placeholder="Student Level...." @if(isset($student)) value="{{$student->level}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Student Class</label>
                <input type="text" class="form-control" id="class" name="class" placeholder="Student Class...." @if(isset($student)) value="{{$student->class}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Parent Name</label>
                <input type="text" class="form-control" id="parent_name" name="parent_name" placeholder="Student Parent Name...." @if(isset($student)) value="{{$student->parent_name}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Relationship</label>
                <input type="text" class="form-control" id="parent_relation" name="parent_relation" placeholder="Relationship...." @if(isset($student)) value="{{$student->parent_relation}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Contact No</label>
                <input type="text" class="form-control" id="parent_contact" name="parent_contact" placeholder="Contact No...." @if(isset($student)) value="{{$student->parent_contact}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Parent Name 2</label>
                <input type="text" class="form-control" id="parent_name_2" name="parent_name_2" placeholder="Student Parent Name...." @if(isset($student)) value="{{$student->parent_name_2}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Relationship 2</label>
                <input type="text" class="form-control" id="parent_relation_2" name="parent_relation_2" placeholder="Relationship...." @if(isset($student)) value="{{$student->parent_relation_2}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Contact No 2</label>
                <input type="text" class="form-control" id="parent_contact_2" name="parent_contact_2" placeholder="Contact No...." @if(isset($student)) value="{{$student->parent_contact_2}}" @endif  autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Is Active</label>
                <select class="form-control" name="is_active">
                    <option value='1' <?php echo isset($student)&&$student->is_active == 1?'selected':'' ?>>Yes</option>
                    <option value='0' <?php echo isset($student)&&$student->is_active == 0?'selected':'' ?>>No</option>
                </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                  <a class="btn btn-light float-right margin-right" onclick="window.location.href='{{ route('student.index') }}'">Back</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- <script>
  $("input").on("change", function() {
    this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD").format( this.getAttribute("data-date-format") )
    )
}).trigger("change");
  </script> -->
@endsection