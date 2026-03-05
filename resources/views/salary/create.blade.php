@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="font-weight-bolder mb-3">Add/Edit Bank</h4>
    <div class="row margin_top">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              
            <form enctype="multipart/form-data"
                @if (isset($salary))
                    method="post" action="{{ route('salary.update',$salary) }}"
                @else
                    method="post" action="{{ route('salary.store') }}"
                @endif>

                @csrf
                @if(isset($salary))
                @method('PUT')
                @endif

                <div class="row g-4">

                <!-- Teacher -->
                <div class="col-md-4">
                <label class="form-label">Teacher</label>
                <select name="user_id" class="form-control" required>
                @foreach($teacher as $user)
                <option value="{{$user->id}}" {{ isset($salary) && $salary->user_id == $user->id ? 'selected' : '' }}>
                {{$user->name}}
                </option>
                @endforeach
                </select>
                </div>

                <!-- Payment Month -->
                <div class="col-md-4">
                <label class="form-label">Payment Month</label>
                <input type="month"
                class="form-control"
                name="year_month"
                value="{{ $salary->year_month ?? '' }}"
                required>
                </div>

                <!-- Payment Date -->
                <div class="col-md-4">
                <label class="form-label">Payment Date</label>
                <input type="date"
                class="form-control"
                name="payment_date"
                value="{{ $salary->payment_date ?? date('Y-m-d') }}"
                required>
                </div>


                <!-- Earnings -->
                <div class="col-md-3">
                <h5><b>Earnings</b></h5>

                <label class="form-label mt-2">Basic</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="basic" name="basic"
                value="{{ $salary->basic ?? '' }}"
                onchange="calculateTotal()">

                <label class="form-label mt-2">Overtime</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="overtime" name="overtime"
                value="{{ $salary->overtime ?? '' }}"
                onchange="calculateTotal()">

                <label class="form-label mt-2">Commission</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="commission" name="commission"
                value="{{ $salary->commission ?? '' }}"
                onchange="calculateTotal()">

                <label class="form-label mt-2">Allowances</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="allowances" name="allowances"
                value="{{ $salary->allowances ?? '' }}"
                onchange="calculateTotal()">
                </div>


                <!-- Deductions -->
                <div class="col-md-3">
                <h5><b>Deductions</b></h5>

                <label class="form-label mt-2">EPF</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="epf" name="epf"
                value="{{ $salary->epf ?? '' }}"
                onchange="calculateDeduction()">

                <label class="form-label mt-2">Socso</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="socso" name="socso"
                value="{{ $salary->socso ?? '' }}"
                onchange="calculateDeduction()">

                <label class="form-label mt-2">SIP</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="employee_s_p" name="employee_s_p"
                value="{{ $salary->employee_s_p ?? '' }}"
                onchange="calculateDeduction()">

                <label class="form-label mt-2">Advance</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="advance" name="advance"
                value="{{ $salary->advance ?? '' }}"
                onchange="calculateDeduction()">

                <label class="form-label mt-2">Income Tax</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="income_tax" name="income_tax"
                value="{{ $salary->income_tax ?? '' }}"
                onchange="calculateDeduction()">
                </div>


                <!-- Additions -->
                <div class="col-md-3">
                <h5><b>Additions</b></h5>

                <label class="form-label mt-2">Reimbursement</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="reimbursement" name="reimbursement"
                value="{{ $salary->reimbursement ?? '' }}"
                onchange="calculateAddition()">

                <label class="form-label mt-2">Additional / Bonus</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="extra" name="extra"
                value="{{ $salary->extra ?? '' }}"
                onchange="calculateAddition()">
                </div>


                <!-- Employer -->
                <div class="col-md-3">
                <h5><b>Employer</b></h5>

                <label class="form-label mt-2">EPF</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="employer_epf" name="employer_epf"
                value="{{ $salary->employer_epf ?? '' }}"
                onchange="calculateContribution()">

                <label class="form-label mt-2">Socso</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="employer_socso" name="employer_socso"
                value="{{ $salary->employer_socso ?? '' }}"
                onchange="calculateContribution()">

                <label class="form-label mt-2">SIP</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="employer_s_p" name="employer_s_p"
                value="{{ $salary->employer_s_p ?? '' }}"
                onchange="calculateContribution()">
                </div>


                <!-- Summary -->
                <div class="col-md-3">
                <label class="form-label">Gross Pay (A)</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="gross_pay" name="gross_pay"
                value="{{ $salary->gross_pay ?? '' }}">
                </div>

                <div class="col-md-3">
                <label class="form-label">Total Deduction (B)</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="total_deduction" name="total_deduction"
                value="{{ $salary->total_deduction ?? '' }}">
                </div>

                <div class="col-md-3">
                <label class="form-label">Total Additions (C)</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="total_additions" name="total_additions"
                value="{{ $salary->total_additions ?? '' }}">
                </div>

                <div class="col-md-3">
                <label class="form-label">Employer Total Contribution</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="total_contribution" name="total_contribution"
                value="{{ $salary->total_contribution ?? '' }}">
                </div>

                <div class="col-md-3">
                <label class="form-label">Net Pay (A-B+C)</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="net_pay" name="net_pay"
                value="{{ $salary->net_pay ?? '' }}">
                </div>

                <div class="col-md-3">
                <label class="form-label">Employer Total Pay</label>
                <input type="number" step="0.01" min="0" class="form-control"
                id="employer_total_paid" name="employer_total_paid"
                value="{{ $salary->employer_total_paid ?? '' }}">
                </div>


                <!-- Remarks -->
                <div class="col-md-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control"
                name="remarks"
                rows="4">{{ $salary->remarks ?? '' }}</textarea>
                </div>

                </div>


                <!-- Buttons -->
                <div class="mt-4 text-end">
                <a href="{{ route('salary.index') }}" class="btn btn-light me-2">
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


<script>
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