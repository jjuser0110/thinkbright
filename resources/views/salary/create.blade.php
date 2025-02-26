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
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<h4 class="font-weight-bolder mb-0">Add/Edit Salary</h4>
<div class="row margin_top">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
              
            <form enctype="multipart/form-data" @if (isset($salary)) method="post" action="{{ route('salary.update',$salary) }}" @else method="post" action="{{ route('salary.store') }}" @endif>
              @csrf
              <div class="form-group row">
                <div class="col-sm-4 margin_top">
                <label for="name">Teacher</label>
                <select name="user_id" class="form-control" required>
                  @foreach($teacher as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                  @endforeach
                </select>
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Payment Month</label>
                <input type="month" class="form-control" id="year_month" name="year_month"  @if(isset($salary)) value="{{$salary->year_month}}" @endif required autocomplete="off">
                </div>
                <div class="col-sm-4 margin_top">
                <label for="name">Payment Date</label>
                <input type="date" class="dateformat form-control" id="payment_date" name="payment_date" data-date="" data-date-format="DD MMMM YYYY" @if(isset($salary)) value="{{$salary->payment_date}}" @else value="<?php echo date('Y-m-d'); ?>" @endif required autocomplete="off">
                </div>
                <div class="col-sm-3 margin_top">
                  <h5><b>Earnings</b></h5>
                    </hr>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Basic</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="basic" name="basic"  @if(isset($salary)) value="{{$salary->basic}}" @endif autocomplete="off" onchange="calculateTotal()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Overtime</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="overtime" name="overtime"  @if(isset($salary)) value="{{$salary->overtime}}" @endif autocomplete="off" onchange="calculateTotal()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Commission</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="commission" name="commission"  @if(isset($salary)) value="{{$salary->commission}}" @endif autocomplete="off" onchange="calculateTotal()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Allowances</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="allowances" name="allowances"  @if(isset($salary)) value="{{$salary->allowances}}" @endif autocomplete="off" onchange="calculateTotal()">
                    </div>
                </div>
                <div class="col-sm-3 margin_top">
                  <h5><b>Deductions</b></h5>
                    <div class="col-sm-12 margin_top">
                      <label for="name">EPF</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="epf" name="epf"  @if(isset($salary)) value="{{$salary->epf}}" @endif autocomplete="off" onchange="calculateDeduction()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Socso</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="socso" name="socso"  @if(isset($salary)) value="{{$salary->socso}}" @endif autocomplete="off" onchange="calculateDeduction()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">SIP</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="employee_s_p" name="employee_s_p"  @if(isset($salary)) value="{{$salary->employee_s_p}}" @endif autocomplete="off" onchange="calculateDeduction()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Advance</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="advance" name="advance"  @if(isset($salary)) value="{{$salary->advance}}" @endif autocomplete="off" onchange="calculateDeduction()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Income Tax</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="income_tax" name="income_tax"  @if(isset($salary)) value="{{$salary->income_tax}}" @endif autocomplete="off" onchange="calculateDeduction()">
                    </div>
                </div>
                <div class="col-sm-3 margin_top">
                  <h5><b>Additions</b></h5>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Reimbursement</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="reimbursement" name="reimbursement"  @if(isset($salary)) value="{{$salary->reimbursement}}" @endif autocomplete="off" onchange="calculateAddition()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Addtional/Bonus</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="extra" name="extra"  @if(isset($salary)) value="{{$salary->extra}}" @endif autocomplete="off" onchange="calculateAddition()">
                    </div>
                </div>
                <div class="col-sm-3 margin_top">
                  <h5><b>Employer</b></h5>
                    <div class="col-sm-12 margin_top">
                      <label for="name">EPF</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="employer_epf" name="employer_epf"  @if(isset($salary)) value="{{$salary->employer_epf}}" @endif autocomplete="off" onchange="calculateContribution()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">Socso</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="employer_socso" name="employer_socso"  @if(isset($salary)) value="{{$salary->employer_socso}}" @endif autocomplete="off" onchange="calculateContribution()">
                    </div>
                    <div class="col-sm-12 margin_top">
                      <label for="name">SIP</label>
                      <input type="number" min="0" step="0.01" class="form-control" id="employer_s_p" name="employer_s_p"  @if(isset($salary)) value="{{$salary->employer_s_p}}" @endif autocomplete="off" onchange="calculateContribution()">
                    </div>
                </div>
                <div class="col-sm-3 margin_top">
                  <label for="name">Gross Pay <span style="color:red">(A)</span></label>
                  <input type="number" min="0" step="0.01" class="form-control" id="gross_pay" name="gross_pay"  @if(isset($salary)) value="{{$salary->gross_pay}}" @endif autocomplete="off">
                </div>
                <div class="col-sm-3 margin_top">
                  <label for="name">Total Deduction <span style="color:red">(B)</span></label>
                  <input type="number" min="0" step="0.01" class="form-control" id="total_deduction" name="total_deduction"  @if(isset($salary)) value="{{$salary->total_deduction}}" @endif autocomplete="off">
                </div>
                <div class="col-sm-3 margin_top">
                  <label for="name">Total Additions <span style="color:red">(C)</span></label>
                  <input type="number" min="0" step="0.01" class="form-control" id="total_additions" name="total_additions"  @if(isset($salary)) value="{{$salary->total_additions}}" @endif autocomplete="off">
                </div>
                <div class="col-sm-3 margin_top">
                  <label for="name"> <b>Employer Total Contribution</b></label>
                  <input type="number" min="0" step="0.01" class="form-control" id="total_contribution" name="total_contribution"  @if(isset($salary)) value="{{$salary->total_contribution}}" @endif autocomplete="off">
                </div>
                <div class="col-sm-3 margin_top">
                  <label for="name">Net Pay(For Employee)  <span style="color:red">(A-B+C)</span></label>
                  <input type="number" min="0" step="0.01" class="form-control" id="net_pay" name="net_pay"  @if(isset($salary)) value="{{$salary->net_pay}}" @endif autocomplete="off">
                </div>
                <div class="col-sm-3 margin_top">
                  <label for="name">Employer Total Pay</label>
                  <input type="number" min="0" step="0.01" class="form-control" id="employer_total_paid" name="employer_total_paid"  @if(isset($salary)) value="{{$salary->employer_total_paid}}" @endif autocomplete="off">
                </div>
                <div class="col-sm-12 margin_top">
                  <label for="name">Remarks</label>
                  <textarea class="form-control" id="remarks" name="remarks" rows="5">{{$salary->remarks??''}}</textarea>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 margin_top">
                  <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                  <a class="btn btn-light float-right margin-right" onclick="window.location.href='{{ route('salary.index') }}'">Back</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>


<script>
//   $("input[type='date']").on("change", function() {
//     this.setAttribute(
//         "data-date",
//         moment(this.value, "YYYY-MM-DD")
//         .format( this.getAttribute("data-date-format") )
//     )
// }).trigger("change");

function calculateTotal(){
  var basic = document.getElementById('basic').value;
  var overtime = document.getElementById('overtime').value;
  var commission = document.getElementById('commission').value;
  var allowances = document.getElementById('allowances').value;
  var gross_pay = +basic + +overtime + +allowances + +commission;

  document.getElementById('gross_pay').value= gross_pay.toFixed(2);

  var total_deduction = document.getElementById('total_deduction').value;
  var total_additions = document.getElementById('total_additions').value;
  var total_contribution = document.getElementById('total_contribution').value;
  var net_pay = +gross_pay - +total_deduction + +total_additions;
  var employer_total_paid = +gross_pay + +total_contribution;

  document.getElementById('net_pay').value= net_pay.toFixed(2);
  document.getElementById('employer_total_paid').value= employer_total_paid.toFixed(2);
}


function calculateDeduction(){
  var epf = document.getElementById('epf').value;
  var socso = document.getElementById('socso').value;
  var advance = document.getElementById('advance').value;
  var income_tax = document.getElementById('income_tax').value;
  var employee_s_p = document.getElementById('employee_s_p').value;
  var total_deduction = +epf + +socso + +advance + +income_tax+ +employee_s_p;

  document.getElementById('total_deduction').value= total_deduction.toFixed(2);

  var gross_pay = document.getElementById('gross_pay').value;
  var total_additions = document.getElementById('total_additions').value;
  var total_contribution = document.getElementById('total_contribution').value;
  var net_pay = +gross_pay - +total_deduction + +total_additions;
  var employer_total_paid = +gross_pay + +total_contribution;

  document.getElementById('net_pay').value= net_pay.toFixed(2);
  document.getElementById('employer_total_paid').value= employer_total_paid.toFixed(2);
}


function calculateAddition(){
  var reimbursement = document.getElementById('reimbursement').value;
  var extra = document.getElementById('extra').value;
  var total_additions = +reimbursement + +extra;

  document.getElementById('total_additions').value= total_additions.toFixed(2);

  var gross_pay = document.getElementById('gross_pay').value;
  var total_deduction = document.getElementById('total_deduction').value;
  var total_contribution = document.getElementById('total_contribution').value;
  var net_pay = +gross_pay - +total_deduction + +total_additions;
  var employer_total_paid = +gross_pay + +total_contribution;

  document.getElementById('net_pay').value= net_pay.toFixed(2);
  document.getElementById('employer_total_paid').value= employer_total_paid.toFixed(2);
}

function calculateContribution(){
  var employer_epf = document.getElementById('employer_epf').value;
  var employer_socso = document.getElementById('employer_socso').value;
  var employer_s_p = document.getElementById('employer_s_p').value;
  var total_contribution = +employer_epf + +employer_socso + +employer_s_p;

  document.getElementById('total_contribution').value= total_contribution.toFixed(2);

  var gross_pay = document.getElementById('gross_pay').value;
  var employer_total_paid = +gross_pay + +total_contribution;
  document.getElementById('employer_total_paid').value= employer_total_paid.toFixed(2);
}

</script>
@endsection