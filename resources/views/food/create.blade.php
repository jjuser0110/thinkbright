@extends('layouts.app')

@section('body')
<!-- <style>
  .dateformat {
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
}
  </style> -->
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<h4 class="font-weight-bolder mb-0">Add/Edit Food</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
              
            <form enctype="multipart/form-data" @if (isset($food)) method="post" action="{{ route('food.update',$food) }}" @else method="post" action="{{ route('food.store') }}" @endif>
              @csrf
              <div class="form-group row">
                <div class="col-sm-6 margin_top">
                <label for="name">Date</label>
                <input type="date" class="form-control dateformat" id="date_of_food" name="date_of_food" data-date="" data-date-format="DD MMMM YYYY" @if(isset($food)) value="{{$food->date_of_food}}" @else value="<?php echo date('Y-m-d'); ?>" @endif required autocomplete="off">
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">Food Type</label>
                <select name="food_type_id" class="form-control" required>
                  @foreach($food_type as $f)
                    <option value="{{$f->id}}">{{$f->name}}</option>
                  @endforeach
                </select>
                </div>
                <div class="col-sm-6 margin_top">
                <label for="name">QTY</label>
                <input type="number" step="1" min="0" class="form-control" id="quantity" name="quantity"  @if(isset($food)) value="{{$food->quantity}}"  @endif required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                  <a class="btn btn-light float-right margin-right" onclick="window.location.href='{{ route('food.index') }}'">Back</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>

<!-- <script>
  $("input").on("change", function() {
    this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( this.getAttribute("data-date-format") )
    )
}).trigger("change")
</script> -->
@endsection