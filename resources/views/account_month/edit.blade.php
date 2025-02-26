@extends('layouts.app')

@section('body')
<style>
  .table thead th {
    padding: 0.05rem 0.05rem;
  }
  .table> :not(caption)>*>* {
    padding: 0.05rem 0.05rem;
  }
  </style>
<h4 class="font-weight-bolder mb-0">Add Account Month</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
            <table class=" table table-bordered table-striped">
              <thead >
                <tr >
                  <th style="text-align:center">No.</th>
                  <th >Student</th>
                  <th style="text-align:center">Tuition</th>
                  <th style="text-align:center">TT Add</th>
                  <th style="text-align:center">B&L</th>
                  <th style="text-align:center">Trans</th>
                  <th style="text-align:center">Trans Add</th>
                  <th style="text-align:center">Deposit</th>
                  <th style="text-align:center">Material</th>
                  <th style="text-align:center">Register</th>
                  <th style="text-align:center">Extra</th>
                  <th style="text-align:center">Extra 2</th>
                  <th style="text-align:center">Total</th>
                  <th style="text-align:center">Sent</th>
                  <th style="text-align:center">Paid</th>
                  <th >Remarks</th>
                  <th ></th>
                </tr>
              </thead>
              <tbody >
                <?php $index=1; ?>
                @foreach ($account_month->accounts as $a)
                  <tr id="tr~{{$a->id}}" <?php echo $a->paid!=null ?'style="background-color:lightgreen"':'' ?>>
                    <td style="text-align:center">{{$index ??""}}</td>
                    <td>{{$a->student->name ??""}}</td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="tuition~{{$a->id}}" id="tuition~{{$a->id}}" value="{{$a->tuition??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="tuition_extra~{{$a->id}}" id="tuition_extra~{{$a->id}}" value="{{$a->tuition_extra??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="food~{{$a->id}}" id="food~{{$a->id}}" value="{{$a->food??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="transport~{{$a->id}}" id="transport~{{$a->id}}" value="{{$a->transport??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="transport_extra~{{$a->id}}" id="transport_extra~{{$a->id}}" value="{{$a->transport_extra??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="deposit~{{$a->id}}" id="deposit~{{$a->id}}" value="{{$a->deposit??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="material~{{$a->id}}" id="material~{{$a->id}}" value="{{$a->material??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="registration~{{$a->id}}" id="registration~{{$a->id}}" value="{{$a->registration??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="extra~{{$a->id}}" id="extra~{{$a->id}}" value="{{$a->extra??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="extra_2~{{$a->id}}" id="extra_2~{{$a->id}}" value="{{$a->extra_2??''}}" onchange="saveData(this)"></td>
                    <td style="text-align:center"><input type="number"  step="0.01" style="width:70px;text-align:center" name="total~{{$a->id}}" id="total~{{$a->id}}" value="{{$a->total??''}}" readonly></td>
                    <td style="text-align:center"><input type="checkbox" value="yes" name="sent~{{$a->id}}" id="sent~{{$a->id}}" onclick="checkboxClick(this)" <?php echo $a->sent!=null ?'checked':'' ?>></td>
                    <td style="text-align:center"><input type="checkbox" value="yes" name="paid~{{$a->id}}" id="paid~{{$a->id}}" onclick="checkboxClick(this)" <?php echo $a->paid!=null ?'checked':'' ?>></td>
                    <td><input type="text" style="width:100px" name="remarks~{{$a->id}}" id="remarks~{{$a->id}}" value="{{$a->remarks??''}}"  onchange="saveData(this)"></td>
                    <td><button type="button" style="background: none; padding: 0px; border: none; color: inherit;" onclick="if(confirm('Are you sure you want to delete?')){ window.location.href='{{ route('account_month.destroy_specific_acc',$a) }}' }"><i class="fas fa-trash-alt"></i></button></td>
                  </tr>
                <?php $index++; ?>
                  @endforeach
              </tbody>  
              <tfoot >
                <tr >
                  <th >No.</th>
                  <th >Student</th>
                  <th style="text-align:center">Tuition</th>
                  <th style="text-align:center">TT Add</th>
                  <th style="text-align:center">B&L</th>
                  <th style="text-align:center">Trans</th>
                  <th style="text-align:center">Trans Add</th>
                  <th style="text-align:center">Deposit</th>
                  <th style="text-align:center">Material</th>
                  <th style="text-align:center">Register</th>
                  <th style="text-align:center">Extra</th>
                  <th style="text-align:center">Extra 2</th>
                  <th style="text-align:center">Total</th>
                  <th style="text-align:center">Sent</th>
                  <th style="text-align:center">Paid</th>
                  <th >Remarks</th>
                </tr>
              </tfoot>
            </table>
        </div>
      </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<script>
  function saveData(data){
    console.log(data.value);
    var value = data.value;
    if(value == ""){
      var value = 'z';
    }
    console.log(value);
    $.ajax({
      url: "{{ url('/account_month/update') }}/" + data.name + "/" + value,
      method: 'GET',
      success: function(data) {
        document.getElementById(data.column_name).value = data.total;
      },
    })
  }

  function checkboxClick(data){
    var checkBox = document.getElementById(data.name).checked;
    var check = "no";
    if(checkBox){
      var check = "yes";
    }
    $.ajax({
      url: "{{ url('/account_month/update') }}/" + data.name + "/" + check,
      method: 'GET',
      success: function(data) {
        if(data.account.paid != null){
          document.getElementById(data.column_name).style.backgroundColor = 'lightgreen';
        }
      },
    })
  }
  </script>

@endsection